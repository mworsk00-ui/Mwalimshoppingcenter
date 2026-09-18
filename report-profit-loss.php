<?php
$page_title = 'Profit and Loss Report';
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

$sales = $expenses = 0;
try {
    $sales = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales WHERE $where")->fetchColumn();
    $expenses = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses WHERE $where")->fetchColumn();
} catch (Exception $e) {}
$profit = $sales - $expenses;

require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="reports.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Profit and Loss Report</span>
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
                <div class="leo-report-total-amount" style="color:<?php echo ($profit >= 0) ? '#10B981' : '#EF4444'; ?>;">TSH <?php echo number_format($profit, 0); ?></div>
                <div class="leo-report-total-label"><?php echo ($profit >= 0) ? 'Net Profit' : 'Net Loss'; ?></div>
            </div>
            <?php include __DIR__ . '/includes/period_dropdown.php'; ?>
        </div>
    </div>
</div>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <div class="leo-person-item">
        <div class="leo-person-avatar" style="background:#E8F8EE;color:#10B981;"><i class="fas fa-arrow-up"></i></div>
        <div class="leo-person-body"><div class="leo-person-name">Total Sales</div></div>
        <div class="leo-person-value up">TSH <?php echo number_format($sales, 0); ?></div>
    </div>
    <div class="leo-person-item">
        <div class="leo-person-avatar" style="background:#FEF0F0;color:#EF4444;"><i class="fas fa-arrow-down"></i></div>
        <div class="leo-person-body"><div class="leo-person-name">Total Expenses</div></div>
        <div class="leo-person-value down">TSH <?php echo number_format($expenses, 0); ?></div>
    </div>
    <div class="leo-person-item" style="background:#F9FAFB;">
        <div class="leo-person-avatar" style="background:<?php echo ($profit >= 0) ? '#E8F8EE' : '#FEF0F0'; ?>;color:<?php echo ($profit >= 0) ? '#10B981' : '#EF4444'; ?>;"><i class="fas fa-equals"></i></div>
        <div class="leo-person-body"><div class="leo-person-name" style="font-weight:800;">Net <?php echo ($profit >= 0) ? 'Profit' : 'Loss'; ?></div></div>
        <div class="leo-person-value <?php echo ($profit >= 0) ? 'up' : 'down'; ?>" style="font-size:1rem;">TSH <?php echo number_format(abs($profit), 0); ?></div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
