@extends('layouts.public')

@php
    $title = 'Katalog Ebook';
@endphp

@section('content')
<!-- Header -->
<div class="bg-gray-900 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Katalog Ebook</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Jelajahi koleksi ebook lengkap kami dan temukan bacaan yang tepat untuk Anda
            </p>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white shadow-lg -mt-8 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form method="GET" action="{{ route('ebooks.index') }}" class="space-y-4">
            <!-- Main Search -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul, penulis, atau deskripsi..." class="w-full pl-12 pr-4 py-4 text-lg border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all">
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Category Filter -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <select name="category" class="w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 appearance-none bg-white transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->ebooks_count }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sort Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                        <select name="sort" class="w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-200 appearance-none bg-white transition-all">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Populer</option>
                            <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>Terbanyak Diunduh</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul (A-Z)</option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-3 text-white font-semibold rounded-xl hover:shadow-lg transform transition-all duration-200 flex items-center justify-center bg-primary-500 hover:bg-primary-600">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request('search') || request('category') || (request('sort') && request('sort') != 'latest'))
                <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div class="flex items-center space-x-2 flex-wrap gap-2">
                        <span class="text-sm font-medium text-gray-900">Filter aktif:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white border border-gray-200 text-gray-800 shadow-sm">
                                <svg class="h-4 w-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('category'))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white border border-gray-200 text-gray-800 shadow-sm">
                                <svg class="h-4 w-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ $categories->firstWhere('id', request('category'))->name ?? 'Kategori' }}
                            </span>
                        @endif
                        <span class="text-sm text-gray-600">• {{ $ebooks->total() }} hasil</span>
                    </div>
                    <a href="{{ route('ebooks.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center transition-colors">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Ebooks Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($ebooks->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($ebooks as $ebook)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="relative overflow-hidden">
                        @if($ebook->cover_image)
                            <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-72 flex items-center justify-center bg-primary-500">
                                <svg class="h-24 w-24 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Category Badge -->
                        @if($ebook->category)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm text-gray-800 shadow-lg">
                                    {{ $ebook->category->name }}
                                </span>
                            </div>
                        @endif

                        <!-- Stats Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent p-4 transition-opacity duration-300">
                            <div class="flex items-center justify-between text-white text-xs font-medium">
                                <span class="flex items-center bg-black/30 px-2 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="h-3.5 w-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ number_format($ebook->view_count) }}
                                </span>
                                <span class="flex items-center bg-black/30 px-2 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="h-3.5 w-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ number_format($ebook->download_count) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 h-14 group-hover:text-black transition-colors">{{ $ebook->title }}</h3>
                        <p class="text-sm text-gray-600 mb-1 flex items-center">
                            <svg class="h-4 w-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $ebook->author }}
                        </p>

                        @if($ebook->publication_year)
                            <p class="text-xs text-gray-500 mb-4 flex items-center">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $ebook->publication_year }}
                            </p>
                        @endif

                        <a href="{{ route('ebooks.show', $ebook) }}" class="block w-full text-center px-4 py-2.5 text-white font-semibold rounded-xl hover:shadow-lg transform transition-all duration-200 bg-primary-500 hover:bg-primary-600">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $ebooks->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Tidak ada ebook ditemukan</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Maaf, kami tidak menemukan ebook yang sesuai dengan pencarian Anda. Coba ubah kata kunci atau filter yang digunakan.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('ebooks.index') }}" class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-xl hover:shadow-lg transform transition-all duration-200 bg-primary-500 hover:bg-primary-600">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Lihat Semua Ebook
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-semibold rounded-xl border-2 border-gray-900 hover:bg-gray-50 hover:scale-105 transform transition-all duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
