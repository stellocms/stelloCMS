<?php
// reset_db.php - Database reset script

// Set the working directory
chdir(dirname(__FILE__));

// Load composer autoloader
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

try {
    // Initialize Laravel application
    $app = require_once 'bootstrap/app.php';
    
    // Register the application with the console kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Get list of migration files
    echo "Dropping and recreating database tables...\n";
    
    // Run migrate:fresh to drop all tables and recreate them
    Artisan::call('migrate:fresh');
    echo Artisan::output();
    
    // Run seeders
    echo "Running seeders...\n";
    Artisan::call('db:seed', ['--class' => 'Database\Seeders\DefaultUsersSeeder']);
    echo Artisan::output();
    
    echo "Database reset and seeding completed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}