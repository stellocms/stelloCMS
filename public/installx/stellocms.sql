-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Nov 2025 pada 09.51
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
-- Database: `stellocms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_publikasi` timestamp NOT NULL DEFAULT current_timestamp(),
  `aktif` tinyint(1) DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `gambar`, `tanggal_publikasi`, `aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'berita test', 'test berita', NULL, '2025-11-07 22:57:49', 1, NULL, '2025-11-07 15:57:49', '2025-11-07 15:57:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('stellocms_cache_active_themes_admin', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:16:\"App\\Models\\Theme\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"themes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:7;s:4:\"name\";s:8:\"adminlte\";s:4:\"type\";s:5:\"admin\";s:7:\"version\";s:5:\"3.2.0\";s:11:\"description\";s:38:\"AdminLTE Free Bootstrap Admin Template\";s:6:\"author\";s:11:\"AdminLTE.io\";s:10:\"author_url\";s:19:\"https://adminlte.io\";s:10:\"screenshot\";s:14:\"screenshot.png\";s:4:\"tags\";s:34:\"[\"admin\",\"bootstrap\",\"responsive\"]\";s:9:\"is_active\";i:1;s:12:\"is_installed\";i:1;s:10:\"is_default\";i:1;s:10:\"created_at\";s:19:\"2025-11-02 07:15:32\";s:10:\"updated_at\";s:19:\"2025-11-06 04:10:23\";}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:7;s:4:\"name\";s:8:\"adminlte\";s:4:\"type\";s:5:\"admin\";s:7:\"version\";s:5:\"3.2.0\";s:11:\"description\";s:38:\"AdminLTE Free Bootstrap Admin Template\";s:6:\"author\";s:11:\"AdminLTE.io\";s:10:\"author_url\";s:19:\"https://adminlte.io\";s:10:\"screenshot\";s:14:\"screenshot.png\";s:4:\"tags\";s:34:\"[\"admin\",\"bootstrap\",\"responsive\"]\";s:9:\"is_active\";i:1;s:12:\"is_installed\";i:1;s:10:\"is_default\";i:1;s:10:\"created_at\";s:19:\"2025-11-02 07:15:32\";s:10:\"updated_at\";s:19:\"2025-11-06 04:10:23\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"tags\";s:5:\"array\";s:9:\"is_active\";s:7:\"boolean\";s:12:\"is_installed\";s:7:\"boolean\";s:10:\"is_default\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:7:\"version\";i:3;s:11:\"description\";i:4;s:6:\"author\";i:5;s:10:\"author_url\";i:6;s:10:\"screenshot\";i:7;s:4:\"tags\";i:8;s:9:\"is_active\";i:9;s:12:\"is_installed\";i:10;s:10:\"is_default\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1762763937),
('stellocms_cache_active_themes_frontend', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:16:\"App\\Models\\Theme\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"themes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:1;s:4:\"name\";s:7:\"stocker\";s:4:\"type\";s:8:\"frontend\";s:7:\"version\";s:5:\"1.0.0\";s:11:\"description\";s:39:\"Stocker - Stock Market Website Template\";s:6:\"author\";s:10:\"HTML Codex\";s:10:\"author_url\";s:21:\"https://htmlcodex.com\";s:10:\"screenshot\";s:18:\"img/carousel-1.jpg\";s:4:\"tags\";s:63:\"[\"stock-market\",\"finance\",\"investment\",\"business\",\"responsive\"]\";s:9:\"is_active\";i:1;s:12:\"is_installed\";i:1;s:10:\"is_default\";i:1;s:10:\"created_at\";s:19:\"2025-11-02 06:18:08\";s:10:\"updated_at\";s:19:\"2025-11-06 04:10:07\";}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:1;s:4:\"name\";s:7:\"stocker\";s:4:\"type\";s:8:\"frontend\";s:7:\"version\";s:5:\"1.0.0\";s:11:\"description\";s:39:\"Stocker - Stock Market Website Template\";s:6:\"author\";s:10:\"HTML Codex\";s:10:\"author_url\";s:21:\"https://htmlcodex.com\";s:10:\"screenshot\";s:18:\"img/carousel-1.jpg\";s:4:\"tags\";s:63:\"[\"stock-market\",\"finance\",\"investment\",\"business\",\"responsive\"]\";s:9:\"is_active\";i:1;s:12:\"is_installed\";i:1;s:10:\"is_default\";i:1;s:10:\"created_at\";s:19:\"2025-11-02 06:18:08\";s:10:\"updated_at\";s:19:\"2025-11-06 04:10:07\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"tags\";s:5:\"array\";s:9:\"is_active\";s:7:\"boolean\";s:12:\"is_installed\";s:7:\"boolean\";s:10:\"is_default\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:7:\"version\";i:3;s:11:\"description\";i:4;s:6:\"author\";i:5;s:10:\"author_url\";i:6;s:10:\"screenshot\";i:7;s:4:\"tags\";i:8;s:9:\"is_active\";i:9;s:12:\"is_installed\";i:10;s:10:\"is_default\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:16:\"App\\Models\\Theme\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"themes\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:14:{s:2:\"id\";i:10;s:4:\"name\";s:7:\"therapy\";s:4:\"type\";s:8:\"frontend\";s:7:\"version\";s:5:\"1.0.0\";s:11:\"description\";s:43:\"Terapia - Physical Therapy Website Template\";s:6:\"author\";s:10:\"HTML Codex\";s:10:\"author_url\";s:21:\"https://htmlcodex.com\";s:10:\"screenshot\";s:18:\"img/carousel-1.jpg\";s:4:\"tags\";s:63:\"[\"therapy\",\"healthcare\",\"medical\",\"physiotherapy\",\"responsive\"]\";s:9:\"is_active\";i:1;s:12:\"is_installed\";i:1;s:10:\"is_default\";i:0;s:10:\"created_at\";s:19:\"2025-11-06 03:58:59\";s:10:\"updated_at\";s:19:\"2025-11-06 04:10:07\";}s:11:\"\0*\0original\";a:14:{s:2:\"id\";i:10;s:4:\"name\";s:7:\"therapy\";s:4:\"type\";s:8:\"frontend\";s:7:\"version\";s:5:\"1.0.0\";s:11:\"description\";s:43:\"Terapia - Physical Therapy Website Template\";s:6:\"author\";s:10:\"HTML Codex\";s:10:\"author_url\";s:21:\"https://htmlcodex.com\";s:10:\"screenshot\";s:18:\"img/carousel-1.jpg\";s:4:\"tags\";s:63:\"[\"therapy\",\"healthcare\",\"medical\",\"physiotherapy\",\"responsive\"]\";s:9:\"is_active\";i:1;s:12:\"is_installed\";i:1;s:10:\"is_default\";i:0;s:10:\"created_at\";s:19:\"2025-11-06 03:58:59\";s:10:\"updated_at\";s:19:\"2025-11-06 04:10:07\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:4:\"tags\";s:5:\"array\";s:9:\"is_active\";s:7:\"boolean\";s:12:\"is_installed\";s:7:\"boolean\";s:10:\"is_default\";s:7:\"boolean\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:4:\"name\";i:1;s:4:\"type\";i:2;s:7:\"version\";i:3;s:11:\"description\";i:4;s:6:\"author\";i:5;s:10:\"author_url\";i:6;s:10:\"screenshot\";i:7;s:4:\"tags\";i:8;s:9:\"is_active\";i:9;s:12:\"is_installed\";i:10;s:10:\"is_default\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1762763937);

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
-- Struktur dari tabel `contoh_plugins`
--

CREATE TABLE `contoh_plugins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contoh_plugins`
--

INSERT INTO `contoh_plugins` (`id`, `judul`, `deskripsi`, `gambar`, `tanggal_dibuat`, `aktif`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'ini Test', 'contoh_plugins/oKEqprBFseZ0JCooLJZjEANcUYzDNGXx9ZKo1gRt.png', NULL, 1, 'test', '2025-11-10 00:40:29', '2025-11-10 00:40:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'fas fa-cube',
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `plugin_name` varchar(255) DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) DEFAULT 'admin',
  `position` enum('header','sidebar-left','sidebar-right','footer') DEFAULT 'header'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `name`, `title`, `route`, `url`, `icon`, `parent_id`, `order`, `is_active`, `plugin_name`, `roles`, `created_at`, `updated_at`, `type`, `position`) VALUES
(75, 'berita', 'Berita', 'panel.berita.index', NULL, 'fas fa-newspaper', NULL, 0, 1, 'Berita', '[\"admin\",\"operator\"]', '2025-11-09 19:56:56', '2025-11-09 19:56:56', 'admin', 'sidebar-left'),
(76, 'berita_frontend', 'Berita', 'berita.index', NULL, 'fas fa-newspaper', NULL, 0, 1, 'Berita', '[]', '2025-11-09 19:56:56', '2025-11-09 19:56:56', 'frontend', 'header');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2025_01_01_000001_create_simpede_tables', 1),
(3, '2014_10_12_100000_create_migrations_table', 2),
(4, '2025_01_01_000002_create_sessions_table', 2),
(5, '2025_01_01_000003_create_menus_table', 2),
(7, '2025_01_01_000001_create_contoh_plugins_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `plugins`
--

CREATE TABLE `plugins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `installed` tinyint(1) NOT NULL DEFAULT 0,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `plugins`
--

INSERT INTO `plugins` (`id`, `name`, `active`, `installed`, `metadata`, `created_at`, `updated_at`) VALUES
(25, 'SimplePage', 1, 1, NULL, '2025-11-07 15:25:02', '2025-11-07 15:25:02'),
(27, 'Testimonial', 1, 1, NULL, '2025-11-07 18:46:19', '2025-11-07 18:46:19'),
(53, 'Berita', 1, 1, NULL, '2025-11-09 19:56:56', '2025-11-09 19:56:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-10-30 20:44:26', '2025-10-30 20:44:26'),
(2, 'Operator', '2025-10-30 20:44:27', '2025-11-08 18:41:28');

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
('l0Yxxo03riOmI07QxnLPKSYj73XN3oi4qz1pcWjL', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZEJQRFdJTDdXaHBVcmNJdEZiU0dIT3FiSDBWN1pmUVRrdnFXRE5SciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3Qvc3RlbGxvQ01TL3B1YmxpYy9wYW5lbC9wbHVnaW5zIjtzOjU6InJvdXRlIjtzOjEzOiJwbHVnaW5zLmluZGV4Ijt9czoxNDoiY2FwdGNoYV9yZXN1bHQiO2k6MTU7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1762764347);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengaturan` varchar(255) NOT NULL,
  `nilai` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `pengaturan`, `nilai`, `status`, `created_at`, `updated_at`) VALUES
(1, 'nama-web', 'PT. Sejahtera Bersama', 'aktif', NULL, '2025-11-09 17:40:19'),
(2, 'deskripsi-web', 'Website milik PT Sejatera Bersama', 'aktif', NULL, '2025-11-09 17:40:42'),
(3, 'keywords-web', 'perusahaan, sejatera bersama, pt sejahtera bersama', 'aktif', NULL, '2025-11-09 17:41:35'),
(4, 'alamat-web', 'Jl Suka Maju 23 Bandung', 'aktif', NULL, NULL),
(5, 'no-telephone', '08732641242', 'aktif', NULL, '2025-11-09 17:39:47'),
(6, 'logo-web', 'img/icon/logo_96x96.png', 'aktif', '2025-11-09 17:39:27', '2025-11-09 20:01:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `version` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `author_url` varchar(255) DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_installed` tinyint(1) NOT NULL DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `themes`
--

INSERT INTO `themes` (`id`, `name`, `type`, `version`, `description`, `author`, `author_url`, `screenshot`, `tags`, `is_active`, `is_installed`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'stocker', 'frontend', '1.0.0', 'Stocker - Stock Market Website Template', 'HTML Codex', 'https://htmlcodex.com', 'img/carousel-1.jpg', '[\"stock-market\",\"finance\",\"investment\",\"business\",\"responsive\"]', 1, 1, 1, '2025-11-01 23:18:08', '2025-11-05 21:10:07'),
(7, 'adminlte', 'admin', '3.2.0', 'AdminLTE Free Bootstrap Admin Template', 'AdminLTE.io', 'https://adminlte.io', 'screenshot.png', '[\"admin\",\"bootstrap\",\"responsive\"]', 1, 1, 1, '2025-11-02 00:15:32', '2025-11-05 21:10:23'),
(10, 'therapy', 'frontend', '1.0.0', 'Terapia - Physical Therapy Website Template', 'HTML Codex', 'https://htmlcodex.com', 'img/carousel-1.jpg', '[\"therapy\",\"healthcare\",\"medical\",\"physiotherapy\",\"responsive\"]', 1, 1, 0, '2025-11-05 20:58:59', '2025-11-05 21:10:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Administrator', 'admin@stellocms.com', NULL, '$2y$12$h9FH.AI.7Mk05f6VmIeo/OqM1D54pLGjI9HB0vxWlp9MtR0gGp/S2', NULL, '2025-10-30 20:44:27', '2025-11-08 18:44:49', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `contoh_plugins`
--
ALTER TABLE `contoh_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plugins_name_unique` (`name`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `contoh_plugins`
--
ALTER TABLE `contoh_plugins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
