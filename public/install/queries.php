<?php

// Array berisi query-query untuk instalasi stelloCMS
$sql_queries = [
    "CREATE TABLE IF NOT EXISTS `berita` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `judul` varchar(255) NOT NULL,
      `isi` text NOT NULL,
      `gambar` varchar(255) DEFAULT NULL,
      `tanggal_publikasi` timestamp NOT NULL DEFAULT current_timestamp(),
      `aktif` tinyint(1) DEFAULT 1,
      `user_id` bigint(20) UNSIGNED DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `cache` (
      `key` varchar(255) NOT NULL,
      `value` mediumtext NOT NULL,
      `expiration` int(11) NOT NULL,
      PRIMARY KEY (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `cache_locks` (
      `key` varchar(255) NOT NULL,
      `owner` varchar(255) NOT NULL,
      `expiration` int(11) NOT NULL,
      PRIMARY KEY (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `contoh_plugins` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `judul` varchar(255) NOT NULL,
      `deskripsi` text NOT NULL,
      `gambar` varchar(255) DEFAULT NULL,
      `tanggal_dibuat` timestamp NULL DEFAULT NULL,
      `aktif` tinyint(1) DEFAULT 1,
      `slug` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `failed_jobs` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `uuid` varchar(255) NOT NULL,
        `connection` text NOT NULL,
        `queue` text NOT NULL,
        `payload` longtext NOT NULL,
        `exception` longtext NOT NULL,
        `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `jobs` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `queue` varchar(255) NOT NULL,
        `payload` longtext NOT NULL,
        `attempts` tinyint unsigned NOT NULL,
        `reserved_at` int unsigned DEFAULT NULL,
        `available_at` int unsigned NOT NULL,
        `created_at` int unsigned NOT NULL,
        PRIMARY KEY (`id`),
        KEY `jobs_queue_index` (`queue`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `menus` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
      `position` enum('header','sidebar-left','sidebar-right','footer') DEFAULT 'header',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `migrations` (
      `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `migration` varchar(255) NOT NULL,
      `batch` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
        `email` varchar(255) NOT NULL,
        `token` varchar(255) NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `tokenable_type` varchar(255) NOT NULL,
        `tokenable_id` bigint unsigned NOT NULL,
        `name` varchar(255) NOT NULL,
        `token` varchar(64) NOT NULL,
        `abilities` text,
        `last_used_at` timestamp NULL DEFAULT NULL,
        `expires_at` timestamp NULL DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
        KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `plugins` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `active` tinyint(1) NOT NULL DEFAULT 0,
      `installed` tinyint(1) NOT NULL DEFAULT 0,
      `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `plugins_name_unique` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `sessions` (
      `id` varchar(255) NOT NULL,
      `user_id` bigint(20) UNSIGNED DEFAULT NULL,
      `ip_address` varchar(45) DEFAULT NULL,
      `user_agent` text DEFAULT NULL,
      `payload` longtext NOT NULL,
      `last_activity` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `sessions_user_id_index` (`user_id`),
      KEY `sessions_last_activity_index` (`last_activity`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `settings` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `pengaturan` varchar(255) NOT NULL,
      `nilai` text DEFAULT NULL,
      `status` enum('aktif','nonaktif') DEFAULT 'aktif',
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `themes` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `roles` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `roles_name_unique` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `users` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `email_verified_at` timestamp NULL DEFAULT NULL,
      `password` varchar(255) NOT NULL,
      `remember_token` varchar(100) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      `role_id` bigint(20) UNSIGNED DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `users_email_unique` (`email`),
      KEY `users_role_id_foreign` (`role_id`),
      CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
    (1, 'admin', NOW(), NOW()),
    (2, 'Operator', NOW(), NOW());",

    "INSERT INTO `themes` (`id`, `name`, `type`, `version`, `description`, `author`, `author_url`, `screenshot`, `tags`, `is_active`, `is_installed`, `is_default`, `created_at`, `updated_at`) VALUES
    (1, 'stocker', 'frontend', '1.0.0', 'Stocker - Stock Market Website Template', 'HTML Codex', 'https://htmlcodex.com', 'img/carousel-1.jpg', '[\"stock-market\",\"finance\",\"investment\",\"business\",\"responsive\"]', 1, 1, 1, NOW(), NOW()),
    (7, 'adminlte', 'admin', '3.2.0', 'AdminLTE Free Bootstrap Admin Template', 'AdminLTE.io', 'https://adminlte.io', 'screenshot.png', '[\"admin\",\"bootstrap\",\"responsive\"]', 1, 1, 1, NOW(), NOW()),
    (10, 'therapy', 'frontend', '1.0.0', 'Terapia - Physical Therapy Website Template', 'HTML Codex', 'https://htmlcodex.com', 'img/carousel-1.jpg', '[\"therapy\",\"healthcare\",\"medical\",\"physiotherapy\",\"responsive\"]', 1, 1, 0, NOW(), NOW());",

    "INSERT INTO `menus` (`id`, `name`, `title`, `route`, `url`, `icon`, `parent_id`, `order`, `is_active`, `plugin_name`, `roles`, `created_at`, `updated_at`, `type`, `position`) VALUES
    (75, 'berita', 'Berita', 'panel.berita.index', NULL, 'fas fa-newspaper', NULL, 0, 1, 'Berita', '[\"admin\",\"operator\"]', NOW(), NOW(), 'admin', 'sidebar-left'),
    (76, 'berita_frontend', 'Berita', 'berita.index', NULL, 'fas fa-newspaper', NULL, 0, 1, 'Berita', '[]', NOW(), NOW(), 'frontend', 'header');"
];