cat > ~/Mwalimshoppingcenter/reports.php << 'PHPEOF'
<?php
$page_title = 'Reports';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="leo-section" style="margin-top:0.5rem;">
    <div class="leo-section-card">

        <a href="report-business-insights.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-th-large"></i></span>
            <span class="leo-menu-item-label">Business Insights</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-sales.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-shopping-cart"></i></span>
            <span class="leo-menu-item-label">Sales Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-daily-sales.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-shopping-bag"></i></span>
            <span class="leo-menu-item-label">Daily Sales Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-product-sales.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-chart-pie"></i></span>
            <span class="leo-menu-item-label">Product Sales Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-employee.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-user-circle"></i></span>
            <span class="leo-menu-item-label">Employee Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-products-performance.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-chart-line"></i></span>
            <span class="leo-menu-item-label">Products Performance Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-inventory-tracking.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-boxes"></i></span>
            <span class="leo-menu-item-label">Inventory Tracking Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-major-shops.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-store"></i></span>
            <span class="leo-menu-item-label">Major Shops Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-major-shops-transactions.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-store-alt"></i></span>
            <span class="leo-menu-item-label">Major Shops Transactions Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-stock-transfer.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-exchange-alt"></i></span>
            <span class="leo-menu-item-label">Stock Transfer Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-stock-tracking.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-cubes"></i></span>
            <span class="leo-menu-item-label">Stock Tracking Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-purchases.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-clipboard-check"></i></span>
            <span class="leo-menu-item-label">Purchases Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-profit-loss.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-hand-holding-usd"></i></span>
            <span class="leo-menu-item-label">Profit and Loss Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-dues-list.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-coins"></i></span>
            <span class="leo-menu-item-label">Dues List Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-dues-payment.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-invoice-dollar"></i></span>
            <span class="leo-menu-item-label">Dues Payment Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-prepaid-list.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-hand-holding-heart"></i></span>
            <span class="leo-menu-item-label">Prepaid List Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-prepaid-transactions.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-invoice"></i></span>
            <span class="leo-menu-item-label">Prepaid Transactions Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-stock.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-warehouse"></i></span>
            <span class="leo-menu-item-label">Stock Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-general.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-alt"></i></span>
            <span class="leo-menu-item-label">General Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-services.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-briefcase"></i></span>
            <span class="leo-menu-item-label">Services Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-stock-expired.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-chart-area"></i></span>
            <span class="leo-menu-item-label">Stock and Expired Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-pending-approvals.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-box-open"></i></span>
            <span class="leo-menu-item-label">Pending Approvals</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-adjustment-history.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-edit"></i></span>
            <span class="leo-menu-item-label">Adjustment History</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-expenses.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-wallet"></i></span>
            <span class="leo-menu-item-label">Expenses Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-customers.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-users"></i></span>
            <span class="leo-menu-item-label">Customers Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-pickup.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-truck-loading"></i></span>
            <span class="leo-menu-item-label">Pickup Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-sales-return.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-undo"></i></span>
            <span class="leo-menu-item-label">Sales Return Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

        <a href="report-purchases-return.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-import"></i></span>
            <span class="leo-menu-item-label">Purchases Return Report</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-play"></i></span>
        </a>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
PHPEOF