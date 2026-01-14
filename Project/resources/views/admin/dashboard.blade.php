@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="relative overflow-hidden bg-primary-600 rounded-2xl shadow-2xl">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-3xl opacity-5 animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-gray-600 rounded-full mix-blend-multiply filter blur-3xl opacity-5 animate-pulse animation-delay-2000"></div>
        </div>
        <div class="relative p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-white text-lg font-semibold">Dashboard Admin - Laravel Perpustakaan Digital</p>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center justify-center w-24 h-24 bg-white/20 backdrop-blur-md rounded-2xl">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Books Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-primary-50 rounded-xl group-hover:bg-primary-100 transition-colors">
                        <svg class="h-7 w-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Total Buku Fisik</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_books'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Ebooks Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-primary-50 rounded-xl group-hover:bg-primary-100 transition-colors">
                        <svg class="h-7 w-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Total Ebook</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_ebooks'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Members Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-primary-50 rounded-xl group-hover:bg-primary-100 transition-colors">
                        <svg class="h-7 w-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Total Anggota</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_members'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-primary-50 rounded-xl group-hover:bg-primary-100 transition-colors">
                        <svg class="h-7 w-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Total Kategori</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Borrowings Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-primary-50 rounded-xl group-hover:bg-primary-100 transition-colors">
                        <svg class="h-7 w-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Peminjaman Aktif</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['active_borrowings'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Borrowings Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-gray-100 rounded-xl group-hover:bg-gray-200 transition-colors">
                        <svg class="h-7 w-7 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Terlambat</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['overdue_borrowings'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Borrowings -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary-600 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Peminjaman Terbaru</h3>
                </div>
                <a href="{{ route('admin.borrowings.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center">
                    Lihat Semua
                    <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($recent_borrowings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50 rounded-tl-lg">Anggota</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider bg-gray-50 rounded-tr-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recent_borrowings as $borrowing)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-bold text-sm">{{ substr($borrowing->member->name, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->member->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ Str::limit($borrowing->book->title, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $borrowing->borrow_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $borrowing->due_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($borrowing->status == 'borrowed')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800">
                                                Dipinjam
                                            </span>
                                        @elseif($borrowing->status == 'returned')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                                Dikembalikan
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-red-100 to-red-200 text-red-800">
                                                Terlambat
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-4 text-gray-500">Belum ada data peminjaman</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Popular Ebooks -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Ebook Populer</h3>
                </div>
                <a href="{{ route('admin.ebooks.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 flex items-center transition-colors">
                    Lihat Semua
                    <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($popular_ebooks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($popular_ebooks as $ebook)
                        <div class="group bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-xl p-4 hover:shadow-lg hover:border-primary-300 transition-all duration-300">
                            <div class="flex items-center justify-center w-12 h-12 bg-primary-50 rounded-lg mb-3 group-hover:bg-primary-100 transition-colors">
                                <svg class="h-6 w-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-sm mb-2 text-gray-900 line-clamp-2 h-10">{{ $ebook->title }}</h4>
                            <p class="text-xs text-gray-600 mb-3">{{ $ebook->author }}</p>
                            <div class="flex items-center text-xs text-gray-500 pt-3 border-t border-gray-100">
                                <svg class="h-4 w-4 mr-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold">{{ number_format($ebook->view_count) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-4 text-gray-500">Belum ada data ebook</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 0.1; }
        50% { opacity: 0.2; }
    }

    .animate-pulse {
        animation: pulse 3s ease-in-out infinite;
    }

    .animation-delay-2000 {
        animation-delay: 1s;
    }
</style>
@endsection
