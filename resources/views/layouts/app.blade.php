<!-- ACTIVE PROJECT: laravel-template-vite -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <link rel="apple-touch-icon" href="/favicon/apple-touch-icon.png">

        <title>{{ config('app.name', 'Pacmedia') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>
        <footer class="w-full  text-xs text-gray-500  bg-gray-100">
            <div class="flex items-center justify-between px-6 py-4">
        <span>
            © {{ now()->year }} Pacmedia Creatives. All rights reserved.
        </span>

                <span class="text-[#245624] font-medium">
            Design & Developed by Pacmedia
        </span>
            </div>
        </footer>
    </body>
</html>
