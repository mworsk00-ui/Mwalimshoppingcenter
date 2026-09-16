<?php
$page_title = 'Expenses';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

$expenses = [];
$total = 0;
try {
    $expenses = $pdo->query("SELECT * FROM expenses ORDER BY id DESC LIMIT 50")->fetchAll();
    $total = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses")->fetchColumn();
} catch (Exception $e) {}
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Expenses List</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-header-icon"><i class="fas fa-search"></i></button>
    </div>
</header>

<div style="padding:0.85rem;">
    <!-- Filter -->
    <div class="leo-report-filter">
        <div class="leo-report-dates">
            <div class="leo-report-date">
                <div class="leo-report-date-label">From Date</div>
                <div class="leo-report-date-value">
                    <span><?php echo date('M j, Y'); ?></span>
                    <i class="far fa-calendar-alt" style="margin-left:auto;"></i>
                </div>
            </div>
            <div class="leo-report-date">
                <div class="leo-report-date-label">To Date</div>
                <div class="leo-report-date-value">
                    <span><?php echo date('M j, Y'); ?></span>
                    <i class="far fa-calendar-alt" style="margin-left:auto;"></i>
                </div>
            </div>
        </div>
        <div class="leo-report-total">
            <div class="leo-report-total-left">
                <div class="leo-report-total-amount">TSH <?php echo number_format($total, 0); ?></div>
                <div class="leo-report-total-label">Total Expenses</div>
            </div>
            <button class="leo-report-total-btn">Today <i class="fas fa-chevron-down"></i></button>
        </div>
    </div>
</div>

<?php if (empty($expenses)): ?>
<div class="leo-empty">
    <div class="leo-empty-img"><i class="fas fa-wallet"></i></div>
    <h4>No data available</h4>
</div>
<?php else: ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($expenses as $e): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar" style="background:#FEF0F0;color:#EF4444;"><i class="fas fa-wallet"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($e['title'] ?? 'Expense'); ?></div>
            <div class="leo-person-sub"><?php echo htmlspecialchars($e['created_at'] ?? ''); ?></div>
        </div>
        <div class="leo-person-value down">TSH <?php echo number_format($e['amount'] ?? 0, 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<a href="expense-add.php" class="leo-fab"><i class="fas fa-plus"></i></a>

<?php require_once __DIR__ . '/includes/footer.php'; ?>