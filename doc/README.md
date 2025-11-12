# Dokumentasi stelloCMS

Selamat datang di dokumentasi stelloCMS. Dokumen ini menyediakan panduan lengkap untuk instalasi, konfigurasi, penggunaan, dan pengembangan stelloCMS.

## Tentang stelloCMS

stelloCMS adalah Content Management System (CMS) open-source berbasis Laravel yang dirancang untuk memudahkan pengelolaan konten website. Sistem ini menawarkan fleksibilitas tinggi melalui sistem tema dan plugin yang modular, serta manajemen pengguna berbasis role yang komprehensif.

## Fitur Utama

### 1. Sistem Tema Dinamis
- Deteksi tema otomatis dari folder
- Dukungan tema terpisah untuk admin dan frontend
- Menggunakan AdminLTE sebagai tema admin default (menggantikan CoreUI)
- Kemampuan mengganti tema secara dinamis tanpa mengubah kode

### 2. Sistem Plugin Modular
- Plugin dapat diinstal, diaktifkan, dan dihapus secara dinamis
- Setiap plugin memiliki struktur yang mandiri dengan database, migrasi, dan routing sendiri
- Plugin "Berita" sebagai plugin default untuk manajemen konten umum
- Plugin "Berita Desa" telah dihapus dan diganti dengan plugin "Berita" yang lebih umum
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

## Instalasi Cepat

```bash
# Clone repository
git clone https://github.com/username/stelloCMS.git
cd stelloCMS

# Install dependencies
composer install
npm install && npm run dev

# Konfigurasi environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database dan migrasi
php artisan migrate --seed

# Jalankan aplikasi
php artisan serve
```

## Struktur Direktori

```
simpede/
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Plugins/
│   ├── Providers/
│   ├── Services/
│   ├── Themes/
│   └── helpers.php
├── config/
├── database/
├── public/
├── resources/
│   └── views/
│       └── themes/
├── routes/
├── storage/
├── tests/
└── vendor/
```

## Perubahan Penting

### Perubahan Tema (Versi 1.1.0)
- Mengganti tema admin default dari CoreUI ke AdminLTE untuk stabilitas yang lebih baik
- Menghapus tema CoreUI yang tidak digunakan untuk mengurangi ukuran sistem
- Menyederhanakan struktur tema untuk kemudahan pemeliharaan

### Perubahan Plugin (Versi 1.1.0)
- Mengganti plugin "Berita Desa" yang spesifik dengan plugin "Berita" yang umum
- Plugin "Berita" sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Menghapus kode yang tidak digunakan untuk plugin yang sudah dihapus

## Dokumentasi Lengkap

### Panduan Pengguna
1. [Instalasi dan Konfigurasi](INSTALLATION.md) - Panduan lengkap untuk menginstal dan mengkonfigurasi stelloCMS
2. [Sistem Pengguna dan Hak Akses](USER_MANAGEMENT.md) - Dokumentasi tentang manajemen pengguna, role, dan hak akses
3. [Sistem Tema](THEMING.md) - Panduan untuk menggunakan dan membuat tema
4. [Sistem Plugin](PLUGIN_SYSTEM.md) - Dokumentasi tentang manajemen dan pengembangan plugin
5. [Sistem Menu](MENUS.md) - Dokumentasi tentang manajemen menu dinamis
6. [Konfigurasi Database](DATABASE.md) - Dokumentasi struktur dan konfigurasi database
7. [Konfigurasi Sistem](CONFIGURATION.md) - Dokumentasi konfigurasi sistem secara menyeluruh

### Panduan Pengembang
1. [Arsitektur Sistem](ARCHITECTURE.md) - Gambaran arsitektur stelloCMS
2. [API Documentation](API.md) - Dokumentasi API untuk integrasi
3. [Development Guidelines](DEVELOPMENT.md) - Panduan pengembangan dan best practices
4. [Testing](TESTING.md) - Panduan testing dan quality assurance
5. [Panduan Pembuatan Plugin](Panduan-Pembuatan-Plugin.md) - Panduan lengkap untuk membuat plugin
6. [Contoh Implementasi: Plugin Kategori](Plugin-Kategori-Dokumentasi.md) - Dokumentasi lengkap plugin Kategori sebagai contoh implementasi
7. [Sistem Menu Sidebar Admin](Sistem-Menu-Sidebar-Admin.md) - Dokumentasi lengkap tentang sistem menu sidebar admin yang mencakup menu statis dan dinamis dari plugin
8. [Sistem Widgets](Sistem-Widgets-Dokumentasi.md) - Dokumentasi lengkap sistem manajemen widgets untuk tampilan dinamis
9. [Cara Pembuatan Widget](Cara-Pembuatan-Widget.md) - Panduan praktis untuk membuat dan mengelola widget di sistem stelloCMS

### Referensi Teknis
1. [Database Schema](DATABASE_SCHEMA.md) - Skema database lengkap
2. [Configuration Reference](CONFIGURATION_REFERENCE.md) - Referensi konfigurasi lengkap
3. [Environment Variables](ENVIRONMENT_VARIABLES.md) - Daftar dan penjelasan variabel lingkungan
4. [CLI Commands](CLI_COMMANDS.md) - Daftar dan penjelasan command line interface

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

stelloCMS dilisensikan di bawah lisensi MIT.

## Dukungan dan Komunitas

### Kanal Dukungan
- **GitHub Issues**: Laporkan bug dan permintaan fitur
- **Forum Komunitas**: Diskusi dan bantuan pengguna
- **Documentation**: Dokumentasi resmi dan panduan
- **Email Support**: support@stellocms.com

## Kontak

Untuk pertanyaan dan dukungan, silakan hubungi tim pengembang stelloCMS di hello@stellocms.com.
