# Helper Functions Plugin Contoh

## Gambaran Umum

Plugin Contoh menggunakan beberapa helper functions yang disediakan oleh sistem stelloCMS untuk mendukung fungsionalitas plugin.

## Helper yang Tersedia

### 1. generate_slug()

Helper untuk membuat slug URL-friendly dari string:

```php
/**
 * Generate a URL-friendly slug from a string
 */
function generate_slug($string, $separator = '-')
```

#### Parameter:
- `$string`: String yang akan diubah menjadi slug
- `$separator`: Karakter pemisah (default: '-')

#### Contoh Penggunaan:
```php
$judul = "Contoh Plugin Terbaik";
$slug = generate_slug($judul); // hasil: "contoh-plugin-terbaik"

$judul = "Plugin dengan Spesial Karakter!";
$slug = generate_slug($judul); // hasil: "plugin-dengan-spesial-karakter"
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
 */
function cms_name()
```

### 3. cms_description()

Mendapatkan deskripsi CMS dari konfigurasi:

```php
/**
 * Get the CMS description from configuration
 */
 */
function cms_description()
```

### 4. view_theme()

Merender view dengan dukungan tema:

```php
/**
 * Render a view with theme support
 */
function view_theme($type, $view, $data = [])
```

#### Parameter:
- `$type`: Jenis tema ('admin' atau 'frontend')
- `$view`: Nama view
- `$data`: Data untuk dikirim ke view

## Implementasi Slug di Model

Model plugin secara otomatis mengenerate slug dari judul saat menyimpan data:

```php
protected static function boot()
{
    parent::boot();
    
    static::saving(function ($model) {
        if (empty($model->slug) || $model->isDirty('judul')) {
            $model->slug = $model->generateUniqueSlug();
        }
    });
}
```

### Mekanisme Generate Slug:
1. Menggunakan helper `generate_slug()` untuk membuat slug dasar
2. Memastikan slug unik dengan menambahkan angka jika diperlukan
3. Menyimpan slug ke dalam database
4. Menggunakan scope `bySlug()` untuk pencarian berdasarkan slug

## Validasi dan Keunikan Slug

Sistem menjamin keunikan slug dengan:
- Mengecek slug yang sudah ada sebelum menyimpan
- Menambahkan angka increment jika slug sudah digunakan
- Meregenerasi slug saat judul diubah

## Contoh Implementasi Lengkap

Berikut contoh implementasi lengkap dari sistem slug dalam model:

```php
<?php

namespace App\Plugins\ContohPlugin\Models;

use Illuminate\Database\Eloquent\Model;

class ContohPlugin extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tanggal_dibuat',
        'aktif',
        'slug'
    ];
    
    protected $table = 'contoh_plugins';
    
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

## Penggunaan di Controller

Di controller, method untuk menampilkan data berdasarkan slug:

```php
public function frontpageShow($slug)
{
    $item = ContohPlugin::where('aktif', true)->bySlug($slug)->firstOrFail();
    return view('contohplugin::frontpage.show', compact('item'));
}
```

## Integrasi dengan Route

Route menggunakan parameter slug:

```php
Route::get('/{slug}', [ContohPluginController::class, 'frontpageShow'])
    ->name('contohplugin.frontpage.show');
```

## Best Practices

### 1. Konsistensi Nama
Pastikan slug tetap konsisten meskipun judul diubah:
- Gunakan logika `isDirty('judul')` untuk mendeteksi perubahan
- Hanya regenerasi slug jika judul berubah

### 2. Performa
- Gunakan indeks database pada kolom slug untuk performa pencarian
- Gunakan scope untuk query berdasarkan slug

### 3. SEO
- Pastikan slug SEO-friendly
- Gunakan karakter alfanumerik dan tanda hubung
- Hindari karakter khusus dan spasi

## Kesimpulan

Sistem slug yang diimplementasikan dalam plugin Contoh:
- Otomatis menggenerate slug dari judul
- Menjamin keunikan slug
- Dapat digunakan untuk URL-friendly
- Dapat dicari dengan cepat
- Mendukung SEO yang baik

## Panduan Pengembangan Plugin

Untuk panduan lengkap tentang cara membuat dan mengembangkan plugin seperti ContohPlugin, lihat dokumentasi di [DEVELOPING.md](DEVELOPING.md).