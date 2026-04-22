<x-guest-layout title="Pending Approval">

    <x-auth-card>

        {{-- Heading --}}
        <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--pac-ink); margin: 0 0 0.25rem;">
            Account Pending Approval ⏳
        </h4>
        <p style="font-size: 0.875rem; color: var(--pac-ink-muted); margin: 0 0 1.6rem; line-height: 1.6;">
            Thanks for signing up! Before you can get started, our team needs
            to manually review your account. This typically takes less than
            48 hours. We'll notify you by email as soon as you're approved.
        </p>

        {{-- Logout — primary action on this page --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="pac-btn" type="submit" data-pac-submit>
                <span class="pac-btn-text">Log out</span>
                <span class="pac-spinner">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <circle cx="12" cy="12" r="9" stroke-opacity="0.25"/>
                        <path d="M12 3a9 9 0 0 1 9 9" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>
        </form>

        {{-- Wrong account link --}}
        <p style="text-align: center; font-size: 0.8125rem; color: var(--pac-ink-muted); margin-top: 1rem; margin-bottom: 0;">
            Used the wrong account?
            <a href="{{ route('login') }}"
               style="color: var(--pac-ink); font-weight: 600; text-decoration: none; border-bottom: 1px solid var(--pac-metal-border); transition: border-color 0.15s;">
                Sign in with a different one
            </a>
        </p>

    </x-auth-card>

</x-guest-layout>
