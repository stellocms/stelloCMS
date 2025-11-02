<?php

use Illuminate\Support\Facades\Route;

// Frontend route
Route::get('/', function () {
    return view_theme('frontend', 'home.index');
});

// Route alias for Laravel's default login route name - corrected to use full URL
Route::get('/login', function () {
    return redirect(route('panel.login'));
})->name('login');

// All panel routes are now in panel.php which should be in the web middleware group
// Load panel routes
require_once __DIR__.'/panel.php';