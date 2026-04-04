<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pacmedia') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        /* ── Reset ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Page ── */
        body {
            font-family: 'Figtree', sans-serif;
            font-size: 1rem;
            color: #111827;
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Outer wrapper ── */
        .guest-screen {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1.5rem 1rem;
        }

        /* ── Logo ── */
        .guest-logo { margin-bottom: 1.5rem; }
        .guest-logo a { display: inline-block; }
        .guest-logo svg {
            width: 5rem;
            height: 5rem;
            color: #6b7280;
            fill: currentColor;
            display: block;
        }

        /* ── Card shell ── */
        .guest-card {
            width: 100%;
            max-width: 28rem;
            background: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        /* ── Labels ── */
        .auth-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.35rem;
        }

        /* ── Inputs ── */
        .auth-input {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 0.9375rem;
            font-family: inherit;
            color: #111827;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
            appearance: none;
        }
        .auth-input:focus {
            outline: none;
            border-color: #245624;
            box-shadow: 0 0 0 3px rgba(36,86,36,0.2);
        }

        /* ── Field wrappers ── */
        .auth-field      { margin-bottom: 1.25rem; }
        .auth-field-last { margin-bottom: 1.5rem; }

        /* ── Validation errors ── */
        .auth-input-error {
            font-size: 0.8125rem;
            color: #dc2626;
            margin-top: 0.3rem;
        }

        /* ── Checkbox ── */
        .auth-check {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        .auth-check input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            accent-color: #245624;
            cursor: pointer;
            flex-shrink: 0;
        }
        .auth-check span {
            font-size: 0.875rem;
            color: #6b7280;
            user-select: none;
        }

        /* ── Actions row ── */
        .auth-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* ── Links ── */
        .auth-link {
            font-size: 0.875rem;
            color: #6b7280;
            text-decoration: underline;
            border-radius: 0.25rem;
            transition: color 0.15s;
        }
        .auth-link:hover { color: #111827; }
        .auth-link:focus { outline: 2px solid #245624; outline-offset: 2px; }

        /* ── Primary button ── */
        .auth-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1.25rem;
            font-family: inherit;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #ffffff;
            background: #1f2937;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background 0.15s, box-shadow 0.15s;
        }
        .auth-btn:hover  { background: #374151; }
        .auth-btn:active { background: #111827; }
        .auth-btn:focus  { outline: none; box-shadow: 0 0 0 3px rgba(36,86,36,0.35); }
        .auth-btn[disabled] { pointer-events: none; opacity: 0.7; }

        /* Social icon buttons */

        .auth-social-btn svg { width: 1.8rem; height: 1.8rem; display: block; }

        /* Button spinner */
        .auth-spinner {
            display: none;
            position: absolute;
            width: 1.25rem;
            height: 1.25rem;
            animation: auth-spin 0.7s linear infinite;
        }
        @keyframes auth-spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .auth-btn.is-loading .auth-btn-text { visibility: hidden; }
        .auth-btn.is-loading .auth-spinner  { display: block; }

        /* Session status banner */
        .auth-session-status {
            padding: 0.75rem 1rem;
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #065f46;
        }

        /* Disable submit while form is invalid */
        form:invalid button[type="submit"] { pointer-events: none; }

        /* ── Page footer ── */
        .guest-footer {
            padding: 1rem;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .guest-footer span { font-weight: 500; }
    </style>
</head>

<body>

<div class="guest-screen">

    <!-- Logo -->
    <div class="guest-logo">
        <a href="/">
            <x-application-logo />
        </a>
    </div>

    <!-- Card shell — auth-card component renders the bar + inner padding -->
    <div class="guest-card">
        {{ $slot }}
    </div>

</div>

<!-- Footer -->
<div class="guest-footer">
    Made with ❤️ by <span>thepacmedia</span>
</div>

<script>
    (function () {
        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form) return;

            // Activate the gradient bar inside auth-card
            var bar = form.querySelector('#auth-preloader');
            if (bar) bar.classList.add('active');

            // Show spinner + disable submit button
            var btn = form.querySelector('[data-auth-submit]');
            if (btn) {
                btn.classList.add('is-loading');
                btn.setAttribute('disabled', true);
            }
        });
    })();
</script>

</body>
</html>
