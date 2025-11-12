<?php
// Instal plugin Kategori secara manual ke database

// Kita perlu setting environment dan koneksi database
if (file_exists(__DIR__.'/.env')) {
    $lines = file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Setup PDO connection
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? '3306';
$dbname = $_ENV['DB_DATABASE'] ?? 'stello_cms';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Cek apakah plugin Kategori sudah ada
    $stmt = $pdo->prepare("SELECT * FROM plugins WHERE name = ?");
    $stmt->execute(['Kategori']);
    $plugin = $stmt->fetch();
    
    if ($plugin) {
        echo "Plugin Kategori ditemukan di database\n";
        echo "Status sebelumnya - Installed: " . $plugin['installed'] . ", Active: " . $plugin['active'] . "\n";
        
        // Update status jika belum aktif
        if (!$plugin['active'] || !$plugin['installed']) {
            $updateStmt = $pdo->prepare("UPDATE plugins SET installed = 1, active = 1 WHERE name = ?");
            $updateStmt->execute(['Kategori']);
            echo "Plugin Kategori telah diperbarui statusnya menjadi installed dan active\n";
        }
    } else {
        echo "Plugin Kategori tidak ditemukan di database, menambahkan...\n";
        
        // Tambahkan plugin Kategori ke database
        $insertStmt = $pdo->prepare("
            INSERT INTO plugins (name, title, version, description, author, author_url, category, screenshot, tags, installed, active, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        
        $insertStmt->execute([
            'Kategori', 
            'Kategori', 
            '1.0.0', 
            'Plugin untuk mengelola kategori berita', 
            'stelloCMS Development Team', 
            'https://stellocms.com', 
            'utility', 
            '', 
            json_encode(['kategori', 'berita']), 
            1, // installed
            1  // active
        ]);
        
        echo "Plugin Kategori berhasil ditambahkan ke database\n";
    }
    
    echo "\nPlugin Kategori sekarang siap digunakan. Silakan coba akses kembali panel/kategori\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Pastikan konfigurasi database benar di .env file\n";
}