<?php
// test_routes.php - Test if routes are working correctly

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing routes...\n";

// Test if berita.index route exists
if (app('router')->has('berita.index')) {
    echo "✓ berita.index route exists\n";
    echo "Route URL: " . route('berita.index') . "\n";
} else {
    echo "✗ berita.index route does not exist\n";
}

echo "All routes:\n";
$routes = app('router')->getRoutes();
foreach ($routes as $route) {
    if (strpos($route->getName(), 'berita') !== false) {
        echo "- " . $route->getName() . ": " . $route->uri() . "\n";
    }
}