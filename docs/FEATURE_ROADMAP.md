# 🗺️ Feature Roadmap - Laravel Perpus

**Last Updated:** 13 Januari 2026

Dokumen ini adalah roadmap visual untuk tracking implementasi fitur sistem perpustakaan.

---

## 📊 Overview Progress

| Phase | Status | Progress | Estimasi Waktu |
|-------|--------|----------|----------------|
| **Phase 1 - Essential** | 🟡 Planning | 0% | 17-23 hari |
| **Phase 2 - Important** | ⚪ Not Started | 0% | 16-21 hari |
| **Phase 3 - Enhancement** | ⚪ Not Started | 0% | 22-31 hari |
| **Phase 4 - Future** | ⚪ Not Started | 0% | 18-25 hari |

**Total Estimasi:** 73-100 hari kerja

---

## 🔴 PHASE 1 - Essential Features (Prioritas Tertinggi)

> **Target:** 1-2 Bulan
> **Goal:** Meningkatkan user experience secara signifikan

### 1.1 Advanced Search & Filters ⚪ NOT STARTED
**Estimasi:** 3-4 hari | **Priority:** 🔴 Critical

**Deskripsi:**
- Full-text search across title, author, description, ISBN
- Multiple filters (publication year, author, category)
- Search autocomplete/suggestions
- Recent searches history

**Benefits:**
- ✅ Pencarian lebih akurat dan cepat
- ✅ User dapat menemukan buku dengan mudah
- ✅ Mengurangi frustasi user

**Tasks:**
- [ ] Setup Laravel Scout dengan Meilisearch/Algolia
- [ ] Buat filter sidebar component
- [ ] Implementasi autocomplete search
- [ ] Add recent searches tracking
- [ ] Testing & optimization

**Files to Create:**
- `app/Services/SearchService.php`
- `resources/views/components/search-filters.blade.php`
- `resources/views/components/autocomplete.blade.php`

**Status:** ⚪ Belum dimulai
**Started:** -
**Completed:** -

---

### 1.2 Book Reservation System ⚪ NOT STARTED
**Estimasi:** 4-5 hari | **Priority:** 🔴 Critical

**Deskripsi:**
- User dapat reservasi buku yang sedang dipinjam
- Queue management (FIFO)
- Auto-notification saat buku tersedia
- Expire reservation setelah 2 hari

**Benefits:**
- ✅ Mengatasi masalah "buku tidak tersedia"
- ✅ Fair queue system
- ✅ Meningkatkan kepuasan member

**Tasks:**
- [ ] Create `reservations` migration
- [ ] Create `Reservation` model
- [ ] Implement queue logic (FIFO)
- [ ] Add reservation UI (button di book detail)
- [ ] Auto-notification system
- [ ] Expire reservation cronjob
- [ ] Admin view untuk manage reservations

**Database:**
```sql
CREATE TABLE reservations (
    id BIGINT PRIMARY KEY,
    member_id BIGINT,
    book_id BIGINT,
    reserved_at TIMESTAMP,
    notified_at TIMESTAMP NULL,
    expires_at TIMESTAMP,
    status ENUM('waiting', 'notified', 'expired', 'fulfilled'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Status:** ⚪ Belum dimulai
**Started:** -
**Completed:** -

---

### 1.3 Reading History ⚪ NOT STARTED
**Estimasi:** 3-4 hari | **Priority:** 🔴 Critical

**Deskripsi:**
- Track ebook yang sudah dibaca user
- Save last page/reading progress
- Resume reading dari halaman terakhir
- Reading statistics per user

**Benefits:**
- ✅ User dapat melanjutkan membaca
- ✅ Personal reading tracker
- ✅ Data untuk personalisasi

**Tasks:**
- [ ] Create `reading_histories` migration
- [ ] Create `ReadingHistory` model
- [ ] Auto-save progress saat baca ebook
- [ ] Add "Continue Reading" badge
- [ ] Create "Reading History" page
- [ ] Reading statistics dashboard

**Database:**
```sql
CREATE TABLE reading_histories (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    ebook_id BIGINT,
    last_page INT DEFAULT 0,
    total_pages INT,
    progress_percentage DECIMAL(5,2),
    is_completed BOOLEAN DEFAULT FALSE,
    last_read_at TIMESTAMP,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Status:** ⚪ Belum dimulai
**Started:** -
**Completed:** -

---

### 1.4 Wishlist/Favorites ⚪ NOT STARTED
**Estimasi:** 2-3 hari | **Priority:** 🔴 Critical

**Deskripsi:**
- User dapat save ebook/buku favorit
- Quick access ke favorites
- Share wishlist
- Polymorphic relationship (Book & Ebook)

**Benefits:**
- ✅ Personal collection management
- ✅ User engagement meningkat
- ✅ Data untuk rekomendasi

**Tasks:**
- [ ] Create `favorites` migration (polymorphic)
- [ ] Create `Favorite` model
- [ ] Add favorite button di card
- [ ] Create "My Favorites" page
- [ ] Add favorite count di card
- [ ] Share wishlist functionality

**Database:**
```sql
CREATE TABLE favorites (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    favorable_id BIGINT,
    favorable_type VARCHAR(255), -- 'App\Models\Book' or 'App\Models\Ebook'
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Status:** ⚪ Belum dimulai
**Started:** -
**Completed:** -

---

### 1.5 Notification System ⚪ NOT STARTED
**Estimasi:** 5-7 hari | **Priority:** 🔴 Critical

**Deskripsi:**
- Email notifications untuk events penting
- In-app notification center
- Background job processing dengan queue
- Notification preferences

**Benefits:**
- ✅ Mengurangi keterlambatan pengembalian
- ✅ Informasi real-time
- ✅ Automated reminders

**Email Notifications:**
- 3 hari sebelum jatuh tempo
- Hari jatuh tempo
- Daily overdue reminder
- Buku reservasi tersedia
- Ebook baru di kategori favorit

**Tasks:**
- [ ] Setup Laravel Queue (database/redis)
- [ ] Create notification jobs
- [ ] Create email templates
- [ ] Implement notification center UI
- [ ] Add notification preferences page
- [ ] Setup cron for scheduled notifications
- [ ] Testing notification delivery

**Files to Create:**
- `app/Jobs/SendDueDateReminder.php`
- `app/Jobs/SendOverdueReminder.php`
- `app/Jobs/SendReservationNotification.php`
- `app/Mail/DueDateReminder.php`
- `app/Mail/OverdueNotification.php`
- `resources/views/emails/due-date-reminder.blade.php`
- `resources/views/notifications/index.blade.php`

**Status:** ⚪ Belum dimulai
**Started:** -
**Completed:** -

---

## 🟡 PHASE 2 - Important Features

> **Target:** 2-3 Bulan
> **Goal:** Meningkatkan engagement & management capabilities

### 2.1 Reviews & Ratings ⚪ NOT STARTED
**Estimasi:** 3-5 hari | **Priority:** 🟡 Important

**Deskripsi:**
- User dapat rate ebook/buku (1-5 stars)
- Write text reviews
- Display average rating di card
- Admin moderation untuk reviews

**Tasks:**
- [ ] Create `reviews` migration (polymorphic)
- [ ] Create `Review` model
- [ ] Add rating/review form
- [ ] Display reviews di detail page
- [ ] Calculate & display average rating
- [ ] Admin review moderation page
- [ ] Report inappropriate review

**Status:** ⚪ Belum dimulai

---

### 2.2 Enhanced Reports & Analytics ⚪ NOT STARTED
**Estimasi:** 5-6 hari | **Priority:** 🟡 Important

**Deskripsi:**
- Statistics & trends
- Popular books/ebooks report
- Member activity report
- Fine collection report
- Export to CSV/PDF

**Tasks:**
- [ ] Create report views
- [ ] Implement charts (Chart.js)
- [ ] Export functionality
- [ ] Date range filters
- [ ] Scheduled reports (email)

**Status:** ⚪ Belum dimulai

---

### 2.3 Book Recommendations ⚪ NOT STARTED
**Estimasi:** 4-5 hari | **Priority:** 🟡 Important

**Deskripsi:**
- Recommend similar books (by category/tags)
- Personalized recommendations
- Trending books
- "You might like" section

**Tasks:**
- [ ] Recommendation algorithm
- [ ] UI for recommendations
- [ ] Track user preferences
- [ ] Trending calculation

**Status:** ⚪ Belum dimulai

---

### 2.4 Enhanced User Profile ⚪ NOT STARTED
**Estimasi:** 4-5 hari | **Priority:** 🟡 Important

**Deskripsi:**
- Reading statistics dashboard
- Achievements/badges
- Reading goals
- Profile picture upload
- Reading preferences

**Tasks:**
- [ ] Profile dashboard design
- [ ] Statistics calculation
- [ ] Badge system
- [ ] Goal tracking
- [ ] Profile picture upload

**Status:** ⚪ Belum dimulai

---

## 🟢 PHASE 3 - Enhancement Features

> **Target:** 3-6 Bulan
> **Goal:** Nice-to-have features

### 3.1 Social Features ⚪ NOT STARTED
**Estimasi:** 7-10 hari

**Deskripsi:**
- Comments on ebooks
- Discussion forums
- Reading clubs
- Share recommendations
- User reputation

**Status:** ⚪ Belum dimulai

---

### 3.2 Multi-role Management ⚪ NOT STARTED
**Estimasi:** 5-7 hari

**Deskripsi:**
- Add Librarian role
- Add Patron/Member role
- RBAC system
- Permission management
- Activity audit log

**Status:** ⚪ Belum dimulai

---

### 3.3 Advanced Fine Management ⚪ NOT STARTED
**Estimasi:** 3-4 hari

**Deskripsi:**
- Customizable fine rules
- Fine payment tracking
- Waive fines
- Payment history
- Outstanding report

**Status:** ⚪ Belum dimulai

---

### 3.4 REST API ⚪ NOT STARTED
**Estimasi:** 7-10 hari

**Deskripsi:**
- API endpoints for mobile
- Token authentication
- Rate limiting
- API documentation
- Postman collection

**Status:** ⚪ Belum dimulai

---

## 🔵 PHASE 4 - Future Features

> **Target:** 6+ Bulan
> **Goal:** Advanced features

### 4.1 Multi-language Support ⚪ NOT STARTED
**Estimasi:** 5-7 hari

**Deskripsi:**
- Indonesian & English
- Language selector
- RTL support

**Status:** ⚪ Belum dimulai

---

### 4.2 ISBN Integration ⚪ NOT STARTED
**Estimasi:** 3-4 hari

**Deskripsi:**
- Barcode scanning
- Auto-fetch metadata
- Google Books API integration

**Status:** ⚪ Belum dimulai

---

### 4.3 Export/Import ⚪ NOT STARTED
**Estimasi:** 4-5 hari

**Deskripsi:**
- Import books from CSV
- Export data
- Bulk operations
- Backup/restore

**Status:** ⚪ Belum dimulai

---

### 4.4 Accessibility Features ⚪ NOT STARTED
**Estimasi:** 4-6 hari

**Deskripsi:**
- Screen reader optimization
- Keyboard navigation
- High contrast mode
- Font size adjustment
- Dark mode

**Status:** ⚪ Belum dimulai

---

### 4.5 Ebook Tags/Keywords ⚪ NOT STARTED
**Estimasi:** 2-3 hari

**Deskripsi:**
- Tag system
- Tag-based filtering
- Popular tags

**Status:** ⚪ Belum dimulai

---

### 4.6 Book Renewal System ⚪ NOT STARTED
**Estimasi:** 2-3 hari

**Deskripsi:**
- Renew borrowing
- Auto-renewal
- Renewal limits

**Status:** ⚪ Belum dimulai

---

### 4.7 Bulk Operations ⚪ NOT STARTED
**Estimasi:** 3-4 hari

**Deskripsi:**
- Bulk import members
- Bulk update books
- Bulk fine adjustments

**Status:** ⚪ Belum dimulai

---

## 📊 Status Legend

- ⚪ **NOT STARTED** - Belum dikerjakan
- 🟡 **PLANNING** - Sedang direncanakan
- 🟠 **IN PROGRESS** - Sedang dikerjakan
- 🟢 **COMPLETED** - Sudah selesai
- 🔴 **BLOCKED** - Terblokir (perlu dependency)
- 🔵 **ON HOLD** - Ditunda sementara

---

## 🎯 Priority Legend

- 🔴 **Critical** - Harus dikerjakan segera
- 🟡 **Important** - Perlu dikerjakan secepatnya
- 🟢 **Nice-to-have** - Bisa dikerjakan nanti
- 🔵 **Future** - Long-term planning

---

## 📝 Update Log

**13 Jan 2026:**
- Roadmap created
- All features defined
- Priorities assigned
- Estimations calculated

---

## 🔗 Quick Links

- [SYSTEM_ANALYSIS.md](SYSTEM_ANALYSIS.md) - Analisis lengkap sistem
- [PROJECT_PROGRESS.md](PROJECT_PROGRESS.md) - Progress tracking
- [README.md](README.md) - Dokumentasi utama

---

**Note:** Dokumen ini akan diupdate seiring development. Setiap fitur yang selesai akan ditandai dengan status 🟢 COMPLETED.
