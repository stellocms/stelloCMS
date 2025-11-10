<?php

namespace App\Services;

use App\Models\Plugin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            $pluginMetadataPath = $pluginPath . '/plugin.json';
            $metadata = [];

            if (File::exists($pluginMetadataPath)) {
                $metadata = json_decode(File::get($pluginMetadataPath), true);
            }

            // Check if plugin is installed and active from database
            $pluginRecord = Plugin::where('name', $pluginName)->first();

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
     * Check if a plugin is active
     */
    public function isPluginActive($pluginName)
    {
        $plugin = Plugin::where('name', $pluginName)->first();
        return $plugin && $plugin->active;
    }

    /**
     * Check if a plugin is installed
     */
    public function isPluginInstalled($pluginName)
    {
        return Plugin::where('name', $pluginName)->where('installed', true)->exists();
    }

    /**
     * Activate a plugin
     */
    public function activatePlugin($pluginName)
    {
        $plugin = Plugin::where('name', $pluginName)->first();
        if ($plugin) {
            $plugin->active = true;
            $plugin->save();
            return true;
        }
        return false;
    }

    /**
     * Deactivate a plugin
     */
    public function deactivatePlugin($pluginName)
    {
        $plugin = Plugin::where('name', $pluginName)->first();
        if ($plugin) {
            $plugin->active = false;
            $plugin->save();
            return true;
        }
        return false;
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
        $plugin = Plugin::firstOrNew(['name' => $pluginName]);
        $plugin->installed = true;
        $plugin->active = true; // Activate by default when installing
        $plugin->save();

        // Handle database tables for specific plugins
        if ($pluginName === 'Berita') {
            $this->createOrUpdateBeritaTable();
        } else if ($pluginName === 'ContohPlugin') {
            $this->createOrUpdateContohPluginTable();
        } else {
            // For other plugins, run migrations from plugin's Database/Migrations directory
            $this->runPluginMigrations($pluginName);
        }

        // Create menu for the plugin
        $this->createPluginMenu($pluginName);

        // Load the plugin's routes and views after installation
        $this->loadPlugin($pluginName);

        return true;
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
     * Create or update contoh_plugin table
     */
    protected function createOrUpdateContohPluginTable()
    {
        // Check if contoh_plugin table exists
        $tableExists = \DB::select("SHOW TABLES LIKE 'contoh_plugins'");

        if (empty($tableExists)) {
            // Create contoh_plugin table
            \DB::statement("
                CREATE TABLE `contoh_plugins` (
                    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `judul` VARCHAR(255) NOT NULL,
                    `deskripsi` TEXT NOT NULL,
                    `gambar` VARCHAR(255) NULL,
                    `tanggal_dibuat` TIMESTAMP NULL,
                    `aktif` BOOLEAN DEFAULT TRUE,
                    `slug` VARCHAR(255) NOT NULL,
                    `created_at` TIMESTAMP NULL DEFAULT NULL,
                    `updated_at` TIMESTAMP NULL DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        } else {
            // Check if columns exist and add them if missing
            $columns = \DB::select("SHOW COLUMNS FROM `contoh_plugins`");
            $columnNames = array_column($columns, 'Field');

            // Add missing columns if needed
            if (!in_array('judul', $columnNames)) {
                \DB::statement("ALTER TABLE `contoh_plugins` ADD COLUMN `judul` VARCHAR(255) NOT NULL");
            }

            if (!in_array('deskripsi', $columnNames)) {
                \DB::statement("ALTER TABLE `contoh_plugins` ADD COLUMN `deskripsi` TEXT NOT NULL");
            }

            if (!in_array('gambar', $columnNames)) {
                \DB::statement("ALTER TABLE `contoh_plugins` ADD COLUMN `gambar` VARCHAR(255) NULL");
            }

            if (!in_array('tanggal_dibuat', $columnNames)) {
                \DB::statement("ALTER TABLE `contoh_plugins` ADD COLUMN `tanggal_dibuat` TIMESTAMP NULL");
            }

            if (!in_array('aktif', $columnNames)) {
                \DB::statement("ALTER TABLE `contoh_plugins` ADD COLUMN `aktif` BOOLEAN DEFAULT TRUE");
            }

            // Add slug column if it doesn't exist
            if (!in_array('slug', $columnNames)) {
                \DB::statement("ALTER TABLE `contoh_plugins` ADD COLUMN `slug` VARCHAR(255) NOT NULL");
                // Generate slugs for existing records
                $this->generateSlugsForExistingRecords();
            }
        }
    }

    /**
     * Generate slugs for existing records
     */
    protected function generateSlugsForExistingRecords()
    {
        $records = \DB::table('contoh_plugins')->get();

        foreach ($records as $record) {
            $slug = generate_slug($record->judul);
            // Check if slug already exists and make it unique
            $originalSlug = $slug;
            $counter = 1;

            while (\DB::table('contoh_plugins')->where('slug', $slug)->where('id', '!=', $record->id)->first()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            \DB::table('contoh_plugins')
                ->where('id', $record->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Run plugin migrations
     */
    protected function runPluginMigrations($pluginName)
    {
        $pluginPath = $this->pluginsPath . '/' . $pluginName;
        $migrationsPath = $pluginPath . '/Database/Migrations';

        if (!File::exists($migrationsPath)) {
            return;
        }

        $migrationFiles = File::glob($migrationsPath . '/*.php');

        foreach ($migrationFiles as $migrationFile) {
            if (preg_match('/\d{4}_\d{2}_\d{2}_\d{6}_.*\.php$/', basename($migrationFile))) {
                require_once $migrationFile;

                $fileName = pathinfo($migrationFile, PATHINFO_FILENAME);
                $className = str_replace('_', '', ucwords($fileName, '_'));
                $className = preg_replace('/\d+/', '', $className);

                if (class_exists($className)) {
                    $migration = new $className();
                    if (method_exists($migration, 'up')) {
                        try {
                            $migration->up();
                        } catch (\Exception $e) {
                            \Log::error("Migration failed for $fileName: " . $e->getMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     * Uninstall a plugin
     */
    public function uninstallPlugin($pluginName)
    {
        // Delete plugin record from database
        Plugin::where('name', $pluginName)->delete();

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
     * Create menu for a plugin
     */
    protected function createPluginMenu($pluginName)
    {
        // Remove existing menu if any
        $this->removePluginMenu($pluginName);

        // Create admin menu
        $adminMenu = new \App\Models\Menu([
            'name' => strtolower($pluginName),
            'title' => $this->getPluginTitle($pluginName),
            'route' => $this->getPluginRoute($pluginName),  // Use the proper method
            'icon' => $this->getPluginIcon($pluginName),
            'plugin_name' => $pluginName,
            'type' => 'admin',
            'position' => 'sidebar-left', // Valid enum value for sidebar menu
            'is_active' => true,
            'order' => 0, // Default order
            'roles' => ['admin', 'operator'] // Updated roles for plugin management
        ]);

        $adminMenu->save();

        // For specific plugins, also create frontend menu in header
        if ($this->shouldCreateFrontendMenu($pluginName)) {
            $frontendMenu = new \App\Models\Menu([
                'name' => strtolower($pluginName) . '_frontend',
                'title' => $this->getPluginTitle($pluginName),
                'route' => $this->getPluginFrontendRoute($pluginName),  // Use the proper frontend method
                'icon' => $this->getPluginIcon($pluginName),
                'plugin_name' => $pluginName,
                'type' => 'frontend',
                'position' => 'header',
                'is_active' => true,
                'order' => 0, // Default order
                'roles' => [] // No role restrictions for frontend
            ]);

            $frontendMenu->save();
        }
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
        // Default plugin route based on plugin name with panel prefix for admin
        $lowerPluginName = strtolower($pluginName);

        // Special cases for specific plugins
        switch ($pluginName) {
            case 'Berita':
                return 'panel.berita.index'; // Admin route for Berita
            default:
                // For other plugins, use panel prefixed pattern for admin
                return 'panel.' . $lowerPluginName . '.index';
        }
    }

    /**
     * Get frontend plugin route
     */
    protected function getPluginFrontendRoute($pluginName)
    {
        // Default plugin route for frontend based on plugin name
        $lowerPluginName = strtolower($pluginName);

        // Special cases for specific plugins
        switch ($pluginName) {
            case 'Berita':
                return 'berita.index'; // Public route for Berita
            default:
                // For other plugins, use a generic pattern for frontend
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
            'ContohPlugin' => 'fas fa-cube',
            'Pengumuman' => 'fas fa-bullhorn',
            'Keuangan' => 'fas fa-money-bill-wave',
            'Surat' => 'fas fa-envelope',
        ];

        return $iconMap[$pluginName] ?? 'fas fa-puzzle-piece';
    }

    /**
     * Determine if a plugin should have a frontend menu
     */
    protected function shouldCreateFrontendMenu($pluginName)
    {
        // Define which plugins should have frontend menu
        $frontendPlugins = ['Berita', 'ContohPlugin'];

        return in_array($pluginName, $frontendPlugins);
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

        $pluginRecord = Plugin::where('name', $pluginName)->first();

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
    
    /**
     * Update menu order via drag and drop
     */
    public function updateMenuOrder($menuIds, $type)
    {
        foreach ($menuIds as $index => $menuId) {
            \App\Models\Menu::where('id', $menuId)
                           ->where('type', $type)
                           ->update(['order' => $index]);
        }

        return true;
    }
}