@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Daftar Peminjaman</h2>
            <a href="{{ route('admin.borrowings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Peminjaman
            </a>
        </div>

        <!-- Filters -->
        <div class="mb-6 flex flex-col md:flex-row gap-4">
            <form method="GET" action="{{ route('admin.borrowings.index') }}" class="flex-1">
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Cari anggota atau buku..."
                        value="{{ request('search') }}"
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cari
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <form method="GET" action="{{ route('admin.borrowings.index') }}" class="md:w-48">
                <select name="status" onchange="this.form.submit()"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Anggota
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Buku
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Pinjam
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jatuh Tempo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Kembali
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Denda
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($borrowings as $borrowing)
                        <tr class="{{ $borrowing->status == 'borrowed' && $borrowing->due_date->isPast() ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->member->name }}</div>
                                <div class="text-sm text-gray-500">{{ $borrowing->member->student_id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</div>
                                <div class="text-sm text-gray-500">{{ $borrowing->book->author }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $borrowing->borrow_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $borrowing->due_date->format('d/m/Y') }}
                                @if($borrowing->status == 'borrowed' && $borrowing->due_date->isPast())
                                    <span class="block text-xs text-red-600 font-semibold">
                                        Terlambat {{ $borrowing->due_date->diffInDays(now()) }} hari
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($borrowing->status == 'borrowed')
                                    @if($borrowing->due_date->isPast())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Dipinjam
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Dikembalikan
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>

                                @if($borrowing->status == 'borrowed')
                                    <a href="{{ route('admin.borrowings.return', $borrowing) }}" class="text-green-600 hover:text-green-900 mr-3">Kembalikan</a>
                                @endif

                                @if($borrowing->status == 'returned')
                                    <form action="{{ route('admin.borrowings.destroy', $borrowing) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $borrowings->links() }}
        </div>
    </div>
</div>
@endsection
