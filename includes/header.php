<?php
// includes/header.php
require_once __DIR__ . '/../config/db.php';

// Fetch default business user profile
$stmt = $pdo->query("SELECT * FROM users LIMIT 1");
$user = $stmt->fetch();

$business_name = $user['business_name'] ?? 'Mwalimu Shopping Center';
$user_name = $user['username'] ?? 'Boss Kajuna';
$package_status = $user['package_status'] ?? 'Free Package';
$days_left = $user['package_days_left'] ?? 7;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo htmlspecialchars($business_name); ?></title>
    
    <!-- Google Fonts & FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Top Navigation Bar -->
    <header class="top-bar">
        <div class="user-profile">
            <div class="avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-details">
                <span class="shop-name"><?php echo htmlspecialchars($business_name); ?></span>
                <span class="user-name"><i class="fa-solid fa-crown"></i> <?php echo htmlspecialchars($user_name); ?></span>
            </div>
        </div>
        <div class="top-actions">
            <button class="icon-btn" title="Sync Data"><i class="fa-solid fa-rotate"></i></button>
            <button class="icon-btn" title="Notifications"><i class="fa-regular fa-bell"></i></button>
            <button class="icon-btn" title="Language"><i class="fa-solid fa-language"></i></button>
            <button class="icon-btn" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></button>
        </div>
    </header>

    <!-- Main Mobile Content Container -->
    <main class="app-container">