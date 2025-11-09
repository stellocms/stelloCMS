    // Update management routes - placed within the main panel middleware group
    Route::get('/panel/update', [\App\Http\Controllers\UpdateController::class, 'index'])->name('update.index');
    Route::get('/panel/api/check-version', [\App\Http\Controllers\UpdateController::class, 'checkLatestVersion'])->name('api.check_version');
    Route::get('/panel/api/changelog', [\App\Http\Controllers\UpdateController::class, 'getChangelog'])->name('api.changelog');
    Route::post('/panel/api/update', [\App\Http\Controllers\UpdateController::class, 'performUpdate'])->name('api.update');
});