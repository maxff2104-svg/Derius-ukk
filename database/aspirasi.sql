-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2026 at 05:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `activity_log`
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
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `model_type`, `model_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Memperbarui aspirasi: ASP-20260225-002', 'App\\Models\\Aspirasi', 2, '2026-02-25 08:14:22', '2026-02-25 08:14:22'),
(2, 2, 'Membuat aspirasi: ASP-20260225-006', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:36:09', '2026-02-25 08:36:09'),
(3, 1, 'Mengubah status aspirasi (ASP-20260225-006): Menunggu => Diproses', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:52:01', '2026-02-25 08:52:01'),
(4, 1, 'Mengubah status aspirasi (ASP-20260225-006): Diproses => Selesai', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:56:27', '2026-02-25 08:56:27'),
(5, 1, 'Mengubah status aspirasi (ASP-20260225-006): Selesai => Selesai', 'App\\Models\\Aspirasi', 6, '2026-02-25 08:56:34', '2026-02-25 08:56:34'),
(6, 1, 'Menghapus aspirasi: ASP-20260225-005', 'App\\Models\\Aspirasi', 5, '2026-02-25 23:34:44', '2026-02-25 23:34:44'),
(7, 1, 'Menghapus aspirasi: ASP-20260225-004', 'App\\Models\\Aspirasi', 4, '2026-02-25 23:34:47', '2026-02-25 23:34:47'),
(8, 1, 'Menghapus aspirasi: ASP-20260225-003', 'App\\Models\\Aspirasi', 3, '2026-02-25 23:34:49', '2026-02-25 23:34:49'),
(9, 1, 'Menghapus aspirasi: ASP-20260225-002', 'App\\Models\\Aspirasi', 2, '2026-02-25 23:34:51', '2026-02-25 23:34:51'),
(10, 1, 'Menghapus aspirasi: ASP-20260225-006', 'App\\Models\\Aspirasi', 6, '2026-02-25 23:34:54', '2026-02-25 23:34:54'),
(11, 1, 'Menghapus aspirasi: ASP-20260225-001', 'App\\Models\\Aspirasi', 1, '2026-02-25 23:34:55', '2026-02-25 23:34:55'),
(12, 2, 'Membuat aspirasi: ASP-20260227-001', 'App\\Models\\Aspirasi', 7, '2026-02-26 18:10:06', '2026-02-26 18:10:06'),
(13, 1, 'Mengubah status aspirasi (ASP-20260227-001): Menunggu => Diproses', 'App\\Models\\Aspirasi', 7, '2026-02-26 18:10:33', '2026-02-26 18:10:33'),
(14, 1, 'Membuat aspirasi: ASP-20260227-002', 'App\\Models\\Aspirasi', 8, '2026-02-26 18:11:54', '2026-02-26 18:11:54'),
(15, 1, 'Menghapus aspirasi: ASP-20260227-002', 'App\\Models\\Aspirasi', 8, '2026-02-26 18:22:04', '2026-02-26 18:22:04'),
(16, 1, 'Menghapus aspirasi: ASP-20260227-001', 'App\\Models\\Aspirasi', 7, '2026-02-26 18:24:34', '2026-02-26 18:24:34'),
(17, 1, 'Membuat aspirasi: ASP-20260227-001', 'App\\Models\\Aspirasi', 9, '2026-02-26 18:26:46', '2026-02-26 18:26:46'),
(18, 1, 'Mengubah status aspirasi (ASP-20260227-001): Menunggu => Selesai', 'App\\Models\\Aspirasi', 9, '2026-02-26 18:28:19', '2026-02-26 18:28:19'),
(19, 1, 'Mengubah status aspirasi (ASP-20260227-001): Selesai => Ditolak', 'App\\Models\\Aspirasi', 9, '2026-02-26 18:28:44', '2026-02-26 18:28:44'),
(20, 1, 'Menghapus aspirasi: ASP-20260227-001', 'App\\Models\\Aspirasi', 9, '2026-02-26 18:28:52', '2026-02-26 18:28:52'),
(21, 2, 'Membuat aspirasi: ASP-20260227-001', 'App\\Models\\Aspirasi', 10, '2026-02-26 20:35:12', '2026-02-26 20:35:12'),
(22, 1, 'Mengubah status aspirasi (ASP-20260227-001): Menunggu => Diproses', 'App\\Models\\Aspirasi', 10, '2026-02-26 20:36:49', '2026-02-26 20:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
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
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `keterangan`, `foto_bukti`, `status`, `feedback`, `progres_perbaikan`, `created_at`, `updated_at`) VALUES
(10, 'ASP-20260227-001', '2024001', 1, 'Kelas 67A', 'ac rusak', 'aspirasi/JVeQvZwJ8Lu94p6TsZ0xRdo78ESNVZKSAPAeuTjk.png', 'Diproses', 'Ac sedang diperbaiki', 50, '2026-02-26 20:35:12', '2026-02-26 20:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `ket_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Toilet', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(2, 'Laboratorium', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(3, 'Perpustakaan', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(4, 'Lapangan', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(5, 'Kantin', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(6, 'Kelas', '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
(8, 'B', '2026-02-25 09:41:47', '2026-02-25 09:41:47'),
(10, 'D', '2026-02-25 09:41:57', '2026-02-25 09:41:57'),
(11, 'E', '2026-02-25 09:42:01', '2026-02-25 09:42:01'),
(12, 'F', '2026-02-25 09:42:10', '2026-02-25 09:42:10'),
(13, 'G', '2026-02-25 09:42:14', '2026-02-25 09:42:14'),
(14, 'H', '2026-02-25 09:42:21', '2026-02-25 09:42:21'),
(15, 'I', '2026-02-25 09:42:27', '2026-02-25 09:42:27'),
(16, 'AD', '2026-02-25 09:42:34', '2026-02-25 09:42:34'),
(17, 'ada', '2026-02-26 00:23:59', '2026-02-26 00:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
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
-- Table structure for table `notifikasis`
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
-- Dumping data for table `notifikasis`
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
(9, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260225-006) progress perbaikan diperbarui menjadi 100%', 'info', 1, 2, 6, '2026-02-25 08:56:34', '2026-02-25 08:57:04'),
(10, 'Status Aspirasi Diperbarui', 'Status aspirasi Anda berubah dari \'Menunggu\' menjadi \'Diproses\'. Aspirasi Anda sedang diproses oleh tim terkait.', 'info', 1, 2, 7, '2026-02-26 18:10:33', '2026-02-26 18:10:50'),
(11, 'Feedback Diberikan', 'Aspirasi Anda (ID: ASP-20260227-001) telah diberikan feedback: Otw bos', 'info', 1, 2, 7, '2026-02-26 18:10:33', '2026-02-26 18:10:50'),
(12, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260227-001) progress perbaikan diperbarui menjadi 75%', 'info', 1, 2, 7, '2026-02-26 18:10:33', '2026-02-26 18:10:50'),
(13, 'Status Aspirasi Diperbarui', 'Status aspirasi Anda berubah dari \'Menunggu\' menjadi \'Selesai\'. Aspirasi Anda telah selesai diperbaiki. Terima kasih atas pengaduannya!', 'success', 0, 10, 9, '2026-02-26 18:28:19', '2026-02-26 18:28:19'),
(14, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260227-001) progress perbaikan diperbarui menjadi 50%', 'info', 0, 10, 9, '2026-02-26 18:28:19', '2026-02-26 18:28:19'),
(15, 'Status Aspirasi Diperbarui', 'Status aspirasi Anda berubah dari \'Selesai\' menjadi \'Ditolak\'. Aspirasi Anda ditolak. Silakan periksa kembali pengajuan Anda.', 'danger', 0, 10, 9, '2026-02-26 18:28:44', '2026-02-26 18:28:44'),
(16, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260227-001) progress perbaikan diperbarui menjadi 50%', 'info', 0, 10, 9, '2026-02-26 18:28:44', '2026-02-26 18:28:44'),
(17, 'Status Aspirasi Diperbarui', 'Status aspirasi Anda berubah dari \'Menunggu\' menjadi \'Diproses\'. Aspirasi Anda sedang diproses oleh tim terkait.', 'info', 0, 2, 10, '2026-02-26 20:36:49', '2026-02-26 20:36:49'),
(18, 'Feedback Diberikan', 'Aspirasi Anda (ID: ASP-20260227-001) telah diberikan feedback: Ac sedang diperbaiki', 'info', 0, 2, 10, '2026-02-26 20:36:49', '2026-02-26 20:36:49'),
(19, 'Progress Perbaikan Diperbarui', 'Aspirasi Anda (ID: ASP-20260227-001) progress perbaikan diperbarui menjadi 50%', 'info', 0, 2, 10, '2026-02-26 20:36:49', '2026-02-26 20:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bpYBuZgtmSsSfS6oiTyZdyYMUGf86rFd0GjVfbNA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnVmeGJONE5JR1RjS3dLbHFmbDJiekxjWWdVREYwY0VTcld5enBxYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hc3BpcmFzaS8xMCI7czo1OiJyb3V0ZSI7czoxOToiYWRtaW4uYXNwaXJhc2kuc2hvdyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1772163409);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
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
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `kelas`, `user_id`, `created_at`, `updated_at`) VALUES
('20210301', 'Akun Dummy', 'XII RPL', 10, '2026-02-26 18:25:56', '2026-02-26 18:25:56'),
('2024001', 'Andi Pratama', '10A', 2, '2026-02-25 08:01:28', '2026-02-25 08:01:28'),
('2024002', 'Bella Kusuma', '10A', 3, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
('2024003', 'Citra Dewi', '10B', 4, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
('2024004', 'Doni Saputro', '10B', 5, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
('2024005', 'Eka Putri', '11A', 6, '2026-02-25 08:01:30', '2026-02-25 08:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `profile_photo`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$EXE8zF6RCMd3vtIgOd/K.uEIT.acQ8Q.MbTJEEI2hLRgD1JvKPOfW', 'admin', 'profile_photos/5QwdJZNzZ5Q415TdHk5QpgSWGRwcUN5r7wRvdQ8n.jpg', '2026-02-25 08:01:28', '2026-02-26 18:20:25'),
(2, '2024001', '$2y$12$x6Nn4J0P3RdywIzQCSKHkOv96vroLpYIpS1GwBqJNIBoA1EwFAPKa', 'siswa', 'profile_photos/dkEqb1RvoNEOzpGSz2RSmWVEcK9uS3KErf2XeHBF.png', '2026-02-25 08:01:28', '2026-02-25 08:32:52'),
(3, '2024002', '$2y$12$vDqcafSEV7L5woG8.uMHEukFHLv.7GvSSvdhJQxFl47TD5WgpFWDC', 'siswa', NULL, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
(4, '2024003', '$2y$12$bbAcRAZ3gBmqEZLC9YVaP.UWC4MdNQ0k/HzSKxh3aLST12C6HhyoS', 'siswa', NULL, '2026-02-25 08:01:29', '2026-02-25 08:01:29'),
(5, '2024004', '$2y$12$vHTe6hsUDK2/UxspD0b9FeYbNjiLVMtK7xMhS78k4fZYZP8HG9zk6', 'siswa', NULL, '2026-02-25 08:01:29', '2026-02-25 21:18:05'),
(6, '2024005', '$2y$12$g6U1ExEPp7uF5VEXxaT5r.WymJ5nlESvi.2MOJ4elr2yY0BdjJbwK', 'siswa', NULL, '2026-02-25 08:01:30', '2026-02-25 08:01:30'),
(7, 'derpy', '$2y$12$qXJnv7luVHfLwr.dsgN2A./TJH.yNfuxbnWmq9fhNjIfHyxSam7hW', 'siswa', NULL, '2026-02-25 09:01:52', '2026-02-26 18:21:16'),
(9, 'derpyss', '$2y$12$49gpY58emU8PTHNKB9rB3eGesadD1K6R3YtBJ.SyT0QVRMt2E9UPG', 'admin', NULL, '2026-02-26 18:21:38', '2026-02-26 18:21:38'),
(10, 'Akun Dummy', '$2y$12$dpQZ95G8JXy6z33kcoSyfei.LNVHpX4cRn7xJ.fp9KOXD4E2eedwq', 'siswa', NULL, '2026-02-26 18:25:56', '2026-02-26 18:25:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_log_user_id_foreign` (`user_id`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD UNIQUE KEY `aspirasi_id_pelaporan_unique` (`id_pelaporan`),
  ADD KEY `aspirasi_id_kategori_foreign` (`id_kategori`),
  ADD KEY `aspirasi_nis_id_kategori_status_created_at_index` (`nis`,`id_kategori`,`status`,`created_at`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `siswa_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE,
  ADD CONSTRAINT `aspirasi_nis_foreign` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
