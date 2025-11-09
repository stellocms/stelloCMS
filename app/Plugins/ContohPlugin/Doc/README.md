# Dokumentasi Plugin Contoh

## Gambaran Umum

Plugin Contoh adalah plugin demonstrasi untuk sistem stelloCMS. Plugin ini menunjukkan struktur dan praktik terbaik dalam pembuatan plugin untuk sistem CMS. Plugin ini menyediakan fitur CRUD untuk mengelola item dengan dukungan frontend dan slug URL-friendly.

## Fitur

- **CRUD Lengkap**: Create, Read, Update, Delete untuk item plugin
- **Backend Admin**: Panel administrasi untuk pengelolaan data
- **Frontend Publik**: Tampilan publik untuk menampilkan data
- **Slug Otomatis**: Pembuatan slug otomatis dari judul item
- **Gambar Pendukung**: Upload dan tampilan gambar untuk setiap item
- **Status Aktif/Nonaktif**: Pengaturan status publikasi item
- **SEO Friendly**: URL menggunakan slug untuk optimasi pencarian

## Struktur Plugin

```
app/Plugins/ContohPlugin/
├── Controllers/
│   └── ContohPluginController.php
├── Models/
│   └── ContohPlugin.php
├── Views/
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── index.blade.php
│   ├── show.blade.php
│   └── frontpage/
│       ├── index.blade.php
│       └── show.blade.php
├── routes.php
├── plugin.json
├── Doc/
│   ├── README.md
│   ├── DEVELOPING.md
│   ├── HELPERS.md
│   └── INSTALLATION.md
```

## Instalasi

### Manual
1. Salin folder plugin ke `app/Plugins/ContohPlugin/`
2. Login ke panel administrasi
3. Buka menu "Plugin"
4. Klik "Instal" pada ContohPlugin
5. Plugin siap digunakan

### Via Upload
1. Buka menu "Plugin" di panel administrasi
2. Klik tombol "Upload Plugin"
3. Pilih file `ContohPlugin.zip`
4. Tunggu proses upload dan instalasi selesai
5. Plugin otomatis aktif

## Penggunaan

### Backend (Admin Panel)

Setelah instalasi, plugin akan membuat menu di panel administrasi:
- Menu: "Manajemen Plugin Contoh"
- URL: `/panel/contohplugin`
- Fitur: Tambah, edit, hapus, dan lihat item

### Frontend (Publik)

Plugin menyediakan tampilan publik:
- Daftar item: `/contohplugin`
- Detail item: `/contohplugin/{slug}`

## Konfigurasi

### File plugin.json

```json
{
    "name": "ContohPlugin",
    "version": "1.0.0",
    "description": "Plugin contoh untuk pengembang - Plugin dengan struktur standar",
    "author": "stelloCMS Developer",
    "author_url": "https://stellocms.com",
    "required_version": "1.0.0",
    "database": {
        "migrations": "Database/Migrations",
        "seeders": "Database/Seeders"
    }
}
```

### Model

Model `ContohPlugin` menggunakan fitur berikut:
- Auto-generate slug dari judul
- Validasi data
- Relasi (jika diperlukan)

### Struktur Tabel

```sql
CREATE TABLE `contoh_plugins` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `gambar` VARCHAR(255) NULL,
    `tanggal_dibuat` TIMESTAMP NULL,
    `aktif` BOOLEAN DEFAULT TRUE,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL
);
```

## Helper Functions

### generate_slug()

Helper untuk membuat slug URL-friendly:
```php
$slug = generate_slug($judul);
```

## Routing

### Backend Routes
- `GET /panel/contohplugin` - Daftar item (admin)
- `GET /panel/contohplugin/create` - Form tambah (admin)
- `POST /panel/contohplugin` - Simpan item (admin)
- `GET /panel/contohplugin/{id}/edit` - Form edit (admin)
- `PUT /panel/contohplugin/{id}` - Update item (admin)
- `DELETE /panel/contohplugin/{id}` - Hapus item (admin)

### Frontend Routes
- `GET /contohplugin` - Daftar item (publik)
- `GET /contohplugin/{slug}` - Detail item (publik)

## Panduan Pengembangan Plugin

Lihat dokumentasi lengkap di [DEVELOPING.md](DEVELOPING.md) untuk informasi tentang cara membuat plugin baru dari awal.

## Troubleshooting

### Plugin Tidak Muncul di Menu
- Pastikan plugin telah diinstal dengan benar di sistem
- Cek apakah nama plugin sesuai dengan nama folder
- Pastikan plugin.json valid dan komplit

### Route Tidak Bekerja
- Pastikan route telah di-definisikan dengan benar
- Clear route cache: `php artisan route:clear`

### View Tidak Ditemukan
- Pastikan namespace view benar
- Pastikan file view berada di lokasi yang benar
- Clear view cache: `php artisan view:clear`

## Lisensi

Plugin ini merupakan bagian dari sistem stelloCMS dan dilisensikan di bawah lisensi MIT.