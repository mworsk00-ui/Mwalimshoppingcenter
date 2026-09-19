<?php
require_once __DIR__ . '/flash.php';   // flash() + flash_render()
$current = basename($_SERVER['PHP_SELF'] ?? 'index.php');
function nav_active($files, $current) {
    foreach ((array)$files as $f) {
        if ($f === $current) return 'active';
    }
    return '';
}
?>
</main>

<nav class="leo-bottom-nav">
    <a href="index.php" class="leo-nav-item <?php echo nav_active('index.php', $current); ?>">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="menu.php" class="leo-nav-item <?php echo nav_active('menu.php', $current); ?>">
        <i class="fas fa-th"></i>
        <span>Menu</span>
    </a>
    <a href="ai.php" class="leo-nav-item leo-nav-item--ai">
        <button class="leo-ai-fab"><i class="fas fa-magic"></i></button>
    </a>
    <a href="reports.php" class="leo-nav-item <?php echo nav_active('reports.php', $current); ?>">
        <i class="fas fa-chart-bar"></i>
        <span>Reports</span>
    </a>
    <a href="settings.php" class="leo-nav-item <?php echo nav_active('settings.php', $current); ?>">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
</nav>

<script>
window.addEventListener('load', function() {
    setTimeout(function() {
        document.getElementById('leoSplash')?.classList.add('hide');
    }, 600);
});

// Haptic feedback
document.querySelectorAll('.leo-nav-item, .leo-quick-btn').forEach(function(el) {
    el.addEventListener('click', function() {
        if (navigator.vibrate) navigator.vibrate(8);
    });
});
</script>

<!-- 1) Emit flash data FIRST so JS can read it -->
<?php flash_render(); ?>

<!-- 2) Then load the UI script that consumes it -->
<?php require_once __DIR__ . '/leo-ui.php'; ?>

</body>
</html>