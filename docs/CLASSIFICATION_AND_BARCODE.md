# 📚 Fitur Klasifikasi & Barcode Scanning

**Created:** 13 Januari 2026
**Status:** ✅ Database & Models Ready | 🟡 Implementation In Progress

---

## 📋 Daftar Isi

1. [Overview](#overview)
2. [Struktur Database](#struktur-database)
3. [Sistem Klasifikasi DDC](#sistem-klasifikasi-ddc)
4. [Model & Relationships](#model--relationships)
5. [Implementasi Barcode](#implementasi-barcode)
6. [Barcode Scanner](#barcode-scanner)
7. [API Endpoints](#api-endpoints)
8. [Usage Examples](#usage-examples)

---

## 🎯 Overview

Fitur ini menambahkan kemampuan untuk:

### ✅ Sudah Diimplementasi
- ✅ Database schema untuk klasifikasi dan barcode
- ✅ Model Classification dengan relationships
- ✅ Dewey Decimal Classification (DDC) system dengan 100+ klasifikasi
- ✅ Fields baru di Books & Ebooks: barcode, classification_code, call_number, shelf_location

### 🟡 Perlu Diimplementasi
- 🟡 Form input dengan dropdown klasifikasi
- 🟡 Auto-generate barcode untuk buku baru
- 🟡 Print barcode label
- 🟡 Barcode scanner menggunakan kamera
- 🟡 API endpoint untuk search by barcode
- 🟡 Quick input menggunakan barcode scanner

---

## 🗄️ Struktur Database

### Tabel `classifications`

Menyimpan master data klasifikasi perpustakaan dengan sistem hierarki.

```sql
CREATE TABLE classifications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(20) UNIQUE NOT NULL,          -- Kode DDC (contoh: 005.1, 004.6)
    name VARCHAR(255) NOT NULL,                -- Nama klasifikasi (Indonesia)
    description TEXT NULL,                     -- Deskripsi (English)
    parent_code VARCHAR(20) NULL,              -- Parent code untuk hierarki
    level INT DEFAULT 1,                       -- Level hierarki (1=main, 2=sub, etc)
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_code (code),
    INDEX idx_parent_code (parent_code)
);
```

### Field Baru di Tabel `books`

```sql
ALTER TABLE books ADD COLUMN (
    barcode VARCHAR(50) UNIQUE NULL,           -- Barcode unik untuk scanning
    classification_code VARCHAR(20) NULL,      -- Kode klasifikasi DDC
    call_number VARCHAR(50) NULL,              -- Nomor panggil lengkap
    shelf_location VARCHAR(50) NULL            -- Lokasi rak fisik
);
```

### Field Baru di Tabel `ebooks`

```sql
ALTER TABLE ebooks ADD COLUMN (
    barcode VARCHAR(50) UNIQUE NULL,           -- Barcode unik
    classification_code VARCHAR(20) NULL,      -- Kode klasifikasi DDC
    call_number VARCHAR(50) NULL               -- Nomor panggil lengkap
);
```

---

## 📖 Sistem Klasifikasi DDC

### Dewey Decimal Classification

Sistem perpustakaan standar internasional dengan 10 kelas utama:

| Kode | Nama Klasifikasi | Contoh |
|------|------------------|--------|
| **000** | Ilmu Komputer, Informasi & Karya Umum | 005 - Pemrograman Komputer |
| **100** | Filsafat & Psikologi | 150 - Psikologi |
| **200** | Agama | 297 - Islam |
| **300** | Ilmu Sosial | 330 - Ekonomi, 370 - Pendidikan |
| **400** | Bahasa | 420 - Bahasa Inggris, 499 - Bahasa Indonesia |
| **500** | Sains | 510 - Matematika, 570 - Biologi |
| **600** | Teknologi | 610 - Kedokteran, 650 - Manajemen |
| **700** | Seni & Rekreasi | 780 - Musik, 790 - Olahraga |
| **800** | Sastra | 820 - Sastra Inggris, 899 - Sastra Indonesia |
| **900** | Sejarah & Geografi | 920 - Biografi, 959.8 - Sejarah Indonesia |

### Hierarki Klasifikasi

Sistem DDC memiliki hierarki 4 level:

```
000 - Ilmu Komputer (Level 1: Main)
 └── 004 - Pemrosesan Data & Ilmu Komputer (Level 2: Sub)
      └── 005 - Pemrograman Komputer (Level 3: Detail)
           └── 005.1 - Bahasa Pemrograman Tertentu (Level 4: Specific)
```

### Contoh Klasifikasi

**Buku: "Clean Code" by Robert C. Martin**
- **Classification Code:** `005.1`
- **Call Number:** `005.1 MAR c`
- **Shelf Location:** `Rak A-1`
- **Barcode:** `BC001234567890`

**Format Call Number:**
```
[Classification] [Author First 3 Letters] [Title First Letter]
005.1            MAR                       c
```

---

## 🔧 Model & Relationships

### Model Classification

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'parent_code', 'level'
    ];

    // Parent classification
    public function parent()
    {
        return $this->belongsTo(Classification::class, 'parent_code', 'code');
    }

    // Children classifications
    public function children()
    {
        return $this->hasMany(Classification::class, 'parent_code', 'code');
    }

    // Books using this classification
    public function books()
    {
        return $this->hasMany(Book::class, 'classification_code', 'code');
    }

    // Ebooks using this classification
    public function ebooks()
    {
        return $this->hasMany(Ebook::class, 'classification_code', 'code');
    }

    // Scope: Main classifications
    public function scopeMainClassifications($query)
    {
        return $query->where('level', 1)->orderBy('code');
    }
}
```

### Updated Book Model

```php
protected $fillable = [
    // ... existing fields
    'barcode',
    'classification_code',
    'call_number',
    'shelf_location',
];

public function classification()
{
    return $this->belongsTo(Classification::class, 'classification_code', 'code');
}
```

### Updated Ebook Model

```php
protected $fillable = [
    // ... existing fields
    'barcode',
    'classification_code',
    'call_number',
];

public function classification()
{
    return $this->belongsTo(Classification::class, 'classification_code', 'code');
}
```

---

## 🔢 Implementasi Barcode

### 1. Generate Barcode untuk Buku Baru

Gunakan package PHP Barcode Generator:

```bash
composer require picqer/php-barcode-generator
```

### 2. Auto-Generate Barcode di Controller

```php
use Picqer\Barcode\BarcodeGeneratorPNG;

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required',
        'author' => 'required',
        'classification_code' => 'nullable|exists:classifications,code',
        // ... other fields
    ]);

    // Auto-generate barcode jika tidak ada
    if (empty($validated['barcode'])) {
        $validated['barcode'] = $this->generateUniqueBarcode();
    }

    // Auto-generate call number
    if (!empty($validated['classification_code'])) {
        $validated['call_number'] = $this->generateCallNumber(
            $validated['classification_code'],
            $validated['author'],
            $validated['title']
        );
    }

    $book = Book::create($validated);

    return redirect()->route('admin.books.index')
        ->with('success', 'Buku berhasil ditambahkan!');
}

private function generateUniqueBarcode()
{
    do {
        // Format: BC + timestamp + random
        $barcode = 'BC' . time() . rand(1000, 9999);
    } while (Book::where('barcode', $barcode)->exists());

    return $barcode;
}

private function generateCallNumber($classificationCode, $author, $title)
{
    $authorCode = strtoupper(substr($author, 0, 3));
    $titleCode = strtolower(substr($title, 0, 1));

    return "{$classificationCode} {$authorCode} {$titleCode}";
}
```

### 3. Generate Barcode Image

```php
public function printBarcode($id)
{
    $book = Book::findOrFail($id);

    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode(
        $book->barcode,
        $generator::TYPE_CODE_128,
        3,
        50
    );

    return response($barcode)->header('Content-Type', 'image/png');
}
```

### 4. View untuk Print Barcode Label

```blade
<!-- resources/views/admin/books/barcode.blade.php -->
<div class="barcode-label" style="width: 300px; padding: 20px; border: 1px solid #000;">
    <div class="text-center">
        <h4>{{ $book->title }}</h4>
        <p>{{ $book->author }}</p>
        <p><strong>{{ $book->call_number }}</strong></p>
        <img src="{{ route('admin.books.barcode-image', $book->id) }}" alt="Barcode">
        <p style="font-family: monospace;">{{ $book->barcode }}</p>
        <p><small>{{ $book->shelf_location }}</small></p>
    </div>
</div>

<script>
    window.print();
</script>
```

---

## 📷 Barcode Scanner

### 1. Install QuaggaJS

QuaggaJS adalah library JavaScript untuk barcode scanning menggunakan kamera.

```html
<!-- Add to layout -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
```

### 2. Scanner Component

```html
<!-- resources/views/admin/books/scanner.blade.php -->
<div class="scanner-container">
    <div id="interactive" class="viewport"></div>
    <button id="start-scan" class="btn btn-primary">Mulai Scan</button>
    <button id="stop-scan" class="btn btn-secondary">Stop Scan</button>

    <div id="result" class="mt-4">
        <h4>Hasil Scan:</h4>
        <input type="text" id="barcode-input" class="form-control" readonly>
    </div>
</div>

<style>
    #interactive.viewport {
        width: 100%;
        height: 400px;
        border: 2px solid #007FFF;
    }

    #interactive.viewport canvas,
    #interactive.viewport video {
        width: 100%;
        height: 100%;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startButton = document.getElementById('start-scan');
    const stopButton = document.getElementById('stop-scan');
    const barcodeInput = document.getElementById('barcode-input');

    startButton.addEventListener('click', function() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#interactive'),
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment"
                },
            },
            decoder: {
                readers: [
                    "code_128_reader",
                    "ean_reader",
                    "ean_8_reader",
                    "code_39_reader",
                    "code_39_vin_reader",
                    "codabar_reader",
                    "upc_reader",
                    "upc_e_reader",
                    "i2of5_reader"
                ],
                debug: {
                    drawBoundingBox: true,
                    showFrequency: true,
                    drawScanline: true,
                    showPattern: true
                }
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            numOfWorkers: 4,
            locate: true
        }, function(err) {
            if (err) {
                console.error(err);
                alert('Error mengakses kamera: ' + err.message);
                return;
            }
            console.log("Scanner initialized");
            Quagga.start();
        });
    });

    stopButton.addEventListener('click', function() {
        Quagga.stop();
    });

    Quagga.onDetected(function(result) {
        const code = result.codeResult.code;
        console.log("Barcode detected:", code);

        barcodeInput.value = code;

        // Auto search buku
        searchBookByBarcode(code);

        // Stop scanner setelah detect
        Quagga.stop();
    });

    function searchBookByBarcode(barcode) {
        fetch(`/api/books/search-by-barcode?barcode=${barcode}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect ke halaman edit atau auto-fill form
                    window.location.href = `/admin/books/${data.book.id}/edit`;
                } else {
                    alert('Buku tidak ditemukan!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari buku');
            });
    }
});
</script>
```

### 3. Scanner di Form Input Peminjaman

```blade
<!-- resources/views/admin/borrowings/create.blade.php -->
<div class="form-group">
    <label>Scan Barcode Buku</label>
    <div class="input-group">
        <input type="text" name="barcode" id="book-barcode" class="form-control" placeholder="Scan atau ketik barcode">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scannerModal">
            <i class="fas fa-barcode"></i> Scan
        </button>
    </div>
</div>

<!-- Scanner Modal -->
<div class="modal fade" id="scannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan Barcode Buku</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('admin.books.scanner-component')
            </div>
        </div>
    </div>
</div>
```

---

## 🔌 API Endpoints

### 1. Search Book by Barcode

**Route:**
```php
// routes/api.php
Route::get('/books/search-by-barcode', [BookController::class, 'searchByBarcode']);
```

**Controller:**
```php
public function searchByBarcode(Request $request)
{
    $barcode = $request->input('barcode');

    $book = Book::where('barcode', $barcode)
        ->with(['category', 'classification'])
        ->first();

    if (!$book) {
        return response()->json([
            'success' => false,
            'message' => 'Buku tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'book' => [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'isbn' => $book->isbn,
            'barcode' => $book->barcode,
            'classification_code' => $book->classification_code,
            'call_number' => $book->call_number,
            'shelf_location' => $book->shelf_location,
            'available_quantity' => $book->available_quantity,
            'category' => $book->category?->name,
            'classification' => $book->classification?->name,
        ]
    ]);
}
```

### 2. Get Classifications

**Route:**
```php
Route::get('/classifications', [ClassificationController::class, 'index']);
Route::get('/classifications/{code}/children', [ClassificationController::class, 'getChildren']);
```

**Controller:**
```php
public function index(Request $request)
{
    $level = $request->input('level', 1);

    $classifications = Classification::where('level', $level)
        ->orderBy('code')
        ->get();

    return response()->json([
        'success' => true,
        'classifications' => $classifications
    ]);
}

public function getChildren($code)
{
    $children = Classification::where('parent_code', $code)
        ->orderBy('code')
        ->get();

    return response()->json([
        'success' => true,
        'children' => $children
    ]);
}
```

---

## 💡 Usage Examples

### 1. Menambah Buku dengan Klasifikasi

```php
// Controller
$book = Book::create([
    'title' => 'Clean Code',
    'author' => 'Robert C. Martin',
    'isbn' => '978-0132350884',
    'barcode' => 'BC20260113001',
    'classification_code' => '005.1',
    'call_number' => '005.1 MAR c',
    'shelf_location' => 'Rak A-1',
    'quantity' => 3,
    'available_quantity' => 3,
]);
```

### 2. Query Buku by Klasifikasi

```php
// Cari semua buku pemrograman (005.x)
$books = Book::where('classification_code', 'LIKE', '005%')
    ->with('classification')
    ->get();

// Cari buku di rak tertentu
$books = Book::where('shelf_location', 'Rak A-1')->get();
```

### 3. Hierarki Klasifikasi

```php
// Get main classifications
$mainClassifications = Classification::mainClassifications()->get();

// Get all computer science books (000-099)
$computerBooks = Book::whereBetween('classification_code', ['000', '099'])
    ->get();

// Get classification with children
$classification = Classification::with('children')->where('code', '000')->first();
```

### 4. Form Dropdown Klasifikasi

```blade
<select name="classification_code" class="form-control">
    <option value="">-- Pilih Klasifikasi --</option>
    @foreach($classifications as $classification)
        <option value="{{ $classification->code }}">
            {{ $classification->code }} - {{ $classification->name }}
        </option>
    @endforeach
</select>
```

---

## 📝 Checklist Implementasi

### ✅ Database & Models (SELESAI)
- [x] Migration untuk field baru
- [x] Tabel classifications
- [x] Model Classification
- [x] Update Book model
- [x] Update Ebook model
- [x] Seeder dengan 100+ klasifikasi DDC

### 🟡 Form & UI (IN PROGRESS)
- [ ] Update form create/edit book dengan klasifikasi
- [ ] Dropdown klasifikasi dengan search
- [ ] Field untuk barcode, call number, shelf location
- [ ] Auto-generate call number
- [ ] Auto-generate barcode

### 🟡 Barcode Features (TODO)
- [ ] Install picqer/php-barcode-generator
- [ ] Generate barcode image
- [ ] Print barcode label view
- [ ] Barcode scanner component (QuaggaJS)
- [ ] Scanner modal di form peminjaman
- [ ] Quick input dengan scan

### 🟡 API & Integration (TODO)
- [ ] API endpoint search by barcode
- [ ] API endpoint get classifications
- [ ] API endpoint get classification children
- [ ] JavaScript untuk scanner integration
- [ ] Auto-fill form setelah scan

---

## 🚀 Next Steps

### Priority 1: Update Book Form
1. Tambahkan dropdown klasifikasi
2. Tambahkan field barcode, call number, shelf location
3. Auto-generate call number berdasarkan klasifikasi
4. Auto-generate barcode untuk buku baru

### Priority 2: Barcode Generation
1. Install picqer/php-barcode-generator
2. Generate barcode image di controller
3. Buat view untuk print barcode label
4. Tambahkan tombol "Print Barcode" di detail buku

### Priority 3: Barcode Scanner
1. Implementasi QuaggaJS scanner
2. Buat scanner component yang reusable
3. Integrasikan scanner di form peminjaman
4. Quick input untuk return buku

---

## 📚 Resources

- **Dewey Decimal Classification:** https://www.oclc.org/dewey.en.html
- **QuaggaJS:** https://github.com/ericblade/quagga2
- **PHP Barcode Generator:** https://github.com/picqer/php-barcode-generator
- **Library Classification Systems:** https://en.wikipedia.org/wiki/Library_classification

---

## 🔗 Related Documentation

- [SYSTEM_ANALYSIS.md](SYSTEM_ANALYSIS.md) - Analisis fitur sistem
- [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) - Skema database lengkap
- [PROJECT_PROGRESS.md](PROJECT_PROGRESS.md) - Progress tracking

---

**Last Updated:** 13 Januari 2026
**Status:** Database & models ready, implementation in progress
