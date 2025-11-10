<?php
require_once 'vendor/autoload.php';

// Set up Laravel environment
use Illuminate\Support\Facades\DB;

// Create a simple script to check menu data
try {
    // Include Laravel bootstrap
    if (file_exists(__DIR__.'/vendor/autoload.php')) {
        include_once __DIR__.'/vendor/autoload.php';
    }
    
    // Create Laravel app instance
    $app = require_once __DIR__.'/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Get menu data
    $menus = DB::table('menus')->get();
    
    echo "Jumlah menu: " . count($menus) . "\n";
    echo "Daftar menu:\n";
    
    foreach($menus as $menu) {
        echo "- ID: {$menu->id}, Name: {$menu->name}, Title: {$menu->title}, Type: {$menu->type}, Position: {$menu->position}, Plugin: {$menu->plugin_name}, Parent: {$menu->parent_id}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}