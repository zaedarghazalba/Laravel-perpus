# Laravel Perpus - Spesifikasi Project

## Overview
Sistem Perpustakaan Digital berbasis Laravel dengan fitur manajemen buku fisik dan ebook untuk admin, serta akses ebook gratis untuk siswa.

## Tech Stack
- **Framework**: Laravel 10.x / 11.x
- **Database**: MySQL 8.0+
- **Frontend**: Blade Template + Bootstrap 5 / Tailwind CSS
- **Authentication**: Laravel Breeze / Sanctum

## Fitur Utama

### 1. Area Publik (Siswa - Tanpa Login)
- **Homepage**: Daftar ebook yang tersedia
- **Katalog Ebook**: Pencarian dan filter ebook
- **Baca Ebook**: PDF viewer / reader online
- **Kategori**: Browse ebook berdasarkan kategori
- **Pencarian**: Search ebook by title, author, category

### 2. Area Admin (Memerlukan Login)

#### Dashboard Admin
- Statistik perpustakaan
- Grafik peminjaman
- Ebook paling populer
- Buku yang perlu dikembalikan

#### Manajemen Buku Fisik
- CRUD buku perpustakaan
- Data: judul, pengarang, penerbit, tahun, ISBN, jumlah stok
- Status ketersediaan
- Kategori buku

#### Peminjaman Buku
- Form peminjaman buku
- Daftar peminjaman aktif
- Riwayat peminjaman
- Pencatatan tanggal pinjam & kembali
- Status: dipinjam, dikembalikan, terlambat
- Denda keterlambatan (opsional)

#### Pengembalian Buku
- Form pengembalian
- Update stok otomatis
- Pencatatan tanggal pengembalian
- Kalkulasi denda (jika ada)

#### Manajemen Ebook
- Upload ebook (PDF)
- CRUD ebook
- Data: judul, pengarang, kategori, cover, file PDF
- Set ebook sebagai published/draft
- Preview ebook

#### Manajemen Data Master
- Kategori buku/ebook
- Data siswa/anggota
- Data petugas perpustakaan

## Database Schema

### Users Table
```sql
id
name
email
password
role (enum: admin, staff)
timestamps
```

### Categories Table
```sql
id
name
slug
description
timestamps
```

### Books Table (Buku Fisik)
```sql
id
title
author
publisher
publication_year
isbn
quantity
available_quantity
category_id
cover_image
description
timestamps
```

### Ebooks Table
```sql
id
title
author
category_id
description
cover_image
file_path (PDF)
file_size
downloads_count
views_count
is_published (boolean)
timestamps
```

### Members Table (Siswa/Anggota)
```sql
id
name
student_id
email
phone
address
join_date
timestamps
```

### Borrowings Table
```sql
id
member_id
book_id
borrow_date
due_date
return_date (nullable)
status (enum: borrowed, returned, overdue)
fine_amount (decimal, nullable)
notes
created_by (user_id)
timestamps
```

### Ebook_Views Table (Tracking)
```sql
id
ebook_id
ip_address
viewed_at
timestamps
```

## Struktur Folder Laravel

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── BookController.php
│   │   │   ├── EbookController.php
│   │   │   ├── BorrowingController.php
│   │   │   ├── MemberController.php
│   │   │   └── CategoryController.php
│   │   └── Public/
│   │       ├── HomeController.php
│   │       └── EbookController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── User.php
│   ├── Book.php
│   ├── Ebook.php
│   ├── Category.php
│   ├── Member.php
│   ├── Borrowing.php
│   └── EbookView.php
└── Services/
    ├── BorrowingService.php
    └── EbookService.php

database/
├── migrations/
│   ├── create_categories_table.php
│   ├── create_books_table.php
│   ├── create_ebooks_table.php
│   ├── create_members_table.php
│   ├── create_borrowings_table.php
│   └── create_ebook_views_table.php
└── seeders/
    ├── UserSeeder.php
    ├── CategorySeeder.php
    └── DatabaseSeeder.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php (Public)
│   │   └── admin.blade.php (Admin)
│   ├── public/
│   │   ├── home.blade.php
│   │   ├── ebooks/
│   │   │   ├── index.blade.php
│   │   │   └── read.blade.php
│   │   └── categories/
│   │       └── show.blade.php
│   └── admin/
│       ├── dashboard.blade.php
│       ├── books/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── ebooks/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── borrowings/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── return.blade.php
│       └── members/
│           ├── index.blade.php
│           ├── create.blade.php
│           └── edit.blade.php

public/
├── uploads/
│   ├── books/
│   │   └── covers/
│   └── ebooks/
│       ├── covers/
│       └── files/

routes/
└── web.php
    ├── Public Routes (/)
    ├── Admin Routes (/admin) - middleware: auth
```

## Routes Structure

```php
// Public Routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/ebooks', [PublicEbookController::class, 'index']);
Route::get('/ebooks/{ebook}', [PublicEbookController::class, 'show']);
Route::get('/ebooks/{ebook}/read', [PublicEbookController::class, 'read']);
Route::get('/categories/{category}', [PublicEbookController::class, 'category']);

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('books', BookController::class);
    Route::resource('ebooks', EbookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('categories', CategoryController::class);

    // Borrowing Routes
    Route::get('/borrowings', [BorrowingController::class, 'index']);
    Route::get('/borrowings/create', [BorrowingController::class, 'create']);
    Route::post('/borrowings', [BorrowingController::class, 'store']);
    Route::get('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnForm']);
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook']);
});
```

## Fitur Tambahan (Opsional)

1. **Sistem Denda**: Otomatis hitung denda keterlambatan
2. **Email Notification**: Reminder sebelum jatuh tempo
3. **QR Code**: Untuk buku dan kartu anggota
4. **Laporan**: Export PDF/Excel untuk laporan perpustakaan
5. **Multi-format Ebook**: Support EPUB selain PDF
6. **Bookmark**: Siswa bisa bookmark halaman ebook
7. **Rating & Review**: Untuk ebook
8. **Recommendation System**: Rekomendasi ebook berdasarkan history

## Security Considerations

1. **File Upload Validation**: Validasi tipe file PDF untuk ebook
2. **File Size Limit**: Batasi ukuran upload ebook (max 50MB)
3. **XSS Protection**: Sanitize input
4. **CSRF Protection**: Laravel default
5. **SQL Injection**: Gunakan Eloquent ORM
6. **Access Control**: Middleware untuk admin area
7. **Secure File Storage**: Gunakan storage link untuk file

## Performance Optimization

1. **Lazy Loading**: untuk relasi database
2. **Caching**: Cache kategori dan ebook populer
3. **Pagination**: Untuk daftar buku dan ebook
4. **Image Optimization**: Compress cover images
5. **CDN**: Untuk static assets (opsional)

## Development Phases

### Phase 1: Setup & Authentication
- Install Laravel
- Setup database
- Implement authentication
- Create admin middleware

### Phase 2: Database & Models
- Buat migrations
- Buat models dan relationships
- Seeders untuk data dummy

### Phase 3: Admin Panel - Book Management
- CRUD buku fisik
- CRUD kategori
- CRUD anggota

### Phase 4: Admin Panel - Borrowing System
- Form peminjaman
- Form pengembalian
- Riwayat peminjaman
- Dashboard statistik

### Phase 5: Admin Panel - Ebook Management
- Upload ebook
- CRUD ebook
- Preview functionality

### Phase 6: Public Area
- Homepage design
- Katalog ebook
- PDF reader integration
- Search & filter

### Phase 7: Testing & Deployment
- Unit testing
- Feature testing
- Deployment setup
- Documentation

## Recommended Packages

```bash
# PDF Viewer
composer require spatie/laravel-pdf

# Image Manipulation
composer require intervention/image

# Excel Export
composer require maatwebsite/excel

# Debugbar (development)
composer require barryvdh/laravel-debugbar --dev
```

## Environment Variables

```env
APP_NAME="Laravel Perpus"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_perpus
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

## Next Steps

1. Install Laravel: `composer create-project laravel/laravel .`
2. Configure `.env` file dengan database MySQL
3. Install Laravel Breeze: `composer require laravel/breeze --dev`
4. Setup authentication: `php artisan breeze:install`
5. Buat migrations sesuai schema di atas
6. Mulai development dari Phase 1
