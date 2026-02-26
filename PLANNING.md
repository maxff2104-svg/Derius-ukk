Baik! Ini prompt lengkap yang bisa langsung kamu paste ke AI coding agent:

🤖 PROMPT UNTUK AI CODING AGENT
# APLIKASI PENGADUAN SARANA SEKOLAH
## System Prompt untuk AI Coding Agent

Buatkan aplikasi web "Pengaduan Sarana Sekolah" menggunakan Laravel 11 + PHP + MySQL + Bootstrap 5.
Aplikasi ini mendukung proses input dan output pengaduan sarana sekolah secara efektif dan efisien.

---

## 📋 METODOLOGI: WATERFALL SEDERHANA

Ikuti urutan berikut dalam membangun aplikasi:
1. Analisis Kebutuhan (dokumentasikan di README.md)
2. Desain (ERD + Diagram Program/Flowchart dalam bentuk komentar atau dokumentasi)
3. Implementasi Kode (clean code, best practices)
4. Pengujian (sertakan test case sederhana)
5. Dokumentasi (komentar kode, README lengkap)

---

## 🗄️ DATABASE DESIGN (ERD)

Buat migrasi Laravel untuk tabel-tabel berikut:

### Tabel: users (Admin)
- id (PK, AUTO_INCREMENT)
- username (VARCHAR 50, UNIQUE)
- password (VARCHAR 255, bcrypt)
- role (ENUM: 'admin', 'siswa')
- created_at, updated_at

### Tabel: siswa
- nis (PK, VARCHAR 20)
- nama (VARCHAR 100)
- kelas (VARCHAR 20)
- user_id (FK → users.id)
- created_at, updated_at

### Tabel: kategori
- id_kategori (PK, AUTO_INCREMENT)
- ket_kategori (VARCHAR 100) — contoh: Toilet, Laboratorium, Lapangan, dll
- created_at, updated_at

### Tabel: aspirasi
- id_aspirasi (PK, AUTO_INCREMENT)
- id_pelaporan (VARCHAR 20, UNIQUE, format: ASP-YYYYMMDD-XXX)
- nis (FK → siswa.nis)
- id_kategori (FK → kategori.id_kategori)
- lokasi (VARCHAR 150)
- keterangan (TEXT)
- foto_bukti (VARCHAR 255, NULLABLE) — path file upload
- status (ENUM: 'Menunggu', 'Diproses', 'Selesai', 'Ditolak', DEFAULT 'Menunggu')
- feedback (TEXT, NULLABLE)
- progres_perbaikan (TINYINT 0-100, DEFAULT 0)
- created_at, updated_at

### Tabel: activity_log
- id (PK, AUTO_INCREMENT)
- user_id (FK → users.id)
- action (VARCHAR 255) — deskripsi aksi
- model_type (VARCHAR 100) — e.g. 'Aspirasi'
- model_id (INT)
- created_at

---

## 👥 SISTEM AUTENTIKASI (2 ROLE)

Gunakan Laravel Breeze atau custom Auth dengan middleware:
- Role 'admin' → akses halaman admin
- Role 'siswa' → akses halaman siswa (login via NIS + password)
- Redirect otomatis berdasarkan role setelah login
- Middleware: AdminMiddleware, SiswaMiddleware

---

## 📁 STRUKTUR FITUR & HALAMAN

### HALAMAN SISWA:
1. Login (NIS + Password)
2. Form Input Aspirasi
   - Pilih kategori (dropdown dari tabel kategori)
   - Input lokasi, keterangan
   - Upload foto bukti (max 2MB, jpg/png/jpeg)
   - Generate otomatis id_pelaporan
3. Histori Aspirasi Saya
   - Tabel list aspirasi milik siswa yang login
   - Filter per tanggal, per kategori
   - Lihat detail: status, feedback, progres perbaikan (progress bar Bootstrap)
4. Notifikasi — tampilkan notifikasi ketika status aspirasi berubah (gunakan Laravel Event/Listener + database notification atau polling sederhana tiap 30 detik dengan AJAX)

### HALAMAN ADMIN:
1. Login (username + password)
2. Dashboard
   - Statistik chart menggunakan Chart.js:
     * Pie chart: distribusi per kategori
     * Bar chart: aspirasi per bulan
     * Card summary: Total, Menunggu, Diproses, Selesai, Ditolak
3. List Aspirasi Keseluruhan
   - Filter: per tanggal, per bulan, per siswa (NIS/nama), per kategori, per status
   - Tabel dengan pagination (15 per halaman)
   - Aksi: Lihat Detail, Update Status, Beri Feedback
4. Detail & Umpan Balik Aspirasi
   - Tampilkan semua data aspirasi
   - Form update: status, feedback, progres_perbaikan (slider 0-100)
   - Histori perubahan status dari activity_log
5. Export PDF/Excel
   - Export list aspirasi (sesuai filter aktif) ke PDF (gunakan DomPDF/Laravel-DOMPDF)
   - Export ke Excel (gunakan Maatwebsite/Laravel-Excel)
6. Manajemen Kategori (CRUD sederhana)
7. Activity Log — tampilkan semua log aktivitas admin
8. Manajemen Siswa (CRUD: tambah, edit, hapus siswa + akun user)

---

## 🏗️ ARSITEKTUR KODE (WAJIB DIIKUTI)

### Controllers (gunakan Resource Controller):
- AuthController — login, logout, redirect by role
- Admin/DashboardController — statistik, chart data (return JSON untuk AJAX)
- Admin/AspirasiController — CRUD, update status & feedback, export
- Admin/KategoriController — CRUD kategori
- Admin/SiswaController — CRUD siswa
- Admin/ActivityLogController — index log
- Siswa/AspirasiController — store, index (milik sendiri), show
- Siswa/NotifikasiController — index, markAsRead

### Models (dengan Eloquent Relationships):
- User: hasOne(Siswa), hasMany(ActivityLog)
- Siswa: belongsTo(User), hasMany(Aspirasi)
- Aspirasi: belongsTo(Siswa), belongsTo(Kategori)
- Kategori: hasMany(Aspirasi)
- ActivityLog: belongsTo(User)

### Service Layer:
Buat folder app/Services/ dengan:
- AspirasiService.php — logika bisnis aspirasi (generateIdPelaporan, storeAspirasi, updateStatus)
- ExportService.php — logika export PDF & Excel
- StatistikService.php — query statistik untuk dashboard

### Helper / Fungsi & Prosedur (WAJIB ada):
Buat app/Helpers/AppHelper.php dan daftarkan di composer.json:
```php
// Fungsi generate ID Pelaporan
function generateIdPelaporan(): string { ... }

// Fungsi format tanggal Indonesia
function formatTanggalIndonesia(string $date): string { ... }

// Fungsi label status dengan badge warna
function statusBadge(string $status): string { ... }

// Fungsi hitung persentase per kategori (return array)
function hitungPersentaseKategori(array $data): array { ... }

// Fungsi validasi NIS
function isValidNIS(string $nis): bool { ... }
```

### Penggunaan Array (WAJIB ada):
- Gunakan array untuk konfigurasi status dan warna badge
- Gunakan array untuk mapping filter
- Gunakan collect() dan array helpers Laravel di service layer
Contoh wajib ada:
```php
// Di config/aspirasi.php
return [
    'status' => ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
    'status_color' => [
        'Menunggu' => 'warning',
        'Diproses' => 'info',
        'Selesai'  => 'success',
        'Ditolak'  => 'danger',
    ],
    'kategori_default' => ['Toilet', 'Laboratorium', 'Perpustakaan', 'Lapangan', 'Kantin', 'Kelas'],
];
```

---

## ⚡ PERFORMANCE & BEST PRACTICES

1. Query Efisien:
   - Gunakan Eager Loading (with()) untuk semua relasi, HINDARI N+1 query
   - Gunakan select() hanya kolom yang dibutuhkan
   - Tambahkan index pada kolom: nis, id_kategori, status, created_at
   - Gunakan pagination() bukan get() untuk list data besar

2. Coding Guidelines:
   - PSR-12 coding standard
   - Semua logic bisnis di Service, bukan di Controller
   - Validasi menggunakan Form Request (app/Http/Requests/)
   - Gunakan Laravel Cache untuk data statistik dashboard (cache 5 menit)
   - Sanitasi input, gunakan CSRF token di semua form

3. Upload File:
   - Simpan di storage/app/public/aspirasi/
   - Gunakan php artisan storage:link
   - Validasi: mimes:jpg,jpeg,png|max:2048

4. Notifikasi Real-time (Sederhana):
   - Gunakan database notification Laravel
   - Polling AJAX setiap 30 detik untuk cek notifikasi baru
   - Tampilkan badge count di navbar

---

## 🎨 UI/UX

- Template: Bootstrap 5 + AdminLTE 3 untuk halaman admin
- Halaman siswa: Bootstrap 5 clean, mobile-responsive
- Gunakan SweetAlert2 untuk konfirmasi aksi (hapus, update status)
- Gunakan DataTables.js untuk semua tabel (search, sort, pagination client-side)
- Progress bar Bootstrap untuk menampilkan progres_perbaikan
- Breadcrumb di setiap halaman admin

---

## 🐛 DEBUGGING & ERROR HANDLING

- Gunakan try-catch di semua method Controller yang menyimpan/mengupdate data
- Log error menggunakan Laravel Log facade: Log::error(...)
- Tampilkan pesan sukses/error menggunakan session flash + alert Bootstrap
- Aktifkan APP_DEBUG=true saat development, false saat production
- Buat custom 404 dan 500 error page

---

## 📦 PACKAGE YANG DIGUNAKAN
composer require barryvdh/laravel-dompdf
composer require maatwebsite/excel
NPM: Chart.js, DataTables, SweetAlert2, AdminLTE 3

---

## 📄 DOKUMENTASI WAJIB

1. README.md berisi:
   - Deskripsi program
   - ERD (dalam bentuk teks/ASCII atau link)
   - Cara instalasi (step by step)
   - Cara menjalankan
   - Struktur folder penting
   - Akun default (admin & siswa demo)

2. Komentar kode:
   - Setiap fungsi/method wajib ada PHPDoc comment
   - Komentar inline untuk logika yang kompleks

3. Seeder:
   - AdminSeeder (1 akun admin default)
   - KategoriSeeder (6 kategori default)
   - SiswaSeeder (5 data siswa demo)
   - AspirasiSeeder (10 data aspirasi demo dengan berbagai status)

---

## ✅ TEST CASE SEDERHANA

Dokumentasikan pengujian berikut di README:
| No | Skenario | Input | Expected Output | Status |
|----|----------|-------|-----------------|--------|
| 1  | Login admin valid | username+password benar | Redirect ke dashboard admin | |
| 2  | Login siswa valid | NIS+password benar | Redirect ke halaman siswa | |
| 3  | Submit aspirasi | Form lengkap + foto | Data tersimpan, notifikasi muncul | |
| 4  | Update status | Admin ubah status → Selesai | Siswa terima notifikasi | |
| 5  | Export PDF | Klik export | File PDF terdownload | |
| 6  | Filter aspirasi | Filter per bulan | Data terfilter | |

---

## 🚀 URUTAN GENERATE

Harap generate file dalam urutan ini:
1. migrations/ (semua tabel)
2. Models/ (semua model + relasi)
3. config/aspirasi.php
4. app/Helpers/AppHelper.php
5. app/Services/ (semua service)
6. app/Http/Requests/ (semua form request)
7. app/Http/Middleware/ (AdminMiddleware, SiswaMiddleware)
8. app/Http/Controllers/ (semua controller)
9. routes/web.php
10. resources/views/ (semua blade template)
11. database/seeders/
12. README.md

Generate SEMUA file secara lengkap, jangan dipotong atau diringkas.