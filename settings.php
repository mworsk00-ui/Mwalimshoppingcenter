<?php
$page_title = 'Settings';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Settings</span>
    </div>
</header>

<div style="padding-top:0.5rem;">

    <!-- GENERAL -->
    <div class="leo-section">
        <div class="leo-section-title">General</div>
        <div class="leo-section-card">
            <a href="profile.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-user-circle"></i></span>
                <span class="leo-menu-item-label">Profile</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
            <a href="security.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-shield-alt"></i></span>
                <span class="leo-menu-item-label">Security</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
            <a href="branches.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-sitemap"></i></span>
                <span class="leo-menu-item-label">Major Branches</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
            <a href="shops.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-store"></i></span>
                <span class="leo-menu-item-label">Major Shops</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
        </div>
    </div>

    <!-- BUSINESS -->
    <div class="leo-section">
        <div class="leo-section-title">Business</div>
        <div class="leo-section-card">
            <a href="stock-transfer.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-exchange-alt"></i></span>
                <span class="leo-menu-item-label">Stock Transfer</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
            <a href="proforma-create.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-file-invoice"></i></span>
                <span class="leo-menu-item-label">Create Proforma Invoice</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
            <a href="delivery-note-create.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-truck"></i></span>
                <span class="leo-menu-item-label">Create Delivery Note</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
            <a href="sales-settings.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-shopping-bag"></i></span>
                <span class="leo-menu-item-label">Sales Settings</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
            <a href="sync-offline.php" class="leo-menu-item">
                <span class="leo-menu-item-icon"><i class="fas fa-cloud-download-alt"></i></span>
                <span class="leo-menu-item-label">Synchronize Business Data for Offline Mode</span>
                <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
            </a>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
