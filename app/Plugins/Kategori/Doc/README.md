# Dokumentasi Plugin Kategori

## Deskripsi
Plugin Kategori adalah modul tambahan untuk sistem stelloCMS yang memungkinkan pengguna untuk mengelola kategori berita. Plugin ini menyediakan kemampuan untuk membuat, mengedit, menghapus, dan menetapkan kategori ke berita di sistem Berita.

## Versi
- 1.0.0

## Fitur Utama

### 1. Manajemen Kategori Lengkap
- **Create (Tambah)**: Membuat kategori baru dengan nama, deskripsi, warna, ikon, dan status aktif
- **Read (Lihat)**: Menampilkan daftar kategori dalam format tabel
- **Update (Edit)**: Mengedit kategori yang sudah ada
- **Delete (Hapus)**: Menghapus kategori dari sistem (dengan verifikasi tidak digunakan di berita)

### 2. Fitur Kategori
- Nama kategori (wajib)
- Deskripsi kategori (opsional)
- Warna kustomisasi (opsional)
- Ikon Font Awesome (opsional)
- Status aktif/non-aktif

### 3. Integrasi dengan Plugin Berita
- Menambahkan dropdown kategori di form tambah/edit berita (jika plugin Kategori terinstal)
- Kategori tidak wajib diisi di form berita
- Jika plugin Kategori tidak terinstal, field kategori tidak muncul di form berita

### 4. Antarmuka Administrasi
- Dashboard untuk pengelolaan kategori
- Form yang mudah digunakan untuk tambah/edit kategori
- Tabel yang responsif untuk menampilkan daftar kategori

## Struktur Plugin

### Struktur Direktori
```
app/Plugins/Kategori/
├── Controllers/
│   └── KategoriController.php
├── Models/
│   └── Kategori.php
├── Views/
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── index.blade.php
│   └── show.blade.php (opsional)
├── Doc/
│   └── README.md
├── helpers.php
├── install.php
├── plugin.json
└── routes.php
```

## Model dan Database

### Tabel `kategori_berita`

| Kolom | Tipe Data | Deskripsi | Contoh |
|-------|-----------|-----------|---------|
| id | BIGINT (unsigned auto-increment) | Primary key | 1, 2, 3 |
| nama_kategori | VARCHAR(255) | Nama kategori | "Teknologi", "Politik", "Olahraga" |
| deskripsi | TEXT (nullable) | Deskripsi kategori | "Berita terbaru tentang teknologi..." |
| warna | VARCHAR(10) | Kode warna hex untuk tampilan UI | "#007bff", "#28a745" |
| ikon | VARCHAR(50) | Nama ikon Font Awesome | "fas fa-laptop", "fas fa-vote-yea" |
| aktif | BOOLEAN | Status kategori (aktif/tidak) | 1 (aktif), 0 (non-aktif) |
| created_at | TIMESTAMP | Tanggal pembuatan | 2025-01-01 00:00:00 |
| updated_at | TIMESTAMP | Tanggal pembaruan | 2025-01-01 00:00:00 |

## Routing

### Rute Admin
- `GET /panel/kategori` → `KategoriController@index` (nama route: `panel.kategori.index`)
- `GET /panel/kategori/create` → `KategoriController@create` (nama route: `panel.kategori.create`)
- `POST /panel/kategori` → `KategoriController@store` (nama route: `panel.kategori.store`)
- `GET /panel/kategori/{id}` → `KategoriController@show` (nama route: `panel.kategori.show`)
- `GET /panel/kategori/{id}/edit` → `KategoriController@edit` (nama route: `panel.kategori.edit`)
- `PUT /panel/kategori/{id}` → `KategoriController@update` (nama route: `panel.kategori.update`)
- `DELETE /panel/kategori/{id}` → `KategoriController@destroy` (nama route: `panel.kategori.destroy`)
- `GET /panel/kategori/api/active` → `KategoriController@getActiveCategories` (nama route: `panel.kategori.api.active`)

## Integrasi dengan Plugin Berita

### Tampilan Form Berita
Jika plugin Kategori terinstal, maka form berita akan menampilkan:

#### Tambah/Edit Berita
```html
<div class="form-group">
    <label for="kategori_id">Kategori (opsional)</label>
    <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
        <option value="">-- Pilih Kategori --</option>
        <!-- Daftar kategori aktif -->
    </select>
    @error('kategori_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

## Helper Functions

### helpers.php
```php
// Mendapatkan semua kategori aktif
$kategoris = get_kategori();

// Mendapatkan semua kategori (aktif dan non-aktif)
$all_kategori = get_kategori_all();

// Mendapatkan kategori berdasarkan ID
$kategori = get_kategori_by_id(1);
```

## Instalasi dan Penghapusan

### install.php
```php
// Install script otomatis membuat tabel kategori_berita
// Jika tabel sudah ada, skrip akan memperbarui struktur
KategoriInstaller::install();
```

### uninstall.php (tergabung dalam install.php)
```php
// Uninstall script menghapus tabel kategori_berita
KategoriInstaller::uninstall();
```

## Troubleshooting

### Kategori Tidak Muncul di Dropdown Berita
- Pastikan plugin Kategori terinstal dengan benar
- Jalankan `php artisan migrate` jika tabel belum dibuat
- Periksa file `helpers.php` bisa diakses
- Pastikan function `get_kategori()` dapat dipanggil

### Error saat Instalasi
- Pastikan struktur direktori plugin benar
- Pastikan file `install.php` memiliki izin yang benar
- Periksa log error untuk informasi lebih lanjut

### Kategori Tidak Bisa Dihapus
- Pastikan kategori tidak sedang digunakan oleh berita
- Periksa relasi foreign key di database

### Cache Issue
- Jalankan `php artisan view:clear` untuk membersihkan cache view
- Jalankan `php artisan route:clear` untuk membersihkan cache route
- Jalankan `php artisan config:clear` untuk membersihkan cache konfigurasi

## Best Practices

### Penamaan Kategori
- Gunakan nama yang deskriptif dan unik
- Gunakan huruf kapital di awal kata
- Jangan gunakan karakter spesial yang tidak diperlukan

### Penggunaan Warna
- Gunakan warna yang kontras dan mudah dibaca
- Pastikan warna konsisten dengan tema situs
- Gunakan warna untuk membantu identifikasi kategori

### Fitur Kategori
- Gunakan status aktif/non-aktif untuk mengontrol visibilitas
- Gunakan deskripsi untuk memberikan informasi tambahan
- Gunakan ikon untuk visualisasi yang lebih baik

### Integrasi dengan Berita
- Pastikan kategori yang tidak digunakan bisa dihapus
- Tampilkan hanya kategori aktif di dropdown
- Tidak wajib mengisi kategori untuk berita

## Konfigurasi Plugin

### plugin.json
```json
{
    "name": "Kategori",
    "version": "1.0.0",
    "description": "Plugin untuk mengelola kategori berita",
    "author": "stelloCMS Development Team",
    "author_url": "https://stellocms.com",
    "required_version": "1.0.0",
    "install_script": "install.php",
    "helpers": "helpers.php"
}
```

## Changelog

### 1.0.0
- Release pertama plugin Kategori
- Fungsi CRUD kategori lengkap
- Integrasi dengan plugin Berita
- Antarmuka administrasi yang responsif