# Aplikasi Pengaduan Sarana Sekolah

Aplikasi web untuk mengelola sistem pengaduan sarana sekolah secara efektif dan efisien menggunakan Laravel 11, PHP 8.2+, MySQL, dan Bootstrap 5.

## 📋 Deskripsi Aplikasi

Aplikasi "Pengaduan Sarana Sekolah" dirancang untuk memudahkan siswa dalam melaporkan kerusakan atau masalah sarana sekolah, serta memberikan admin kemampuan untuk mengelola, memproses, dan memberikan feedback terhadap aspirasi yang masuk.

### Fitur Utama:
- **Sistem Autentikasi**: Login terpisah untuk Admin (username/password) dan Siswa (NIS/password)
- **Input Aspirasi Siswa**: Form untuk mengirimkan laporan dengan kategori, lokasi, keterangan, dan foto bukti
- **Histori Aspirasi**: Daftar dan tracking status pengaduan yang dikirim siswa
- **Dashboard Admin**: Statistik dan visualisasi data aspirasi
- **Manajemen Aspirasi Admin**: CRUD lengkap dengan update status & feedback
- **Activity Log**: Pencatatan semua aktivitas admin
- **Upload Foto Bukti**: Dukungan upload gambar dengan validasi

---

## 🗄️ Database Design (ERD)

```
Tabel: users
├─ id (PK, AUTO_INCREMENT)
├─ username (VARCHAR 50, UNIQUE) - untuk admin
├─ name (VARCHAR 255)
├─ email (VARCHAR 255)
├─ password (VARCHAR 255, bcrypt)
├─ role (ENUM: 'admin', 'siswa')
├─ created_at, updated_at

Tabel: siswa
├─ nis (PK, VARCHAR 20)
├─ nama (VARCHAR 100)
├─ kelas (VARCHAR 20)
├─ user_id (FK → users.id)
├─ created_at, updated_at

Tabel: kategori
├─ id_kategori (PK, AUTO_INCREMENT)
├─ ket_kategori (VARCHAR 100)
├─ created_at, updated_at

Tabel: aspirasi
├─ id_aspirasi (PK, AUTO_INCREMENT)
├─ id_pelaporan (VARCHAR 30, UNIQUE) - Format: ASP-YYYYMMDD-XXX
├─ nis (FK → siswa.nis)
├─ id_kategori (FK → kategori.id_kategori)
├─ lokasi (VARCHAR 150)
├─ keterangan (TEXT)
├─ foto_bukti (VARCHAR 255, NULLABLE)
├─ status (ENUM: 'Menunggu', 'Diproses', 'Selesai', 'Ditolak')
├─ feedback (TEXT, NULLABLE)
├─ progres_perbaikan (TINYINT 0-100)
├─ created_at, updated_at

Tabel: activity_log
├─ id (PK, AUTO_INCREMENT)
├─ user_id (FK → users.id)
├─ action (VARCHAR 255)
├─ model_type (VARCHAR 100)
├─ model_id (INT)
├─ created_at
```

---

## 🚀 Instalasi & Cara Menjalankan

### Persyaratan Sistem:
- PHP 8.2+
- MySQL / MariaDB
- Node.js & npm
- Composer

### Langkah-langkah Instalasi:

1. **Clone/Extract Project**
   ```bash
   cd pengaduan
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Setup Environment File**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database** (edit `.env`)
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pengaduan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate
   ```

6. **Jalankan Seeders (Isi Data Demo)**
   ```bash
   composer dump-autoload
   php artisan db:seed
   php artisan db:seed --class=AspirasiSeeder
   ```

7. **Setup Storage Link untuk Upload Foto**
   ```bash
   php artisan storage:link
   ```

8. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

9. **Build Frontend Assets (Production)**
   ```bash
   npm run build
   ```

   atau untuk development dengan watch:
   ```bash
   npm run dev
   ```

10. **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di: **http://localhost:8000**

---

## 🔑 Akun Default

### Admin
- **Username**: `admin`
- **Password**: `admin123`
- **URL**: `http://localhost:8000/login`

### Siswa Demo (Pilih Salah Satu)
- **NIS**: `2024001`, **Password**: `2024001` (Andi Pratama, Kelas 10A)
- **NIS**: `2024002`, **Password**: `2024002` (Bella Kusuma, Kelas 10A)
- **NIS**: `2024003`, **Password**: `2024003` (Citra Dewi, Kelas 10B)
- **NIS**: `2024004`, **Password**: `2024004` (Doni Saputro, Kelas 10B)
- **NIS**: `2024005`, **Password**: `2024005` (Eka Putri, Kelas 11A)

**URL Login Umum**: `http://localhost:8000/login`

---

## 📁 Struktur Folder Penting

```
pengaduan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── AspirasiController.php
│   │   │   └── Siswa/
│   │   │       └── AspirasiController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php  
│   │   │   └── SiswaMiddleware.php
│   │   ├── Requests/
│   │   │   ├── StoreAspirasiRequest.php
│   │   │   └── UpdateAspirasiStatusRequest.php
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Siswa.php
│   │   ├── Aspirasi.php
│   │   ├── Kategori.php
│   │   └── ActivityLog.php
│   ├── Services/
│   │   └── AspirasiService.php
│   └── Helpers/
│       └── AppHelper.php
├── config/
│   └── aspirasi.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── AdminSeeder.php
│       ├── KategoriSeeder.php
│       ├── SiswaSeeder.php
│       └── AspirasiSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── admin/
│       │   ├── dashboard/
│       │   │   └── index.blade.php
│       │   └── aspirasi/
│       │       ├── index.blade.php
│       │       └── show.blade.php
│       └── siswa/
│           └── aspirasi/
│               ├── index.blade.php
│               └── show.blade.php
├── routes/
│   └── web.php
└── storage/app/public/aspirasi/ (untuk upload foto)
```

---

## 🏗️ Arsitektur & Teknologi

### Backend:
- **Framework**: Laravel 11
- **Database**: MySQL
- **Authentication**: Laravel Auth
- **Service Layer**: AspirasiService untuk logic bisnis

### Frontend:
- **Template**: NowUI Dashboard + Bootstrap 5
- **JavaScript**: Vanilla JS (dapat diperluas dengan Vue.js)
- **Build Tool**: Vite

### Helper Functions (`app/Helpers/AppHelper.php`):
- `generateIdPelaporan()` — Generate ID laporan unik format ASP-YYYYMMDD-XXX
- `formatTanggalIndonesia()` — Format tanggal ke format Indonesia
- `statusBadge()` — Return HTML badge berdasarkan status
- `hitungPersentaseKategori()` — Hitung persentase distribusi per kategori
- `isValidNIS()` — Validasi format NIS

---

## 📊 Fitur Per Role

### Admin
- ✅ Dashboard dengan statistik aspirasi
- ✅ List semua aspirasi dengan filter (status, kategori, siswa)
- ✅ Lihat detail aspirasi + foto bukti
- ✅ Update status aspirasi (Menunggu → Diproses → Selesai/Ditolak)
- ✅ Beri feedback/umpan balik
- ✅ Track progress perbaikan (0-100%)
- ✅ Lihat activity log semua perubahan

### Siswa
- ✅ Login dengan NIS
- ✅ Form input aspirasi:
  - Pilih kategori
  - Input lokasi & keterangan
  - Upload foto bukti (max 2MB)
  - Auto-generate ID pelaporan
- ✅ Lihat histori aspirasi pribadi
- ✅ Track status & feedback dari admin
- ✅ Lihat progress perbaikan

---

## ✅ Test Case Sederhana

| No | Skenario | Input | Expected Output |
|----|----------|-------|-----------------|
| 1 | Login admin dengan kredensial benar | username: `admin`, password: `admin123` | Redirect ke `/admin/dashboard`, menampilkan statistik |
| 2 | Login siswa dengan NIS benar | NIS: `2024001`, password: `2024001` | Redirect ke `/siswa/aspirasi`, menampilkan histori aspirasi |
| 3 | Submit aspirasi baru | Form lengkap + foto | Data tersimpan, muncul di list dengan status "Menunggu" |
| 4 | Admin update status aspirasi | Change status to "Selesai" + feedback | Status berubah, tersimpan di activity_log |
| 5 | Tampilkan aspirasi detail | Click "Lihat" di list | Tampil semua detail: kategori, lokasi, keterangan, foto, status |
| 6 | Filter aspirasi (admin) | Pilih filter status/kategori | List terupdate menampilkan data sesuai filter |

---

## 🐛 Debugging & Error Handling

- **Try-Catch**: Semua method create/update menggunakan exception handling
- **Logging**: Error dicatat via `Log::error()`
- **Flash Messages**: Pesan sukses/error ditampilkan via session
- **Validation**: Form Request memvalidasi input sebelum disimpan

---

## 📝 Best Practices Diterapkan

### Performance:
- ✅ Eager loading (with) untuk menghindari N+1 query
- ✅ Pagination (15 per halaman) untuk list data
- ✅ Indexed kolom: nis, id_kategori, status, created_at

### Code Standards:
- ✅ PSR-12 coding style
- ✅ PHPDoc comment di setiap method
- ✅ Service layer untuk business logic
- ✅ Form Request untuk validasi
- ✅ Middleware untuk role-based access

### File Upload:
- ✅ Simpan di `storage/app/public/aspirasi/`
- ✅ Validasi: jpg, jpeg, png | max 2MB
- ✅ Symlink: `php artisan storage:link`

---

## 🚀 Pengembangan Lanjutan (Future Enhancements)

- [ ] Export PDF & Excel aspirasi dengan barryvdh/laravel-dompdf
- [ ] Real-time notifikasi siswa saat status berubah
- [ ] Dashboard charts dengan Chart.js (pie chart, bar chart)
- [ ] Manajemen kategori CRUD admin
- [ ] Manajemen siswa CRUD admin
- [ ] Filter aspirasi per tanggal/bulan detail
- [ ] Email notification ke siswa
- [ ] SMS reminder
- [ ] Mobile app (Flutter/React Native)
- [ ] API REST untuk integrasi

---

## 📞 Informasi Teknis

**Framework Version**: Laravel 11  
**PHP Version**: 8.2+  
**Database**: MySQL 5.7+  
**Template**: NowUI Dashboard (AdminLTE 3)  
**Created**: February 25, 2026  

---

**Dibuat dengan ❤️ untuk Sistem Informasi Pengaduan Sarana Sekolah**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
