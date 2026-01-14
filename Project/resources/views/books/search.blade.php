@extends('layouts.public')

@section('content')
<!-- Search Hero Section -->
<div class="relative overflow-hidden bg-white border-b border-gray-100">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-600 mb-4 leading-tight animate-slide-up">
                Cari Buku di Perpustakaan
            </h1>
            <p class="text-lg text-gray-600 mb-6 max-w-2xl mx-auto animate-slide-up animation-delay-100">
                Temukan buku yang Anda butuhkan dengan mudah dan cepat
            </p>

            <!-- Search Box -->
            <div class="max-w-3xl mx-auto animate-fade-in-up animation-delay-150">
                <form action="{{ route('books.search') }}" method="GET">
                    <div class="flex gap-3">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                name="q"
                                value="{{ $query }}"
                                class="w-full px-4 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400 shadow-sm"
                                placeholder="Cari buku berdasarkan judul, penulis, atau ISBN..."
                                autocomplete="off"
                                autofocus
                            >
                        </div>
                        <button 
                            type="submit" 
                            class="px-8 py-4 bg-gray-900 text-white border border-gray-900 rounded-lg font-bold hover:bg-black hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
                        >
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            @if($query)
                <p class="text-gray-600 mt-6 animate-fade-in">
                    Hasil pencarian untuk: <strong class="text-gray-900">"{{ $query }}"</strong>
                    <span class="inline-block ml-2 px-3 py-1 bg-gray-100 rounded-full text-sm font-semibold">
                        {{ $books->count() }} buku ditemukan
                    </span>
                </p>
            @endif
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="url(#paint0_linear)" fill-opacity="0.2"/>
            <path d="M0 120L60 112C120 104 240 88 360 80C480 72 600 72 720 76C840 80 960 88 1080 92C1200 96 1320 96 1380 96L1440 96V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="rgb(249, 250, 251)"/>
            <defs>
                <linearGradient id="paint0_linear" x1="720" y1="60" x2="720" y2="120" gradientUnits="userSpaceOnUse">
                    <stop stop-color="white" stop-opacity="0.5"/>
                    <stop offset="1" stop-color="white" stop-opacity="0"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
</div>

<!-- Results Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-8 relative z-10">
    @if($books->isEmpty() && $query)
        <!-- No Results -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8 py-12 text-center animate-fade-in">
            <div class="max-w-md mx-auto">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Buku Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-6">
                    Maaf, buku yang Anda cari tidak tersedia di perpustakaan kami saat ini.
                </p>

                <!-- Request Book Action -->
                @auth
                    <a
                        href="{{ route('book-requests.create', ['title' => $query]) }}"
                        class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-xl hover:bg-black hover:scale-105 transform transition-all duration-200"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajukan Permintaan Buku
                    </a>
                @else
                    <div class="mt-8 pt-8 border-t border-gray-100">
                        <p class="text-gray-900 font-semibold mb-6">
                            Ingin mengajukan permintaan buku ini?
                        </p>
                        <div class="flex flex-col items-center gap-4">
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:bg-black hover:scale-105 transform transition-all duration-200"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Login untuk Request Buku
                            </a>
                            <p class="text-sm text-gray-500 max-w-xs mx-auto leading-relaxed">
                                Anda harus login terlebih dahulu untuk mengajukan permintaan buku
                            </p>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

    @elseif($books->isNotEmpty())
        <!-- Book Results Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-12">
            @foreach($books as $book)
                <div class="group bg-white border border-gray-200 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <!-- Book Cover -->
                    <div class="relative h-64 bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center overflow-hidden">
                        @if($book->cover_image)
                            <img
                                src="{{ route('files.book.cover', $book) }}"
                                alt="{{ $book->title }}"
                                class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300"
                            >
                        @else
                            <div class="text-center p-6">
                                <svg class="w-20 h-20 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="text-xs text-gray-400 font-medium">No Cover</p>
                            </div>
                        @endif

                        <!-- Availability Badge -->
                        <div class="absolute top-3 right-3">
                            @if($book->available_quantity > 0)
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-lg">
                                    Dipinjam
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Book Info -->
                    <div class="p-5 space-y-3">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900 mb-1 line-clamp-2 group-hover:text-gray-700 transition-colors">
                                {{ $book->title }}
                            </h3>
                            <p class="text-sm text-gray-600 line-clamp-1">
                                {{ $book->author ?? 'Unknown Author' }}
                            </p>
                        </div>

                        @if($book->category)
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                {{ $book->category->name }}
                            </span>
                        @endif

                        <!-- Classification & Location -->
                        <div class="space-y-2 text-sm">
                            @if($book->classification_code)
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <div class="flex-1">
                                        <span class="font-medium text-gray-900">{{ $book->classification_code }}</span>
                                        @if($book->classification)
                                            <span class="text-gray-500"> - {{ $book->classification->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($book->shelf_location)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-gray-700 font-medium">{{ $book->shelf_location }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Availability Detail -->
                        <div class="pt-3 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 font-medium">Ketersediaan:</span>
                                @if($book->available_quantity > 0)
                                    <span class="text-sm font-bold text-green-600">
                                        {{ $book->available_quantity }}/{{ $book->quantity }} tersedia
                                    </span>
                                @else
                                    <span class="text-sm font-bold text-red-600">
                                        Tidak tersedia
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($book->isbn || $book->barcode)
                            <div class="pt-2 text-xs text-gray-500 space-y-1">
                                @if($book->isbn)
                                    <div>ISBN: {{ $book->isbn }}</div>
                                @endif
                                @if($book->barcode)
                                    <div>Barcode: {{ $book->barcode }}</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Request Different Book CTA -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Tidak Menemukan Buku yang Anda Cari?</h3>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Jika buku yang Anda butuhkan tidak ada dalam hasil pencarian, Anda dapat mengajukan permintaan kepada kami
            </p>
            @auth
                <a
                    href="{{ route('book-requests.create') }}"
                    class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-xl hover:bg-black hover:scale-105 transform transition-all duration-200"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajukan Permintaan Buku / E-Book
                </a>
            @else
                <div class="space-y-4">
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-xl hover:bg-black hover:scale-105 transform transition-all duration-200"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login untuk Request Buku
                    </a>
                    <p class="text-sm text-gray-500">
                        Silakan login terlebih dahulu untuk mengajukan permintaan buku
                    </p>
                </div>
            @endauth
        </div>

    @else
        <!-- Initial State (No Query) -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8 py-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Cari Buku di Perpustakaan</h3>
                <p class="text-gray-600">
                    Masukkan judul buku, nama penulis, ISBN, atau barcode untuk memulai pencarian
                </p>
            </div>
        </div>
    @endif
</div>

<!-- Back to Home -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="text-center">
        <a
            href="{{ route('home') }}"
            class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-900 transition-all duration-200"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
