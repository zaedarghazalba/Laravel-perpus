@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Ebook Info -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Detail Ebook</h2>
                <div class="space-x-2">
                    <a href="{{ route('admin.ebooks.download', $ebook) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Download PDF
                    </a>
                    <a href="{{ route('admin.ebooks.edit', $ebook) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <a href="{{ route('admin.ebooks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Cover Image -->
                <div class="md:col-span-1">
                    @if($ebook->cover_image)
                        <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-full rounded-lg shadow-lg">
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Ebook Details -->
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul</label>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $ebook->title }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Penulis</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $ebook->author }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Penerbit</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $ebook->publisher ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">ISBN</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $ebook->isbn ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tahun Terbit</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $ebook->publication_year ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Kategori</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{ $ebook->category->name }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                @if($ebook->is_published)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Dipublikasikan
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Draft
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Total Views</p>
                            <p class="mt-1 text-3xl font-bold text-blue-600">{{ number_format($ebook->view_count) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Total Downloads</p>
                            <p class="mt-1 text-3xl font-bold text-green-600">{{ number_format($ebook->download_count) }}</p>
                        </div>
                    </div>

                    @if($ebook->description)
                        <div class="pt-4 border-t">
                            <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                            <p class="mt-1 text-gray-900 leading-relaxed">{{ $ebook->description }}</p>
                        </div>
                    @endif

                    @if($ebook->file_path)
                        <div class="pt-4 border-t">
                            <label class="block text-sm font-medium text-gray-500">File PDF</label>
                            <div class="mt-2 bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ basename($ebook->file_path) }}</p>
                                            <p class="text-xs text-gray-500">
                                                @if(file_exists(public_path($ebook->file_path)))
                                                    {{ number_format(filesize(public_path($ebook->file_path)) / 1024 / 1024, 2) }} MB
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.ebooks.download', $ebook) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="pt-4 border-t">
                        <div class="flex space-x-3">
                            <form action="{{ route('admin.ebooks.togglePublish', $ebook) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    {{ $ebook->is_published ? 'Unpublish' : 'Publish' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Preview -->
    @if($ebook->file_path && file_exists(public_path($ebook->file_path)))
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-xl font-semibold mb-4">Preview PDF</h3>
                <div class="w-full" style="height: 800px;">
                    <iframe src="{{ asset($ebook->file_path) }}" class="w-full h-full border rounded" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
