# Dokumentasi Plugin Kategori untuk stelloCMS

## Gambaran Umum

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
- Warna kustomisasi (opsional, default: #007bff)
- Ikon Font Awesome (opsional, default: fas fa-tag)
- Status aktif/non-aktif

### 3. Integrasi dengan Plugin Berita
- Menambahkan dropdown kategori di form tambah/edit berita (jika plugin Kategori terinstal)
- Kategori tidak wajib diisi di form berita
- Jika plugin Kategori tidak terinstal, field kategori tidak muncul di form berita

### 4. Antarmuka Administrasi
- Dashboard untuk pengelolaan kategori
- Form yang mudah digunakan untuk tambah/edit kategori
- Tabel yang responsif untuk menampilkan daftar kategori
- Tampilan warna langsung di daftar kategori

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

## File Konfigurasi Plugin

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

### Model Kategori
```php
<?php

namespace App\Plugins\Kategori\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'warna',
        'ikon',
        'aktif'
    ];

    protected $table = 'kategori_berita';

    protected $casts = [
        'aktif' => 'boolean'
    ];

    /**
     * Scope untuk kategori aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Relasi ke berita
     */
    public function berita()
    {
        return $this->hasMany(\App\Plugins\Berita\Models\Berita::class, 'kategori_id');
    }
}
```

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

### routes.php
```php
<?php

use App\Plugins\Kategori\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

// Rute untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/kategori')->middleware(['auth'])->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('panel.kategori.index');
    Route::get('/create', [KategoriController::class, 'create'])->name('panel.kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('panel.kategori.store');
    Route::get('/{id}', [KategoriController::class, 'show'])->name('panel.kategori.show');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('panel.kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('panel.kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('panel.kategori.destroy');

    // API untuk mendapatkan kategori aktif
    Route::get('/api/active', [KategoriController::class, 'getActiveCategories'])->name('panel.kategori.api.active');
});
```

## Controller Plugin

### KategoriController
```php
<?php

namespace App\Plugins\Kategori\Controllers;

use App\Plugins\Kategori\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('created_at', 'desc')->paginate(10);

        return view('kategori::index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:10',
            'ikon' => 'nullable|string|max:50',
            'aktif' => 'nullable|boolean'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'warna' => $request->warna ?? '#007bff',
            'ikon' => $request->ikon ?? 'fas fa-tag',
            'aktif' => $request->has('aktif')
        ]);

        return redirect()->route('panel.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori::show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori::edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:10',
            'ikon' => 'nullable|string|max:50',
            'aktif' => 'nullable|boolean'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'warna' => $request->warna ?? '#007bff',
            'ikon' => $request->ikon ?? 'fas fa-tag',
            'aktif' => $request->has('aktif')
        ]);

        return redirect()->route('panel.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih digunakan oleh berita
        $beritaCount = $kategori->berita()->count();
        if ($beritaCount > 0) {
            return redirect()->route('panel.kategori.index')->with('error', 'Kategori masih digunakan oleh ' . $beritaCount . ' berita, tidak dapat dihapus.');
        }

        $kategori->delete();

        return redirect()->route('panel.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function getActiveCategories()
    {
        $categories = Kategori::aktif()->orderBy('nama_kategori')->get(['id', 'nama_kategori']);
        return response()->json($categories);
    }
}
```

## View Plugin

### index.blade.php
```blade
@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Daftar Kategori - ' . cms_name())
@section('page_title', 'Daftar Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kategori Berita</h3>
                    <div class="card-tools">
                        <a href="{{ route('panel.kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Warna</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>{{ Str::limit(strip_tags($item->deskripsi), 50) }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $item->warna }};">{{ $item->warna }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-warning' }}">
                                        {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('panel.kategori.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ route('panel.kategori.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('panel.kategori.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada kategori ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $kategori->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
```

### create.blade.php
```blade
@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Tambah Kategori - ' . cms_name())
@section('page_title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kategori Baru</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ route('panel.kategori.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi (opsional)</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="warna">Warna (opsional)</label>
                            <input type="color" class="form-control @error('warna') is-invalid @enderror" id="warna" name="warna" value="{{ old('warna', '#007bff') }}">
                            @error('warna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ikon">Ikon Font Awesome (opsional)</label>
                            <input type="text" class="form-control @error('ikon') is-invalid @enderror" id="ikon" name="ikon" value="{{ old('ikon', 'fas fa-tag') }}" placeholder="e.g. fas fa-tag, far fa-bookmark, etc.">
                            @error('ikon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}>
                                <label for="aktif">Aktifkan Kategori</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('panel.kategori.index') }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
```

## Integrasi dengan Plugin Berita

### Tampilan Form Berita
Jika plugin Kategori terinstal, maka form berita akan menampilkan field kategori opsional:

```html
<div class="form-group">
    <label for="kategori_id">Kategori (opsional)</label>
    <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
        <option value="">-- Pilih Kategori --</option>
        @foreach(get_kategori_all() as $kategori)
            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>
    @error('kategori_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

### Model Berita - Relasi Kategori
```php
/**
 * Relasi ke kategori berita (jika plugin kategori terinstal)
 */
public function kategori()
{
    if (class_exists(\App\Plugins\Kategori\Models\Kategori::class)) {
        return $this->belongsTo(\App\Plugins\Kategori\Models\Kategori::class, 'kategori_id');
    }

    // Jika plugin kategori tidak terinstal, kembalikan relasi kosong
    return $this->belongsTo(\Illuminate\Database\Eloquent\Model::class, 'dummy');
}
```

## Helper Functions

### helpers.php
```php
<?php

use App\Plugins\Kategori\Models\Kategori;

if (!function_exists('get_kategori')) {
    /**
     * Mendapatkan semua kategori aktif
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_kategori()
    {
        if (class_exists(App\Plugins\Kategori\Models\Kategori::class)) {
            return Kategori::aktif()->orderBy('nama_kategori')->get();
        }

        return collect([]);
    }
}

if (!function_exists('get_kategori_all')) {
    /**
     * Mendapatkan semua kategori (aktif dan non-aktif)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_kategori_all()
    {
        if (class_exists(App\Plugins\Kategori\Models\Kategori::class)) {
            return Kategori::orderBy('nama_kategori')->get();
        }

        return collect([]);
    }
}

if (!function_exists('get_kategori_by_id')) {
    /**
     * Mendapatkan kategori berdasarkan ID
     *
     * @param int $id ID kategori
     * @return \App\Plugins\Kategori\Models\Kategori|null
     */
    function get_kategori_by_id($id)
    {
        if (class_exists(App\Plugins\Kategori\Models\Kategori::class)) {
            return Kategori::aktif()->find($id);
        }

        return null;
    }
}
```

## Instalasi Plugin

### Install Script (install.php)
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Instalasi dan pembaruan tabel kategori_berita untuk plugin Kategori
 * File ini digunakan untuk membuat atau memperbarui struktur tabel kategori_berita
 * ketika plugin Kategori diinstal atau diperbarui
 */
class KategoriInstaller
{
    /**
     * Membuat atau memperbarui tabel kategori_berita
     */
    public static function install()
    {
        if (!Schema::hasTable('kategori_berita')) {
            // Buat tabel kategori_berita baru
            Schema::create('kategori_berita', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kategori');
                $table->text('deskripsi')->nullable();
                $table->string('warna')->default('#007bff');  // warna hex untuk tampilan UI
                $table->string('ikon')->default('fas fa-tag');  // ikon font awesome
                $table->boolean('aktif')->default(true);
                $table->timestamps();
            });
        } else {
            // Lakukan pembaruan struktur tabel jika sudah ada
            static::updateTableStructure();
        }
    }

    /**
     * Memperbarui struktur tabel kategori_berita jika sudah ada
     */
    private static function updateTableStructure()
    {
        $columns = [
            'nama_kategori' => 'string',
            'deskripsi' => 'text',
            'warna' => 'string',
            'ikon' => 'string',
            'aktif' => 'boolean'
        ];

        foreach ($columns as $columnName => $columnType) {
            if (!Schema::hasColumn('kategori_berita', $columnName)) {
                Schema::table('kategori_berita', function (Blueprint $table) use ($columnName, $columnType) {
                    switch ($columnType) {
                        case 'string':
                            if ($columnName == 'aktif') {
                                $table->string($columnName)->default('#007bff');
                            } elseif ($columnName == 'ikon') {
                                $table->string($columnName)->default('fas fa-tag');
                            } else {
                                $table->string($columnName);
                            }
                            break;
                        case 'text':
                            $table->text($columnName)->nullable();
                            break;
                        case 'boolean':
                            $table->boolean($columnName)->default(true);
                            break;
                    }
                });
            }
        }

        // Pastikan kolom warna dan ikon memiliki default values jika belum ada
        if (Schema::hasColumn('kategori_berita', 'warna') &&
            !Schema::hasColumn('kategori_berita', 'warna_default_set')) {
            try {
                DB::statement("ALTER TABLE kategori_berita ALTER COLUMN warna SET DEFAULT '#007bff'");
            } catch (\Exception $e) {
                // Jika terjadi error, abaikan karena mungkin sudah memiliki default
            }
        }

        if (Schema::hasColumn('kategori_berita', 'ikon') &&
            !Schema::hasColumn('kategori_berita', 'ikon_default_set')) {
            try {
                DB::statement("ALTER TABLE kategori_berita ALTER COLUMN ikon SET DEFAULT 'fas fa-tag'");
            } catch (\Exception $e) {
                // Jika terjadi error, abaikan karena mungkin sudah memiliki default
            }
        }
    }

    /**
     * Menghapus tabel kategori_berita (untuk uninstall)
     */
    public static function uninstall()
    {
        if (Schema::hasTable('kategori_berita')) {
            Schema::dropIfExists('kategori_berita');
        }
    }
}

// Panggil metode install saat file ini di-include
KategoriInstaller::install();
```

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

## Troubleshooting

### Kategori Tidak Muncul di Dropdown Berita
- Pastikan plugin Kategori terinstal dengan benar
- Jalankan `php artisan config:clear` dan `php artisan route:clear`
- Periksa file `helpers.php` bisa diakses
- Pastikan function `get_kategori()` dapat dipanggil

### Error saat Instalasi
- Pastikan struktur direktori plugin benar
- Pastikan file `install.php` memiliki izin yang benar
- Periksa log error untuk informasi lebih lanjut

### Kategori Tidak Bisa Dihapus
- Pastikan kategori tidak sedang digunakan oleh berita
- Periksa relasi foreign key di database
- Lihat pesan error yang ditampilkan di halaman

### Cache Issue
- Jalankan `php artisan view:clear` untuk membersihkan cache view
- Jalankan `php artisan route:clear` untuk membersihkan cache route
- Jalankan `php artisan config:clear` untuk membersihkan cache konfigurasi

## Keamanan
- Validasi semua input user
- Gunakan CSRF token untuk setiap form
- Batasi akses hanya untuk pengguna terotentikasi
- Sanitasi input deskripsi untuk mencegah XSS

## Performance
- Gunakan hanya kategori aktif untuk dropdown
- Gunakan eager loading untuk relasi
- Gunakan caching jika diperlukan untuk daftar kategori

## Contoh Implementasi
Plugin Kategori berfungsi sebagai contoh implementasi plugin yang baik dalam sistem stelloCMS dengan:

1. Struktur plugin yang lengkap
2. Integrasi dengan plugin lain (Berita)
3. Sistem manajemen data yang lengkap
4. Tampilan antarmuka yang user-friendly
5. Validasi dan error handling yang baik