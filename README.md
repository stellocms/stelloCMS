# stelloCMS Core

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stellocms/core.svg?style=flat-square)](https://packagist.org/packages/stellocms/core)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/stellocms/core/run-tests?label=tests)](https://github.com/stellocms/core/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/stellocms/core.svg?style=flat-square)](https://packagist.org/packages/stellocms/core)

stelloCMS adalah Content Management System (CMS) open-source berbasis Laravel yang dirancang untuk memudahkan pengelolaan konten website. Sistem ini menawarkan fleksibilitas tinggi melalui sistem tema dan plugin yang modular, serta manajemen pengguna berbasis role yang komprehensif.

## Fitur Utama

### 1. Sistem Tema Dinamis
- Deteksi tema otomatis dari folder
- Dukungan tema terpisah untuk admin dan frontend
- Menggunakan AdminLTE sebagai tema admin default
- Mudah menambahkan tema baru dengan struktur folder sederhana

### 2. Sistem Plugin Modular
- Plugin dapat diinstal, diaktifkan, dan dihapus secara dinamis
- Setiap plugin dapat memiliki database, migrasi, dan routing sendiri
- Plugin "Berita" sebagai plugin default untuk manajemen konten umum
- Integrasi otomatis dengan sistem menu

### 3. Manajemen Pengguna dan Hak Akses
- Berbagai level pengguna (admin, kepala desa, sekretaris desa, dll)
- Sistem role-based access control (RBAC) yang fleksibel
- Manajemen hak akses berdasarkan menu dan role

### 4. Antarmuka Administrasi
- Dashboard informatif dengan statistik sistem
- Manajemen tema dan plugin yang intuitif
- Sistem menu dinamis yang dapat dikustomisasi

## Persyaratan Sistem

- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.2
- Composer
- Node.js dan NPM (opsional)
- Ekstensi PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath

## Instalasi

### Metode 1: Menggunakan Git Clone (Direkomendasikan)

```bash
git clone https://github.com/stellocms/core.git
cd core

# Install dependencies
composer install
npm install && npm run dev

# Konfigurasi environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database
# Edit file .env dan sesuaikan konfigurasi database

# Migrasi database
php artisan migrate --seed

# Jalankan aplikasi
php artisan serve
```

### Metode 2: Menggunakan Composer

```bash
composer create-project stellocms/core nama-project
cd nama-project

# Konfigurasi environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database
# Edit file .env dan sesuaikan konfigurasi database

# Migrasi database
php artisan migrate --seed

# Install assets
npm install && npm run dev

# Jalankan aplikasi
php artisan serve
```

## Konfigurasi

### Konfigurasi Dasar
Edit file `.env` dan sesuaikan konfigurasi berikut:
```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stello_cms
DB_USERNAME=root
DB_PASSWORD=

# Tema Configuration
ADMIN_THEME=adminlte
FRONTEND_THEME=kind_heart

# CMS Configuration
CMS_NAME=stelloCMS
CMS_DESCRIPTION="Limitless Online Content Management"
```

## Dokumentasi

Dokumentasi lengkap tersedia di direktori `/doc`:
- [Panduan Instalasi](doc/id/INSTALLATION.md)
- [Sistem Pengguna dan Hak Akses](doc/id/USER_MANAGEMENT.md)
- [Sistem Tema](doc/id/THEMING.md)
- [Sistem Plugin](doc/id/PLUGIN_SYSTEM.md)
- [Sistem Menu](doc/id/MENUS.md)
- [Konfigurasi Database](doc/id/DATABASE.md)
- [Konfigurasi Sistem](doc/id/CONFIGURATION.md)

## Kontribusi

Kami menyambut kontribusi dari komunitas:
1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat pull request

### Pedoman Kontribusi
- Ikuti pedoman penulisan kode Laravel
- Tulis dokumentasi yang jelas untuk setiap fitur baru
- Tambahkan test untuk setiap perubahan yang signifikan
- Gunakan commit message yang deskriptif
- Pastikan semua test berjalan dengan baik sebelum membuat pull request

## Lisensi

stelloCMS dilisensikan di bawah lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

## Dukungan dan Komunitas

Untuk pertanyaan dan dukungan, silakan hubungi tim pengembang stelloCMS di hello@stello-cms.com.