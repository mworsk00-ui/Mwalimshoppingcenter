<?php
$page_title = 'Sales';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

$sales = [];
try {
    $sales = $pdo->query("SELECT s.*, c.customer_name FROM sales s LEFT JOIN customers c ON s.customer_id=c.id ORDER BY s.id DESC LIMIT 50")->fetchAll();
} catch (Exception $e) {}
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Sales List</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-header-icon"><i class="fas fa-search"></i></button>
    </div>
</header>

<?php if (empty($sales)): ?>
<div class="leo-empty">
    <div class="leo-empty-img"><i class="fas fa-shopping-cart"></i></div>
    <h4>Please Add a Sale</h4>
    <p>Tap the + button to record your first sale</p>
</div>
<?php else: ?>
<div class="leo-section-card" style="margin:0.85rem;">
    <?php foreach ($sales as $s): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar" style="background:#E8F8EE;color:#10B981;">
            <i class="fas fa-receipt"></i>
        </div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?php echo htmlspecialchars($s['customer_name'] ?? 'Walk-in Customer'); ?></div>
            <div class="leo-person-sub"><?php echo htmlspecialchars($s['created_at'] ?? ''); ?> · <?php echo htmlspecialchars($s['payment_status'] ?? 'paid'); ?></div>
        </div>
        <div class="leo-person-value up">TSH <?php echo number_format($s['total_amount'] ?? 0, 0); ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<a href="sale-add.php" class="leo-fab"><i class="fas fa-plus"></i></a>

<?php require_once __DIR__ . '/includes/footer.php'; ?>