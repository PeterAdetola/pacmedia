<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <x-auth-card>

            <x-slot name="cap">
                <x-auth-session-status :status="session('status')" />
            </x-slot>

            <!-- Intro text -->
            <p class="auth-hint">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>

            <!-- Email Address -->
            <div class="auth-field">
                <x-input-label for="email" :value="__('Email')" class="auth-label" />
                <x-text-input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="auth-input-error" />
            </div>

            <!-- Actions -->
            <div class="auth-actions">
                <button type="submit" class="auth-btn" data-auth-submit>
                    <span class="auth-btn-text">{{ __('Email Password Reset Link') }}</span>
                    <svg class="auth-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>

        </x-auth-card>
    </form>
</x-guest-layout>
