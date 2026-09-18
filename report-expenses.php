<?php
$page_title = 'Expenses Report';
require_once __DIR__ . '/config/db.php';

$period = $_GET['period'] ?? 'today';
$where = match($period) {
    'today' => "DATE(created_at) = CURDATE()",
    'yesterday' => "DATE(created_at) = CURDATE() - INTERVAL 1 DAY",
    'this_week' => "YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1)",
    'last_week' => "YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1) - 1",
    'this_month' => "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())",
    'last_month' => "MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)",
    'this_year' => "YEAR(created_at) = YEAR(CURDATE())",
    default => "DATE(created_at) = CURDATE()"
};

$rows = []; $total = 0;
try {
    $rows = $pdo->query("SELECT * FROM expenses WHERE $where ORDER BY id DESC")->fetchAll();
    $total = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses WHERE $where")->fetchColumn();
} catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="reports.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Expenses Report</span>
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
                <div class="leo-report-total-amount">TSH <?php echo number_format($total, 0); ?></div>
                <div class="leo-report-total-label">Total Expenses</div>
            </div>
            <?php include __DIR__ . '/includes/period_dropdown.php'; ?>
        </div>
    </div>
</div>
<?php if (empty($rows)): ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-wallet"></i></div><h4>No data available</h4></div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($rows as $r): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar" style="background:#FEF0F0;color:#EF4444;"><i class="fas fa-wallet"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($r['title'] ?? 'Expense'); ?></div>
            <div class="leo-person-sub"><?php echo date('M j, Y', strtotime($r['created_at'])); ?></div>
        </div>
        <div class="leo-person-value down">TSH <?php echo number_format($r['amount'], 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
