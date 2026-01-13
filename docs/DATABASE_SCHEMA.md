# Database Schema - Laravel Perpus

## Entity Relationship Diagram (ERD)

```
┌─────────────────┐
│     users       │
├─────────────────┤
│ id              │
│ name            │
│ email           │
│ password        │
│ role            │
│ created_at      │
│ updated_at      │
└─────────────────┘
         │
         │ created_by
         ▼
┌─────────────────┐       ┌─────────────────┐
│   borrowings    │───────│     members     │
├─────────────────┤       ├─────────────────┤
│ id              │       │ id              │
│ member_id       │       │ name            │
│ book_id         │       │ student_id      │
│ borrow_date     │       │ email           │
│ due_date        │       │ phone           │
│ return_date     │       │ address         │
│ status          │       │ join_date       │
│ fine_amount     │       │ created_at      │
│ notes           │       │ updated_at      │
│ created_by      │       └─────────────────┘
│ created_at      │
│ updated_at      │
└─────────────────┘
         │
         │
         ▼
┌─────────────────┐       ┌─────────────────┐
│      books      │───────│   categories    │
├─────────────────┤       ├─────────────────┤
│ id              │       │ id              │
│ title           │       │ name            │
│ author          │       │ slug            │
│ publisher       │       │ description     │
│ publication_year│       │ created_at      │
│ isbn            │       │ updated_at      │
│ quantity        │       └─────────────────┘
│ available_qty   │                │
│ category_id     │                │
│ cover_image     │                │
│ description     │                │
│ created_at      │                │
│ updated_at      │                │
└─────────────────┘                │
                                   │
                                   │
┌─────────────────┐                │
│     ebooks      │────────────────┘
├─────────────────┤
│ id              │
│ title           │
│ author          │
│ category_id     │
│ description     │
│ cover_image     │
│ file_path       │
│ file_size       │
│ downloads_count │
│ views_count     │
│ is_published    │
│ created_at      │
│ updated_at      │
└─────────────────┘
         │
         │
         ▼
┌─────────────────┐
│  ebook_views    │
├─────────────────┤
│ id              │
│ ebook_id        │
│ ip_address      │
│ viewed_at       │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

## Detailed Table Specifications

### 1. users
Admin dan staff perpustakaan

| Column     | Type         | Constraints              | Description              |
|------------|--------------|--------------------------|--------------------------|
| id         | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | User ID                  |
| name       | VARCHAR(255) | NOT NULL                 | Nama lengkap             |
| email      | VARCHAR(255) | NOT NULL, UNIQUE         | Email login              |
| password   | VARCHAR(255) | NOT NULL                 | Hashed password          |
| role       | ENUM         | NOT NULL, DEFAULT 'staff'| admin, staff             |
| created_at | TIMESTAMP    | NULL                     | Waktu dibuat             |
| updated_at | TIMESTAMP    | NULL                     | Waktu diupdate           |

**Indexes:**
- PRIMARY KEY (id)
- UNIQUE KEY (email)
- INDEX (role)

---

### 2. categories
Kategori untuk buku dan ebook

| Column      | Type         | Constraints              | Description              |
|-------------|--------------|--------------------------|--------------------------|
| id          | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | Category ID              |
| name        | VARCHAR(255) | NOT NULL                 | Nama kategori            |
| slug        | VARCHAR(255) | NOT NULL, UNIQUE         | URL-friendly name        |
| description | TEXT         | NULL                     | Deskripsi kategori       |
| created_at  | TIMESTAMP    | NULL                     | Waktu dibuat             |
| updated_at  | TIMESTAMP    | NULL                     | Waktu diupdate           |

**Indexes:**
- PRIMARY KEY (id)
- UNIQUE KEY (slug)

---

### 3. books
Buku fisik di perpustakaan

| Column            | Type         | Constraints              | Description              |
|-------------------|--------------|--------------------------|--------------------------|
| id                | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | Book ID                  |
| title             | VARCHAR(255) | NOT NULL                 | Judul buku               |
| author            | VARCHAR(255) | NOT NULL                 | Nama pengarang           |
| publisher         | VARCHAR(255) | NULL                     | Penerbit                 |
| publication_year  | YEAR         | NULL                     | Tahun terbit             |
| isbn              | VARCHAR(20)  | NULL, UNIQUE             | ISBN                     |
| quantity          | INT          | NOT NULL, DEFAULT 0      | Jumlah total buku        |
| available_quantity| INT          | NOT NULL, DEFAULT 0      | Jumlah buku tersedia     |
| category_id       | BIGINT       | NULL, FOREIGN KEY        | Relasi ke categories     |
| cover_image       | VARCHAR(255) | NULL                     | Path cover image         |
| description       | TEXT         | NULL                     | Deskripsi buku           |
| created_at        | TIMESTAMP    | NULL                     | Waktu dibuat             |
| updated_at        | TIMESTAMP    | NULL                     | Waktu diupdate           |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
- INDEX (isbn)
- INDEX (title)

---

### 4. ebooks
Ebook digital

| Column          | Type         | Constraints              | Description              |
|-----------------|--------------|--------------------------|--------------------------|
| id              | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | Ebook ID                 |
| title           | VARCHAR(255) | NOT NULL                 | Judul ebook              |
| author          | VARCHAR(255) | NOT NULL                 | Nama pengarang           |
| category_id     | BIGINT       | NULL, FOREIGN KEY        | Relasi ke categories     |
| description     | TEXT         | NULL                     | Deskripsi ebook          |
| cover_image     | VARCHAR(255) | NULL                     | Path cover image         |
| file_path       | VARCHAR(255) | NOT NULL                 | Path file PDF            |
| file_size       | BIGINT       | NULL                     | Ukuran file (bytes)      |
| downloads_count | INT          | DEFAULT 0                | Jumlah download          |
| views_count     | INT          | DEFAULT 0                | Jumlah views             |
| is_published    | BOOLEAN      | DEFAULT 0                | Status publish           |
| created_at      | TIMESTAMP    | NULL                     | Waktu dibuat             |
| updated_at      | TIMESTAMP    | NULL                     | Waktu diupdate           |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
- INDEX (is_published)
- INDEX (title)

---

### 5. members
Anggota perpustakaan (siswa)

| Column     | Type         | Constraints              | Description              |
|------------|--------------|--------------------------|--------------------------|
| id         | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | Member ID                |
| name       | VARCHAR(255) | NOT NULL                 | Nama lengkap             |
| student_id | VARCHAR(50)  | NOT NULL, UNIQUE         | NIS/NIM                  |
| email      | VARCHAR(255) | NULL                     | Email siswa              |
| phone      | VARCHAR(20)  | NULL                     | No. telepon              |
| address    | TEXT         | NULL                     | Alamat                   |
| join_date  | DATE         | NOT NULL                 | Tanggal bergabung        |
| created_at | TIMESTAMP    | NULL                     | Waktu dibuat             |
| updated_at | TIMESTAMP    | NULL                     | Waktu diupdate           |

**Indexes:**
- PRIMARY KEY (id)
- UNIQUE KEY (student_id)
- INDEX (name)

---

### 6. borrowings
Transaksi peminjaman buku

| Column      | Type         | Constraints              | Description              |
|-------------|--------------|--------------------------|--------------------------|
| id          | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | Borrowing ID             |
| member_id   | BIGINT       | NOT NULL, FOREIGN KEY    | Relasi ke members        |
| book_id     | BIGINT       | NOT NULL, FOREIGN KEY    | Relasi ke books          |
| borrow_date | DATE         | NOT NULL                 | Tanggal pinjam           |
| due_date    | DATE         | NOT NULL                 | Tanggal jatuh tempo      |
| return_date | DATE         | NULL                     | Tanggal kembali          |
| status      | ENUM         | NOT NULL                 | borrowed, returned, overdue |
| fine_amount | DECIMAL(10,2)| DEFAULT 0.00             | Jumlah denda             |
| notes       | TEXT         | NULL                     | Catatan                  |
| created_by  | BIGINT       | NULL, FOREIGN KEY        | User yang mencatat       |
| created_at  | TIMESTAMP    | NULL                     | Waktu dibuat             |
| updated_at  | TIMESTAMP    | NULL                     | Waktu diupdate           |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
- FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
- FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
- INDEX (status)
- INDEX (borrow_date)
- INDEX (due_date)

---

### 7. ebook_views
Tracking views ebook

| Column     | Type         | Constraints              | Description              |
|------------|--------------|--------------------------|--------------------------|
| id         | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | View ID                  |
| ebook_id   | BIGINT       | NOT NULL, FOREIGN KEY    | Relasi ke ebooks         |
| ip_address | VARCHAR(45)  | NULL                     | IP address pengakses     |
| viewed_at  | TIMESTAMP    | NOT NULL                 | Waktu akses              |
| created_at | TIMESTAMP    | NULL                     | Waktu dibuat             |
| updated_at | TIMESTAMP    | NULL                     | Waktu diupdate           |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (ebook_id) REFERENCES ebooks(id) ON DELETE CASCADE
- INDEX (ebook_id, viewed_at)

## Sample Data

### Default Admin User
```
email: admin@perpus.test
password: password
role: admin
```

### Sample Categories
- Fiksi
- Non-Fiksi
- Referensi
- Komputer & Teknologi
- Sains
- Sejarah
- Agama
- Biografi

### Business Rules

1. **Book Availability**: `available_quantity` harus selalu <= `quantity`
2. **Borrowing Period**: Default 7-14 hari
3. **Overdue Status**: Status otomatis berubah jadi 'overdue' jika `due_date` terlewat dan belum dikembalikan
4. **Fine Calculation**: Misal Rp 1.000 per hari keterlambatan
5. **Return Process**: Saat buku dikembalikan, `available_quantity` bertambah 1
6. **Borrow Process**: Saat buku dipinjam, `available_quantity` berkurang 1
7. **Ebook Access**: Tidak perlu tracking member, cukup IP untuk statistik
