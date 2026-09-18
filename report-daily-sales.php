<?php
$page_title = 'Daily Sales Report';
require_once __DIR__ . '/config/db.php';
$rows = []; $total = 0;
try {
    $rows = $pdo->query("SELECT DATE(created_at) AS day, COUNT(*) AS txn_count, SUM(total_amount) AS day_total FROM sales GROUP BY DATE(created_at) ORDER BY day DESC LIMIT 30")->fetchAll();
    $total = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales")->fetchColumn();
} catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="reports.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Daily Sales Report</span>
    </div>
</header>
<div style="padding:0.85rem;">
    <div class="leo-report-filter">
        <div class="leo-report-dates">
            <div class="leo-report-date"><div class="leo-report-date-label">From Date</div><div class="leo-report-date-value"><span><?php echo date('M j, Y', strtotime('-30 days')); ?></span><i class="far fa-calendar-alt" style="margin-left:auto;"></i></div></div>
            <div class="leo-report-date"><div class="leo-report-date-label">To Date</div><div class="leo-report-date-value"><span><?php echo date('M j, Y'); ?></span><i class="far fa-calendar-alt" style="margin-left:auto;"></i></div></div>
        </div>
        <div class="leo-report-total">
            <div class="leo-report-total-left">
                <div class="leo-report-total-amount">TSH <?php echo number_format($total, 0); ?></div>
                <div class="leo-report-total-label">Total Sales (30 days)</div>
            </div>
            <?php include __DIR__ . '/includes/period_dropdown.php'; ?>
        </div>
    </div>
</div>
<?php if (empty($rows)): ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-calendar-day"></i></div><h4>No data available</h4></div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($rows as $r): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-calendar-day"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo date('l, M j, Y', strtotime($r['day'])); ?></div>
            <div class="leo-person-sub"><?php echo (int)$r['txn_count']; ?> transactions</div>
        </div>
        <div class="leo-person-value up">TSH <?php echo number_format($r['day_total'], 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
