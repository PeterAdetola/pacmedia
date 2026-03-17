<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-auth-card>

            <x-slot name="cap">
                <x-auth-session-status :status="session('status')" />
            </x-slot>

            <!-- Email Address -->
            <div class="auth-field">
                <x-input-label for="email" :value="__('Email')" class="auth-label" />
                <x-text-input
                    id="email"
                    class="auth-input"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" class="auth-input-error" />
            </div>

            <!-- Password -->
            <div class="auth-field">
                <x-input-label for="password" :value="__('Password')" class="auth-label" />
                <x-text-input
                    id="password"
                    class="auth-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                <x-input-error :messages="$errors->get('password')" class="auth-input-error" />
            </div>

            <!-- Remember Me -->
            <div class="auth-field-last">
                <label class="auth-check" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember" />
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="auth-actions">
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="auth-btn" data-auth-submit>
                    <span class="auth-btn-text">{{ __('Log in') }}</span>
                    <svg
                        class="auth-spinner"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>

        </x-auth-card>
    </form>
</x-guest-layout>
