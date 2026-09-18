<?php
$page_title = 'Brands';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
$brands = [];
try { $brands = $pdo->query("SELECT * FROM brands ORDER BY brand_name ASC")->fetchAll(); } catch (Exception $e) {}
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Brands</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="brand-add.php" class="leo-header-icon"><i class="fas fa-plus-square"></i></a>
    </div>
</header>
<div class="leo-page-search">
    <div class="leo-page-search-bar">
        <i class="fas fa-search" style="color:#9CA3AF;"></i>
        <input type="text" placeholder="Search here...">
        <span class="leo-scan"><i class="fas fa-barcode"></i></span>
    </div>
</div>
<?php if (empty($brands)): ?>
<div class="leo-empty">
    <div class="leo-empty-img"><i class="fas fa-cube"></i></div>
    <h4>No brand found</h4>
    <p>Tap the + button to add your first brand</p>
</div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($brands as $b): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-cube"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($b['brand_name']); ?></div>
        </div>
        <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<a href="brand-add.php" class="leo-fab"><i class="fas fa-plus"></i></a>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
