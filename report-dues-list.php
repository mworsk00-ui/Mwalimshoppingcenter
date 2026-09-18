<?php
$page_title = 'Dues List Report';
require_once __DIR__ . '/config/db.php';
$rows = []; $total = 0;
try {
    $rows = $pdo->query("SELECT * FROM customers WHERE due_amount > 0 ORDER BY due_amount DESC")->fetchAll();
    $total = $pdo->query("SELECT COALESCE(SUM(due_amount),0) FROM customers WHERE due_amount > 0")->fetchColumn();
} catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="reports.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Dues List Report</span>
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
                <div class="leo-report-total-amount" style="color:#EF4444;">TSH <?php echo number_format($total, 0); ?></div>
                <div class="leo-report-total-label">Total Dues</div>
            </div>
            <?php include __DIR__ . '/includes/period_dropdown.php'; ?>
        </div>
    </div>
</div>
<?php if (empty($rows)): ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-file-invoice-dollar"></i></div><h4>No dues</h4></div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($rows as $r): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><?php echo strtoupper(substr($r['customer_name'], 0, 2)); ?></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($r['customer_name']); ?></div>
            <div class="leo-person-sub"><?php echo htmlspecialchars($r['phone'] ?? ''); ?></div>
        </div>
        <div class="leo-person-value down">TSH <?php echo number_format($r['due_amount'], 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
