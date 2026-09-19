<?php
$page_title = 'Products';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Products</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-header-icon"><i class="fas fa-filter"></i></button>
        <button class="leo-header-icon"><i class="fas fa-ellipsis-v"></i></button>
    </div>
</header>

<div class="leo-page-search">
    <div class="leo-page-search-bar">
        <i class="fas fa-search" style="color:#9CA3AF;"></i>
        <input type="text" placeholder="Search here...">
        <span class="leo-scan"><i class="fas fa-barcode"></i></span>
    </div>
</div>

<?php
$products = [];
try {
    $products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
} catch (Exception $e) {}
?>

<?php if (empty($products)): ?>
<div class="leo-empty">
    <div class="leo-empty-img"><i class="fas fa-box-open"></i></div>
    <h4>Product list is empty, Add products</h4>
    <p>Tap the + button to add your first product</p>
</div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($products as $p): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-box"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($p['product_name']); ?></div>
            <div class="leo-person-sub">Stock: <?php echo (int)$p['stock_qty']; ?> units</div>
        </div>
        <div class="leo-person-value up">TSH <?php echo number_format($p['price'] ?? 0, 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<a href="product-add.php" class="leo-fab"><i class="fas fa-plus"></i></a>

<?php require_once __DIR__ . '/includes/footer.php'; ?>