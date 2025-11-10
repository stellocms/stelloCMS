# Panduan Pengembang Plugin Berita

## Struktur Plugin

Plugin Berita mengikuti standar plugin stelloCMS:

```
app/Plugins/Berita/
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

## Model Berita

### Struktur Model
```php
namespace App\Plugins\Berita\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'tanggal_publikasi',
        'aktif',
        'user_id'
    ];

    protected $table = 'berita';

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'aktif' => 'boolean'
    ];
}
```

### Relasi
```php
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
```

## Controller Berita

### Method Public
- `index()` - Menampilkan daftar berita admin
- `create()` - Form tambah berita
- `store(Request $request)` - Simpan berita baru
- `show($id)` - Tampilkan detail berita (membedakan admin/publik)
- `edit($id)` - Form edit berita
- `update(Request $request, $id)` - Update berita
- `destroy($id)` - Hapus berita
- `publicIndex()` - Daftar berita publik
- `publicShow($id)` - Detail berita publik

## View dan Template

### Namespace View
- Admin: `berita::index`, `berita::create`, dll.
- Frontend: `berita::frontend.index`, `berita::frontend.show`

### Layout
- Admin: `theme.admin.{theme}::layouts.app`
- Frontend: `theme.frontend.{theme}::layouts.app`

## Route Security

### Admin Route Security
```php
Route::prefix('panel/berita')->middleware(['auth'])->group(function () {
    // Route admin di sini
});
```

### Public Route Security
```php
Route::prefix('berita')->group(function () {
    // Route publik di sini
});
```

## Upload File

### Penyimpanan Gambar
- Lokasi: `storage/app/public/berita/`
- Format: jpeg, png, jpg, gif
- Maksimum ukuran: 2048KB (2MB)
- Penamaan: Auto-generated dengan timestamp

### Validasi Gambar
```php
'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
```

## Error Handling

### Pendekatan Aman untuk Route
Plugin Berita menggunakan pendekatan aman terhadap route yang tidak ditemukan:

```php
$redirectUrl = in_array('panel.berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
    route('panel.berita.index') : url('/panel/berita');
return redirect($redirectUrl)->with('success', 'Berita berhasil ditambahkan.');
```

### Error Handling di View
```php
<a href="{{ in_array('berita.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.show', $item->id) : url('/berita/' . $item->id) }}">
    Baca Selengkapnya
</a>
```

## SEO dan Metadata

### Meta Description
- Gunakan `Str::limit(strip_tags($item->isi), 160)` untuk membuat deskripsi SEO
- Tersedia di section `@section('description')`

### Title
- Dinamis berdasarkan konten berita
- Format: `{judul_berita} - {judul_situs}`

## Custom Helper

### View Helper
- Admin: `view('berita::index', $data)`
- Frontend: `view('berita::frontend.index', $data)`

### Route Helper
Gunakan pendekatan aman:
```php
in_array('route.name', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
    route('route.name') : url('/fallback-url')
```

## Migration

### Membuat Tabel Berita
```php
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
```

## Testing

### Unit Test
Saat menulis test untuk plugin ini, pastikan untuk:
- Menguji validasi input
- Menguji manajemen file upload
- Menguji relasi model
- Menguji route admin dan publik

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

### Performance
- Gunakan pagination untuk daftar berita
- Optimalkan query database
- Gunakan eager loading untuk relasi

### Code Style
- Ikuti standar Laravel
- Gunakan type hinting
- Gunakan konstanta untuk nilai yang sering digunakan
- Gunakan exception handling yang tepat