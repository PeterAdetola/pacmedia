<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            Auth::login($user, true);
            return $this->redirectAfterLogin($user); // Updated
        }

        // 2. Find existing user by email and link the provider
        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    $idColumn           => $socialId,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);

                Auth::login($user, true);
                return $this->redirectAfterLogin($user); // Updated
            }
        }

        // 3. No email returned
        if (!$email) {
            return redirect()->route('login')
                ->withErrors(['email' =>
                    ucfirst($provider) . ' did not return an email address.'
                ]);
        }

        // 4. Create a brand new user
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
            'email_verified_at' => now(),
            'password'          => Hash::make(Str::random(32)),
            'status'            => 'pending', // Explicitly setting default
        ]);

        Auth::login($user, true);

        return $this->redirectAfterLogin($user); // Updated
    }

    /**
     * Custom redirection logic based on user status.
     */
    protected function redirectAfterLogin(User $user)
    {
        if ($user->status === 'approved') {
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->route('verification.notice');
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
