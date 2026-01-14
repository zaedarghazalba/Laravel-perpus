@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Member Info -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Detail Anggota</h2>
                <div class="space-x-2">
                    <a href="{{ route('admin.members.edit', $member) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500">NIS/NIM</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $member->student_id }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $member->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Email</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $member->email ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Telepon</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $member->phone ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Tanggal Bergabung</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $member->join_date->format('d F Y') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Total Peminjaman</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $member->borrowings->count() }} kali</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500">Alamat</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $member->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowing History -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-xl font-semibold mb-4">Riwayat Peminjaman</h3>

            @if($member->borrowings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($member->borrowings as $borrowing)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $borrowing->book->author }}</div>
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
                                            <span class="text-red-600">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada riwayat peminjaman</p>
            @endif
        </div>
    </div>
</div>
@endsection
