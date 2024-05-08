<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title') - Top Popular</title>
        
        @yield('head')
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('storage/images/icon/main.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js' ])

        {{-- Yields --}}
    </head>
    <body class="font-sans text-gray-900 antialiased h-[calc(screen - 64px)] bg-main">
        <x-nav-layout :search="false" />
        <x-admin.sidebar />

        <div class="mt-16 sm:ml-64 p-4">
            @if (isset($header))
                {{ $header }}
            @endif
            {{ $slot }}
        </div>
    </body>
</html>
