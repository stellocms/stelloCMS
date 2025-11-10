# Dokumentasi Plugin Berita

## Deskripsi

Plugin Berita adalah plugin untuk mengelola konten berita dan informasi dalam sistem stelloCMS. Plugin ini menyediakan fungsionalitas untuk membuat, mengedit, dan menampilkan berita di sisi admin dan publik.

## Versi
- 1.0.0

## Fitur Utama

### 1. Manajemen Berita Lengkap
- CRUD (Create, Read, Update, Delete) berita
- Upload dan manajemen gambar untuk berita
- Status publikasi (aktif/tidak aktif)
- Tanggal publikasi
- Relasi dengan pengguna yang membuat berita

### 2. Akses Ganda
- Tampilan admin untuk manajemen berita
- Tampilan publik untuk pembaca berita
- Route terpisah untuk admin dan publik

### 3. Frontend Responsif
- Tampilan grid card untuk daftar berita
- Tampilan detail dengan breadcrumb
- Sidebar informasi tambahan
- Struktur SEO-friendly

## Struktur File

```
app/Plugins/Berita/
├── Controllers/
│   └── BeritaController.php
├── Models/
│   └── Berita.php
├── Views/
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── index.blade.php
│   ├── show.blade.php
│   └── frontend/
│       ├── index.blade.php
│       └── show.blade.php
├── Database/
│   ├── Migrations/
│   │   └── 2025_01_01_000000_create_berita_table.php
│   └── Seeders/
│       └── BeritaTableSeeder.php
├── Doc/
│   └── README.md
├── plugin.json
└── routes.php
```

## Model

### Tabel `berita`

| Kolom | Tipe Data | Deskripsi |
|-------|-----------|-----------|
| id | BIGINT (unsigned) | Primary key |
| judul | VARCHAR(255) | Judul berita |
| isi | TEXT | Isi/konten berita |
| gambar | VARCHAR(255) (nullable) | Path gambar berita |
| tanggal_publikasi | TIMESTAMP | Tanggal publikasi berita |
| aktif | BOOLEAN | Status publikasi (aktif/tidak) |
| user_id | BIGINT (unsigned, nullable) | Foreign key ke tabel users |
| created_at | TIMESTAMP | Tanggal pembuatan |
| updated_at | TIMESTAMP | Tanggal pembaruan |

## Routes

### Rute Admin (memerlukan otentikasi)
- `GET /panel/berita` → `BeritaController@index` (nama route: `panel.berita.index`)
- `GET /panel/berita/create` → `BeritaController@create` (nama route: `panel.berita.create`)
- `POST /panel/berita` → `BeritaController@store` (nama route: `panel.berita.store`)
- `GET /panel/berita/{id}` → `BeritaController@show` (nama route: `panel.berita.show`)
- `GET /panel/berita/{id}/edit` → `BeritaController@edit` (nama route: `panel.berita.edit`)
- `PUT /panel/berita/{id}` → `BeritaController@update` (nama route: `panel.berita.update`)
- `DELETE /panel/berita/{id}` → `BeritaController@destroy` (nama route: `panel.berita.destroy`)

### Rute Publik
- `GET /berita` → `BeritaController@publicIndex` (nama route: `berita.index`)
- `GET /berita/{id}` → `BeritaController@publicShow` (nama route: `berita.show`)

## Controller

### BeritaController

#### Method Admin
- `index()` - Menampilkan daftar berita untuk admin
- `create()` - Menampilkan form tambah berita
- `store(Request $request)` - Menyimpan berita baru
- `show($id)` - Menampilkan detail berita (admin atau publik)
- `edit($id)` - Menampilkan form edit berita
- `update(Request $request, $id)` - Memperbarui berita
- `destroy($id)` - Menghapus berita

#### Method Publik
- `publicIndex()` - Menampilkan daftar berita untuk publik
- `publicShow($id)` - Menampilkan detail berita untuk publik

## View

### Tampilan Admin
- `index.blade.php` - Daftar berita dengan opsi CRUD
- `create.blade.php` - Form tambah berita
- `edit.blade.php` - Form edit berita
- `show.blade.php` - Detail berita untuk admin

### Tampilan Frontend
- `frontend/index.blade.php` - Daftar berita dalam format card untuk publik
- `frontend/show.blade.php` - Detail berita untuk publik dengan breadcrumb

## Konfigurasi Plugin

### plugin.json
```json
{
    "name": "Berita",
    "version": "1.0.0",
    "description": "Plugin untuk mengelola berita dan informasi",
    "author": "SimPeDe Development Team",
    "author_url": "https://simpede.id",
    "required_version": "1.0.0",
    "database": {
        "migrations": "Database/Migrations",
        "seeders": "Database/Seeders"
    }
}
```

## Instalasi dan Konfigurasi

1. Plugin akan otomatis terdeteksi oleh sistem plugin stelloCMS
2. Jalankan migrasi untuk membuat tabel `berita`: `php artisan migrate`
3. Plugin siap digunakan

## Panduan Penggunaan

### Untuk Admin
1. Akses `/panel/berita` untuk mengelola berita
2. Gunakan tombol "Tambah Berita" untuk membuat berita baru
3. Gunakan tombol edit/hapus untuk mengelola berita yang sudah ada
4. Gunakan checkbox "Aktifkan Berita" untuk mengatur status publikasi

### Untuk Pengunjung
1. Akses `/berita` untuk melihat daftar berita publik
2. Klik judul berita untuk melihat detail berita

## Panduan Pengembang

### Model Berita
```php
use App\Plugins\Berita\Models\Berita;

$berita = Berita::where('aktif', true)->get();
$berita = Berita::find($id);
$berita = Berita::create($data);
```

### Route dalam View
#### Admin View
```php
// Dalam view admin
route('panel.berita.index')     // Daftar berita
route('panel.berita.create')    // Tambah berita
route('panel.berita.edit', $id) // Edit berita
```

#### Frontend View
```php
// Dalam view frontend
route('berita.index')     // Daftar berita publik
route('berita.show', $id) // Detail berita publik
```

## Integrasi dengan Sistem

### Menu Otomatis
- Plugin akan menambahkan menu otomatis ke sistem menu admin
- Nama menu: "Berita"
- Route: `panel.berita.index`
- Icon: `fas fa-newspaper`

### Hak Akses
- Menu tersedia untuk role: admin, operator
- Akses route dilindungi dengan middleware `auth`

## Troubleshooting

### Error Route Tidak Ditemukan
- Pastikan plugin aktif di halaman manajemen plugin
- Jalankan `php artisan route:clear` untuk membersihkan cache route

### Error View Tidak Ditemukan
- Pastikan namespace plugin benar (`berita::`)
- Jalankan `php artisan view:clear` untuk membersihkan cache view

### Gambar Tidak Muncul
- Pastikan folder `storage/app/public` bisa diakses
- Pastikan symlink sudah dibuat: `php artisan storage:link`