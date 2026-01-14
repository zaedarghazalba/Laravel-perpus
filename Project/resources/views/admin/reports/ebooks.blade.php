@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Laporan Katalog E-Book</h2>
            <p class="mt-1 text-sm text-gray-600">Statistik publikasi dan performa unduhan koleksi digital.</p>
        </div>
        <div class="flex gap-2 print:hidden">
            <a href="{{ route('admin.reports.ebooks', array_merge(request()->all(), ['format' => 'print'])) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-xl shadow-md hover:bg-black transition-all">
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
        <form method="GET" action="{{ route('admin.reports.ebooks') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Ebook</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori</label>
                <select name="category_id" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500 transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status Publikasi</label>
                <select name="is_published" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500 transition-all">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_published') === '1' ? 'selected' : '' }}>Dipublikasikan</option>
                    <option value="0" {{ request('is_published') === '0' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Mulai Tgl</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sampai Tgl</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
                </div>
                <button type="submit" class="p-3 bg-primary-500 text-white rounded-xl shadow-lg hover:shadow-xl hover:bg-primary-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info E-Book</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Lihat</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Unduh</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($ebooks as $ebook)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $ebook->title }}</div>
                                <div class="text-xs text-gray-500">{{ $ebook->author }} • {{ $ebook->publication_year }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-bold bg-gray-100 text-gray-700 rounded-lg">{{ $ebook->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-sm text-gray-700">{{ number_format($ebook->view_count) }}</td>
                            <td class="px-6 py-4 text-center font-bold text-sm text-gray-700">{{ number_format($ebook->download_count) }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($ebook->is_published)
                                    <span class="px-2 py-1 text-[10px] font-bold bg-green-50 text-green-700 uppercase rounded-full border border-green-100">Published</span>
                                @else
                                    <span class="px-2 py-1 text-[10px] font-bold bg-gray-50 text-gray-600 uppercase rounded-full border border-gray-100">Draft</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic font-medium">Belum ada data ebook yang sesuai kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Stats (Printed) -->
    <div class="hidden print:grid grid-cols-3 gap-8 mt-12 pt-8 border-t border-gray-200">
        <div class="text-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total E-Book</p>
            <p class="text-3xl font-bold text-gray-900">{{ $ebooks->count() }}</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Views</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($ebooks->sum('view_count')) }}</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Downloads</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($ebooks->sum('download_count')) }}</p>
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
    }
</style>
@endsection
