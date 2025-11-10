<?php
// File sederhana untuk menambahkan kolom ke tabel menus

// Mulai sesi Laravel
require_once __DIR__.'/vendor/autoload.php';

// Dapatkan instance aplikasi
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

// Tambahkan kolom jika belum ada
try {
    $columns = DB::select("SHOW COLUMNS FROM menus");
    $columnNames = array_column($columns, 'Field');
    
    if (!in_array('type', $columnNames)) {
        DB::statement("ALTER TABLE menus ADD COLUMN type VARCHAR(255) DEFAULT 'admin'");
        echo "Kolom 'type' berhasil ditambahkan ke tabel menus\n";
    } else {
        echo "Kolom 'type' sudah ada di tabel menus\n";
    }
    
    if (!in_array('position', $columnNames)) {
        DB::statement("ALTER TABLE menus ADD COLUMN position ENUM('header', 'sidebar-left', 'sidebar-right', 'footer') DEFAULT 'header'");
        echo "Kolom 'position' berhasil ditambahkan ke tabel menus\n";
    } else {
        echo "Kolom 'position' sudah ada di tabel menus\n";
    }
    
    // Update beberapa menu yang sudah ada untuk frontend
    // Misalnya, kita bisa mengatur bahwa menu yang tidak memiliki plugin_name adalah menu frontend
    DB::statement("UPDATE menus SET type = 'frontend', position = 'header' WHERE type = 'admin' AND plugin_name IS NULL AND (roles IS NULL OR roles = '[]')");
    echo "Beberapa menu frontend telah diperbarui\n";
    
    echo "Proses selesai.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}