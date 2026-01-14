@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-white border-b border-gray-100">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
        <div class="text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-600 mb-6 leading-tight animate-slide-up">
                Jelajahi Dunia Pengetahuan <br>
                <span class="text-gray-900">Tanpa Batas</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed animate-slide-up animation-delay-100">
                Akses ribuan ebook berkualitas tinggi untuk mendukung pembelajaran dan pengembangan diri Anda kapan saja, di mana saja.
            </p>

            <!-- Search Book Box (Admin Style) -->
            <div class="max-w-2xl mx-auto mb-16 animate-fade-in-up animation-delay-150 relative z-20">
                <form action="{{ route('books.search') }}" method="GET">
                    <div class="flex gap-3">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                name="q"
                                class="w-full px-4 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400 shadow-sm"
                                placeholder="Cari buku berdasarkan judul, penulis, atau ISBN..."
                                autocomplete="off"
                            >
                        </div>
                        <button 
                            type="submit" 
                            class="px-8 py-4 bg-gray-900 text-white border border-gray-900 rounded-lg font-bold hover:bg-black hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
                        >
                            Cari
                        </button>
                    </div>

                    <!-- Clean Helper Text/Tags (Optional, kept minimal) -->
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">
                             Tidak menemukan buku? 
                             @auth
                                <a href="{{ route('book-requests.create') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">Request di sini</a>
                             @else
                                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">Login untuk request</a>
                             @endauth
                        </p>
                    </div>
                </form>
            </div>

                    <!-- Clean Helper Text/Tags -->
                    <div class="mt-6 text-center">
                        <div class="inline-flex items-center gap-4 text-sm text-gray-500 bg-white/50 backdrop-blur-sm px-6 py-2 rounded-full border border-white/60 shadow-sm">
                            <span class="font-medium text-gray-400 uppercase tracking-wider text-xs">Trending</span>
                            <a href="{{ route('books.search', ['q' => 'Investasi']) }}" class="hover:text-blue-600 transition-colors">Investasi</a>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <a href="{{ route('books.search', ['q' => 'Sejarah']) }}" class="hover:text-blue-600 transition-colors">Sejarah</a>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <a href="{{ route('books.search', ['q' => 'Psikologi']) }}" class="hover:text-blue-600 transition-colors">Psikologi</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 mt-6 justify-center items-center animate-fade-in-up animation-delay-200">
                <a href="{{ route('ebooks.index') }}" class="group inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-2xl hover:bg-black hover:scale-105 transform transition-all duration-200">
                    <span>Jelajahi Ebook</span>
                </a>
                <a href="#statistics" class="inline-flex items-center px-8 py-4 bg-white text-gray-900 font-bold rounded-xl border-2 border-gray-200 hover:bg-gray-50 hover:border-gray-900 hover:scale-105 transform transition-all duration-200">>
                    Lihat Statistik
                </a>
            </div>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
            <defs>
                <linearGradient id="paint0_linear" x1="720" y1="60" x2="720" y2="120" gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" stop-opacity="0.5"/>
                    <stop offset="1" stop-color="white" stop-opacity="0"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
</div>

<!-- Statistics Section -->
<div id="statistics" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 mb-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Card 1 -->
        <div class="group bg-white border border-gray-200 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gray-100 rounded-xl">
                    <svg class="h-8 w-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-gray-900">{{ $stats['total_ebooks'] }}</div>
                    <div class="text-gray-500 text-sm font-medium mt-1">Total Ebook</div>
                </div>
            </div>
            <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gray-900 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="group bg-white border border-gray-200 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gray-100 rounded-xl">
                    <svg class="h-8 w-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-gray-900">{{ $stats['total_books'] }}</div>
                    <div class="text-gray-500 text-sm font-medium mt-1">Buku Fisik</div>
                </div>
            </div>
            <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gray-900 rounded-full" style="width: 85%"></div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="group bg-white border border-gray-200 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gray-100 rounded-xl">
                    <svg class="h-8 w-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-gray-900">{{ $stats['total_categories'] }}</div>
                    <div class="text-gray-500 text-sm font-medium mt-1">Kategori</div>
                </div>
            </div>
            <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gray-900 rounded-full" style="width: 70%"></div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="group bg-white border border-gray-200 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gray-100 rounded-xl">
                    <svg class="h-8 w-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-gray-900">{{ number_format($stats['total_downloads'], 0, ',', '.') }}</div>
                    <div class="text-gray-500 text-sm font-medium mt-1">Total Unduhan</div>
                </div>
            </div>
            <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gray-900 rounded-full" style="width: 90%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Ebooks Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-4xl font-bold text-gray-900 mb-2">Ebook Populer</h2>
            <p class="text-gray-600">Ebook paling banyak dilihat dan diunduh</p>
        </div>
        <a href="{{ route('ebooks.index', ['sort' => 'popular']) }}" class="hidden md:inline-flex items-center px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:bg-black transform transition-all duration-200">
            Lihat Semua
            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($featuredEbooks as $ebook)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="relative overflow-hidden">
                    @if($ebook->cover_image)
                        <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-72 flex items-center justify-center bg-primary-500">
                            <svg class="h-32 w-32 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 flex gap-2">
                        <span class="px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full flex items-center shadow-lg">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Populer
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $ebook->title }}</h3>
                    <p class="text-gray-600 mb-4 flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $ebook->author }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-6 pb-6 border-b border-gray-100">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-1 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ number_format($ebook->view_count) }}
                        </span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            {{ number_format($ebook->download_count) }}
                        </span>
                    </div>
                    <a href="{{ route('ebooks.show', $ebook) }}" class="block w-full text-center px-6 py-3 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transform transition-all duration-200 bg-primary-500 hover:bg-primary-600">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">Belum ada ebook tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Recent Ebooks Section -->
<div class="bg-gradient-to-br from-gray-50 to-indigo-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-4xl font-bold bg-gradient-to-r from-primary-600 to-primary-400 bg-clip-text text-transparent mb-2">Ebook Terbaru</h2>
                <p class="text-gray-600">Koleksi ebook terbaru yang baru saja ditambahkan</p>
            </div>
            <a href="{{ route('ebooks.index', ['sort' => 'latest']) }}" class="hidden md:inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transform transition-all duration-200">
                Lihat Semua
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recentEbooks as $ebook)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="relative overflow-hidden">
                        @if($ebook->cover_image)
                            <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-72 flex items-center justify-center bg-primary-500">
                                <svg class="h-32 w-32 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-green-400 text-green-900 text-xs font-bold rounded-full flex items-center shadow-lg">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                Baru
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors">{{ $ebook->title }}</h3>
                        <p class="text-gray-600 mb-4 flex items-center">
                            <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $ebook->author }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-6 pb-6 border-b border-gray-100">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-1 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ number_format($ebook->view_count) }}
                            </span>
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                {{ number_format($ebook->download_count) }}
                            </span>
                        </div>
                        <a href="{{ route('ebooks.show', $ebook) }}" class="block w-full text-center px-6 py-3 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transform transition-all duration-200 bg-primary-500 hover:bg-primary-600">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg">Belum ada ebook tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold mb-3">Jelajahi Berdasarkan Kategori</h2>
        <p class="text-gray-600 text-lg">Temukan ebook sesuai dengan minat dan kebutuhan Anda</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('ebooks.index', ['category' => $category->id]) }}" class="group relative bg-white rounded-xl shadow-md hover:shadow-xl p-6 text-center transform hover:-translate-y-1 transition-all duration-200 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl mb-3 group-hover:scale-110 transform transition-transform duration-200 shadow-lg">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500">
                        <span class="font-semibold text-primary-600">{{ $category->ebooks_count }}</span> ebook
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>

<!-- Add animations -->
<style>
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

    @keyframes fade-in-down {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.8s ease-out;
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        animation-fill-mode: both;
    }
</style>
@endsection
