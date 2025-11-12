# Sistem Menu Sidebar Admin untuk stelloCMS

## Daftar Isi
1. [Gambaran Umum](#gambaran-umum)
2. [Struktur Menu](#struktur-menu)
3. [Menu Statis](#menu-statis)
4. [Menu Dinamis dari Plugin](#menu-dinamis-dari-plugin)
5. [Implementasi Teknis](#implementasi-teknis)
6. [Manajemen Menu](#manajemen-menu)
7. [Hak Akses dan Role](#hak-akses-dan-role)
8. [Troubleshooting](#troubleshooting)
9. [Best Practices](#best-practices)

## Gambaran Umum

Sistem menu sidebar admin dalam stelloCMS merupakan komponen penting yang mengelola navigasi dan akses pengguna ke berbagai fitur sistem. Sistem ini mendukung kombinasi menu statis (yang didefinisikan dalam kode) dan menu dinamis (yang dihasilkan otomatis dari plugin).

### Fungsi Utama
- Menyediakan navigasi yang intuitif bagi pengguna admin
- Mengelola akses berdasarkan role pengguna
- Mengintegrasikan menu dari plugin-plugin yang terinstal
- Menyediakan pengelolaan menu secara dinamis

### Jenis Menu
- **Menu Statis**: Menu yang didefinisikan secara langsung dalam kode sistem utama
- **Menu Dinamis**: Menu yang dihasilkan otomatis saat plugin diinstal atau diaktifkan

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
    type ENUM('admin', 'frontend') DEFAULT 'admin',
    position ENUM('sidebar-left', 'sidebar-right', 'header', 'footer') DEFAULT 'sidebar-left',
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
- **type**: Tipe menu (admin/frontend)
- **position**: Posisi menu (sidebar-left, sidebar-right, header, footer)
- **created_at/updated_at**: Timestamp

## Menu Statis

Menu statis adalah menu yang didefinisikan secara langsung dalam kode sistem utama dan tidak berubah-ubah kecuali dilakukan perubahan pada kode.

### Contoh Menu Statis
```php
// Di database seeder atau PluginManager
[
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
        'type' => 'admin',
        'position' => 'sidebar-left'
    ],
    [
        'name' => 'manajemen_pengguna',
        'title' => 'Manajemen Pengguna',
        'route' => '#', // Menu parent tanpa route
        'icon' => 'fas fa-users',
        'parent_id' => null,
        'order' => 2,
        'is_active' => true,
        'plugin_name' => null,
        'roles' => json_encode(['admin']),
        'type' => 'admin',
        'position' => 'sidebar-left'
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
        'type' => 'admin',
        'position' => 'sidebar-left'
    ]
]
```

### Karakteristik Menu Statis
- Didefinisikan dalam kode sistem utama
- Tidak berubah-ubah kecuali perubahan kode
- Biasanya merupakan menu inti sistem
- Diinstal saat migrasi awal sistem
- Tidak terpengaruh oleh plugin

## Menu Dinamis dari Plugin

Menu dinamis adalah menu yang dihasilkan otomatis saat plugin diinstal atau diaktifkan, dan dihapus saat plugin diuninstall atau dinonaktifkan.

### Pembuatan Menu Otomatis
Ketika plugin diinstal, sistem secara otomatis membuat menu untuk plugin tersebut:

```php
protected function createPluginMenu($pluginName)
{
    // Remove existing menu if any
    $this->removePluginMenu($pluginName);

    // Create admin menu
    $adminMenu = new \App\Models\Menu([
        'name' => strtolower($pluginName),
        'title' => $this->getPluginTitle($pluginName),
        'route' => $this->getPluginRoute($pluginName),  // Contoh: panel.kategori.index
        'icon' => $this->getPluginIcon($pluginName),
        'plugin_name' => $pluginName,
        'type' => 'admin',
        'position' => 'sidebar-left', // Valid enum value for sidebar menu
        'is_active' => true,
        'order' => 0, // Default order
        'roles' => ['admin', 'administrator', 'adminstrator', 'operator'] // Updated roles for plugin management
    ]);

    $adminMenu->save();
}
```

### Contoh Menu Dinamis (dari Plugin Kategori)
```php
// Dihasilkan saat plugin Kategori diinstal
[
    'name' => 'kategori',
    'title' => 'Kategori',
    'route' => 'panel.kategori.index',
    'icon' => 'fas fa-tags',
    'parent_id' => null,
    'order' => 0,
    'is_active' => true,
    'plugin_name' => 'Kategori',
    'roles' => ['admin', 'administrator', 'adminstrator', 'operator'],
    'type' => 'admin',
    'position' => 'sidebar-left'
]
```

### Karakteristik Menu Dinamis
- Dibuat otomatis saat plugin diinstal
- Diupdate saat plugin diupdate
- Dihapus saat plugin diuninstall
- Terkait dengan nama plugin
- Dapat memiliki role khusus berdasarkan plugin
- Muncul dan hilang sesuai status plugin

## Implementasi Teknis

### Model Menu
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'route',
        'url',
        'icon',
        'parent_id',
        'order',
        'is_active',
        'plugin_name',
        'roles',
        'type',
        'position'
    ];

    protected $casts = [
        'roles' => 'array',
    ];

    /**
     * Get the parent menu item.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Scope to get only active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get main menus (no parent)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get frontend menus
     */
    public function scopeFrontend($query)
    {
        return $query->where('type', 'frontend');
    }

    /**
     * Scope to get admin menus
     */
    public function scopeAdmin($query)
    {
        return $query->where('type', 'admin');
    }

    /**
     * Scope to get menus by position
     */
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }
}
```

### Rendering Menu
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

## Manajemen Menu

### Melalui Antarmuka Admin
Sistem menyediakan antarmuka untuk:
1. Menambah menu baru (statik)
2. Mengedit menu yang ada
3. Menghapus menu
4. Mengatur urutan menu
5. Mengatur hierarki menu
6. Mengatur kontrol akses role

### Melalui Database
Menu dapat dikelola langsung melalui database:
```sql
-- Menambah menu statis
INSERT INTO menus (name, title, route, icon, parent_id, order, is_active, roles, type, position, created_at, updated_at)
VALUES ('contoh_menu', 'Contoh Menu', 'contoh.route', 'fas fa-cube', NULL, 10, TRUE, '["admin"]', 'admin', 'sidebar-left', NOW(), NOW());

-- Menonaktifkan menu
UPDATE menus SET is_active = FALSE WHERE name = 'nama_menu';

-- Mengatur hierarki
UPDATE menus SET parent_id = 1 WHERE id = 2; -- Menjadikan menu dengan id=2 sebagai submenu dari menu dengan id=1
```

## Hak Akses dan Role

### Role-based Access Control
Setiap menu dapat dibatasi aksesnya berdasarkan role pengguna:
```json
{
    "roles": ["admin", "kepala-desa", "sekdes"]
}
```

### Implementasi Hak Akses
```php
// Di middleware atau controller
$userRoles = auth()->user()->roles->pluck('name')->toArray();
$menuRoles = json_decode($menu->roles, true);

if (empty($menuRoles) || count(array_intersect($userRoles, $menuRoles)) > 0) {
    // User dapat mengakses menu
}
```

### Role Default untuk Plugin
Menu plugin secara default diberi role akses yang luas:
```php
'roles' => ['admin', 'administrator', 'adminstrator', 'operator']
```

## Troubleshooting

### Menu Tidak Muncul
- Periksa status `is_active` menu
- Cek apakah user memiliki role yang sesuai
- Pastikan route menu valid dan dapat diakses
- Bersihkan cache view dan route: `php artisan view:clear && php artisan route:clear`

### Menu Statis Tidak Tampil
- Pastikan menu sudah dimasukkan ke database
- Cek apakah tidak ada duplikasi nama
- Verifikasi role yang ditetapkan

### Menu Plugin Tidak Muncul
- Pastikan plugin sudah diinstal dan diaktifkan
- Cek apakah route plugin sudah ditambahkan ke `routes/panel.php`
- Periksa apakah menu dibuat saat instalasi plugin
- Bersihkan cache konfigurasi dan route

### Hierarki Menu Tidak Benar
- Periksa field `parent_id` di database
- Pastikan menu induk dalam status aktif
- Cek apakah menu induk dan anak memiliki role yang konsisten

### Error saat Rendering Menu
- Pastikan role pengguna sesuai dengan hak akses menu
- Cek apakah route eksis dan dapat diakses
- Verifikasi bahwa plugin terkait aktif (jika menu plugin)

## Best Practices

### Penamaan Menu
- Gunakan nama yang deskriptif dan unik
- Gunakan huruf kecil dengan pemisah underscore untuk field `name`
- Gunakan title case untuk field `title`

### Struktur Hierarki
- Batasi kedalaman menu hingga 3 level
- Gunakan icon yang konsisten dan mudah dikenali
- Urutkan menu berdasarkan prioritas penggunaan
- Kelompokkan menu terkait dalam satu parent

### Hak Akses
- Selalu tentukan role untuk menu sensitif
- Gunakan array kosong untuk menu publik
- Pertimbangkan inheritansi role (admin dapat mengakses semua menu)
- Perbarui kontrol akses saat menambah/menghapus role

### Integrasi Plugin
- Plugin harus membuat menu secara otomatis saat diinstal
- Menu plugin harus dihapus saat plugin dihapus
- Gunakan icon yang sesuai dengan fungsi plugin
- Batasi akses menu plugin sesuai dengan kebutuhan

### Performance
- Hanya tampilkan menu yang aktif
- Gunakan eager loading untuk relasi menu
- Implementasikan caching untuk menu yang sering diakses
- Gunakan pagination jika jumlah menu sangat banyak

### Security
- Validasi role saat rendering menu
- Pastikan menu tidak mengekspos endpoint sensitif
- Gunakan penamaan route yang aman
- Implementasikan akses kontrol ganda di level controller

## Konfigurasi Tambahan

### Urutan Menu
Menu diurutkan berdasarkan field `order` dalam database:
```sql
SELECT * FROM menus WHERE is_active = TRUE ORDER BY order ASC;
```

### Submenu
Gunakan field `parent_id` untuk membuat submenu:
- Menu utama memiliki `parent_id = NULL`
- Submenu memiliki `parent_id` merujuk ke ID menu induk

### Tipe dan Posisi
- `type`: 'admin' untuk menu admin, 'frontend' untuk menu publik
- `position`: 'sidebar-left', 'sidebar-right', 'header', 'footer'

## Perubahan Penting

### Versi 1.1.0
- Menambahkan field `type` dan `position` untuk fleksibilitas menu
- Memperbarui role default untuk menu plugin menjadi lebih luas
- Menambahkan validasi tambahan untuk menu plugin

### Integrasi dengan Plugin
- Menu plugin dibuat otomatis saat instalasi
- Menu plugin dihapus saat plugin diuninstall
- Validasi status plugin saat rendering menu

## Pengembangan Lebih Lanjut

### Menu API
```php
// Endpoint API untuk mendapatkan menu
Route::get('/api/menus', function() {
    $user = auth()->user();
    $userRoles = $user->roles->pluck('name')->toArray();

    $menus = Menu::whereNull('parent_id')
                 ->where('is_active', true)
                 ->where('type', 'admin')
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
    public function getActiveAdminMenus()
    {
        return Cache::remember('active_admin_menus', 3600, function() {
            return Menu::where('is_active', true)
                       ->where('type', 'admin')
                       ->where('position', 'sidebar-left')
                       ->with('children')
                       ->orderBy('order')
                       ->get();
        });
    }

    public function clearCache()
    {
        Cache::forget('active_admin_menus');
        Cache::forget('active_frontend_menus');
    }
}
```