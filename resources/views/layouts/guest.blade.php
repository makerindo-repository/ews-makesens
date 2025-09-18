<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Layer 1: Background image -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/bgLogin.jpg') }}" alt="Background" class="w-full h-full object-cover">
        </div>

        <!-- Layer 2: Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 via-blue-900/40 to-transparent"></div>

        <!-- Layer 3: Content -->
        <div class="relative z-10 flex flex-col items-center w-full sm:max-w-md px-6">
            <div class="mt-6 w-full px-6 py-6 bg-white shadow-xl rounded-lg backdrop-blur">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
