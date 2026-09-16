<?php
// config/db.php

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Replace with your database username
define('DB_PASS', '');           // Replace with your database password
define('DB_NAME', 'mwalimu_shop');

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Stop execution and display error if connection fails
    die("Database Connection Failed: " . $e->getMessage());
}
?>