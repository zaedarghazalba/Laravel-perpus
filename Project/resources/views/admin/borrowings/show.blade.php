@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Detail Peminjaman</h2>
            <div class="space-x-2">
                @if($borrowing->status == 'borrowed')
                    <a href="{{ route('admin.borrowings.return', $borrowing) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Kembalikan
                    </a>
                @endif
                <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Member Information -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Anggota
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $borrowing->member->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">NIS/NIM</label>
                        <p class="mt-1 text-gray-900">{{ $borrowing->member->student_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-gray-900">{{ $borrowing->member->email ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Telepon</label>
                        <p class="mt-1 text-gray-900">{{ $borrowing->member->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Book Information -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Informasi Buku
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $borrowing->book->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Penulis</label>
                        <p class="mt-1 text-gray-900">{{ $borrowing->book->author }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Kategori</label>
                        <p class="mt-1">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ $borrowing->book->category->name }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">ISBN</label>
                        <p class="mt-1 text-gray-900">{{ $borrowing->book->isbn ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowing Details -->
        <div class="mt-6 bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Detail Peminjaman
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Tanggal Pinjam</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $borrowing->borrow_date->format('d F Y') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Jatuh Tempo</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $borrowing->due_date->format('d F Y') }}</p>
                    @if($borrowing->status == 'borrowed' && $borrowing->due_date->isPast())
                        <p class="text-sm text-red-600 font-semibold">Terlambat {{ $borrowing->due_date->diffInDays(now()) }} hari</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Tanggal Kembali</label>
                    <p class="mt-1 text-lg text-gray-900">
                        {{ $borrowing->return_date ? $borrowing->return_date->format('d F Y') : '-' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Status</label>
                    <p class="mt-1">
                        @if($borrowing->status == 'borrowed')
                            @if($borrowing->due_date->isPast())
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Terlambat
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Dipinjam
                                </span>
                            @endif
                        @else
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Dikembalikan
                            </span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Denda</label>
                    <p class="mt-1 text-lg {{ $borrowing->fine_amount > 0 ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                        {{ $borrowing->fine_amount > 0 ? 'Rp ' . number_format($borrowing->fine_amount, 0, ',', '.') : '-' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Durasi Peminjaman</label>
                    <p class="mt-1 text-lg text-gray-900">
                        @if($borrowing->return_date)
                            {{ $borrowing->borrow_date->diffInDays($borrowing->return_date) }} hari
                        @else
                            {{ $borrowing->borrow_date->diffInDays(now()) }} hari (berlangsung)
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if($borrowing->status == 'borrowed' && $borrowing->due_date->isPast())
            <div class="mt-6 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <strong>Perhatian!</strong> Buku ini sudah melewati jatuh tempo {{ $borrowing->due_date->diffInDays(now()) }} hari.
                            Estimasi denda: Rp {{ number_format($borrowing->due_date->diffInDays(now()) * 1000, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
