# Dokumentasi Plugin Berita stelloCMS

## Versi
- 1.0.0

## Deskripsi
Plugin Berita adalah modul inti dalam sistem stelloCMS yang memungkinkan pengguna untuk mengelola konten berita dan informasi. Plugin ini menyediakan kemampuan untuk membuat, mengedit, menghapus, dan menampilkan berita di sisi admin dan publik dengan berbagai fitur canggih.

## Fitur Utama

### 1. Manajemen Berita Lengkap
- **Create (Tambah)**: Membuat berita baru dengan judul, isi rich text, gambar, metadata SEO, dan status publikasi
- **Read (Lihat)**: Menampilkan daftar dan detail berita dalam format yang responsif
- **Update (Edit)**: Mengedit berita yang sudah ada dengan semua fitur yang sama
- **Delete (Hapus)**: Menghapus berita dari sistem

### 2. Rich Text Editor (Summernote)
- Menggunakan Summernote editor untuk pengalaman menulis yang kaya
- Toolbar lengkap dengan format teks, warna, daftar, tabel, dan elemen lainnya
- Dukungan untuk menyisipkan gambar, tautan, dan video langsung dari editor
- Pengalaman menulis yang profesional dan intuitif

### 3. Pengelolaan Gambar
- **Upload gambar dari komputer**: Hanya file gambar yang diperbolehkan (dengan atribut `accept="image/*"`)
- **Integrasi dengan Unsplash**: Mencari dan menggunakan gambar gratis dari Unsplash
- **Thumbnail otomatis**: Pembuatan otomatis dengan berbagai ukuran dan watermark
- **Dukungan berbagai format**: JPG, PNG, GIF dengan batas ukuran maksimal 2MB

### 4. Fitur SEO
- **Meta description**: Field textarea untuk deskripsi singkat berita (maksimal 160 karakter)
- **Meta keywords**: Field input untuk kata kunci berita dipisahkan dengan koma
- **Slug otomatis**: Dihasilkan otomatis dari judul, dapat diubah secara manual
- **Format URL SEO-friendly**: `/berita/{slug}`

### 5. Manajemen Publikasi
- **Status publikasi**: Aktif/tidak aktif untuk mengontrol visibilitas
- **Tanggal publikasi**: Dapat diatur sesuai kebutuhan
- **Counter viewer**: Mencatat jumlah tampilan berita

### 6. Akses Ganda
- **Tampilan admin**: Form lengkap untuk manajemen berita
- **Tampilan publik**: Menampilkan berita untuk pembaca
- **Route terpisah**: Dukungan route khusus untuk admin dan publik

### 7. Frontend Responsif
- **Tampilan daftar berita**: Dalam bentuk card yang responsif
- **Tampilan detail berita**: Dengan breadcrumb dan sidebar informasi
- **Struktur mobile-optimized**: Tampilan optimal di berbagai perangkat

## Struktur Plugin

### Struktur Direktori
```
app/Plugins/Berita/
├── Controllers/
│   └── BeritaController.php
├── Models/
│   └── Berita.php
├── Views/
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── index.blade.php
│   ├── show.blade.php
│   └── frontend/
│       ├── index.blade.php
│       └── show.blade.php
├── Doc/
│   └── README.md (dokumentasi)
├── helpers.php (fungsi bantuan)
├── install.php (script instalasi)
├── plugin.json (metadata plugin)
└── routes.php (routing plugin)
```

**Catatan:** Folder `Database/` dihapus karena manajemen skema sekarang dilakukan melalui file `install.php`.

## Model dan Database

### Tabel `berita`
| Kolom | Tipe Data | Deskripsi | Contoh |
|-------|-----------|-----------|---------|
| id | BIGINT (unsigned auto-increment) | Primary key | 1, 2, 3 |
| judul | VARCHAR(255) | Judul berita | "Pembangunan Jembatan Baru" |
| isi | TEXT | Isi/konten berita (dapat berisi HTML) | "<p>Isi berita...</p>" |
| gambar | VARCHAR(255) (nullable) | Path gambar berita | "berita/2025_01_01_judul_berita_thumb_large.jpg" |
| tanggal_publikasi | TIMESTAMP | Tanggal publikasi berita | 2025-01-01 00:00:00 |
| aktif | BOOLEAN | Status publikasi (aktif/tidak) | 1 (aktif), 0 (tidak aktif) |
| user_id | BIGINT (unsigned, nullable) | Foreign key ke tabel users | 1 |
| created_at | TIMESTAMP | Tanggal pembuatan | 2025-01-01 00:00:00 |
| updated_at | TIMESTAMP | Tanggal pembaruan | 2025-01-01 00:00:00 |
| meta_description | TEXT (nullable) | Deskripsi SEO | "Deskripsi singkat berita..." |
| meta_keywords | VARCHAR(255) (nullable) | Kata kunci SEO | "pembangunan, jembatan, desa" |
| slug | VARCHAR(255) (unique, nullable) | URL slug | "pembangunan-jembatan-baru" |
| viewer | INTEGER | Jumlah penayangan | 10 |

### Model Berita
```php
use App\Plugins\Berita\Models\Berita;

// Mendapatkan semua berita aktif
$aktifBerita = Berita::where('aktif', true)->get();

// Mendapatkan berita berdasarkan slug
$berita = Berita::bySlug('judul-berita')->firstOrFail();

// Membuat berita baru
$berita = Berita::create([
    'judul' => 'Judul Berita',
    'isi' => '<p>Isi berita...</p>',
    'aktif' => true
]);
```

## Routing

### Rute Admin
- `GET /panel/berita` → `BeritaController@index` (nama route: `panel.berita.index`)
- `GET /panel/berita/create` → `BeritaController@create` (nama route: `panel.berita.create`)
- `POST /panel/berita` → `BeritaController@store` (nama route: `panel.berita.store`)
- `GET /panel/berita/{id}` → `BeritaController@show` (nama route: `panel.berita.show`)
- `GET /panel/berita/{id}/edit` → `BeritaController@edit` (nama route: `panel.berita.edit`)
- `PUT /panel/berita/{id}` → `BeritaController@update` (nama route: `panel.berita.update`)
- `DELETE /panel/berita/{id}` → `BeritaController@destroy` (nama route: `panel.berita.destroy`)

### Rute Publik
- `GET /berita` → `BeritaController@publicIndex` (nama route: `berita.index`)
- `GET /berita/{slug}` → `BeritaController@publicShow` (nama route: `berita.show`)

### Rute Tambahan
- `GET /panel/berita/unsplash/search` → `BeritaController@searchUnsplash` (cari gambar dari Unsplash)
- `GET /panel/berita/unsplash/check_keys` → `BeritaController@checkUnsplashKeys` (cek status API Unsplash)

## View dan Form Berita

### Form Tambah Berita (create.blade.php)
Form ini menyediakan:
- Input judul dengan validasi
- Summernote editor untuk isi berita
- Upload gambar dari komputer (dengan batasan hanya file gambar)
- Pilihan gambar dari Unsplash (dengan tombol khusus)
- Input untuk metadata SEO (meta_description, meta_keywords, slug)
- Checkbox status aktif/non-aktif
- Validasi form dan pesan error

### Form Edit Berita (edit.blade.php)
Menyediakan fungsionalitas yang sama dengan create, ditambah:
- Tampilan gambar saat ini
- Kemampuan untuk menimpa gambar yang ada
- Field-field yang sudah terisi dengan data berita sebelumnya

### Tampilan Daftar Berita (index.blade.php)
- Tabel atau grid berita dengan pagination
- Tombol-tombol CRUD (Lihat, Edit, Hapus)
- Indikator status publikasi (aktif/non-aktif)
- Ringkasan isi berita

### Tampilan Detail Berita (show.blade.php)
- Tampilan lengkap judul dan isi berita
- Gambar berita (jika ada)
- Metadata (tanggal publikasi, status, user)
- Tombol-tombol aksi (Edit, Hapus, Kembali)

### Tampilan Frontend
- Tampilan daftar berita dalam format card untuk publik
- Tampilan detail berita dengan breadcrumb
- Sidebar informasi tambahan
- SEO-friendly structure

## Fitur Keamanan

### Validasi Upload File
- Upload hanya menerima format gambar (JPEG, PNG, GIF)
- Batas ukuran maksimal 2MB
- Atribut `accept="image/*"` di form untuk batasan sisi klien
- Validasi server-side tambahan untuk tipe file dan ukuran

### Validasi Isi Berita
- Summernote editor mengizinkan format HTML yang kaya
- Input yang aman dari XSS attack
- Sanitasi output untuk mencegah script malicious

### Penanganan Konflik
- Tidak ada konflik antara upload file lokal dan pemilihan gambar Unsplash
- Jika pengguna memilih gambar dari Unsplash, upload lokal diabaikan
- Jika pengguna memilih upload lokal, gambar Unsplash diabaikan

## Integrasi Unsplash

### Fitur Unsplash
- Modal pencarian untuk menemukan gambar dari Unsplash
- Cek otomatis apakah API keys tersedia
- Tampilan grid hasil pencarian
- Preview sebelum pemilihan
- Download dan proses lokal otomatis dengan watermark

### Konfigurasi Unsplash
Untuk mengaktifkan fitur Unsplash, tambahkan pengaturan berikut ke tabel `settings`:
| pengaturan | nilai | deskripsi |
|------------|-------|-----------|
| unsplash-access | [API Access Key] | Kunci akses Unsplash API |
| unsplash-secret | [API Secret Key] | Kunci rahasia Unsplash API |

### API Integration
Endpoint: `GET /panel/berita/unsplash/search?query={kata_kunci}&per_page={jumlah_per_halaman}`

## Helper Functions

### helpers.php
```php
// Fungsi untuk membuat slug dari judul
$slug = generate_slug('Judul Berita Baru'); // Output: 'judul-berita-baru'

// Fungsi untuk membuat slug unik
$uniqueSlug = generate_unique_slug('Judul Berita', 'berita', 'slug');
```

## Controller Methods

### BeritaController Methods

#### Admin Methods
- `index()` - Menampilkan daftar berita untuk admin
- `create()` - Menampilkan form tambah berita
- `store(Request $request)` - Menyimpan berita baru
- `show($id)` - Menampilkan detail berita (admin atau publik berdasarkan route)
- `edit($id)` - Menampilkan form edit berita
- `update(Request $request, $id)` - Memperbarui berita
- `destroy($id)` - Menghapus berita

#### Publik Methods
- `publicIndex()` - Menampilkan daftar berita untuk publik
- `publicShow($slug)` - Menampilkan detail berita untuk publik

### Validasi Input
Semua input melalui controller divalidasi untuk mencegah data yang tidak valid:
- **judul**: Wajib, string maksimal 255 karakter
- **isi**: Wajib, dapat berisi HTML format kaya
- **gambar**: Opsional, harus berupa file gambar (JPG, PNG, GIF), maksimal 2MB
- **aktif**: Boolean, default true jika tidak disertakan
- **meta_description**: Opsional, maksimal 500 karakter
- **meta_keywords**: Opsional, maksimal 255 karakter
- **slug**: Opsional, string unik maksimal 255 karakter

## Best Practices

### Penamaan
- Gunakan nama plugin dalam format `PascalCase` (huruf kapital di awal setiap kata tanpa spasi atau underscore)
- Contoh benar: `Berita`, `ContohPlugin`, `PengumumanDesa`
- Contoh salah: `berita`, `contoh_plugin`, `pengumuman-desa`, `Manajemen keuangan`

### SEO Optimization
- Gunakan meta description unik untuk setiap berita
- Batasi panjang meta description hingga 150-160 karakter
- Gunakan kata kunci yang relevan dan spesifik
- Gunakan format slug yang mudah dimengerti manusia

### Keamanan
- Validasi semua input pengguna
- Gunakan authorization untuk akses data
- Sanitasi output untuk mencegah XSS
- Gunakan batasan upload file yang ketat

### Performance
- Gunakan eager loading untuk mencegah N+1 queries
- Gunakan caching untuk data yang jarang berubah
- Gunakan pagination untuk hasil yang besar
- Gunakan connection pooling untuk aplikasi dengan traffic tinggi

## Konfigurasi Plugin

### plugin.json
```json
{
    "name": "Berita",
    "version": "1.0.0",
    "description": "Plugin untuk mengelola berita dan informasi",
    "author": "stelloCMS Development Team",
    "author_url": "https://stellocms.com",
    "required_version": "1.0.0",
    "install_script": "install.php",
    "helpers": "helpers.php"
}
```

### Install Script
File `install.php` berisi class `BeritaInstaller` yang otomatis:
- Membuat tabel `berita` jika belum ada
- Mengupdate struktur tabel jika sudah ada
- Menambahkan kolom baru jika diperlukan
- Memperbaiki relasi foreign key
- Memastikan semua slug unik

## Troubleshooting

### Upload Gambar Gagal
- Pastikan hanya file gambar yang dipilih
- Periksa ukuran file (maksimal 2MB)
- Pastikan format file didukung (JPG, PNG, GIF)
- Pastikan folder upload bisa ditulis
- Pastikan tidak ada konflik dengan field `unsplash_image_url`

### Fitur Unsplash Tidak Muncul
- Pastikan API keys diatur di tabel settings
- Periksa koneksi internet
- Pastikan endpoint dapat diakses

### Summernote Editor Tidak Muncul
- Pastikan CDN Summernote dimuat dengan benar
- Periksa JavaScript console untuk error
- Pastikan jQuery dan Bootstrap tersedia

### Form Validation Error
- Periksa apakah semua field wajib terisi
- Pastikan format file gambar sesuai dengan persyaratan
- Pastikan teks meta tidak melebihi batas karakter

## Pengembangan Lebih Lanjut

### Template Extendibility
```php
// Di controller lain
use App\Plugins\Berita\Models\Berita;

// Mengambil berita aktif dengan relasi user
$berita = Berita::where('aktif', true)
              ->with('user')
              ->orderBy('tanggal_publikasi', 'desc')
              ->paginate(10);

// Membuat berita dengan user dan metadata
$berita = Berita::create([
    'judul' => 'Judul Berita',
    'isi' => '<p>Isi berita dengan format HTML</p>',
    'user_id' => auth()->id(),
    'aktif' => true,
    'meta_description' => 'Deskripsi SEO',
    'meta_keywords' => 'keyword1, keyword2, keyword3'
]);
```

### Event System
Karena tidak ada file event di struktur, plugin ini menggunakan pendekatan langsung di controller.

## Integrasi Sistem

### Menu Otomatis
Plugin secara otomatis menambahkan menu ke sistem menu stelloCMS:
- Nama menu: "Berita"
- Route: `panel.berita.index`
- Icon: `fas fa-newspaper`
- Role: Admin, kepala-desa, sekdes (dapat dikonfigurasi)

### Hak Akses
- Menu dan route dilindungi dengan middleware `auth`
- Hak akses dapat dikonfigurasi melalui sistem manajemen menu
- Dukungan role-based access control (RBAC)

### Tema
- Kompatibel dengan AdminLTE untuk tampilan admin
- Menggunakan helper `view_theme()` untuk rendering view
- Dukungan untuk berbagai tema frontend