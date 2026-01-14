@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Klasifikasi</h2>
            <p class="mt-1 text-sm text-gray-600">Informasi lengkap tentang klasifikasi ini</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.classifications.edit', $classification) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
               style="background-color: #007FFF;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.classifications.index') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Info Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="p-8 space-y-6">
            <!-- Code and Name -->
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <span class="px-4 py-2 text-xl font-bold rounded-lg text-white shadow-md" style="background-color: #007FFF;">
                        {{ $classification->code }}
                    </span>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                        {{ $classification->level == 1 ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $classification->level == 2 ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $classification->level == 3 ? 'bg-green-100 text-green-800' : '' }}
                        {{ $classification->level == 4 ? 'bg-yellow-100 text-yellow-800' : '' }}">
                        Level {{ $classification->level }}
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $classification->name }}</h3>
            </div>

            <!-- Description -->
            @if($classification->description)
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi</h4>
                    <p class="text-gray-600">{{ $classification->description }}</p>
                </div>
            @endif

            <!-- Parent Info -->
            @if($classification->parent)
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Klasifikasi Parent</h4>
                    <a href="{{ route('admin.classifications.show', $classification->parent) }}"
                       class="inline-flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors border border-gray-200">
                        <span class="px-3 py-1 text-sm font-bold rounded-lg text-white" style="background-color: #007FFF;">
                            {{ $classification->parent->code }}
                        </span>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">{{ $classification->parent->name }}</div>
                            <div class="text-xs text-gray-500">Level {{ $classification->parent->level }}</div>
                        </div>
                    </a>
                </div>
            @endif

            <!-- Children Classifications -->
            @if($classification->children->count() > 0)
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Sub-Klasifikasi ({{ $classification->children->count() }})</h4>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($classification->children as $child)
                            <a href="{{ route('admin.classifications.show', $child) }}"
                               class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors border border-gray-200">
                                <span class="px-3 py-1 text-sm font-bold rounded-lg text-white" style="background-color: #007FFF;">
                                    {{ $child->code }}
                                </span>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-gray-900">{{ $child->name }}</div>
                                    <div class="text-xs text-gray-500">Level {{ $child->level }}</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Books Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-900">Buku Fisik</h4>
                    <div class="p-3 rounded-lg" style="background-color: #E6F3FF;">
                        <svg class="w-6 h-6" style="color: #007FFF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold mb-2" style="color: #007FFF;">{{ $classification->books->count() }}</div>
                <p class="text-sm text-gray-600">Total buku dengan klasifikasi ini</p>
                @if($classification->books->count() > 0)
                    <a href="{{ route('admin.books.index', ['classification' => $classification->code]) }}"
                       class="mt-4 inline-flex items-center text-sm font-semibold hover:underline"
                       style="color: #007FFF;">
                        Lihat Semua Buku
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Ebooks Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-bold text-gray-900">E-Book</h4>
                    <div class="p-3 rounded-lg" style="background-color: #E6F3FF;">
                        <svg class="w-6 h-6" style="color: #007FFF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold mb-2" style="color: #007FFF;">{{ $classification->ebooks->count() }}</div>
                <p class="text-sm text-gray-600">Total e-book dengan klasifikasi ini</p>
                @if($classification->ebooks->count() > 0)
                    <a href="{{ route('admin.ebooks.index', ['classification' => $classification->code]) }}"
                       class="mt-4 inline-flex items-center text-sm font-semibold hover:underline"
                       style="color: #007FFF;">
                        Lihat Semua E-Book
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Books/Ebooks -->
    @if($classification->books->count() > 0 || $classification->ebooks->count() > 0)
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Item Terbaru dengan Klasifikasi Ini</h4>

                <div class="space-y-3">
                    @foreach($classification->books->take(3) as $book)
                        <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-16 rounded bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $book->title }}</p>
                                <p class="text-xs text-gray-500">{{ $book->author }} • {{ $book->publication_year }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">Buku</span>
                        </div>
                    @endforeach

                    @foreach($classification->ebooks->take(3) as $ebook)
                        <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-16 rounded bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $ebook->title }}</p>
                                <p class="text-xs text-gray-500">{{ $ebook->author }} • {{ $ebook->publication_year }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">E-Book</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
