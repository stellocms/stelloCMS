<?php

use App\Plugins\ContohPlugin\Controllers\ContohPluginController;
use Illuminate\Support\Facades\Route;

// Rute untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/contohplugin')->middleware(['auth'])->group(function () {
    Route::get('/', [ContohPluginController::class, 'index'])->name('contohplugin.index');
    Route::get('/create', [ContohPluginController::class, 'create'])->name('contohplugin.create');
    Route::post('/', [ContohPluginController::class, 'store'])->name('contohplugin.store');
    Route::get('/{id}/edit', [ContohPluginController::class, 'edit'])->name('contohplugin.edit');
    Route::put('/{id}', [ContohPluginController::class, 'update'])->name('contohplugin.update');
    Route::delete('/{id}', [ContohPluginController::class, 'destroy'])->name('contohplugin.destroy');
    
    // Route untuk menampilkan contoh plugin di admin (opsional)
    Route::get('/{id}', [ContohPluginController::class, 'show'])->name('contohplugin.show');
});

// Jika perlu rute frontend untuk menampilkan contoh plugin publik (opsional)
// Route::prefix('contoh-plugin')->group(function () {
//     Route::get('/', [ContohPluginController::class, 'index'])->name('contohplugin.public.index');
//     Route::get('/{id}', [ContohPluginController::class, 'show'])->name('contohplugin.public.show');
// });