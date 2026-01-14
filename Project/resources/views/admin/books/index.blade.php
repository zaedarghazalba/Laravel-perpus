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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Daftar Buku Fisik
                </h2>
                <p class="text-gray-500 mt-1 text-sm">Kelola koleksi buku perpustakaan</p>
            </div>
            <a href="{{ route('admin.books.create') }}" class="group flex items-center px-5 py-3 bg-gray-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Buku
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50 rounded-tl-xl">
                            Cover
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Detail Buku
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            ISBN
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Klasifikasi
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Lokasi Rak
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Stok Total
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">
                            Tersedia
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50 rounded-tr-xl">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($books as $book)
                        <tr class="hover:bg-gray-50 transition-all duration-200 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($book->cover_image)
                                    <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="h-20 w-14 object-cover rounded-lg shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-200 ring-2 ring-gray-200">
                                @else
                                    <div class="h-20 w-14 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-200">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900 mb-1">{{ Str::limit($book->title, 50) }}</div>
                                <div class="flex items-center text-sm text-gray-600 mb-1">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $book->author }}
                                </div>
                                @if($book->publisher)
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $book->publisher }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700 font-mono bg-gray-100 px-2 py-1 rounded inline-block">
                                    {{ $book->isbn ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($book->classification)
                                    <div class="text-sm">
                                        <div class="font-mono font-bold text-gray-900 bg-blue-50 px-2 py-1 rounded inline-block mb-1">
                                            {{ $book->classification_code }}
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            {{ Str::limit($book->classification->name, 25) }}
                                        </div>
                                    </div>
                                @else
                                    <span class="text-[10px] text-amber-500 uppercase font-semibold">Bukan DDC/Kosong</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($book->shelf_location)
                                    <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-50 text-purple-800 shadow-sm border border-purple-200">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $book->shelf_location }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 shadow-sm border border-gray-200">
                                    <svg class="w-3.5 h-3.5 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $book->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-800 font-bold shadow-sm ring-1 ring-gray-200">
                                    {{ $book->quantity }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-full {{ $book->available_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} font-bold shadow-sm ring-1 ring-gray-200">
                                    {{ $book->available_quantity }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <a href="{{ route('admin.books.show', $book) }}" class="group/btn flex items-center px-3 py-2 bg-gray-900 text-white text-xs font-bold rounded-lg hover:bg-black shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book) }}" class="group/btn flex items-center px-3 py-2 bg-gray-600 text-white text-xs font-bold rounded-lg hover:bg-gray-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="group/btn flex items-center px-3 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="mt-4 text-gray-500 font-medium">Belum ada data buku</p>
                                    <p class="text-sm text-gray-400 mt-1">Mulai dengan menambahkan buku baru ke koleksi perpustakaan</p>
                                    <a href="{{ route('admin.books.create') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-black hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah Buku Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($books->hasPages())
            <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
