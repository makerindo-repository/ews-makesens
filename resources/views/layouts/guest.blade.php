<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="relative min-h-screen flex flex-col justify-center items-center md:items-start pt-6 sm:pt-0">
        <!-- Layer 1: Background image -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/bgLogin.jpg') }}" alt="Background" class="w-full h-full object-cover">
        </div>

        <!-- Layer 2: Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/100 via-blue-900/60 to-transparent"></div>

        <!-- Layer 3: Content -->
        <div class="relative z-10 flex flex-col justify-center w-full gap-5 sm:max-w-xl px-6 md:ms-20">
            <div>
                <a href="/">
                    <img src="{{ asset('images/logoMakesens.png') }}" alt="Logo"
                        class="h-auto w-52 object-contain filter brightness-0 invert">
                </a>
            </div>
            <div>
                <h1 class="text-white text-5xl font-bold">Welcome to EWS</h1>
                <p class="text-white font-extralight">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, dolor.</p>
            </div>
            <div class="w-full px-6 py-8 md:px-12 md:py-10 bg-white shadow-xl rounded-lg backdrop-blur">
                {{ $slot }}
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
