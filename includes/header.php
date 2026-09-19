<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$page_title = $page_title ?? 'Dashboard';
$user_name = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Mwalimu';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#4A90E2">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Mwalim Shop">
    <title><?php echo $page_title; ?> | Mwalim Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/leo-style.css">
</head>
<body>

<div class="leo-splash" id="leoSplash">
    <div class="leo-splash-icon"><i class="fas fa-store"></i></div>
    <h1>Mwalim Shop</h1>
    <p>Business Management</p>
</div>

<!-- SIDEBAR DRAWER -->
<?php require_once __DIR__ . '/sidebar.php'; ?>

<!-- HEADER -->
<header class="leo-app-header">
    <div class="leo-app-header-left">
        <button class="leo-hamburger" onclick="openDrawer()" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>
        <div class="leo-app-avatar"><i class="fas fa-user"></i></div>
        <div class="leo-app-name"><?php echo htmlspecialchars($user_name); ?></div>
    </div>
    <div class="leo-app-header-right">
        <button class="leo-header-icon" onclick="location.reload()"><i class="fas fa-sync-alt"></i></button>
        <button class="leo-header-icon"><i class="fas fa-bell"></i></button>
        <button class="leo-header-icon"><i class="fas fa-language"></i></button>
        <button class="leo-header-icon" onclick="if(confirm('Logout?'))window.location.href='logout.php'"><i class="fas fa-sign-out-alt"></i></button>
    </div>
</header>

<main class="leo-app-content">
