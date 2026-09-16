<?php
$page_title = 'Sales Report';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
$total = 0;
try { $total = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales")->fetchColumn(); } catch (Exception $e) {}
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Sales Report</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-header-icon"><i class="fas fa-search"></i></button>
    </div>
</header>

<div style="padding:0.85rem;">
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
                <div class="leo-report-total-label">Total Sales</div>
            </div>
            <button class="leo-report-total-btn">Today <i class="fas fa-chevron-down"></i></button>
        </div>
    </div>
</div>

<div class="leo-empty">
    <div class="leo-empty-img"><i class="fas fa-chart-line"></i></div>
    <h4>Please Add a Sale</h4>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
