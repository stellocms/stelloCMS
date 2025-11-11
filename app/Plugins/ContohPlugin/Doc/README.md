# Dokumentasi Plugin ContohPlugin

## Deskripsi

Plugin ContohPlugin adalah plugin demonstrasi untuk sistem stelloCMS. Plugin ini menunjukkan struktur dan praktik terbaik dalam pembuatan plugin untuk sistem CMS. Plugin ini menyediakan fitur CRUD untuk mengelola item dengan dukungan frontend dan slug URL-friendly.

## Versi
- 1.0.0

## Fitur Utama

### 1. Manajemen Item Lengkap
- CRUD (Create, Read, Update, Delete) item
- Upload dan manajemen gambar untuk item
- Status publikasi (aktif/tidak aktif)
- Slug otomatis dari judul
- Relasi dengan pengguna (jika diterapkan)

### 2. Akses Ganda
- Tampilan admin untuk manajemen item
- Tampilan publik untuk pengunjung
- Route terpisah untuk admin dan publik

### 3. Frontend Responsif
- Tampilan grid card untuk daftar item
- Tampilan detail dengan breadcrumb
- Sidebar informasi tambahan
- Struktur SEO-friendly

## Struktur File

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
├── Doc/
│   ├── README.md
│   ├── API.md
│   ├── DEVELOPMENT.md
│   ├── DEVELOPING.md
│   ├── HELPERS.md
│   └── INSTALLATION.md
├── plugin.json
├── routes.php
└── install.php
```

**Catatan:** Folder `Database/` tidak lagi diperlukan karena struktur tabel sekarang ditangani melalui file `install.php`.

## Model

### Tabel `contoh_plugins`

| Kolom | Tipe Data | Deskripsi |
|-------|-----------|-----------|
| id | BIGINT (unsigned) | Primary key |
| judul | VARCHAR(255) | Judul item |
| deskripsi | TEXT | Deskripsi/isi item |
| gambar | VARCHAR(255) (nullable) | Path gambar item |
| tanggal_dibuat | TIMESTAMP (nullable) | Tanggal pembuatan item |
| aktif | BOOLEAN | Status publikasi (aktif/tidak) |
| slug | VARCHAR(255) | Slug URL-friendly (unik) |
| created_at | TIMESTAMP | Tanggal pembuatan |
| updated_at | TIMESTAMP | Tanggal pembaruan |

## Routes

### Rute Admin (memerlukan otentikasi)
- `GET /panel/contohplugin` → `ContohPluginController@index` (nama route: `panel.contohplugin.index`)
- `GET /panel/contohplugin/create` → `ContohPluginController@create` (nama route: `panel.contohplugin.create`)
- `POST /panel/contohplugin` → `ContohPluginController@store` (nama route: `panel.contohplugin.store`)
- `GET /panel/contohplugin/{id}/edit` → `ContohPluginController@edit` (nama route: `panel.contohplugin.edit`)
- `PUT /panel/contohplugin/{id}` → `ContohPluginController@update` (nama route: `panel.contohplugin.update`)
- `DELETE /panel/contohplugin/{id}` → `ContohPluginController@destroy` (nama route: `panel.contohplugin.destroy`)
- `GET /panel/contohplugin/{id}` → `ContohPluginController@show` (nama route: `panel.contohplugin.show`)

### Rute Publik
- `GET /contohplugin` → `ContohPluginController@frontpageIndex` (nama route: `contohplugin.frontpage.index`)
- `GET /contohplugin/{slug}` → `ContohPluginController@frontpageShow` (nama route: `contohplugin.frontpage.show`)

## Controller

### ContohPluginController

#### Method Admin
- `index()` - Menampilkan daftar item untuk admin
- `create()` - Menampilkan form tambah item
- `store(Request $request)` - Menyimpan item baru
- `show($id)` - Menampilkan detail item untuk admin
- `edit($id)` - Menampilkan form edit item
- `update(Request $request, $id)` - Memperbarui item
- `destroy($id)` - Menghapus item

#### Method Publik
- `frontpageIndex()` - Menampilkan daftar item untuk publik
- `frontpageShow($slug)` - Menampilkan detail item untuk publik

## View

### Tampilan Admin
- `index.blade.php` - Daftar item dengan opsi CRUD
- `create.blade.php` - Form tambah item
- `edit.blade.php` - Form edit item
- `show.blade.php` - Detail item untuk admin

### Tampilan Frontend
- `frontpage/index.blade.php` - Daftar item dalam format card untuk publik
- `frontpage/show.blade.php` - Detail item untuk publik dengan breadcrumb

## Konfigurasi Plugin

### plugin.json
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
    },
    "install_script": "install.php"
}
```

## File Install.php

File `install.php` adalah script untuk menangani pembuatan dan pembaruan struktur tabel `contoh_plugins` secara dinamis. File ini berisi class `{NamaPlugin}Installer` (dalam kasus ini `ContohPluginInstaller`) yang menyediakan metode untuk:

- `install()` - Membuat atau memperbarui struktur tabel contoh_plugins
- `uninstall()` - Menghapus tabel contoh_plugins saat plugin dihapus

**Catatan penting:** PluginManager akan secara otomatis mencari class `{NamaPlugin}Installer` berdasarkan nama folder plugin. Dalam kasus ini, karena nama plugin adalah "ContohPlugin", maka nama kelas harus "ContohPluginInstaller".

Fitur dari installer:
- Mengecek apakah tabel sudah ada sebelum membuat
- Memperbarui struktur tabel jika kolom baru ditambahkan
- Menjamin keunikan kolom slug
- Memperbarui tipe data kolom jika diperlukan

## Instalasi dan Konfigurasi

1. Plugin akan otomatis terdeteksi oleh sistem plugin stelloCMS
2. Jalankan migrasi untuk membuat tabel `contoh_plugins`: `php artisan migrate`
3. Plugin siap digunakan

## Panduan Penggunaan

### Untuk Admin
1. Akses `/panel/contohplugin` untuk mengelola item
2. Gunakan tombol "Tambah Contoh Plugin" untuk membuat item baru
3. Gunakan tombol edit/hapus untuk mengelola item yang sudah ada
4. Gunakan checkbox "Aktif" untuk mengatur status publikasi

### Untuk Pengunjung
1. Akses `/contohplugin` untuk melihat daftar item publik
2. Klik judul item untuk melihat detail item

## Panduan Pengembang

### Model ContohPlugin
```php
use App\Plugins\ContohPlugin\Models\ContohPlugin;

$item = ContohPlugin::where('aktif', true)->get();
$item = ContohPlugin::where('slug', $slug)->first();
$item = ContohPlugin::create($data);
```

### Route dalam View
#### Admin View
```php
// Dalam view admin
route('panel.contohplugin.index')     // Daftar item
route('panel.contohplugin.create')    // Tambah item
route('panel.contohplugin.edit', $id) // Edit item
```

#### Frontend View
```php
// Dalam view frontend
route('contohplugin.frontpage.index')     // Daftar item publik
route('contohplugin.frontpage.show', $slug) // Detail item publik
```

## Integrasi dengan Sistem

### Menu Otomatis
- Plugin akan menambahkan menu otomatis ke sistem menu admin
- Nama menu: "ContohPlugin" 
- Route: `panel.contohplugin.index`
- Icon: `fas fa-cube`

### Hak Akses
- Menu tersedia untuk role: admin, operator
- Akses route dilindungi dengan middleware `auth`

## Troubleshooting

### Error Route Tidak Ditemukan
- Pastikan plugin aktif di halaman manajemen plugin
- Jalankan `php artisan route:clear` untuk membersihkan cache route

### Error View Tidak Ditemukan
- Pastikan namespace plugin benar (`contohplugin::`)
- Jalankan `php artisan view:clear` untuk membersihkan cache view

### Gambar Tidak Muncul
- Pastikan folder `storage/app/public` bisa diakses
- Pastikan symlink sudah dibuat: `php artisan storage:link`

### Slug Tidak Dibuat Otomatis
- Pastikan helper `generate_slug` terdaftar
- Cek apakah field `judul` telah diisi saat pembuatan item