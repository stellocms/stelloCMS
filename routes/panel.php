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
    
    // Plugin management routes
    Route::get('/panel/plugins', [PluginController::class, 'index'])->name('plugins.index');
    Route::post('/panel/plugins/{pluginName}/activate', [PluginController::class, 'activate'])->name('plugins.activate');
    Route::post('/panel/plugins/{pluginName}/deactivate', [PluginController::class, 'deactivate'])->name('plugins.deactivate');
    Route::post('/panel/plugins/{pluginName}/install', [PluginController::class, 'install'])->name('plugins.install');
    Route::delete('/panel/plugins/{pluginName}/uninstall', [PluginController::class, 'uninstall'])->name('plugins.uninstall');
    
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