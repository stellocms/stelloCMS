<?php

use App\Plugins\Berita\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

// Rute frontend untuk menampilkan berita publik
Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaController::class, 'publicIndex'])->name('berita.index');
    Route::get('/{slug}', [BeritaController::class, 'publicShow'])->name('berita.show');
});

// Rute untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/berita')->middleware(['auth'])->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('panel.berita.index');
    Route::get('/create', [BeritaController::class, 'create'])->name('panel.berita.create');
    Route::post('/', [BeritaController::class, 'store'])->name('panel.berita.store');
    Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('panel.berita.edit');
    Route::put('/{id}', [BeritaController::class, 'update'])->name('panel.berita.update');
    Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('panel.berita.destroy');

    // Route untuk menampilkan berita di admin (opsional)
    Route::get('/{id}', [BeritaController::class, 'show'])->name('panel.berita.show');
});

