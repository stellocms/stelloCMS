<?php
// create_sessions_table.php - Create sessions table manually

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
    
    // Create the sessions table if it doesn't exist
    if (!$db->getSchemaBuilder()->hasTable('sessions')) {
        echo "Creating sessions table...\n";
        $db->getSchemaBuilder()->create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        
        echo "Sessions table created successfully!\n";
    } else {
        echo "Sessions table already exists.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}