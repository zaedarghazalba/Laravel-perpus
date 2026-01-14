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
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Custom background pattern */
            .bg-pattern {
                background-color: #f5f3ff; /* brand-50 */
                background-image: radial-gradient(#ddd6fe 1px, transparent 1px);
                background-size: 24px 24px;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-brand-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-pattern relative">
            
            <!-- Abstract shapes for visual interest -->
            <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-brand-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-20 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

            <div class="relative z-10 flex flex-col items-center">
                <a href="/" class="mb-6 scale-100 hover:scale-105 transition-transform duration-300">
                    <x-application-logo class="w-16 h-16 fill-current text-brand-600" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/80 backdrop-blur-xl shadow-2xl ring-1 ring-gray-900/5 sm:rounded-2xl relative z-10 animate-fade-in">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
