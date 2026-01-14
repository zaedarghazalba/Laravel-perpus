<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Ensure proper spacing for sidebar layout */
            @media (min-width: 1024px) {
                body {
                    padding-left: 0;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl border-r border-gray-200 transform transition-transform duration-300 lg:translate-x-0 -translate-x-full">
                <!-- Logo -->
                <div class="h-16 flex items-center px-6 border-b border-gray-200">
                    <a href="{{ route('admin.books.index') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 bg-primary-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-900">{{ config('app.name', 'Laravel') }}</div>
                            <div class="text-xs text-gray-500 font-semibold -mt-0.5">Admin Panel</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Kategori
                    </a>

                    <a href="{{ route('admin.classifications.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.classifications.*') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Klasifikasi
                    </a>

                    <a href="{{ route('admin.books.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.books.index') || request()->routeIs('admin.books.create') || request()->routeIs('admin.books.edit') || request()->routeIs('admin.books.show') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Buku
                    </a>

                    <a href="{{ route('admin.books.lookup') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.books.lookup') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z M3 10h18M3 14h18M3 6h18M3 18h18"></path>
                        </svg>
                        Book Lookup
                    </a>

                    <a href="{{ route('admin.ebooks.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.ebooks.*') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Ebook
                    </a>

                    <a href="{{ route('admin.book-requests.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.book-requests.*') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span class="flex-1">Permintaan Buku</span>
                        @php
                            $pendingCount = \App\Models\BookRequest::pending()->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.members.*') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 4 0 014 0z"></path>
                        </svg>
                        Anggota
                    </a>

                    <a href="{{ route('admin.borrowings.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.borrowings.*') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Peminjaman
                    </a>

                    <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-primary-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m3.243-9.743a4 4 0 115.657 5.657m-5.657-5.657a4 4 0 100 5.657m5.657-5.657a4 4 0 100 5.657M13 21h8m-1-4l1 4-1 4m-5-4l1 4-1 4M5 21h2a2 2 0 002-2v-3a2 2 0 00-2-2H5a2 2 0 00-2 2v3a2 2 0 002 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m3.243-9.743a4 4 0 115.657 5.657m-5.657-5.657a4 4 0 100 5.657m5.657-5.657a4 4 0 100 5.657M13 21h8m-1-4l1 4-1 4m-5-4l1 4-1 4M5 21h2a2 2 0 002-2v-3a2 2 0 00-2-2H5a2 2 0 00-2 2v3a2 2 0 002 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m3.243-9.743a4 4 0 115.657 5.657m-5.657-5.657a4 4 0 100 5.657m5.657-5.657a4 4 0 100 5.657M13 21h8m-1-4l1 4-1 4m-5-4l1 4-1 4M5 21h2a2 2 0 002-2v-3a2 2 0 00-2-2H5a2 2 0 00-2 2v3a2 2 0 002 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6a2 2 0 00-2-2H5a2 2 0 00-2 2v13a2 2 0 01-2 2h20a2 2 0 01-2-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v13"></path>
                        </svg>
                        Laporan
                    </a>
                </nav>

                <!-- User Section -->
                <div class="border-t border-gray-200 p-4">
                    <div class="flex items-center space-x-3 px-3 py-2">
                        <div class="flex items-center justify-center w-9 h-9 rounded-full text-white font-bold shadow-md bg-primary-500">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 font-semibold">Administrator</div>
                        </div>
                        <button id="user-menu-button" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- User Dropdown -->
                    <div id="user-menu-dropdown" class="hidden mt-2 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="min-h-screen transition-all duration-300 lg:ml-64">
            <!-- Top Header -->
            <header class="bg-white shadow-sm sticky top-0 z-40 border-b border-gray-200">
                <div class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                        <svg id="menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="close-icon" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <!-- Page Title (Optional) -->
                    <div class="flex-1 lg:hidden"></div>

                    <!-- Public Site Link -->
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors duration-200" target="_blank">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <span class="hidden sm:inline">Lihat Situs</span>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8 w-full">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="mb-6 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 shadow-lg overflow-hidden animate-fade-in">
                        <div class="flex items-start p-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 shadow-md">
                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-semibold text-green-900 mb-1">Success!</p>
                                <p class="text-sm text-green-800">{{ session('success') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-green-600 hover:text-green-800 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 shadow-lg overflow-hidden animate-fade-in">
                        <div class="flex items-start p-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-pink-600 shadow-md">
                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-semibold text-red-900 mb-1">Error!</p>
                                <p class="text-sm text-red-800">{{ session('error') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-600 hover:text-red-800 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Backdrop for mobile sidebar -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Barcode Scanner Modal -->
        @include('components.barcode-scanner-modal')

        <!-- JavaScript for Navigation -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sidebar and Mobile Menu Toggle
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                const menuIcon = document.getElementById('menu-icon');
                const closeIcon = document.getElementById('close-icon');

                function toggleSidebar() {
                    sidebar.classList.toggle('-translate-x-full');
                    backdrop.classList.toggle('hidden');
                    menuIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                }

                if (mobileMenuButton) {
                    mobileMenuButton.addEventListener('click', toggleSidebar);
                }

                if (backdrop) {
                    backdrop.addEventListener('click', toggleSidebar);
                }

                // User Dropdown Toggle
                const userMenuButton = document.getElementById('user-menu-button');
                const userMenuDropdown = document.getElementById('user-menu-dropdown');

                if (userMenuButton && userMenuDropdown) {
                    userMenuButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        userMenuDropdown.classList.toggle('hidden');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!userMenuButton.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                            userMenuDropdown.classList.add('hidden');
                        }
                    });
                }
            });
        </script>

        <!-- Barcode Scanner Library (html5-qrcode) -->
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

        <!-- Barcode Scanner Component -->
        <script src="{{ asset('js/barcode-scanner.js') }}?v={{ time() }}"></script>
    </body>
</html>
