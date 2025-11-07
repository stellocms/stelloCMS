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
    
    // Check table structure
    $stmt = $pdo->query("DESCRIBE `themes`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Themes table structure:\n";
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']}" . 
             ($column['Null'] === 'NO' ? ' NOT NULL' : ' NULL') .
             (isset($column['Key']) && $column['Key'] ? " {$column['Key']}" : '') .
             "\n";
    }
    
    // Check unique constraint
    $stmt = $pdo->query("SHOW CREATE TABLE `themes`");
    $tableInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\nTable creation statement:\n";
    echo $tableInfo['Create Table'] . "\n";
    
    // Check current themes
    $stmt = $pdo->query("SELECT * FROM `themes` ORDER BY `id`");
    $themes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nCurrent themes:\n";
    foreach ($themes as $theme) {
        echo "- {$theme['name']} (type: {$theme['type']}, default: {$theme['is_default']})\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}