<?php
$page_title = $page_title ?? 'Dashboard';
$user_name = 'BaiNet';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#4A90E2">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Leo Sales">
    <title><?php echo $page_title; ?> | Leo Sales</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/leo-style.css">
</head>
<body>

<div class="leo-splash" id="leoSplash">
    <div class="leo-splash-icon"><i class="fas fa-store"></i></div>
    <h1>Leo Sales</h1>
    <p>Business Management</p>
</div>

<header class="leo-app-header">
    <div class="leo-app-header-left">
        <div class="leo-app-avatar"><i class="fas fa-user"></i></div>
        <div class="leo-app-name"><?php echo htmlspecialchars($user_name); ?></div>
    </div>
    <div class="leo-app-header-right">
        <button class="leo-header-icon" onclick="location.reload()"><i class="fas fa-sync-alt"></i></button>
        <button class="leo-header-icon"><i class="fas fa-bell"></i></button>
        <button class="leo-header-icon"><i class="fas fa-language"></i></button>
        <button class="leo-header-icon" onclick="alert('Logout')"><i class="fas fa-sign-out-alt"></i></button>
    </div>
</header>

<main class="leo-app-content">