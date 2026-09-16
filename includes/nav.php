<?php
// includes/nav.php
// Determine current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

    </main> <!-- End of .app-container -->

    <!-- Fixed Bottom Navigation Bar -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="products.php" class="nav-item <?php echo ($current_page == 'products.php' || $current_page == 'sales.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-border-all"></i>
            <span>Menu</span>
        </a>
        <a href="reports.php" class="nav-item <?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-chart-column"></i>
            <span>Reports</span>
        </a>
        <a href="settings.php" class="nav-item <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Navigation Styles -->
    <style>
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #ffffff;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid #e0e0e0;
            z-index: 1000;
        }

        body.dark-mode .bottom-nav {
            background: #1e1e1e !important;
            border-top-color: #333333 !important;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #666;
            font-size: 11px;
            flex: 1;
        }

        .nav-item.active {
            color: #2b7fff;
        }
    </style>

</body>
</html>