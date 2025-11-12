<?php

use Illuminate\Support\Facades\Route;

// Frontend route
Route::get('/', function () {
    try {
        // Ambil menu untuk header
        $headerMenus = \App\Models\Menu::where('type', 'frontend')
                           ->where('position', 'header')
                           ->where('is_active', true)
                           ->orderBy('order')
                           ->get();
                           
        // Ambil widget berdasarkan posisi
        $headerWidgets = \App\Models\Widget::aktif()
                               ->byPosition('header')
                               ->orderBy('order')
                               ->get();
                               
        $sidebarLeftWidgets = \App\Models\Widget::aktif()
                                    ->byPosition('sidebar-left')
                                    ->orderBy('order')
                                    ->get();
                                    
        $sidebarRightWidgets = \App\Models\Widget::aktif()
                                     ->byPosition('sidebar-right')
                                     ->orderBy('order')
                                     ->get();
                                     
        $footerWidgets = \App\Models\Widget::aktif()
                               ->byPosition('footer')
                               ->orderBy('order')
                               ->get();
                               
        $homeWidgets = \App\Models\Widget::aktif()
                             ->byPosition('home')
                             ->orderBy('order')
                             ->get();

        return view_theme('frontend', 'home.index', compact(
            'headerMenus',
            'headerWidgets',
            'sidebarLeftWidgets',
            'sidebarRightWidgets',
            'footerWidgets',
            'homeWidgets'
        ));
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