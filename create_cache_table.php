<?php

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get database connection
$db = DB::connection();

// Create cache table
try {
    // Check if cache table exists
    $cacheTableExists = $db->select("SHOW TABLES LIKE 'cache'");
    
    if (empty($cacheTableExists)) {
        $db->statement("
            CREATE TABLE `cache` (
                `key` VARCHAR(255) NOT NULL PRIMARY KEY,
                `value` MEDIUMTEXT NOT NULL,
                `expiration` INTEGER NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        echo "Table 'cache' created successfully.\n";
    } else {
        echo "Table 'cache' already exists.\n";
    }
    
    // Check if cache_locks table exists
    $cacheLocksTableExists = $db->select("SHOW TABLES LIKE 'cache_locks'");
    
    if (empty($cacheLocksTableExists)) {
        $db->statement("
            CREATE TABLE `cache_locks` (
                `key` VARCHAR(255) NOT NULL PRIMARY KEY,
                `owner` VARCHAR(255) NOT NULL,
                `expiration` INTEGER NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        echo "Table 'cache_locks' created successfully.\n";
    } else {
        echo "Table 'cache_locks' already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}