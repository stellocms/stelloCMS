<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\PluginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/panel', [LoginController::class, 'showLoginForm'])->name('panel.login');
    Route::post('/panel', [LoginController::class, 'login']);
});

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
});

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
Route::get('/panel/check-role', function() {
    if (auth()->check()) {
        $user = auth()->user();
        $roleName = $user->role ? $user->role->name : 'No role assigned';
        return "User: {$user->name} (ID: {$user->id})<br>Role: {$roleName}";
    } else {
        return 'User not logged in';
    }
});

// Route to check all available roles
Route::get('/panel/check-roles', function() {
    $roles = \App\Models\Role::all();
    $output = '<h3>Available Roles in System:</h3><ul>';
    foreach ($roles as $role) {
        $output .= "<li>{$role->id}: {$role->name}</li>";
    }
    $output .= '</ul>';
    
    $currentUser = auth()->user();
    if ($currentUser && $currentUser->role) {
        $output .= "<h3>Current User Role:</h3>";
        $output .= "<p>User: {$currentUser->name} (ID: {$currentUser->id})</p>";
        $output .= "<p>Role: {$currentUser->role->name} (ID: {$currentUser->role->id})</p>";
        $output .= "<p>Lowercase role for comparison: " . strtolower($currentUser->role->name) . "</p>";
    } else {
        $output .= "<h3>No authenticated user</h3>";
    }
    
    return $output;
});

// Debugging route for SimplePage access
Route::get('/panel/debug-simplepage', function() {
    $output = '<h3>Debugging SimplePage Access</h3>';
    
    // Check if user is authenticated
    $output .= '<h4>Authentication Status:</h4>';
    if (auth()->check()) {
        $user = auth()->user();
        $output .= "<p>User is logged in: {$user->name} (ID: {$user->id})</p>";
        $output .= "<p>User role: {$user->role->name} (ID: {$user->role->id})</p>";
        $output .= "<p>Lowercased role: " . strtolower($user->role->name) . "</p>";
        
        // Check if user role is considered admin
        $userRoleLower = strtolower($user->role->name);
        $isAdmin = in_array($userRoleLower, ['admin', 'administrator', 'adminstrator']);
        $output .= "<p>Is admin (based on role): " . ($isAdmin ? 'YES' : 'NO') . "</p>";
    } else {
        $output .= '<p>No user is logged in</p>';
        return $output;
    }
    
    // Check if route exists
    $output .= '<h4>Route Information:</h4>';
    $routeName = request()->route() ? request()->route()->getName() : 'No route matched';
    $output .= '<p>Current route name: ' . $routeName . '</p>';
    
    // Check if menu exists for this route
    $menu = \App\Models\Menu::where('route', 'simplepage.index')->first();
    if ($menu) {
        $output .= '<p>Menu entry exists for simplepage.index</p>';
        $output .= '<p>Menu roles: ' . json_encode(json_decode($menu->roles, true)) . '</p>';
    } else {
        $output .= '<p>No menu entry found for simplepage.index</p>';
    }
    
    // Check if view exists
    $output .= '<h4>View Information:</h4>';
    $viewPath = 'theme.admin.adminlte::simplepage.index';
    if (view()->exists($viewPath)) {
        $output .= '<p>View exists: ' . $viewPath . '</p>';
    } else {
        $output .= '<p>View does NOT exist: ' . $viewPath . '</p>';
    }
    
    // Check if plugin is active
    $output .= '<h4>Plugin Information:</h4>';
    try {
        $pluginManager = app(\App\Services\PluginManager::class);
        $isActive = $pluginManager->isPluginActive('SimplePage');
        $output .= '<p>SimplePage plugin is active: ' . ($isActive ? 'YES' : 'NO') . '</p>';
        
        // Get plugin info
        $pluginInfo = $pluginManager->getPluginInfo('SimplePage');
        if ($pluginInfo) {
            $output .= '<p>Plugin info found</p>';
            $output .= '<p>Plugin status: ' . ($pluginInfo['active'] ? 'ACTIVE' : 'INACTIVE') . '</p>';
        } else {
            $output .= '<p>Plugin info NOT found</p>';
        }
    } catch (\Exception $e) {
        $output .= '<p>Error checking plugin status: ' . $e->getMessage() . '</p>';
    }
    
    return $output;
});

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
            'author_url' => 'https://stello-cms.com',
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
Route::get('/panel/install-simplepage-plugin', function() {
    try {
        $pluginManager = app(\App\Services\PluginManager::class);
        
        // Check if plugin exists in filesystem
        $pluginPath = app_path('Plugins/SimplePage');
        if (!file_exists($pluginPath)) {
            return 'Plugin SimplePage not found in filesystem';
        }
        
        // Use PluginManager to properly install the plugin
        $result = $pluginManager->installPlugin('SimplePage');
        
        if ($result) {
            return 'SimplePage plugin installed successfully through PluginManager';
        } else {
            return 'Failed to install SimplePage plugin through PluginManager';
        }
    } catch (\Exception $e) {
        return 'Error installing plugin: ' . $e->getMessage();
    }
});

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

// Test route to check if SimplePage controller works
Route::get('/panel/test-simplepage-controller', function() {
    try {
        // Try to instantiate the controller
        $controller = app(\App\Plugins\SimplePage\Controllers\SimplePageController::class);
        
        // Try to call index method directly
        return $controller->index();
    } catch (\Exception $e) {
        return 'Error in SimplePage controller: ' . $e->getMessage() . '<br><br>' . 
               'File: ' . $e->getFile() . '<br>' .
               'Line: ' . $e->getLine();
    }
});

// Test route to check if SimplePage view renders
Route::get('/panel/test-simplepage-view', function() {
    $results = [];
    
    // Try different view paths
    $viewPaths = [
        'theme.admin.adminlte::simplepage.index',
        'simplepage.index',
        'theme.admin.adminlte.simplepage::index',
        'app.themes.admin.adminlte.simplepage::index',
    ];
    
    foreach ($viewPaths as $path) {
        $exists = view()->exists($path);
        $results[] = $path . ': ' . ($exists ? 'EXISTS' : 'NOT FOUND');
    }
    
    // Try to actually render the correct view
    try {
        return view('theme.admin.adminlte::simplepage.index');
    } catch (\Exception $e) {
        return '<h3>View paths check results:</h3><ul><li>' . implode('</li><li>', $results) . '</li></ul>' .
               '<h3>Error when rendering view:</h3><p>' . $e->getMessage() . '</p>';
    }
});

// Route to test SimplePage controller without plugin middleware
Route::get('/panel/simplepage-direct', function() {
    try {
        $controller = app(\App\Plugins\SimplePage\Controllers\SimplePageController::class);
        return $controller->index();
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage() . '<br>File: ' . $e->getFile() . '<br>Line: ' . $e->getLine();
    }
});

// Route to create example plugin entry in database
Route::get('/panel/create-example-plugin', function() {
    $examplePlugin = \App\Models\Plugin::firstOrCreate(
        ['name' => 'ContohPlugin'],
        [
            'title' => 'Contoh Plugin',
            'version' => '1.0.0',
            'description' => 'Plugin contoh untuk pengembang - Plugin dengan struktur standar',
            'author' => 'StelloCMS Developer',
            'author_url' => 'https://stello-cms.com',
            'category' => 'utility',
            'screenshot' => '',
            'tags' => json_encode(['example', 'sample', 'template']),
            'installed' => true,
            'active' => true,
        ]
    );
    
    if ($examplePlugin->wasRecentlyCreated) {
        return 'ContohPlugin created successfully in database';
    } else {
        return 'ContohPlugin already exists in database';
    }
});

// Route to install example plugin through PluginManager
Route::get('/panel/install-example-plugin', function() {
    try {
        $pluginManager = app(\App\Services\PluginManager::class);
        
        // Check if plugin exists in filesystem
        $pluginPath = app_path('Plugins/ContohPlugin');
        if (!file_exists($pluginPath)) {
            return 'Plugin ContohPlugin not found in filesystem at: ' . $pluginPath;
        }
        
        // Use PluginManager to properly install the plugin
        $result = $pluginManager->installPlugin('ContohPlugin');
        
        if ($result) {
            return 'ContohPlugin installed successfully through PluginManager';
        } else {
            return 'Failed to install ContohPlugin through PluginManager';
        }
    } catch (\Exception $e) {
        return 'Error installing ContohPlugin: ' . $e->getMessage();
    }
});

// Route to check example plugin status
Route::get('/panel/check-example-plugin', function() {
    $output = '<h3>ContohPlugin Status Check</h3>';
    
    if (!auth()->check()) {
        return 'No user is logged in';
    }
    
    $user = auth()->user();
    $output .= '<h4>Current User:</h4>';
    $output .= '<p>User: ' . $user->name . ' (ID: ' . $user->id . ')</p>';
    $output .= '<p>Role: ' . $user->role->name . ' (ID: ' . $user->role->id . ')</p>';
    
    // Check if plugin directory exists
    $pluginPath = app_path('Plugins/ContohPlugin');
    $pluginExists = file_exists($pluginPath);
    $output .= '<h4>Plugin Directory:</h4>';
    $output .= '<p>Directory exists: ' . ($pluginExists ? 'YES' : 'NO') . '</p>';
    
    // Check if plugin routes file exists
    $routesFile = $pluginPath . '/routes.php';
    $routesExist = file_exists($routesFile);
    $output .= '<p>Routes file exists: ' . ($routesExist ? 'YES' : 'NO') . '</p>';
    
    // Check if plugin json file exists
    $pluginJsonFile = $pluginPath . '/plugin.json';
    $pluginJsonExists = file_exists($pluginJsonFile);
    $output .= '<p>Plugin.json file exists: ' . ($pluginJsonExists ? 'YES' : 'NO') . '</p>';
    
    // Check if controller exists
    $controllerFile = $pluginPath . '/Controllers/ContohPluginController.php';
    $controllerExists = file_exists($controllerFile);
    $output .= '<p>Controller file exists: ' . ($controllerExists ? 'YES' : 'NO') . '</p>';
    
    // Check if database record exists
    $pluginRecord = \App\Models\Plugin::where('name', 'ContohPlugin')->first();
    $dbRecordExists = !!$pluginRecord;
    $output .= '<h4>Database Record:</h4>';
    $output .= '<p>Record exists: ' . ($dbRecordExists ? 'YES' : 'NO') . '</p>';
    if ($dbRecordExists) {
        $output .= '<p>Installed: ' . ($pluginRecord->installed ? 'YES' : 'NO') . '</p>';
        $output .= '<p>Active: ' . ($pluginRecord->active ? 'YES' : 'NO') . '</p>';
    }
    
    // Check if specific route exists
    $routeExists = \Illuminate\Support\Facades\Route::has('contohplugin.index');
    $output .= '<h4>Route Check:</h4>';
    $output .= '<p>Route contohplugin.index exists: ' . ($routeExists ? 'YES' : 'NO') . '</p>';
    
    // Try to access the controller directly
    try {
        $controller = app(\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class);
        $controllerAccessible = true;
        $output .= '<h4>Controller Access:</h4>';
        $output .= '<p>Controller accessible: YES</p>';
    } catch (\Exception $e) {
        $controllerAccessible = false;
        $output .= '<h4>Controller Access Error:</h4>';
        $output .= '<p>Controller accessible: NO</p>';
        $output .= '<p>Error: ' . $e->getMessage() . '</p>';
    }
    
    return $output;
});

// Route to test controller method directly
Route::get('/panel/test-contoh-plugin-controller', function() {
    try {
        $controller = app(\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class);
        
        // Get testimonials for index page
        $testimonials = \App\Plugins\ContohPlugin\Models\ContohPlugin::where('aktif', true)->orderBy('tanggal_dibuat', 'desc')->paginate(10);
        
        // Instead of using view('contohplugin::index'), let's try to render directly
        $viewPath = resource_path('views/theme/admin/' . config('themes.admin', 'adminlte') . '/contohplugin/index.blade.php');
        
        // Check if view exists
        if (view()->exists('contohplugin::index')) {
            return view('contohplugin::index', ['testimonials' => $testimonials]);
        } else {
            $output = '<h3>ContohPlugin View Test</h3>';
            $output .= '<p>View contohplugin::index does not exist</p>';
            
            // Let's check what views are available
            $viewsPath = app_path('Plugins/ContohPlugin/Views');
            if (file_exists($viewsPath)) {
                $output .= '<h4>Available Views in Plugin:</h4>';
                $views = scandir($viewsPath);
                $output .= '<ul>';
                foreach ($views as $view) {
                    if ($view !== '.' && $view !== '..') {
                        $output .= '<li>' . $view . '</li>';
                    }
                }
                $output .= '</ul>';
            } else {
                $output .= '<p>Views directory does not exist</p>';
            }
            
            return $output;
        }
    } catch (\Exception $e) {
        return 'Error in controller method: ' . $e->getMessage() . '<br><br>File: ' . $e->getFile() . '<br>Line: ' . $e->getLine();
    }
});