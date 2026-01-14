@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
    <!-- Header -->
    <!-- Header -->
    <div class="px-8 py-6 border-b border-gray-100">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Daftar Ebook Digital
                </h2>
                <p class="text-gray-500 mt-1 text-sm">Kelola koleksi ebook perpustakaan</p>
            </div>
            <a href="{{ route('admin.ebooks.create') }}" class="group flex items-center px-5 py-3 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Ebook
            </a>
        </div>
    </div>

    <div class="p-6">
        <!-- Filters -->
        <div class="mb-6 flex flex-col lg:flex-row gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
            <form method="GET" action="{{ route('admin.ebooks.index') }}" class="flex-1 flex gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Cari judul, penulis, atau penerbit..."
                        value="{{ request('search') }}"
                        class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 bg-white">
                </div>
                <button type="submit" class="flex items-center px-5 py-2 bg-gray-900 text-white font-bold rounded-lg hover:bg-black hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.ebooks.index') }}" class="flex items-center px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Reset
                    </a>
                @endif
            </form>

            <form method="GET" action="{{ route('admin.ebooks.index') }}" class="lg:w-64">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <select name="status" onchange="this.form.submit()"
                        class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 bg-white">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                        <option value="unpublished" {{ request('status') == 'unpublished' ? 'selected' : '' }}>Belum Dipublikasikan</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50 rounded-tl-xl">
                            Cover
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Detail Ebook
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Views
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Downloads
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50 rounded-tr-xl">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($ebooks as $ebook)
                        <tr class="hover:bg-gray-50 transition-all duration-200 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ebook->cover_image)
                                    <img src="{{ asset($ebook->cover_image) }}" alt="{{ $ebook->title }}" class="h-20 w-14 object-cover rounded-lg shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-200 ring-2 ring-gray-200">
                                @else
                                    <div class="h-20 w-14 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-200">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900 mb-1">{{ Str::limit($ebook->title, 50) }}</div>
                                <div class="flex items-center text-sm text-gray-600 mb-1">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $ebook->author }}
                                </div>
                                @if($ebook->publisher)
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $ebook->publisher }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 shadow-sm border border-gray-200">
                                    <svg class="w-3.5 h-3.5 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $ebook->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($ebook->is_published)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-emerald-200 text-green-800 shadow-sm">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 shadow-sm border border-gray-200">
                                        <svg class="w-3.5 h-3.5 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    <div class="flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-semibold shadow-sm border border-gray-200">
                                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ number_format($ebook->view_count) }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    <div class="flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-semibold shadow-sm border border-gray-200">
                                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        {{ number_format($ebook->download_count) }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center flex-wrap gap-1.5">
                                    <a href="{{ route('admin.ebooks.show', $ebook) }}" class="flex items-center px-2 py-1.5 bg-gray-900 text-white text-xs font-bold rounded-lg hover:bg-black shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="Detail">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.ebooks.download', $ebook) }}" class="flex items-center px-2 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="Download">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.ebooks.edit', $ebook) }}" class="flex items-center px-2 py-1.5 bg-gray-600 text-white text-xs font-bold rounded-lg hover:bg-gray-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.ebooks.togglePublish', $ebook) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="flex items-center px-2 py-1.5 bg-yellow-600 text-white text-xs font-bold rounded-lg hover:bg-yellow-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="{{ $ebook->is_published ? 'Unpublish' : 'Publish' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.ebooks.destroy', $ebook) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus ebook ini? File PDF dan cover akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center px-2 py-1.5 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-4 text-gray-500 font-medium">Belum ada data ebook</p>
                                    <p class="text-sm text-gray-400 mt-1">Mulai dengan menambahkan ebook digital ke perpustakaan</p>
                                    <a href="{{ route('admin.ebooks.create') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-black hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah Ebook Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ebooks->hasPages())
            <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6">
                {{ $ebooks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
