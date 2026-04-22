<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="{{ asset('admin/assets/') }}"
    data-template="vertical-menu-template-bordered">
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

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/pickr/pickr-themes.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

    <!-- Algolia — required by template before helpers -->
    <script src="{{ asset('admin/assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

    <!-- Helpers — must load before config in <head> -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
{{--    <script src="{{ asset('admin/assets/vendor/js/template-customizer.js') }}"></script>--}}
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>

    <!-- Brand overrides -->
    <style>
        :root {
            --pac-peridot:      #b5cc18;
            --pac-peridot-dim:  #96aa12;
            --pac-metal:        #6b7280;
            --pac-ink:          #111827;
            --pac-ink-soft:     #374151;
        }

        /* ── Sidebar brand text ── */
        .app-brand-text { font-weight: 700; letter-spacing: -0.01em; }

        /* ── Logo — 2x bigger ── */
        .app-brand-logo svg {
            width: 2.25rem !important;
            height: 2.25rem !important;
        }

        /* ── Active menu item — dark background, peridot text ── */
        .menu-vertical .menu-item.active > .menu-link {
            background-color: #1f2937 !important;
            border-radius: 0.375rem;
        }
        .menu-vertical .menu-item.active > .menu-link .menu-icon {
            color: var(--pac-peridot) !important;
        }
        .menu-vertical .menu-item.active > .menu-link div,
        .menu-vertical .menu-item.active > .menu-link span {
            color: var(--pac-peridot) !important;
            font-weight: 600;
        }

        /* ── Hover state — subtle ink tint ── */
        .menu-vertical .menu-item > .menu-link:hover:not(.active) {
            background-color: rgba(17, 24, 39, 0.06) !important;
        }

        /* ── Page background — matches template default #f7f7f9 ── */
        body,
        .layout-page,
        .content-wrapper,
        .container-xxl { background-color: #f7f7f9 !important; }

        /* ── Peridot focus rings ── */
        :focus-visible { outline-color: var(--pac-peridot) !important; }



        /* Pac navbar search bar */
        .pac-search-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0,0,0,0.03);
            border: 1px solid var(--bs-border-color);
            border-radius: 0.5rem;
            padding: 0.375rem 0.875rem;
            width: 260px;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .pac-search-bar:focus-within {
            border-color: var(--pac-peridot);
            box-shadow: 0 0 0 3px rgba(181,204,24,0.12);
            background: #fff;
        }
        .pac-search-icon {
            font-size: 1rem;
            color: #9ca3af;
            flex-shrink: 0;
        }
        .pac-search-input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.82rem;
            color: var(--bs-body-color);
            flex: 1;
            min-width: 0;
        }
        .pac-search-input::placeholder { color: #9ca3af; }
        .pac-kbd {
            font-size: 0.67rem;
            font-family: ui-monospace, monospace;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 1px 6px;
            color: #9ca3af;
            flex-shrink: 0;
        }
        .pac-shortcut-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.3rem;
            padding: 0.65rem 0.25rem;
            border-radius: 0.5rem;
            border: 1px solid #f0f0f0;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
            text-align: center;
        }
        .pac-shortcut-item:hover {
            background: color-mix(in sRGB, var(--pac-peridot) 8%, white);
            border-color: rgba(181,204,24,0.4);
        }
        .pac-shortcut-item i   { font-size: 1.2rem; color: var(--pac-peridot-dim); }
        .pac-shortcut-item span { font-size: 0.68rem; color: #374151; font-weight: 600; }
        /* Dark mode */
        [data-bs-theme="dark"] .pac-search-bar { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); }
        [data-bs-theme="dark"] .pac-search-bar:focus-within { background: rgba(255,255,255,0.08); }
        [data-bs-theme="dark"] .pac-kbd { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.12); color: #6b7280; }
        [data-bs-theme="dark"] .pac-shortcut-item { border-color: rgba(255,255,255,0.08); }
        [data-bs-theme="dark"] .pac-shortcut-item:hover { background: rgba(181,204,24,0.1); border-color: rgba(181,204,24,0.3); }
        [data-bs-theme="dark"] .pac-shortcut-item span { color: rgba(255,255,255,0.75); }

        /* ── Responsive logo swap ── */
        .pac-logo-full {
            height: 2.25rem;      /* ← was 1.75rem, now matches the mark */
            width: auto;
            display: block;
            max-width: 180px;     /* ← slightly wider allowance for the taller height */
            object-fit: contain;
        }
        .pac-logo-mark {
            height: 2.25rem;      /* ← same value */
            width: auto;
            display: none;
            object-fit: contain;
        }

        /* Collapsed state — html element gets this class from menu.js */
        .layout-menu-collapsed .pac-logo-full { display: none; }
        .layout-menu-collapsed .pac-logo-mark { display: block; }

        /* Hovering the collapsed sidebar (template expands it temporarily) */
        .layout-menu-collapsed:not(.layout-menu-hover) .pac-logo-full { display: none; }
        .layout-menu-collapsed:not(.layout-menu-hover) .pac-logo-mark { display: block; }
        .layout-menu-collapsed.layout-menu-hover .pac-logo-full  { display: block; }
        .layout-menu-collapsed.layout-menu-hover .pac-logo-mark  { display: none; }

        /* Mobile — always show full logo */
        @media (max-width: 1199px) {
            .pac-logo-full { display: block !important; }
            .pac-logo-mark { display: none  !important; }
        }
    </style>

    {{-- Page-specific CSS injected here --}}
    @stack('page-css')
</head>

<body>

{{-- ─── Layout wrapper ─────────────────────────────────────── --}}
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        {{-- ─── Sidebar ──────────────────────────────────────────── --}}
        @include('components.admin.sidebar')
        {{-- ─── / Sidebar ─────────────────────────────────────────── --}}

        {{-- Mobile menu toggler --}}
        <div class="menu-mobile-toggler d-xl-none rounded-1">
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                <i class="ri ri-menu-line icon-base"></i>
                <i class="ri ri-arrow-right-s-line icon-base"></i>
            </a>
        </div>

        {{-- ─── Layout page ───────────────────────────────────────── --}}
        <div class="layout-page">

            {{-- ─── Navbar ────────────────────────────────────────── --}}
            @include('components.admin.navbar')
            {{-- ─── / Navbar ──────────────────────────────────────── --}}

            {{-- ─── Content wrapper ──────────────────────────────── --}}
            <div class="content-wrapper">

                {{-- Content --}}
                <div class="container-xxl flex-grow-1 container-p-y">

                    {{-- Page header: title + optional breadcrumb --}}
                    @if(isset($title) || isset($breadcrumbs))
                        <div class="d-flex align-items-center justify-content-between py-3 mb-4">
                            <div>
                                @isset($title)
                                    <h4 class="mb-0 fw-semibold" style="color: var(--pac-ink);">
                                        {{ $title }}
                                    </h4>
                                @endisset
                                @isset($breadcrumbs)
                                    <nav aria-label="breadcrumb" class="mt-1">
                                        <ol class="breadcrumb breadcrumb-style1 mb-0" style="font-size: 0.8rem;">
                                            @foreach($breadcrumbs as $crumb)
                                                @if($loop->last)
                                                    <li class="breadcrumb-item active">{{ $crumb['name'] }}</li>
                                                @else
                                                    <li class="breadcrumb-item">
                                                        <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    </nav>
                                @endisset
                            </div>

                            {{-- Optional page-level actions slot --}}
                            @isset($actions)
                                <div class="d-flex gap-2">{{ $actions }}</div>
                            @endisset
                        </div>
                    @endif

                    {{-- Main page content --}}
                    {{ $slot }}

                </div>
                {{-- / Content --}}

                {{-- ─── Footer ─────────────────────────────────── --}}
                @include('components.admin.footer')
                {{-- ─── / Footer ───────────────────────────────── --}}

                <div class="content-backdrop fade"></div>
            </div>
            {{-- ─── / Content wrapper ─────────────────────────────── --}}

        </div>
        {{-- ─── / Layout page ─────────────────────────────────────── --}}

    </div>

    {{-- Overlay for mobile sidebar --}}
    <div class="layout-overlay layout-menu-toggle"></div>

    {{-- Drag target for mobile slide-in menu --}}
    <div class="drag-target"></div>

</div>
{{-- ─── / Layout wrapper ───────────────────────────────────── --}}

{{-- ─── Core JS ────────────────────────────────────────────── --}}
<script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/pickr/pickr.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('admin/assets/js/main.js') }}"></script>

{{-- DataTables — must come after jQuery, before page-js --}}
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

{{-- Session timeout — auto logout after configured session lifetime --}}
<script>
    (function () {
        var timeout  = {{ config('session.lifetime') * 60 * 1000 }};
        var warnAt   = timeout - (2 * 60 * 1000);

        function resetTimer() {
            clearTimeout(window._pacWarn);
            clearTimeout(window._pacLogout);

            window._pacWarn = setTimeout(function () {
                if (confirm('Your session will expire in 2 minutes due to inactivity. Click OK to stay logged in.')) {
                    fetch('{{ route("admin.ping") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                    resetTimer();
                }
            }, warnAt);

            window._pacLogout = setTimeout(function () {
                var f = document.createElement('form');
                f.method = 'POST';
                f.action = '{{ route("logout") }}';
                var t = document.createElement('input');
                t.type = 'hidden'; t.name = '_token'; t.value = '{{ csrf_token() }}';
                f.appendChild(t);
                document.body.appendChild(f);
                f.submit();
            }, timeout);
        }

        ['mousemove','keydown','click','scroll','touchstart'].forEach(function(e) {
            document.addEventListener(e, resetTimer, { passive: true });
        });

        resetTimer();
    })();
</script>
<x-admin.pac-ui />
@stack('page-js')
{{--@include('components.admin.notifications')--}}
</body>
</html>
