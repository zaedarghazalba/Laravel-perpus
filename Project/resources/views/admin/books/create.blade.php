@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Tambah Buku Baru</h2>
            <a href="{{ route('admin.books.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Buku *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        ✨ Klasifikasi akan otomatis terisi berdasarkan kata kunci judul
                    </p>
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">Penulis *</label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('author') border-red-500 @enderror">
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="publisher" class="block text-sm font-medium text-gray-700">Penerbit</label>
                    <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('publisher') border-red-500 @enderror">
                    @error('publisher')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('isbn') border-red-500 @enderror">
                    @error('isbn')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="publication_year" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                    <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year') }}" min="1000" max="{{ date('Y') + 1 }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('publication_year') border-red-500 @enderror">
                    @error('publication_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori *</label>
                    <select name="category_id" id="category_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Barcode -->
                <div>
                    <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
                    <div class="flex gap-2 mt-1">
                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}"
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('barcode') border-red-500 @enderror"
                            placeholder="Scan atau ketik manual">
                        <button type="button" onclick="openBarcodeScanner('barcode')"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            Scan
                        </button>
                    </div>
                    @error('barcode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">📷 Klik tombol Scan untuk memindai barcode dengan kamera</p>
                </div>

                <!-- Klasifikasi DDC dengan Auto-Suggest -->
                <div class="relative">
                    <label for="classification_search" class="block text-sm font-medium text-gray-700">
                        Klasifikasi DDC
                        <span class="text-xs text-gray-500 font-normal">(Ketik untuk cari langsung)</span>
                    </label>
                    <input type="text" id="classification_search"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        placeholder="Ketik: isl, kom, nov, mat, fis..."
                        autocomplete="off">
                    <input type="hidden" name="classification_code" id="classification_code" value="{{ old('classification_code') }}">

                    <!-- Auto-suggest dropdown -->
                    <div id="classification_suggestions" class="hidden absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md overflow-auto border border-gray-200">
                        <div class="py-2">
                            <!-- Suggestions akan muncul di sini -->
                        </div>
                    </div>

                    <!-- Selected classification display -->
                    <div id="selected_classification" class="hidden mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-blue-900" id="selected_code"></span>
                                <span class="text-sm text-blue-700 ml-2" id="selected_name"></span>
                            </div>
                            <button type="button" onclick="clearClassification()" class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    @error('classification_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        ⚡ <span class="font-semibold">Pencarian real-time</span> - ketik 2-3 huruf dan pilihan langsung muncul!
                    </p>
                </div>

                <!-- Call Number (Auto-generated) -->
                <div>
                    <label for="call_number" class="block text-sm font-medium text-gray-700">
                        Nomor Panggil
                        <span class="text-xs text-gray-500 font-normal">(Otomatis)</span>
                    </label>
                    <input type="text" name="call_number" id="call_number" value="{{ old('call_number') }}" readonly
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm"
                        placeholder="Auto-generate dari klasifikasi">
                    <p class="mt-1 text-xs text-gray-500">Format: [Kode] [3 huruf penulis] [1 huruf judul]</p>
                </div>

                <!-- Shelf Location -->
                <div>
                    <label for="shelf_location" class="block text-sm font-medium text-gray-700">
                        Lokasi Rak
                        <span class="text-xs text-gray-500 font-normal">(Otomatis dari klasifikasi)</span>
                    </label>
                    <input type="text" name="shelf_location" id="shelf_location" value="{{ old('shelf_location') }}" readonly
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm"
                        placeholder="Auto-generate dari klasifikasi">
                    @error('shelf_location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">💡 Lokasi otomatis berdasarkan kode klasifikasi</p>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah Stok *</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required min="0"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('quantity') border-red-500 @enderror">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Jumlah total buku yang tersedia</p>
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Buku</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/jpeg,image/jpg,image/png"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('cover_image') border-red-500 @enderror">
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.books.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
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
// Data klasifikasi DDC (akan di-load dari server)
let classifications = @json($classifications ?? []);

// Auto-suggest berdasarkan input
const searchInput = document.getElementById('classification_search');
const suggestionsDiv = document.getElementById('classification_suggestions');
const hiddenInput = document.getElementById('classification_code');
const selectedDiv = document.getElementById('selected_classification');
const titleInput = document.getElementById('title');
const authorInput = document.getElementById('author');
const callNumberInput = document.getElementById('call_number');

// Debounce function untuk performa
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Function untuk search klasifikasi
function searchClassifications(query) {
    query = query ? query.toLowerCase().trim() : '';

    // Jika tidak ada query, sembunyikan suggestions
    if (!query || query.length === 0) {
        suggestionsDiv.classList.add('hidden');
        return;
    }

    // Filter klasifikasi berdasarkan query - bahkan dengan 1 karakter
    let results = classifications.filter(c => {
        const code = c.code.toLowerCase();
        const name = c.name.toLowerCase();
        const desc = c.description ? c.description.toLowerCase() : '';

        // Cari di code, name, atau description
        return code.includes(query) ||
               name.includes(query) ||
               desc.includes(query);
    });

    // Prioritaskan hasil yang match di awal kata
    results.sort((a, b) => {
        const aCode = a.code.toLowerCase();
        const aName = a.name.toLowerCase();
        const bCode = b.code.toLowerCase();
        const bName = b.name.toLowerCase();

        // Prioritas 1: Code exact match atau dimulai dengan query
        if (aCode === query || aCode.startsWith(query)) return -1;
        if (bCode === query || bCode.startsWith(query)) return 1;

        // Prioritas 2: Name dimulai dengan query
        if (aName.startsWith(query)) return -1;
        if (bName.startsWith(query)) return 1;

        // Prioritas 3: Name mengandung query di awal kata
        const aWordStart = aName.includes(' ' + query);
        const bWordStart = bName.includes(' ' + query);
        if (aWordStart && !bWordStart) return -1;
        if (!aWordStart && bWordStart) return 1;

        return 0;
    });

    // Limit hasil
    results = results.slice(0, 15);

    displaySuggestions(results);
}

// Function untuk display suggestions
function displaySuggestions(results) {
    const container = suggestionsDiv.querySelector('div');

    if (results.length === 0) {
        container.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">Tidak ada hasil ditemukan</div>';
        suggestionsDiv.classList.remove('hidden');
        return;
    }

    container.innerHTML = results.map(c => `
        <button type="button"
                onclick="selectClassification('${c.code}', '${c.name.replace(/'/g, "\\'")}', event)"
                class="w-full text-left px-4 py-2 hover:bg-blue-50 transition-colors">
            <div class="flex items-center">
                <span class="font-semibold text-blue-900 mr-2">${c.code}</span>
                <span class="text-sm text-gray-700">${c.name}</span>
            </div>
            ${c.description ? `<div class="text-xs text-gray-500 mt-1">${c.description}</div>` : ''}
        </button>
    `).join('');

    suggestionsDiv.classList.remove('hidden');
}

// Function untuk select klasifikasi
function selectClassification(code, name, event) {
    event.preventDefault();

    // Set hidden input
    hiddenInput.value = code;

    // Show selected
    document.getElementById('selected_code').textContent = code;
    document.getElementById('selected_name').textContent = name;
    selectedDiv.classList.remove('hidden');

    // Clear search input
    searchInput.value = '';
    suggestionsDiv.classList.add('hidden');

    // Auto-generate call number
    generateCallNumber();

    // Auto-generate shelf location
    const shelfLocationInput = document.getElementById('shelf_location');
    shelfLocationInput.value = generateShelfLocation(code);
}

// Function untuk clear selection
function clearClassification() {
    hiddenInput.value = '';
    selectedDiv.classList.add('hidden');
    callNumberInput.value = '';
    document.getElementById('shelf_location').value = '';
}

// Function untuk generate shelf location from classification code
function generateShelfLocation(classificationCode) {
    if (!classificationCode) {
        return '';
    }

    // Extract main class (first digit/digits before decimal)
    const mainClass = parseInt(classificationCode);

    // Determine rack based on Dewey Decimal Classification
    const rackMap = {
        0: 'Rak A', // 000-099: Computer science, information & general works
        1: 'Rak B', // 100-199: Philosophy & psychology
        2: 'Rak C', // 200-299: Religion
        3: 'Rak D', // 300-399: Social sciences
        4: 'Rak E', // 400-499: Language
        5: 'Rak F', // 500-599: Science
        6: 'Rak G', // 600-699: Technology
        7: 'Rak H', // 700-799: Arts & recreation
        8: 'Rak I', // 800-899: Literature
        9: 'Rak J', // 900-999: History & geography
    };

    const rackLetter = rackMap[Math.floor(mainClass / 100)] || 'Rak A';

    // Determine shelf number based on tens digit
    const shelfNumber = Math.floor((mainClass % 100) / 10) + 1;

    return `${rackLetter}-${shelfNumber}`;
}

// Function untuk generate call number
function generateCallNumber() {
    const code = hiddenInput.value;
    const author = authorInput.value;
    const title = titleInput.value;

    if (!code || !author || !title) {
        return;
    }

    // Format: [Code] [3 huruf penulis] [1 huruf judul]
    const authorPart = author.substring(0, 3).toUpperCase();
    const titlePart = title.substring(0, 1).toLowerCase();

    callNumberInput.value = `${code} ${authorPart} ${titlePart}`;
}

// Smart auto-suggest saat ketik judul
titleInput.addEventListener('input', debounce(function() {
    const title = this.value.toLowerCase();

    if (title.length < 3) {
        // Clear classification jika judul terlalu pendek
        return;
    }

    // Kata kunci untuk auto-suggest (diperluas)
    const keywords = {
        'komputer': ['000', '004', '005'],
        'program': ['005', '005.1'],
        'algoritma': ['005.1'],
        'struktur data': ['005.1'],
        'python': ['005.133'],
        'java': ['005.133'],
        'javascript': ['005.133'],
        'c++': ['005.133'],
        'php': ['005.133'],
        'ai': ['006.3'],
        'kecerdasan buatan': ['006.3'],
        'machine learning': ['006.31'],
        'web': ['006.7'],
        'database': ['005.74'],
        'agama': ['200', '297'],
        'islam': ['297'],
        'al-quran': ['297.1'],
        'quran': ['297.1'],
        'tafsir': ['297.1'],
        'hadis': ['297.1'],
        'hadits': ['297.1'],
        'fiqh': ['297.3'],
        'fiqih': ['297.3'],
        'novel': ['899.221'],
        'sastra': ['800', '899'],
        'fiksi': ['899.221'],
        'cerita': ['899.221'],
        'indonesia': ['959.8', '899.221'],
        'sejarah': ['900', '959'],
        'ekonomi': ['330'],
        'bisnis': ['650'],
        'manajemen': ['658'],
        'psikologi': ['150'],
        'filsafat': ['100', '188'],
        'stoik': ['188'],
        'teras': ['188'],
        'matematika': ['510'],
        'fisika': ['530'],
        'kimia': ['540'],
        'biologi': ['570'],
        'kedokteran': ['610'],
        'dongeng': ['398.2'],
        'komik': ['741.5'],
        'kamus': ['499.221'],
        'ensiklopedia': ['030'],
        'biografi': ['92']
    };

    // Cari keyword yang match dan auto-select klasifikasi pertama
    for (const [keyword, codes] of Object.entries(keywords)) {
        if (title.includes(keyword)) {
            const suggestedClassifications = classifications.filter(c =>
                codes.some(code => c.code.startsWith(code))
            );

            if (suggestedClassifications.length > 0) {
                // Auto-select klasifikasi pertama yang paling spesifik
                const bestMatch = suggestedClassifications.sort((a, b) => {
                    // Prioritaskan yang lebih spesifik (kode lebih panjang)
                    return b.code.length - a.code.length;
                })[0];

                // Auto-fill classification
                hiddenInput.value = bestMatch.code;
                document.getElementById('selected_code').textContent = bestMatch.code;
                document.getElementById('selected_name').textContent = bestMatch.name;
                selectedDiv.classList.remove('hidden');

                // Auto-generate call number dan shelf location
                generateCallNumber();
                document.getElementById('shelf_location').value = generateShelfLocation(bestMatch.code);

                return;
            }
        }
    }
}, 600));

// Event listener untuk search input - langsung tanpa debounce untuk responsif
searchInput.addEventListener('input', function() {
    const query = this.value;

    // Langsung tampilkan suggestions bahkan dengan 1 karakter
    searchClassifications(query);
});

// Auto-generate call number saat author atau title berubah
authorInput.addEventListener('input', debounce(generateCallNumber, 500));
titleInput.addEventListener('change', generateCallNumber);

// Close suggestions saat click di luar
document.addEventListener('click', function(event) {
    if (!searchInput.contains(event.target) && !suggestionsDiv.contains(event.target)) {
        suggestionsDiv.classList.add('hidden');
    }
});

// Show suggestions saat focus pada search input
searchInput.addEventListener('focus', function() {
    // Hanya tampilkan suggestions jika ada input
    if (this.value && this.value.trim().length > 0) {
        searchClassifications(this.value);
    }
    // Jika tidak ada input, jangan tampilkan apa-apa (user belum ketik)
});
</script>
@endsection
