<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$__user = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Mwalimu';
$__role = $_SESSION['role'] ?? 'Admin';
$__cur  = basename($_SERVER['PHP_SELF'] ?? '');
function drawer_active($files, $current) {
    foreach ((array)$files as $f) {
        if ($f === $current) return 'active';
    }
    return '';
}
?>

<div class="leo-drawer-backdrop" id="leoDrawerBackdrop" onclick="closeDrawer()"></div>

<aside class="leo-drawer" id="leoDrawer">
    <div class="leo-drawer-header">
        <button class="leo-drawer-close" onclick="closeDrawer()" aria-label="Close"><i class="fas fa-times"></i></button>
        <div class="leo-drawer-user">
            <div class="leo-drawer-avatar"><i class="fas fa-user"></i></div>
            <div class="leo-drawer-user-info">
                <div class="leo-drawer-user-name"><?= htmlspecialchars($__user) ?></div>
                <div class="leo-drawer-user-role"><?= htmlspecialchars($__role) ?></div>
            </div>
        </div>
    </div>

    <div class="leo-drawer-body">

        <!-- QUICK ACCESS -->
        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Quick Access</div>
            <a href="product-add.php" class="leo-drawer-item <?= drawer_active('product-add.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-cubes"></i></span> Record Products
            </a>
            <a href="customer-add.php" class="leo-drawer-item <?= drawer_active('customer-add.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-user-plus"></i></span> Record Customers
            </a>
            <a href="sale-add.php" class="leo-drawer-item <?= drawer_active('sale-add.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-cart-plus"></i></span> Record Sales
            </a>
            <a href="purchase-add.php" class="leo-drawer-item <?= drawer_active('purchase-add.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-shopping-bag"></i></span> Record Purchases
            </a>
            <a href="expense-add.php" class="leo-drawer-item <?= drawer_active('expense-add.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-file-invoice-dollar"></i></span> Record Expenses
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Dashboard</div>
            <a href="index.php" class="leo-drawer-item <?= drawer_active('index.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-th-large"></i></span> View Dashboard
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Payments</div>
            <a href="payment-modes.php" class="leo-drawer-item <?= drawer_active('payment-modes.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-credit-card"></i></span> Modes of Payment
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">People</div>
            <a href="customers.php" class="leo-drawer-item <?= drawer_active(['customers.php','customer-edit.php','customer-view.php'], $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-users"></i></span> Customers
            </a>
            <a href="suppliers.php" class="leo-drawer-item <?= drawer_active('suppliers.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-truck"></i></span> Suppliers
            </a>
            <a href="employees.php" class="leo-drawer-item <?= drawer_active('employees.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-user-tie"></i></span> Employees
            </a>
            <a href="dues.php" class="leo-drawer-item <?= drawer_active('dues.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-file-invoice-dollar"></i></span> Dues List
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Supplies / Deliveries</div>
            <a href="supplies.php" class="leo-drawer-item <?= drawer_active('supplies.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-box-open"></i></span> Supplies
            </a>
            <a href="supply-guide.php" class="leo-drawer-item <?= drawer_active('supply-guide.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-circle-question"></i></span> Supplies Guide
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Products Management</div>
            <a href="products.php" class="leo-drawer-item <?= drawer_active('products.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-gift"></i></span> Products List
            </a>
            <a href="categories.php" class="leo-drawer-item <?= drawer_active('categories.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-list"></i></span> Product Category
            </a>
            <a href="brands.php" class="leo-drawer-item <?= drawer_active('brands.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-tag"></i></span> Brands
            </a>
            <a href="units.php" class="leo-drawer-item <?= drawer_active('units.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-layer-group"></i></span> Units
            </a>
            <a href="taxes.php" class="leo-drawer-item <?= drawer_active('taxes.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-file-invoice"></i></span> Taxes
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Inventory Management</div>
            <a href="stock-adjustment.php" class="leo-drawer-item <?= drawer_active('stock-adjustment.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-boxes"></i></span> Stock Adjustment
            </a>
            <a href="stock-transfer.php" class="leo-drawer-item <?= drawer_active('stock-transfer.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-exchange-alt"></i></span> Stock Transfer
            </a>
            <a href="adjustment-history.php" class="leo-drawer-item <?= drawer_active('adjustment-history.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-history"></i></span> Adjustment History
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Service Management</div>
            <a href="services.php" class="leo-drawer-item <?= drawer_active('services.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-hands-helping"></i></span> Services
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Cashbook</div>
            <a href="cashbook.php" class="leo-drawer-item <?= drawer_active('cashbook.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-book"></i></span> View Cashbook
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Sales</div>
            <a href="sales.php" class="leo-drawer-item <?= drawer_active('sales.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-shopping-cart"></i></span> Sales List
            </a>
            <a href="sales-return.php" class="leo-drawer-item <?= drawer_active('sales-return.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-undo"></i></span> Sales Return
            </a>
            <a href="proforma.php" class="leo-drawer-item <?= drawer_active('proforma.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-file-alt"></i></span> Proforma Invoice
            </a>
            <a href="delivery-notes.php" class="leo-drawer-item <?= drawer_active('delivery-notes.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-truck"></i></span> Delivery Notes
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Purchases</div>
            <a href="purchases.php" class="leo-drawer-item <?= drawer_active('purchases.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-clipboard-list"></i></span> Purchases List
            </a>
            <a href="purchases-return.php" class="leo-drawer-item <?= drawer_active('purchases-return.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-file-import"></i></span> Purchases Return
            </a>
            <a href="purchase-procurement.php" class="leo-drawer-item <?= drawer_active('purchase-procurement.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-file-invoice"></i></span> Purchase Procurement
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Expenses</div>
            <a href="expenses.php" class="leo-drawer-item <?= drawer_active('expenses.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-wallet"></i></span> Expenses List
            </a>
            <a href="expense-categories.php" class="leo-drawer-item <?= drawer_active('expense-categories.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-folder"></i></span> Expenses Category
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">Product Price</div>
            <a href="product-price.php" class="leo-drawer-item <?= drawer_active('product-price.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-money-bill-wave"></i></span> Product Price
            </a>
            <a href="product-purchase-price.php" class="leo-drawer-item <?= drawer_active('product-purchase-price.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-money-check-alt"></i></span> Purchase Price
            </a>
        </div>

        <div class="leo-drawer-section">
            <div class="leo-drawer-section-title">System</div>
            <a href="recycle-bin.php" class="leo-drawer-item <?= drawer_active('recycle-bin.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-recycle"></i></span> Recycle Bin
            </a>
            <a href="recycle-bin-guide.php" class="leo-drawer-item <?= drawer_active('recycle-bin-guide.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-circle-question"></i></span> Recycle Bin Guide
            </a>
            <a href="settings.php" class="leo-drawer-item <?= drawer_active('settings.php', $__cur) ?>">
                <span class="leo-drawer-icon"><i class="fas fa-cog"></i></span> Settings
            </a>
        </div>

    </div>

    <a href="logout.php" class="leo-drawer-logout" onclick="return confirm('Logout?')">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</aside>

<script>
function openDrawer() {
    document.getElementById('leoDrawer').classList.add('show');
    document.getElementById('leoDrawerBackdrop').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeDrawer() {
    document.getElementById('leoDrawer').classList.remove('show');
    document.getElementById('leoDrawerBackdrop').classList.remove('show');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDrawer();
});
var __touchStartX = 0;
document.addEventListener('touchstart', function(e) {
    __touchStartX = e.touches[0].clientX;
}, { passive: true });
document.addEventListener('touchend', function(e) {
    var dx = e.changedTouches[0].clientX - __touchStartX;
    if (dx > 80 && __touchStartX < 40) openDrawer();
    if (dx < -80 && document.getElementById('leoDrawer').classList.contains('show')) closeDrawer();
}, { passive: true });
</script>
