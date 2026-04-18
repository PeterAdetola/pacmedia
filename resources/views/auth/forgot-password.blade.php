<x-guest-layout title="Forgot Password">

    <x-auth-card>

        {{-- Cap: session status --}}
        <x-slot name="cap">
            @if (session('status'))
                <div class="pac-status">{{ session('status') }}</div>
            @endif
        </x-slot>

        {{-- Heading --}}
        <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--pac-ink); margin: 0 0 0.25rem;">
            Forgot Password? 🔒
        </h4>
        <p style="font-size: 0.875rem; color: var(--pac-ink-muted); margin: 0 0 1.6rem;">
            Enter your email and we'll send you a reset link.
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- Email --}}
            <div class="pac-field">
                <input
                    class="pac-input"
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder=" "
                    required
                    autocomplete="email"
                    autofocus
                />
                <label class="pac-label" for="email">Email Address</label>
                @error('email')
                <div class="pac-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button class="pac-btn" type="submit" data-pac-submit>
                <span class="pac-btn-text">Send Reset Link</span>
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
