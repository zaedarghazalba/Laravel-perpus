@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Pengembalian Buku</h2>
            <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <!-- Borrowing Info -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Informasi Peminjaman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Anggota</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $borrowing->member->name }}</p>
                    <p class="text-sm text-gray-500">{{ $borrowing->member->student_id }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Buku</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $borrowing->book->title }}</p>
                    <p class="text-sm text-gray-500">{{ $borrowing->book->author }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Tanggal Pinjam</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $borrowing->borrow_date->format('d F Y') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Jatuh Tempo</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $borrowing->due_date->format('d F Y') }}</p>
                    @if($borrowing->due_date->isPast())
                        <p class="text-sm text-red-600 font-semibold">Terlambat {{ $borrowing->due_date->diffInDays(now()) }} hari</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Return Form -->
        <form action="{{ route('admin.borrowings.processReturn', $borrowing) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700">Tanggal Kembali *</label>
                    <input type="date" name="return_date" id="return_date"
                        value="{{ old('return_date', date('Y-m-d')) }}" required
                        max="{{ date('Y-m-d') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('return_date') border-red-500 @enderror">
                    @error('return_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fine_amount" class="block text-sm font-medium text-gray-700">Denda (Opsional)</label>
                    <input type="number" name="fine_amount" id="fine_amount" min="0" step="1000"
                        value="{{ old('fine_amount') }}"
                        placeholder="Otomatis dihitung jika terlambat"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fine_amount') border-red-500 @enderror">
                    @error('fine_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Kosongkan untuk perhitungan otomatis (Rp 1,000/hari)</p>
                </div>
            </div>

            <!-- Fine Calculation Display -->
            <div id="fineCalculation" class="hidden bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Perhitungan Denda:</strong>
                        </p>
                        <p id="fineText" class="mt-1 text-sm text-yellow-700"></p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Setelah dikembalikan, stok buku akan bertambah secara otomatis.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Batal
                </a>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Proses Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const borrowDate = new Date('{{ $borrowing->borrow_date->format('Y-m-d') }}');
const dueDate = new Date('{{ $borrowing->due_date->format('Y-m-d') }}');
const returnDateInput = document.getElementById('return_date');
const fineCalculation = document.getElementById('fineCalculation');
const fineText = document.getElementById('fineText');

returnDateInput.setAttribute('min', '{{ $borrowing->borrow_date->format('Y-m-d') }}');

function calculateFine() {
    const returnDate = new Date(returnDateInput.value);

    if (returnDate > dueDate) {
        const diffTime = Math.abs(returnDate - dueDate);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const fine = diffDays * 1000;

        fineCalculation.classList.remove('hidden');
        fineText.textContent = `Terlambat ${diffDays} hari × Rp 1,000 = Rp ${fine.toLocaleString('id-ID')}`;
    } else {
        fineCalculation.classList.add('hidden');
    }
}

returnDateInput.addEventListener('change', calculateFine);

// Initial calculation
calculateFine();
</script>
@endsection
