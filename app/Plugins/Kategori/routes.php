<?php

use App\Plugins\Kategori\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

// Rute untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/kategori')->middleware(['auth'])->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('panel.kategori.index');
    Route::get('/create', [KategoriController::class, 'create'])->name('panel.kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('panel.kategori.store');
    Route::get('/{id}', [KategoriController::class, 'show'])->name('panel.kategori.show');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('panel.kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('panel.kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('panel.kategori.destroy');
    
    // API untuk mendapatkan kategori aktif
    Route::get('/api/active', [KategoriController::class, 'getActiveCategories'])->name('panel.kategori.api.active');
});