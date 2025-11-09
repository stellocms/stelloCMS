<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Update-related API routes
Route::get('/check-version', function () {
    // Mock response for version check - replace with actual implementation
    return response()->json([
        'current_version' => config('app.version', '1.0.0'),
        'latest_version' => '1.0.0', // This would normally come from an external source
        'has_update' => false,
        'message' => 'Versi terbaru'
    ]);
})->name('api.check_version');

Route::get('/changelog', function () {
    // Mock response for changelog in markdown format - matches what the JS expects as text
    return response('# Changelog

- Update terbaru
- Perbaikan bug
- Fitur tambahan');
})->name('api.changelog');

Route::post('/update', function () {
    // Mock response for update - replace with actual implementation
    return response()->json([
        'success' => true,
        'message' => 'Pembaruan berhasil dilakukan'
    ]);
})->name('api.update');