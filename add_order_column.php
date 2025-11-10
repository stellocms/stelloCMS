<?php
// File sederhana untuk menambahkan kolom order ke tabel menus

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
    
    if (!in_array('order', $columnNames)) {
        DB::statement("ALTER TABLE menus ADD COLUMN `order` INT DEFAULT 0");
        echo "Kolom 'order' berhasil ditambahkan ke tabel menus\n";
    } else {
        echo "Kolom 'order' sudah ada di tabel menus\n";
    }
    
    echo "Proses selesai.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}