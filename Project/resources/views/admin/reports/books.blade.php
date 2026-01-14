@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header/Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Laporan Inventaris Buku</h2>
            <p class="mt-1 text-sm text-gray-600">Daftar lengkap koleksi buku fisik perpustakaan.</p>
        </div>
        <div class="flex gap-2 print:hidden">
            <a href="{{ route('admin.reports.books', array_merge(request()->all(), ['format' => 'print'])) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-xl shadow-md hover:bg-black transition-all">
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

    <!-- Filters (Hidden on Print) -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 print:hidden">
        <form method="GET" action="{{ route('admin.reports.books') }}" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Judul/Penulis/ISBN</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori Buku</label>
                    <select name="category_id" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500 font-medium text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- DDC Level -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Level DDC</label>
                    <select name="level" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500 font-medium text-sm">
                        <option value="">Semua Level</option>
                        <option value="1" {{ request('level') == '1' ? 'selected' : '' }}>Level 1 (Utama)</option>
                        <option value="2" {{ request('level') == '2' ? 'selected' : '' }}>Level 2 (Divisi)</option>
                        <option value="3" {{ request('level') == '3' ? 'selected' : '' }}>Level 3 (Seksi)</option>
                    </select>
                </div>

                <!-- Main Class Range -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kelompok Klasifikasi (DDC Sequence)</label>
                    <select name="main_class" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500 font-medium text-sm">
                        <option value="">Semua Urutan</option>
                        <option value="000" {{ request('main_class') == '000' ? 'selected' : '' }}>000 - Karya Umum / Komputer</option>
                        <option value="100" {{ request('main_class') == '100' ? 'selected' : '' }}>100 - Filsafat & Psikologi</option>
                        <option value="200" {{ request('main_class') == '200' ? 'selected' : '' }}>200 - Agama</option>
                        <option value="300" {{ request('main_class') == '300' ? 'selected' : '' }}>300 - Ilmu Sosial</option>
                        <option value="400" {{ request('main_class') == '400' ? 'selected' : '' }}>400 - Bahasa</option>
                        <option value="500" {{ request('main_class') == '500' ? 'selected' : '' }}>500 - Sains & Matematika</option>
                        <option value="600" {{ request('main_class') == '600' ? 'selected' : '' }}>600 - Teknologi / Terapan</option>
                        <option value="700" {{ request('main_class') == '700' ? 'selected' : '' }}>700 - Kesenian & Olahraga</option>
                        <option value="800" {{ request('main_class') == '800' ? 'selected' : '' }}>800 - Kesusastraan</option>
                        <option value="900" {{ request('main_class') == '900' ? 'selected' : '' }}>900 - Sejarah & Geografi</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-100">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Masuk (Dari)</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500 font-medium text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Hingga</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500 font-medium text-sm">
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="flex-1 py-3 bg-primary-500 text-white rounded-xl shadow-lg hover:shadow-xl hover:bg-primary-600 transition-all font-bold text-sm uppercase tracking-widest flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter Data
                    </button>
                    <a href="{{ route('admin.reports.books') }}" class="p-3 bg-gray-100 text-gray-500 rounded-xl hover:bg-gray-200 transition-all font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Report Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul & Penulis</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ISBN</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">DDC</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Rak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($books as $book)
                        <tr class="hover:bg-gray-50 transition-all">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $book->title }}</div>
                                <div class="text-xs text-gray-500">{{ $book->author }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $book->isbn ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-bold bg-blue-50 text-blue-700 rounded-lg">{{ $book->classification_code ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-bold bg-gray-100 text-gray-700 rounded-lg">{{ $book->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-bold text-gray-900">{{ $book->quantity }}</div>
                                <div class="text-[10px] text-gray-400">Tersedia: {{ $book->available_quantity }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-bold bg-purple-50 text-purple-700 rounded-lg">{{ $book->shelf_location ?? '-' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">Tidak ada data buku ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Stats (Printed) -->
    <div class="hidden print:grid grid-cols-2 gap-8 mt-12 pt-8 border-t border-gray-200">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Koleksi</p>
            <p class="text-2xl font-bold text-gray-900">{{ $books->count() }} Judul</p>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Eksemplar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $books->sum('quantity') }} Buku</p>
        </div>
    </div>
</div>

<style>
    @media print {
        header, aside, .print\:hidden {
            display: none !important;
        }
        body {
            background-color: white !important;
            padding: 0 !important;
        }
        .min-h-screen {
            margin-left: 0 !important;
        }
        main {
            padding: 0 !important;
        }
        table {
            border: 1px solid #e5e7eb !important;
        }
        th {
            background-color: #f9fafb !important;
            color: black !important;
        }
    }
</style>
@endsection
