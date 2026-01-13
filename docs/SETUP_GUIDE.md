# Setup Guide - Laravel Perpus

Panduan lengkap untuk setup project Laravel Perpus dari awal.

## Prerequisites

Pastikan sudah terinstall:
- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js & NPM (untuk asset compilation)
- Git

## Step 1: Install Laravel

```bash
# Di dalam folder project
composer create-project laravel/laravel .

# Atau jika folder belum ada
composer create-project laravel/laravel laravel-perpus
cd laravel-perpus
```

## Step 2: Database Configuration

1. Buat database MySQL:
```sql
CREATE DATABASE laravel_perpus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Edit file `.env`:
```env
APP_NAME="Laravel Perpus"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_perpus
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

## Step 3: Install Laravel Breeze (Authentication)

```bash
composer require laravel/breeze --dev

php artisan breeze:install blade

npm install
npm run build
```

## Step 4: Create Folder Structure

```bash
# Buat folder untuk uploads
mkdir -p public/uploads/books/covers
mkdir -p public/uploads/ebooks/covers
mkdir -p public/uploads/ebooks/files

# Atau di Windows
md public\uploads\books\covers
md public\uploads\ebooks\covers
md public\uploads\ebooks\files
```

## Step 5: Create Migrations

Jalankan perintah berikut untuk membuat migrations:

```bash
# Categories
php artisan make:migration create_categories_table

# Books
php artisan make:migration create_books_table

# Ebooks
php artisan make:migration create_ebooks_table

# Members
php artisan make:migration create_members_table

# Borrowings
php artisan make:migration create_borrowings_table

# Ebook Views
php artisan make:migration create_ebook_views_table

# Add role to users table
php artisan make:migration add_role_to_users_table
```

## Step 6: Create Models

```bash
php artisan make:model Category
php artisan make:model Book
php artisan make:model Ebook
php artisan make:model Member
php artisan make:model Borrowing
php artisan make:model EbookView
```

## Step 7: Create Controllers

```bash
# Admin Controllers
php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/BookController --resource
php artisan make:controller Admin/EbookController --resource
php artisan make:controller Admin/MemberController --resource
php artisan make:controller Admin/CategoryController --resource
php artisan make:controller Admin/BorrowingController

# Public Controllers
php artisan make:controller Public/HomeController
php artisan make:controller Public/EbookController
```

## Step 8: Create Middleware

```bash
php artisan make:middleware AdminMiddleware
```

## Step 9: Create Seeders

```bash
php artisan make:seeder UserSeeder
php artisan make:seeder CategorySeeder
```

## Step 10: Install Additional Packages (Optional)

```bash
# Image Intervention (untuk resize images)
composer require intervention/image

# Laravel Debugbar (development only)
composer require barryvdh/laravel-debugbar --dev

# Excel Export
composer require maatwebsite/excel
```

## Step 11: Storage Link

```bash
php artisan storage:link
```

## Step 12: Run Migrations & Seeders

```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Atau sekaligus
php artisan migrate:fresh --seed
```

## Step 13: Development Server

```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite (jika pakai Vite)
npm run dev
```

Akses aplikasi di: `http://localhost:8000`

## Default Login Credentials

Setelah seeding:
```
Email: admin@perpus.test
Password: password
```

## File Permissions (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 public/uploads

chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
chown -R www-data:www-data public/uploads
```

## Git Setup

```bash
git init
git add .
git commit -m "Initial commit: Laravel Perpus setup"
```

## Troubleshooting

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: Database connection
- Pastikan MySQL service berjalan
- Cek username/password di `.env`
- Cek nama database sudah dibuat

### Error: Storage link
```bash
# Hapus link lama
rm public/storage

# Buat ulang
php artisan storage:link
```

### NPM Install Error
```bash
# Clear cache
npm cache clean --force

# Install ulang
rm -rf node_modules package-lock.json
npm install
```

## Development Workflow

1. **Feature baru**:
   - Buat migration
   - Buat/update model
   - Buat controller
   - Buat view
   - Tambah route

2. **Testing**:
   ```bash
   php artisan test
   ```

3. **Clear Cache** (jika ada masalah):
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

## Next Steps

Setelah setup selesai:
1. Lihat `PROJECT_SPECIFICATION.md` untuk detail fitur
2. Lihat `DATABASE_SCHEMA.md` untuk struktur database
3. Mulai development dari Dashboard Admin
4. Test setiap fitur sebelum lanjut ke fitur berikutnya

## Useful Commands

```bash
# Lihat routes
php artisan route:list

# Lihat semua commands
php artisan list

# Create controller with resource
php artisan make:controller Admin/BookController --resource --model=Book

# Create migration with model
php artisan make:model Book -m

# Rollback migration
php artisan migrate:rollback

# Fresh migration (hati-hati: hapus semua data)
php artisan migrate:fresh --seed
```
