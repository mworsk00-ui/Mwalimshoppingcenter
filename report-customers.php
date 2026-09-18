<?php
$page_title = 'Customers Report';
require_once __DIR__ . '/config/db.php';
$rows = []; $total_due = 0;
try {
    $rows = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM sales WHERE customer_id=c.id) AS purchases, (SELECT COALESCE(SUM(total_amount),0) FROM sales WHERE customer_id=c.id) AS total_spent FROM customers c ORDER BY total_spent DESC")->fetchAll();
    $total_due = $pdo->query("SELECT COALESCE(SUM(due_amount),0) FROM customers")->fetchColumn();
} catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="reports.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Customers Report</span>
    </div>
</header>
<div style="padding:0.85rem;">
    <div class="leo-report-filter">
        <div class="leo-report-dates">
            <div class="leo-report-date"><div class="leo-report-date-label">Total</div><div class="leo-report-date-value"><span><?php echo count($rows); ?> customers</span></div></div>
            <div class="leo-report-date"><div class="leo-report-date-label">Total Due</div><div class="leo-report-date-value"><span>TSH <?php echo number_format($total_due, 0); ?></span></div></div>
        </div>
        <div class="leo-report-total">
            <div class="leo-report-total-left">
                <div class="leo-report-total-amount"><?php echo count($rows); ?></div>
                <div class="leo-report-total-label">Total Customers</div>
            </div>
            <?php include __DIR__ . '/includes/period_dropdown.php'; ?>
        </div>
    </div>
</div>
<?php if (empty($rows)): ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-users"></i></div><h4>No customers</h4></div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($rows as $r): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><?php echo strtoupper(substr($r['customer_name'], 0, 2)); ?></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($r['customer_name']); ?></div>
            <div class="leo-person-sub"><?php echo (int)$r['purchases']; ?> purchases · <?php echo htmlspecialchars($r['phone'] ?? ''); ?></div>
        </div>
        <div class="leo-person-value up">TSH <?php echo number_format($r['total_spent'], 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
