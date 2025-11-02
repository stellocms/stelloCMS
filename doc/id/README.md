# Dokumentasi stelloCMS

## Tentang stelloCMS

stelloCMS adalah Content Management System (CMS) berbasis Laravel yang dirancang untuk memudahkan pengelolaan konten website. Sistem ini dilengkapi dengan fitur tema dinamis, plugin modular, dan manajemen pengguna yang fleksibel.

## Fitur Utama

### 1. Sistem Tema Dinamis
- Dapat mendeteksi tema secara otomatis dari folder
- Dukungan untuk tema admin dan frontend terpisah
- Mudah menambahkan tema baru dengan struktur folder sederhana

### 2. Sistem Plugin Modular
- Plugin dapat diinstal, diaktifkan, dan dihapus secara dinamis
- Setiap plugin dapat memiliki database, migrasi, dan routing sendiri
- Plugin "Berita" sebagai plugin default untuk manajemen konten umum
- Mengganti plugin "Berita Desa" yang spesifik dengan plugin "Berita" yang umum
- Plugin "Berita" sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Sistem menu otomatis untuk plugin yang diinstal

### 3. Manajemen Pengguna dan Hak Akses
- Berbagai level pengguna (admin, kepala desa, sekretaris desa, dll)
- Sistem role-based access control (RBAC)
- Manajemen hak akses berdasarkan menu

### 4. Antarmuka Administrasi
- Dashboard informatif
- Manajemen tema dan plugin yang intuitif
- Sistem menu dinamis

## Instalasi

### Persyaratan Sistem
- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.2
- Composer
- Node.js dan NPM (opsional)

### Langkah Instalasi
1. Clone repository stelloCMS
2. Jalankan `composer install`
3. Salin `.env.example` menjadi `.env`
4. Konfigurasi database di file `.env`
5. Jalankan `php artisan key:generate`
6. Jalankan `php artisan migrate --seed`
7. Akses aplikasi melalui browser

## Konfigurasi

### Konfigurasi Dasar
- `ADMIN_THEME`: Tema yang digunakan untuk panel administrasi
- `FRONTEND_THEME`: Tema yang digunakan untuk tampilan publik
- `CMS_NAME`: Nama CMS yang ditampilkan
- `CMS_DESCRIPTION`: Deskripsi CMS

### Konfigurasi Database
- `DB_CONNECTION`: Jenis koneksi database
- `DB_HOST`: Host database
- `DB_PORT`: Port database
- `DB_DATABASE`: Nama database
- `DB_USERNAME`: Username database
- `DB_PASSWORD`: Password database

## Sistem Tema

### Struktur Tema
Setiap tema harus memiliki struktur dasar:
```
/themes/
├── admin/
│   └── {nama_tema}/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       └── theme.json
└── frontend/
    └── {nama_tema}/
        ├── layouts/
        │   └── app.blade.php
        └── theme.json
```

### Membuat Tema Baru
1. Buat folder tema di `/themes/admin/` atau `/themes/frontend/`
2. Tambahkan file `theme.json` dengan informasi tema
3. Buat struktur view yang diperlukan
4. Tema akan terdeteksi secara otomatis

## Sistem Plugin

### Struktur Plugin
Setiap plugin harus memiliki struktur dasar:
```
/Plugins/
└── {nama_plugin}/
    ├── Controllers/
    ├── Models/
    ├── Views/
    ├── Database/
    │   ├── Migrations/
    │   └── Seeders/
    ├── routes.php
    ├── plugin.json
    └── helpers.php (opsional)
```

### Membuat Plugin Baru
1. Buat folder plugin di `/app/Plugins/`
2. Tambahkan file `plugin.json` dengan informasi plugin
3. Buat controller, model, dan view yang diperlukan
4. Tambahkan migrasi database jika diperlukan
5. Plugin akan terdeteksi secara otomatis

### Instalasi Plugin
1. Akses panel administrasi
2. Buka menu "Plugin"
3. Klik tombol "Instal" pada plugin yang diinginkan
4. Plugin akan diinstal dan aktif secara otomatis

### Penghapusan Plugin
1. Akses panel administrasi
2. Buka menu "Plugin"
3. Klik tombol "Hapus" pada plugin yang diinginkan
4. Plugin akan dihapus dari sistem (data dapat dipertahankan)

## Pengembangan

### Membuat Tema
Untuk membuat tema baru:
1. Ikuti struktur tema yang telah ditentukan
2. Gunakan helper `view_theme()` untuk rendering view
3. Pastikan file `theme.json` berisi informasi yang lengkap

### Membuat Plugin
Untuk membuat plugin baru:
1. Ikuti struktur plugin yang telah ditentukan
2. Gunakan namespace yang sesuai (`App\Plugins\{NamaPlugin}\...`)
3. Tambahkan migrasi database jika diperlukan
4. Gunakan helper `view_theme()` untuk rendering view plugin

## Sistem Plugin

### Plugin Berita
Plugin untuk mengelola berita dan informasi secara umum.

#### Fitur:
- Manajemen berita dengan CRUD
- Upload gambar untuk berita
- Penjadwalan publikasi
- Status aktif/tidak aktif
- Integrasi dengan sistem menu

#### Instalasi:
Plugin ini diinstal secara default saat sistem dijalankan pertama kali.

#### Konfigurasi:
- Tidak memerlukan konfigurasi khusus
- Dapat diakses melalui menu "Berita" di panel administrasi

#### Database:
Membuat tabel `berita` dengan struktur:
```sql
CREATE TABLE `berita` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `isi` TEXT NOT NULL,
    `gambar` VARCHAR(255) NULL,
    `tanggal_publikasi` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `aktif` BOOLEAN DEFAULT TRUE,
    `user_id` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);
```

## Troubleshooting

### Error Umum
- **Class not found**: Pastikan namespace dan struktur folder sudah benar
- **View not found**: Pastikan view menggunakan namespace yang benar
- **Database error**: Periksa koneksi database dan hak akses

### Maintenance
- Jalankan `php artisan config:clear` untuk membersihkan cache konfigurasi
- Jalankan `php artisan view:clear` untuk membersihkan cache view
- Jalankan `php artisan route:clear` untuk membersihkan cache route

## Lisensi

stelloCMS dilisensikan di bawah lisensi MIT.

## Kontribusi

Kami menyambut kontribusi dari komunitas. Untuk berkontribusi:
1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat pull request

## Kontak

Untuk pertanyaan dan dukungan, silakan hubungi tim pengembang stelloCMS.