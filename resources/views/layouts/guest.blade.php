<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-bs-theme="light"
      data-assets-path="{{ asset('admin/assets/') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'The Pacmedia') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Iconify icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/iconify-icons.css') }}">

    <!-- Core CSS: Bootstrap + Materialize Bootstrap theme -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}">

    <!-- Auth page CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/pages/page-auth.css') }}">

    <!-- Helpers must load before customizer and config -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>

    <style>
        /* ── Brand variables ── */
        :root {
            --pac-peridot:       #b5cc18;
            --pac-peridot-dim:   #96aa12;
            --pac-peridot-glow:  rgba(181, 204, 24, 0.15);
            --pac-peridot-track: #e8edab;
            --pac-metal:         #6b7280;
            --pac-metal-border:  #d1d5db;
            --pac-ink:           #111827;
            --pac-ink-soft:      #374151;
            --pac-ink-muted:     #6b7280;
        }

        /* ── Page ── */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
        }

        /* ── Outer wrapper ── */
        .pac-auth-screen {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ── Logo — outside the card ── */
        .pac-auth-logo {
            margin-bottom: 1.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pac-auth-logo svg {
            width: 3rem;
            height: 3rem;
            fill: var(--pac-ink);
            display: block;
        }

        /* ── Card shell ── */
        .pac-auth-card-wrap {
            width: 100%;
            max-width: 420px;
        }

        /* ── Indeterminate progress bar ── */
        .pac-progress {
            height: 3px;
            background: var(--pac-peridot-track);
            position: relative;
            overflow: hidden;
        }
        .pac-progress-bar {
            position: absolute;
            top: 0;
            height: 100%;
            width: 40%;
            background: var(--pac-peridot);
            border-radius: 2px;
            animation: pac-slide 1.4s ease-in-out infinite;
        }
        .pac-progress.idle .pac-progress-bar {
            animation-play-state: paused;
            opacity: 0;
            transition: opacity 0.4s;
        }
        @keyframes pac-slide {
            0%   { left: -40%; }
            55%  { left: 60%; }
            100% { left: 120%; }
        }

        /* ── Floating label inputs ── */
        .pac-field {
            position: relative;
            margin-bottom: 1.25rem;
        }
        .pac-input {
            display: block;
            width: 100%;
            height: 3.25rem;
            box-sizing: border-box;
            padding: 1rem 0.875rem 0.25rem;
            font-size: 0.9375rem;
            font-family: inherit;
            color: var(--pac-ink);
            background: #ffffff;
            border: 1px solid var(--pac-metal-border);
            border-radius: 0.4rem;
            outline: none;
            appearance: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .pac-input:focus {
            border-color: var(--pac-peridot);
            box-shadow: 0 0 0 3px var(--pac-peridot-glow);
        }
        .pac-label {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            color: var(--pac-metal);
            pointer-events: none;
            background: #ffffff;
            padding: 0 0.2rem;
            transition: top 0.15s ease, font-size 0.15s ease,
            color 0.15s ease, transform 0.15s ease;
        }
        .pac-input:focus ~ .pac-label,
        .pac-input:not(:placeholder-shown) ~ .pac-label {
            top: 0;
            transform: translateY(-50%);
            font-size: 0.72rem;
            color: var(--pac-peridot-dim);
        }

        /* ── Password toggle ── */
        .pac-pw-wrap { position: relative; }
        .pac-pw-wrap .pac-input { padding-right: 2.75rem; }
        .pac-eye {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--pac-metal);
            background: none;
            border: none;
            padding: 0;
            display: flex;
            line-height: 1;
            transition: color 0.15s;
        }
        .pac-eye:hover { color: var(--pac-ink-soft); }

        /* ── Checkbox ── */
        .pac-check {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.8125rem;
            color: var(--pac-ink-muted);
            cursor: pointer;
            user-select: none;
        }
        .pac-check input[type="checkbox"] {
            accent-color: var(--pac-peridot);
            width: 0.95rem;
            height: 0.95rem;
            cursor: pointer;
        }

        /* ── Links ── */
        .pac-link {
            font-size: 0.8125rem;
            color: var(--pac-ink-muted);
            text-decoration: none;
            transition: color 0.15s;
        }
        .pac-link:hover { color: var(--pac-ink); }

        /* ── Primary button — black family ── */
        .pac-btn {
            width: 100%;
            padding: 0.78rem 1rem;
            font-family: inherit;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #ffffff;
            background: var(--pac-ink);
            border: none;
            border-radius: 0.4rem;
            cursor: pointer;
            overflow: hidden;
            transition: background 0.15s;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pac-btn:hover  { background: var(--pac-ink-soft); }
        .pac-btn:active { background: #000000; }
        .pac-btn::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--pac-peridot);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .pac-btn:hover::before { opacity: 1; }
        .pac-btn.is-loading .pac-btn-text { visibility: hidden; }
        .pac-btn.is-loading .pac-spinner  { display: flex; }
        .pac-spinner {
            display: none;
            position: absolute;
            align-items: center;
            justify-content: center;
        }
        .pac-spinner svg { animation: pac-spin 0.7s linear infinite; }
        @keyframes pac-spin { to { transform: rotate(360deg); } }

        /* ── Social icon buttons ── */
        .pac-socials {
            display: flex;
            justify-content: center;
            gap: 0.6rem;
        }
        .pac-social-btn {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            border: 1.5px solid var(--pac-metal-border);
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: border-color 0.2s, background 0.2s, transform 0.15s;
        }
        .pac-social-btn:hover {
            border-color: var(--pac-metal);
            background: #f0f0f0;
            transform: translateY(-1px);
        }
        .pac-social-btn svg { width: 1.1rem; height: 1.1rem; display: block; }

        /* ── Divider ── */
        .pac-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0 1.1rem;
        }
        .pac-divider-line { flex: 1; height: 1px; background: var(--pac-metal-border); }
        .pac-divider-text { font-size: 0.8125rem; color: var(--pac-metal); white-space: nowrap; }

        /* ── Session status ── */
        .pac-status {
            padding: 0.65rem 0.9rem;
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #065f46;
            margin-bottom: 1rem;
        }

        /* ── Validation error ── */
        .pac-error {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 0.3rem;
        }

        /* ── Bottom brand strip ── */
        .pac-strip {
            height: 3px;
            background: linear-gradient(90deg, var(--pac-peridot) 0%, var(--pac-metal) 55%, #111111 100%);
            opacity: 0.5;
        }

        /* ── Page footer ── */
        .pac-footer {
            text-align: center;
            font-size: 0.75rem;
            color: var(--pac-metal);
            margin-top: 1.1rem;
            letter-spacing: 0.02em;
        }
        .pac-footer .heart { color: #dc2626; }
    </style>

    {{-- Per-page extra CSS --}}
    @if(isset($pageStyles))
        {!! $pageStyles !!}
    @endif
</head>

<body>

<div class="pac-auth-screen">

    {{-- Logo — outside the card --}}
    <div class="pac-auth-logo">
        <a href="{{ url('/') }}">
            <x-application-logo />
        </a>
    </div>

    {{-- Slot: auth-card component fills this --}}
    <div class="pac-auth-card-wrap">
        {{ $slot }}
    </div>

</div>

{{-- Page footer --}}
<div class="pac-footer">
    Made with <span class="heart">&#10084;</span> by Pacmedia Creatives
</div>

<!-- Core JS — order matters -->
<script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('admin/assets/js/main.js') }}"></script>

<!-- Auth page JS -->
<script src="{{ asset('admin/assets/js/pages-auth.js') }}"></script>

<script>
    // Activate progress bar + button spinner on form submit
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form) return;

        // Activate the indeterminate bar
        var bar = document.getElementById('pac-preloader');
        if (bar) {
            bar.classList.remove('idle');
        }

        // Show spinner and disable the submit button
        var btn = form.querySelector('.pac-btn[data-pac-submit]');
        if (!btn) btn = form.querySelector('[data-pac-submit]');
        if (btn) {
            btn.classList.add('is-loading');
            btn.disabled = true;
        }
    });
</script>

{{-- Per-page scripts --}}
@if(isset($pageScripts))
    {!! $pageScripts !!}
@endif

</body>
</html>
