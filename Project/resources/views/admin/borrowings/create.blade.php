@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Tambah Peminjaman Baru</h2>
            <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.borrowings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="member_id" class="block text-sm font-medium text-gray-700">Anggota *</label>
                    <select name="member_id" id="member_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('member_id') border-red-500 @enderror">
                        <option value="">Pilih Anggota</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->student_id }} - {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="book_id" class="block text-sm font-medium text-gray-700">Buku *</label>
                    <select name="book_id" id="book_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('book_id') border-red-500 @enderror">
                        <option value="">Pilih Buku</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} - {{ $book->author }} (Tersedia: {{ $book->available_quantity }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($books->count() == 0)
                        <p class="mt-1 text-sm text-yellow-600">Tidak ada buku yang tersedia untuk dipinjam.</p>
                    @endif
                </div>

                <div>
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700">Tanggal Pinjam *</label>
                    <input type="date" name="borrow_date" id="borrow_date"
                        value="{{ old('borrow_date', date('Y-m-d')) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('borrow_date') border-red-500 @enderror">
                    @error('borrow_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Jatuh Tempo *</label>
                    <input type="date" name="due_date" id="due_date"
                        value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Default: 7 hari dari tanggal pinjam</p>
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Perhatian:</strong>
                        </p>
                        <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside">
                            <li>Pastikan anggota tidak memiliki buku yang terlambat dikembalikan</li>
                            <li>Buku yang dipilih harus tersedia (stok > 0)</li>
                            <li>Denda keterlambatan: Rp 1,000/hari</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto calculate due date when borrow date changes
document.getElementById('borrow_date').addEventListener('change', function() {
    const borrowDate = new Date(this.value);
    const dueDate = new Date(borrowDate);
    dueDate.setDate(dueDate.getDate() + 7);

    const dueDateInput = document.getElementById('due_date');
    dueDateInput.value = dueDate.toISOString().split('T')[0];
});
</script>
@endsection
