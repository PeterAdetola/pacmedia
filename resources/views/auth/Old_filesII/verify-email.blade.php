<x-guest-layout>
    <x-auth-card>

        <!-- Intro text -->
        <p class="auth-hint">
            {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
        </p>

        <!-- Verification link sent confirmation -->
        @if (session('status') == 'verification-link-sent')
            <p class="auth-success-hint">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </p>
        @endif

        <!-- Actions -->
        <div class="auth-actions auth-actions-split">

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="auth-btn" data-auth-submit>
                    <span class="auth-btn-text">{{ __('Resend Verification Email') }}</span>
                    <svg class="auth-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="auth-link-btn">
                    {{ __('Log Out') }}
                </button>
            </form>

        </div>

    </x-auth-card>
</x-guest-layout>
