<?php

use Illuminate\Support\Facades\Route;

// Frontend route
Route::get('/', function () {
    try {
        return view_theme('frontend', 'home.index');
    } catch (\Exception $e) {
        // Fallback jika helper view_theme mengalami error
        return '<!DOCTYPE html>
<html>
<head>
    <title>stelloCMS</title>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di stelloCMS</h1>
        <p>Sistem manajemen konten yang fleksibel dan mudah digunakan.</p>
    </div>
</body>
</html>';
    }
});

// Route alias for Laravel's default login route name - corrected to use full URL
Route::get('/login', function () {
    return redirect(route('panel.login'));
})->name('login');

// All panel routes are now in panel.php which should be in the web middleware group
// Load panel routes
require_once __DIR__.'/panel.php';