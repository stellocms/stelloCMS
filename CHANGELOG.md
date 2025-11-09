# Changelog

## [v1.0.0] - 2025-11-09

### Rilis Versi 1.0.0

Versi pertama dari stelloCMS - Content Management System berbasis Laravel dengan pendekatan modular terhadap tema dan plugin.

### Fitur Utama

- **Sistem Tema Dinamis**
  - Deteksi tema otomatis dari folder
  - Dukungan tema terpisah untuk admin dan frontend
  - Menggunakan AdminLTE sebagai tema admin default
  - Kemampuan mengganti tema secara dinamis tanpa mengubah kode

- **Sistem Plugin Modular**
  - Plugin dapat diinstal, diaktifkan, dan dihapus secara dinamis
  - Setiap plugin memiliki struktur yang mandiri dengan database, migrasi, dan routing sendiri
  - Plugin "Berita" sebagai plugin default untuk manajemen konten umum
  - Integrasi otomatis dengan sistem menu

- **Manajemen Pengguna dan Hak Akses**
  - Berbagai level pengguna (admin, kepala desa, sekretaris desa, dll)
  - Sistem role-based access control (RBAC) yang fleksibel
  - Manajemen hak akses berdasarkan menu dan role

- **Antarmuka Administrasi**
  - Dashboard informatif dengan statistik sistem
  - Manajemen tema dan plugin yang intuitif
  - Sistem menu dinamis yang dapat dikustomisasi

### Perubahan Penting

- Mengganti tema admin default dari CoreUI ke AdminLTE untuk stabilitas yang lebih baik
- Menghapus tema CoreUI yang tidak digunakan untuk mengurangi ukuran sistem
- Menyederhanakan struktur tema untuk kemudahan pemeliharaan
- Mengganti plugin "Berita Desa" yang spesifik dengan plugin "Berita" yang umum
- Plugin "Berita" sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Menghapus kode yang tidak digunakan untuk plugin yang sudah dihapus

### Teknologi yang Digunakan

- Laravel 12.x
- PHP 8.2+
- MySQL 5.7+ atau MariaDB 10.2+
- AdminLTE sebagai tema admin
- Sistem plugin modular
- Sistem tema dinamis