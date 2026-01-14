@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Klasifikasi DDC</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola klasifikasi buku menggunakan sistem Dewey Decimal Classification</p>
        </div>
        <a href="{{ route('admin.classifications.create') }}" class="inline-flex items-center justify-center px-5 py-3 text-sm font-semibold text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200" style="background-color: #007FFF;">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Klasifikasi
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <form method="GET" action="{{ route('admin.classifications.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Cari Klasifikasi</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Cari kode, nama, atau deskripsi..."
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-opacity-50 focus:border-transparent transition-all" style="focus:ring-color: #007FFF;">
                </div>

                <!-- Level Filter -->
                <div>
                    <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">Level</label>
                    <select name="level" id="level" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-opacity-50 focus:border-transparent transition-all" style="focus:ring-color: #007FFF;">
                        <option value="">Semua Level</option>
                        <option value="1" {{ request('level') == '1' ? 'selected' : '' }}>Level 1 (Kelas Utama)</option>
                        <option value="2" {{ request('level') == '2' ? 'selected' : '' }}>Level 2 (Divisi)</option>
                        <option value="3" {{ request('level') == '3' ? 'selected' : '' }}>Level 3 (Seksi)</option>
                        <option value="4" {{ request('level') == '4' ? 'selected' : '' }}>Level 4 (Spesifik)</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex gap-3">
                <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200" style="background-color: #007FFF;">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
                <a href="{{ route('admin.classifications.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Classifications Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kode</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Level</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Parent</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($classifications as $classification)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="px-3 py-1 text-sm font-bold rounded-lg" style="background-color: #007FFF; color: white;">
                                        {{ $classification->code }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $classification->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $classification->level == 1 ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $classification->level == 2 ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $classification->level == 3 ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $classification->level == 4 ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    Level {{ $classification->level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                @if($classification->parent)
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-800">{{ $classification->parent->code }}</span>
                                        <span class="text-[10px] text-gray-500 uppercase tracking-tight">{{ Str::limit($classification->parent->name, 20) }}</span>
                                    </div>
                                @elseif($classification->parent_code)
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-amber-600">{{ $classification->parent_code }}</span>
                                        <span class="text-[10px] text-amber-500 uppercase">Parent Kurang Sinkron</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Level Utama
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 line-clamp-2">
                                    {{ $classification->description }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.classifications.show', $classification) }}"
                                       class="text-gray-600 hover:text-gray-900 transition-colors p-2 hover:bg-gray-100 rounded-lg"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.classifications.edit', $classification) }}"
                                       class="text-blue-600 hover:text-blue-900 transition-colors p-2 hover:bg-blue-50 rounded-lg"
                                       title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.classifications.destroy', $classification) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klasifikasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors p-2 hover:bg-red-50 rounded-lg" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak ada klasifikasi</h3>
                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan klasifikasi baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($classifications->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $classifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
