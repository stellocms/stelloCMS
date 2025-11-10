# Panduan Pengembang Plugin ContohPlugin

## Struktur Plugin

Plugin ContohPlugin mengikuti standar plugin stelloCMS:

```
app/Plugins/ContohPlugin/
├── Controllers/
├── Models/
├── Views/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Doc/
├── plugin.json
└── routes.php
```

## Model ContohPlugin

### Struktur Model
```php
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
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = generate_slug($model->judul);
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('judul') && empty($model->slug)) {
                $model->slug = generate_slug($model->judul);
            }
        });
    }
}
```

### Relasi
```php
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
```

## Controller ContohPlugin

### Method Public
- `index()` - Menampilkan daftar item admin
- `create()` - Form tambah item
- `store(Request $request)` - Simpan item baru
- `show($id)` - Tampilkan detail item (admin)
- `edit($id)` - Form edit item
- `update(Request $request, $id)` - Update item
- `destroy($id)` - Hapus item
- `frontpageIndex()` - Daftar item publik
- `frontpageShow($slug)` - Detail item publik

## View dan Template

### Namespace View
- Admin: `contohplugin::index`, `contohplugin::create`, dll.
- Frontend: `contohplugin::frontpage.index`, `contohplugin::frontpage.show`

### Layout
- Admin: `theme.admin.{theme}::layouts.app`
- Frontend: `theme.frontend.{theme}::layouts.app`

## Route Security

### Admin Route Security
```php
Route::prefix('panel/contohplugin')->middleware(['auth'])->group(function () {
    // Route admin di sini
});
```

### Public Route Security
```php
Route::prefix('contohplugin')->group(function () {
    // Route publik di sini
});
```

## Upload File

### Penyimpanan Gambar
- Lokasi: `storage/app/public/contoh_plugins/`
- Format: jpeg, png, jpg, gif
- Maksimum ukuran: 2048KB (2MB)
- Penamaan: Auto-generated dengan timestamp

### Validasi Gambar
```php
'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
```

## Slug Generation

### Pembuatan Slug Otomatis
Plugin ini menggunakan helper `generate_slug`:
```php
$slug = generate_slug($judul);
```

Helper ini biasanya didefinisikan dalam file helpers.php:
```php
if (!function_exists('generate_slug')) {
    function generate_slug($string, $separator = '-')
    {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9-_.]+/', $separator, $string);
        return $string;
    }
}
```

## Error Handling

### Pendekatan Aman untuk Route
Plugin ContohPlugin menggunakan pendekatan aman terhadap route yang tidak ditemukan:

```php
$redirectUrl = in_array('panel.contohplugin.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
    route('panel.contohplugin.index') : url('/panel/contohplugin');
return redirect($redirectUrl)->with('success', 'Contoh Plugin berhasil ditambahkan.');
```

### Error Handling di View
```php
<a href="{{ in_array('contohplugin.frontpage.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('contohplugin.frontpage.show', $item->slug) : url('/contohplugin/' . $item->slug) }}">
    Lihat Detail
</a>
```

## SEO dan Metadata

### Meta Description
- Gunakan `Str::limit(strip_tags($item->deskripsi), 160)` untuk membuat deskripsi SEO
- Tersedia di section `@section('description')`

### Title
- Dinamis berdasarkan konten item
- Format: `{judul_item} - Contoh Plugin - {judul_situs}`

## Custom Helper

### View Helper
- Admin: `view('contohplugin::index', $data)`
- Frontend: `view('contohplugin::frontpage.index', $data)`

### Route Helper
Gunakan pendekatan aman:
```php
in_array('route.name', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
    route('route.name') : url('/fallback-url')
```

## Migration

### Membuat Tabel ContohPlugin
```php
Schema::create('contoh_plugins', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->text('deskripsi');
    $table->string('gambar')->nullable();
    $table->timestamp('tanggal_dibuat')->nullable();
    $table->boolean('aktif')->default(true);
    $table->string('slug')->unique();
    $table->timestamps();
});
```

## Testing

### Unit Test
Saat menulis test untuk plugin ini, pastikan untuk:
- Menguji validasi input
- Menguji manajemen file upload
- Menguji relasi model
- Menguji route admin dan publik
- Menguji pembuatan slug otomatis

### Integration Test
- Menguji workflow CRUD
- Menguji akses admin vs publik
- Menguji tampilan view

## Best Practices

### Security
- Selalu lakukan validasi input
- Gunakan form request untuk validasi kompleks
- Gunakan CSRF token pada form
- Sanitasi output HTML sebelum ditampilkan
- Pastikan route admin dilindungi dengan middleware auth

### Performance
- Gunakan pagination untuk daftar item
- Optimalkan query database
- Gunakan eager loading untuk relasi
- Gunakan cache jika sesuai

### Code Style
- Ikuti standar Laravel
- Gunakan type hinting
- Gunakan konstanta untuk nilai yang sering digunakan
- Gunakan exception handling yang tepat
- Gunakan helper function untuk operasi yang berulang

### Plugin Development Guidelines
- Gunakan namespace plugin yang konsisten
- Ikuti struktur direktori standar
- Gunakan route names yang deskriptif
- Pastikan plugin dapat dinonaktifkan tanpa mempengaruhi sistem utama
- Gunakan helper untuk operasi umum

### View Development
- Gunakan layout tema yang konsisten
- Gunakan pendekatan aman untuk route dalam view
- Gunakan helper untuk format tampilan data
- Gunakan class CSS yang konsisten

Dengan mengikuti panduan ini, plugin ContohPlugin menjadi contoh implementasi yang baik untuk pengembangan plugin lain dalam sistem stelloCMS.