{{--
    Cookie Consent Banner — Pacmedia
    ─────────────────────────────────────────────────────────────
    Place this component just before the closing </body> tag
    in your layouts/app.blade.php:

        <x-cookie-consent />
--}}

<div class="cookie-consent" id="cookie-consent" role="dialog" aria-label="Cookie consent">
    <div class="cookie-consent__inner">

        <div class="cookie-consent__text">
            <p class="cookie-consent__title">
                <i class="ph ph-cookie cookie-consent__icon"></i>
                We use cookies.
            </p>
            <p class="cookie-consent__body">
                This site uses essential cookies to function and analytics cookies to understand how it's used.
                No data is sold. Ever.
                <a href="{{ route('privacy') }}" class="cookie-consent__link">Privacy Policy</a>
            </p>
        </div>

        <div class="cookie-consent__actions">
            <button class="cookie-consent__btn cookie-consent__btn--decline" id="cookie-decline">
                Essentials only
            </button>
            <button class="cookie-consent__btn cookie-consent__btn--accept" id="cookie-accept">
                Accept all
            </button>
        </div>

    </div>
</div>

<style>
    /* ─────────────────────────────────────────────────────────
       COOKIE CONSENT — Pacmedia
    ───────────────────────────────────────────────────────── */
    .cookie-consent {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%) translateY(calc(100% + 4rem));
        width: calc(100% - 4rem);
        max-width: 72rem;
        z-index: 998;
        transition: transform 0.5s cubic-bezier(0.23, 0.65, 0.74, 1.09),
        opacity 0.4s ease;
        opacity: 0;
        pointer-events: none;
    }

    .cookie-consent.is-visible {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
        pointer-events: all;
    }

    .cookie-consent__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 3rem;
        padding: 2rem 2.5rem;
        background: var(--base);
        border: 1px solid var(--stroke-elements);
        border-radius: var(--_radius);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    @media (max-width: 767px) {
        .cookie-consent {
            bottom: 1rem;
            width: calc(100% - 2rem);
        }

        .cookie-consent__inner {
            flex-direction: column;
            align-items: flex-start;
            gap: 2rem;
            padding: 2rem;
        }
    }

    /* ── Text ─────────────────────────────────────────── */
    .cookie-consent__text {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        flex: 1;
    }

    .cookie-consent__title {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font: normal var(--font-weight-medium) 1.6rem/1 var(--_font-default);
        color: var(--t-bright);
        margin: 0;
    }

    .cookie-consent__icon {
        font-size: 1.8rem;
        color: var(--t-muted);
        line-height: 1;
    }

    .cookie-consent__body {
        font: normal var(--font-weight-base) 1.4rem/1.6 var(--_font-default);
        color: var(--t-medium);
        margin: 0;
    }

    .cookie-consent__link {
        color: var(--t-medium);
        text-decoration: underline;
        text-underline-offset: 3px;
        transition: color var(--_animspeed-medium) var(--_animbezier);
        font-size: inherit;
    }

    .cookie-consent__link:hover {
        color: var(--t-bright);
    }

    /* ── Actions ──────────────────────────────────────── */
    .cookie-consent__actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
    }

    @media (max-width: 767px) {
        .cookie-consent__actions {
            width: 100%;
        }

        .cookie-consent__btn {
            flex: 1;
        }
    }

    .cookie-consent__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 2rem;
        border-radius: var(--_radius-s);
        font: normal var(--font-weight-medium) 1.4rem/1 var(--_font-default);
        cursor: pointer;
        white-space: nowrap;
        transition: all var(--_animspeed-medium) var(--_animbezier);
        border: 1px solid var(--stroke-elements);
    }

    /* Decline — ghost */
    .cookie-consent__btn--decline {
        background: transparent;
        color: var(--t-muted);
    }

    .cookie-consent__btn--decline:hover {
        color: var(--t-bright);
        border-color: var(--t-bright);
    }

    /* Accept — solid */
    .cookie-consent__btn--accept {
        background: var(--neutral-bright);
        color: var(--t-opp-bright);
        border-color: var(--neutral-bright);
    }

    .cookie-consent__btn--accept:hover {
        opacity: 0.85;
    }
</style>

<script>
    (function () {
        const COOKIE_KEY = 'pacmedia_cookie_consent';
        const banner     = document.getElementById('cookie-consent');
        const btnAccept  = document.getElementById('cookie-accept');
        const btnDecline = document.getElementById('cookie-decline');

        // Show banner if no consent recorded yet
        function init() {
            if (!localStorage.getItem(COOKIE_KEY)) {
                setTimeout(() => banner.classList.add('is-visible'), 800);
            }
        }

        function dismiss(value) {
            localStorage.setItem(COOKIE_KEY, value);
            banner.classList.remove('is-visible');
        }

        btnAccept.addEventListener('click', function () {
            dismiss('all');
            // Fire analytics consent here if needed
            // e.g. gtag('consent', 'update', { analytics_storage: 'granted' });
        });

        btnDecline.addEventListener('click', function () {
            dismiss('essential');
        });

        // Run on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
