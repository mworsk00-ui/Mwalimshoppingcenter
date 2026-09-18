<?php
$page_title = 'Product Sales Report';
require_once __DIR__ . '/config/db.php';
$rows = [];
try {
    $rows = $pdo->query("SELECT p.product_name, COUNT(s.id) AS sales_count, COALESCE(SUM(s.total_amount),0) AS revenue FROM sales s JOIN products p ON s.product_id=p.id GROUP BY p.id ORDER BY revenue DESC LIMIT 50")->fetchAll();
} catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="reports.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Product Sales Report</span>
    </div>
</header>
<div style="padding:0.85rem;">
    <div class="leo-report-filter">
        <div class="leo-report-dates">
            <div class="leo-report-date"><div class="leo-report-date-label">From Date</div><div class="leo-report-date-value"><span><?php echo date('M j, Y'); ?></span><i class="far fa-calendar-alt" style="margin-left:auto;"></i></div></div>
            <div class="leo-report-date"><div class="leo-report-date-label">To Date</div><div class="leo-report-date-value"><span><?php echo date('M j, Y'); ?></span><i class="far fa-calendar-alt" style="margin-left:auto;"></i></div></div>
        </div>
        <div class="leo-report-total">
            <div class="leo-report-total-left">
                <div class="leo-report-total-amount">TSH 0</div>
                <div class="leo-report-total-label">Total Revenue</div>
            </div>
            <?php include __DIR__ . '/includes/period_dropdown.php'; ?>
        </div>
    </div>
</div>
<?php if (empty($rows)): ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-chart-pie"></i></div><h4>No product sales yet</h4></div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($rows as $r): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-box"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($r['product_name']); ?></div>
            <div class="leo-person-sub"><?php echo (int)$r['sales_count']; ?> sales</div>
        </div>
        <div class="leo-person-value up">TSH <?php echo number_format($r['revenue'], 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
