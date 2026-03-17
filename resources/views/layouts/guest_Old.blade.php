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

    <!-- Scripts -->
    {{-- Vite is default in main branch --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Animated Gradient CSS -->
    <style>
        .animated-gradient {
            width: 100%;
            height: 0.2em;
            background-image: linear-gradient(
                90deg,
                #eef0f1,
                #245624,
                #eef0f1
            )
        ;
            background-size: 200% 100%;
            animation: gradient-animation 10s ease-in-out infinite;
        }

        @keyframes gradient-animation {
            0%   { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col bg-gray-100">

    <!-- CENTERED CONTENT -->
    <div class="flex-1 flex flex-col justify-center items-center px-4">

        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <!-- Card -->
        <div class="w-full sm:max-w-md bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

    </div>

    <!-- FOOTER -->
    <div class="pb-4 text-center text-sm text-gray-500">
        Made with ❤️ by <span class="font-medium">thepacmedia</span>
    </div>

</div>
</body>

</html>
