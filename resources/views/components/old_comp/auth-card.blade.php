@props([
    'animate' => false,
])

@php
    $hasErrors = $errors->any();
@endphp

<div class="auth-card-inner">

    <!-- CAP (session status / any slot content) -->
    <div class="auth-card-cap">
        {{ $cap ?? '' }}
    </div>

    <!-- GRADIENT BAR — green normally, red when validation errors exist -->
    <div class="auth-gradient-bar {{ $hasErrors ? 'is-error active' : '' }}" id="auth-preloader"></div>

    <!-- BODY -->
    <div class="auth-card-body">
        {{ $slot }}
    </div>

</div>

<style>
    .auth-card-inner {
        background: #ffffff;
        border-radius: 0.5rem;
        width: 100%;
        overflow: hidden;
    }

    /* ── Cap ── */
    .auth-card-cap {
        padding: 1.25rem 1.5rem 0.75rem;
    }

    /* Hide cap entirely when empty */
    .auth-card-cap:empty {
        padding: 0;
    }

    /* ── Body ── */
    .auth-card-body {
        padding: 1.25rem 1.5rem 1.5rem;
    }

    /* ── Gradient bar ─────────────────────────────────────────────────────────
     *
     *  Two states:
     *    Default  — green sliding bar, shown on form submit (via JS in guest.blade)
     *    is-error — red static bar, shown immediately when $errors->any() is true
     *
     *  iOS / Safari fix (same as guest.blade):
     *    Animation always runs. We only toggle visibility so Safari never has
     *    to "start" the animation — it just reveals an already-moving bar.
     *
     * ───────────────────────────────────────────────────────────────────────── */
    .auth-gradient-bar {
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #eef0f1 0%, #245624 50%, #eef0f1 100%);
        background-size: 200% 100%;
        animation: auth-gradient-slide 1.6s linear infinite;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease;
    }

    /* Shown — triggered by JS on submit OR by PHP error state */
    .auth-gradient-bar.active {
        opacity: 1;
        visibility: visible;
    }

    /* Error state — red, no slide animation needed */
    .auth-gradient-bar.is-error {
        background: linear-gradient(90deg, #f3f4f6 0%, #dc2626 50%, #f3f4f6 100%);
        animation: none;
        opacity: 1;
        visibility: visible;
    }

    @keyframes auth-gradient-slide {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
