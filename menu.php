cat > ~/Mwalimshoppingcenter/menu.php << 'PHPEOF'
<?php
$page_title = 'Menu';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- DASHBOARD -->
<div class="leo-section">
    <div class="leo-section-title">Dashboard</div>
    <div class="leo-section-card">
        <a href="index.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-th-large"></i></span>
            <span class="leo-menu-item-label">View Dashboard</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- PAYMENTS -->
<div class="leo-section">
    <div class="leo-section-title">Payments</div>
    <div class="leo-section-card">
        <a href="payment-modes.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-credit-card"></i></span>
            <span class="leo-menu-item-label">Modes of Payment</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- PEOPLE -->
<div class="leo-section">
    <div class="leo-section-title">People</div>
    <div class="leo-section-card">
        <a href="customers.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-users"></i></span>
            <span class="leo-menu-item-label">Customers</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="suppliers.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-truck"></i></span>
            <span class="leo-menu-item-label">Suppliers</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="employees.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-user-tie"></i></span>
            <span class="leo-menu-item-label">Employees</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="announcements.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-bullhorn"></i></span>
            <span class="leo-menu-item-label">Announcements</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="sms.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-comment-sms"></i></span>
            <span class="leo-menu-item-label">SMS Broadcasts</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- HRM -->
<div class="leo-section">
    <div class="leo-section-title">Human Resource Management</div>
    <div class="leo-section-card">
        <a href="hrm.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-users-cog"></i></span>
            <span class="leo-menu-item-label">Human Resources</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- HOTEL -->
<div class="leo-section">
    <div class="leo-section-title">Hotel Management</div>
    <div class="leo-section-card">
        <a href="hotel.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-hotel"></i></span>
            <span class="leo-menu-item-label">Hotel Management</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- PRODUCTS MANAGEMENT -->
<div class="leo-section">
    <div class="leo-section-title">Products Management</div>
    <div class="leo-section-card">
        <a href="products.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-gift"></i></span>
            <span class="leo-menu-item-label">Products</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="categories.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-list"></i></span>
            <span class="leo-menu-item-label">Product Category</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="brands.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-tag"></i></span>
            <span class="leo-menu-item-label">Brands</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="units.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-layer-group"></i></span>
            <span class="leo-menu-item-label">Units</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="taxes.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-invoice"></i></span>
            <span class="leo-menu-item-label">Taxes</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- INVENTORY MANAGEMENT -->
<div class="leo-section">
    <div class="leo-section-title">Inventory Management</div>
    <div class="leo-section-card">
        <a href="stock-adjustment.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-boxes"></i></span>
            <span class="leo-menu-item-label">Stock Adjustment</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="stock-transfer.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-exchange-alt"></i></span>
            <span class="leo-menu-item-label">Stock Transfer</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="adjustment-history.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-history"></i></span>
            <span class="leo-menu-item-label">Adjustment History</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- SERVICE MANAGEMENT -->
<div class="leo-section">
    <div class="leo-section-title">Service Management</div>
    <div class="leo-section-card">
        <a href="services.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-hands-helping"></i></span>
            <span class="leo-menu-item-label">Services</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- CASHBOOK -->
<div class="leo-section">
    <div class="leo-section-title">Cashbook</div>
    <div class="leo-section-card">
        <a href="cashbook.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-book"></i></span>
            <span class="leo-menu-item-label">View Cashbook</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- SALES -->
<div class="leo-section">
    <div class="leo-section-title">Sales</div>
    <div class="leo-section-card">
        <a href="sales.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-shopping-cart"></i></span>
            <span class="leo-menu-item-label">Sales List</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="sales-return.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-undo"></i></span>
            <span class="leo-menu-item-label">Sales Return</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="proforma.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-alt"></i></span>
            <span class="leo-menu-item-label">Proforma Invoice List</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="delivery-notes.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-truck"></i></span>
            <span class="leo-menu-item-label">Delivery Note List</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- PURCHASES -->
<div class="leo-section">
    <div class="leo-section-title">Purchases</div>
    <div class="leo-section-card">
        <a href="purchases.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-clipboard-list"></i></span>
            <span class="leo-menu-item-label">Purchases List</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="purchases-return.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-import"></i></span>
            <span class="leo-menu-item-label">Purchases Return</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="purchase-procurement.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-file-invoice"></i></span>
            <span class="leo-menu-item-label">Purchase Procurement</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- EXPENSES -->
<div class="leo-section">
    <div class="leo-section-title">Expenses</div>
    <div class="leo-section-card">
        <a href="expenses.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-wallet"></i></span>
            <span class="leo-menu-item-label">Expenses List</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
        <a href="expense-categories.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-folder"></i></span>
            <span class="leo-menu-item-label">Expenses Category</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- PRODUCT PRICE -->
<div class="leo-section">
    <div class="leo-section-title">Product Price</div>
    <div class="leo-section-card">
        <a href="product-price.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-money-bill-wave"></i></span>
            <span class="leo-menu-item-label">Product Price</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<!-- PRODUCT PURCHASE PRICE -->
<div class="leo-section">
    <div class="leo-section-title">Product Purchase Price</div>
    <div class="leo-section-card">
        <a href="product-purchase-price.php" class="leo-menu-item">
            <span class="leo-menu-item-icon"><i class="fas fa-money-check-alt"></i></span>
            <span class="leo-menu-item-label">Product Purchase Price</span>
            <span class="leo-menu-item-arrow"><i class="fas fa-chevron-right"></i></span>
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
PHPEOF