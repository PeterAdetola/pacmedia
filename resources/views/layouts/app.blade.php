<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle ?? 'The Pacmedia | Forging Identity. Engineering Digital Infrastructure' }}</title>
    <meta name="title" content="{{ $metaTitle ?? 'Pacmedia Creatives - Forging Identity. Engineering Digital Infrastructure' }}"/>
    <meta name="description" content="{{ $metaDescription ?? 'Pacmedia Creatives forges elite identities and engineers mission-critical digital infrastructure. We deploy tactical solutions for ambitious brands worldwide, blending high-precision design with scalable Laravel-powered systems and AI automation.' }}"/>
    <meta name="keywords" content="{{ $metaKeywords ?? 'Pacmedia Creatives, Forging Identity, Digital Infrastructure Engineering, Tactical Digital Solutions, Brand Architecture, High-Performance Laravel Development, Custom CRM Systems, AI Automation, Strategic Branding Studio, Global Digital Agency, UI/UX Engineering, Scalable Web Systems' }}"/>
    <meta name="author" content="Pacmedia Creatives"/>
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1"/>
    <link rel="canonical" href="{{ url()->current() }}"/>

    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="Pacmedia Creatives"/>
    <meta property="og:title" content="{{ $metaTitle ?? 'Pacmedia Creatives - Forging Identity. Engineering Digital Infrastructure' }}"/>
    <meta property="og:description" content="{{ $metaDescription ?? 'Forging Digital Prestige. We engineer high-performance brand identities and digital infrastructure for companies that refuse to blend in.' }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:image" content="{{ asset('img/og-image.jpg') }}"/>
    <meta property="og:image:secure_url" content="{{ asset('img/og-image.jpg') }}"/>
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>
    <meta property="og:image:alt" content="{{ $metaTitle ?? 'Pacmedia Creatives' }}"/>
    <meta property="og:locale" content="en_US"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{ $metaTitle ?? 'Pacmedia Creatives - Forging Identity. Engineering Digital Infrastructure' }}"/>
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Where brand identity is forged and mission-critical digital infrastructure is engineered.' }}"/>
    <meta name="twitter:image" content="{{ asset('img/og-image.jpg') }}"/>
    <meta name="twitter:image:alt" content="{{ $metaTitle ?? 'Pacmedia Creatives' }}"/>

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "ProfessionalService",
            "name": "Pacmedia Creatives",
            "alternateName": "Pacmedia",
            "description": "Tactical digital studio specializing in forging brand identities and engineering mission-critical digital infrastructure via Laravel and AI automation.",
            "url": "{{ url('/') }}",
        "logo": "{{ url('img/logo.png') }}",
        "image": "{{ url('img/og-image.jpg') }}",
        "email": "reach@thepacmedia.com",
        "areaServed": { "@type": "Place", "name": "Worldwide" },
        "serviceType": [
            "Brand Identity Forging",
            "Digital Infrastructure Engineering",
            "Laravel Web Development",
            "AI Automation Systems",
            "Custom CRM & Inventory Solutions"
        ],
        "priceRange": "$$"
    }
    </script>

    <link rel="icon" href="{{ asset('img/favicon/favicon.ico') }}" sizes="any"/>
    <link rel="icon" href="{{ asset('img/favicon/icon.svg') }}" type="image/svg+xml"/>
    <link rel="apple-touch-icon" href="{{ asset('img/favicon/apple-touch-icon.png') }}"/>
    <link rel="manifest" href="{{ asset('img/favicon/manifest.webmanifest') }}"/>

    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#BABEC8"/>
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#141414"/>
    <meta name="msapplication-navbutton-color" content="#141414"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="msapplication-TileColor" content="#141414"/>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com"/>

    <link rel="preload" href="{{ asset('css/main.css') }}" as="style"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/loaders/loader.css') }}?v={{ filemtime(public_path('css/loaders/loader.css')) }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}"/>

    <meta http-equiv="X-Content-Type-Options" content="nosniff"/>
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN"/>
    <meta http-equiv="X-XSS-Protection" content="1; mode=block"/>
    <meta name="referrer" content="strict-origin-when-cross-origin"/>
    @include('partials.lqip')
    @stack('head')
</head>

<body>
<!-- Loader -->
<div id="loader" class="loader active">
    <div class="loader__content">

        {{--
            Single SVG logo used by ALL browsers.
            - On capable browsers: JS RAF morph animates the points.
            - On Chrome iOS (CriOS): JS point-morphing is skipped;
              the CSS cross-fade animation on .poly-a / .poly-b runs
              instead. No separate fallback element needed.
        --}}
        <svg id="loader-logo"
             class="loader__logo loader__logo--css"
             viewBox="0 0 219.1 354"
             xmlns="http://www.w3.org/2000/svg"
             aria-hidden="true" focusable="false">
            {{-- poly-l = left column: top-left + bottom-left --}}
            <polygon id="l-tl" class="poly-l" fill="#6b6e78"/>
            <polygon id="l-bl" class="poly-l" fill="#6b6e78"/>
            {{-- poly-r = right column: top-right + bottom-right --}}
            <polygon id="l-tr" class="poly-r" fill="#6b6e78"/>
            <polygon id="l-br" class="poly-r" fill="#6b6e78"/>
        </svg>

        <div class="loader__bar-wrap" id="loader-bar-wrap">
            <div class="loader__bar" id="loader-bar"></div>
        </div>
        <span class="loader__percent" id="loader-percent">0%</span>

    </div>
</div>
{{-- Remove the orphaned #loader-fallback div entirely --}}
{{--<div id="loader" class="loader">--}}
{{--    <div class="loader__wrapper">--}}
{{--        <div class="loader__content">--}}
{{--            <div class="loader__count">--}}
{{--                <span class="count__text">0</span>--}}
{{--                <span class="count__percent">%</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{-- ================================================ --}}
{{-- NAVBAR — home page only (desktop navbar) --}}
{{-- Inner pages are handled exclusively inside --}}
{{-- .nav-container below to avoid duplication --}}
{{-- ================================================ --}}
@if($isHomePage ?? false)
    @include('layouts.navbar')
@endif

<!-- Fixed Logo -->
<div class="logo loading__fade">
    <a href="{{ url('/') }}" class="logo__link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 213.87 348.38" class="logo-svg" aria-label="Logo">
            <style>.cls-1 { fill: currentColor; }</style>
            <polygon class="cls-1" points="0 24.16 96.35 0 96.35 135.47 0 135.47 0 24.16"/>
            <polygon class="cls-1" points="0 155.41 96.35 155.41 96.35 348.38 0 257.69 0 155.41"/>
            <polygon class="cls-1" points="213.87 54.61 213.87 135.47 117.53 135.47 117.53 39.5 213.87 54.61"/>
            <polygon class="cls-1" points="117.53 155.41 213.87 155.41 213.87 233.5 117.53 245.41 117.53 155.41"/>
        </svg>
        <span class="logo-text-header" style="width: 7em; padding-bottom: 0.4em">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 263.2 43.7" class="logo-svg" aria-label="Pacmedia. logo">
                <switch>
                    <g>
                        <path fill="currentColor" d="M0 42.9v-40h13.8c2.2 0 4.1.5 5.8 1.6 1.7 1.1 3.1 2.5 4.2 4.3 1 1.8 1.6 3.8 1.6 6s-.5 4.2-1.6 6-2.5 3.2-4.2 4.3c-1.8 1.1-3.7 1.6-5.8 1.6H6v16.2H0zm6-22.1h7.2c1.1 0 2.2-.3 3.1-.9s1.7-1.3 2.3-2.3c.6-1 .8-2 .8-3.2s-.3-2.3-.8-3.2c-.6-1-1.3-1.7-2.3-2.3-.9-.6-2-.8-3.1-.8H6v12.7zm44.8-6.5h5.9v28.6h-6l-.2-4.1c-.8 1.5-2 2.6-3.4 3.5S44 43.6 42 43.6c-2.1 0-4.1-.4-5.9-1.2-1.8-.8-3.5-1.9-4.9-3.3s-2.5-3-3.3-4.9c-.8-1.8-1.2-3.8-1.2-5.9 0-2 .4-4 1.1-5.8.8-1.8 1.8-3.4 3.2-4.7 1.4-1.4 2.9-2.4 4.7-3.2 1.8-.8 3.7-1.2 5.7-1.2 2.1 0 3.9.5 5.5 1.4s2.9 2.1 4 3.6l-.1-4.1zM42 37.9c1.7 0 3.1-.4 4.4-1.2 1.3-.8 2.2-1.9 2.9-3.4.7-1.4 1-3 1-4.7s-.4-3.3-1.1-4.7-1.7-2.5-2.9-3.4c-1.2-.8-2.7-1.2-4.4-1.2-1.7 0-3.2.4-4.5 1.3-1.4.8-2.5 2-3.3 3.4s-1.2 3-1.2 4.7.4 3.3 1.2 4.7c.8 1.4 1.9 2.5 3.3 3.3 1.5.8 3 1.2 4.6 1.2zm38.6-3.1 5.3 2.9C84.6 39.5 83 41 81 42c-2 1.1-4.1 1.6-6.5 1.6-2.6 0-5-.7-7.2-2-2.2-1.4-3.9-3.2-5.2-5.4-1.3-2.3-1.9-4.8-1.9-7.6 0-2.1.4-4 1.1-5.9.7-1.8 1.8-3.4 3.1-4.8s2.8-2.5 4.6-3.2c1.7-.8 3.6-1.2 5.5-1.2 2.3 0 4.5.5 6.5 1.6s3.6 2.5 4.9 4.4l-5.3 2.9c-.8-1-1.7-1.7-2.8-2.2s-2.2-.8-3.3-.8c-1.6 0-3 .4-4.2 1.3-1.3.8-2.3 2-3 3.3-.7 1.4-1.1 2.9-1.1 4.5s.4 3.1 1.1 4.5c.7 1.4 1.7 2.5 3 3.3 1.3.8 2.7 1.3 4.2 1.3 1.2 0 2.3-.3 3.4-.8 1-.5 1.9-1.2 2.7-2zM91 42.9V14.3h5.9v3c1-1.2 2.2-2.1 3.6-2.8s3-1 4.7-1c2 0 3.9.5 5.6 1.5 1.7 1 3.1 2.3 4.1 3.9 1-1.6 2.4-2.9 4-3.9 1.7-1 3.5-1.5 5.6-1.5s4 .5 5.8 1.5c1.7 1 3.1 2.4 4.1 4.1s1.5 3.7 1.5 5.8v18H130V26.5c0-1.3-.3-2.4-.9-3.5-.6-1-1.4-1.9-2.5-2.5s-2.2-1-3.4-1c-1.3 0-2.4.3-3.4.9-1 .6-1.8 1.4-2.5 2.5-.6 1-.9 2.2-.9 3.6v16.4h-5.9V26.5c0-1.3-.3-2.5-.9-3.6-.6-1-1.4-1.9-2.5-2.5-1-.6-2.2-.9-3.4-.9s-2.4.3-3.4 1c-1 .6-1.9 1.5-2.5 2.5s-.9 2.2-.9 3.5v16.4H91zm62.8.7c-2.6 0-5-.7-7.2-2-2.2-1.4-3.9-3.2-5.2-5.4-1.3-2.3-1.9-4.8-1.9-7.6 0-2.1.4-4 1.1-5.9.7-1.8 1.8-3.4 3.1-4.8s2.8-2.5 4.6-3.2c1.7-.8 3.6-1.2 5.5-1.2 2.2 0 4.2.5 6 1.4s3.4 2.2 4.7 3.7c1.3 1.6 2.2 3.4 2.9 5.5.6 2.1.8 4.3.5 6.6h-22c.2 1.3.7 2.5 1.4 3.6s1.6 1.9 2.7 2.5c1.1.6 2.4.9 3.7.9 1.4 0 2.8-.4 4-1.1s2.2-1.7 2.9-3l6 1.4c-1.1 2.5-2.9 4.6-5.2 6.2-2.2 1.6-4.8 2.4-7.6 2.4zm-8.1-17.5h16.2c-.2-1.4-.7-2.6-1.4-3.7-.8-1.1-1.7-2-2.9-2.7s-2.4-1-3.8-1-2.6.3-3.8 1c-1.2.6-2.1 1.5-2.9 2.6-.7 1.2-1.2 2.5-1.4 3.8zM194.8 0h5.9v42.9h-5.9v-4.2c-.9 1.5-2.2 2.7-3.7 3.6s-3.3 1.4-5.3 1.4c-2.1 0-4-.4-5.8-1.2-1.8-.8-3.4-1.9-4.8-3.2-1.4-1.4-2.5-3-3.2-4.8-.8-1.8-1.2-3.8-1.2-5.8 0-2.1.4-4 1.2-5.8s1.9-3.4 3.2-4.8c1.4-1.4 3-2.5 4.8-3.2 1.8-.8 3.8-1.2 5.8-1.2s3.8.5 5.3 1.4 2.7 2.1 3.7 3.6V0zm-8.9 37.9c1.7 0 3.1-.4 4.4-1.2 1.3-.8 2.2-1.9 2.9-3.4.7-1.4 1-3 1-4.7s-.4-3.3-1.1-4.7-1.7-2.5-2.9-3.4c-1.2-.8-2.7-1.2-4.4-1.2-1.7 0-3.2.4-4.5 1.3-1.4.8-2.4 2-3.3 3.4-.8 1.4-1.2 3-1.2 4.7s.4 3.3 1.2 4.7c.8 1.4 1.9 2.5 3.3 3.3 1.5.8 3 1.2 4.6 1.2zm21.7-23.6h5.9v28.6h-5.9V14.3zm34.5 0h5.9v28.6h-6l-.2-4.1c-.8 1.5-2 2.6-3.4 3.5s-3.1 1.3-5.1 1.3c-2.1 0-4.1-.4-5.9-1.2s-3.5-1.9-4.9-3.3-2.5-3-3.3-4.9c-.8-1.8-1.2-3.8-1.2-5.9 0-2 .4-4 1.1-5.8.8-1.8 1.8-3.4 3.2-4.7 1.4-1.4 2.9-2.4 4.7-3.2 1.8-.8 3.7-1.2 5.7-1.2 2.1 0 3.9.5 5.5 1.4s2.9 2.1 4 3.6l-.1-4.1zm-8.9 23.6c1.7 0 3.1-.4 4.4-1.2 1.3-.8 2.2-1.9 2.9-3.4.7-1.4 1-3 1-4.7s-.4-3.3-1.1-4.7-1.7-2.5-2.9-3.4c-1.2-.8-2.7-1.2-4.4-1.2-1.7 0-3.2.4-4.5 1.3-1.4.8-2.5 2-3.3 3.4s-1.2 3-1.2 4.7.4 3.3 1.2 4.7c.8 1.4 1.9 2.5 3.3 3.3 1.5.8 3 1.2 4.6 1.2z"/>
                        <path d="M258.2 42.5c-1.5 0-2.7-.5-3.5-1.3-1-1-1.5-2-1.5-3.5 0-1.3.5-2.5 1.5-3.5s2.2-1.3 3.5-1.3c1.3 0 2.5.5 3.5 1.3 1 1 1.5 2 1.5 3.5 0 1.3-.5 2.5-1.3 3.5-.9 1-2.4 1.3-3.7 1.3z" style="fill: #e6e117"/>
                    </g>
                </switch>
            </svg>
        </span>
    </a>
</div>

<!-- Nav Container -->
{{-- ================================================ --}}
{{-- This is the SINGLE place navbars are rendered. --}}
{{-- Home page  → mobile nav only (desktop navbar --}}
{{--              was already included above) --}}
{{-- Inner pages → navbar-inner handles BOTH desktop --}}
{{--              and mobile in one include --}}
{{-- ================================================ --}}
<div class="nav-container loading__fade">
    @if($isHomePage ?? false)
        @include('layouts.navbar-mobile')
    @else
        @include('layouts.navbar-inner', [
            'pageTitle' => $pageTitle ?? 'Page',
            'pageIcon'  => $pageIcon  ?? 'ph ph-file',
        ])
    @endif

    <div class="translucent-element color-switcher-container">
        <button id="color-switcher" class="color-switcher" type="button" role="switch"
                aria-label="Toggle light/dark mode" aria-checked="true"></button>
    </div>
</div>

<main id="page-content" class="page-content">
    @yield('content')
    @include('layouts.footer')
</main>

<div class="bottom__background bottom-bg-03">
    <div class="bottom-bg-03__01 animate-card-2">
        <img src="{{ asset('img/backgrounds/1200x1200_bg01.webp') }}" alt="Background Objects"/>
    </div>
    <div class="bottom-bg-03__02 animate-card-2">
        <img src="{{ asset('img/backgrounds/1200x1200_bg02.webp') }}" alt="Background Objects"/>
    </div>
</div>

<div class="header-offset"></div>

<a href="#0" id="to-top" class="btn btn-to-top slide-up">
    <i class="ph ph-arrow-up"></i>
</a>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close link-s" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share link-s" title="Share"></button>
                <button class="pswp__button pswp__button--fs link-s" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom link-s" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left link-s" title="Previous (arrow left)"></button>
            <button class="pswp__button pswp__button--arrow--right link-s" title="Next (arrow right)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

{{-- Engagement Modal --}}
<x-engagement-modal />

<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
<script src="{{ asset('js/libs.min.js') }}"></script>
<script src="{{ asset('js/modal.js') }}"></script>
<script src="{{ asset('js/gallery-init.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const menuDropdown = document.getElementById('menu-dropdown');

    if (menuToggle && menuDropdown) {
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            menuToggle.classList.toggle('active');
            menuDropdown.classList.toggle('show');
        });
        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !menuDropdown.contains(e.target)) {
                menuToggle.classList.remove('active');
                menuDropdown.classList.remove('show');
            }
        });
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                menuDropdown.classList.remove('show');
            });
        });
    }
</script>

<script type="text/javascript">
    (function (C, A, L) {
        let p = function (a, ar) { a.q.push(ar); };
        let d = C.document;
        C.Cal = C.Cal || function () {
            let cal = C.Cal; let ar = arguments;
            if (!cal.loaded) { cal.ns = {}; cal.q = cal.q || []; d.head.appendChild(d.createElement("script")).src = A; cal.loaded = true; }
            if (ar[0] === L) { const api = function () { p(api, arguments); }; const namespace = ar[1]; api.q = api.q || []; if(typeof namespace === "string"){cal.ns[namespace] = cal.ns[namespace] || api;p(cal.ns[namespace], ar);p(cal, ["initNamespace", namespace]);} else p(cal, ar); return; }
            p(cal, ar);
        };
    })(window, "https://app.cal.com/embed/embed.js", "init");

    Cal("init", "15min", {origin: "https://app.cal.com"});
    Cal.ns["15min"]("inline", {
        elementOrSelector: "#my-cal-inline-15min",
        config: {"layout": "month_view", "useSlotsViewOnSmallScreen": "true"},
        calLink: "peter-adetola-pwjdgz/15min",
    });
    Cal.ns["15min"]("ui", {
        "hideEventTypeDetails": true,
        "layout": "month_view",
        "cssVarsPerTheme": {
            "light": {
                "cal-brand": "#383838", "cal-bg": "#babec8", "cal-bg-subtle": "#d8dde7",
                "cal-bg-muted": "#989ba3", "cal-border": "#8f93a1",
                "cal-text": "#151617", "cal-text-muted": "#44474a"
            },
            "dark": {
                "cal-brand": "#E6E200", "cal-bg": "#141414", "cal-bg-subtle": "#242424",
                "cal-bg-muted": "#000000", "cal-border": "#535762",
                "cal-text": "#f2f5fc", "cal-text-muted": "#aeb5c5"
            }
        }
    });
</script>
<script>
    (function () {
        var isChromeIOS = /CriOS/i.test(navigator.userAgent);
        window._loaderChromeIOS = isChromeIOS;

        /* Light mode fill — all browsers */
        var scheme = document.documentElement.getAttribute('color-scheme')
            || (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
        if (scheme === 'light') {
            var polys = document.querySelectorAll('#loader-logo polygon');
            for (var i = 0; i < polys.length; i++) {
                polys[i].setAttribute('fill', '#888b95');
            }
        }

        /* No hiding of bar/percent — let everything run on Chrome iOS too */
    })();
</script>
<script>
    (function () {

        /* ── SVG frame data — exact Illustrator coordinates ── */
        var F = [
            { /* Frame 1 — closed */
                tl: [[2.6,57.5],[99,57.4],[99,138.3],[2.6,138.3]],
                bl: [[2.6,158.2],[99,158.2],[99,236.2],[2.6,236.5]],
                tr: [[216.5,57.4],[216.5,138.3],[120.2,138.3],[120.2,57.3]],
                br: [[120.2,158.2],[216.5,158.2],[216.5,236.3],[120.2,236.2]]
            },
            { /* Frame 2 — opening */
                tl: [[2.6,57.5],[99,57.4],[99,138.3],[2.6,138.3]],
                bl: [[2.6,158.2],[99,158.2],[99,236.2],[2.6,236.5]],
                tr: [[216.5,57.4],[216.5,138.3],[120.2,138.3],[120.2,42.3]],
                br: [[120.2,158.2],[216.5,158.2],[216.5,236.3],[120.2,261.2]]
            },
            { /* Frame 3 — fully open */
                tl: [[2.6,26.5],[99,2.4],[99,138.3],[2.6,138.3]],
                bl: [[2.6,158.2],[99,158.2],[99,351.2],[2.6,260.5]],
                tr: [[216.5,57.4],[216.5,138.3],[120.2,138.3],[120.2,42.3]],
                br: [[120.2,158.2],[216.5,158.2],[216.5,236.3],[120.2,248.2]]
            }
        ];

        var els = {
            tl: document.getElementById('l-tl'),
            bl: document.getElementById('l-bl'),
            tr: document.getElementById('l-tr'),
            br: document.getElementById('l-br')
        };

        var bar    = document.getElementById('loader-bar');
        var label  = document.getElementById('loader-percent');
        var loader = document.getElementById('loader');

        /* ── Helpers ── */
        function pts(arr) {
            return arr.map(function (p) { return p[0].toFixed(2) + ',' + p[1].toFixed(2); }).join(' ');
        }

        function lerp2(a, b, t) {
            return a.map(function (p, i) {
                return [a[i][0] + (b[i][0] - a[i][0]) * t,
                    a[i][1] + (b[i][1] - a[i][1]) * t];
            });
        }

        function eio(t) { return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t; }

        function setFrame(f) {
            els.tl.setAttribute('points', pts(f.tl));
            els.bl.setAttribute('points', pts(f.bl));
            els.tr.setAttribute('points', pts(f.tr));
            els.br.setAttribute('points', pts(f.br));
        }

        /* All 4 panels morph simultaneously */
        function morphAll(fA, fB, dur, done) {
            var start = null;
            function step(ts) {
                if (!start) start = ts;
                var t = Math.min((ts - start) / dur, 1);
                var e = eio(t);
                setFrame({
                    tl: lerp2(fA.tl, fB.tl, e),
                    bl: lerp2(fA.bl, fB.bl, e),
                    tr: lerp2(fA.tr, fB.tr, e),
                    br: lerp2(fA.br, fB.br, e)
                });
                if (t < 1) requestAnimationFrame(step);
                else if (done) done();
            }
            requestAnimationFrame(step);
        }

        /* ── Bar & percent ── */
        var barCur = 0, barRaf = null;

        function setBar(to) {
            var from = barCur; barCur = to;
            if (bar)   bar.style.width = to + '%';
            if (!label) return;
            var start = null;
            if (barRaf) cancelAnimationFrame(barRaf);
            (function count(ts) {
                if (!start) start = ts;
                var p = Math.min((ts - start) / 500, 1);
                label.textContent = Math.round(from + (to - from) * (1 - Math.pow(1 - p, 3))) + '%';
                if (p < 1) barRaf = requestAnimationFrame(count);
            })(performance.now());
        }

        /* ── Animation loop ── */
        var animating = true;

        function openClose() {
            if (!animating) return;
            morphAll(F[0], F[1], 480, function () {
                if (!animating) return;
                morphAll(F[1], F[2], 480, function () {
                    if (!animating) return;
                    setTimeout(function () {
                        if (!animating) return;
                        morphAll(F[2], F[1], 380, function () {
                            if (!animating) return;
                            morphAll(F[1], F[0], 380, function () {
                                setTimeout(function () { openClose(); }, 400);
                            });
                        });
                    }, 600);
                });
            });
        }

        /* ── Simulated progress ── */
        var simDone = false;
        var simInterval = setInterval(function () {
            if (simDone) return;
            var step = Math.random() * 10 + 4;
            barCur = Math.min(barCur + step, 90);
            setBar(Math.round(barCur));
        }, 450);

        function finish() {
            animating = false;
            simDone   = true;
            clearInterval(simInterval);

            setBar(100);

            setTimeout(function () {
                setFrame(F[0]);
                loader.classList.remove('active');
                document.body.classList.add('page-ready');

                setTimeout(function () {
                    if (loader && loader.parentNode) {
                        loader.parentNode.removeChild(loader);
                    }
                }, 600);
            }, 350);
        }

        /* Set initial frame always */
        setFrame(F[0]);
        openClose();


        /* ── Dismissal: both window.load AND 1.5s minimum must pass ── */
        var pageLoaded  = false;
        var minTimeDone = false;
        var dismissed   = false;

        function tryFinish() {
            if (!dismissed && pageLoaded && minTimeDone) {
                dismissed = true;
                finish();
            }
        }

        setTimeout(function () {
            minTimeDone = true;
            tryFinish();
        }, 1500);

        if (document.readyState === 'complete') {
            pageLoaded = true;
        } else {
            window.addEventListener('load', function () {
                pageLoaded = true;
                tryFinish();
            }, { once: true });
        }

        /* Hard fallback — 12s max for very slow connections */
        setTimeout(function () {
            if (!dismissed) { dismissed = true; finish(); }
        }, 12000);

    })();
</script>

@stack('scripts')
<x-cookie-consent />
</body>
</html>
