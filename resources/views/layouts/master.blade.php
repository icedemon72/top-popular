<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased h-[calc(100vh_-_64px)] bg-main">
        <x-nav-layout />
        <x-sidebar />

        {{-- OVDE SAM STAO --}}
        <div class="flex flex-col justify-between min-h-full mt-16 sm:ml-64 ">
            <div class="p-4">
                @if (isset($header))
                    {{ $header }}
                @endif
                {{ $slot }}
            </div>
            <x-footer />
        </div>
    </body>
</html>
