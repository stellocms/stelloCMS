<?php
// Script untuk memeriksa route setting

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = app('router')->getRoutes();

echo "Routes yang mengandung 'setting':\n";
foreach ($routes as $route) {
    $routeName = $route->getName();
    $uri = $route->uri();
    if (strpos($routeName, 'setting') !== false || strpos($uri, 'setting') !== false) {
        echo "- Name: {$routeName}, URI: {$uri}, Methods: " . implode(',', $route->methods()) . "\n";
    }
}

echo "\nRoutes yang mengandung 'setting' dalam nama:\n";
foreach ($routes as $route) {
    $routeName = $route->getName();
    if (strpos($routeName, 'setting') !== false) {
        echo "- Name: {$routeName}, URI: {$route->uri()}, Methods: " . implode(',', $route->methods()) . "\n";
    }
}