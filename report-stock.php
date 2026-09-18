<?php
$page_title = 'Stock Report';
require_once __DIR__ . '/config/db.php';
$rows = []; $total_cost = $total_value = 0;
try {
    $rows = $pdo->query("SELECT * FROM products ORDER BY stock_qty ASC")->fetchAll();
    foreach ($rows as $r) {
        $total_cost += ($r['purchase_price'] ?? 0) * ($r['stock_qty'] ?? 0);
        $total_value += ($r['price'] ?? 0) * ($r['stock_qty'] ?? 0);
    }
} catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="reports.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Stock Report</span>
    </div>
</header>
<div style="padding:0.85rem;">
    <div class="leo-report-filter">
        <div class="leo-report-dates">
            <div class="leo-report-date"><div class="leo-report-date-label">Total Cost</div><div class="leo-report-date-value"><span>TSH <?php echo number_format($total_cost, 0); ?></span></div></div>
            <div class="leo-report-date"><div class="leo-report-date-label">Total Value</div><div class="leo-report-date-value"><span>TSH <?php echo number_format($total_value, 0); ?></span></div></div>
        </div>
        <div class="leo-report-total">
            <div class="leo-report-total-left">
                <div class="leo-report-total-amount"><?php echo count($rows); ?> products</div>
                <div class="leo-report-total-label">Total Items</div>
            </div>
            <?php include __DIR__ . '/includes/period_dropdown.php'; ?>
        </div>
    </div>
</div>
<?php if (empty($rows)): ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-warehouse"></i></div><h4>No products</h4></div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($rows as $r): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-box"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($r['product_name']); ?></div>
            <div class="leo-person-sub">Cost: TSH <?php echo number_format($r['purchase_price'] ?? 0, 0); ?> · Price: TSH <?php echo number_format($r['price'] ?? 0, 0); ?></div>
        </div>
        <div class="leo-person-value <?php echo ($r['stock_qty'] <= ($r['low_stock'] ?? 5)) ? 'down' : ''; ?>"><?php echo (int)$r['stock_qty']; ?> units</div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
