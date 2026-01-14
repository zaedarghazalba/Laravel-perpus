# Dokumentasi Laravel Perpus

Selamat datang di dokumentasi project Laravel Perpus - Sistem Perpustakaan Digital.

---

## 📊 STATUS PROJECT

**Last Updated:** 2026-01-13

### ✅ FASE 1-2: Setup & Database Layer - SELESAI (100%)
- Laravel 12 terinstall & running
- Database dikonfigurasi dan ready
- Authentication (Breeze) aktif
- 7 tabel custom + relationships
- Initial data seeded

**👉 Lihat detail lengkap di [PROJECT_PROGRESS.md](PROJECT_PROGRESS.md)**

**Next:** Mulai development Admin Panel (Controllers & Views)

---

## 🚀 BARU? MULAI DI SINI!

**Jika ini pertama kali Anda membuka project ini, mulai dari:**

### 👉 [MULAI_DARI_SINI.md](MULAI_DARI_SINI.md)

Dokumen ini akan memandu Anda langkah demi langkah dari awal sampai siap development!

---

## Daftar Dokumen

### 0. [MULAI_DARI_SINI.md](MULAI_DARI_SINI.md) ⭐ **WAJIB BACA PERTAMA!**
Panduan lengkap untuk memulai project dari nol:
- Checklist persiapan step-by-step
- Alur development yang jelas
- Fase-fase pengerjaan
- Troubleshooting cepat
- Tips untuk pemula

**Baca dokumen ini untuk**: Mendapatkan panduan langkah demi langkah mulai dari persiapan sampai siap development.

### 0.1. [PROJECT_PROGRESS.md](PROJECT_PROGRESS.md) 📊 **CEK PROGRESS PROJECT**
Status dan progress project saat ini:
- Status keseluruhan project (% completion)
- Checklist apa yang sudah selesai
- Checklist apa yang belum dikerjakan
- Login credentials (admin & staff)
- Next steps dan rekomendasi
- Quick commands reference

**Baca dokumen ini untuk**: Mengetahui sampai mana project sudah dikerjakan dan apa yang harus dilakukan selanjutnya.

### 1. [PROJECT_SPECIFICATION.md](PROJECT_SPECIFICATION.md)
Spesifikasi lengkap project meliputi:
- Overview dan tech stack
- Daftar fitur lengkap (area publik & admin)
- Struktur database
- Struktur folder Laravel
- Routes structure
- Fitur tambahan opsional
- Security considerations
- Performance optimization
- Development phases
- Recommended packages

**Baca dokumen ini untuk**: Memahami scope project dan fitur-fitur yang akan dibangun.

### 2. [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)
Detail skema database meliputi:
- Entity Relationship Diagram (ERD)
- Spesifikasi detail setiap tabel
- Indexes dan foreign keys
- Sample data
- Business rules

**Baca dokumen ini untuk**: Memahami struktur database dan relasi antar tabel.

### 3. [SETUP_GUIDE.md](SETUP_GUIDE.md)
Panduan setup step-by-step meliputi:
- Prerequisites
- Instalasi Laravel
- Konfigurasi database
- Install authentication
- Create migrations, models, controllers
- Seeding data
- Troubleshooting

**Baca dokumen ini untuk**: Setup project dari awal sampai siap development.

### 4. [SYSTEM_ANALYSIS.md](SYSTEM_ANALYSIS.md) ⭐ **ANALISIS LENGKAP**
Analisis komprehensif sistem perpustakaan meliputi:
- ✅ Fitur yang sudah diimplementasi (detail lengkap)
- ❌ Fitur yang belum ada (20+ items)
- 🎯 Rekomendasi prioritas implementasi (Phase 1-4)
- 📊 Estimasi waktu development per fitur
- 🗄️ Struktur database lengkap dengan relasi
- 🖥️ Daftar halaman dan antarmuka pengguna
- 💪 Kekuatan sistem saat ini
- 🔧 Area yang perlu diperbaiki

**Baca dokumen ini untuk**: Memahami apa yang sudah ada, apa yang belum, dan apa yang harus dikerjakan selanjutnya dengan prioritas yang jelas.

## Quick Start

```bash
# 1. Install Laravel
composer create-project laravel/laravel .

# 2. Setup database di .env
# DB_DATABASE=laravel_perpus

# 3. Install Breeze
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build

# 4. Create migrations & models
# (lihat SETUP_GUIDE.md untuk detail)

# 5. Run migrations
php artisan migrate --seed

# 6. Start server
php artisan serve
```

## Fitur Utama

### Untuk Siswa (Tanpa Login)
- Browse dan baca ebook gratis
- Pencarian ebook
- Filter berdasarkan kategori
- PDF reader online

### Untuk Admin (Dengan Login)
- Dashboard statistik perpustakaan
- Manajemen buku fisik (CRUD)
- Manajemen ebook (upload, edit, delete)
- Peminjaman buku
- Pengembalian buku
- Manajemen anggota
- Manajemen kategori

## Tech Stack

- **Backend**: Laravel 10.x / 11.x
- **Database**: MySQL 8.0+
- **Frontend**: Blade Templates + Bootstrap/Tailwind
- **Auth**: Laravel Breeze

## Development Phases (Recommended Order)

1. Setup & Authentication
2. Database & Models
3. Admin - Book Management
4. Admin - Borrowing System
5. Admin - Ebook Management
6. Public Area (Student)
7. Testing & Deployment

## Struktur Project

```
laravel-perpus/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/         # Admin controllers
│   │   └── Public/        # Public controllers
│   ├── Models/            # Eloquent models
│   └── Services/          # Business logic
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Data seeders
├── resources/
│   └── views/
│       ├── admin/         # Admin views
│       └── public/        # Public views
├── public/
│   └── uploads/           # File uploads
└── routes/
    └── web.php            # Routes
```

## Database Tables

1. **users** - Admin & staff
2. **categories** - Kategori buku/ebook
3. **books** - Buku fisik
4. **ebooks** - Ebook digital
5. **members** - Anggota perpustakaan
6. **borrowings** - Transaksi peminjaman
7. **ebook_views** - Tracking views ebook

## Important Notes

### Security
- Validasi file upload (hanya PDF untuk ebook)
- Batasi ukuran file (max 50MB)
- XSS & CSRF protection
- Admin middleware untuk area admin

### Performance
- Gunakan pagination untuk list data
- Lazy loading untuk relasi
- Cache untuk data statis
- Image optimization untuk cover

### File Management
- Simpan file di `storage/app/public`
- Gunakan `php artisan storage:link`
- Validasi tipe dan ukuran file

## Default Login

```
Email: admin@perpus.test
Password: password
```

## Kontak & Support

Jika ada pertanyaan atau butuh bantuan:
1. Baca dokumentasi lengkap di folder `docs/`
2. Check Laravel documentation: https://laravel.com/docs
3. Check troubleshooting di SETUP_GUIDE.md

## License

Project ini untuk keperluan pembelajaran dan development.

---

**Happy Coding!**

Mulai development dengan membaca SETUP_GUIDE.md untuk setup project, lalu ikuti development phases di PROJECT_SPECIFICATION.md.
