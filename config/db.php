<?php
// config/db.php

// Database Configuration for InfinityFree
define('DB_HOST', 'sql201.infinityfree.com');
define('DB_USER', 'if0_42727461');
define('DB_PASS', 'Mmcenter2026');
define('DB_NAME', 'if0_42727461_mwalimu_shop');

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
