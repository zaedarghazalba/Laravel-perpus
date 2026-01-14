@extends('layouts.public')

@php
    $title = $ebook->title;
@endphp

@section('content')
<!-- Breadcrumb -->
<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm mb-4">
            <ol class="flex items-center space-x-2 text-indigo-100">
                <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                <li><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li><a href="{{ route('ebooks.index') }}" class="hover:text-white transition">Katalog</a></li>
                <li><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-white font-medium truncate max-w-xs">{{ Str::limit($ebook->title, 40) }}</li>
            </ol>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-white">Detail Ebook</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Cover & Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden sticky top-24">
                <!-- Cover Image -->
                <div class="relative">
                    @if($ebook->cover_image)
                        <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400 flex items-center justify-center">
                            <svg class="h-32 w-32 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Category Badge -->
                    @if($ebook->category)
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-white/90 backdrop-blur-sm text-indigo-600 shadow-lg">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ $ebook->category->name }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="p-6 space-y-3">
                    <!-- Read Button -->
                    <a href="{{ route('ebooks.read', $ebook) }}" class="block w-full text-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-2xl hover:scale-105 transform transition-all duration-200">
                        <svg class="h-6 w-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Baca Ebook
                    </a>

                    <!-- Download Button -->
                    <a href="{{ route('ebooks.download', $ebook) }}" class="block w-full text-center px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl hover:shadow-2xl hover:scale-105 transform transition-all duration-200">
                        <svg class="h-6 w-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Unduh PDF
                    </a>

                    <!-- Statistics -->
                    <div class="pt-4 border-t-2 border-gray-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl">
                                <svg class="h-8 w-8 mx-auto text-blue-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($ebook->view_count) }}</div>
                                <div class="text-xs text-gray-600 font-medium">Views</div>
                            </div>
                            <div class="text-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl">
                                <svg class="h-8 w-8 mx-auto text-green-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($ebook->download_count) }}</div>
                                <div class="text-xs text-gray-600 font-medium">Downloads</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $ebook->title }}</h1>

                <!-- Author -->
                <div class="flex items-center text-xl text-gray-700 mb-6">
                    <svg class="h-6 w-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="font-semibold">{{ $ebook->author }}</span>
                </div>

                <!-- Metadata Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 pb-8 border-b-2 border-gray-100">
                    @if($ebook->publisher)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-gradient-to-br from-purple-100 to-pink-100 text-purple-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Penerbit</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ $ebook->publisher }}</p>
                            </div>
                        </div>
                    @endif

                    @if($ebook->publication_year)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-gradient-to-br from-blue-100 to-cyan-100 text-blue-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Tahun Terbit</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ $ebook->publication_year }}</p>
                            </div>
                        </div>
                    @endif

                    @if($ebook->isbn)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-gradient-to-br from-green-100 to-emerald-100 text-green-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">ISBN</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ $ebook->isbn }}</p>
                            </div>
                        </div>
                    @endif

                    @if($ebook->file_size)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-gradient-to-br from-orange-100 to-red-100 text-orange-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Ukuran File</h3>
                                <p class="text-lg font-semibold text-gray-900">{{ number_format($ebook->file_size / 1024 / 1024, 2) }} MB</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                @if($ebook->description)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="h-6 w-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Deskripsi
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $ebook->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Share Section -->
                <div class="mb-8 pb-8 border-b-2 border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        Bagikan Ebook
                    </h3>
                    <button onclick="copyToClipboard()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 font-semibold rounded-xl hover:from-indigo-200 hover:to-purple-200 transition-all duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Salin Link
                    </button>
                </div>

                <!-- Related Ebooks -->
                @if($relatedEbooks && $relatedEbooks->count() > 0)
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="h-6 w-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Ebook Terkait
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($relatedEbooks as $related)
                                <a href="{{ route('ebooks.show', $related) }}" class="group flex bg-gray-50 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 rounded-xl overflow-hidden transition-all duration-200 hover:shadow-lg">
                                    @if($related->cover_image)
                                        <img src="{{ asset($related->cover_image) }}" alt="{{ $related->title }}" class="w-24 h-32 object-cover">
                                    @else
                                        <div class="w-24 h-32 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center flex-shrink-0">
                                            <svg class="h-12 w-12 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 p-4">
                                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $related->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $related->author }}</p>
                                        <span class="text-xs text-indigo-600 font-medium flex items-center">
                                            Lihat Detail
                                            <svg class="h-3 w-3 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard() {
    const url = window.location.href;
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        }).catch(() => {
            alert('Gagal menyalin link');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement("textarea");
        textArea.value = url;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            alert('Link berhasil disalin!');
        } catch (err) {
            alert('Gagal menyalin link');
        }
        document.body.removeChild(textArea);
    }
}
</script>
@endsection
