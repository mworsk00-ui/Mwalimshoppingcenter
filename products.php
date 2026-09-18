
<?php
$page_title = 'Products';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

$products = [];
$total_cost = $total_revenue = $total_profit = 0;
try {
    $products = $pdo->query("SELECT * FROM products ORDER BY product_name ASC")->fetchAll();
    foreach ($products as $p) {
        $cost = ($p['purchase_price'] ?? 0) * ($p['stock_qty'] ?? 0);
        $revenue = ($p['price'] ?? 0) * ($p['stock_qty'] ?? 0);
        $total_cost += $cost;
        $total_revenue += $revenue;
    }
    $total_profit = $total_revenue - $total_cost;
} catch (Exception $e) {}
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Products</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="product-add.php" class="leo-header-icon"><i class="fas fa-plus-square"></i></a>
        <button class="leo-filter-btn" onclick="toggleFilter('filterDropdown')">All <i class="fas fa-chevron-down"></i></button>
    </div>
    <div class="leo-filter-dropdown" id="filterDropdown">
        <div class="leo-filter-option active" onclick="selectFilter(this,'All')"><span class="check"><i class="fas fa-check"></i></span> All</div>
        <div class="leo-filter-option" onclick="selectFilter(this,'Low Stock')"><span class="check"><i class="fas fa-check"></i></span> Low Stock</div>
        <div class="leo-filter-option" onclick="selectFilter(this,'Expiring')"><span class="check"><i class="fas fa-check"></i></span> Expiring</div>
    </div>
</header>

<div class="leo-search-row">
    <div class="leo-page-search-bar">
        <i class="fas fa-search" style="color:#9CA3AF;"></i>
        <input type="text" placeholder="Search Here....">
    </div>
</div>

<?php if (empty($products)): ?>
<div class="leo-empty">
    <div class="leo-empty-img"><i class="fas fa-shopping-basket"></i></div>
    <h4>No product found</h4>
</div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($products as $p): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-box"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($p['product_name']); ?></div>
            <div class="leo-person-sub">Stock: <?php echo (int)($p['stock_qty'] ?? 0); ?> units</div>
        </div>
        <div class="leo-person-value up">TSH <?php echo number_format($p['price'] ?? 0, 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div style="height:120px;"></div>
<div class="leo-totals-footer">
    <div class="leo-totals-row">
        <span class="leo-totals-label">Total Inventory Cost</span>
        <span class="leo-totals-value">TSH <?php echo number_format($total_cost, 0); ?></span>
    </div>
    <div class="leo-totals-row">
        <span class="leo-totals-label">Estimated Sales Revenue</span>
        <span class="leo-totals-value">TSH <?php echo number_format($total_revenue, 0); ?></span>
    </div>
    <div class="leo-totals-row">
        <span class="leo-totals-label">Estimated Gross Profit</span>
        <span class="leo-totals-value leo-totals-value--profit">TSH <?php echo number_format($total_profit, 0); ?></span>
    </div>
</div>

<a href="product-add.php" class="leo-fab"><i class="fas fa-plus"></i></a>

<script>
function toggleFilter(id) {
    document.getElementById(id).classList.toggle('show');
}
function selectFilter(el, name) {
    document.querySelectorAll('#filterDropdown .leo-filter-option').forEach(function(o){o.classList.remove('active');});
    el.classList.add('active');
    document.getElementById('filterDropdown').classList.remove('show');
}
document.addEventListener('click', function(e){
    if (!e.target.closest('.leo-filter-dropdown') && !e.target.closest('.leo-filter-btn')) {
        document.querySelectorAll('.leo-filter-dropdown').forEach(function(d){d.classList.remove('show');});
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
PHPEOF