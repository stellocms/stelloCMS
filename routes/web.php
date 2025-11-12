<?php

use Illuminate\Support\Facades\Route;

// Frontend route
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route alias for Laravel's default login route name - corrected to use full URL
Route::get('/login', function () {
    return redirect('/');
})->name('login');

// Captcha route
Route::get('/captcha/refresh', function() {
    $num1 = rand(1, 20);
    $num2 = rand(1, 20);
    $operation = ['+', '-', '*'][array_rand(['+', '-', '*'])];
    
    switch ($operation) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            // Pastikan hasil tidak negatif
            if ($num1 < $num2) {
                list($num1, $num2) = [$num2, $num1];
            }
            $result = $num1 - $num2;
            break;
        case '*':
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
            $result = $num1 * $num2;
            break;
    }
    
    $equation = "$num1 $operation $num2 = ?";
    session(['captcha_result' => $result]);
    
    return response()->json([
        'equation' => $equation,
        'success' => true
    ]);
})->name('captcha.refresh');

// All panel routes are now in panel.php which should be in the web middleware group
// Load panel routes
require_once __DIR__.'/panel.php';