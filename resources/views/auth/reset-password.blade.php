<x-guest-layout title="Reset Password">

    <x-auth-card>

        {{-- Heading --}}
        <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--pac-ink); margin: 0 0 0.25rem;">
            Reset Password 🔑
        </h4>
        <p style="font-size: 0.875rem; color: var(--pac-ink-muted); margin: 0 0 1.6rem;">
            Choose a strong new password for your account.
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            {{-- Hidden token + email --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ $request->email }}">

            {{-- New password --}}
            <div class="pac-field">
                <div class="pac-pw-wrap">
                    <input
                        class="pac-input"
                        id="password"
                        type="password"
                        name="password"
                        placeholder=" "
                        required
                        autocomplete="new-password"
                        autofocus
                    />
                    <label class="pac-label" for="password">New Password</label>
                    <button class="pac-eye" type="button" onclick="pacTogglePw('password', 'eye-pw')" aria-label="Toggle password">
                        <svg id="eye-pw" width="17" height="17" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                <div class="pac-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm password --}}
            <div class="pac-field">
                <div class="pac-pw-wrap">
                    <input
                        class="pac-input"
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder=" "
                        required
                        autocomplete="new-password"
                    />
                    <label class="pac-label" for="password_confirmation">Confirm Password</label>
                    <button class="pac-eye" type="button" onclick="pacTogglePw('password_confirmation', 'eye-confirm')" aria-label="Toggle confirm password">
                        <svg id="eye-confirm" width="17" height="17" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                <div class="pac-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button class="pac-btn" type="submit" data-pac-submit>
                <span class="pac-btn-text">Reset Password</span>
                <span class="pac-spinner">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <circle cx="12" cy="12" r="9" stroke-opacity="0.25"/>
                        <path d="M12 3a9 9 0 0 1 9 9" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>

            {{-- Back to login --}}
            <p style="text-align: center; font-size: 0.8125rem; color: var(--pac-ink-muted); margin-top: 1.25rem; margin-bottom: 0;">
                <a href="{{ route('login') }}"
                   style="color: var(--pac-ink); font-weight: 600; text-decoration: none; border-bottom: 1px solid var(--pac-metal-border); transition: border-color 0.15s;">
                    ← Back to Login
                </a>
            </p>

        </form>

    </x-auth-card>

</x-guest-layout>

<script>
    function pacTogglePw(inputId, iconId) {
        var inp  = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            inp.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }
</script>
