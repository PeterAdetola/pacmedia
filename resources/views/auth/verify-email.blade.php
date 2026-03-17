<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{{ $metaDescription ?? 'Pacmedia - Tactical Digital Solutions. Brand Strategy, Development & Intelligent Automation.' }}">
    <meta name="keywords"    content="{{ $metaKeywords ?? 'brand strategy, digital experience design, web development, AI automation systems, brand identity systems, conversion-focused design, custom development, intelligent customer operations, digital presence strategy, tactical digital solutions' }}">
    <meta name="author"      content="Pacmedia Creatives">

    <link rel="apple-touch-icon" href="{{ asset('admin/assets/images/favicon/icon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/images/favicon/icon_bg.png') }}">

    <title>{{ $title ?? 'Authentication' }} | Pacmedia Creatives</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendors/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/themes/vertical-modern-menu-template/materialize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/themes/vertical-modern-menu-template/style.css') }}">

    {{-- Optional per-page CSS passed via named slot --}}
    {{ $pageCss ?? '' }}

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/custom/custom.css') }}">

    <style type="text/css">
        form:invalid button {
            pointer-events: none;
        }

        /* ── Full-page centering ── */
        html, body {
            height: 100%;
        }

        .auth-page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .auth-page-wrapper > .row {
            width: 100%;
            margin-bottom: 0;
        }

        {{ $inlineStyles ?? '' }}
    </style>
</head>

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column blank-page {{ $bodyClass ?? 'login-bg' }}"
      data-open="click" data-menu="vertical-modern-menu" data-col="1-column">

<div class="auth-page-wrapper">
    <div class="row" style="width:100%;">
        <div class="col s12">
            <div class="container">
                {{ $slot }}
            </div>
        </div>
    </div>
    <div class="content-overlay"></div>
</div>

<script src="{{ asset('admin/assets/js/vendors.min.js') }}"></script>
{{ $pageVendorJs ?? '' }}
<script src="{{ asset('admin/assets/js/plugins.js') }}"></script>
<script src="{{ asset('admin/assets/js/search.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/custom-script.js') }}"></script>
{{ $pageLevelJs ?? '' }}

<script type="text/javascript">
    function ShowPreloader() {
        var el = document.getElementById('preloader');
        if (el) el.style.display = 'block';
    }
    {{ $inlineScripts ?? '' }}
</script>

</body>
</html>
