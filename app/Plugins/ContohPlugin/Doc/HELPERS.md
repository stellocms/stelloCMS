# Helper Functions di stelloCMS

## Gambaran Umum

stelloCMS menyediakan beberapa helper functions yang dapat digunakan oleh plugin untuk mendukung fungsionalitas sistem. Helper ini mencakup berbagai kebutuhan seperti pembuatan slug, informasi CMS, dan rendering view dengan tema.

## Helper yang Tersedia

### 1. generate_slug()

Helper untuk membuat slug URL-friendly dari string:

```php
/**
 * Generate a URL-friendly slug from a string
 * @param string $string String to convert to slug
 * @param string $separator Separator to use (default: '-')
 * @return string Slugified string
 */
function generate_slug($string, $separator = '-')
```

#### Contoh Penggunaan:
```php
$judul = "Contoh Plugin Terbaru Laravel 11";
$slug = generate_slug($judul); // hasil: "contoh-plugin-terbaru-laravel-11"

$judul = "Plugin dengan Karakter Spesial!";
$slug = generate_slug($judul); // hasil: "plugin-dengan-karakter-spesial"
```

#### Fitur:
- Mengonversi ke huruf kecil
- Mengganti karakter non-alphanumeric dengan separator
- Menghapus karakter separator ganda
- Menghapus separator di awal dan akhir string
- Menangani string kosong

### 2. cms_name()

Mendapatkan nama CMS dari konfigurasi:

```php
/**
 * Get the CMS name from configuration
 * @return string CMS name
 */
function cms_name()
```

#### Contoh Penggunaan:
```php
$cmsName = cms_name(); // hasil: "stelloCMS"
```

### 3. cms_description()

Mendapatkan deskripsi CMS dari konfigurasi:

```php
/**
 * Get the CMS description from configuration
 * @return string CMS description
 */
function cms_description()
```

#### Contoh Penggunaan:
```php
$description = cms_description(); // hasil: "Limitless Online Content Management"
```

### 4. view_theme()

Merender view dengan dukungan tema:

```php
/**
 * Render a view with theme support
 * @param string $type Type of theme (admin or frontend)
 * @param string $view View name
 * @param array $data Data to pass to view
 * @return mixed Rendered view
 */
function view_theme($type, $view, $data = [])
```

#### Contoh Penggunaan:
```php
// Render view untuk tema admin
return view_theme('admin', 'dashboard.index', $data);

// Render view untuk tema frontend
return view_theme('frontend', 'home.index', $data);
```

#### Parameter:
- `$type`: Jenis tema ('admin' atau 'frontend')
- `$view`: Nama view (tanpa ekstensi)
- `$data`: Array data untuk dikirim ke view

## Implementasi Sistem Slug

Helper `generate_slug()` sangat berguna dalam pembuatan plugin yang memerlukan URL-friendly slugs. Berikut implementasi tipikal dalam model:

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
    
    protected $table = 'nama_plugins';
    
    /**
     * Generate slug before saving
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

## Penggunaan di Controller

Di controller plugin, helper ini dapat digunakan saat membuat atau memperbarui data:

```php
public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string|unique:nama_plugins,judul',
        'deskripsi' => 'required',
        'aktif' => 'boolean'
    ]);
    
    // Data akan secara otomatis mengenerate slug melalui model hook
    $item = NamaPlugin::create($request->all());
    
    return redirect()->route('namaplugin.index')->with('success', 'Data berhasil disimpan.');
}

public function frontpageShow($slug)
{
    $item = NamaPlugin::where('aktif', true)->bySlug($slug)->firstOrFail();
    
    return view('namaplugin::frontpage.show', compact('item'));
}
```

## Penggunaan di Route

Untuk route frontend, gunakan slug sebagai parameter:

```php
Route::get('/namaplugin/{slug}', [NamaPluginController::class, 'frontpageShow'])
    ->name('namaplugin.frontpage.show');
```

## Best Practices

### 1. Konsistensi Slug
Pastikan slug tetap konsisten meskipun judul diubah:
- Gunakan logika `isDirty('judul')` untuk mendeteksi perubahan
- Hanya regenerasi slug jika judul berubah

### 2. Keunikan Slug
- Pastikan slug unik dalam satu tabel
- Tambahkan angka increment jika slug sudah digunakan

### 3. SEO-Friendly
- Gunakan karakter alfanumerik dan tanda hubung
- Hindari karakter khusus dan spasi
- Buat slug deskriptif dan relevan

## Kesimpulan

Helper functions di stelloCMS:
- Mempermudah pengembangan plugin
- Mendukung fungsionalitas penting seperti slug generation
- Mengikuti standar Laravel
- Meningkatkan konsistensi antar plugin

Dengan helper `generate_slug()`, plugin dapat dengan mudah membuat URL-friendly slugs yang mendukung SEO dan pengalaman pengguna yang baik.