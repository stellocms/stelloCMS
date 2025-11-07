<?php

// Database configuration from .env
$host = '127.0.0.1';
$dbname = 'stellocms';
$username = 'root';
$password = '';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // First, unset the current default for frontend themes
    $stmt = $pdo->prepare("UPDATE `themes` SET `is_default` = 0 WHERE `type` = 'frontend' AND `is_default` = 1");
    $stmt->execute();
    
    // Set stocker theme as default
    $stmt = $pdo->prepare("
        UPDATE `themes` 
        SET `is_default` = 1,
            `is_active` = 1,
            `is_installed` = 1,
            `updated_at` = ?
        WHERE `name` = 'stocker' AND `type` = 'frontend'
    ");
    
    $now = date('Y-m-d H:i:s');
    $stmt->execute([$now]);
    
    echo "Theme 'stocker' set as default frontend theme successfully.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}