# Dokumentasi Sistem Widgets untuk stelloCMS

## Daftar Isi
1. [Gambaran Umum](#gambaran-umum)
2. [Struktur Tabel](#struktur-tabel)
3. [Model Widgets](#model-widgets)
4. [Controller Widgets](#controller-widgets)
5. [Route dan URL](#route-dan-url)
6. [Manajemen Menu di Sidebar](#manajemen-menu-di-sidebar)
7. [Fitur dan Fungsi](#fitur-dan-fungsi)
8. [Penggunaan](#penggunaan)
9. [Best Practices](#best-practices)

## Gambaran Umum

Sistem Widgets adalah modul tambahan untuk stelloCMS yang memungkinkan pengguna untuk mengelola elemen-elemen tampilan yang dapat ditampilkan di berbagai posisi dalam sistem. Widgets dapat berupa plugin, teks sederhana, atau kode HTML yang dapat ditempatkan di header, sidebar kiri, sidebar kanan, footer, atau halaman home.

### Fungsi Utama
- Mengelola elemen tampilan dinamis
- Memungkinkan penempatan konten di berbagai posisi
- Mendukung tiga jenis konten: plugin, teks, dan HTML
- Memberikan fleksibilitas dalam tata letak tampilan

## Struktur Tabel

### Tabel `widgets`

| Kolom | Tipe Data | Deskripsi | Default | Contoh |
|-------|-----------|-----------|---------|---------|
| id | BIGINT (unsigned auto-increment) | Primary key | | 1, 2, 3 |
| name | VARCHAR(255) | Nama unik widget | | "Widget Berita Terbaru" |
| type | ENUM('plugin', 'text', 'html') | Jenis konten widget | | 'plugin', 'text', 'html' |
| position | ENUM('header', 'sidebar-left', 'sidebar-right', 'footer', 'home') | Posisi penempatan | | 'sidebar-left', 'footer' |
| status | ENUM('aktif', 'nonaktif') | Status aktif/nonaktif | 'aktif' | 'aktif', 'nonaktif' |
| content | TEXT (nullable) | Isi konten widget | NULL | "Ini adalah teks widget" |
| plugin_name | VARCHAR(255) (nullable) | Nama plugin terkait | NULL | "Berita" |
| order | INT | Urutan tampilan | 0 | 1, 2, 3 |
| settings | JSON (nullable) | Pengaturan tambahan | NULL | {"show_title": true} |
| created_at | TIMESTAMP | Tanggal pembuatan | CURRENT_TIMESTAMP | 2025-01-01 10:00:00 |
| updated_at | TIMESTAMP | Tanggal pembaruan | CURRENT_TIMESTAMP ON UPDATE | 2025-01-01 10:00:00 |

## Model Widgets

### Widget Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'position',
        'status',
        'content',
        'plugin_name',
        'order',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'string',
        'type' => 'string',
        'position' => 'string'
    ];

    /**
     * Scope untuk widget aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk widget berdasarkan posisi
     */
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Scope untuk widget berdasarkan tipe
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
```

## Controller Widgets

Controller Widget menyediakan fungsi CRUD lengkap untuk manajemen widgets.

### Fungsi Utama
- `index()` - Menampilkan daftar semua widgets
- `create()` - Menampilkan form pembuatan widget baru
- `store(Request $request)` - Menyimpan widget baru ke database
- `show(Widget $widget)` - Menampilkan detail widget
- `edit(Widget $widget)` - Menampilkan form edit widget
- `update(Request $request, Widget $widget)` - Memperbarui data widget
- `destroy(Widget $widget)` - Menghapus widget
- `updateOrder(Request $request)` - Mengupdate urutan widget

## Route dan URL

### Route System
- `GET /panel/widgets` → `WidgetController@index` (nama route: `panel.widgets.index`)
- `GET /panel/widgets/create` → `WidgetController@create` (nama route: `panel.widgets.create`)
- `POST /panel/widgets` → `WidgetController@store` (nama route: `panel.widgets.store`)
- `GET /panel/widgets/{widget}` → `WidgetController@show` (nama route: `panel.widgets.show`)
- `GET /panel/widgets/{widget}/edit` → `WidgetController@edit` (nama route: `panel.widgets.edit`)
- `PUT /panel/widgets/{widget}` → `WidgetController@update` (nama route: `panel.widgets.update`)
- `DELETE /panel/widgets/{widget}` → `WidgetController@destroy` (nama route: `panel.widgets.destroy`)
- `POST /panel/widgets/update-order` → `WidgetController@updateOrder` (nama route: `panel.widgets.update-order`)

## Manajemen Menu di Sidebar

Menu Widgets ditambahkan ke dalam menu Pengaturan di sidebar admin.

### Struktur Menu
- **Parent Menu**: Pengaturan (`pengaturan`)
  - **Submenu**: Widgets (`widgets`) → Route: `widgets.index`
  - Icon: `fas fa-th-large`
  - Akses role: `['admin', 'operator']`

### Tabel Menu
Menu Widgets disimpan di tabel `menus` dengan konfigurasi:
```php
[
    'name' => 'widgets',
    'title' => 'Widgets',
    'route' => 'widgets.index',
    'icon' => 'fas fa-th-large',
    'parent_id' => ID_MENU_PENGATURAN,
    'order' => 1,
    'is_active' => true,
    'plugin_name' => null,
    'roles' => json_encode(['admin', 'operator']),
    'type' => 'admin',
    'position' => 'sidebar-left'
]
```

## Fitur dan Fungsi

### Jenis Widget
1. **Plugin Widget**
   - Menampilkan konten dari plugin yang terinstal
   - Menggunakan `plugin_name` untuk mengidentifikasi plugin
   - Contoh: Widget berita terbaru dari plugin Berita

2. **Text Widget**
   - Menampilkan teks sederhana
   - Menggunakan field `content` untuk menyimpan teks
   - Cocok untuk informasi statis atau dinamis sederhana

3. **HTML Widget**
   - Menampilkan konten HTML
   - Menggunakan field `content` untuk menyimpan HTML
   - Cocok untuk elemen tampilan khusus atau embed code

### Posisi Widget
1. **Header** - Ditampilkan di bagian atas halaman
2. **Sidebar Kiri** - Ditampilkan di sidebar kiri
3. **Sidebar Kanan** - Ditampilkan di sidebar kanan
4. **Footer** - Ditampilkan di bagian bawah halaman
5. **Home** - Ditampilkan di halaman utama

### Status Widget
- **Aktif**: Widget ditampilkan di posisi yang ditentukan
- **Nonaktif**: Widget disembunyikan dan tidak ditampilkan

## Penggunaan

### Menambahkan Widget Baru
1. Akses **Pengaturan** → **Widgets** dari sidebar
2. Klik tombol "Tambah Widget"
3. Isi formulir dengan informasi widget:
   - Nama widget
   - Tipe (plugin, text, html)
   - Posisi (header, sidebar-left, dll)
   - Status (aktif/nonaktif)
   - Untuk tipe plugin: masukkan nama plugin
   - Untuk tipe text/html: masukkan konten
   - Atur urutan tampilan
4. Klik "Simpan"

### Mengelola Widget
- **Lihat Detail**: Klik tombol "Lihat" untuk melihat detail
- **Edit**: Klik tombol "Edit" untuk memperbarui informasi
- **Hapus**: Klik tombol "Hapus" untuk menghapus widget
- **Ubah Urutan**: Gunakan fitur drag-and-drop atau atur field `order`

### Contoh Penggunaan
```php
// Mendapatkan semua widget aktif untuk posisi sidebar kiri
$sidebarWidgets = Widget::aktif()->byPosition('sidebar-left')->orderBy('order')->get();

// Mendapatkan widget berdasarkan tipe
$htmlWidgets = Widget::byType('html')->get();
```

## Best Practices

### Penamaan Widget
- Gunakan nama yang deskriptif dan unik
- Hindari karakter khusus dalam nama
- Gunakan format yang konsisten

### Penempatan Widget
- Atur urutan widget untuk kontrol tampilan
- Gunakan posisi yang sesuai dengan fungsi widget
- Jangan terlalu banyak widget di satu posisi

### Keamanan
- Validasi konten HTML untuk mencegah XSS
- Gunakan hanya plugin terpercaya dalam widget plugin
- Batasi akses hanya untuk role yang berwenang

### Performance
- Gunakan caching untuk widget yang tidak sering berubah
- Batasi jumlah widget aktif yang ditampilkan
- Gunakan lazy loading jika widget memerlukan proses berat

### Konten
- Untuk widget HTML, perhatikan validitas dan keamanan kode
- Gunakan relative path untuk gambar dan resource
- Pastikan responsif untuk widget yang ditampilkan mobile

## Panduan Pembuatan Widget

### 1. Membuat Plugin Widget
Jika ingin membuat widget plugin, ikuti langkah-langkah pembuatan plugin standar:

1. Siapkan struktur plugin sesuai panduan [Panduan-Pembuatan-Plugin.md](./Panduan-Pembuatan-Plugin.md)
2. Pastikan plugin memiliki controller yang dapat mengembalikan view/widget
3. Registrasi plugin ke dalam sistem melalui menu plugin

### 2. Membuat Text Widget
1. Akses halaman **Pengaturan** → **Widgets**
2. Klik "Tambah Widget"
3. Isi form dengan:
   - Nama: "Widget Informasi"
   - Tipe: "Text"
   - Posisi: Sesuai kebutuhan (misalnya 'sidebar-right')
   - Status: "Aktif"
   - Konten: "Informasi penting untuk pengunjung"
4. Simpan widget

### 3. Membuat HTML Widget
1. Akses halaman **Pengaturan** → **Widgets**
2. Klik "Tambah Widget"
3. Isi form dengan:
   - Nama: "Widget Khusus"
   - Tipe: "HTML"
   - Posisi: Sesuai kebutuhan 
   - Status: "Aktif"
   - Konten: Kode HTML yang ingin ditampilkan
4. Simpan widget

### 4. Membuat Plugin Widget
1. Akses halaman **Pengaturan** → **Widgets**
2. Klik "Tambah Widget"
3. Isi form dengan:
   - Nama: "Widget Plugin"
   - Tipe: "Plugin"
   - Posisi: Sesuai kebutuhan
   - Status: "Aktif"
   - Nama Plugin: nama plugin yang sudah terinstal
4. Simpan widget

### 5. Tips Membuat Widget Efektif
- **Gunakan widget sesuai kebutuhan**: Jangan terlalu banyak widget di satu halaman
- **Atur urutan widget**: Gunakan field `order` untuk mengontrol urutan tampilan
- **Gunakan status widget**: Nonaktifkan widget jika tidak perlu ditampilkan
- **Optimalkan konten**: Untuk widget berisi data dinamis, gunakan caching jika memungkinkan
- **Uji kompatibilitas**: Pastikan widget tampil dengan baik di berbagai ukuran layar

### 6. Implementasi Widget di Tampilan
Untuk menampilkan widget di frontend, gunakan kode berikut:

```php
// Ambil widget berdasarkan posisi
$widgets = \App\Models\Widget::aktif()
                              ->byPosition('sidebar-left')
                              ->orderBy('order')
                              ->get();

// Tampilkan di view
@foreach($widgets as $widget)
    @if($widget->type === 'html')
        <div class="widget">{!! $widget->content !!}</div>
    @elseif($widget->type === 'text')
        <div class="widget">{{ $widget->content }}</div>
    @elseif($widget->type === 'plugin')
        @if($widget->plugin_name)
            {!! view_widget_from_plugin($widget->plugin_name) !!}
        @endif
    @endif
@endforeach
```

### 7. Fungsi Helper Widget (Opsional)
Anda dapat membuat helper untuk mempermudah implementasi widget:

```php
if (!function_exists('display_widgets')) {
    /**
     * Fungsi untuk menampilkan widget berdasarkan posisi
     */
    function display_widgets($position, $wrapperClass = 'widget-container') {
        $widgets = \App\Models\Widget::aktif()
                                     ->byPosition($position)
                                     ->orderBy('order')
                                     ->get();
        
        $output = '<div class="'.$wrapperClass.'">';
        
        foreach($widgets as $widget) {
            $output .= '<div class="widget-'.$widget->type.' '.$widget->name.'">';
            
            if($widget->type === 'html') {
                $output .= $widget->content;
            } elseif($widget->type === 'text') {
                $output .= '<p>'.$widget->content.'</p>';
            } elseif($widget->type === 'plugin' && $widget->plugin_name) {
                // Implementasi untuk menampilkan widget plugin
                $output .= get_widget_content_from_plugin($widget->plugin_name);
            }
            
            $output .= '</div>';
        }
        
        $output .= '</div>';
        
        return $output;
    }
}
```

## Implementasi Lanjutan

### 1. Widget dengan Pengaturan
Gunakan field `settings` dalam JSON untuk menyimpan pengaturan widget:

```json
{
    "show_title": true,
    "show_border": false,
    "animation": "fade_in",
    "max_items": 5
}
```

Contoh implementasi:
```php
@if(isset($widget->settings['show_title']) && $widget->settings['show_title'])
    <h3>{{ $widget->name }}</h3>
@endif

@if(isset($widget->settings['max_items']))
    $items = get_items($widget->plugin_name, $widget->settings['max_items']);
@endif
```

### 2. Widget Dinamis
Buat widget yang dapat disesuaikan dengan konteks halaman:

```php
// Dalam controller
public function getDynamicContent($widget, $context = null) {
    if ($widget->type === 'plugin' && $widget->plugin_name) {
        $pluginClass = "App\\Plugins\\" . $widget->plugin_name . "\\Controllers\\" . $widget->plugin_name . "Controller";

        if (class_exists($pluginClass)) {
            $controller = new $pluginClass();

            // Kirim context jika tersedia
            if ($context) {
                return $controller->getWidgetContent($context);
            } else {
                return $controller->getWidgetContent();
            }
        }
    }

    return $widget->content;
}
```

### 3. Scheduler Widget
Anda bisa membuat widget yang aktif hanya dalam periode tertentu:

```php
// Tambahkan kolom publish_start dan publish_end di tabel
public function scopeActiveNow($query) {
    $now = now();
    return $query->where('status', 'aktif')
                 ->where(function($q) use ($now) {
                     $q->whereNull('publish_start')
                       ->orWhere('publish_start', '<=', $now);
                 })
                 ->where(function($q) use ($now) {
                     $q->whereNull('publish_end')
                       ->orWhere('publish_end', '>=', $now);
                 });
}
```

Dengan sistem widgets yang fleksibel ini, pengguna dapat mengelola elemen tampilan dinamis untuk berbagai keperluan, mulai dari informasi statis hingga elemen interaktif dari plugin.

## Contoh Implementasi: Widget Berita Terbaru

Sistem stelloCMS menyediakan contoh implementasi widget dalam plugin Berita. Widget ini menampilkan berita terbaru dalam bentuk ringkas yang dapat ditempatkan di sidebar atau area lain dalam sistem.

### Fitur Widget Berita Terbaru
- Menampilkan judul berita terbaru (default 5 berita)
- Menampilkan tanggal publikasi
- Link langsung ke halaman detail berita
- Responsive dan kompatibel dengan berbagai ukuran layar
- Dapat dikustomisasi jumlah berita yang ditampilkan

### Cara Membuat Widget Berita Terbaru
1. Pastikan plugin Berita sudah terinstal dan aktif
2. Akses halaman **Pengaturan** → **Widgets** 
3. Klik "Tambah Widget"
4. Isi form dengan:
   - Nama: "Berita Terbaru"
   - Tipe: "Plugin"
   - Posisi: Sesuai kebutuhan (misalnya 'sidebar-right')
   - Status: "Aktif"
   - Nama Plugin: "Berita" (atau sesuai dengan nama plugin berita Anda)
5. Simpan widget

Atau secara otomatis saat plugin Berita diinstal, widget "Berita Terbaru" akan dibuat secara otomatis dengan pengaturan default.

### Implementasi Plugin
Plugin Berita menyediakan method khusus untuk konten widget:
```php
// Dalam BeritaController
public function getLatestNewsWidget($limit = 5)
{
    $latestNews = Berita::where('aktif', true)
                        ->orderBy('tanggal_publikasi', 'desc')
                        ->limit($limit)
                        ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug']);
    
    return view('berita::widget.latest-news', compact('latestNews'))->render();
}
```

### Fungsi Helper
Plugin Berita juga menyediakan fungsi helper untuk mengakses widget:
```php
// Menggunakan fungsi helper
$widgetContent = get_latest_news_widget(5); // Menampilkan 5 berita terbaru
$widgetContent = get_popular_news_widget(5); // Menampilkan 5 berita populer

// Mengambil data berita terbaru
$latestNews = get_latest_news_data(10); // Mengambil 10 berita terbaru

// Mengambil data berita populer
$popularNews = get_popular_news_data(10); // Mengambil 10 berita populer
```

### Widget Berita Populer
Plugin Berita juga menyediakan widget khusus untuk menampilkan berita-berita yang paling banyak dilihat berdasarkan kolom 'viewer'. Widget ini menampilkan judul berita dan jumlah viewer untuk membantu pengguna mengetahui konten yang paling diminati.

#### Fitur Widget Berita Populer
- Menampilkan berita berdasarkan jumlah view/visitor (kolom 'viewer')
- Menampilkan jumlah viewer untuk setiap berita
- Menampilkan judul berita terpopuler
- Dapat dikustomisasi jumlah berita yang ditampilkan

#### Implementasi Plugin
Plugin berita menyediakan method khusus untuk widget populer:
```php
// Dalam BeritaController
public function getPopularNewsWidget($limit = 5)
{
    $popularNews = Berita::where('aktif', true)
                        ->orderBy('viewer', 'desc')
                        ->limit($limit)
                        ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug', 'viewer']);
    
    return view('berita::widget.popular-news', compact('popularNews'))->render();
}
```

#### Fungsi Helper Berita Populer
Plugin juga menyediakan helper function untuk widget berita populer:
```php
// Menggunakan fungsi helper
$widgetContent = get_popular_news_widget(5); // Menampilkan 5 berita populer
```

#### Widget Berita Acak
Plugin Berita juga menyediakan widget khusus untuk menampilkan berita yang dipilih secara acak. Widget ini secara khusus dirancang untuk menampilkan berita yang memiliki gambar, memberikan variasi tampilan konten yang menarik.

##### Fitur Widget Berita Acak
- Menampilkan berita secara acak dari kumpulan berita yang aktif
- Memastikan hanya menampilkan berita yang memiliki gambar
- Menampilkan judul berita dan tanggal publikasi
- Menyertakan gambar berita (jika tersedia) untuk tampilan visual yang menarik
- Dapat dikustomisasi jumlah berita yang ditampilkan (meskipun defaultnya hanya 1)

##### Implementasi Plugin
Plugin berita menyediakan method khusus untuk widget acak:
```php
// Dalam BeritaController
public function getRandomNewsWidget($limit = 1)
{
    // Hitung total berita yang aktif dan memiliki gambar
    $totalWithImages = Berita::where('aktif', true)
                              ->whereNotNull('gambar')
                              ->where('gambar', '!=', '')
                              ->count();

    if ($totalWithImages == 0) {
        return view('berita::widget.random-news', ['randomNews' => collect([])])->render();
    }

    // Ambil offset acak
    $randomOffset = rand(0, max(0, $totalWithImages - 1));
    
    $randomNews = Berita::where('aktif', true)
                       ->whereNotNull('gambar')
                       ->where('gambar', '!=', '')
                       ->offset($randomOffset)
                       ->limit($limit)
                       ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug']);

    return view('berita::widget.random-news', compact('randomNews'))->render();
}
```

##### Fungsi Helper Berita Acak
Plugin juga menyediakan helper function untuk widget berita acak:
```php
// Menggunakan fungsi helper
$widgetContent = get_random_news_widget(1); // Menampilkan 1 berita acak dengan gambar
$randomNewsData = get_random_news_data(1);  // Mengambil 1 berita acak dengan gambar dari database
```

Widget berita populer dan widget berita acak melengkapi sistem manajemen widgets di stelloCMS dan memberikan berbagai wawasan tentang konten yang diminati pengunjung serta menawarkan tampilan konten yang bervariasi.

Widget berita terbaru memberikan kemudahan dalam menampilkan konten dinamis dari plugin Berita ke dalam sistem widget stelloCMS, membuktikan integrasi yang kuat antara sistem plugin dan sistem widget.

## Fitur Otomatisasi

Salah satu keunggulan sistem ini adalah kemampuan membuat widget secara otomatis saat plugin diinstal. Saat plugin Berita diinstal melalui sistem manajemen plugin, tiga widget akan dibuat secara otomatis ke dalam sistem widgets:
- **Berita Terbaru**: Menampilkan 5 berita terbaru dengan default penempatan di sidebar kanan
- **Berita Populer**: Menampilkan 5 berita paling banyak dilihat dengan default penempatan di sidebar kanan
- **Berita Acak**: Menampilkan 1 berita acak yang memiliki gambar dengan default penempatan di sidebar kiri

Hal ini memudahkan administrator dalam menyiapkan elemen tampilan yang relevan tanpa perlu membuatnya secara manual.

## Tampilan dan Pengelolaan Widgets

Sistem widgets telah ditingkatkan dengan fitur tampilan yang lebih interaktif dan mudah digunakan.

### Tabs Berdasarkan Posisi
Halaman manajemen widgets kini dilengkapi dengan tabs yang memisahkan widget berdasarkan posisi, yaitu:
- **Header Widgets**: Widget yang ditampilkan di header halaman
- **Sidebar Left Widgets**: Widget yang ditampilkan di sidebar kiri
- **Sidebar Right Widgets**: Widget yang ditampilkan di sidebar kanan
- **Footer Widgets**: Widget yang ditampilkan di footer halaman
- **Home Widgets**: Widget yang ditampilkan di halaman utama

Fitur ini memungkinkan pengguna untuk lebih mudah mengelola dan melihat widget sesuai dengan posisinya masing-masing.

### Pengurutan Drag-and-Drop
Sistem widgets kini mendukung pengurutan widget dengan drag-and-drop yang lebih canggih. Pengguna dapat:
- Menggeser widget ke posisi yang diinginkan di dalam posisi yang sama
- **Menggeser widget dari satu posisi ke posisi lain** (misalnya dari sidebar kanan ke sidebar kiri atau dari footer ke header)
- Melihat perubahan secara real-time
- Menyimpan perubahan posisi dan urutan secara otomatis ke database
- Melihat nomor urutan pada setiap widget

Fitur ini meningkatkan pengalaman pengguna dalam mengorganisir tata letak elemen tampilan dengan fleksibilitas penuh.

### Tampilan Widget yang Ditingkatkan
- Widget ditampilkan dalam format card yang lebih informatif
- Informasi tipe widget, status, dan konten disajikan secara jelas
- Akses cepat ke fitur edit, lihat, dan hapus tersedia untuk setiap widget
- Tampilan yang responsif dan konsisten dengan sistem adminLTE

### Manajemen Widget Interaktif
Dengan sistem yang ditingkatkan, administrator dapat:
- Memindahkan widget antar posisi hanya dengan drag dan drop
- Memperbarui urutan widget secara real-time tanpa refresh halaman
- Memantau posisi dan urutan widget saat ini
- Mengakses fitur administrasi widget langsung dari tampilan

## Fitur Pemindahan Widget Antar Posisi

Sistem widgets juga mendukung pemindahan widget antar posisi yang berbeda hanya dengan menggunakan drag-and-drop. Fitur ini memungkinkan administrator untuk:
- Memindahkan widget dari satu posisi ke posisi lain tanpa harus mengedit widget secara manual
- Mengatur penempatan widget secara visual dan interaktif
- Mengubah urutan tampilan widget dalam satu posisi atau antar posisi secara bersamaan
- Menyimpan perubahan posisi dan urutan secara otomatis ke database

### Cara Menggunakan Fitur Pemindahan
1. Akses halaman **Pengaturan** → **Widgets** 
2. Klik pada tab posisi widget yang ingin Anda kelola
3. Untuk mengubah urutan dalam posisi yang sama: Geser widget ke atas atau bawah
4. Untuk memindahkan ke posisi lain: Geser widget ke tab posisi lain
5. Perubahan akan disimpan secara otomatis ke database
6. Tidak perlu refresh halaman karena semua perubahan disimpan secara real-time

Contoh penggunaan:
- Memindahkan widget dari sidebar kanan ke sidebar kiri: Geser widget dari tab "Sidebar Right" ke tab "Sidebar Left"
- Memindahkan widget dari header ke footer: Geser widget dari tab "Header Widgets" ke tab "Footer Widgets"
- Mengubah urutan widget di sidebar: Geser widget ke posisi yang diinginkan di dalam tab yang sama

Fitur ini memberikan fleksibilitas tinggi dalam pengelolaan elemen tampilan tanpa perlu mengedit atau mengatur ulang setiap widget secara terpisah.

## Perubahan Otomatis pada Instalasi Plugin

Saat plugin Berita diinstal melalui sistem manajemen plugin, secara otomatis akan dibuatkan tiga widget:
- **Berita Terbaru**: Menampilkan 5 berita terbaru
- **Berita Populer**: Menampilkan 5 berita paling banyak dilihat
- **Berita Acak**: Menampilkan 1 berita acak yang memiliki gambar

Ketiga widget ini dibuat dengan pengaturan default dan posisi yang optimal, memudahkan administrator dalam mengelola tampilan halaman tanpa perlu membuat widget secara manual.