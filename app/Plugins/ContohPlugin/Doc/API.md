# API dan Route Plugin ContohPlugin

## Route Admin

### Daftar Item
- **Method**: GET
- **URL**: `/panel/contohplugin`
- **Route Name**: `panel.contohplugin.index`
- **Controller Method**: `ContohPluginController@index`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan daftar semua item

### Tambah Item
- **Method**: GET
- **URL**: `/panel/contohplugin/create`
- **Route Name**: `panel.contohplugin.create`
- **Controller Method**: `ContohPluginController@create`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan form untuk membuat item baru

### Simpan Item Baru
- **Method**: POST
- **URL**: `/panel/contohplugin`
- **Route Name**: `panel.contohplugin.store`
- **Controller Method**: `ContohPluginController@store`
- **Middleware**: `auth`
- **Deskripsi**: Menyimpan item baru ke database

### Detail Item
- **Method**: GET
- **URL**: `/panel/contohplugin/{id}`
- **Route Name**: `panel.contohplugin.show`
- **Controller Method**: `ContohPluginController@show`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan detail item spesifik

### Edit Item
- **Method**: GET
- **URL**: `/panel/contohplugin/{id}/edit`
- **Route Name**: `panel.contohplugin.edit`
- **Controller Method**: `ContohPluginController@edit`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan form untuk mengedit item

### Perbarui Item
- **Method**: PUT/PATCH
- **URL**: `/panel/contohplugin/{id}`
- **Route Name**: `panel.contohplugin.update`
- **Controller Method**: `ContohPluginController@update`
- **Middleware**: `auth`
- **Deskripsi**: Memperbarui data item

### Hapus Item
- **Method**: DELETE
- **URL**: `/panel/contohplugin/{id}`
- **Route Name**: `panel.contohplugin.destroy`
- **Controller Method**: `ContohPluginController@destroy`
- **Middleware**: `auth`
- **Deskripsi**: Menghapus item dari database

## Route Publik

### Daftar Item Publik
- **Method**: GET
- **URL**: `/contohplugin`
- **Route Name**: `contohplugin.frontpage.index`
- **Controller Method**: `ContohPluginController@frontpageIndex`
- **Middleware**: Tidak ada (publik)
- **Deskripsi**: Menampilkan daftar item untuk publik

### Detail Item Publik
- **Method**: GET
- **URL**: `/contohplugin/{slug}`
- **Route Name**: `contohplugin.frontpage.show`
- **Controller Method**: `ContohPluginController@frontpageShow`
- **Middleware**: Tidak ada (publik)
- **Deskripsi**: Menampilkan detail item untuk publik

## API Response Format

### Success Response
```json
{
    "success": true,
    "message": "Contoh Plugin berhasil ditambahkan.",
    "data": {
        // Data item
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Terjadi kesalahan.",
    "errors": {
        // Detail error validasi
    }
}
```

## Parameter Request

### Tambah/Edit Item
- `judul` (string, required) - Judul item
- `deskripsi` (text, required) - Deskripsi/konten item
- `gambar` (file, optional) - Gambar item (jpeg, png, jpg, gif; max 2MB)
- `aktif` (boolean, optional) - Status publikasi (default: true)

## Validasi

- `judul`: Wajib, maksimal 255 karakter
- `deskripsi`: Wajib
- `gambar`: Opsional, format gambar valid, maksimal 2048KB
- `aktif`: Harus berupa boolean

## Model Relationships

### ContohPlugin Model
```php
// Relasi yang mungkin diterapkan
public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}
```

## Slug Generation

### Pembuatan Slug Otomatis
Plugin ini menggunakan helper `generate_slug` untuk membuat slug URL-friendly dari judul:
```php
$slug = generate_slug($request->judul);
```

## File Upload

### Penyimpanan Gambar
- Lokasi: `storage/app/public/contoh_plugins/`
- Format: jpeg, png, jpg, gif
- Maksimum ukuran: 2048KB (2MB)
- Penamaan: Auto-generated dengan timestamp

### Validasi Gambar
```php
'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

## Security Notes

### Input Validation
Semua form menggunakan validasi yang ketat:
- Validasi tipe data
- Batas karakter
- Format file upload
- CSRF protection

### Route Protection
- Route admin dilindungi dengan middleware `auth`
- Tidak ada perlindungan khusus untuk route publik
- Validasi parameter ID/slug di controller

## Response Handling

### Redirect Setelah CRUD
- Setelah create: redirect ke daftar item
- Setelah update: redirect ke daftar item
- Setelah delete: redirect ke daftar item
- Dengan pesan sukses/error yang sesuai