# 🚀 Mulai dari Sini - Panduan Pertama Kali

Panduan ini akan memandu Anda langkah demi langkah untuk memulai project Laravel Perpus dari awal sampai siap development.

## 📋 Checklist Persiapan

### 1️⃣ FASE PERSIAPAN (15-30 menit)

**Langkah 1: Pahami Project**
- [ ] Baca file [PROJECT_SPECIFICATION.md](PROJECT_SPECIFICATION.md) untuk memahami:
  - Apa saja fitur yang akan dibangun
  - Tech stack yang digunakan
  - Struktur folder dan database
  - **⏱️ Estimasi waktu:** 10-15 menit

**Langkah 2: Pahami Database**
- [ ] Baca file [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) untuk memahami:
  - Tabel-tabel apa saja yang diperlukan
  - Relasi antar tabel
  - Field-field yang ada di setiap tabel
  - **⏱️ Estimasi waktu:** 10-15 menit

**Langkah 3: Cek Prerequisites**
- [ ] Pastikan sudah terinstall:
  - [ ] PHP >= 8.1 (cek: `php --version`)
  - [ ] Composer (cek: `composer --version`)
  - [ ] MySQL >= 8.0 (cek: `mysql --version`)
  - [ ] Node.js & NPM (cek: `node --version` dan `npm --version`)
  - [ ] Git (cek: `git --version`)

**Jika belum install, download dari:**
- PHP: https://www.php.net/downloads
- Composer: https://getcomposer.org/download/
- MySQL: https://dev.mysql.com/downloads/mysql/
- Node.js: https://nodejs.org/

---

### 2️⃣ FASE INSTALASI (30-45 menit)

**Langkah 4: Install Laravel**
```bash
# Di dalam folder project ini
composer create-project laravel/laravel .

# TUNGGU sampai selesai (bisa 5-10 menit)
```
- [ ] Laravel berhasil terinstall
- [ ] File `.env` sudah ada

**Langkah 5: Setup Database**

a. Buat database MySQL:
```sql
CREATE DATABASE laravel_perpus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

b. Edit file `.env`:
```env
APP_NAME="Laravel Perpus"
DB_DATABASE=laravel_perpus
DB_USERNAME=root
DB_PASSWORD=     # isi sesuai password MySQL Anda
```

- [ ] Database `laravel_perpus` sudah dibuat
- [ ] File `.env` sudah dikonfigurasi

**Langkah 6: Install Authentication (Laravel Breeze)**
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
```
- [ ] Breeze berhasil terinstall
- [ ] NPM build selesai tanpa error

**Langkah 7: Test Aplikasi**
```bash
php artisan serve
```
- [ ] Buka browser: http://localhost:8000
- [ ] Halaman Laravel muncul dengan baik
- [ ] Ada link "Login" dan "Register" di pojok kanan atas

---

### 3️⃣ FASE DEVELOPMENT - DATABASE (1-2 jam)

> 💡 **PENTING**: Ikuti panduan detail di [SETUP_GUIDE.md](SETUP_GUIDE.md) untuk langkah-langkah berikut

**Langkah 8: Buat Struktur Folder Upload**
```bash
# Windows
md public\uploads\books\covers
md public\uploads\ebooks\covers
md public\uploads\ebooks\files

# Linux/Mac
mkdir -p public/uploads/books/covers
mkdir -p public/uploads/ebooks/covers
mkdir -p public/uploads/ebooks/files
```
- [ ] Folder upload sudah dibuat

**Langkah 9: Buat Migrations (Urutan Penting!)**

Jalankan perintah ini **SESUAI URUTAN**:

```bash
# 1. Categories (harus pertama karena dipakai oleh books & ebooks)
php artisan make:migration create_categories_table

# 2. Books
php artisan make:migration create_books_table

# 3. Ebooks
php artisan make:migration create_ebooks_table

# 4. Members
php artisan make:migration create_members_table

# 5. Borrowings
php artisan make:migration create_borrowings_table

# 6. Ebook Views
php artisan make:migration create_ebook_views_table

# 7. Add role to users
php artisan make:migration add_role_to_users_table
```

- [ ] 7 file migration sudah dibuat di folder `database/migrations/`

**Langkah 10: Isi Kode Migration**

Buka setiap file migration dan isi dengan kode yang sesuai berdasarkan [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)

> 📌 **TIP**: Lihat detail spesifikasi tabel di DATABASE_SCHEMA.md untuk setiap field, tipe data, dan relasi

- [ ] Migration `create_categories_table` sudah diisi
- [ ] Migration `create_books_table` sudah diisi
- [ ] Migration `create_ebooks_table` sudah diisi
- [ ] Migration `create_members_table` sudah diisi
- [ ] Migration `create_borrowings_table` sudah diisi
- [ ] Migration `create_ebook_views_table` sudah diisi
- [ ] Migration `add_role_to_users_table` sudah diisi

**Langkah 11: Buat Models**
```bash
php artisan make:model Category
php artisan make:model Book
php artisan make:model Ebook
php artisan make:model Member
php artisan make:model Borrowing
php artisan make:model EbookView
```
- [ ] 6 model sudah dibuat di folder `app/Models/`

**Langkah 12: Konfigurasi Models**

Edit setiap model untuk menambahkan:
- `$fillable` atau `$guarded`
- Relationships (hasMany, belongsTo, dll)
- Casts (jika diperlukan)

- [ ] Semua model sudah dikonfigurasi dengan benar

**Langkah 13: Buat Seeders**
```bash
php artisan make:seeder UserSeeder
php artisan make:seeder CategorySeeder
```

Edit setiap seeder untuk isi data awal:
- UserSeeder: Buat admin default
- CategorySeeder: Buat kategori-kategori buku

- [ ] Seeder sudah dibuat dan dikonfigurasi
- [ ] File `DatabaseSeeder.php` sudah memanggil kedua seeder

**Langkah 14: Run Migration & Seeder**
```bash
php artisan migrate:fresh --seed
```

Jika sukses, Anda akan lihat:
- Semua tabel tercipta di database
- Data seeder masuk ke database

- [ ] Migration berhasil tanpa error
- [ ] Seeder berhasil dijalankan
- [ ] Cek di phpMyAdmin/TablePlus: tabel dan data sudah ada

---

### 4️⃣ FASE DEVELOPMENT - BACKEND (Bertahap)

**Langkah 15: Buat Middleware Admin**
```bash
php artisan make:middleware AdminMiddleware
```
- [ ] Middleware dibuat
- [ ] Middleware didaftarkan di `app/Http/Kernel.php` atau `bootstrap/app.php` (Laravel 11)

**Langkah 16: Buat Controllers**

> 🎯 **Strategi**: Buat controller secara bertahap, sesuai prioritas development

**Prioritas 1 - Admin Dashboard:**
```bash
php artisan make:controller Admin/DashboardController
```

**Prioritas 2 - Manajemen Kategori (Paling mudah, cocok untuk awal):**
```bash
php artisan make:controller Admin/CategoryController --resource
```

**Prioritas 3 - Manajemen Buku:**
```bash
php artisan make:controller Admin/BookController --resource
```

**Prioritas 4 - Manajemen Anggota:**
```bash
php artisan make:controller Admin/MemberController --resource
```

**Prioritas 5 - Manajemen Ebook:**
```bash
php artisan make:controller Admin/EbookController --resource
```

**Prioritas 6 - Peminjaman:**
```bash
php artisan make:controller Admin/BorrowingController
```

**Prioritas 7 - Area Publik:**
```bash
php artisan make:controller Public/HomeController
php artisan make:controller Public/EbookController
```

- [ ] Controllers sudah dibuat sesuai prioritas

**Langkah 17: Setup Routes**

Edit `routes/web.php` dan tambahkan routes sesuai dengan [PROJECT_SPECIFICATION.md](PROJECT_SPECIFICATION.md#routes-structure)

- [ ] Public routes sudah ditambahkan
- [ ] Admin routes dengan middleware auth sudah ditambahkan

---

### 5️⃣ FASE DEVELOPMENT - FRONTEND (Bertahap)

**Langkah 18: Buat Layout Blade**

Buat 2 layout utama:
- `resources/views/layouts/app.blade.php` (untuk public)
- `resources/views/layouts/admin.blade.php` (untuk admin)

**Langkah 19: Buat Views Bertahap**

> 🎯 **Mulai dari yang paling sederhana dulu**

**Mulai dari Admin:**
1. Dashboard (`resources/views/admin/dashboard.blade.php`)
2. Categories (index, create, edit)
3. Members (index, create, edit)
4. Books (index, create, edit)
5. Ebooks (index, create, edit)
6. Borrowings (index, create, return)

**Lalu Public Area:**
1. Home (`resources/views/public/home.blade.php`)
2. Ebooks catalog
3. Ebook reader

---

## 🎯 Alur Development yang Disarankan

```
FASE 1: Setup & Auth (SELESAIKAN DULU!)
├─ Install Laravel ✓
├─ Setup Database ✓
├─ Install Breeze ✓
└─ Test login/register ✓

FASE 2: Database Layer (SELESAIKAN DULU!)
├─ Buat Migrations ✓
├─ Buat Models ✓
├─ Buat Seeders ✓
└─ Run migrate & seed ✓

FASE 3: Admin - Kategori (MULAI DARI SINI!)
├─ CategoryController ✓
├─ Routes kategori ✓
├─ Views kategori (index, create, edit) ✓
└─ Test CRUD kategori ✓

FASE 4: Admin - Anggota
├─ MemberController ✓
├─ Routes member ✓
├─ Views member ✓
└─ Test CRUD member ✓

FASE 5: Admin - Buku Fisik
├─ BookController ✓
├─ Routes books ✓
├─ Views books ✓
├─ Upload cover image ✓
└─ Test CRUD books ✓

FASE 6: Admin - Peminjaman
├─ BorrowingController ✓
├─ Form pinjam buku ✓
├─ Form kembalikan buku ✓
├─ Riwayat peminjaman ✓
└─ Update stok otomatis ✓

FASE 7: Admin - Ebook
├─ EbookController ✓
├─ Upload PDF ✓
├─ Upload cover ✓
└─ Publish/unpublish ✓

FASE 8: Admin - Dashboard
├─ Statistik ✓
├─ Charts ✓
└─ Recent activity ✓

FASE 9: Public Area
├─ Homepage ✓
├─ Katalog ebook ✓
├─ PDF Reader ✓
└─ Search & filter ✓

FASE 10: Testing & Polish
├─ Testing semua fitur ✓
├─ Bug fixing ✓
├─ UI/UX improvements ✓
└─ Documentation ✓
```

---

## 📚 Referensi Dokumen

Selama development, gunakan dokumen ini sebagai referensi:

1. **[PROJECT_SPECIFICATION.md](PROJECT_SPECIFICATION.md)**
   - Lihat saat: Perlu tahu fitur apa yang harus dibuat
   - Lihat saat: Perlu referensi struktur routes
   - Lihat saat: Perlu tahu tech stack & packages

2. **[DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)**
   - Lihat saat: Buat migrations
   - Lihat saat: Setup model relationships
   - Lihat saat: Perlu tahu struktur tabel

3. **[SETUP_GUIDE.md](SETUP_GUIDE.md)**
   - Lihat saat: Instalasi Laravel
   - Lihat saat: Troubleshooting error
   - Lihat saat: Perlu command Laravel tertentu

4. **[README.md](README.md)**
   - Overview project
   - Quick start commands
   - Default login credentials

---

## ⚠️ Hal Penting yang Perlu Diingat

### Do's ✅
- Selalu test setiap fitur setelah selesai sebelum lanjut ke fitur berikutnya
- Commit code secara berkala
- Ikuti struktur folder yang sudah ditentukan
- Gunakan validation di setiap form
- Gunakan try-catch untuk operasi file upload

### Don'ts ❌
- Jangan skip migration atau seeder
- Jangan hardcode value, gunakan config
- Jangan lupa validasi input user
- Jangan langsung jump ke fitur kompleks (mulai dari yang mudah)
- Jangan lupa backup database sebelum migrate:fresh

---

## 🆘 Troubleshooting Cepat

**Error saat migrate?**
```bash
php artisan migrate:fresh
```

**Seeder tidak jalan?**
```bash
php artisan db:seed --class=UserSeeder
```

**NPM error?**
```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

**Storage link error?**
```bash
php artisan storage:link
```

**Clear all cache:**
```bash
php artisan optimize:clear
```

**Lihat semua routes:**
```bash
php artisan route:list
```

---

## 🎓 Tips untuk Pemula

1. **Jangan terburu-buru**: Selesaikan satu fase sebelum lanjut ke fase berikutnya
2. **Test berkala**: Jangan tunggu semua selesai baru test
3. **Baca error message**: Laravel error message sangat informatif
4. **Gunakan dd()**: Untuk debug, gunakan `dd($variable)`
5. **Lihat Laravel docs**: https://laravel.com/docs - dokumentasi sangat lengkap
6. **Commit sering**: Commit setiap selesai 1 fitur kecil

---

## 📞 Butuh Bantuan?

1. Lihat dokumentasi lengkap di folder `docs/`
2. Laravel Documentation: https://laravel.com/docs
3. Laravel Breeze: https://laravel.com/docs/starter-kits
4. Troubleshooting lengkap di [SETUP_GUIDE.md](SETUP_GUIDE.md)

---

## ✅ Checklist Akhir Sebelum Mulai Development

Pastikan semua ini sudah ✅ sebelum mulai coding:

- [ ] Sudah baca PROJECT_SPECIFICATION.md
- [ ] Sudah baca DATABASE_SCHEMA.md
- [ ] Semua prerequisites sudah terinstall
- [ ] Laravel sudah terinstall
- [ ] Database sudah dibuat dan dikonfigurasi
- [ ] Breeze sudah terinstall
- [ ] Aplikasi bisa diakses di http://localhost:8000
- [ ] Bisa login/register
- [ ] Migration sudah dibuat dan dijalankan
- [ ] Models sudah dibuat
- [ ] Seeders sudah jalan
- [ ] Admin default sudah ada di database

---

## 🚀 Siap Mulai?

Jika semua checklist di atas sudah ✅, Anda siap mulai development!

**Langkah pertama yang harus dikerjakan:**

```bash
# 1. Pastikan server berjalan
php artisan serve

# 2. Di terminal lain, jalankan Vite
npm run dev

# 3. Mulai coding dari Admin - Kategori (paling mudah)
# Buat CategoryController, routes, dan views

# 4. Test fitur kategori sampai sempurna

# 5. Lanjut ke fitur berikutnya
```

**Selamat coding! 🎉**

---

**Last Updated:** 2026-01-13
**Project:** Laravel Perpus - Sistem Perpustakaan Digital
