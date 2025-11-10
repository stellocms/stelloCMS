<?php

use App\Plugins\ContohPlugin\Controllers\ContohPluginController;
use Illuminate\Support\Facades\Route;

// Rute frontend untuk menampilkan contoh plugin publik
Route::prefix('contohplugin')->group(function () {
    Route::get('/', [ContohPluginController::class, 'frontpageIndex'])->name('contohplugin.index');
    Route::get('/{slug}', [ContohPluginController::class, 'frontpageShow'])->name('contohplugin.frontpage.show');
});
// Rute untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/contohplugin')->middleware(['auth'])->group(function () {
    Route::get('/', [ContohPluginController::class, 'index'])->name('panel.contohplugin.index');
    Route::get('/create', [ContohPluginController::class, 'create'])->name('panel.contohplugin.create');
    Route::post('/', [ContohPluginController::class, 'store'])->name('panel.contohplugin.store');
    Route::get('/{id}/edit', [ContohPluginController::class, 'edit'])->name('panel.contohplugin.edit');
    Route::put('/{id}', [ContohPluginController::class, 'update'])->name('panel.contohplugin.update');
    Route::delete('/{id}', [ContohPluginController::class, 'destroy'])->name('panel.contohplugin.destroy');
    
    // Route untuk menampilkan contoh plugin di admin (opsional)
    Route::get('/{id}', [ContohPluginController::class, 'show'])->name('panel.contohplugin.show');
});

