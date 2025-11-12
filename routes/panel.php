<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\PluginController;
use Illuminate\Support\Facades\Route;

// Single route for /panel that handles both login and redirection based on auth state
Route::get('/panel', function () {
    // Check if user is already authenticated
    if (auth()->check()) {
        // If user is logged in, redirect to dashboard
        return redirect()->route('panel.dashboard');
    } else {
        // If user is not logged in, show login form
        return view_theme('admin', 'auth.login');
    }
})->name('panel.login');

Route::post('/panel', [LoginController::class, 'login']);

// Routes for authenticated users
Route::middleware(['auth', 'role:admin,kepala-desa,sekdes,kaur,kadus,rw,rt'])->group(function () {
    Route::get('/panel/dashboard', function () {
        return view_theme('admin', 'dashboard.index');
    })->name('panel.dashboard');

    // Theme management routes
    Route::get('/panel/themes', [ThemeController::class, 'index'])->name('themes.index');
    Route::post('/panel/themes/admin/switch', [ThemeController::class, 'switchAdminTheme'])->name('themes.admin.switch');
    Route::post('/panel/themes/frontend/switch', [ThemeController::class, 'switchFrontendTheme'])->name('themes.frontend.switch');
    Route::get('/panel/themes/scan', [ThemeController::class, 'scan'])->name('themes.scan.get');
    Route::post('/panel/themes/scan', [ThemeController::class, 'scan'])->name('themes.scan.post');
    Route::post('/panel/themes/upload', [ThemeController::class, 'upload'])->name('themes.upload');

    // Theme CRUD routes
    Route::post('/panel/themes/{type}/{name}/install', [ThemeController::class, 'install'])->name('themes.install');
    Route::delete('/panel/themes/{type}/{name}/uninstall', [ThemeController::class, 'uninstall'])->name('themes.uninstall');
    Route::post('/panel/themes/{type}/{name}/activate', [ThemeController::class, 'activate'])->name('themes.activate');
    Route::post('/panel/themes/{type}/{name}/deactivate', [ThemeController::class, 'deactivate'])->name('themes.deactivate');
    Route::post('/panel/themes/{type}/{name}/set-default', [ThemeController::class, 'setDefault'])->name('themes.set_default');

    // Plugin management routes
    Route::get('/panel/plugins', [PluginController::class, 'index'])->name('plugins.index');
    Route::post('/panel/plugins/{pluginName}/activate', [PluginController::class, 'activate'])->name('plugins.activate');
    Route::post('/panel/plugins/{pluginName}/deactivate', [PluginController::class, 'deactivate'])->name('plugins.deactivate');
    Route::post('/panel/plugins/{pluginName}/install', [PluginController::class, 'install'])->name('plugins.install');
    Route::delete('/panel/plugins/{pluginName}/uninstall', [PluginController::class, 'uninstall'])->name('plugins.uninstall');
    Route::post('/panel/plugins/upload', [PluginController::class, 'upload'])->name('plugins.upload');

    // Menu management routes
    Route::get('/panel/menus', [\App\Http\Controllers\MenuManagementController::class, 'index'])->name('menus.index');
    Route::get('/panel/menus/create', [\App\Http\Controllers\MenuManagementController::class, 'create'])->name('menus.create');
    Route::post('/panel/menus', [\App\Http\Controllers\MenuManagementController::class, 'store'])->name('menus.store');
    Route::get('/panel/menus/{id}/edit', [\App\Http\Controllers\MenuManagementController::class, 'edit'])->name('menus.edit');
    Route::put('/panel/menus/{id}', [\App\Http\Controllers\MenuManagementController::class, 'update'])->name('menus.update');
    Route::delete('/panel/menus/{id}', [\App\Http\Controllers\MenuManagementController::class, 'destroy'])->name('menus.destroy');
    Route::post('/panel/menus/update-order', [\App\Http\Controllers\MenuManagementController::class, 'updateOrder'])->name('menus.update-order');

    // User management routes
    Route::get('/panel/users', [\App\Http\Controllers\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/panel/users/create', [\App\Http\Controllers\UserManagementController::class, 'create'])->name('users.create');
    Route::post('/panel/users', [\App\Http\Controllers\UserManagementController::class, 'store'])->name('users.store');
    Route::get('/panel/users/{id}/edit', [\App\Http\Controllers\UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/panel/users/{id}', [\App\Http\Controllers\UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/panel/users/{id}', [\App\Http\Controllers\UserManagementController::class, 'destroy'])->name('users.destroy');

    // Role management routes
    Route::get('/panel/roles', [\App\Http\Controllers\RoleManagementController::class, 'index'])->name('roles.index');
    Route::get('/panel/roles/create', [\App\Http\Controllers\RoleManagementController::class, 'create'])->name('roles.create');
    Route::post('/panel/roles', [\App\Http\Controllers\RoleManagementController::class, 'store'])->name('roles.store');
    Route::get('/panel/roles/{id}/edit', [\App\Http\Controllers\RoleManagementController::class, 'edit'])->name('roles.edit');
    Route::put('/panel/roles/{id}', [\App\Http\Controllers\RoleManagementController::class, 'update'])->name('roles.update');
    Route::delete('/panel/roles/{id}', [\App\Http\Controllers\RoleManagementController::class, 'destroy'])->name('roles.destroy');

    // Berita plugin routes
    Route::prefix('panel/berita')->group(function () {
        Route::get('/', [\App\Plugins\Berita\Controllers\BeritaController::class, 'index'])->name('berita.index');
        Route::get('/create', [\App\Plugins\Berita\Controllers\BeritaController::class, 'create'])->name('berita.create');
        Route::post('/', [\App\Plugins\Berita\Controllers\BeritaController::class, 'store'])->name('berita.store');
        Route::get('/{id}/edit', [\App\Plugins\Berita\Controllers\BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/{id}', [\App\Plugins\Berita\Controllers\BeritaController::class, 'update'])->name('berita.update');
        Route::delete('/{id}', [\App\Plugins\Berita\Controllers\BeritaController::class, 'destroy'])->name('berita.destroy');
        Route::get('/{id}', [\App\Plugins\Berita\Controllers\BeritaController::class, 'show'])->name('berita.show');
    });
    
    // Unsplash API routes
    Route::get('/panel/unsplash/search', [\App\Plugins\Berita\Controllers\BeritaController::class, 'searchUnsplash'])->name('panel.berita.unsplash.search');
    Route::get('/panel/unsplash/check-keys', [\App\Plugins\Berita\Controllers\BeritaController::class, 'checkUnsplashKeys'])->name('panel.berita.unsplash.check_keys');

    // ContohPlugin routes - added manually to ensure they work without relying on route caching
    Route::prefix('panel/contohplugin')->group(function () {
        Route::get('/', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'index'])->name('contohplugin.index');
        Route::get('/create', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'create'])->name('contohplugin.create');
        Route::post('/', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'store'])->name('contohplugin.store');
        Route::get('/{id}/edit', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'edit'])->name('contohplugin.edit');
        Route::put('/{id}', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'update'])->name('contohplugin.update');
        Route::delete('/{id}', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'destroy'])->name('contohplugin.destroy');
        Route::get('/{id}', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'show'])->name('contohplugin.show');
    });

    // Kategori routes - added manually to ensure they work without relying on route caching
    Route::prefix('panel/kategori')->group(function () {
        Route::get('/', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'index'])->name('panel.kategori.index');
        Route::get('/create', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'create'])->name('panel.kategori.create');
        Route::post('/', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'store'])->name('panel.kategori.store');
        Route::get('/{id}/edit', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'edit'])->name('panel.kategori.edit');
        Route::put('/{id}', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'update'])->name('panel.kategori.update');
        Route::delete('/{id}', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'destroy'])->name('panel.kategori.destroy');
        Route::get('/{id}', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'show'])->name('panel.kategori.show');

        // API untuk mendapatkan kategori aktif
        Route::get('/api/active', [\App\Plugins\Kategori\Controllers\KategoriController::class, 'getActiveCategories'])->name('panel.kategori.api.active');
    });

    // Settings management routes - following the same pattern as other panel routes
    Route::get('/panel/setting', [\App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    Route::get('/panel/setting/create', [\App\Http\Controllers\SettingController::class, 'create'])->name('setting.create');
    Route::post('/panel/setting', [\App\Http\Controllers\SettingController::class, 'store'])->name('setting.store');
    Route::get('/panel/setting/{id}/edit', [\App\Http\Controllers\SettingController::class, 'edit'])->name('setting.edit');
    Route::put('/panel/setting/{id}', [\App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');
    Route::delete('/panel/setting/{id}', [\App\Http\Controllers\SettingController::class, 'destroy'])->name('setting.destroy');
    Route::post('/panel/setting/clear-cache', [\App\Http\Controllers\SettingController::class, 'clearCache'])->name('setting.clear_cache');

    // Update management routes - following the same pattern as other panel routes
    Route::get('/panel/update', [\App\Http\Controllers\UpdateController::class, 'index'])->name('update.index');
    Route::get('/panel/update/create', [\App\Http\Controllers\UpdateController::class, 'create'])->name('update.create');
    Route::post('/panel/update', [\App\Http\Controllers\UpdateController::class, 'store'])->name('update.store');
    Route::get('/panel/update/{id}/edit', [\App\Http\Controllers\UpdateController::class, 'edit'])->name('update.edit');
    Route::put('/panel/update/{id}', [\App\Http\Controllers\UpdateController::class, 'update'])->name('update.update');
    Route::delete('/panel/update/{id}', [\App\Http\Controllers\UpdateController::class, 'destroy'])->name('update.destroy');

    // Widget management routes
    Route::get('/panel/widgets', [\App\Http\Controllers\WidgetController::class, 'index'])->name('panel.widgets.index');
    Route::get('/panel/widgets/create', [\App\Http\Controllers\WidgetController::class, 'create'])->name('panel.widgets.create');
    Route::post('/panel/widgets', [\App\Http\Controllers\WidgetController::class, 'store'])->name('panel.widgets.store');
    Route::get('/panel/widgets/{widget}', [\App\Http\Controllers\WidgetController::class, 'show'])->name('panel.widgets.show');
    Route::get('/panel/widgets/{widget}/edit', [\App\Http\Controllers\WidgetController::class, 'edit'])->name('panel.widgets.edit');
    Route::put('/panel/widgets/{widget}', [\App\Http\Controllers\WidgetController::class, 'update'])->name('panel.widgets.update');
    Route::delete('/panel/widgets/{widget}', [\App\Http\Controllers\WidgetController::class, 'destroy'])->name('panel.widgets.destroy');
    Route::post('/panel/widgets/update-order', [\App\Http\Controllers\WidgetController::class, 'updateOrder'])->name('panel.widgets.update-order');
    Route::post('/panel/widgets/update-position', [\App\Http\Controllers\WidgetController::class, 'updatePosition'])->name('panel.widgets.update-position');
});

// Dynamic plugin routes - automatically handle routes for installed and active plugins
// This catches routes that are registered by plugin's routes.php but not explicitly defined above

// Handle direct access to logout URL by redirecting to login
Route::get('/panel/logout', function () {
    return redirect()->route('panel.login');
})->name('logout.get');

Route::post('/panel/logout', [LoginController::class, 'logout'])->name('logout');

// Temporary route to add SimplePage menu entry
Route::get('/panel/add-simplepage-menu', function() {
    $existingMenu = DB::table('menus')->where('name', 'simplepage')->first();

    if (!$existingMenu) {
        DB::table('menus')->insert([
            'name' => 'simplepage',
            'title' => 'Simple Page',
            'route' => 'simplepage.index',
            'icon' => 'fas fa-file-alt',
            'parent_id' => null,
            'order' => 100,
            'is_active' => true,
            'plugin_name' => 'SimplePage',
            'roles' => json_encode(['admin', 'kepala-desa', 'sekdes', 'kaur', 'kadus', 'rw', 'rt']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return 'Menu entry for SimplePage created successfully!';
    } else {
        return 'Menu entry for SimplePage already exists!';
    }
});

// Route to check current user role


// Route to check all available roles


// Debugging route for SimplePage access


// Route to force activate SimplePage plugin
Route::get('/panel/activate-simplepage', function() {
    try {
        $pluginManager = app(\App\Services\PluginManager::class);

        // Check if plugin exists in filesystem
        $pluginPath = app_path('Plugins/SimplePage');
        if (!file_exists($pluginPath)) {
            return 'Plugin SimplePage not found in filesystem at: ' . $pluginPath;
        }

        // Try to activate the plugin
        $result = $pluginManager->activatePlugin('SimplePage');

        if ($result) {
            // Also ensure menu entry exists for the plugin
            $existingMenu = \App\Models\Menu::where('name', 'simplepage')->first();

            if (!$existingMenu) {
                \App\Models\Menu::create([
                    'name' => 'simplepage',
                    'title' => 'Simple Page',
                    'route' => 'simplepage.index',
                    'icon' => 'fas fa-file-alt',
                    'parent_id' => null,
                    'order' => 100,
                    'is_active' => true,
                    'plugin_name' => 'SimplePage',
                    'roles' => json_encode(['admin', 'kepala-desa', 'sekdes', 'kaur', 'kadus', 'rw', 'rt']),
                ]);

                return 'SimplePage plugin activated successfully and menu entry created!';
            }

            return 'SimplePage plugin activated successfully!';
        } else {
            return 'Failed to activate SimplePage plugin';
        }
    } catch (\Exception $e) {
        return 'Error activating plugin: ' . $e->getMessage();
    }
});

// Diagnostic route for plugin system
Route::get('/panel/plugin-diagnostic', function() {
    $output = '<h3>Plugin Diagnostic Information</h3>';

    // Check if user is authenticated
    if (!auth()->check()) {
        return 'No user is logged in';
    }

    $user = auth()->user();
    $output .= '<h4>Current User:</h4>';
    $output .= "<p>User: {$user->name} (ID: {$user->id})</p>";
    $output .= "<p>Role: {$user->role->name} (ID: {$user->role->id})</p>";

    // Check plugin manager
    try {
        $pluginManager = app(\App\Services\PluginManager::class);

        $output .= '<h4>Plugin Manager:</h4>';
        $output .= '<p>Plugin manager instantiated successfully</p>';

        // List all plugins in filesystem
        $pluginDir = app_path('Plugins');
        $output .= '<h5>Plugins in filesystem:</h5>';
        $output .= '<ul>';
        foreach (scandir($pluginDir) as $dir) {
            if ($dir !== '.' && $dir !== '..') {
                $pluginPath = $pluginDir . '/' . $dir;
                if (is_dir($pluginPath)) {
                    $output .= '<li>' . $dir . '</li>';
                }
            }
        }
        $output .= '</ul>';

        // Check if SimplePage plugin is installed/active
        $simplePageInstalled = file_exists(app_path('Plugins/SimplePage/plugin.json'));
        $output .= '<h5>SimplePage Plugin Status:</h5>';
        $output .= '<p>Plugin file exists: ' . ($simplePageInstalled ? 'YES' : 'NO') . '</p>';

        try {
            $isSimplePageActive = $pluginManager->isPluginActive('SimplePage');
            $output .= '<p>Plugin is active: ' . ($isSimplePageActive ? 'YES' : 'NO') . '</p>';
        } catch (\Exception $e) {
            $output .= '<p>Plugin active check failed: ' . $e->getMessage() . '</p>';
        }

        // List all registered routes
        $output .= '<h4>Current Route Status:</h4>';
        $output .= '<p>Current route: ' . request()->route()->getName() . '</p>';

        // Check if simplepage routes exist
        $routeExists = \Illuminate\Support\Facades\Route::has('simplepage.index');
        $output .= '<p>Route simplepage.index exists: ' . ($routeExists ? 'YES' : 'NO') . '</p>';
    } catch (\Exception $e) {
        $output .= '<h4>Error accessing PluginManager:</h4>';
        $output .= '<p>' . $e->getMessage() . '</p>';
    }

    return $output;
});

// Route to manually register SimplePage plugin in database
Route::get('/panel/register-simplepage-plugin', function() {
    $plugin = \App\Models\Plugin::firstOrCreate(
        ['name' => 'SimplePage'],
        [
            'title' => 'Simple Page Plugin',
            'version' => '1.0.0',
            'description' => 'A simple plugin for creating pages',
            'author' => 'StelloCMS Developer',
            'author_url' => 'https://stellocms.com',
            'category' => 'utility',
            'screenshot' => '',
            'tags' => json_encode(['pages', 'simple', 'utility']),
            'installed' => true,
            'active' => true,
        ]
    );

    if ($plugin->wasRecentlyCreated) {
        return 'SimplePage plugin registered successfully in database';
    } else {
        $plugin->update([
            'installed' => true,
            'active' => true,
        ]);
        return 'SimplePage plugin already existed, updated status to active';
    }
});

// Route to properly install SimplePage plugin through PluginManager


// Route to check plugin installation status
Route::get('/panel/check-testimonial-status', function() {
    // Check if plugin exists in filesystem
    $pluginPath = app_path('Plugins/Testimonial');
    $filesystemExists = file_exists($pluginPath);

    // Check if plugin is recorded in database
    $pluginRecord = \App\Models\Plugin::where('name', 'Testimonial')->first();
    $databaseExists = !!$pluginRecord;

    // Try to access PluginManager
    try {
        $pluginManager = app(\App\Services\PluginManager::class);
        $pluginManagerExists = true;

        // Get all plugins from manager
        $allPlugins = $pluginManager->getPlugins();
        $testimonialInManager = null;
        foreach ($allPlugins as $plugin) {
            if ($plugin['name'] === 'Testimonial') {
                $testimonialInManager = $plugin;
                break;
            }
        }

        // Check if plugin is active according to manager
        $managerIsActive = $testimonialInManager ? $testimonialInManager['active'] : null;

        // Check if routes.php exists
        $routesFileExists = file_exists($pluginPath . '/routes.php');

        $result = "<h3>Testimonial Plugin Status Check</h3>";
        $result .= "<p>Plugin directory exists: " . ($filesystemExists ? 'YES' : 'NO') . "</p>";
        $result .= "<p>Plugin record in database: " . ($databaseExists ? 'YES' : 'NO') . "</p>";
        $result .= "<p>Plugin manager accessible: " . ($pluginManagerExists ? 'YES' : 'NO') . "</p>";

        if ($testimonialInManager) {
            $result .= "<p>Plugin found in plugin manager:</p>";
            $result .= "<ul>";
            $result .= "<li>Name: " . $testimonialInManager['name'] . "</li>";
            $result .= "<li>Active: " . ($testimonialInManager['active'] ? 'YES' : 'NO') . "</li>";
            $result .= "<li>Installed: " . ($testimonialInManager['installed'] ? 'YES' : 'NO') . "</li>";
            $result .= "</ul>";
        } else {
            $result .= "<p>Plugin NOT found in plugin manager</p>";
        }

        $result .= "<p>Routes file exists: " . ($routesFileExists ? 'YES' : 'NO') . "</p>";

        return $result;
    } catch (\Exception $e) {
        return "Error checking plugin status: " . $e->getMessage();
    }
});



// Dynamic plugin routes - automatically handle routes for installed and active plugins
// This catches routes that are registered by plugin's routes.php but not explicitly defined above

// Handle direct access to logout URL by redirecting to login
Route::get('/panel/logout', function () {
    return redirect()->route('panel.login');
})->name('logout.get');

Route::post('/panel/logout', [LoginController::class, 'logout'])->name('logout');

// Temporary route to add SimplePage menu entry
Route::get('/panel/add-simplepage-menu', function() {
    $existingMenu = DB::table('menus')->where('name', 'simplepage')->first();

    if (!$existingMenu) {
        DB::table('menus')->insert([
            'name' => 'simplepage',
            'title' => 'Simple Page',
            'route' => 'simplepage.index',
            'icon' => 'fas fa-file-alt',
            'parent_id' => null,
            'order' => 100,
            'is_active' => true,
            'plugin_name' => 'SimplePage',
            'roles' => json_encode(['admin', 'kepala-desa', 'sekdes', 'kaur', 'kadus', 'rw', 'rt']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return 'Menu entry for SimplePage created successfully!';
    } else {
        return 'Menu entry for SimplePage already exists!';
    }
});

// Route to check current user role


// Route to check all available roles


// Debugging route for SimplePage access


// Route to force activate SimplePage plugin
Route::get('/panel/activate-simplepage', function() {
    try {
        $pluginManager = app(\App\Services\PluginManager::class);

        // Check if plugin exists in filesystem
        $pluginPath = app_path('Plugins/SimplePage');
        if (!file_exists($pluginPath)) {
            return 'Plugin SimplePage not found in filesystem at: ' . $pluginPath;
        }

        // Try to activate the plugin
        $result = $pluginManager->activatePlugin('SimplePage');

        if ($result) {
            // Also ensure menu entry exists for the plugin
            $existingMenu = \App\Models\Menu::where('name', 'simplepage')->first();

            if (!$existingMenu) {
                \App\Models\Menu::create([
                    'name' => 'simplepage',
                    'title' => 'Simple Page',
                    'route' => 'simplepage.index',
                    'icon' => 'fas fa-file-alt',
                    'parent_id' => null,
                    'order' => 100,
                    'is_active' => true,
                    'plugin_name' => 'SimplePage',
                    'roles' => json_encode(['admin', 'kepala-desa', 'sekdes', 'kaur', 'kadus', 'rw', 'rt']),
                ]);

                return 'SimplePage plugin activated successfully and menu entry created!';
            }

            return 'SimplePage plugin activated successfully!';
        } else {
            return 'Failed to activate SimplePage plugin';
        }
    } catch (\Exception $e) {
        return 'Error activating plugin: ' . $e->getMessage();
    }
});

// Diagnostic route for plugin system
Route::get('/panel/plugin-diagnostic', function() {
    $output = '<h3>Plugin Diagnostic Information</h3>';

    // Check if user is authenticated
    if (!auth()->check()) {
        return 'No user is logged in';
    }

    $user = auth()->user();
    $output .= '<h4>Current User:</h4>';
    $output .= "<p>User: {$user->name} (ID: {$user->id})</p>";
    $output .= "<p>Role: {$user->role->name} (ID: {$user->role->id})</p>";

    // Check plugin manager
    try {
        $pluginManager = app(\App\Services\PluginManager::class);

        $output .= '<h4>Plugin Manager:</h4>';
        $output .= '<p>Plugin manager instantiated successfully</p>';

        // List all plugins in filesystem
        $pluginDir = app_path('Plugins');
        $output .= '<h5>Plugins in filesystem:</h5>';
        $output .= '<ul>';
        foreach (scandir($pluginDir) as $dir) {
            if ($dir !== '.' && $dir !== '..') {
                $pluginPath = $pluginDir . '/' . $dir;
                if (is_dir($pluginPath)) {
                    $output .= '<li>' . $dir . '</li>';
                }
            }
        }
        $output .= '</ul>';

        // Check if SimplePage plugin is installed/active
        $simplePageInstalled = file_exists(app_path('Plugins/SimplePage/plugin.json'));
        $output .= '<h5>SimplePage Plugin Status:</h5>';
        $output .= '<p>Plugin file exists: ' . ($simplePageInstalled ? 'YES' : 'NO') . '</p>';

        try {
            $isSimplePageActive = $pluginManager->isPluginActive('SimplePage');
            $output .= '<p>Plugin is active: ' . ($isSimplePageActive ? 'YES' : 'NO') . '</p>';
        } catch (\Exception $e) {
            $output .= '<p>Plugin active check failed: ' . $e->getMessage() . '</p>';
        }

        // List all registered routes
        $output .= '<h4>Current Route Status:</h4>';
        $output .= '<p>Current route: ' . request()->route()->getName() . '</p>';

        // Check if simplepage routes exist
        $routeExists = \Illuminate\Support\Facades\Route::has('simplepage.index');
        $output .= '<p>Route simplepage.index exists: ' . ($routeExists ? 'YES' : 'NO') . '</p>';
    } catch (\Exception $e) {
        $output .= '<h4>Error accessing PluginManager:</h4>';
        $output .= '<p>' . $e->getMessage() . '</p>';
    }

    return $output;
});

// Route to manually register SimplePage plugin in database
Route::get('/panel/register-simplepage-plugin', function() {
    $plugin = \App\Models\Plugin::firstOrCreate(
        ['name' => 'SimplePage'],
        [
            'title' => 'Simple Page Plugin',
            'version' => '1.0.0',
            'description' => 'A simple plugin for creating pages',
            'author' => 'StelloCMS Developer',
            'author_url' => 'https://stellocms.com',
            'category' => 'utility',
            'screenshot' => '',
            'tags' => json_encode(['pages', 'simple', 'utility']),
            'installed' => true,
            'active' => true,
        ]
    );

    if ($plugin->wasRecentlyCreated) {
        return 'SimplePage plugin registered successfully in database';
    } else {
        $plugin->update([
            'installed' => true,
            'active' => true,
        ]);
        return 'SimplePage plugin already existed, updated status to active';
    }
});

// Route to properly install SimplePage plugin through PluginManager


// Route to check plugin installation status
Route::get('/panel/check-testimonial-status', function() {
    // Check if plugin exists in filesystem
    $pluginPath = app_path('Plugins/Testimonial');
    $filesystemExists = file_exists($pluginPath);

    // Check if plugin is recorded in database
    $pluginRecord = \App\Models\Plugin::where('name', 'Testimonial')->first();
    $databaseExists = !!$pluginRecord;

    // Try to access PluginManager
    try {
        $pluginManager = app(\App\Services\PluginManager::class);

        $pluginManagerExists = true;

        // Get all plugins from manager
        $allPlugins = $pluginManager->getPlugins();
        $testimonialInManager = null;
        foreach ($allPlugins as $plugin) {
            if ($plugin['name'] === 'Testimonial') {
                $testimonialInManager = $plugin;
                break;
            }
        }

        // Check if plugin is active according to manager
        $managerIsActive = $testimonialInManager ? $testimonialInManager['active'] : null;

        // Check if routes.php exists
        $routesFileExists = file_exists($pluginPath . '/routes.php');

        $result = "<h3>Testimonial Plugin Status Check</h3>";
        $result .= "<p>Plugin directory exists: " . ($filesystemExists ? 'YES' : 'NO') . "</p>";
        $result .= "<p>Plugin record in database: " . ($databaseExists ? 'YES' : 'NO') . "</p>";
        $result .= "<p>Plugin manager accessible: " . ($pluginManagerExists ? 'YES' : 'NO') . "</p>";

        if ($testimonialInManager) {
            $result .= "<p>Plugin found in plugin manager:</p>";
            $result .= "<ul>";
            $result .= "<li>Name: " . $testimonialInManager['name'] . "</li>";
            $result .= "<li>Active: " . ($testimonialInManager['active'] ? 'YES' : 'NO') . "</li>";
            $result .= "<li>Installed: " . ($testimonialInManager['installed'] ? 'YES' : 'NO') . "</li>";
            $result .= "</ul>";
        } else {
            $result .= "<p>Plugin NOT found in plugin manager</p>";
        }

        $result .= "<p>Routes file exists: " . ($routesFileExists ? 'YES' : 'NO') . "</p>";

        return $result;
    } catch (\Exception $e) {
        return "Error checking plugin status: " . $e->getMessage();
    }
});

// Redirect any accesses to the default Laravel login path to our panel login
Route::get('/login', function () {
    return redirect()->route('panel.login');
});