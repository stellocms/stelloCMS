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