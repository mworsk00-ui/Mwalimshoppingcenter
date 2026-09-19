<?php
$page_title = 'Dashboard';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

$sales = $income = $profit = $expenses = 0;
$today_sales = $today_profit = 0;
$low_stock = [];
$recent_sales = [];
$today_txns = 0;

try {
    // Jumla
    $sales = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales")->fetchColumn();
    $expenses = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses")->fetchColumn();

    // Leo
    $today_sales = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales WHERE DATE(created_at)=CURDATE()")->fetchColumn();
    $today_expenses = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses WHERE DATE(created_at)=CURDATE()")->fetchColumn();
    $today_profit = $today_sales - $today_expenses;
    $today_txns = $pdo->query("SELECT COUNT(*) FROM sales WHERE DATE(created_at)=CURDATE()")->fetchColumn();

    // Low stock
    $low_stock = $pdo->query("SELECT product_name, stock_qty FROM products WHERE stock_qty <= 5 AND deleted_at IS NULL ORDER BY stock_qty ASC LIMIT 5")->fetchAll();

    // Recent sales
    $recent_sales = $pdo->query("SELECT s.*, c.customer_name FROM sales s LEFT JOIN customers c ON s.customer_id=c.id ORDER BY s.id DESC LIMIT 5")->fetchAll();
} catch (Exception $e) {}

$income = $sales;
$profit = $sales - $expenses;
?>

<!-- DATE BAR -->
<div class="leo-home-date">
    <span class="leo-home-date-icon"><i class="fas fa-clock"></i></span>
    <span class="leo-home-date-text" id="leoDateText">
        TODAY, <?= strtoupper(date('l F j')) ?>
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
            <div class="leo-summary-cell-value">TSH <?= number_format($sales, 0) ?></div>
        </div>
        <div class="leo-summary-cell">
            <div class="leo-summary-cell-label">Net Income</div>
            <div class="leo-summary-cell-value">TSH <?= number_format($income, 0) ?></div>
        </div>
        <div class="leo-summary-cell">
            <div class="leo-summary-cell-label">Net Profit</div>
            <div class="leo-summary-cell-value">TSH <?= number_format($profit, 0) ?></div>
        </div>
        <div class="leo-summary-cell">
            <div class="leo-summary-cell-label">Expenses</div>
            <div class="leo-summary-cell-value">TSH <?= number_format($expenses, 0) ?></div>
        </div>
    </div>
</div>

<!-- TODAY'S SALES HIGHLIGHT -->
<div class="leo-target" style="background:linear-gradient(135deg,#10B981 0%,#059669 100%);color:#fff;">
    <span class="leo-target-bullseye" style="background:rgba(255,255,255,0.2);color:#fff;">
        <i class="fas fa-shopping-cart"></i>
    </span>
    <div class="leo-target-main">
        <div class="leo-target-top">
            <span class="leo-target-month" style="background:rgba(255,255,255,0.2);color:#fff;">
                <i class="far fa-calendar-alt"></i> Today
            </span>
            <span class="leo-target-month" style="background:rgba(255,255,255,0.2);color:#fff;">
                <?= $today_txns ?> txn<?= $today_txns == 1 ? '' : 's' ?>
            </span>
        </div>
        <div class="leo-target-title" style="color:#fff;">Today's Sales</div>
        <div class="leo-target-desc" style="color:rgba(255,255,255,0.9);">
            TSH <?= number_format($today_sales, 0) ?> · Profit: TSH <?= number_format($today_profit, 0) ?>
        </div>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="leo-home-welcome" style="margin-top:0.5rem;">Quick Actions</div>
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
<div class="leo-quick3" style="margin-top:-0.3rem;">
    <a href="purchase-add.php" class="leo-quick3-btn">
        <span class="leo-quick3-icon"><i class="fas fa-shopping-bag"></i></span>
        <span class="leo-quick3-label">Record<br>Purchases</span>
    </a>
    <a href="expense-add.php" class="leo-quick3-btn">
        <span class="leo-quick3-icon"><i class="fas fa-file-invoice-dollar"></i></span>
        <span class="leo-quick3-label">Record<br>Expenses</span>
    </a>
    <a href="dues.php" class="leo-quick3-btn">
        <span class="leo-quick3-icon"><i class="fas fa-clipboard-list"></i></span>
        <span class="leo-quick3-label">Dues<br>List</span>
    </a>
</div>

<!-- LOW STOCK ALERT -->
<?php if (count($low_stock) > 0): ?>
<div class="leo-panel" style="margin:0.85rem;background:#FEF3C7;border:1px solid #FDE68A;border-radius:14px;padding:1rem;">
    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.75rem;">
        <i class="fas fa-exclamation-triangle" style="color:#D97706;font-size:1.2rem;"></i>
        <div style="flex:1;">
            <div style="font-size:0.95rem;font-weight:800;color:#92400E;">Low Stock Alert</div>
            <div style="font-size:0.78rem;color:#78350F;"><?= count($low_stock) ?> product<?= count($low_stock) == 1 ? '' : 's' ?> running low</div>
        </div>
        <a href="products.php" style="font-size:0.78rem;font-weight:700;color:#92400E;text-decoration:none;">View All →</a>
    </div>
    <?php foreach ($low_stock as $p): ?>
    <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid rgba(146,64,14,0.1);">
        <span style="font-size:0.85rem;font-weight:600;color:#78350F;"><?= htmlspecialchars($p['product_name']) ?></span>
        <span style="font-size:0.85rem;font-weight:800;color:#DC2626;"><?= (int)$p['stock_qty'] ?> left</span>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- RECENT SALES -->
<div class="leo-section" style="margin:0.85rem 0;">
    <div style="display:flex;justify-content:space-between;align-items:center;padding:0 0.15rem 0.5rem;">
        <span style="font-size:0.95rem;font-weight:800;color:#1F2937;">Recent Sales</span>
        <a href="sales.php" style="font-size:0.78rem;font-weight:700;color:#4A90E2;text-decoration:none;">View All →</a>
    </div>
    <?php if (count($recent_sales) > 0): ?>
    <div class="leo-section-card">
        <?php foreach ($recent_sales as $s): ?>
        <div class="leo-person-item">
            <div class="leo-person-avatar" style="background:#E8F8EE;color:#10B981;"><i class="fas fa-receipt"></i></div>
            <div class="leo-person-body">
                <div class="leo-person-name"><?= htmlspecialchars($s['customer_name'] ?? 'Walk-in Customer') ?></div>
                <div class="leo-person-sub"><?= date('d M, H:i', strtotime($s['created_at'])) ?></div>
            </div>
            <div class="leo-person-value up">TSH <?= number_format((float)$s['total_amount'], 0) ?></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="leo-section-card" style="padding:1.5rem;text-align:center;color:#9CA3AF;">
        <i class="fas fa-shopping-cart" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;opacity:0.5;"></i>
        <div style="font-size:0.85rem;">No sales yet. Tap <strong>Record Sales</strong> to start.</div>
    </div>
    <?php endif; ?>
</div>

<!-- BANNER -->
<div class="leo-banner-card">
    <div class="leo-banner-top-line"></div>
    <div class="leo-banner-brand">MWALIM SHOP</div>
    <div class="leo-banner-tagline">Karibu kwenye mfumo wako wa biashara</div>
    <div class="leo-banner-manual">SIMAMIA BIASHARA YAKO</div>
    <div class="leo-banner-footer">Rahisi · Haraka · Salama</div>
    <div class="leo-banner-book">
        <i class="fas fa-store"></i>
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
        text.textContent = 'TODAY, <?= strtoupper(date('l F j')) ?>';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
