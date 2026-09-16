<?php
$page_title = 'Dashboard';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

$sales = $income = $profit = $expenses = 0;
try {
    $sales = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales")->fetchColumn();
    $expenses = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses")->fetchColumn();
} catch (Exception $e) {}
$income = $sales;
$profit = $sales - $expenses;
?>

<!-- DATE BAR -->
<div class="leo-home-date">
    <span class="leo-home-date-icon"><i class="fas fa-clock"></i></span>
    <span class="leo-home-date-text" id="leoDateText">
        TODAY, <?php echo strtoupper(date('l F j')); ?>
    </span>
    <button class="leo-home-date-eye" onclick="toggleDate()">
        <i class="fas fa-eye" id="leoDateEye"></i>
    </button>
</div>

<!-- WELCOME -->
<div class="leo-home-welcome">Welcome, Here is your Business Overview</div>

<!-- TODAY'S SUMMARY -->
<div class="leo-summary">
    <div class="leo-summary-top">
        <span class="leo-summary-heading">Today's Summary</span>
        <a href="reports.php" class="leo-summary-viewall">
            View All
            <span class="leo-summary-viewall-circle"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
    <div class="leo-summary-grid">
        <div class="leo-summary-cell">
            <div class="leo-summary-cell-label">Sales</div>
            <div class="leo-summary-cell-value">TSH <?php echo number_format($sales, 0); ?></div>
        </div>
        <div class="leo-summary-cell">
            <div class="leo-summary-cell-label">Net Income</div>
            <div class="leo-summary-cell-value">TSH <?php echo number_format($income, 0); ?></div>
        </div>
        <div class="leo-summary-cell">
            <div class="leo-summary-cell-label">Net Profit</div>
            <div class="leo-summary-cell-value">TSH <?php echo number_format($profit, 0); ?></div>
        </div>
        <div class="leo-summary-cell">
            <div class="leo-summary-cell-label">Expenses</div>
            <div class="leo-summary-cell-value">TSH <?php echo number_format($expenses, 0); ?></div>
        </div>
    </div>
</div>

<!-- TARGET -->
<div class="leo-target">
    <span class="leo-target-bullseye"><i class="fas fa-bullseye"></i></span>
    <div class="leo-target-main">
        <div class="leo-target-top">
            <span class="leo-target-month">
                <i class="far fa-calendar-alt"></i> <?php echo date('F Y'); ?>
            </span>
            <button class="leo-target-set-btn">Set target</button>
        </div>
        <div class="leo-target-title">No revenue target yet</div>
        <div class="leo-target-desc">
            Set a target for <?php echo date('F Y'); ?> to track posted sales against your target.
        </div>
    </div>
</div>

<!-- PACKAGE -->
<div class="leo-package">
    <span class="leo-package-shield"><i class="fas fa-shield-alt"></i></span>
    <div class="leo-package-main">
        <div class="leo-package-title">Free Package</div>
        <div class="leo-package-sub">4 Days left</div>
    </div>
    <span class="leo-package-play"><i class="fas fa-play"></i></span>
</div>

<!-- QUICK 3 -->
<div class="leo-quick3">
    <a href="product-add.php" class="leo-quick3-btn">
        <span class="leo-quick3-icon"><i class="fas fa-cubes"></i></span>
        <span class="leo-quick3-label">Record<br>Products</span>
    </a>
    <a href="customer-add.php" class="leo-quick3-btn">
        <span class="leo-quick3-icon"><i class="fas fa-user-plus"></i></span>
        <span class="leo-quick3-label">Record<br>Customers</span>
    </a>
    <a href="sale-add.php" class="leo-quick3-btn">
        <span class="leo-quick3-icon"><i class="fas fa-cart-plus"></i></span>
        <span class="leo-quick3-label">Record<br>Sales</span>
    </a>
</div>

<!-- GRID 3x3 — FEATURES ZOTE -->
<div class="leo-menu-grid">
    <a href="product-add.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-cubes"></i></span>
        <span class="leo-menu-grid-label">Record<br>Products</span>
    </a>
    <a href="customer-add.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-user-plus"></i></span>
        <span class="leo-menu-grid-label">Record<br>Customers</span>
    </a>
    <a href="sale-add.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-cart-plus"></i></span>
        <span class="leo-menu-grid-label">Record<br>Sales</span>
    </a>

    <a href="purchase-add.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-shopping-cart"></i></span>
        <span class="leo-menu-grid-label">Record<br>Purchases</span>
    </a>
    <a href="expense-add.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-file-invoice-dollar"></i></span>
        <span class="leo-menu-grid-label">Record<br>Expenses</span>
    </a>
    <a href="dues.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-clipboard-list"></i></span>
        <span class="leo-menu-grid-label">Dues List</span>
    </a>

    <a href="service-add.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-hands-helping"></i></span>
        <span class="leo-menu-grid-label">Record<br>Services</span>
    </a>
    <a href="products.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-boxes"></i></span>
        <span class="leo-menu-grid-label">Products List</span>
    </a>
    <a href="report-sales.php" class="leo-menu-grid-btn">
        <span class="leo-menu-grid-icon"><i class="fas fa-chart-line"></i></span>
        <span class="leo-menu-grid-label">Sales Report</span>
    </a>
</div>

<!-- UPDATES BANNER -->
<div class="leo-updates-title">Updates and System Usages</div>
<div class="leo-banner-card">
    <div class="leo-banner-top-line"></div>
    <div class="leo-banner-brand">LEO SALES</div>
    <div class="leo-banner-tagline">The Comprehensive</div>
    <div class="leo-banner-manual">MANUAL GUIDE BOOK</div>
    <div class="leo-banner-footer">Read the book to get full insight</div>
    <div class="leo-banner-book">
        <i class="fas fa-book-open"></i>
    </div>
</div>

<script>
var dateHidden = false;
function toggleDate() {
    var text = document.getElementById('leoDateText');
    var eye = document.getElementById('leoDateEye');
    dateHidden = !dateHidden;
    if (dateHidden) {
        text.textContent = 'TODAY, **********';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        text.textContent = 'TODAY, <?php echo strtoupper(date('l F j')); ?>';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>