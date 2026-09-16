<?php
// includes/nav.php
$current = basename($_SERVER['PHP_SELF'] ?? 'index.php');
function nav_active($files, $current) {
    foreach ((array)$files as $f) {
        if ($f === $current) return 'active';
    }
    return '';
}
?>
<aside class="leo-sidebar" id="leoSidebar">
    <div class="leo-sidebar-logo">
        <a href="index.php" style="color:#fff; font-size:1.15rem; font-weight:800; letter-spacing:-0.02em;">
            <i class="fas fa-store" style="color:#338AFF;"></i> Mwalim Shop
        </a>
    </div>
    <nav class="leo-sidebar-menu">
        <ul>
            <li>
                <a href="index.php" class="<?php echo nav_active('index.php', $current); ?>">
                    <span class="leo-sidebar-icon"><i class="fas fa-th-large"></i></span>
                    Dashboard
                </a>
            </li>

            <li class="dropdown <?php echo in_array($current, ['products.php','services.php'])?'open':''; ?>">
                <a href="javascript:void(0)" onclick="this.parentElement.classList.toggle('open')">
                    <span class="leo-sidebar-icon"><i class="fas fa-box"></i></span>
                    Products
                </a>
                <div class="submenu">
                    <a href="products.php">All Products</a>
                    <a href="services.php">Services</a>
                </div>
            </li>

            <li class="dropdown <?php echo in_array($current, ['customers.php','dues.php'])?'open':''; ?>">
                <a href="javascript:void(0)" onclick="this.parentElement.classList.toggle('open')">
                    <span class="leo-sidebar-icon"><i class="fas fa-users"></i></span>
                    Customers
                </a>
                <div class="submenu">
                    <a href="customers.php">All Customers</a>
                    <a href="dues.php">Due List</a>
                </div>
            </li>

            <li>
                <a href="sales.php" class="<?php echo nav_active('sales.php', $current); ?>">
                    <span class="leo-sidebar-icon"><i class="fas fa-shopping-cart"></i></span>
                    Sales
                </a>
            </li>

            <li>
                <a href="expenses.php" class="<?php echo nav_active('expenses.php', $current); ?>">
                    <span class="leo-sidebar-icon"><i class="fas fa-wallet"></i></span>
                    Expenses
                </a>
            </li>

            <li>
                <a href="reports.php" class="<?php echo nav_active('reports.php', $current); ?>">
                    <span class="leo-sidebar-icon"><i class="fas fa-chart-line"></i></span>
                    Reports
                </a>
            </li>

            <li>
                <a href="settings.php" class="<?php echo nav_active('settings.php', $current); ?>">
                    <span class="leo-sidebar-icon"><i class="fas fa-cog"></i></span>
                    Settings
                </a>
            </li>
        </ul>
    </nav>
</aside>
<div class="leo-overlay" id="leoOverlay"></div>
