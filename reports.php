<?php
// reports.php
require_once 'includes/header.php';

// Determine active filter (default: today)
$filter = $_GET['filter'] ?? 'today';

// SQL Date condition mapping
switch ($filter) {
    case 'week':
        $date_condition = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        $filter_label = "This Week";
        break;
    case 'month':
        $date_condition = "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        $filter_label = "This Month (" . date('F Y') . ")";
        break;
    case 'year':
        $date_condition = "YEAR(created_at) = YEAR(CURDATE())";
        $filter_label = "This Year (" . date('Y') . ")";
        break;
    case 'today':
    default:
        $date_condition = "DATE(created_at) = CURDATE()";
        $filter_label = "Today (" . date('M j, Y') . ")";
        break;
}

// Dynamic Filtered Calculations
$filtered_sales_stmt = $pdo->query("SELECT SUM(total_amount) AS total FROM sales WHERE {$date_condition}");
$filtered_sales = $filtered_sales_stmt->fetch()['total'] ?? 0;

$filtered_expenses_stmt = $pdo->query("SELECT SUM(amount) AS total FROM expenses WHERE {$date_condition}");
$filtered_expenses = $filtered_expenses_stmt->fetch()['total'] ?? 0;

$filtered_profit = $filtered_sales - $filtered_expenses;

// Overall Lifetime Totals
$total_sales = $pdo->query("SELECT SUM(total_amount) AS total FROM sales")->fetch()['total'] ?? 0;
$total_expenses = $pdo->query("SELECT SUM(amount) AS total FROM expenses")->fetch()['total'] ?? 0;
$net_profit = $total_sales - $total_expenses;

// Low Stock Alert (Products with 5 or fewer items remaining)
$low_stock_products = $pdo->query("SELECT * FROM products WHERE stock_qty <= 5 ORDER BY stock_qty ASC")->fetchAll();
?>

<!-- Timeframe Filter Buttons Bar -->
<div class="card" style="padding: 8px; margin-bottom: 12px;">
    <div style="display: flex; gap: 6px; justify-content: space-between;">
        <a href="reports.php?filter=today" style="flex: 1; text-align: center; padding: 8px 4px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; background: <?php echo $filter === 'today' ? 'var(--primary-green)' : '#f0f0f0'; ?>; color: <?php echo $filter === 'today' ? '#fff' : '#333'; ?>;">
            Day
        </a>
        <a href="reports.php?filter=week" style="flex: 1; text-align: center; padding: 8px 4px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; background: <?php echo $filter === 'week' ? 'var(--primary-green)' : '#f0f0f0'; ?>; color: <?php echo $filter === 'week' ? '#fff' : '#333'; ?>;">
            Week
        </a>
        <a href="reports.php?filter=month" style="flex: 1; text-align: center; padding: 8px 4px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; background: <?php echo $filter === 'month' ? 'var(--primary-green)' : '#f0f0f0'; ?>; color: <?php echo $filter === 'month' ? '#fff' : '#333'; ?>;">
            Month
        </a>
        <a href="reports.php?filter=year" style="flex: 1; text-align: center; padding: 8px 4px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; background: <?php echo $filter === 'year' ? 'var(--primary-green)' : '#f0f0f0'; ?>; color: <?php echo $filter === 'year' ? '#fff' : '#333'; ?>;">
            Year
        </a>
    </div>
</div>

<!-- Revenue Target / Goal Progress Card (Filtered) -->
<div class="card summary-card">
    <div class="summary-title">
        <span>Performance Summary</span>
        <span style="font-size: 11px; opacity: 0.85;"><?php echo $filter_label; ?></span>
    </div>
    <div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
        <div>
            <div style="font-size: 11px; opacity: 0.9;">Total Revenue</div>
            <div style="font-size: 18px; font-weight: 700; margin-top: 2px;">TSH <?php echo number_format($filtered_sales, 0); ?></div>
        </div>
        <div>
            <div style="font-size: 11px; opacity: 0.9;">Net Profit</div>
            <div style="font-size: 18px; font-weight: 700; margin-top: 2px;">TSH <?php echo number_format($filtered_profit, 0); ?></div>
        </div>
    </div>
</div>

<!-- All-Time Financial Overview -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--dark-forest); margin-bottom: 12px;"><i class="fa-solid fa-chart-pie"></i> Lifetime Overview</h3>
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--bg-light); border-radius: 6px;">
            <span style="font-size: 13px; font-weight: 500;">Total Sales Recorded:</span>
            <strong style="color: var(--primary-green); font-size: 14px;">TSH <?php echo number_format($total_sales, 0); ?></strong>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--bg-light); border-radius: 6px;">
            <span style="font-size: 13px; font-weight: 500;">Total Expenses Recorded:</span>
            <strong style="color: #d32f2f; font-size: 14px;">TSH <?php echo number_format($total_expenses, 0); ?></strong>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--accent-green); border-radius: 6px; border: 1px solid var(--accent-green-border);">
            <span style="font-size: 13px; font-weight: 700; color: var(--dark-forest);">Net Profit:</span>
            <strong style="color: var(--primary-green-dark); font-size: 15px;">TSH <?php echo number_format($net_profit, 0); ?></strong>
        </div>
    </div>
</div>

<!-- Stock Inventory Alerts -->
<div class="card">
    <h3 style="font-size: 15px; color: #d32f2f; margin-bottom: 12px;"><i class="fa-solid fa-triangle-exclamation"></i> Low Stock Warnings</h3>
    <?php if (empty($low_stock_products)): ?>
        <p style="color: var(--primary-green); font-size: 13px; font-weight: 500;">All inventory levels are healthy!</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <?php foreach ($low_stock_products as $item): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #fff3e0; border-radius: 6px; border-left: 3px solid #ff9800;">
                    <div>
                        <strong style="font-size: 13px; display: block; color: var(--text-main);"><?php echo htmlspecialchars($item['product_name']); ?></strong>
                        <span style="font-size: 11px; color: #e65100; font-weight: 600;">Only <?php echo $item['stock_qty']; ?> items left in stock</span>
                    </div>
                    <a href="products.php" style="font-size: 12px; color: var(--primary-green); text-decoration: none; font-weight: bold;">Restock</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/nav.php'; ?>