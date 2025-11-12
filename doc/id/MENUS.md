# Dokumentasi Sistem Menu stelloCMS

## Gambaran Umum

Sistem menu stelloCMS adalah komponen inti yang mengelola navigasi dan akses pengguna ke berbagai fitur sistem. Sistem ini mendukung menu hierarkis, kontrol akses berbasis role, dan integrasi otomatis dengan plugin.

## Struktur Menu

### Tabel Database
```sql
CREATE TABLE menus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    route VARCHAR(255) NOT NULL,
    icon VARCHAR(255) NULL,
    parent_id BIGINT UNSIGNED NULL,
    order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    plugin_name VARCHAR(255) NULL,
    roles JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (parent_id) REFERENCES menus(id) ON DELETE CASCADE
);
```

### Field-field Menu
- **id**: ID unik menu (auto increment)
- **name**: Nama teknis menu (digunakan untuk identifikasi)
- **title**: Judul menu yang ditampilkan kepada pengguna
- **route**: Nama route Laravel yang dituju
- **icon**: Icon Font Awesome untuk menu
- **parent_id**: ID menu induk (untuk submenu)
- **order**: Urutan tampilan menu
- **is_active**: Status aktif menu
- **plugin_name**: Nama plugin yang terkait (jika ada)
- **roles**: Array JSON role yang dapat mengakses menu
- **created_at/updated_at**: Timestamp

## Hirarki Menu

### Struktur Menu Bertingkat
```
Dashboard
├── Statistik
├── Laporan
└── Pengaturan
Manajemen Pengguna
├── Pengguna
├── Role
└── Hak Akses
Manajemen Konten
├── Berita
├── Pengumuman
└── Galeri
Plugin
├── Manajemen Plugin
└── Manajemen Tema
```

### Relasi Parent-Child
- Menu utama memiliki `parent_id` NULL
- Submenu memiliki `parent_id` yang merujuk ke ID menu induk
- Satu menu dapat memiliki banyak submenu
- Submenu dapat memiliki submenu lagi (nested menu)

## Kontrol Akses Menu

### Role-based Access Control
Setiap menu dapat dibatasi aksesnya berdasarkan role pengguna:
```json
{
    "roles": ["admin", "kepala-desa", "sekdes"]
}
```

### Implementasi Kontrol Akses
```php
// Di middleware atau controller
$userRoles = auth()->user()->roles->pluck('name')->toArray();
$menuRoles = json_decode($menu->roles, true);

if (empty($menuRoles) || count(array_intersect($userRoles, $menuRoles)) > 0) {
    // User dapat mengakses menu
}
```

## Integrasi Plugin dengan Menu

### Pembuatan Menu Otomatis
Ketika plugin diinstal, sistem secara otomatis membuat menu untuk plugin tersebut:
```php
protected function createPluginMenu($pluginName)
{
    $menu = new \App\Models\Menu([
        'name' => strtolower($pluginName),
        'title' => $this->getPluginTitle($pluginName),
        'route' => $this->getPluginRoute($pluginName),
        'icon' => $this->getPluginIcon($pluginName),
        'plugin_name' => $pluginName,
        'is_active' => true,
        'roles' => ['admin', 'kepala-desa', 'sekdes']
    ]);
    
    $menu->save();
}
```

### Penghapusan Menu Otomatis
Ketika plugin dihapus, menu terkait juga dihapus:
```php
protected function removePluginMenu($pluginName)
{
    \App\Models\Menu::where('plugin_name', $pluginName)->delete();
}
```

## Manajemen Menu

### Backend Menu Management
Panel administrasi menyediakan interface untuk:
1. Menambah menu baru
2. Mengedit menu yang ada
3. Menghapus menu
4. Mengatur urutan menu
5. Mengatur hierarki menu
6. Mengatur kontrol akses role

### Menu CRUD Operations

#### Membuat Menu Baru
```php
$menu = new Menu([
    'name' => 'berita',
    'title' => 'Manajemen Berita',
    'route' => 'berita.index',
    'icon' => 'fas fa-newspaper',
    'parent_id' => null,
    'order' => 1,
    'is_active' => true,
    'plugin_name' => 'Berita',
    'roles' => json_encode(['admin', 'kepala-desa', 'sekdes'])
]);

$menu->save();
```

#### Mengedit Menu
```php
$menu = Menu::find($id);
$menu->update([
    'title' => 'Berita dan Pengumuman',
    'order' => 2,
    'roles' => json_encode(['admin', 'kepala-desa', 'sekdes', 'kaur'])
]);
```

#### Menghapus Menu
```php
$menu = Menu::find($id);
$menu->delete(); // Akan menghapus submenu juga karena cascade
```

## Frontend Menu Rendering

### Helper Menu Rendering
```php
function render_menu($parentId = null, $depth = 0)
{
    $menus = Menu::where('parent_id', $parentId)
                 ->where('is_active', true)
                 ->orderBy('order')
                 ->get();
    
    foreach ($menus as $menu) {
        // Cek akses berdasarkan role
        if (can_access_menu($menu)) {
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="' . route($menu->route) . '">';
            echo '<i class="nav-icon ' . $menu->icon . '"></i>';
            echo '<p>' . $menu->title . '</p>';
            echo '</a>';
            
            // Render submenu jika ada
            if (has_submenu($menu->id)) {
                echo '<ul class="nav nav-treeview">';
                render_menu($menu->id, $depth + 1);
                echo '</ul>';
            }
            
            echo '</li>';
        }
    }
}
```

### View Menu dengan Blade
```blade
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
    @foreach($menus as $menu)
        @if(empty($menu->roles) || (auth()->user() && auth()->user()->role && in_array(auth()->user()->role->name, $menu->roles)))
            @if(!$menu->route || (Route::has($menu->route) && (!$menu->plugin_name || (app(App\Services\PluginManager::class)->isPluginActive($menu->plugin_name)))))
                <li class="nav-item">
                    @if($menu->route)
                        <a href="{{ route($menu->route) }}" class="nav-link">
                    @else
                        <a href="{{ $menu->url }}" class="nav-link">
                    @endif
                        <i class="nav-icon {{ $menu->icon }}"></i>
                        <p>{{ $menu->title }}</p>
                    </a>
                    
                    {{-- Render submenu --}}
                    @if($menu->children->count() > 0)
                        <ul class="nav nav-treeview">
                            @foreach($menu->children as $submenu)
                                @if(empty($submenu->roles) || (auth()->user() && auth()->user()->role && in_array(auth()->user()->role->name, $submenu->roles)))
                                    @if(!$submenu->route || (Route::has($submenu->route) && (!$submenu->plugin_name || (app(App\Services\PluginManager::class)->isPluginActive($submenu->plugin_name)))))
                                        <li class="nav-item">
                                            @if($submenu->route)
                                                <a href="{{ route($submenu->route) }}" class="nav-link">
                                            @else
                                                <a href="{{ $submenu->url }}" class="nav-link">
                                            @endif
                                                <i class="nav-icon {{ $submenu->icon }}"></i>
                                                <p>{{ $submenu->title }}</p>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endif
    @endforeach
</ul>
```

## Model Menu

### Definisi Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'title',
        'route',
        'icon',
        'parent_id',
        'order',
        'is_active',
        'plugin_name',
        'roles'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'roles' => 'array'
    ];
    
    /**
     * Get parent menu
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
    
    /**
     * Get child menus
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }
    
    /**
     * Scope for active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope for main menus (without parent)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }
}
```

## Seeder Menu Default

### Menu Default untuk Sistem Inti
```php
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            [
                'name' => 'dashboard',
                'title' => 'Dashboard',
                'route' => 'panel.dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'parent_id' => null,
                'order' => 1,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin', 'kepala-desa', 'sekdes', 'kaur', 'kadus', 'rw', 'rt']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'manajemen_pengguna',
                'title' => 'Manajemen Pengguna',
                'route' => '#',
                'icon' => 'fas fa-users',
                'parent_id' => null,
                'order' => 2,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'pengguna',
                'title' => 'Pengguna',
                'route' => 'users.index',
                'icon' => 'fas fa-user',
                'parent_id' => 2, // ID menu manajemen_pengguna
                'order' => 1,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'role',
                'title' => 'Role',
                'route' => 'roles.index',
                'icon' => 'fas fa-user-tag',
                'parent_id' => 2, // ID menu manajemen_pengguna
                'order' => 2,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'manajemen_konten',
                'title' => 'Manajemen Konten',
                'route' => '#',
                'icon' => 'fas fa-file-alt',
                'parent_id' => null,
                'order' => 3,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'berita',
                'title' => 'Berita',
                'route' => 'berita.index',
                'icon' => 'fas fa-newspaper',
                'parent_id' => 5, // ID menu manajemen_konten
                'order' => 1,
                'is_active' => true,
                'plugin_name' => 'Berita',
                'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'plugin',
                'title' => 'Plugin',
                'route' => 'plugins.index',
                'icon' => 'fas fa-plug',
                'parent_id' => null,
                'order' => 4,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin']),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'tema',
                'title' => 'Tema',
                'route' => 'themes.index',
                'icon' => 'fas fa-paint-brush',
                'parent_id' => null,
                'order' => 5,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin']),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Insert menus
        DB::table('menus')->insert($menus);
    }
}
```

## Best Practices

### Penamaan Menu
- Gunakan nama yang deskriptif dan unik
- Hindari karakter spesial dalam field `name`
- Gunakan huruf kecil dengan pemisah underscore untuk `name`
- Gunakan title case untuk field `title`

### Struktur Hierarki
- Batasi kedalaman menu hingga 3 level
- Gunakan icon yang konsisten dan mudah dikenali
- Urutkan menu berdasarkan prioritas penggunaan
- Kelompokkan menu terkait dalam satu parent

### Kontrol Akses
- Selalu tentukan role untuk menu sensitif
- Gunakan array kosong untuk menu publik
- Pertimbangkan inheritansi role (admin dapat mengakses semua menu)
- Perbarui kontrol akses saat menambah/menghapus role

### Integrasi Plugin
- Plugin harus membuat menu secara otomatis saat diinstal
- Menu plugin harus dihapus saat plugin dihapus
- Gunakan icon yang sesuai dengan fungsi plugin
- Batasi akses menu plugin sesuai dengan kebutuhan

## Troubleshooting

### Menu Tidak Muncul
- Periksa status `is_active` menu
- Cek apakah user memiliki role yang sesuai
- Pastikan route menu valid dan dapat diakses
- Bersihkan cache view dan route

### Menu Tidak Terurut
- Periksa field `order` pada tabel menu
- Pastikan tidak ada duplikasi nilai `order`
- Bersihkan cache konfigurasi

### Submenu Tidak Muncul
- Periksa relasi `parent_id`
- Pastikan menu induk dalam status aktif
- Cek kontrol akses untuk submenu

### Icon Tidak Muncul
- Pastikan icon Font Awesome tersedia
- Periksa format icon (harus dimulai dengan `fas fa-`)
- Bersihkan cache browser

## Perubahan Penting

### Perubahan Menu (Versi 1.1.0)
- Mengganti menu "Berita Desa" yang spesifik dengan menu "Berita" yang umum
- Menu "Berita" sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Menghapus menu "BeritaDesa" yang tidak digunakan untuk mengurangi kompleksitas sistem

### Perubahan Tema (Versi 1.1.0)
- Mengganti tema admin default dari CoreUI ke AdminLTE untuk stabilitas yang lebih baik
- Menghapus tema CoreUI yang tidak digunakan untuk mengurangi ukuran sistem
- Menyederhanakan struktur tema untuk kemudahan pemeliharaan

## Dokumentasi Lengkap

Untuk dokumentasi lengkap tentang sistem menu sidebar admin yang mencakup menu statis dan dinamis dari plugin, lihat [Sistem-Menu-Sidebar-Admin.md](../Sistem-Menu-Sidebar-Admin.md).

## Sistem Widgets

Sistem widgets adalah komponen tambahan yang menyediakan manajemen elemen tampilan yang dapat ditampilkan di berbagai posisi dalam sistem. Widget mendukung tiga jenis konten: plugin, teks, dan HTML, serta dapat ditempatkan di posisi header, sidebar-kiri, sidebar-kanan, footer, atau home.

### Fitur Widget
- **Tipe Konten**: Mendukung widget plugin, teks, dan HTML
- **Penempatan**: Dapat ditempatkan di lima posisi berbeda
- **Manajemen**: Sistem CRUD lengkap untuk mengelola widget
- **Pengaturan**: Dukungan pengaturan spesifik per widget (JSON)
- **Pemfilteran**: Filter berdasarkan status (aktif/nonaktif), posisi, dan tipe

### Integrasi dengan Menu
Widget diakses melalui menu **Pengaturan** → **Widgets** di sidebar admin. Menu ini secara otomatis ditambahkan ke dalam sistem dan hanya dapat diakses oleh role admin dan operator.

### Implementasi
Widget dapat diimplementasikan di frontend dengan fungsi helper khusus atau dengan mengambil data langsung dari model `Widget`. Sistem ini memungkinkan pengelolaan elemen tampilan dinamis tanpa mengubah kode utama.

Untuk dokumentasi lengkap tentang sistem widgets, lihat [Sistem-Widgets-Dokumentasi.md](../Sistem-Widgets-Dokumentasi.md).

## Pengembangan Lebih Lanjut

### Extending Menu Model
```php
// Menambahkan method kustom ke model Menu
class Menu extends Model
{
    // Method untuk mendapatkan menu berdasarkan role
    public static function forRole($roleName)
    {
        return self::where('is_active', true)
                   ->where(function($query) use ($roleName) {
                       $query->whereNull('roles')
                             ->orWhere('roles', 'like', '%"'.$roleName.'"%');
                   })
                   ->orderBy('order')
                   ->get();
    }
    
    // Method untuk mengecek apakah menu memiliki submenu
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
}
```

### Menu API
```php
// Endpoint API untuk mendapatkan menu
Route::get('/api/menus', function() {
    $user = auth()->user();
    $userRoles = $user->roles->pluck('name')->toArray();
    
    $menus = Menu::whereNull('parent_id')
                 ->where('is_active', true)
                 ->orderBy('order')
                 ->get()
                 ->filter(function($menu) use ($userRoles) {
                     return empty($menu->roles) || 
                            count(array_intersect($userRoles, json_decode($menu->roles, true))) > 0;
                 });
                 
    return response()->json($menus);
});
```

### Menu Caching
```php
// Caching menu untuk meningkatkan performa
class MenuService
{
    public function getActiveMenus()
    {
        return Cache::remember('active_menus', 3600, function() {
            return Menu::where('is_active', true)
                       ->with('children')
                       ->orderBy('order')
                       ->get();
        });
    }
    
    public function clearCache()
    {
        Cache::forget('active_menus');
    }
}
```