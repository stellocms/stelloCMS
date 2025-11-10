# API dan Route Plugin Berita

## Route Admin

### Daftar Berita
- **Method**: GET
- **URL**: `/panel/berita`
- **Route Name**: `panel.berita.index`
- **Controller Method**: `BeritaController@index`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan daftar semua berita

### Tambah Berita
- **Method**: GET
- **URL**: `/panel/berita/create`
- **Route Name**: `panel.berita.create`
- **Controller Method**: `BeritaController@create`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan form untuk membuat berita baru

### Simpan Berita Baru
- **Method**: POST
- **URL**: `/panel/berita`
- **Route Name**: `panel.berita.store`
- **Controller Method**: `BeritaController@store`
- **Middleware**: `auth`
- **Deskripsi**: Menyimpan berita baru ke database

### Detail Berita
- **Method**: GET
- **URL**: `/panel/berita/{id}`
- **Route Name**: `panel.berita.show`
- **Controller Method**: `BeritaController@show`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan detail berita spesifik

### Edit Berita
- **Method**: GET
- **URL**: `/panel/berita/{id}/edit`
- **Route Name**: `panel.berita.edit`
- **Controller Method**: `BeritaController@edit`
- **Middleware**: `auth`
- **Deskripsi**: Menampilkan form untuk mengedit berita

### Perbarui Berita
- **Method**: PUT/PATCH
- **URL**: `/panel/berita/{id}`
- **Route Name**: `panel.berita.update`
- **Controller Method**: `BeritaController@update`
- **Middleware**: `auth`
- **Deskripsi**: Memperbarui data berita

### Hapus Berita
- **Method**: DELETE
- **URL**: `/panel/berita/{id}`
- **Route Name**: `panel.berita.destroy`
- **Controller Method**: `BeritaController@destroy`
- **Middleware**: `auth`
- **Deskripsi**: Menghapus berita dari database

## Route Publik

### Daftar Berita Publik
- **Method**: GET
- **URL**: `/berita`
- **Route Name**: `berita.index`
- **Controller Method**: `BeritaController@publicIndex`
- **Middleware**: Tidak ada (publik)
- **Deskripsi**: Menampilkan daftar berita untuk publik

### Detail Berita Publik
- **Method**: GET
- **URL**: `/berita/{id}`
- **Route Name**: `berita.show`
- **Controller Method**: `BeritaController@publicShow`
- **Middleware**: Tidak ada (publik)
- **Deskripsi**: Menampilkan detail berita untuk publik

## API Response Format

### Success Response
```json
{
    "success": true,
    "message": "Berita berhasil ditambahkan.",
    "data": {
        // Data berita
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

### Tambah/Edit Berita
- `judul` (string, required) - Judul berita
- `isi` (text, required) - Isi konten berita
- `gambar` (file, optional) - Gambar berita (jpeg, png, jpg, gif; max 2MB)
- `tanggal_publikasi` (date, optional) - Tanggal publikasi (default: sekarang)
- `aktif` (boolean, optional) - Status publikasi (default: true)

## Validasi

- `judul`: Wajib, maksimal 255 karakter
- `isi`: Wajib
- `gambar`: Opsional, format gambar valid, maksimal 2048KB
- `tanggal_publikasi`: Format tanggal valid
- `aktif`: Harus berupa boolean