<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUserPendingApprovalNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Map route param → [db column, socialite driver]
     */
    protected array $providers = [
        'google'   => ['column' => 'google_id',   'driver' => 'google'],
        'linkedin' => ['column' => 'linkedin_id',  'driver' => 'linkedin-openid'],
        'github'   => ['column' => 'github_id',    'driver' => 'github'],
    ];

    /**
     * Redirect the user to the provider's OAuth page.
     */
    public function redirect(string $provider)
    {
        $this->abortIfUnsupported($provider);
        $driver = $this->providers[$provider]['driver'];
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Handle the callback from the provider after authentication.
     */
    public function callback(string $provider)
    {
        $this->abortIfUnsupported($provider);

        $driver   = $this->providers[$provider]['driver'];
        $idColumn = $this->providers[$provider]['column'];

        try {
            $socialUser = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            \Log::error(ucfirst($provider) . ' OAuth error: ' . $e->getMessage());

            return redirect()->route('login')
                ->withErrors(['email' => ucfirst($provider) . ' sign-in failed. Please try again.']);
        }

        $socialId = $socialUser->getId();
        $email    = $socialUser->getEmail();
        $name     = $socialUser->getName() ?? $socialUser->getNickname() ?? 'User';

        // 1. Find existing user by this provider's ID
        $user = User::where($idColumn, $socialId)->first();

        if ($user) {
            // Ensure email is marked verified (social provider confirmed it)
            if (!$user->email_verified_at) {
                $user->update(['email_verified_at' => now()]);
            }

            return $this->loginOrRejectPending($user);
        }

        // 2. Find existing user by email and link the provider
        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    $idColumn           => $socialId,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);

                return $this->loginOrRejectPending($user);
            }
        }

        // 3. No email returned by provider — cannot create account
        if (!$email) {
            return redirect()->route('login')
                ->withErrors(['email' =>
                    ucfirst($provider) . ' did not return an email address. Please use a different sign-in method.'
                ]);
        }

        // 4. Create a brand new user — always status=pending
        $baseUsername = Str::slug(Str::lower($name), '_');
        $username     = $baseUsername;
        $counter      = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter++;
        }

        $user = User::create([
            'name'              => $name,
            'username'          => $username,
            'email'             => $email,
            $idColumn           => $socialId,
            'email_verified_at' => now(),   // Social = provider already verified the email
            'password'          => Hash::make(Str::random(32)),
            'status'            => 'pending', // Always pending — admin must approve
        ]);

        // Notify admins a new user is awaiting approval
        $this->notifyAdmins($user);

        // Do NOT log them in — redirect straight to pending notice
        return redirect()->route('login')
            ->with('status', 'Your account has been created and is awaiting admin approval. You will be notified by email once approved.');
    }

    /**
     * Log the user in only if approved; otherwise log out and redirect with message.
     * Used for returning users (found by provider ID or email).
     */
    protected function loginOrRejectPending(User $user)
    {
        if ($user->status === 'approved') {
            Auth::login($user, true);
            return redirect()->intended(route('admin.dashboard'));
        }

        // Suspended or still pending — do not allow login
        $message = $user->status === 'suspended'
            ? 'Your account has been suspended. Please contact support.'
            : 'Your account is pending admin approval. You will be notified by email once approved.';

        return redirect()->route('login')->with('error', $message);
    }

    /**
     * Notify all admin users that a new user is awaiting approval.
     */
    protected function notifyAdmins(User $newUser): void
    {
        try {
            $admins = User::where('status', 'approved')
                ->whereNotNull('email_verified_at')
                ->get(); // Adjust this query if you have a role/permission system

            if ($admins->isNotEmpty()) {
                Notification::send($admins, new NewUserPendingApprovalNotification($newUser));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to notify admins of new user: ' . $e->getMessage());
        }
    }

    /**
     * Abort with 404 if the provider is not in our supported list.
     */
    protected function abortIfUnsupported(string $provider): void
    {
        if (!array_key_exists($provider, $this->providers)) {
            abort(404);
        }
    }
}
