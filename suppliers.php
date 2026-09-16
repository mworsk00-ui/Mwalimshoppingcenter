<?php
$page_title = 'Suppliers';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Suppliers</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-header-icon"><i class="fas fa-filter"></i></button>
        <button class="leo-header-icon"><i class="fas fa-search"></i></button>
    </div>
</header>

<div class="leo-empty">
    <div class="leo-empty-img"><i class="fas fa-truck"></i></div>
    <h4>No Supplier Available</h4>
    <p>Tap the + button to add a supplier</p>
</div>

<a href="supplier-add.php" class="leo-fab"><i class="fas fa-plus"></i></a>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
