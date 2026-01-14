@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Book Lookup</h2>
                <p class="text-gray-600">Scan barcode untuk mencari dan melihat detail buku dengan cepat</p>
            </div>
            <div class="hidden sm:block">
                <svg class="w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z M3 10h18M3 14h18M3 6h18M3 18h18"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Scan Button Area -->
    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-lg shadow-sm p-8 mb-6 text-center border border-indigo-100">
        <button onclick="openQuickLookup()"
                class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 text-white rounded-lg text-lg font-semibold hover:bg-indigo-700 active:bg-indigo-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-indigo-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
            </svg>
            <span>Scan Barcode</span>
        </button>

        <div class="mt-6">
            <p class="text-sm text-gray-600 mb-3">Atau masukkan barcode secara manual:</p>
            <div class="flex gap-2 max-w-md mx-auto">
                <input type="text" id="manual-barcode"
                       placeholder="Ketik barcode di sini..."
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-center"
                       autocomplete="off"
                       onkeypress="if(event.key === 'Enter') searchByManualBarcode()">
                <button onclick="searchByManualBarcode()"
                        class="px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Cari
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-2">Tekan Enter atau klik tombol Cari</p>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loading-indicator" class="hidden bg-white rounded-lg shadow-sm p-8 mb-6">
        <div class="text-center">
            <svg class="animate-spin w-12 h-12 text-indigo-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600 font-medium">Mencari buku...</p>
        </div>
    </div>

    <!-- Result Area -->
    <div id="lookup-result" class="hidden">
        <!-- Book details card will be inserted here -->
    </div>

    <!-- Not Found Message -->
    <div id="not-found-message" class="hidden bg-white rounded-lg shadow-sm p-8 text-center">
        <div class="text-6xl mb-4">🔍</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Buku Tidak Ditemukan</h3>
        <p class="text-gray-600 mb-2">Barcode <span id="searched-barcode" class="font-mono font-bold text-indigo-600"></span> tidak ditemukan dalam database.</p>
        <div class="mt-6 flex gap-3 justify-center">
            <a href="{{ route('admin.books.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Buku Baru
            </a>
            <button onclick="resetLookup()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors">
                Scan Lagi
            </button>
        </div>
    </div>
</div>

<script>
// Open barcode scanner for quick lookup
function openQuickLookup() {
    openBarcodeScanner('manual-barcode', function(barcode) {
        // Callback after successful scan
        performLookup(barcode);
    });
}

// Search by manually entered barcode
function searchByManualBarcode() {
    const barcodeInput = document.getElementById('manual-barcode');
    const barcode = barcodeInput.value.trim();

    if (!barcode) {
        alert('Silakan masukkan barcode');
        barcodeInput.focus();
        return;
    }

    performLookup(barcode);
}

// Perform AJAX lookup
function performLookup(barcode) {
    // Show loading
    document.getElementById('loading-indicator').classList.remove('hidden');
    document.getElementById('lookup-result').classList.add('hidden');
    document.getElementById('not-found-message').classList.add('hidden');

    // Perform AJAX request
    fetch('{{ route("admin.books.lookup.search") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ barcode: barcode })
    })
    .then(response => response.json())
    .then(data => {
        // Hide loading
        document.getElementById('loading-indicator').classList.add('hidden');

        if (data.success && data.book) {
            displayBookResult(data.book);
        } else {
            showNotFound(barcode);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loading-indicator').classList.add('hidden');
        showNotFound(barcode);
    });
}

// Display book result
function displayBookResult(book) {
    const resultDiv = document.getElementById('lookup-result');

    // Build availability badge
    const availabilityBadge = book.available_quantity > 0
        ? `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
             <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                 <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
             </svg>
             Tersedia (${book.available_quantity}/${book.quantity})
           </span>`
        : `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
             <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                 <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
             </svg>
             Tidak Tersedia
           </span>`;

    // Build cover image
    const coverImage = book.cover_image
        ? `<img src="/${book.cover_image}" alt="${book.title}" class="w-full h-full object-cover">`
        : `<div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
             <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
             </svg>
           </div>`;

    const html = `
        <div class="bg-white rounded-lg shadow-sm overflow-hidden animate-fade-in">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <div class="flex items-center text-white">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-semibold">Buku Ditemukan!</span>
                </div>
            </div>

            <!-- Book Card -->
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Cover Image -->
                    <div class="flex-shrink-0">
                        <div class="w-full md:w-48 h-64 rounded-lg overflow-hidden shadow-md">
                            ${coverImage}
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div class="flex-1">
                        <!-- Title -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">${book.title}</h3>

                        <!-- Availability Badge -->
                        <div class="mb-4">
                            ${availabilityBadge}
                        </div>

                        <!-- Details Grid -->
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                            <div>
                                <dt class="font-medium text-gray-500">Penulis</dt>
                                <dd class="text-gray-900 font-semibold">${book.author || '-'}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500">Penerbit</dt>
                                <dd class="text-gray-900">${book.publisher || '-'}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500">ISBN</dt>
                                <dd class="text-gray-900 font-mono">${book.isbn || '-'}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500">Barcode</dt>
                                <dd class="text-gray-900 font-mono font-bold text-indigo-600">${book.barcode || '-'}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500">Kategori</dt>
                                <dd class="text-gray-900">${book.category ? book.category.name : '-'}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500">Klasifikasi</dt>
                                <dd class="text-gray-900">${book.classification_code || '-'} ${book.classification ? '- ' + book.classification.name : ''}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500">Call Number</dt>
                                <dd class="text-gray-900 font-mono">${book.call_number || '-'}</dd>
                            </div>

                            <div>
                                <dt class="font-medium text-gray-500">Lokasi Rak</dt>
                                <dd class="text-gray-900 font-semibold text-purple-700">${book.shelf_location || '-'}</dd>
                            </div>
                        </dl>

                        <!-- Description -->
                        ${book.description ? `
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <dt class="font-medium text-gray-500 mb-1">Deskripsi</dt>
                            <dd class="text-gray-700 text-sm">${book.description}</dd>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 pt-6 border-t border-gray-200 flex flex-wrap gap-3">
                    <a href="/admin/books/${book.id}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
                    </a>
                    <a href="/admin/books/${book.id}/edit"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    ${book.available_quantity > 0 ? `
                    <a href="/admin/borrowings/create?book_id=${book.id}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Pinjamkan Buku
                    </a>
                    ` : ''}
                    <button onclick="resetLookup()"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors ml-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Scan Buku Lain
                    </button>
                </div>
            </div>
        </div>
    `;

    resultDiv.innerHTML = html;
    resultDiv.classList.remove('hidden');

    // Scroll to result
    resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Show not found message
function showNotFound(barcode) {
    document.getElementById('searched-barcode').textContent = barcode;
    document.getElementById('not-found-message').classList.remove('hidden');
}

// Reset lookup
function resetLookup() {
    document.getElementById('manual-barcode').value = '';
    document.getElementById('lookup-result').classList.add('hidden');
    document.getElementById('not-found-message').classList.add('hidden');
    document.getElementById('loading-indicator').classList.add('hidden');

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Focus on manual input when page loads
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('manual-barcode').focus();
});
</script>

<style>
/* Fade-in animation */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection
