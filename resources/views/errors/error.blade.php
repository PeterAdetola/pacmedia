<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5"/>
    <title>{{ $code }} — {{ $name }} | Pacmedia</title>
    <meta name="robots" content="noindex, nofollow"/>

    <link rel="icon" href="{{ asset('img/favicon/favicon.ico') }}" sizes="any"/>
    <link rel="icon" href="{{ asset('img/favicon/icon.svg') }}" type="image/svg+xml"/>
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/apple-touch-icon.png') }}"/>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}"/>

    {{-- Phosphor Icons --}}
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        /* ─────────────────────────────────────────────────
           ERROR PAGE — standalone, no layout wrapper
        ───────────────────────────────────────────────── */

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            background-color: var(--base);
            position: relative;
            overflow: hidden;
        }

        /* ── Background grid lines ── */
        .error-page::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(var(--stroke-elements) 1px, transparent 1px),
                linear-gradient(90deg, var(--stroke-elements) 1px, transparent 1px);
            background-size: 6rem 6rem;
            opacity: 0.15;
            pointer-events: none;
        }

        /* ── Corner logo ── */
        .error-logo {
            position: fixed;
            top: 2.5rem;
            left: 2.5rem;
            z-index: 10;
            opacity: 0;
            animation: fadeUp 0.6s ease forwards 0.1s;
        }

        .error-logo svg {
            height: 3.6rem;
            width: auto;
            color: var(--t-bright);
        }

        @media (min-width: 768px) {
            .error-logo {
                top: 3.5rem;
                left: 4rem;
            }
        }

        /* ── Main content ── */
        .error-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 56rem;
        }

        /* ── Status icon ── */
        .error-icon-wrap {
            width: 9rem;
            height: 9rem;
            border-radius: 50%;
            /*background: var(--base-tint);*/
            /*border: 1px solid var(--stroke-elements);*/
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 3.5rem;
            opacity: 0;
            animation: fadeUp 0.7s ease forwards 0.2s;
        }

        .error-icon-wrap i {
            font-size: 3.6rem;
            color: var(--t-muted);
            line-height: 1;
        }

        @media (min-width: 768px) {
            .error-icon-wrap {
                width: 11rem;
                height: 11rem;
            }
            .error-icon-wrap i {
                font-size: 4.4rem;
            }
        }

        /* ── Code number ── */
        .error-code {
            font: normal 300 10rem/1 var(--_font-accent);
            color: var(--t-bright);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            opacity: 0;
            animation: fadeUp 0.7s ease forwards 0.3s;
        }

        @media (min-width: 768px) {
            .error-code {
                font-size: 16rem;
            }
        }

        @media (min-width: 1200px) {
            .error-code {
                font-size: 20rem;
            }
        }

        /* ── Status name ── */
        .error-name {
            font: normal var(--font-weight-base) 1.4rem/1 var(--_font-default);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--t-muted);
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeUp 0.7s ease forwards 0.4s;
        }

        /* ── Rule ── */
        .error-rule {
            width: 4rem;
            height: 1px;
            background: var(--stroke-elements);
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeUp 0.7s ease forwards 0.45s;
        }

        /* ── Message ── */
        .error-message {
            font: normal var(--font-weight-base) 1.8rem/1.7 var(--_font-default);
            color: var(--t-medium);
            margin-bottom: 4rem;
            opacity: 0;
            animation: fadeUp 0.7s ease forwards 0.5s;
        }

        @media (min-width: 768px) {
            .error-message {
                font-size: 2rem;
            }
        }

        /* ── Actions ── */
        .error-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
            opacity: 0;
            animation: fadeUp 0.7s ease forwards 0.6s;
        }

        .error-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            padding: 1.4rem 2.8rem;
            border-radius: var(--_radius-s);
            font: normal var(--font-weight-medium) 1.6rem/1 var(--_font-default);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
            border: 1px solid var(--stroke-elements);
        }

        .error-btn i {
            font-size: 1.8rem;
            line-height: 1;
        }

        /* Primary — solid */
        .error-btn--primary {
            background: var(--neutral-bright);
            color: var(--t-opp-bright);
            border-color: var(--neutral-bright);
        }

        .error-btn--primary:hover {
            opacity: 0.85;
        }

        /* Ghost */
        .error-btn--ghost {
            background: transparent;
            color: var(--t-medium);
        }

        .error-btn--ghost:hover {
            color: var(--t-bright);
            border-color: var(--t-bright);
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Color switcher ── */
        .error-color {
            position: fixed;
            top: 2rem;
            right: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 4rem;
            height: 4rem;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: var(--_radius-s);
            z-index: 100;
        }

        @media (min-width: 768px) {
            .error-color {
                top: 3rem;
                right: 5rem;
            }
        }

        .color-switcher {
            position: relative;
            display: inline-flex;
            border: none;
            outline: 0;
            padding: 0;
            background-color: var(--neutral-bright);
            cursor: pointer;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>

{{-- Color switcher --}}
<div class="error-color">
    <button id="color-switcher" class="color-switcher" type="button"
            role="switch" aria-label="Toggle light/dark mode"></button>
</div>

{{-- Logo --}}
<div class="error-logo">
    <a href="{{ url('/') }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 213.87 348.38" aria-label="Pacmedia">
            <style>.cls-1 { fill: currentColor; }</style>
            <polygon class="cls-1" points="0 24.16 96.35 0 96.35 135.47 0 135.47 0 24.16"/>
            <polygon class="cls-1" points="0 155.41 96.35 155.41 96.35 348.38 0 257.69 0 155.41"/>
            <polygon class="cls-1" points="213.87 54.61 213.87 135.47 117.53 135.47 117.53 39.5 213.87 54.61"/>
            <polygon class="cls-1" points="117.53 155.41 213.87 155.41 213.87 233.5 117.53 245.41 117.53 155.41"/>
        </svg>
    </a>
</div>

{{-- Main error content --}}
<main class="error-page">
    <div class="error-content">

        {{-- Icon --}}
        <div class="error-icon-wrap">
{{--            <i class="ph-thin {{ $icon }}"></i>--}}
            <img src="{{ asset('img/favicon/icon-off.png') }}" />
        </div>

        {{-- Code --}}
        <p class="error-code">{{ $code }}</p>

        {{-- Name --}}
        <p class="error-name">{{ $name }}</p>

        {{-- Rule --}}
        <div class="error-rule"></div>

        {{-- Message --}}
        <p class="error-message">{{ $message }}</p>

        {{-- Actions --}}
        <div class="error-actions">
            <a href="{{ url('/') }}" class="error-btn error-btn--primary">
                <i class="ph ph-house"></i>
                Return Home
            </a>
            @if($showBack ?? true)
                <button onclick="history.back()" class="error-btn error-btn--ghost">
                    <i class="ph ph-arrow-left"></i>
                    Go Back
                </button>
            @endif
        </div>

    </div>
</main>

<script>
    // Colour scheme switcher — same logic as main site
    const themeBtn = document.getElementById('color-switcher');

    function getCurrentTheme() {
        let theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        localStorage.getItem('template.theme') ? (theme = localStorage.getItem('template.theme')) : null;
        return theme;
    }

    function loadTheme(theme) {
        document.querySelector(':root').setAttribute('color-scheme', theme);
    }

    themeBtn.addEventListener('click', () => {
        let theme = getCurrentTheme();
        theme = theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('template.theme', theme);
        loadTheme(theme);
    });

    window.addEventListener('DOMContentLoaded', () => loadTheme(getCurrentTheme()));
</script>

</body>
</html>
