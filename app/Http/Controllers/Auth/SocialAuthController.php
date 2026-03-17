<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Supported providers and their matching user table column.
     */
    protected array $providers = [
        'google'   => 'google_id',
        'linkedin' => 'linkedin_id',
        'github'   => 'github_id',
    ];

    /**
     * Redirect the user to the provider's OAuth page.
     */
    public function redirect(string $provider)
    {
        $this->abortIfUnsupported($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from the provider after authentication.
     */
    public function callback(string $provider)
    {
        $this->abortIfUnsupported($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => ucfirst($provider) . ' sign-in failed. Please try again.']);
        }

        $idColumn = $this->providers[$provider];
        $socialId = $socialUser->getId();
        $email    = $socialUser->getEmail();
        $name     = $socialUser->getName() ?? $socialUser->getNickname() ?? 'User';

        // 1. Find existing user by this provider's ID
        $user = User::where($idColumn, $socialId)->first();

        if ($user) {
            Auth::login($user, true);
            return redirect()->intended(route('dashboard'));
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
                return redirect()->intended(route('dashboard'));
            }
        }

        // 3. Create a brand new user
        // GitHub can have no public email — handle that gracefully
        if (!$email) {
            return redirect()->route('login')
                ->withErrors(['email' => 'No email address returned from ' . ucfirst($provider) . '. Please ensure your ' . ucfirst($provider) . ' account has a public email address.']);
        }

        // Auto-generate a unique username from their name
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
            'email_verified_at' => now(), // Provider already verified the email
            'password'          => null,
        ]);

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
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
