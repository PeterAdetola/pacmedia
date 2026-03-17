<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-auth-card>

            <!-- Email Address -->
            <div class="auth-field">
                <x-input-label for="email" :value="__('Email')" class="auth-label" />
                <x-text-input id="email" class="auth-input" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="auth-input-error" />
            </div>

            <!-- Password -->
            <div class="auth-field">
                <x-input-label for="password" :value="__('Password')" class="auth-label" />
                <x-text-input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="auth-input-error" />
            </div>

            <!-- Confirm Password -->
            <div class="auth-field-last">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="auth-label" />
                <x-text-input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="auth-input-error" />
            </div>

            <!-- Actions -->
            <div class="auth-actions">
                <button type="submit" class="auth-btn" data-auth-submit>
                    <span class="auth-btn-text">{{ __('Reset Password') }}</span>
                    <svg class="auth-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>

        </x-auth-card>
    </form>
</x-guest-layout>
