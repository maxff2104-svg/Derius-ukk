-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Feb 2026 pada 18.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aspirasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `model_type`, `model_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Memperbarui aspirasi: ASP-20260225-002', 'App\\Models\\Aspirasi', 2, '2026-02-25 08:14:22', '2026-02-25 08:14:22'),
(2, 2, 'Membuat aspirasi: ASP-20260225-006', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:36:09', '2026-02-25 08:36:09'),
(3, 1, 'Mengubah status aspirasi (ASP-20260225-006): Menunggu => Diproses', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:52:01', '2026-02-25 08:52:01'),
(4, 1, 'Mengubah status aspirasi (ASP-20260225-006): Diproses => Selesai', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:56:27', '2026-02-25 08:56:27'),
(5, 1, 'Mengubah status aspirasi (ASP-20260225-006): Selesai => Selesai', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:56:34', '2026-02-25 08:56:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` bigint(20) UNSIGNED NOT NULL,
  `id_pelaporan` varchar(20) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `lokasi` varchar(150) NOT NULL,
  `keterangan` text NOT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `feedback` text DEFAULT NULL,
  `progres_perbaikan` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `keterangan`, `foto_bukti`, `status`, `feedback`, `progres_perbaikan`, `created_at`, `updated_at`) VALUES
(1, 'ASP-20260225-001', '2024001', 1, 'Toilet Dekat Kelas 10A', 'Kamar mandi toilet ada yang mampet, mohon segera diperbaiki.', NULL, 'Menunggu', NULL, 0, '2026-02-25 08:01:30', '2026-02-25 08:01:30'),
(2, 'ASP-20260225-002', '2024002', 2, 'Lab KomputerS', 'Beberapa komputer di lab sudah rusak dan perlu diganti.', NULL, 'Diproses', NULL, 50, '2026-02-25 08:01:30', '2026-02-25 08:14:22'),
(3, 'ASP-20260225-003', '2024003', 3, 'Perpustakaan Lantai 1', 'Rak buku sudah tua dan tidak stabil, takut roboh.', NULL, 'Selesai', NULL, 100, '2026-02-25 08:01:30', '2026-02-25 08:01:30'),
(4, 'ASP-20260225-004', '2024004', 4, 'Lapangan Olahraga', 'Rerumputan lapangan sudah mati, tidak bisa digunakan.', NULL, 'Ditolak', NULL, 0, '2026-02-25 08:01:30', '2026-02-25 08:01:30'),
(5, 'ASP-20260225-005', '2024005', 5, 'Kantin', 'Meja dan kursi di kantin banyak yang rusak.', NULL, 'Menunggu', NULL, 0, '2026-02-25 08:01:30', '2026-02-25 08:01:30'),
(6, 'ASP-20260225-006', '2024001', 2, 'Aula', 'ada', 'aspirasi/X5HsCmiA3p9bk9kx4YUz8JjV9G50gBdD50Rxa6Kl.png', 'Selesai', 'ada', 100, '2026-02-25 08:36:09', '2026-02-25 08:56:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `ket_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Toilet', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(2, 'Laboratorium', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(3, 'Perpustakaan', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(4, 'Lapangan', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(5, 'Kantin', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(6, 'Kelas', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(7, 'A', '2026-02-25 09:41:40', '2026-02-25 09:41:40'),
(8, 'B', '2026-02-25 09:41:47', '2026-02-25 09:41:47'),
(9, 'C', '2026-02-25 09:41:51', '2026-02-25 09:41:51'),
(10, 'D', '2026-02-25 09:41:57', '2026-02-25 09:41:57'),
(11, 'E', '2026-02-25 09:42:01', '2026-02-25 09:42:01'),
(12, 'F', '2026-02-25 09:42:10', '2026-02-25 09:42:10'),
(13, 'G', '2026-02-25 09:42:14', '2026-02-25 09:42:14'),
(14, 'H', '2026-02-25 09:42:21', '2026-02-25 09:42:21'),
(15, 'I', '2026-02-25 09:42:27', '2026-02-25 09:42:27'),
(16, 'AD', '2026-02-25 09:42:34', '2026-02-25 09:42:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000001_create_siswa_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '0001_01_01_000002_create_kategori_table', 1),
(6, '0001_01_01_000003_create_aspirasi_table', 1),
(7, '0001_01_01_000004_create_activity_log_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `aspirasi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifikasis`
--

INSERT INTO `notifikasis` (`id`, `judul`, `pesan`, `tipe`, `is_read`, `user_id`, `aspirasi_id`, `created_at`, `updated_at`) VALUES
(1, 'Status Aspirasi Diperbarui', 'Status aspirasi Anda berubah dari \'Menunggu\' menjadi \'Diproses\'. Aspirasi Anda sedang diproses oleh tim terkait.', 'info', 1, 2, 6, '2026-02-25 08:52:01', '2026-02-25 08:57:04'),
(2, 'Feedback Diberikan', 'Aspirasi Anda (ID: ASP-20260225-006) telah diberikan feedback: ada', 'info', 1, 2, 6, '2026-02-25 08:52:01', '2026-02-25 08:57:04'),
(3, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260225-006) progress perbaikan diperbarui menjadi 50%', 'info', 1, 2, 6, '2026-02-25 08:52:01', '2026-02-25 08:57:04'),
(4, 'Status Aspirasi Diperbarui', 'Status aspirasi Anda berubah dari \'Diproses\' menjadi \'Selesai\'. Aspirasi Anda telah selesai diperbaiki. Terima kasih atas pengaduannya!', 'success', 1, 2, 6, '2026-02-25 08:56:27', '2026-02-25 08:57:04'),
(5, 'Feedback Diberikan', 'Aspirasi Anda (ID: ASP-20260225-006) telah diberikan feedback: ada', 'info', 1, 2, 6, '2026-02-25 08:56:27', '2026-02-25 08:57:04'),
(6, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260225-006) progress perbaikan diperbarui menjadi 50%', 'info', 1, 2, 6, '2026-02-25 08:56:27', '2026-02-25 08:57:04'),
(7, 'Status Aspirasi Diperbarui', 'Aspirasi Anda telah selesai diperbaiki. Terima kasih atas pengaduannya!', 'success', 1, 2, 6, '2026-02-25 08:56:34', '2026-02-25 08:57:04'),
(8, 'Feedback Diberikan', 'Aspirasi Anda (ID: ASP-20260225-006) telah diberikan feedback: ada', 'info', 1, 2, 6, '2026-02-25 08:56:34', '2026-02-25 08:57:04'),
(9, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260225-006) progress perbaikan diperbarui menjadi 100%', 'info', 1, 2, 6, '2026-02-25 08:56:34', '2026-02-25 08:57:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('LJRqBNMCGrVwRjSeuBowt2AxIAtti6tuzWdXNSt1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXF2bVNrSUNRdVdKOUtzUjRMeXFNVE02Y1JpZnA3VFozWHVZSm5ZdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9rYXRlZ29yaT9wYWdlPTIiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLmthdGVnb3JpLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1772039351);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `kelas`, `user_id`, `created_at`, `updated_at`) VALUES
('2024001', 'Andi Pratama', '10A', 2, '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
('2024002', 'Bella Kusuma', '10A', 3, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
('2024003', 'Citra Dewi', '10B', 4, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
('2024004', 'Doni Saputro', '10B', 5, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
('2024005', 'Eka Putri', '11A', 6, '2026-02-25 08:01:30', '2026-02-25 08:01:30'),
('23161067', 'Andi', 'XII RPL 12', 8, '2026-02-25 09:10:27', '2026-02-25 09:10:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `profile_photo`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$CvXrBngP8JcSbaNb.3r84.idRth9MRu7n.0JuzyqoksH8o.I0B6aa', 'admin', 'profile_photos/hiMXcChoaM2ZsyjQOdajXMjJLkSmRWdjI9crUUfQ.png', '2026-02-25 08:01:28', '2026-02-25 08:05:23'),
(2, '2024001', '$2y$12$x6Nn4J0P3RdywIzQCSKHkOv96vroLpYIpS1GwBqJNIBoA1EwFAPKa', 'siswa', 'profile_photos/dkEqb1RvoNEOzpGSz2RSmWVEcK9uS3KErf2XeHBF.png', '2026-02-25 08:01:28', '2026-02-25 08:32:52'),
(3, '2024002', '$2y$12$vDqcafSEV7L5woG8.uMHEukFHLv.7GvSSvdhJQxFl47TD5WgpFWDC', 'siswa', NULL, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
(4, '2024003', '$2y$12$bbAcRAZ3gBmqEZLC9YVaP.UWC4MdNQ0k/HzSKxh3aLST12C6HhyoS', 'siswa', NULL, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
(5, '2024004', '$2y$12$OqSQrp6MQRsnlVzUYzDbxOS7.Sw0UVTDOg/3SXtA6FugF/ai/upDG', 'siswa', NULL, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
(6, '2024005', '$2y$12$g6U1ExEPp7uF5VEXxaT5r.WymJ5nlESvi.2MOJ4elr2yY0BdjJbwK', 'siswa', NULL, '2026-02-25 08:01:30', '2026-02-25 08:01:30'),
(7, 'derpyusz@gmail.com', '$2y$12$qXJnv7luVHfLwr.dsgN2A./TJH.yNfuxbnWmq9fhNjIfHyxSam7hW', 'siswa', NULL, '2026-02-25 09:01:52', '2026-02-25 09:01:52'),
(8, 'andi', '$2y$12$XwzRX7mO6P6G.QT8nwfBp.K1UL7JZ3RnsxRixP2l6MKv.xvjwG4bm', 'siswa', NULL, '2026-02-25 09:10:27', '2026-02-25 09:10:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_log_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD UNIQUE KEY `aspirasi_id_pelaporan_unique` (`id_pelaporan`),
  ADD KEY `aspirasi_id_kategori_foreign` (`id_kategori`),
  ADD KEY `aspirasi_nis_id_kategori_status_created_at_index` (`nis`,`id_kategori`,`status`,`created_at`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `siswa_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE,
  ADD CONSTRAINT `aspirasi_nis_foreign` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
