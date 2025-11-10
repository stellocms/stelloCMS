<?php

use App\Plugins\Berita\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

// Rute untuk admin panel - semua user terotentikasi bisa mengakses
// Pengaturan role spesifik akan dilakukan melalui manajemen menu
Route::prefix('panel/berita')->middleware(['auth'])->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    // Route untuk menampilkan berita di admin (opsional)
    Route::get('/{id}', [BeritaController::class, 'show'])->name('berita.show');
});

// Rute frontend untuk menampilkan berita publik
Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('berita.public.index');
    Route::get('/{id}', [BeritaController::class, 'show'])->name('berita.public.show');
});