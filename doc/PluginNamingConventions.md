# Aturan Penamaan Plugin untuk Pengembang

## Pendahuluan

Dokumen ini menjelaskan aturan dan konvensi penamaan plugin untuk sistem stelloCMS. Mengikuti aturan ini penting untuk memastikan plugin bekerja dengan baik, terutama dalam konteks sistem install.php otomatis dan PluginManager.

## Aturan Dasar Penamaan Plugin

### 1. Format Penamaan
- Gunakan format `PascalCase` (huruf kapital di awal setiap kata tanpa spasi atau underscore)
- Contoh benar: `Berita`, `ContohPlugin`, `PengumumanDesa`, `ManajemenKeuangan`
- Contoh salah: `berita`, `contoh_plugin`, `pengumuman-desa`, `Manajemen keuangan`

### 2. Karakter yang Diizinkan
- Hanya huruf (A-Z, a-z) dan angka (0-9)
- Tidak diperbolehkan spasi, underscore, atau karakter khusus lainnya
- Tidak diperbolehkan karakter non-ASCII (seperti huruf dengan aksen)

### 3. Panjang Nama Plugin
- Rekomendasi: 2-50 karakter
- Maksimum: 100 karakter
- Nama terlalu pendek dapat membingungkan (misalnya: `A`, `B`)
- Nama terlalu panjang sulit dikelola

## Konsekuensi dari Aturan Penamaan

### 1. Kaitan dengan Install.php
- PluginManager mencari kelas `{NamaPlugin}Installer` secara otomatis
- Jika folder plugin bernama `PengumumanDesa`, maka kelas installer harus bernama `PengumumanDesaInstaller`

### 2. Namespace PHP
- Nama plugin menjadi bagian dari namespace PHP
- Contoh: plugin bernama `Berita` akan memiliki namespace `App\Plugins\Berita\Controllers\BeritaController`

### 3. Route dan View
- Nama plugin digunakan untuk route dan namespace view
- Contoh: plugin bernama `Pengumuman` akan menggunakan route `pengumuman.index` dan view namespace `pengumuman::`

## Struktur Plugin yang Disarankan

```
app/Plugins/{NamaPlugin}/
├── Controllers/
│   └── {NamaPlugin}Controller.php
├── Models/
│   └── {ModelName}.php
├── Views/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Doc/
├── plugin.json
├── routes.php
└── install.php (opsional)
```

## Contoh Nama Plugin yang Valid

### Contoh Nama Plugin yang Benar:
- `Berita`
- `PengumumanDesa`
- `ManajemenKeuangan`
- `ArsipSurat`
- `DataPenduduk`
- `GaleriFoto`

### Contoh Nama Plugin yang Salah:
- `berita_desa` (menggunakan underscore)
- `pengumuman-desa` (menggunakan dash)
- `Manajemen Keuangan` (mengandung spasi)
- `123Berita` (dimulai dengan angka, walaupun teknis diperbolehkan tidak disarankan)
- `Contoh@Plugin` (mengandung karakter khusus)

## Panduan Praktis

### 1. Menentukan Nama Plugin
1. Pilih nama yang deskriptif dan mencerminkan fungsi plugin
2. Gunakan format PascalCase
3. Pastikan nama unik dan tidak bentrok dengan plugin lain
4. Hindari nama yang terlalu umum seperti `Umum`, `Dasar`, `Utama`

### 2. Implementasi Install.php
Jika plugin Anda membutuhkan struktur database, buat file `install.php` dengan kelas:
```php
class {NamaPlugin}Installer
{
    public static function install() { /* ... */ }
    public static function uninstall() { /* ... */ }
}
```

Contoh: Plugin bernama `PengumumanDesa` memerlukan file `install.php` dengan kelas `PengumumanDesaInstaller`.

### 3. File plugin.json
Pastikan file plugin.json mencerminkan nama plugin:
```json
{
    "name": "PengumumanDesa",
    "version": "1.0.0",
    "description": "Plugin untuk mengelola pengumuman desa",
    "install_script": "install.php"
}
```

## Konvensi Tambahan

### 1. Nama Tabel Database
- Gunakan format `snake_case` dan jamak
- Contoh: Plugin `Berita` menggunakan tabel `berita`
- Contoh: Plugin `PengumumanDesa` menggunakan tabel `pengumuman_desa` atau `pengumuman` (tergantung kompleksitas)

### 2. Prefix Route
- Route admin: `panel.{nama_plugin_kecil}.{action}`
- Route publik: `{nama_plugin_kecil}.{action}`

### 3. Namespace View
- `view('{nama_plugin_kecil}::{view_name}', $data)`

## Contoh Lengkap

Contoh plugin bernama `ManajemenKegiatan`:

1. Folder: `app/Plugins/ManajemenKegiatan/`
2. Installer: `ManajemenKegiatanInstaller` di file `install.php`
3. Controller: `ManajemenKegiatanController` di `Controllers/`
4. Model: `Kegiatan.php` di `Models/`
5. Route: `panel.manajemenkegiatan.index`
6. View: `manajemenkegiatan::index`

## Kesimpulan

Mengikuti aturan penamaan plugin ini penting untuk:
- Kompatibilitas dengan sistem otomatis PluginManager
- Konsistensi dalam seluruh sistem
- Kemudahan pemeliharaan dan pengembangan
- Mencegah konflik dan error sistem

## Kesalahan Umum

1. Menggunakan format penamaan yang tidak benar
2. Mengganti nama folder plugin tanpa memperbarui referensi di kelas
3. Lupa mengikuti konvensi penamaan kelas installer
4. Menggunakan karakter khusus yang tidak diizinkan