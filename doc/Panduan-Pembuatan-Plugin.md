# Panduan Pembuatan Plugin untuk stelloCMS

## Daftar Isi
1. [Pengenalan Plugin](#pengenalan-plugin)
2. [Struktur Plugin](#struktur-plugin)
3. [Langkah-langkah Membuat Plugin](#langkah-langkah-membuat-plugin)
4. [File Konfigurasi Plugin](#file-konfigurasi-plugin)
5. [Route dan Controller Plugin](#route-dan-controller-plugin)
6. [Model dan Database Plugin](#model-dan-database-plugin)
7. [View Plugin](#view-plugin)
8. [Pengujian Plugin](#pengujian-plugin)
9. [Instalasi Plugin](#instalasi-plugin)
10. [Troubleshooting dan Best Practices](#troubleshooting-dan-best-practices)

## Pengenalan Plugin

Plugin dalam stelloCMS adalah modul tambahan yang dapat ditempatkan untuk memperluas fungsionalitas sistem. Plugin memungkinkan pengembangan fitur tambahan tanpa harus memodifikasi core sistem, sehingga memudahkan pemeliharaan dan pengembangan sistem secara berkelanjutan.

### Keunggulan Plugin
- **Modularitas**: Plugin dapat diinstal, diaktifkan, dinonaktifkan, dan dihapus secara independen
- **Integrasi Otomatis**: Plugin otomatis terintegrasi dengan sistem menu dan sistem hak akses
- **Skalabilitas**: Memungkinkan pengembangan fitur tambahan tanpa mengganggu sistem utama

### Jenis-jenis Plugin
- Plugin berbasis data (mengelola informasi seperti berita, kategori, produk)
- Plugin utilitas (menyediakan fungsi tambahan)
- Plugin antarmuka (menambahkan elemen UI)

## Struktur Plugin

Setiap plugin harus mengikuti struktur direktori standar berikut:

```
app/Plugins/{PluginName}/
├── Controllers/
│   └── {PluginName}Controller.php
├── Models/
│   └── {ModelName}.php (opsional)
├── Views/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── Database/ (opsional)
│   ├── Migrations/
│   └── Seeders/
├── helpers.php (opsional)
├── install.php (opsional)
├── plugin.json
└── routes.php
```

### Aturan Penamaan Plugin
- Gunakan format **PascalCase** (huruf kapital di awal setiap kata tanpa spasi atau underscore)
- Contoh benar: `Berita`, `ContohPlugin`, `PengumumanDesa`, `ManajemenKeuangan`
- Contoh salah: `berita`, `contoh_plugin`, `pengumuman-desa`, `Manajemen keuangan`
- Hanya boleh huruf (A-Z, a-z) dan angka (0-9)
- Tidak boleh mengandung spasi, underscore, atau karakter khusus lainnya

## Langkah-langkah Membuat Plugin

### 1. Membuat Struktur Plugin

1. Buat folder plugin di `app/Plugins/{PluginName}` (gunakan format PascalCase)
2. Buat subfolder sesuai struktur yang disebutkan di atas
3. Masukkan file-file konfigurasi dan logika plugin ke dalam folder masing-masing

### 2. Membuat File Konfigurasi Plugin

Buat file `plugin.json` yang berisi metadata plugin:

```json
{
    "name": "NamaPlugin",
    "version": "1.0.0",
    "description": "Deskripsi plugin",
    "author": "Nama Pembuat",
    "author_url": "https://website.com",
    "required_version": "1.0.0",
    "install_script": "install.php",
    "helpers": "helpers.php"
}
```

### 3. Membuat Route Plugin

Buat file `routes.php` untuk mendefinisikan route plugin:

```php
<?php

use App\Plugins\NamaPlugin\Controllers\NamaPluginController;
use Illuminate\Support\Facades\Route;

// Gunakan prefix panel dan middleware auth
Route::prefix('panel/namaplugin')->middleware(['auth'])->group(function () {
    Route::get('/', [NamaPluginController::class, 'index'])->name('panel.namaplugin.index');
    Route::get('/create', [NamaPluginController::class, 'create'])->name('panel.namaplugin.create');
    Route::post('/', [NamaPluginController::class, 'store'])->name('panel.namaplugin.store');
    Route::get('/{id}', [NamaPluginController::class, 'show'])->name('panel.namaplugin.show');
    Route::get('/{id}/edit', [NamaPluginController::class, 'edit'])->name('panel.namaplugin.edit');
    Route::put('/{id}', [NamaPluginController::class, 'update'])->name('panel.namaplugin.update');
    Route::delete('/{id}', [NamaPluginController::class, 'destroy'])->name('panel.namaplugin.destroy');
});
```

### 4. Menambahkan Route ke Sistem Utama (Langkah Kritis)

**Langkah ini wajib dilakukan** untuk mencegah redirect ke home page. Tambahkan route plugin ke file `routes/panel.php`:

```php
// NamaPlugin routes - added manually to ensure they work without relying on route caching
Route::prefix('panel/namaplugin')->group(function () {
    Route::get('/', [\App\Plugins\NamaPlugin\Controllers\NamaPluginController::class, 'index'])->name('panel.namaplugin.index');
    Route::get('/create', [\App\Plugins\NamaPlugin\Controllers\NamaPluginController::class, 'create'])->name('panel.namaplugin.create');
    Route::post('/', [\App\Plugins\NamaPlugin\Controllers\NamaPluginController::class, 'store'])->name('panel.namaplugin.store');
    Route::get('/{id}/edit', [\App\Plugins\NamaPlugin\Controllers\NamaPluginController::class, 'edit'])->name('panel.namaplugin.edit');
    Route::put('/{id}', [\App\Plugins\NamaPlugin\Controllers\NamaPluginController::class, 'update'])->name('panel.namaplugin.update');
    Route::delete('/{id}', [\App\Plugins\NamaPlugin\Controllers\NamaPluginController::class, 'destroy'])->name('panel.namaplugin.destroy');
    Route::get('/{id}', [\App\Plugins\NamaPlugin\Controllers\NamaPluginController::class, 'show'])->name('panel.namaplugin.show');
});
```

### 5. Membuat Controller Plugin

```php
<?php

namespace App\Plugins\NamaPlugin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NamaPluginController extends Controller
{
    public function index()
    {
        // Implementasi logika ambil data
        return view('namaplugin::index');
    }

    public function create()
    {
        return view('namaplugin::create');
    }

    public function store(Request $request)
    {
        // Implementasi logika simpan data
        return redirect()->route('panel.namaplugin.index');
    }

    public function show($id)
    {
        // Implementasi logika tampilkan detail
        return view('namaplugin::show', compact('item'));
    }

    public function edit($id)
    {
        // Implementasi logika ambil data untuk edit
        return view('namaplugin::edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        // Implementasi logika update data
        return redirect()->route('panel.namaplugin.index');
    }

    public function destroy($id)
    {
        // Implementasi logika hapus data
        return redirect()->route('panel.namaplugin.index');
    }
}
```

## File Konfigurasi Plugin

### plugin.json
File ini berisi metadata plugin:

```json
{
    "name": "NamaPlugin",          // Nama plugin dalam format PascalCase
    "version": "1.0.0",            // Versi plugin
    "description": "Deskripsi plugin", // Deskripsi singkat
    "author": "Nama Pembuat",      // Nama pembuat plugin
    "author_url": "https://website.com", // URL website pembuat
    "required_version": "1.0.0",   // Versi minimum stelloCMS yang diperlukan
    "install_script": "install.php", // Path script instalasi (opsional)
    "helpers": "helpers.php"       // Path file helper (opsional)
}
```

### install.php (Opsional)
File ini digunakan untuk membuat struktur database dan migrasi:

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class NamaPluginInstaller
{
    public static function install()
    {
        if (!Schema::hasTable('namatable')) {
            Schema::create('namatable', function (Blueprint $table) {
                $table->id();
                $table->string('kolom1');
                $table->text('kolom2')->nullable();
                $table->timestamps();
            });
        }
    }

    public static function uninstall()
    {
        if (Schema::hasTable('namatable')) {
            Schema::dropIfExists('namatable');
        }
    }
}
```

## Route dan Controller Plugin

### Route
- Gunakan prefix `panel/{nama_plugin}` untuk endpoint admin
- Gunakan middleware `['auth']` untuk proteksi akses
- Beri nama route dengan format `panel.{nama_plugin}.{action}`

### Controller
- Extends dari `App\Http\Controllers\Controller`
- Gunakan namespace `App\Plugins\{PluginName}\Controllers`
- Gunakan view dengan format `{nama_plugin}::`

## Model dan Database Plugin

### Model
```php
<?php

namespace App\Plugins\NamaPlugin\Models;

use Illuminate\Database\Eloquent\Model;

class NamaModel extends Model
{
    protected $fillable = [
        'kolom1',
        'kolom2',
        // daftar kolom yang bisa diisi
    ];

    protected $table = 'namatable'; // Nama tabel database
}
```

### Migrasi Database
Gunakan migrasi standar Laravel dalam folder `Database/Migrations/`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('namatable', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('namatable');
    }
};
```

## View Plugin

### Struktur View
Gunakan namespace plugin dalam view: `{plugin_name}::`

Contoh struktur view index:
```blade
@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Nama Plugin - ' . cms_name())
@section('page_title', 'Nama Plugin')

@section('content')
<div class="container-fluid">
    <!-- Konten plugin -->
</div>
@endsection
```

### Helper View dalam Plugin
Jika perlu, buat file `helpers.php` untuk helper khusus plugin:

```php
<?php

if (!function_exists('helper_plugin_nama')) {
    function helper_plugin_nama()
    {
        // Logika helper
    }
}
```

## Pengujian Plugin

### Sebelum Deploy
1. Pastikan plugin dapat diinstal dan diaktifkan
2. Uji semua endpoint yang tersedia
3. Verifikasi integrasi dengan sistem menu
4. Cek akses berdasarkan role

### Setelah Deploy
1. Akses plugin di `/panel/{nama_plugin}`
2. Coba semua fungsi CRUD
3. Periksa log error di `storage/logs/laravel.log` jika ada masalah

## Instalasi Plugin

### Manual
1. Tempatkan plugin dalam folder `app/Plugins/{PluginName}`
2. Tambahkan route ke `routes/panel.php`
3. Clear cache: `php artisan route:clear && php artisan config:clear`
4. Install plugin melalui antarmuka `/panel/plugins`

### Melalui Antarmuka
1. Akses `/panel/plugins`
2. Upload file ZIP plugin (jika disediakan)
3. Klik install
4. Aktifkan plugin

## Troubleshooting dan Best Practices

### Masalah Umum dan Solusi

#### 1. Plugin Redirect ke Home Page
**Penyebab**: Route plugin tidak ditambahkan ke `routes/panel.php`
**Solusi**: Pastikan route ditambahkan secara eksplisit ke `routes/panel.php`

#### 2. View Tidak Ditemukan
**Penyebab**: Namespace view salah atau file view tidak ditemukan
**Solusi**: Pastikan namespace `{plugin_name}::` digunakan dengan benar

#### 3. Akses Ditolak (403)
**Penyebab**: Role tidak memiliki izin atau menu tidak dibuat
**Solusi**: Pastikan plugin telah diinstal dan menu dibuat secara otomatis

#### 4. Error saat Load Plugin
**Penyebab**: Syntax error atau dependency tidak ditemukan
**Solusi**: Cek log error dan pastikan struktur plugin benar

### Best Practices

#### Struktur Plugin
- Gunakan struktur direktori yang konsisten
- Pisahkan logika antara model, view, dan controller
- Gunakan namespace yang benar

#### Security
- Validasi semua input user
- Gunakan authorization di setiap endpoint
- Sanitasi output untuk mencegah XSS

#### Performance
- Gunakan pagination untuk data besar
- Gunakan caching untuk data yang jarang berubah
- Gunakan eager loading untuk relasi

#### Maintainability
- Gunakan konstanta untuk nilai-nilai konfigurasi
- Tambahkan komentar yang menjelaskan fungsi penting
- Gunakan exception handling yang baik

#### Testing
- Uji plugin dalam berbagai skenario
- Uji integrasi dengan sistem menu
- Uji akses berdasarkan role

### Panduan Kontribusi Plugin

Jika ingin berkontribusi plugin ke sistem stelloCMS:

1. Ikuti standar struktur plugin
2. Tambahkan dokumentasi
3. Sertakan test jika memungkinkan
4. Pastikan plugin kompatibel dengan berbagai role pengguna
5. Gunakan fitur sistem (seperti menu otomatis) secara maksimal