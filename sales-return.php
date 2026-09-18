<?php
$page_title = 'Sales Return';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
$sales = [];
try { $sales = $pdo->query("SELECT * FROM sales ORDER BY id DESC LIMIT 20")->fetchAll(); } catch (Exception $e) {}
?>
<header class="leo-page-header">
    <div class="leo-page-header-left"><a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a><span class="leo-page-header-title">Sales Return</span></div>
</header>
<?php if (count($sales) > 0): ?>
<div class="leo-section-card" style="margin:0.85rem;">
    <?php foreach ($sales as $s): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar" style="background:#FEF0F0;color:#EF4444;"><i class="fas fa-undo"></i></div>
        <div class="leo-person-body"><div class="leo-person-name">Sale #<?= (int)$s['id'] ?></div><div class="leo-person-sub"><?= date('d M Y', strtotime($s['created_at'])) ?></div></div>
        <div class="leo-person-value down">TSH <?= number_format((float)$s['total_amount'], 0) ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-undo"></i></div><h4>No sales to return</h4></div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
