<?php
$page_title = 'Purchases';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

try { $pdo->exec("CREATE TABLE IF NOT EXISTS purchases_list (id INT AUTO_INCREMENT PRIMARY KEY, supplier_name VARCHAR(150), product_name VARCHAR(150), quantity DECIMAL(12,2), unit_price DECIMAL(12,2), total_amount DECIMAL(12,2), payment_status VARCHAR(20) DEFAULT 'Paid', purchase_date DATE, notes TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, deleted_at DATETIME DEFAULT NULL)"); } catch (Exception $e) {}

if (isset($_GET['delete'])) { try { $pdo->prepare("UPDATE purchases_list SET deleted_at=NOW() WHERE id=?")->execute([(int)$_GET['delete']]); flash('success','Purchase deleted.'); } catch (PDOException $e) {} header('Location: purchases.php'); exit; }

$purchases = $pdo->query("SELECT * FROM purchases_list WHERE deleted_at IS NULL ORDER BY purchase_date DESC, id DESC")->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left"><a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a><span class="leo-page-header-title">Purchases</span></div>
    <div class="leo-page-header-actions"><a href="purchase-add.php" class="leo-save-btn" style="text-decoration:none;"><i class="fas fa-plus"></i> ADD</a></div>
</header>
<?php if (count($purchases) > 0): ?>
<div class="leo-section-card" style="margin:0.85rem;">
    <?php foreach ($purchases as $p): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar" style="background:#E0F2FE;color:#0369A1;"><i class="fas fa-clipboard-list"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?= htmlspecialchars($p['product_name']) ?></div>
            <div class="leo-person-sub"><?= htmlspecialchars($p['supplier_name']) ?> · <?= date('d M Y', strtotime($p['purchase_date'])) ?></div>
        </div>
        <div class="leo-person-value up">TSH <?= number_format((float)$p['total_amount'], 0) ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="leo-empty"><div class="leo-empty-img"><i class="fas fa-clipboard-list"></i></div><h4>No purchases yet</h4><p>Tap + to add</p></div>
<?php endif; ?>
<a href="purchase-add.php" class="leo-fab"><i class="fas fa-plus"></i></a>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
