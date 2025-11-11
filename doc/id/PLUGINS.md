# Dokumentasi Sistem Plugin stelloCMS

## Gambaran Umum

Sistem plugin stelloCMS memungkinkan ekstensi fungsionalitas sistem melalui plugin yang modular dan dapat dikelola secara dinamis. Plugin dapat diinstal, diaktifkan, dan dihapus melalui panel administrasi.

## Struktur Plugin

### Struktur Dasar Plugin
```
/app/Plugins/{nama_plugin}/
├── Controllers/
│   └── {NamaPlugin}Controller.php
├── Models/
│   └── {NamaModel}.php
├── Views/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── routes.php
├── plugin.json
├── install.php (opsional - untuk mengelola struktur database secara dinamis)
├── helpers.php (opsional)
└── README.md (opsional)
```

**Catatan:** Folder `Database/` dengan migrasi tradisional tidak lagi diperlukan jika menggunakan file `install.php` untuk mengelola struktur database secara dinamis.

## File Konfigurasi Plugin

### plugin.json
File `plugin.json` berisi informasi metadata tentang plugin:
```json
{
    "name": "Nama Plugin",
    "version": "1.0.0",
    "description": "Deskripsi plugin",
    "author": "Nama Pembuat",
    "author_url": "https://website.com",
    "required_version": "1.0.0",
    "database": {
        "migrations": "Database/Migrations",
        "seeders": "Database/Seeders"
    }
}
```

## Pembuatan Plugin Baru

### Penamaan Plugin
Penting untuk mengikuti aturan penamaan plugin:
- Gunakan format `PascalCase` (huruf kapital di awal setiap kata tanpa spasi atau underscore)
- Contoh benar: `Berita`, `ContohPlugin`, `PengumumanDesa`
- Contoh salah: `berita`, `contoh_plugin`, `pengumuman-desa`, `Manajemen keuangan`

Catatan khusus: PluginManager mencari kelas `{NamaPlugin}Installer` secara otomatis berdasarkan nama folder plugin. Jika folder plugin bernama `PengumumanDesa`, maka kelas installer harus bernama `PengumumanDesaInstaller`.

### Langkah-langkah Membuat Plugin
1. Buat folder plugin di `/app/Plugins/` dengan nama mengikuti aturan penamaan
2. Tambahkan file `plugin.json` dengan informasi plugin
3. Buat controller, model, dan view yang diperlukan
4. Tambahkan file `routes.php` untuk routing plugin
5. Tambahkan file `install.php` (opsional) untuk mengelola struktur database secara dinamis (menggantikan folder Database/)
6. Plugin akan terdeteksi secara otomatis

**Catatan:** Gunakan file `install.php` dengan kelas `{NamaPlugin}Installer` untuk mengelola struktur database secara dinamis, menggantikan kebutuhan akan folder `Database/` dengan migrasi tradisional.

### Contoh plugin.json
```json
{
    "name": "Berita",
    "version": "1.0.0",
    "description": "Plugin untuk mengelola berita dan informasi",
    "author": "stelloCMS Development Team",
    "author_url": "https://stellocms.com",
    "required_version": "1.0.0"
}
```

### Contoh Controller Plugin
```php
<?php

namespace App\Plugins\Berita\Controllers;

use App\Plugins\Berita\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('aktif', true)->orderBy('tanggal_publikasi', 'desc')->paginate(10);
        
        return view('berita::index', compact('berita'));
    }
    
    // Method-method lain...
}
```

### Contoh Model Plugin
```php
<?php

namespace App\Plugins\Berita\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'tanggal_publikasi',
        'aktif'
    ];
    
    protected $table = 'berita';
    
    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'aktif' => 'boolean'
    ];
}
```

### Contoh routes.php
```php
<?php

use App\Plugins\Berita\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

// Rute untuk admin panel
Route::prefix('panel/berita')->middleware(['auth'])->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/{id}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
});
```

## Migrasi Database Plugin

### Contoh File Migrasi
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->timestamp('tanggal_publikasi')->useCurrent();
            $table->boolean('aktif')->default(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
```

## Instalasi dan Pengelolaan Plugin

### Menginstal Plugin
1. Pastikan plugin berada di folder `/app/Plugins/`
2. Akses panel administrasi
3. Buka menu "Plugin"
4. Klik tombol "Instal" pada plugin yang diinginkan
5. Plugin akan diinstal dan diaktifkan secara otomatis

### Mengaktifkan Plugin
1. Akses panel administrasi
2. Buka menu "Plugin"
3. Klik tombol "Aktifkan" pada plugin yang diinginkan
4. Plugin akan diaktifkan

### Menonaktifkan Plugin
1. Akses panel administrasi
2. Buka menu "Plugin"
3. Klik tombol "Nonaktifkan" pada plugin yang diinginkan
4. Plugin akan dinonaktifkan

### Menghapus Plugin
1. Akses panel administrasi
2. Buka menu "Plugin"
3. Klik tombol "Hapus" pada plugin yang diinginkan
4. Plugin akan dihapus dari sistem

## Best Practices

### Penamaan Plugin
- Gunakan nama yang deskriptif dan unik
- Hindari karakter spesial
- Gunakan format CamelCase untuk nama folder
- Gunakan huruf kecil dengan pemisah underscore untuk nama file

### Namespace
- Gunakan namespace yang sesuai: `App\Plugins\{NamaPlugin}\...`
- Pastikan namespace sesuai dengan struktur folder

### Routing
- Gunakan prefix yang unik untuk setiap plugin
- Gunakan middleware auth untuk rute admin
- Gunakan penamaan route yang konsisten

### Database
- Gunakan nama tabel yang unik dan deskriptif
- Tambahkan foreign key constraint jika diperlukan
- Gunakan timestamp created_at dan updated_at

### View
- Gunakan namespace view yang sesuai
- Ikuti struktur view yang konsisten
- Gunakan helper Blade untuk rendering yang efisien

## Troubleshooting

### Plugin Tidak Terdeteksi
- Pastikan struktur folder sudah benar
- Periksa file `plugin.json` ada dan formatnya benar
- Bersihkan cache konfigurasi dengan `php artisan config:clear`

### Error Database
- Pastikan migrasi sudah dijalankan dengan benar
- Periksa struktur tabel dan constraint
- Gunakan `php artisan migrate:fresh` jika diperlukan

### Error Routing
- Pastikan file `routes.php` ada dan formatnya benar
- Periksa penamaan route dan controller
- Bersihkan cache route dengan `php artisan route:clear`

### Error View
- Pastikan namespace view sudah benar
- Periksa path view dalam plugin
- Bersihkan cache view dengan `php artisan view:clear`
