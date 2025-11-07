<?php

use App\Plugins\SimplePage\Controllers\SimplePageController;

Route::middleware(['auth', 'role:admin,kepala-desa,sekdes,kaur,kadus,rw,rt'])->prefix('panel/simplepage')->group(function () {
    Route::get('/', [SimplePageController::class, 'index'])->name('simplepage.index');
    Route::get('/create', [SimplePageController::class, 'create'])->name('simplepage.create');
    Route::post('/', [SimplePageController::class, 'store'])->name('simplepage.store');
    Route::get('/{id}/edit', [SimplePageController::class, 'edit'])->name('simplepage.edit');
    Route::put('/{id}', [SimplePageController::class, 'update'])->name('simplepage.update');
    Route::delete('/{id}', [SimplePageController::class, 'destroy'])->name('simplepage.destroy');
});