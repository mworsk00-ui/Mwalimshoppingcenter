<?php
$page_title = 'View Supply';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM supplies WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$sp = $stmt->fetch();
if (!$sp) { flash('warning', 'Not found.'); header('Location: supplies.php'); exit; }
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="supplies.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Supply Details</span>
    </div>
    <div class="leo-page-header-actions">
        <button onclick="window.print()" class="leo-save-btn" style="background:#FEF3C7;color:#92400E;margin-right:0.4rem;border:none;"><i class="fas fa-print"></i></button>
        <a href="supply-edit.php?id=<?= (int)$sp['id'] ?>" class="leo-save-btn" style="text-decoration:none;"><i class="fas fa-pen"></i></a>
    </div>
</header>
<div class="leo-form-card" style="margin:0.85rem;" id="printArea">
    <div class="leo-form-card-body">
        <div style="text-align:center;margin:0.5rem 0 1.25rem;">
            <div style="width:90px;height:90px;border-radius:50%;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.5rem;"><i class="fas fa-box-open"></i></div>
            <h2 style="margin-top:0.75rem;color:#0F172A;">Supply #<?= (int)$sp['id'] ?></h2>
        </div>
        <?php
        $rows = [
            'Date' => date('d M Y', strtotime($sp['supply_date'])),
            'Customer' => $sp['customer_name'],
            'Product' => $sp['product_name'],
            'Quantity' => (float)$sp['quantity'] . ' ' . $sp['unit'],
            'Unit Price' => number_format((float)$sp['unit_price'], 2),
            'Total' => number_format((float)$sp['total_amount'], 2),
            'Amount Paid' => number_format((float)$sp['amount_paid'], 2),
            'Balance' => number_format((float)$sp['balance'], 2),
            'Status' => $sp['payment_status'],
            'Payment Mode' => $sp['payment_mode'] ?? '—',
            'Courier' => $sp['courier_name'] ?? '—',
            'Courier Phone' => $sp['courier_phone'] ?? '—',
            'Notes' => $sp['notes'] ?? '—',
        ];
        foreach ($rows as $label => $value): ?>
            <div style="display:flex;justify-content:space-between;padding:0.75rem 0;border-bottom:1px solid #EEF2F7;">
                <span style="font-size:0.85rem;color:var(--leo-muted);font-weight:600;"><?= $label ?></span>
                <span style="font-size:0.92rem;color:#1E293B;text-align:right;"><?= htmlspecialchars($value) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="leo-bottom-actions">
    <a href="supplies.php?delete=<?= (int)$sp['id'] ?>" data-confirm="Move to Bin?" class="leo-btn leo-btn--outline" style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;"><i class="fas fa-trash"></i></a>
    <a href="supplies.php" class="leo-btn leo-btn--outline">BACK</a>
    <a href="supply-edit.php?id=<?= (int)$sp['id'] ?>" class="leo-btn leo-btn--primary">EDIT</a>
</div>
<style>@media print{.leo-page-header,.leo-bottom-actions,.leo-bottom-nav,.leo-app-header{display:none!important;}}</style>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
