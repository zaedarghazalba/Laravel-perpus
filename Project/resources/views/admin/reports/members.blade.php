@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Laporan Keanggotaan</h2>
            <p class="mt-1 text-sm text-gray-600">Daftar anggota perpustakaan dan data pertumbuhan.</p>
        </div>
        <div class="flex gap-2 print:hidden">
            <a href="{{ route('admin.reports.members', array_merge(request()->all(), ['format' => 'print'])) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-gray-900 rounded-xl shadow-md hover:bg-black transition-all">
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
        <form method="GET" action="{{ route('admin.reports.members') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Anggota</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama/No/Email..." class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status Anggota</label>
                <select name="status" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pendaftaran Sejak</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="flex items-end gap-3">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Hingga</label>
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nomor Anggota</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email/Telp</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Gabung</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono font-bold text-primary-600">{{ $member->member_number }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $member->name }}</div>
                                <div class="text-[10px] text-gray-400 capitalize">{{ $member->gender ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-600">{{ $member->email }}</div>
                                <div class="text-xs text-gray-500">{{ $member->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $member->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($member->status == 'active')
                                    <span class="px-2 py-1 text-[10px] font-bold bg-green-50 text-green-700 uppercase rounded-full border border-green-100">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-[10px] font-bold bg-red-50 text-red-700 uppercase rounded-full border border-red-100">Non-Aktif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic font-medium">Data anggota tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary (Printed) -->
    <div class="hidden print:block mt-12 bg-gray-50 p-8 rounded-3xl border border-gray-100">
        <div class="grid grid-cols-2 gap-12">
            <div>
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Statistik Keanggotaan</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Total Anggota</span>
                        <span class="text-lg font-bold text-gray-900">{{ $members->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Anggota Aktif</span>
                        <span class="text-lg font-bold text-green-600">{{ $members->where('status', 'active')->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-end">
                <p class="text-xs text-gray-400 italic">Dicetak secara otomatis oleh sistem pada {{ now()->format('d/m/Y H:i') }}</p>
                <div class="mt-8 border-t border-gray-300 w-48 text-center pt-2">
                    <p class="text-xs font-bold text-gray-700">Administrator</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        header, aside, .print\:hidden {
            display: none !important;
        }
        body { background-color: white !important; padding: 0 !important; }
        .min-h-screen { margin-left: 0 !important; }
        main { padding: 0 !important; }
    }
</style>
@endsection
