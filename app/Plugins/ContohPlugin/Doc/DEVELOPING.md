# Panduan Pengembangan Plugin untuk stelloCMS

## Persiapan Awal

Sebelum membuat plugin baru untuk stelloCMS, pastikan Anda memiliki:
- Pengetahuan dasar tentang Laravel Framework 11
- Struktur direktori plugin yang benar
- Pemahaman tentang arsitektur MVC
- Pengetahuan tentang Blade templating
- Pemahaman tentang sistem tema dan plugin stelloCMS

## Struktur Plugin Standar

Setiap plugin di stelloCMS harus mengikuti struktur standar:

```
app/Plugins/{NamaPlugin}/
├── Controllers/
│   └── {NamaPlugin}Controller.php
├── Models/
│   └── {ModelName}.php
├── Views/
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── index.blade.php
│   ├── show.blade.php
│   └── frontpage/
│       ├── index.blade.php
│       └── show.blade.php
├── Database/Migrations/ (opsional)
├── routes.php
├── plugin.json
└── Doc/
    ├── README.md
    ├── DEVELOPING.md
    ├── HELPERS.md
    └── INSTALLATION.md
```

## Langkah-langkah Membuat Plugin Baru

### 1. Membuat Struktur Direktori

Buat direktori plugin dalam `app/Plugins/`:

```bash
mkdir -p app/Plugins/NamaPlugin/{Controllers,Models,Views,Views/frontpage,Database/Migrations,Doc}
```

### 2. Membuat File Konfigurasi (plugin.json)

Buat file `plugin.json` untuk metadata plugin:

```json
{
    "name": "NamaPlugin",
    "version": "1.0.0",
    "description": "Deskripsi plugin",
    "author": "Nama Pengembang",
    "author_url": "https://stellocms.com",
    "required_version": "1.0.0",
    "database": {
        "migrations": "Database/Migrations",
        "seeders": "Database/Seeders"
    }
}
```

### 3. Membuat Model

Buat model plugin di `Models/`. Contoh struktur untuk sistem slug otomatis:

```php
<?php

namespace App\Plugins\NamaPlugin\Models;

use Illuminate\Database\Eloquent\Model;

class NamaPlugin extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tanggal_dibuat',
        'aktif',
        'slug'
    ];
    
    protected $table = 'nama_plugins'; // Gunakan jamak
    
    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'aktif' => 'boolean'
    ];
    
    /**
     * Generate a unique slug before saving
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('judul')) {
                $model->slug = $model->generateUniqueSlug();
            }
        });
    }
    
    /**
     * Generate a unique slug based on the title
     */
    private function generateUniqueSlug()
    {
        $slug = generate_slug($this->judul);
        $originalSlug = $slug;
        $counter = 1;
        
        // If this is an update, exclude current record from the check
        $query = static::where('slug', $slug);
        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }
        
        while ($query->first()) {
            $slug = $originalSlug . '-' . $counter;
            $query = static::where('slug', $slug);
            
            if ($this->exists) {
                $query->where('id', '!=', $this->id);
            }
            
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Scope to find by slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
```

### 4. Membuat Controller

Buat controller di `Controllers/`:

```php
<?php

namespace App\Plugins\NamaPlugin\Controllers;

use App\Plugins\NamaPlugin\Models\NamaPlugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class NamaPluginController extends Controller
{
    public function index()
    {
        try {
            $items = NamaPlugin::where('aktif', true)->orderBy('tanggal_dibuat', 'desc')->paginate(10);
            
            return view('namaplugin::index', compact('items'));
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@index: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function create()
    {
        try {
            return view('namaplugin::create');
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@create: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255|unique:nama_plugins,judul',
                'deskripsi' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'aktif' => 'boolean'
            ]);
            
            $data = $request->all();
            
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('namaplugin', 'public');
                $data['gambar'] = $gambarPath;
            }
            
            NamaPlugin::create($data);
            
            return redirect()->route('namaplugin.index')->with('success', 'Item berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@store: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    
    public function show($id)
    {
        try {
            $item = NamaPlugin::findOrFail($id);
            
            return view('namaplugin::show', compact('item'));
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@show: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function edit($id)
    {
        try {
            $item = NamaPlugin::findOrFail($id);
            
            return view('namaplugin::edit', compact('item'));
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@edit: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255|unique:nama_plugins,judul,' . $id,
                'deskripsi' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'aktif' => 'boolean'
            ]);
            
            $item = NamaPlugin::findOrFail($id);
            $data = $request->all();
            
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($item->gambar && file_exists(storage_path('app/public/' . $item->gambar))) {
                    unlink(storage_path('app/public/' . $item->gambar));
                }
                
                $gambarPath = $request->file('gambar')->store('namaplugin', 'public');
                $data['gambar'] = $gambarPath;
            }
            
            $item->update($data);
            
            return redirect()->route('namaplugin.index')->with('success', 'Item berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@update: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $item = NamaPlugin::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($item->gambar && file_exists(storage_path('app/public/' . $item->gambar))) {
                unlink(storage_path('app/public/' . $item->gambar));
            }
            
            $item->delete();
            
            return redirect()->route('namaplugin.index')->with('success', 'Item berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@destroy: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Frontend methods
     */
    
    public function frontpageIndex()
    {
        try {
            $items = NamaPlugin::where('aktif', true)
                ->orderBy('tanggal_dibuat', 'desc')
                ->paginate(9);
            
            return view('namaplugin::frontpage.index', compact('items'));
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@frontpageIndex: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function frontpageShow($slug)
    {
        try {
            $item = NamaPlugin::where('aktif', true)->bySlug($slug)->firstOrFail();
            
            return view('namaplugin::frontpage.show', compact('item'));
        } catch (\Exception $e) {
            Log::error('Error in NamaPluginController@frontpageShow: ' . $e->getMessage());
            throw $e;
        }
    }
}
```

### 5. Membuat Routes

Buat file `routes.php`:

```php
<?php

use App\Plugins\NamaPlugin\Controllers\NamaPluginController;
use Illuminate\Support\Facades\Route;

// Routes untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/namaplugin')->middleware(['auth'])->group(function () {
    Route::get('/', [NamaPluginController::class, 'index'])->name('namaplugin.index');
    Route::get('/create', [NamaPluginController::class, 'create'])->name('namaplugin.create');
    Route::post('/', [NamaPluginController::class, 'store'])->name('namaplugin.store');
    Route::get('/{id}/edit', [NamaPluginController::class, 'edit'])->name('namaplugin.edit');
    Route::put('/{id}', [NamaPluginController::class, 'update'])->name('namaplugin.update');
    Route::delete('/{id}', [NamaPluginController::class, 'destroy'])->name('namaplugin.destroy');
    Route::get('/{id}', [NamaPluginController::class, 'show'])->name('namaplugin.show');
});

// Routes untuk frontend publik
Route::prefix('namaplugin')->group(function () {
    Route::get('/', [NamaPluginController::class, 'frontpageIndex'])->name('namaplugin.frontpage.index');
    Route::get('/{slug}', [NamaPluginController::class, 'frontpageShow'])->name('namaplugin.frontpage.show');
});
```

### 6. Membuat Views

Contoh `Views/index.blade.php`:

```blade
@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Manajemen Nama Plugin - ' . cms_name())
@section('page_title', 'Manajemen Nama Plugin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Item Nama Plugin</h3>
                    <div class="card-tools">
                        <a href="{{ route('namaplugin.create') }}" class="btn btn-primary">Tambah Item</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                    @endif
                    
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Deskripsi Singkat</th>
                                <th>Tanggal Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{!! Str::limit(strip_tags($item->deskripsi), 100) !!}</td>
                                <td>{{ $item->tanggal_dibuat ? $item->tanggal_dibuat->format('d M Y') : '-' }}</td>
                                <td>
                                    <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-warning' }}">
                                        {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('namaplugin.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ route('namaplugin.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('namaplugin.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada item ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $items->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
```

## Best Practices

### 1. Namespace
Gunakan namespace yang konsisten:
```
App\Plugins\{NamaPlugin}\Controllers\{NamaPlugin}Controller
App\Plugins\{NamaPlugin}\Models\{ModelName}
```

### 2. View Namespaces
Plugin view namespace otomatis terdaftar sebagai `{lowercase_nama_plugin}::`. Contoh: `contohplugin::index`

### 3. Nama Route
Gunakan pola: `{plugin_name}.{action}` atau `{plugin_name}.frontpage.{action}`

### 4. Database
- Gunakan nama tabel jamak (misalnya: `nama_plugins`)
- Gunakan timestamps (created_at, updated_at)
- Gunakan tipe data yang sesuai

### 5. Validasi
Selalu tambahkan validasi pada form input:
```php
$request->validate([
    'judul' => 'required|string|max:255|unique:nama_plugins,judul',
    'deskripsi' => 'required',
    'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
]);
```

### 6. Error Handling
Gunakan try-catch dan logging:
```php
try {
    // kode
} catch (\Exception $e) {
    Log::error('Deskripsi error: ' . $e->getMessage());
    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
}
```

### 7. Security
- Gunakan validation untuk semua input
- Gunakan authorization untuk mencegah akses ilegal
- Sanitasi output saat menampilkan data

### 8. SEO
- Gunakan metatags untuk setiap halaman
- Gunakan slug untuk URL yang SEO-friendly
- Gunakan title dan description yang bermanfaat

## Integrasi Sistem

### Plugin Management
- Plugin harus bisa diinstal dan diaktifkan melalui sistem plugin
- Tabel harus dibuat saat plugin diinstal
- Menu harus otomatis muncul di sidebar

### Hak Akses
- Menu plugin akan mengikuti hak akses role yang telah ditentukan
- Gunakan sistem role untuk mengatur akses

## Testing Plugin

### Manual Testing
1. Instal plugin melalui panel
2. Uji semua fitur CRUD
3. Periksa tampilan frontend dan backend
4. Uji validasi input
5. Pastikan slug di-generate dengan benar

### Debugging
Gunakan logging untuk melacak error:
```php
Log::info('Debug message', ['data' => $variable]);
Log::error('Error message', ['error' => $exception]);
```

## Deployment dan Instalasi

### Instalasi Plugin
1. Salin folder plugin ke `app/Plugins/{NamaPlugin}/`
2. Gunakan panel administrasi untuk menginstal plugin
3. Verifikasi bahwa plugin berfungsi dengan benar

### Update Plugin
1. Backup data dan file sebelum update
2. Ganti file plugin dengan versi baru
3. Jalankan migrasi jika ada perubahan database

## Troubleshooting

### Plugin Tidak Muncul
- Periksa struktur direktori
- Pastikan plugin.json valid
- Verifikasi nama plugin sesuai dengan nama folder

### Route Tidak Bekerja
- Pastikan route didaftarkan dengan benar
- Clear route cache: `php artisan route:clear`

### View Tidak Ditemukan
- Pastikan namespace view benar
- Pastikan PluginServiceProvider aktif
- Clear view cache: `php artisan view:clear`

## Kesimpulan

Dengan mengikuti panduan ini, Anda dapat membuat plugin yang:
- Konsisten dengan arsitektur stelloCMS
- Mudah dipelihara dan dikembangkan
- Mengikuti praktik terbaik Laravel
- Dapat diintegrasikan dengan sistem tema dan plugin
- Aman dan sesuai dengan standar keamanan web