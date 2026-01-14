<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Permintaan Buku - Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('layouts.navigation')

    <div class="min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Ajukan Permintaan Buku</h1>
                <p class="text-gray-600">
                    Jika buku yang Anda cari tidak tersedia di perpustakaan, silakan ajukan permintaan melalui form di bawah ini.
                    Kami akan meninjau permintaan Anda dan mengusahakan untuk menyediakan buku tersebut.
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('book-requests.store') }}" method="POST">
                    @csrf

                    <!-- Request Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Permintaan <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input
                                    type="radio"
                                    name="request_type"
                                    value="book"
                                    {{ old('request_type', $prefill['request_type'] ?? 'book') == 'book' ? 'checked' : '' }}
                                    class="mr-2"
                                >
                                <span>Buku Fisik</span>
                            </label>
                            <label class="flex items-center">
                                <input
                                    type="radio"
                                    name="request_type"
                                    value="ebook"
                                    {{ old('request_type', $prefill['request_type'] ?? 'book') == 'ebook' ? 'checked' : '' }}
                                    class="mr-2"
                                >
                                <span>E-Book (PDF)</span>
                            </label>
                        </div>
                        @error('request_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Buku <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $prefill['title'] ?? '') }}"
                            required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Masukkan judul buku yang Anda inginkan"
                        >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div class="mb-6">
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                            Penulis / Pengarang
                        </label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="{{ old('author', $prefill['author'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Nama penulis (opsional)"
                        >
                        @error('author')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher -->
                    <div class="mb-6">
                        <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2">
                            Penerbit
                        </label>
                        <input
                            type="text"
                            id="publisher"
                            name="publisher"
                            value="{{ old('publisher') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Nama penerbit (opsional)"
                        >
                        @error('publisher')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div class="mb-6">
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                            ISBN
                        </label>
                        <input
                            type="text"
                            id="isbn"
                            name="isbn"
                            value="{{ old('isbn') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Nomor ISBN (opsional)"
                        >
                        @error('isbn')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan Tambahan
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Tambahkan informasi lain yang membantu kami menemukan buku yang Anda maksud (opsional)"
                        >{{ old('description') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Maksimal 1000 karakter</p>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Catatan:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Permintaan akan ditinjau oleh admin perpustakaan</li>
                                    <li>Anda akan menerima notifikasi jika permintaan disetujui atau ditolak</li>
                                    <li>Waktu pemenuhan permintaan bervariasi tergantung ketersediaan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold"
                        >
                            Kirim Permintaan
                        </button>
                        <a
                            href="{{ route('home') }}"
                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold"
                        >
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- My Requests Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('book-requests.index') }}" class="text-indigo-600 hover:text-indigo-800">
                    Lihat Permintaan Saya →
                </a>
            </div>
        </div>
    </div>
</body>
</html>
