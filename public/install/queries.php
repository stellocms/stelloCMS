<?php

// Array berisi query-query untuk instalasi stelloCMS
$sql_queries = [
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
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `judul` varchar(255) NOT NULL,
        `deskripsi` text NOT NULL,
        `gambar` varchar(255) DEFAULT NULL,
        `tanggal_dibuat` timestamp NULL DEFAULT NULL,
        `aktif` tinyint(1) NOT NULL DEFAULT '1',
        `slug` varchar(255) NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `contoh_plugins_slug_unique` (`slug`)
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
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        `route` varchar(255) NOT NULL,
        `icon` varchar(255) DEFAULT NULL,
        `parent_id` bigint unsigned DEFAULT NULL,
        `order` int DEFAULT '0',
        `is_active` tinyint(1) NOT NULL DEFAULT '1',
        `plugin_name` varchar(255) DEFAULT NULL,
        `roles` json DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `menus_parent_id_foreign` (`parent_id`),
        CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `migrations` (
        `id` int unsigned NOT NULL AUTO_INCREMENT,
        `migration` varchar(255) NOT NULL,
        `batch` int NOT NULL,
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
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `title` varchar(255) DEFAULT NULL,
        `version` varchar(255) DEFAULT NULL,
        `description` text,
        `author` varchar(255) DEFAULT NULL,
        `author_url` varchar(255) DEFAULT NULL,
        `category` varchar(255) DEFAULT NULL,
        `screenshot` varchar(255) DEFAULT NULL,
        `tags` json DEFAULT NULL,
        `installed` tinyint(1) NOT NULL DEFAULT '0',
        `active` tinyint(1) NOT NULL DEFAULT '0',
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `plugins_name_unique` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `sessions` (
        `id` varchar(255) NOT NULL,
        `user_id` bigint unsigned DEFAULT NULL,
        `ip_address` varchar(45) DEFAULT NULL,
        `user_agent` text,
        `payload` longtext NOT NULL,
        `last_activity` int NOT NULL,
        PRIMARY KEY (`id`),
        KEY `sessions_user_id_index` (`user_id`),
        KEY `sessions_last_activity_index` (`last_activity`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `themes` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `type` enum('admin','frontend') NOT NULL,
        `version` varchar(255) NOT NULL,
        `description` text,
        `author` varchar(255) DEFAULT NULL,
        `author_url` varchar(255) DEFAULT NULL,
        `screenshot` varchar(255) DEFAULT NULL,
        `tags` json DEFAULT NULL,
        `is_active` tinyint(1) NOT NULL DEFAULT '0',
        `is_installed` tinyint(1) NOT NULL DEFAULT '0',
        `is_default` tinyint(1) NOT NULL DEFAULT '0',
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `themes_name_type_unique` (`name`,`type`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `roles` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `description` text,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `roles_name_unique` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `settings` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `pengaturan` varchar(255) NOT NULL,
        `nilai` text,
        `status` enum('aktif','nonaktif') DEFAULT 'aktif',
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "CREATE TABLE IF NOT EXISTS `users` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `email_verified_at` timestamp NULL DEFAULT NULL,
        `password` varchar(255) NOT NULL,
        `remember_token` varchar(100) DEFAULT NULL,
        `role_id` bigint unsigned NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `users_email_unique` (`email`),
        KEY `users_role_id_foreign` (`role_id`),
        CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

    "INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES 
    (1, 'admin', 'Administrator system with full access', NOW(), NOW()),
    (2, 'kepala-desa', 'Kepala Desa', NOW(), NOW()),
    (3, 'sekdes', 'Sekretaris Desa', NOW(), NOW()),
    (4, 'kaur', 'Kepala Urusan', NOW(), NOW()),
    (5, 'kadus', 'Kepala Dusun', NOW(), NOW()),
    (6, 'rw', 'Ketua RW', NOW(), NOW()),
    (7, 'rt', 'Ketua RT', NOW(), NOW()),
    (8, 'warga', 'Anggota masyarakat', NOW(), NOW());",

    "INSERT INTO `themes` (`id`, `name`, `type`, `version`, `description`, `author`, `author_url`, `screenshot`, `tags`, `is_active`, `is_installed`, `is_default`, `created_at`, `updated_at`) VALUES 
    (1, 'adminlte', 'admin', '3.2.0', 'AdminLTE - Free Admin Dashboard Template', 'ColorlibHQ', 'https://adminlte.io', 'img/adminlte-screenshot.png', '[\"admin\", \"dashboard\", \"responsive\"]', 1, 1, 1, NOW(), NOW()),
    (2, 'kind_heart', 'frontend', '1.0.0', 'Kind Heart Charity - Charity Website Template', 'Colorlib', 'https://colorlib.com', 'img/kind-heart-screenshot.png', '[\"charity\", \"non-profit\", \"donation\"]', 1, 1, 1, NOW(), NOW());",

    "INSERT INTO `menus` (`id`, `name`, `title`, `route`, `icon`, `parent_id`, `order`, `is_active`, `plugin_name`, `created_at`, `updated_at`) VALUES 
    (1, 'dashboard', 'Dashboard', 'panel.dashboard', 'fas fa-tachometer-alt', NULL, 1, 1, NULL, NOW(), NOW()),
    (2, 'themes', 'Manajemen Tema', 'themes.index', 'fas fa-paint-brush', NULL, 2, 1, NULL, NOW(), NOW()),
    (3, 'plugins', 'Manajemen Plugin', 'plugins.index', 'fas fa-plug', NULL, 3, 1, NULL, NOW(), NOW()),
    (4, 'users', 'Manajemen Pengguna', '#', 'fas fa-users', NULL, 4, 1, NULL, NOW(), NOW()),
    (5, 'user-management', 'Manajemen Pengguna', 'users.index', 'fas fa-user-cog', 4, 1, 1, NULL, NOW(), NOW()),
    (6, 'role-management', 'Manajemen Peran', 'roles.index', 'fas fa-user-tag', 4, 2, 1, NULL, NOW(), NOW()),
    (7, 'menu-management', 'Manajemen Menu', 'menus.index', 'fas fa-list', NULL, 5, 1, NULL, NOW(), NOW());"
];