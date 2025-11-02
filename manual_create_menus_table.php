<?php
// manual_create_menus_table.php - Create menus table manually

// Set the working directory
chdir(dirname(__FILE__));

// Load composer autoloader
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Initialize Laravel application
    $app = require_once 'bootstrap/app.php';
    
    // Register the application with the console kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Get the database connection
    $db = $app->make('db');
    
    // Test the connection
    echo "Testing database connection...\n";
    $pdo = $db->connection()->getPdo();
    echo "Connection successful!\n";
    
    // Create the menus table if it doesn't exist
    if (!$db->getSchemaBuilder()->hasTable('menus')) {
        echo "Creating menus table...\n";
        $db->getSchemaBuilder()->create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('route')->nullable();
            $table->string('url')->nullable();
            $table->string('icon')->default('fas fa-cube');
            $table->integer('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('plugin_name')->nullable(); // Menandai menu milik plugin mana
            $table->json('roles')->nullable(); // Role yang bisa mengakses menu ini
            $table->timestamps();
        });
        
        echo "Menus table created successfully!\n";
    } else {
        echo "Menus table already exists.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}