<?php
// index.php
require_once 'includes/header.php';

// Fetch Saved System Settings from Database
$raw_settings = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll(PDO::FETCH_KEY_PAIR);
$package_status = $raw_settings['system_status'] ?? 'FULL SYSTEM';
$days_left = 'ALWAYS ACTIVE';

// Fetch Today's Financial Totals (SQL)
$today = date('Y-m-d');

// Today's Sales (Includes product sales and service transactions)
$sales_stmt = $pdo->prepare("SELECT SUM(total_amount) AS total_sales FROM sales WHERE DATE(created_at) = ?");
$sales_stmt->execute([$today]);
$today_sales = $sales_stmt->fetch()['total_sales'] ?? 0;

// Today's Expenses
$expenses_stmt = $pdo->prepare("SELECT SUM(amount) AS total_expenses FROM expenses WHERE DATE(created_at) = ?");
$expenses_stmt->execute([$today]);
$today_expenses = $expenses_stmt->fetch()['total_expenses'] ?? 0;

// Net Income / Profit Calculation
$net_profit = $today_sales - $today_expenses;
?>

<!-- Date Bar -->
<div class="card" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px;">
    <div style="display: flex; align-items: center; gap: 8px; color: var(--primary-green); font-weight: 600; font-size: 13px;">
        <i class="fa-regular fa-clock" style="font-size: 16px;"></i>
        <span>TODAY, <?php echo strtoupper(date('l, F j, Y')); ?></span>
    </div>
    <div style="display: flex; gap: 12px; align-items: center;">
        <a href="settings.php" title="System Settings" style="color: var(--text-muted); text-decoration: none;">
            <i class="fa-solid fa-gear" style="font-size: 16px; cursor: pointer;"></i>
        </a>
        <i class="fa-regular fa-eye" style="color: var(--text-muted); cursor: pointer;"></i>
    </div>
</div>

<!-- Business Overview Summary -->
<div class="card summary-card">
    <div class="summary-title">
        <span>Today's Summary</span>
        <a href="reports.php" style="color: #fff; text-decoration: none; font-size: 12px; opacity: 0.9;">View All <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    <div class="summary-grid">
        <div class="stat-box">
            <div class="stat-label">Sales</div>
            <div class="stat-value">TSH <?php echo number_format($today_sales, 0); ?></div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Net Income</div>
            <div class="stat-value">TSH <?php echo number_format($today_sales, 0); ?></div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Net Profit</div>
            <div class="stat-value">TSH <?php echo number_format($net_profit, 0); ?></div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Expenses</div>
            <div class="stat-value">TSH <?php echo number_format($today_expenses, 0); ?></div>
        </div>
    </div>
</div>

<!-- System Status Banner -->
<div class="card" style="display: flex; align-items: center; justify-content: space-between; border-left: 4px solid var(--primary-green);">
    <div style="display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-shield-halved" style="color: var(--primary-green); font-size: 24px;"></i>
        <div>
            <strong style="font-size: 14px; display: block; color: var(--text-main);"><?php echo htmlspecialchars($package_status); ?></strong>
            <span style="font-size: 12px; color: var(--primary-green); font-weight: 600;"><?php echo $days_left; ?></span>
        </div>
    </div>
    <i class="fa-solid fa-circle-check" style="color: var(--primary-green); font-size: 20px;"></i>
</div>

<!-- 3x3 Menu Action Grid -->
<div class="menu-grid">
    <a href="products.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-box-archive"></i></div>
        <div class="grid-title">Record<br>Products</div>
    </a>
    <a href="customers.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-users-gear"></i></div>
        <div class="grid-title">Record<br>Customers</div>
    </a>
    <a href="sales.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-cart-shopping"></i></div>
        <div class="grid-title">Record<br>Sales</div>
    </a>
    <a href="products.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-cart-flatbed"></i></div>
        <div class="grid-title">Record<br>Purchases</div>
    </a>
    <a href="expenses.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
        <div class="grid-title">Record<br>Expenses</div>
    </a>
    <a href="dues.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-clipboard-list"></i></div>
        <div class="grid-title">Dues<br>List</div>
    </a>
    <a href="services.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-hand-holding-hand"></i></div>
        <div class="grid-title">Record<br>Services</div>
    </a>
    <a href="settings.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-gear"></i></div>
        <div class="grid-title">System<br>Settings</div>
    </a>
    <a href="reports.php" class="grid-card">
        <div class="grid-icon"><i class="fa-solid fa-chart-line"></i></div>
        <div class="grid-title">Sales<br>Report</div>
    </a>
</div>

<?php require_once 'includes/nav.php'; ?>