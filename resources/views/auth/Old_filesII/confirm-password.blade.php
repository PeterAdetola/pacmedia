<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <x-auth-card>

            <!-- Intro text -->
            <p class="auth-hint">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>

            <!-- Password -->
            <div class="auth-field-last">
                <x-input-label for="password" :value="__('Password')" class="auth-label" />
                <x-text-input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="auth-input-error" />
            </div>

            <!-- Actions -->
            <div class="auth-actions">
                <button type="submit" class="auth-btn" data-auth-submit>
                    <span class="auth-btn-text">{{ __('Confirm') }}</span>
                    <svg class="auth-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>

        </x-auth-card>
    </form>
</x-guest-layout>
