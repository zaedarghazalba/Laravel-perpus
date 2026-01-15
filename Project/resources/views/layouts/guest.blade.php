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
            /* Custom background gradient */
            .bg-pattern {
                background: linear-gradient(135deg, #007FFF 0%, #0284c7 50%, #0369a1 100%);
                position: relative;
                overflow: hidden;
            }

            .bg-pattern::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image:
                    radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 90%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
                animation: bgShift 15s ease infinite;
            }

            @keyframes bgShift {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.8; }
            }

            @keyframes blob {
                0%, 100% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
            }

            .animate-blob {
                animation: blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }

            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.6s ease-out;
            }

            /* Floating books decoration */
            .floating-book {
                position: absolute;
                opacity: 0.1;
                animation: float 20s infinite ease-in-out;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(5deg); }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-brand-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-pattern relative">

            <!-- Floating book decorations -->
            <svg class="floating-book w-24 h-24 text-white top-20 left-10" fill="currentColor" viewBox="0 0 24 24" style="animation-delay: 0s;">
                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <svg class="floating-book w-20 h-20 text-white top-40 right-20" fill="currentColor" viewBox="0 0 24 24" style="animation-delay: 3s;">
                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <svg class="floating-book w-16 h-16 text-white bottom-32 left-1/4" fill="currentColor" viewBox="0 0 24 24" style="animation-delay: 6s;">
                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>

            <!-- Glowing orbs -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-cyan-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/3 w-72 h-72 bg-sky-400 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

            <!-- Logo -->
            <div class="relative z-10 flex flex-col items-center">
                <a href="/" class="mb-6 p-4 bg-white rounded-2xl shadow-xl transform hover:scale-105 hover:rotate-3 transition-all duration-300">
                    <x-application-logo class="w-16 h-16 fill-current text-primary-500" />
                </a>
            </div>

            <!-- Main card with enhanced styling -->
            <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white shadow-2xl ring-1 ring-gray-900/5 sm:rounded-3xl relative z-10 animate-fade-in">
                {{ $slot }}
            </div>

            <!-- Footer text -->
            <p class="mt-8 text-white/80 text-sm font-medium relative z-10">
                Digital Library Management System
            </p>
        </div>
    </body>
</html>
