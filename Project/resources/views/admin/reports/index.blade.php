@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Laporan Perpustakaan</h2>
        <p class="mt-1 text-sm text-gray-600">Pilih jenis laporan yang ingin Anda buat atau cetak.</p>
    </div>

    <!-- Report Selection Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Books Report Card -->
        <a href="{{ route('admin.reports.books') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-primary-500 transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center mb-4 group-hover:bg-primary-500 transition-colors duration-300 text-blue-600 group-hover:text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Laporan Buku</h3>
            <p class="text-xs text-gray-500 leading-relaxed font-medium">Data inventaris buku fisik, kategori, dan stok.</p>
            <div class="mt-4 flex items-center text-primary-600 text-xs font-bold uppercase tracking-wider">
                Buka Laporan
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Ebooks Report Card -->
        <a href="{{ route('admin.reports.ebooks') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-primary-500 transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center mb-4 group-hover:bg-primary-500 transition-colors duration-300 text-purple-600 group-hover:text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Laporan Ebook</h3>
            <p class="text-xs text-gray-500 leading-relaxed font-medium">Statistik publikasi, unduhan, dan kategori ebook digital.</p>
            <div class="mt-4 flex items-center text-primary-600 text-xs font-bold uppercase tracking-wider">
                Buka Laporan
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Members Report Card -->
        <a href="{{ route('admin.reports.members') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-primary-500 transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center mb-4 group-hover:bg-primary-500 transition-colors duration-300 text-emerald-600 group-hover:text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 4 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Laporan Anggota</h3>
            <p class="text-xs text-gray-500 leading-relaxed font-medium">Data pendaftaran anggota, status aktif, dan pertumbuhan.</p>
            <div class="mt-4 flex items-center text-primary-600 text-xs font-bold uppercase tracking-wider">
                Buka Laporan
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Borrowings Report Card -->
        <a href="{{ route('admin.reports.borrowings') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-primary-500 transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center mb-4 group-hover:bg-primary-500 transition-colors duration-300 text-amber-600 group-hover:text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Laporan Peminjaman</h3>
            <p class="text-xs text-gray-500 leading-relaxed font-medium">Riwayat peminjaman buku, status pengembalian, dan denda.</p>
            <div class="mt-4 flex items-center text-primary-600 text-xs font-bold uppercase tracking-wider">
                Buka Laporan
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
    </div>

    <!-- Quick Stats Summary -->
    <div class="bg-gradient-to-br from-primary-600 to-indigo-700 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
        <svg class="absolute right-0 bottom-0 w-64 h-64 text-white opacity-10 transform translate-x-10 translate-y-10" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
        </svg>
        <div class="relative">
            <h3 class="text-xl font-bold mb-2">Pusat Laporan Terpadu</h3>
            <p class="text-primary-100 max-w-xl text-sm leading-relaxed font-medium">
                Gunakan fitur laporan ini untuk menganalisis perkembangan perpustakaan Anda secara real-time. Anda dapat memfilter data berdasarkan rentang waktu atau kategori tertentu untuk mendapatkan wawasan yang lebih akurat.
            </p>
        </div>
    </div>
</div>
@endsection
