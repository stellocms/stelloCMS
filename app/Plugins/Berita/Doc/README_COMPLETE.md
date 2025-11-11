# Dokumentasi Plugin Berita stelloCMS

## Deskripsi
Plugin Berita adalah modul inti dalam sistem stelloCMS yang memungkinkan pengguna untuk mengelola konten berita dan informasi. Plugin ini menyediakan kemampuan untuk membuat, mengedit, menghapus, dan menampilkan berita di sisi admin dan publik dengan berbagai fitur canggih.

## Versi
- 1.0.0

## Fitur Utama

### 1. Manajemen Berita Lengkap
- **Create (Tambah)**: Membuat berita baru dengan judul, isi, gambar, metadata SEO, dan status publikasi
- **Read (Lihat)**: Menampilkan daftar dan detail berita dalam format yang responsif
- **Update (Edit)**: Mengedit berita yang sudah ada dengan semua fitur yang sama
- **Delete (Hapus)**: Menghapus berita dari sistem

### 2. Rich Text Editor (Summernote)
- Menggunakan Summernote editor untuk pengalaman menulis yang kaya
- Toolbar lengkap dengan format teks, warna, daftar, tabel, dan elemen lainnya
- Dukungan untuk menyisipkan gambar, tautan, dan video langsung dari editor
- Fungsi upload gambar langsung ke dalam editor (sebagai data URL base64)
- Format HTML yang kaya (bold, italic, underline, heading, quote, code, dll.)
- Penanganan konflik antara upload editor dan upload form

### 3. Pengelolaan Gambar
- Upload gambar dari komputer pengguna (dengan batasan hanya file gambar melalui atribut `accept="image/*"`)
- Integrasi dengan Unsplash untuk mencari dan menggunakan gambar gratis
- Otomatisasi pembuatan thumbnail dengan berbagai ukuran
- Penambahan watermark otomatis pada gambar
- Dukungan untuk berbagai format gambar (JPG, PNG, GIF)
- Batas ukuran maksimal 2MB
- Konflik otomatis antara upload lokal dan gambar Unsplash (hanya satu yang aktif)
- Preview gambar sebelum upload

### 4. Fitur Unsplash Integration
- Modal pencarian untuk menemukan gambar dari Unsplash
- Cek otomatis apakah API keys tersedia
- Tampilan grid hasil pencarian
- Preview sebelum pemilihan
- Download dan proses lokal otomatis dengan watermark
- Konflik otomatis antara gambar Unsplash dan upload lokal
- Field hidden untuk menyimpan URL gambar Unsplash
- Otomatisasi pembuatan thumbnail dengan watermark dari gambar Unsplash

### 5. Manajemen Publikasi
- Status publikasi (aktif/tidak aktif) untuk mengontrol visibilitas
- Tanggal publikasi yang bisa diatur
- Fitur counter viewer untuk melacak jumlah tampilan

### 6. Fitur Keamanan
Plugin Berita menyediakan berbagai fitur keamanan untuk mencegah upload file berbahaya dan menjaga integritas sistem:

#### Batasan Upload File
- Atribut HTML `accept="image/*"` untuk membatasi hanya file gambar yang bisa dipilih
- Validasi server-side tambahan untuk tipe file (JPG, PNG, GIF)
- Batas ukuran maksimal 2MB untuk file gambar
- Pencegahan konflik antara upload file lokal dan URL gambar Unsplash
- Validasi nama file dan ekstensi untuk mencegah eksploitasi

#### Validasi Konten
- Summernote editor menyaring konten HTML yang diizinkan
- Input yang aman dari XSS attack
- Sanitasi output untuk mencegah script malicious
- Validasi form untuk mencegah input tidak sah

### 7. Fitur SEO (Search Engine Optimization)
Plugin Berita menyediakan berbagai fitur untuk optimasi mesin pencari (SEO):

#### Meta Description
- Field textarea untuk deskripsi singkat berita (maksimal 160 karakter)
- Ditampilkan di hasil pencarian sebagai ringkasan
- Membantu mesin pencari memahami konten berita
- Meningkatkan klik-tayang (click-through rate) di hasil pencarian

#### Meta Keywords
- Field input untuk kata kunci berita
- Dipisahkan dengan koma (contoh: "berita, teknologi, indonesia")
- Membantu dalam kategorisasi dan pencarian konten
- Dapat digunakan untuk fitur terkait atau rekomendasi

#### URL Slug
- Dihasilkan otomatis dari judul berita (contoh: "judul-berita-baru")
- Dapat diubah secara manual jika diperlukan
- Format URL yang SEO-friendly: `/berita/{slug}`
- Unik untuk mencegah konflik URL

#### Struktur Data Terstruktur
- Tanggal publikasi dalam format yang dapat dipahami mesin
- Informasi penulis jika tersedia
- Format HTML yang semantik

#### Best Practices SEO
- Gunakan meta description yang unik untuk setiap berita
- Batasi panjang meta description hingga 150-160 karakter
- Gunakan kata kunci yang relevan dan spesifik
- Gunakan format slug yang mudah dimengerti manusia

### 6. Akses Ganda
- Tampilan admin untuk manajemen berita
- Tampilan publik untuk pembaca berita
- Route terpisah untuk admin dan publik

### 7. Frontend Responsif
- Tampilan daftar berita dalam bentuk card yang responsif
- Tampilan detail berita dengan breadcrumb dan sidebar informasi
- Struktur yang SEO-friendly dan mobile-optimized

## Struktur File dan Direktori

### Struktur Plugin
```
app/Plugins/Berita/
├── Controllers/
│   └── BeritaController.php              # Controller utama untuk manajemen berita
├── Models/
│   └── Berita.php                        # Model untuk data berita
├── Views/
│   ├── create.blade.php                  # Form tambah berita
│   ├── edit.blade.php                    # Form edit berita
│   ├── index.blade.php                   # Daftar berita (admin)
│   ├── show.blade.php                    # Detail berita (admin)
│   └── frontend/
│       ├── index.blade.php               # Daftar berita (publik)
│       └── show.blade.php                # Detail berita (publik)
├── Doc/
│   └── README.md                         # Dokumentasi plugin
├── helpers.php                           # Fungsi bantuan
├── install.php                           # Script instalasi plugin
├── plugin.json                           # Metadata plugin
└── routes.php                            # Routing plugin
```

**Catatan:** Folder `Database/` dihapus karena manajemen skema sekarang dilakukan melalui file `install.php`.

## Model dan Database

### Tabel `berita`

| Kolom | Tipe Data | Deskripsi | Contoh |
|-------|-----------|-----------|---------|
| id | BIGINT (unsigned auto-increment) | Primary key | 1, 2, 3 |
| judul | VARCHAR(255) | Judul berita | "Pembangunan Jembatan Baru" |
| isi | TEXT | Isi/konten berita | "<p>Isi berita...</p>" |
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
$berita = Berita::bySlug('judul-berita')->first();

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
- `GET /panel/berita/unsplash/search` → `BeritaController@searchUnsplash` (mencari gambar dari Unsplash)
- `GET /panel/berita/unsplash/check_keys` → `BeritaController@checkUnsplashKeys` (cek status API Unsplash)

## Frontend API

### Pencarian Gambar Unsplash
Endpoint: `GET /panel/berita/unsplash/search?query={kata_kunci}&per_page={jumlah_per_halaman}`

Contoh:
```
GET /panel/berita/unsplash/search?query=technology&per_page=12
```

Response:
```json
{
  "results": [
    {
      "id": "abc123",
      "urls": {
        "regular": "https://...",
        "small": "https://..."
      },
      "alt_description": "Technology image",
      "user": {
        "name": "John Doe"
      }
    }
  ],
  "total": 100
}
```

### Cek Status API Unsplash
Endpoint: `GET /panel/berita/unsplash/check_keys`

Response:
```json
{
  "hasKeys": true
}
```

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

### Pengaturan Unsplash
Untuk mengaktifkan fitur Unsplash, tambahkan pengaturan berikut ke tabel `settings`:

| pengaturan | nilai | deskripsi |
|------------|-------|-----------|
| unsplash-access | [API Access Key] | Kunci akses Unsplash API |
| unsplash-secret | [API Secret Key] | Kunci rahasia Unsplash API |

## Fungsi-fungsi Bantuan

### helpers.php
```php
// Membuat slug dari judul
$slug = generate_slug('Judul Berita Baru'); // Output: 'judul-berita-baru'

// Membuat slug unik
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
- `searchUnsplash(Request $request)` - Mencari gambar dari Unsplash
- `checkUnsplashKeys()` - Mengecek status API keys Unsplash

### Validasi Input
Semua input melalui controller divalidasi untuk mencegah data yang tidak valid:

- **judul**: Wajib, string maksimal 255 karakter
- **isi**: Wajib, dapat berisi HTML
- **gambar**: Opsional, harus berupa file gambar (JPG, PNG, GIF), maksimal 2MB
- **aktif**: Boolean, default true jika tidak disertakan
- **meta_description**: Opsional, maksimal 500 karakter
- **meta_keywords**: Opsional, maksimal 255 karakter
- **slug**: Opsional, string unik maksimal 255 karakter

## View Templates

### Admin Views
- `index.blade.php`: Tampilan daftar berita dalam format tabel
- `create.blade.php`: Form untuk membuat berita baru
- `edit.blade.php`: Form untuk mengedit berita yang sudah ada
- `show.blade.php`: Tampilan detail berita untuk admin

### Frontend Views
- `frontend/index.blade.php`: Tampilan daftar berita dalam format card
- `frontend/show.blade.php`: Tampilan detail berita untuk publik

## Tampilan di Frontpage (Halaman Depan)

### Menampilkan Berita di Halaman Depan
Plugin Berita menyediakan fleksibilitas untuk menampilkan berita di halaman depan (frontpage) website. Berikut adalah cara-cara untuk mengintegrasikan berita ke dalam halaman depan:

#### 1. Menggunakan Model Langsung
Dari dalam controller atau service halaman depan, Anda dapat menggunakan model Berita langsung:

```php
use App\Plugins\Berita\Models\Berita;

// Dalam controller halaman depan
public function index()
{
    // Ambil 5 berita terbaru yang aktif
    $berita_terbaru = Berita::where('aktif', true)
                        ->orderBy('tanggal_publikasi', 'desc')
                        ->limit(5)
                        ->get();
    
    // Atau dengan pagination
    $berita_paginated = Berita::where('aktif', true)
                          ->orderBy('tanggal_publikasi', 'desc')
                          ->paginate(5);
    
    return view('theme.frontend.' . config('themes.frontend') . '::home', compact('berita_terbaru'));
}
```

#### 2. Penggunaan di Blade Template
Di dalam template halaman depan, Anda dapat menyertakan berita sebagai berikut:

```blade
<!-- Dalam template halaman depan -->
@if($berita_terbaru && $berita_terbaru->count() > 0)
    <section class="latest-news">
        <h2>Berita Terbaru</h2>
        <div class="row">
            @foreach($berita_terbaru as $berita)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                 class="card-img-top" 
                                 alt="{{ $berita->judul }}"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $berita->judul }}</h5>
                            <p class="card-text">
                                {!! Str::limit(strip_tags($berita->isi), 100) !!}
                            </p>
                            <small class="text-muted">
                                {{ $berita->tanggal_publikasi->format('d M Y') }}
                            </small>
                            <br>
                            <a href="{{ route('berita.show', $berita->slug) }}" 
                               class="btn btn-primary btn-sm mt-2">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
```

#### 3. Widget Berita
Anda juga bisa membuat widget berita yang dapat digunakan di berbagai bagian frontpage:

```php
// Dalam helper atau service
function renderLatestNewsWidget($limit = 3, $showImages = true)
{
    $berita = App\Plugins\Berita\Models\Berita::where('aktif', true)
                    ->orderBy('tanggal_publikasi', 'desc')
                    ->limit($limit)
                    ->get();
    
    $html = '<div class="latest-news-widget">';
    $html .= '<h4>Berita Terbaru</h4>';
    
    foreach($berita as $item) {
        $html .= '<div class="news-item">';
        if($showImages && $item->gambar) {
            $html .= '<img src="' . asset('storage/' . $item->gambar) . '" alt="' . $item->judul . '">';
        }
        $html .= '<h5><a href="' . route('berita.show', $item->slug) . '">' . $item->judul . '</a></h5>';
        $html .= '<p>' . Str::limit(strip_tags($item->isi), 80) . '</p>';
        $html .= '<small>' . $item->tanggal_publikasi->format('d M Y') . '</small>';
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}
```

#### 4. Contoh Implementasi di Layout Frontend
Jika ingin menampilkan berita di layout utama frontend, Anda bisa menambahkan di controller layout atau menggunakan view composer:

**Menggunakan View Composer (direkomendasikan untuk tampilan global):**
```php
// Dalam AppServiceProvider
use Illuminate\Support\Facades\View;
use App\Plugins\Berita\Models\Berita;

public function boot()
{
    View::composer('theme.frontend.' . config('themes.frontend') . '::layouts.*', function ($view) {
        $latestNews = Berita::where('aktif', true)
                    ->orderBy('tanggal_publikasi', 'desc')
                    ->limit(3)
                    ->get();
        
        $view->with('latestNews', $latestNews);
    });
}
```

**Menggunakan Middleware:**
```php
// Dalam middleware yang diterapkan ke semua route frontend
public function handle($request, Closure $next)
{
    // Menyediakan data global untuk semua view frontend
    View::share('globalLatestNews', 
        Berita::where('aktif', true)
              ->orderBy('tanggal_publikasi', 'desc')
              ->limit(5)
              ->get()
    );
    
    return $next($request);
}
```

#### 5. Filter dan Kategori (Opsional)
Jika Anda ingin menampilkan berita dengan filter tertentu (misalnya hanya berita dengan kategori tertentu), Anda bisa:

- Menambahkan kolom kategori di tabel berita
- Membuat scope di model Berita
- Menggunakan tag atau relasi kategori
- Menyaring berdasarkan tanggal atau jumlah viewer

Contoh dengan scope tambahan:
```php
// Dalam Model Berita
public function scopeByCategory($query, $category)
{
    return $query->where('kategori', $category);
}

public function scopeFeatured($query)
{
    return $query->where('featured', true);
}
```

Penggunaan:
```php
// Dalam controller
$featuredNews = Berita::where('aktif', true)
                  ->featured()
                  ->orderBy('tanggal_publikasi', 'desc')
                  ->limit(5)
                  ->get();
```

### Struktur Tampilan Berita di Frontpage
- **Gambar Thumbnail**: Gambar yang telah diolah dengan thumbnail otomatis
- **Judul Berita**: Link ke halaman detail berita
- **Ringkasan Isi**: Dengan limit karakter untuk tampilan ringkas
- **Tanggal Publikasi**: Format yang ramah pengguna
- **Jumlah Viewer**: Jika diaktifkan, menunjukkan popularitas berita
- **Metadata SEO**: Untuk optimasi pencarian

### Komponen dan Fitur Tampilan
- **Pagination**: Otomatis untuk daftar berita dengan jumlah banyak
- **Filter Tanggal**: Menampilkan berita terbaru atau berdasarkan rentang waktu
- **Pencarian Berita**: Dapat dikaitkan dengan fitur pencarian global
- **Related News**: Berita terkait berdasarkan tag atau kategori
- **Social Sharing**: Tombol berbagi ke media sosial (opsional)

Dengan pendekatan ini, berita dapat dengan mudah diintegrasikan ke dalam halaman depan website sambil tetap mempertahankan fleksibilitas dan kinerja yang optimal.

### Komponen UI

#### Summernote Editor
- Toolbar lengkap dengan format teks, warna, daftar, tabel
- Dukungan untuk menyisipkan gambar, tautan, video
- Responsive dan kompatibel dengan AdminLTE
- Tinggi editor 300px untuk pengalaman menulis optimal

#### Form Create (create.blade.php)
Form ini digunakan untuk membuat berita baru dengan komponen-komponen berikut:

**Struktur Form:**
- Method: `POST`
- Action: `/panel/berita`
- Enctype: `multipart/form-data` untuk upload gambar

**Field-Field Form:**
- `judul` (input text) - Wajib diisi, placeholder untuk judul berita
- `isi` (textarea) - Wajib diisi, menggunakan Summernote editor
- `meta_description` (textarea) - Opsional, deskripsi singkat berita untuk SEO (maksimal 160 karakter)
- `meta_keywords` (input text) - Opsional, kata kunci berita dipisahkan dengan koma
- `gambar` (file input) - Opsional, untuk upload gambar dari komputer
- `aktif` (checkbox) - Status publikasi (aktif/non-aktif), default aktif
- `slug` (hidden field) - Untuk SEO URL (dihasilkan otomatis dari judul jika tidak diisi)
- `unsplash_image_url` (hidden field) - Untuk menyimpan URL gambar dari Unsplash

**Fitur-Fitur:**
- Tombol "Gunakan dari Unsplash" muncul saat judul diisi
- Preview gambar dari Unsplash atau upload lokal
- Validasi form sesuai dengan aturan model
- Integrasi dengan Unsplash untuk pencarian gambar
- Custom file input sesuai dengan tema AdminLTE

**Script Terkait:**
- Inisialisasi Summernote editor
- Handler untuk upload file dan preview
- Handler untuk pencarian dan pemilihan gambar dari Unsplash
- Validasi dan penanganan error

#### Form Edit (edit.blade.php)
Form ini digunakan untuk mengedit berita yang sudah ada dengan komponen-komponen berikut:

**Struktur Form:**
- Method: `PUT` (dengan spoofing method hidden field `_method`)
- Action: `/panel/berita/{id}`
- Enctype: `multipart/form-data` untuk upload gambar

**Field-Field Form:**
- `judul` (input text) - Wajib diisi, nilai dari data berita sebelumnya
- `isi` (textarea) - Wajib diisi, menggunakan Summernote editor, nilai dari data berita sebelumnya
- `meta_description` (textarea) - Opsional, deskripsi singkat berita untuk SEO (maksimal 160 karakter), nilai dari data berita sebelumnya
- `meta_keywords` (input text) - Opsional, kata kunci berita dipisahkan dengan koma, nilai dari data berita sebelumnya
- `gambar` (file input) - Opsional, untuk upload gambar baru (kosongkan jika tidak ingin mengganti)
- `aktif` (checkbox) - Status publikasi, nilai dari data berita sebelumnya
- `slug` (hidden field) - Untuk SEO URL (dihasilkan otomatis dari judul jika tidak diisi), nilai dari data berita sebelumnya
- `unsplash_image_url` (hidden field) - Untuk menyimpan URL gambar dari Unsplash

**Fitur-Fitur Tambahan:**
- Tampilan gambar berita saat ini sebelum upload baru
- Tombol "Gunakan dari Unsplash" muncul saat judul diisi
- Preview gambar dari Unsplash atau upload lokal
- Validasi form sesuai dengan aturan model
- Integrasi dengan Unsplash untuk pencarian gambar
- Custom file input sesuai dengan tema AdminLTE

**Script Terkait:**
- Inisialisasi Summernote editor
- Handler untuk upload file dan preview
- Handler untuk pencarian dan pemilihan gambar dari Unsplash
- Handler untuk menyembunyikan gambar saat ini saat upload baru
- Validasi dan penanganan error

#### Upload Gambar
- Upload dari komputer (dengan batasan hanya file gambar melalui atribut `accept="image/*"`)
- Preview gambar sebelum upload
- Integrasi dengan Unsplash untuk mencari gambar
- Thumbnail otomatis
- Proses watermark otomatis
- Batas ukuran maksimal 2MB
- Validasi tipe file (JPEG, PNG, GIF)
- Handler untuk mengganti gambar berita saat ini

#### Unsplash Modal
- Pencarian gambar dengan keyword
- Tampilan grid hasil pencarian
- Preview sebelum pemilihan
- Download dan proses lokal otomatis
- Cek status API keys Unsplash sebelum menampilkan modal

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

## Pengembangan Lebih Lanjut

### Model Extendibility
```php
// Di controller lain
use App\Plugins\Berita\Models\Berita;

// Mengambil berita aktif dengan relasi user
$berita = Berita::where('aktif', true)
              ->with('user')
              ->orderBy('tanggal_publikasi', 'desc')
              ->paginate(10);

// Membuat berita dengan user
$berita = Berita::create([
    'judul' => 'Judul Berita',
    'isi' => 'Isi berita',
    'user_id' => auth()->id(),
    'aktif' => true
]);
```

### Event System
Karena tidak ada file event di struktur, plugin ini menggunakan pendekatan langsung di controller.

### Testing
```php
// Contoh test untuk berita
public function test_berita_can_be_created()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/panel/berita', [
        'judul' => 'Test Berita',
        'isi' => 'Isi berita test',
        'aktif' => true
    ]);
    
    $response->assertRedirect();
    $this->assertDatabaseHas('berita', [
        'judul' => 'Test Berita'
    ]);
}
```

## Instalasi dan Konfigurasi

### Instalasi Manual
1. Ekstrak plugin ke direktori `app/Plugins/Berita/`
2. Plugin akan terdeteksi otomatis oleh sistem
3. Jalankan `php artisan migrate` untuk membuat tabel berita jika belum ada
4. Konfigurasi Unsplash API keys jika ingin menggunakan fitur Unsplash
5. Plugin siap digunakan

### Install Script
File `install.php` berisi class `BeritaInstaller` yang otomatis:
- Membuat tabel `berita` jika belum ada
- Mengupdate struktur tabel jika sudah ada
- Menambahkan kolom baru jika diperlukan
- Memperbaiki relasi foreign key

## Best Practices

### Keamanan
- Validasi semua input user
- Sanitasi output HTML
- Gunakan CSRF token
- Batasi akses berdasarkan role
- Validasi file upload (tipe dan ukuran)
- Gunakan atribut `accept="image/*"` di form HTML untuk batasan sisi klien
- Periksa potensi konflik antara upload file dan field URL lainnya
- Gunakan authorization yang ketat untuk akses upload

### Performance
- Gunakan pagination untuk daftar berita
- Buat thumbnail untuk mengurangi ukuran gambar
- Gunakan caching untuk data yang jarang berubah
- Optimasi query dengan eager loading

### SEO
- Gunakan slug unik untuk URL
- Tambahkan meta description dan keywords
- Gunakan heading hierarchy yang benar
- Gunakan struktur data terstruktur (schema.org)

### Penggunaan Gambar
- Gunakan thumbnail untuk daftar berita
- Tambahkan alt text untuk aksesibilitas
- Gunakan watermark untuk perlindungan hak cipta
- Pastikan tidak ada konflik antara upload lokal dan URL gambar
- Gunakan format file yang optimal untuk web (JPG untuk foto, PNG untuk grafik)
- Batasi ukuran file maksimal 2MB untuk kinerja yang lebih baik
- Optimalkan ukuran file untuk kecepatan loading

## Troubleshooting

### Error Umum
1. **Gambar tidak muncul**
   - Pastikan folder `storage/app/public` bisa diakses
   - Pastikan symlink dibuat: `php artisan storage:link`
   - Periksa permission file

2. **Unsplash tidak muncul**
   - Pastikan API keys diatur di tabel settings
   - Periksa koneksi internet
   - Pastikan endpoint dapat diakses

3. **Upload gambar gagal**
   - Periksa ukuran file (maksimal 2MB)
   - Pastikan format file didukung (JPG, PNG, GIF)
   - Pastikan folder upload bisa ditulis

4. **Route tidak ditemukan**
   - Pastikan plugin aktif
   - Jalankan `php artisan route:clear`
   - Periksa nama route di `routes.php`

### Debugging
- Gunakan log untuk melacak proses upload dan proses gambar
- Periksa `storage/logs/laravel.log` untuk error
- Gunakan browser dev tools untuk debugging JavaScript
- Periksa console JavaScript untuk error

## Tips dan Trik

### Untuk Admin
- Gunakan fitur Unsplash untuk gambar berkualitas tinggi
- Gunakan Summernote editor untuk format teks kaya
- Gunakan preview sebelum publish
- Gunakan status aktif/nonaktif untuk jadwal publikasi

### Untuk Pengembang
- Gunakan helper `view_theme()` untuk konsistensi tampilan
- Ikuti konvensi penamaan route
- Gunakan model events untuk logika tambahan
- Gunakan accessor untuk format data tambahan

## Update dan Maintenance

### Update Database
File `install.php` akan otomatis:
- Mengecek apakah tabel sudah ada
- Menambahkan kolom baru jika versi plugin lebih baru
- Memperbaiki struktur jika diperlukan

### Backup
Pastikan untuk mencadangkan:
- Database (tabel berita dan pengaturan)
- Gambar yang diupload (folder storage/app/public)
- File konfigurasi plugin

## Kontribusi

### Struktur Pengembangan
1. Fork repository
2. Buat branch fitur baru
3. Implementasikan perubahan
4. Test fungsionalitas
5. Update dokumentasi jika diperlukan
6. Buat pull request

### Coding Standards
- Ikuti Laravel coding standards
- Gunakan PHP DocBlock untuk dokumentasi fungsi
- Gunakan konvensi penamaan yang konsisten
- Tambahkan test untuk perubahan signifikan

## Lisensi
Plugin Berita adalah bagian dari stelloCMS dan dilisensikan di bawah lisensi MIT.

## Dukungan dan Komunitas
- Dokumentasi resmi: [stelloCMS Documentation](https://stellocms.com/docs)
- Forum komunitas: [stelloCMS Community](https://stellocms.com/community)
- GitHub Issues: [Issue Tracker](https://github.com/stellocms/stelloCMS/issues)
- Email support: support@stellocms.com

## Versi dan Update Log

### 1.0.0
- Rilis awal plugin berita
- CRUD berita lengkap
- Integrasi Summernote editor
- Upload gambar dan Unsplash
- SEO features (meta tags, slug)
- Akses ganda (admin/publik)