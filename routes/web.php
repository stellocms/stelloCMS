<?php

use Illuminate\Support\Facades\Route;

// Frontend route
Route::get('/', function () {
    return view_theme('frontend', 'home.index');
})->name('home');

// Route alias for Laravel's default login route name - corrected to use full URL
Route::get('/login', function () {
    return redirect(route('panel.login'));
})->name('login');

// ContohPlugin frontend routes
Route::prefix('contohplugin')->group(function () {
    Route::get('/', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'frontpageIndex'])->name('contohplugin.frontpage.index');
    Route::get('/{slug}', [\App\Plugins\ContohPlugin\Controllers\ContohPluginController::class, 'frontpageShow'])->name('contohplugin.frontpage.show');
});

// All panel routes are now in panel.php which should be in the web middleware group
// Load panel routes
require_once __DIR__.'/panel.php';