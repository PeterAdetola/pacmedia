<x-guest-layout title="Verify Email">

    <x-auth-card>

        {{-- Cap: resend confirmation --}}
        <x-slot name="cap">
            @if (session('status') == 'verification-link-sent')
                <div class="pac-status">
                    A new verification link has been sent to your email address.
                </div>
            @endif
        </x-slot>

        {{-- Heading --}}
        <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--pac-ink); margin: 0 0 0.25rem;">
            Check your Inbox 📬
        </h4>
        <p style="font-size: 0.875rem; color: var(--pac-ink-muted); margin: 0 0 1.6rem; line-height: 1.6;">
            Thanks for signing up! Before you continue, please verify your
            email address by clicking the link we just sent you. Didn't
            receive it? We can send another.
        </p>

        {{-- Resend form --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button class="pac-btn" type="submit" data-pac-submit>
                <span class="pac-btn-text">Resend Verification Email</span>
                <span class="pac-spinner">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <circle cx="12" cy="12" r="9" stroke-opacity="0.25"/>
                        <path d="M12 3a9 9 0 0 1 9 9" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>

        </form>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
            @csrf
            <p style="text-align: center; font-size: 0.8125rem; color: var(--pac-ink-muted); margin: 0;">
                Wrong account?
                <button type="submit"
                        style="background: none; border: none; padding: 0; font-family: inherit; font-size: 0.8125rem; font-weight: 600; color: var(--pac-ink); border-bottom: 1px solid var(--pac-metal-border); cursor: pointer; transition: border-color 0.15s;">
                    Log out
                </button>
            </p>
        </form>

    </x-auth-card>

</x-guest-layout>
