# Dokumentasi Sistem Plugin stelloCMS

## Gambaran Umum

Sistem plugin stelloCMS memungkinkan ekstensi fungsionalitas sistem melalui plugin modular yang dapat diinstal, diaktifkan, dan dihapus secara dinamis. Sistem ini mendukung berbagai jenis plugin dengan struktur yang fleksibel dan integrasi yang mudah.

## Arsitektur Plugin

### Struktur Direktori Plugin
```
/app/Plugins/
└── {PluginName}/
    ├── Controllers/
    │   └── {PluginName}Controller.php
    ├── Models/
    │   └── {ModelName}.php
    ├── Views/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── show.blade.php
    ├── Database/
    │   ├── Migrations/
    │   │   └── {timestamp}_{description}_table.php
    │   └── Seeders/
    │       └── {SeederName}.php
    ├── routes.php
    ├── plugin.json
    ├── helpers.php (opsional)
    └── README.md (opsional)
```

### File Konfigurasi Plugin (plugin.json)
Setiap plugin harus memiliki file `plugin.json` yang berisi informasi metadata:
```json
{
    "name": "Nama Plugin",
    "version": "1.0.0",
    "description": "Deskripsi plugin",
    "author": "Nama Pembuat",
    "author_url": "https://website.com",
    "required_version": "1.0.0",
    "database": {
        "migrations": "Database/Migrations",
        "seeders": "Database/Seeders"
    }
}
```

## Plugin Manager

### Fungsi Utama PluginManager
```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PluginManager
{
    protected $pluginsPath;
    
    public function __construct()
    {
        $this->pluginsPath = app_path('Plugins');
    }
    
    /**
     * Get all plugins from filesystem
     */
    public function getPlugins()
    {
        $plugins = [];
        
        if (!File::exists($this->pluginsPath)) {
            return $plugins;
        }
        
        foreach (File::directories($this->pluginsPath) as $pluginPath) {
            $pluginName = basename($pluginPath);
            
            // Check if plugin has metadata
            $pluginJsonPath = $pluginPath . '/plugin.json';
            $metadata = [];
            
            if (File::exists($pluginJsonPath)) {
                $metadata = json_decode(File::get($pluginJsonPath), true);
            }
            
            // Check if plugin is installed and active from database
            $pluginRecord = \App\Models\Plugin::where('name', $pluginName)->first();
            
            $plugins[] = [
                'name' => $pluginName,
                'path' => $pluginPath,
                'metadata' => $metadata,
                'installed' => $pluginRecord ? $pluginRecord->installed : false,
                'active' => $pluginRecord ? $pluginRecord->active : false,
            ];
        }
        
        return $plugins;
    }
    
    /**
     * Install a plugin
     */
    public function installPlugin($pluginName)
    {
        // Check if plugin exists in filesystem
        $pluginPath = $this->pluginsPath . '/' . $pluginName;
        if (!File::exists($pluginPath)) {
            return false;
        }
        
        // Find or create plugin record
        $plugin = \App\Models\Plugin::firstOrNew(['name' => $pluginName]);
        $plugin->installed = true;
        $plugin->active = true; // Activate by default when installing
        $plugin->save();
        
        // Handle database tables for specific plugins
        if ($pluginName === 'Berita') {
            $this->createOrUpdateBeritaTable();
        }
        
        // Create menu for the plugin
        $this->createPluginMenu($pluginName);
        
        return true;
    }
    
    /**
     * Uninstall a plugin
     */
    public function uninstallPlugin($pluginName)
    {
        // Delete plugin record from database
        \App\Models\Plugin::where('name', $pluginName)->delete();
        
        // Remove menu for the plugin
        $this->removePluginMenu($pluginName);
        
        // Note: We don't drop the tables to preserve data
        // If you want to drop tables, uncomment the following lines:
        // if ($pluginName === 'Berita') {
        //     \DB::statement('DROP TABLE IF EXISTS `berita`');
        // }
        
        return true;
    }
    
    /**
     * Activate a plugin
     */
    public function activatePlugin($pluginName)
    {
        $plugin = \App\Models\Plugin::where('name', $pluginName)->first();
        if ($plugin) {
            $plugin->active = true;
            $plugin->save();
            
            // Ensure menu is created
            $this->createPluginMenu($pluginName);
            
            return true;
        }
        return false;
    }
    
    /**
     * Deactivate a plugin
     */
    public function deactivatePlugin($pluginName)
    {
        $plugin = \App\Models\Plugin::where('name', $pluginName)->first();
        if ($plugin) {
            $plugin->active = false;
            $plugin->save();
            return true;
        }
        return false;
    }
    
    /**
     * Create or update berita table
     */
    protected function createOrUpdateBeritaTable()
    {
        // Check if berita table exists
        $tableExists = \DB::select("SHOW TABLES LIKE 'berita'");
        
        if (empty($tableExists)) {
            // Create berita table
            \DB::statement("
                CREATE TABLE `berita` (
                    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `judul` VARCHAR(255) NOT NULL,
                    `isi` TEXT NOT NULL,
                    `gambar` VARCHAR(255) NULL,
                    `tanggal_publikasi` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `aktif` TINYINT(1) DEFAULT 1,
                    `user_id` BIGINT UNSIGNED NULL,
                    `created_at` TIMESTAMP NULL DEFAULT NULL,
                    `updated_at` TIMESTAMP NULL DEFAULT NULL,
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        } else {
            // Check if columns exist and add them if missing
            $columns = \DB::select("SHOW COLUMNS FROM `berita`");
            $columnNames = array_column($columns, 'Field');
            
            // Add missing columns if needed
            if (!in_array('judul', $columnNames)) {
                \DB::statement("ALTER TABLE `berita` ADD COLUMN `judul` VARCHAR(255) NOT NULL");
            }
            
            if (!in_array('isi', $columnNames)) {
                \DB::statement("ALTER TABLE `berita` ADD COLUMN `isi` TEXT NOT NULL");
            }
            
            if (!in_array('gambar', $columnNames)) {
                \DB::statement("ALTER TABLE `berita` ADD COLUMN `gambar` VARCHAR(255) NULL");
            }
            
            if (!in_array('tanggal_publikasi', $columnNames)) {
                \DB::statement("ALTER TABLE `berita` ADD COLUMN `tanggal_publikasi` TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
            }
            
            if (!in_array('aktif', $columnNames)) {
                \DB::statement("ALTER TABLE `berita` ADD COLUMN `aktif` TINYINT(1) DEFAULT 1");
            }
            
            if (!in_array('user_id', $columnNames)) {
                \DB::statement("ALTER TABLE `berita` ADD COLUMN `user_id` BIGINT UNSIGNED NULL");
                \DB::statement("ALTER TABLE `berita` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL");
            }
        }
    }
    
    /**
     * Create menu for a plugin
     */
    protected function createPluginMenu($pluginName)
    {
        // Remove existing menu if any
        $this->removePluginMenu($pluginName);
        
        // Create new menu
        $menu = new \App\Models\Menu([
            'name' => strtolower($pluginName),
            'title' => $this->getPluginTitle($pluginName),
            'route' => $this->getPluginRoute($pluginName),
            'icon' => $this->getPluginIcon($pluginName),
            'plugin_name' => $pluginName,
            'is_active' => true,
            'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']) // Default roles for plugin management
        ]);
        
        $menu->save();
    }
    
    /**
     * Remove menu for a plugin
     */
    protected function removePluginMenu($pluginName)
    {
        \App\Models\Menu::where('plugin_name', $pluginName)->delete();
    }
    
    /**
     * Get plugin title from metadata or generate from name
     */
    protected function getPluginTitle($pluginName)
    {
        $pluginPath = $this->pluginsPath . '/' . $pluginName;
        $pluginJsonPath = $pluginPath . '/plugin.json';
        
        if (File::exists($pluginJsonPath)) {
            $metadata = json_decode(File::get($pluginJsonPath), true);
            if (isset($metadata['name'])) {
                return $metadata['name'];
            }
        }
        
        // Convert camelCase to spaced words
        $spacedName = preg_replace('/([a-z])([A-Z])/', '$1 $2', $pluginName);
        return Str::title(str_replace(['-', '_'], ' ', $spacedName));
    }
    
    /**
     * Get plugin route
     */
    protected function getPluginRoute($pluginName)
    {
        // Default plugin route based on plugin name
        $lowerPluginName = strtolower($pluginName);
        
        // Special cases for specific plugins
        switch ($pluginName) {
            case 'Berita':
                return 'berita.index';
            default:
                // For other plugins, use a generic pattern
                return $lowerPluginName . '.index';
        }
    }
    
    /**
     * Get plugin icon
     */
    protected function getPluginIcon($pluginName)
    {
        // Default icons for specific plugins
        $iconMap = [
            'Berita' => 'fas fa-newspaper',
            'Pengumuman' => 'fas fa-bullhorn',
            'Keuangan' => 'fas fa-money-bill-wave',
            'Surat' => 'fas fa-envelope',
        ];
        
        return $iconMap[$pluginName] ?? 'fas fa-cube';
    }
    
    /**
     * Get plugin info
     */
    public function getPluginInfo($pluginName)
    {
        $pluginPath = $this->pluginsPath . '/' . $pluginName;
        if (!File::exists($pluginPath)) {
            return null;
        }
        
        $pluginJsonPath = $pluginPath . '/plugin.json';
        $metadata = [];
        
        if (File::exists($pluginJsonPath)) {
            $metadata = json_decode(File::get($pluginJsonPath), true);
        }
        
        $pluginRecord = \App\Models\Plugin::where('name', $pluginName)->first();
        
        return [
            'name' => $pluginName,
            'path' => $pluginPath,
            'metadata' => $metadata,
            'installed' => $pluginRecord ? $pluginRecord->installed : false,
            'active' => $pluginRecord ? $pluginRecord->active : false,
        ];
    }
    
    /**
     * Load a plugin
     */
    public function loadPlugin($pluginName)
    {
        $pluginPath = $this->pluginsPath . '/' . $pluginName;
        if (!File::exists($pluginPath)) {
            return false;
        }
        
        // Load plugin helpers if they exist
        $helpersPath = $pluginPath . '/helpers.php';
        if (File::exists($helpersPath)) {
            require_once $helpersPath;
        }
        
        // Load plugin routes if they exist
        $routesPath = $pluginPath . '/routes.php';
        if (File::exists($routesPath)) {
            require_once $routesPath;
        }
        
        return true;
    }
}
```

## Pembuatan Plugin Baru

### Langkah-langkah Membuat Plugin
1. Buat folder plugin di `/app/Plugins/`
2. Tambahkan file `plugin.json` dengan informasi plugin
3. Buat controller, model, dan view yang diperlukan
4. Tambahkan file `routes.php` untuk routing plugin
5. Tambahkan migrasi database jika diperlukan
6. Plugin akan terdeteksi secara otomatis

### Contoh plugin.json
```json
{
    "name": "Berita",
    "version": "1.0.0",
    "description": "Plugin untuk mengelola berita dan informasi",
    "author": "stelloCMS Development Team",
    "author_url": "https://simpede.id",
    "required_version": "1.0.0",
    "database": {
        "migrations": "Database/Migrations",
        "seeders": "Database/Seeders"
    }
}
```

### Contoh Controller Plugin
```php
<?php

namespace App\Plugins\Berita\Controllers;

use App\Plugins\Berita\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('aktif', true)->orderBy('tanggal_publikasi', 'desc')->paginate(10);
        
        return view_theme('admin', 'berita.index', compact('berita'));
    }
    
    public function create()
    {
        return view_theme('admin', 'berita.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_publikasi' => 'required|date',
            'aktif' => 'nullable|boolean',
        ]);
        
        $data = $request->all();
        $data['aktif'] = $request->has('aktif') ? true : false;
        
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $gambarPath;
        }
        
        // Set user_id if available
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }
        
        Berita::create($data);
        
        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }
    
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        
        return view_theme('admin', 'berita.show', compact('berita'));
    }
    
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        
        return view_theme('admin', 'berita.edit', compact('berita'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_publikasi' => 'required|date',
            'aktif' => 'nullable|boolean',
        ]);
        
        $berita = Berita::findOrFail($id);
        $data = $request->all();
        $data['aktif'] = $request->has('aktif') ? true : false;
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
                unlink(storage_path('app/public/' . $berita->gambar));
            }
            
            $gambarPath = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $gambarPath;
        }
        
        // Set user_id if available
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }
        
        $berita->update($data);
        
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
            unlink(storage_path('app/public/' . $berita->gambar));
        }
        
        $berita->delete();
        
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
```

### Contoh Model Plugin
```php
<?php

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
    
    /**
     * Get the user that owns the berita.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
```

### Contoh routes.php Plugin
```php
<?php

use App\Plugins\Berita\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

// Rute untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/berita')->middleware(['auth'])->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/{id}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
});
```

### Contoh Migrasi Plugin
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
```

## Manajemen Plugin

### Instalasi Plugin
Melalui panel administrasi:
1. Buka menu "Plugin"
2. Klik tombol "Instal" pada plugin yang diinginkan
3. Plugin akan diinstal dan diaktifkan secara otomatis

Melalui command line:
```bash
php artisan plugin:install {plugin_name}
```

### Aktivasi Plugin
Melalui panel administrasi:
1. Buka menu "Plugin"
2. Klik tombol "Aktifkan" pada plugin yang diinginkan

Melalui command line:
```bash
php artisan plugin:activate {plugin_name}
```

### Deaktivasi Plugin
Melalui panel administrasi:
1. Buka menu "Plugin"
2. Klik tombol "Nonaktifkan" pada plugin yang diinginkan

Melalui command line:
```bash
php artisan plugin:deactivate {plugin_name}
```

### Penghapusan Plugin
Melalui panel administrasi:
1. Buka menu "Plugin"
2. Klik tombol "Hapus" pada plugin yang diinginkan
3. Plugin akan dihapus dari sistem (data dapat dipertahankan)

Melalui command line:
```bash
php artisan plugin:uninstall {plugin_name}
```

## Integrasi Menu Plugin

### Pembuatan Menu Otomatis
Ketika plugin diinstal, sistem secara otomatis membuat menu untuk plugin tersebut:
```php
protected function createPluginMenu($pluginName)
{
    // Remove existing menu if any
    $this->removePluginMenu($pluginName);
    
    // Create new menu
    $menu = new \App\Models\Menu([
        'name' => strtolower($pluginName),
        'title' => $this->getPluginTitle($pluginName),
        'route' => $this->getPluginRoute($pluginName),
        'icon' => $this->getPluginIcon($pluginName),
        'plugin_name' => $pluginName,
        'is_active' => true,
        'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']) // Default roles for plugin management
    ]);
    
    $menu->save();
}
```

### Konfigurasi Menu Plugin
Setiap plugin dapat memiliki konfigurasi menu khusus:
```php
protected function getPluginTitle($pluginName)
{
    $pluginPath = $this->pluginsPath . '/' . $pluginName;
    $pluginJsonPath = $pluginPath . '/plugin.json';
    
    if (File::exists($pluginJsonPath)) {
        $metadata = json_decode(File::get($pluginJsonPath), true);
        if (isset($metadata['name'])) {
            return $metadata['name'];
        }
    }
    
    // Convert camelCase to spaced words
    $spacedName = preg_replace('/([a-z])([A-Z])/', '$1 $2', $pluginName);
    return Str::title(str_replace(['-', '_'], ' ', $spacedName));
}

protected function getPluginRoute($pluginName)
{
    // Default plugin route based on plugin name
    $lowerPluginName = strtolower($pluginName);
    
    // Special cases for specific plugins
    switch ($pluginName) {
        case 'Berita':
            return 'berita.index';
        default:
            // For other plugins, use a generic pattern
            return $lowerPluginName . '.index';
    }
}

protected function getPluginIcon($pluginName)
{
    // Default icons for specific plugins
    $iconMap = [
        'Berita' => 'fas fa-newspaper',
        'Pengumuman' => 'fas fa-bullhorn',
        'Keuangan' => 'fas fa-money-bill-wave',
        'Surat' => 'fas fa-envelope',
    ];
    
    return $iconMap[$pluginName] ?? 'fas fa-cube';
}
```

## Best Practices

### Penamaan Plugin
- Gunakan nama yang deskriptif dan unik
- Hindari karakter spesial dalam nama
- Gunakan format CamelCase untuk nama folder
- Gunakan huruf kecil dengan pemisah underscore untuk nama file

### Namespace
- Gunakan namespace yang sesuai: `App\Plugins\{PluginName}\...`
- Pastikan namespace sesuai dengan struktur folder

### Routing
- Gunakan prefix yang unik untuk setiap plugin
- Gunakan middleware auth untuk rute admin
- Gunakan penamaan route yang konsisten

### Database
- Gunakan nama tabel yang unik dan deskriptif
- Tambahkan foreign key constraint jika diperlukan
- Gunakan timestamp created_at dan updated_at

### View
- Gunakan helper `view_theme()` untuk rendering view
- Ikuti struktur view yang konsisten
- Gunakan helper Blade untuk rendering yang efisien

### Error Handling
- Tangani exception dengan baik
- Berikan pesan error yang informatif
- Log error untuk debugging

### Keamanan
- Validasi semua input user
- Gunakan authorization untuk akses data
- Sanitasi output untuk mencegah XSS

## Troubleshooting

### Plugin Tidak Terdeteksi
- Pastikan struktur folder sudah benar
- Periksa file `plugin.json` ada dan formatnya benar
- Bersihkan cache konfigurasi dengan `php artisan config:clear`

### Error Database
- Pastikan migrasi sudah dijalankan dengan benar
- Periksa struktur tabel dan constraint
- Gunakan `php artisan migrate:fresh` jika diperlukan

### Error Routing
- Pastikan file `routes.php` ada dan formatnya benar
- Periksa penamaan route dan controller
- Bersihkan cache route dengan `php artisan route:clear`

### Error View
- Pastikan namespace view sudah benar
- Periksa path view dalam plugin
- Bersihkan cache view dengan `php artisan view:clear`

### Plugin Tidak Bisa Diinstal
- Periksa permission folder plugin
- Pastikan semua dependensi plugin tersedia
- Cek log error untuk informasi lebih detail

### Menu Plugin Tidak Muncul
- Pastikan plugin sudah diaktifkan
- Periksa konfigurasi menu plugin
- Bersihkan cache konfigurasi dan view

## Perubahan Penting

### Perubahan Plugin (Versi 1.1.0)
- Mengganti plugin "Berita Desa" yang spesifik dengan plugin "Berita" yang umum
- Plugin "Berita" sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Menghapus plugin "BeritaDesa" yang tidak digunakan untuk mengurangi kompleksitas sistem

### Perubahan Tema (Versi 1.1.0)
- Mengganti tema admin default dari CoreUI ke AdminLTE sesuai permintaan pengguna
- Menghapus tema CoreUI yang tidak digunakan untuk mengurangi ukuran sistem
- Menyederhanakan struktur tema untuk kemudahan pemeliharaan

## Pengembangan Lebih Lanjut

### Plugin dengan Submenu
```php
// Di PluginManager untuk membuat submenu
protected function createPluginSubMenu($pluginName)
{
    // Create main menu
    $mainMenu = \App\Models\Menu::create([
        'name' => strtolower($pluginName),
        'title' => $this->getPluginTitle($pluginName),
        'route' => '#', // Parent menu with no route
        'icon' => $this->getPluginIcon($pluginName),
        'plugin_name' => $pluginName,
        'is_active' => true,
        'roles' => ['admin', 'kepala-desa', 'sekdes']
    ]);
    
    // Create submenus
    $submenus = [
        [
            'name' => strtolower($pluginName) . '-list',
            'title' => 'Daftar',
            'route' => $this->getPluginRoute($pluginName),
            'icon' => 'fas fa-list',
            'parent_id' => $mainMenu->id,
            'plugin_name' => $pluginName,
            'is_active' => true,
            'roles' => ['admin', 'kepala-desa', 'sekdes']
        ],
        [
            'name' => strtolower($pluginName) . '-create',
            'title' => 'Tambah',
            'route' => str_replace('.index', '.create', $this->getPluginRoute($pluginName)),
            'icon' => 'fas fa-plus',
            'parent_id' => $mainMenu->id,
            'plugin_name' => $pluginName,
            'is_active' => true,
            'roles' => ['admin', 'kepala-desa', 'sekdes']
        ]
    ];
    
    foreach ($submenus as $submenu) {
        \App\Models\Menu::create($submenu);
    }
}
```

### Plugin dengan API
```php
// routes/api.php untuk plugin
Route::prefix('api/v1/plugin/{pluginName}')->group(function () {
    Route::get('/', [PluginApiController::class, 'index']);
    Route::post('/', [PluginApiController::class, 'store']);
    Route::get('/{id}', [PluginApiController::class, 'show']);
    Route::put('/{id}', [PluginApiController::class, 'update']);
    Route::delete('/{id}', [PluginApiController::class, 'destroy']);
});
```

### Plugin dengan Event dan Listener
```php
// PluginServiceProvider untuk registrasi event
class PluginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load plugin events
        $this->loadPluginEvents();
    }
    
    protected function loadPluginEvents()
    {
        $plugins = app(\App\Services\PluginManager::class)->getPlugins();
        
        foreach ($plugins as $plugin) {
            if ($plugin['active']) {
                $eventsPath = app_path("Plugins/{$plugin['name']}/Events");
                if (File::exists($eventsPath)) {
                    // Register plugin events
                    $this->loadEventsFrom($eventsPath);
                }
            }
        }
    }
}
```

### Plugin dengan Testing
```php
// tests/Feature/Plugins/BeritaTest.php
namespace Tests\Feature\Plugins;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plugin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeritaTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_berita_plugin_can_be_installed()
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($user)->post(route('plugins.install', 'Berita'));
        
        $response->assertRedirect();
        $this->assertTrue(app(\App\Services\PluginManager::class)->isPluginInstalled('Berita'));
    }
    
    public function test_berita_can_be_created()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Plugin::factory()->create(['name' => 'Berita', 'installed' => true, 'active' => true]);
        
        $response = $this->actingAs($user)->post(route('berita.store'), [
            'judul' => 'Test Berita',
            'isi' => 'Ini adalah test berita',
            'tanggal_publikasi' => now()->format('Y-m-d'),
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('berita', [
            'judul' => 'Test Berita',
            'isi' => 'Ini adalah test berita',
        ]);
    }
}
```

## Distribusi Plugin

### Packaging Plugin
Untuk mendistribusikan plugin, Anda dapat membuat file ZIP dengan struktur:
```
{plugin_name}.zip
└── {PluginName}/
    ├── Controllers/
    ├── Models/
    ├── Views/
    ├── Database/
    ├── routes.php
    ├── plugin.json
    └── README.md
```

### Instalasi Plugin dari ZIP
Melalui panel administrasi:
1. Buka menu "Plugin"
2. Klik tombol "Upload Plugin"
3. Pilih file ZIP plugin
4. Plugin akan diekstrak dan diinstal secara otomatis

Melalui command line:
```bash
php artisan plugin:install-from-zip /path/to/plugin.zip
```

### Update Plugin
Sistem mendukung update plugin dengan:
1. Mendeteksi versi plugin yang terinstal
2. Membandingkan dengan versi baru
3. Menjalankan migrasi jika diperlukan
4. Memperbarui file sesuai kebutuhan

```php
public function updatePlugin($pluginName, $newVersionPath)
{
    // Check current version
    $currentPlugin = \App\Models\Plugin::where('name', $pluginName)->first();
    
    // Compare versions
    $newMetadata = json_decode(File::get($newVersionPath . '/plugin.json'), true);
    $newVersion = $newMetadata['version'];
    
    if (version_compare($newVersion, $currentPlugin->version, '>')) {
        // Backup current plugin
        $this->backupPlugin($pluginName);
        
        // Update plugin files
        $this->updatePluginFiles($pluginName, $newVersionPath);
        
        // Run migrations if any
        $this->runPluginMigrations($pluginName);
        
        // Update version in database
        $currentPlugin->version = $newVersion;
        $currentPlugin->save();
        
        return true;
    }
    
    return false;
}
```

## Plugin yang Telah Dihapus

### Plugin BeritaDesa (Deprecated)
Plugin spesifik untuk mengelola berita dan informasi desa telah dihapus dan diganti dengan plugin "Berita" yang lebih umum. Plugin ini tidak lagi tersedia dalam sistem stelloCMS versi terbaru.

Perubahan ini dilakukan untuk:
1. Membuat plugin lebih umum dan dapat digunakan untuk berbagai jenis organisasi
2. Mengurangi kompleksitas sistem dengan menghilangkan plugin duplikat
3. Mempermudah pemeliharaan dan pengembangan sistem

Plugin "Berita" sekarang dapat digunakan untuk:
- Organisasi pemerintahan desa
- Organisasi pemerintahan kota
- Organisasi swasta
- Organisasi nirlaba
- Dan berbagai jenis organisasi lainnya