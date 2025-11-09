<?php
// File debugging untuk mengetahui masalah route
// Simpan sementara sebagai public/debug_simple.php

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Http\Request;

// Bootstrap aplikasi Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

try {
    // Cek apakah kita bisa membuat kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "Aplikasi Laravel bootstrapped dengan sukses.";
    
    // Cek routes terdaftar
    $routeCollection = $app['router']->getRoutes();
    
    foreach ($routeCollection as $route) {
        if ($route->uri === '/') {
            echo "<br><br>Route / ditemukan:";
            echo "<br>Methods: " . implode(', ', $route->methods);
            echo "<br>Name: " . ($route->getName() ?? 'unnamed');
            echo "<br>Action: " . (is_string($route->getAction()) ? $route->getAction() : json_encode($route->getAction()));
            break;
        }
    }
    
    echo "<br><br>Semua routes yang ditemukan:<br>";
    foreach ($routeCollection as $route) {
        if ($route->uri === '/') {
            echo "Route /: " . implode(',', $route->methods) . "<br>";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<br>File: " . $e->getFile();
    echo "<br>Line: " . $e->getLine();
    echo "<br>Trace: " . $e->getTraceAsString();
}