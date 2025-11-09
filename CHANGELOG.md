# Changelog stelloCMS

Semua perubahan penting pada proyek ini akan didokumentasikan dalam file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Plugin Contoh untuk demonstrasi struktur dan praktik terbaik
- Fungsi helper `generate_slug()` untuk membuat slug URL-friendly
- Sistem manajemen plugin yang otomatis
- Sistem tema dinamis dengan dukungan admin dan frontend
- Menu management system dengan hak akses role-based
- Dokumentasi lengkap untuk pengembangan plugin
- Halaman instalasi menggunakan PHP native dengan tema AdminLTE

### Changed
- Mengganti nama domain dari `stello-cms.com` menjadi `stellocms.com`
- Menambahkan fitur slug otomatis di plugin Contoh
- Memperbarui sistem instalasi database untuk plugin
- Menambahkan versi aplikasi ke konfigurasi `config/app.php`
- Menampilkan versi aplikasi secara dinamis di footer
- Mengganti tema admin default dari CoreUI ke AdminLTE
- Memindahkan menu "Tema", "Plugin", "Menu" ke dalam submenu "Pengaturan"
- Mengganti nama menu dari "Manajemen Plugin Contoh" menjadi "Setting"
- Memperbarui dokumentasi plugin Contoh

## [1.0.0] - 2025-11-09

### Added
- Sistem plugin modular
- Sistem tema dinamis
- Sistem role-based access control
- Panel administrasi berbasis AdminLTE
- Plugin Berita sebagai contoh plugin utama
- Sistem menu dinamis
- Fitur upload plugin
- Sistem manajemen pengguna dan hak akses
- Fitur CRUD untuk plugin

### Changed
- Menyesuaikan struktur database untuk plugin
- Mengganti struktur folder plugin
- Memperbarui sistem routing
- Mengganti sistem authentikasi
- Memperbarui tema admin ke AdminLTE

[Unreleased]: https://github.com/stellocms/stelloCMS/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/stellocms/stelloCMS/releases/tag/v1.0.0