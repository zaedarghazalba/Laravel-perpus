@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Laporan Transaksi Peminjaman</h2>
            <p class="mt-1 text-sm text-gray-600">Riwayat sirkulasi buku dan status pengembalian.</p>
        </div>
        <div class="flex gap-2 print:hidden">
            <a href="{{ route('admin.reports.borrowings', array_merge(request()->all(), ['format' => 'print'])) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-xl shadow-md hover:bg-black transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Export PDF / Cetak
            </a>
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">
                Kembali
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 print:hidden">
        <form method="GET" action="{{ route('admin.reports.borrowings') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Buku/Member</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status Peminjaman</label>
                <select name="status" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Masih Dipinjam</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Sudah Kembali</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Periode Pinjam (Mulai)</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex items-end gap-3">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sampai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
                </div>
                <button type="submit" class="p-3 bg-primary-500 text-white rounded-xl shadow-lg hover:shadow-xl hover:bg-primary-600 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($borrowings as $borrowing)
                        @php
                            $isOverdue = $borrowing->status === 'borrowed' && $borrowing->due_date->isPast();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $borrowing->book->title }}</div>
                                <div class="text-[10px] text-gray-400">Barcode: {{ $borrowing->book->barcode }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $borrowing->member->name }}</div>
                                <div class="text-[10px] text-gray-500">{{ $borrowing->member->member_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm {{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                {{ $borrowing->due_date->format('d/m/Y') }}
                                @if($borrowing->return_date)
                                    <div class="text-[10px] text-green-600">Dikembalikan: {{ $borrowing->return_date->format('d/m/y') }}</div>
                                @elseif($isOverdue)
                                    <div class="text-[10px]">Terlambat {{ now()->diffInDays($borrowing->due_date) }} Hari</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($borrowing->status == 'returned')
                                    <span class="px-2 py-1 text-[10px] font-bold bg-green-50 text-green-700 uppercase rounded-full border border-green-100">Kembali</span>
                                @elseif($isOverdue)
                                    <span class="px-2 py-1 text-[10px] font-bold bg-red-50 text-red-700 uppercase rounded-full border border-red-100">Terlambat</span>
                                @else
                                    <span class="px-2 py-1 text-[10px] font-bold bg-blue-50 text-blue-700 uppercase rounded-full border border-blue-100">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic font-medium">Tidak ada transaksi peminjaman dalam periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detailed Summary (Printed) -->
    <div class="hidden print:block mt-12 pt-8 border-t-2 border-dashed border-gray-300">
        <div class="flex justify-between items-start">
            <div class="space-y-4">
                <h4 class="text-lg font-bold text-gray-900">Ringkasan Laporan Peminjaman</h4>
                <div class="grid grid-cols-2 gap-x-12 gap-y-4">
                    <div class="flex justify-between border-b border-gray-100 pb-1">
                        <span class="text-sm text-gray-500">Total Transaksi</span>
                        <span class="text-sm font-bold">{{ $borrowings->count() }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-1">
                        <span class="text-sm text-gray-500">Sedang Dipinjam</span>
                        <span class="text-sm font-bold">{{ $borrowings->where('status', 'borrowed')->count() }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-1">
                        <span class="text-sm text-gray-500">Sudah Kembali</span>
                        <span class="text-sm font-bold text-green-600">{{ $borrowings->where('status', 'returned')->count() }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-1">
                        <span class="text-sm text-gray-500">Total Terlambat</span>
                        <span class="text-sm font-bold text-red-600">{{ $borrowings->filter(fn($b) => $b->status === 'borrowed' && $b->due_date->isPast())->count() }}</span>
                    </div>
                </div>
            </div>
            
            <div class="text-right space-y-12">
                <div>
                    <p class="text-sm font-bold text-gray-900">Kepala Perpustakaan</p>
                    <p class="text-xs text-gray-500">{{ now()->format('d F Y') }}</p>
                </div>
                <div class="pt-4 border-t border-gray-900 w-48 ml-auto">
                    <p class="text-xs font-bold">( .................................... )</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        header, aside, .print\:hidden { display: none !important; }
        body { background-color: white !important; padding: 20px !important; }
        .min-h-screen { margin-left: 0 !important; }
        main { padding: 0 !important; }
        table { font-size: 12px; }
    }
</style>
@endsection
