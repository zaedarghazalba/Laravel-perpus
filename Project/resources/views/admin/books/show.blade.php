@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Book Info --><div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Detail Buku</h2>
                <div class="space-x-2">
                    <a href="{{ route('admin.books.edit', $book) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Cover Image -->
                <div class="md:col-span-1">
                    @if($book->cover_image)
                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-lg">
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Book Details -->
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul</label>
                        <p class="mt-1 text-xl font-semibold text-gray-900">{{ $book->title }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Penulis</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $book->author }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Penerbit</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $book->publisher ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">ISBN</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $book->isbn ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tahun Terbit</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $book->publication_year ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Kategori</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{ $book->category->name }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Barcode</label>
                            <p class="mt-1 text-lg font-mono text-gray-900">{{ $book->barcode ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Kode Klasifikasi</label>
                            <p class="mt-1">
                                @if($book->classification)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 font-mono">
                                        {{ $book->classification_code }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Klasifikasi</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $book->classification->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Call Number</label>
                            <p class="mt-1 text-lg font-mono text-gray-900">{{ $book->call_number ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Lokasi Rak</label>
                            <p class="mt-1">
                                @if($book->shelf_location)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $book->shelf_location }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status Ketersediaan</label>
                            <p class="mt-1">
                                @if($book->available_quantity > 0)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-4 border-t">
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Total Stok</p>
                            <p class="mt-1 text-3xl font-bold text-gray-900">{{ $book->quantity }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Tersedia</p>
                            <p class="mt-1 text-3xl font-bold text-green-600">{{ $book->available_quantity }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-500">Dipinjam</p>
                            <p class="mt-1 text-3xl font-bold text-blue-600">{{ $book->quantity - $book->available_quantity }}</p>
                        </div>
                    </div>

                    @if($book->description)
                        <div class="pt-4 border-t">
                            <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                            <p class="mt-1 text-gray-900 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowing History -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-xl font-semibold mb-4">Riwayat Peminjaman</h3>

            @if($book->borrowings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS/NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($book->borrowings->sortByDesc('borrow_date') as $borrowing)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $borrowing->member->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $borrowing->member->student_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $borrowing->borrow_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $borrowing->due_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($borrowing->status == 'borrowed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Dipinjam
                                            </span>
                                        @elseif($borrowing->status == 'returned')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Dikembalikan
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Terlambat
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($borrowing->fine_amount > 0)
                                            <span class="text-red-600 font-semibold">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-sm text-gray-500">
                    Total Peminjaman: {{ $book->borrowings->count() }} kali
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada riwayat peminjaman untuk buku ini</p>
            @endif
        </div>
    </div>
</div>
@endsection
