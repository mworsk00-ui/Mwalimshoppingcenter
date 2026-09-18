<?php
$page_title = 'Edit Supply';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM supplies WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$sp = $stmt->fetch();
if (!$sp) { flash('warning', 'Supply not found.'); header('Location: supplies.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name'] ?? '');
    $product_name = trim($_POST['product_name'] ?? '');
    $quantity = (float)($_POST['quantity'] ?? 0);
    $unit = trim($_POST['unit'] ?? 'pcs');
    $unit_price = (float)($_POST['unit_price'] ?? 0);
    $total_amount = (float)($_POST['total_amount'] ?? 0);
    $amount_paid = (float)($_POST['amount_paid'] ?? 0);
    $balance = $total_amount - $amount_paid;
    $supply_date = $_POST['supply_date'] ?? date('Y-m-d');
    $pay_status = trim($_POST['payment_status'] ?? 'Unpaid');
    $pay_mode = trim($_POST['payment_mode'] ?? '');
    $courier_name = trim($_POST['courier_name'] ?? '');
    $courier_phone = trim($_POST['courier_phone'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    if ($customer_name === '' || $product_name === '') { flash('warning', 'Required fields missing.'); }
    else {
        try {
            $stmt = $pdo->prepare("UPDATE supplies SET customer_name=?, product_name=?, quantity=?, unit=?, unit_price=?, total_amount=?, amount_paid=?, balance=?, supply_date=?, payment_status=?, payment_mode=?, courier_name=?, courier_phone=?, notes=? WHERE id=?");
            $stmt->execute([$customer_name, $product_name, $quantity, $unit, $unit_price, $total_amount, $amount_paid, $balance, $supply_date, $pay_status, $pay_mode ?: null, $courier_name ?: null, $courier_phone ?: null, $notes ?: null, $id]);
            flash('success', 'Supply updated!');
            header('Location: supplies.php'); exit;
        } catch (PDOException $e) { flash('error', 'Error: ' . $e->getMessage()); }
    }
}

$modes = [];
try { $modes = $pdo->query("SELECT name FROM payment_modes WHERE deleted_at IS NULL ORDER BY name")->fetchAll(); } catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="supplies.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Supply</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="supForm" class="leo-save-btn">SAVE</button>
    </div>
</header>
<form method="post" id="supForm" class="leo-form-card" style="margin:0.85rem;">
<div class="leo-form-card-body">
    <div class="leo-form-row"><label class="leo-input-label">Customer *</label><input type="text" name="customer_name" class="leo-input" value="<?= htmlspecialchars($sp['customer_name']) ?>" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Product *</label><input type="text" name="product_name" class="leo-input" value="<?= htmlspecialchars($sp['product_name']) ?>" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row leo-form-row-inline">
        <div><label class="leo-input-label">Quantity</label><input type="number" step="0.01" name="quantity" class="leo-input" value="<?= htmlspecialchars($sp['quantity']) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
        <div><label class="leo-input-label">Unit</label><input type="text" name="unit" class="leo-input" value="<?= htmlspecialchars($sp['unit']) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Unit Price</label><input type="number" step="0.01" name="unit_price" class="leo-input" value="<?= htmlspecialchars($sp['unit_price']) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Total *</label><input type="number" step="0.01" name="total_amount" class="leo-input" value="<?= htmlspecialchars($sp['total_amount']) ?>" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Date</label><input type="date" name="supply_date" class="leo-input" value="<?= htmlspecialchars($sp['supply_date']) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Payment Status</label><select name="payment_status" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><?php foreach (['Unpaid','Partial','Paid'] as $st): ?><option value="<?= $st ?>" <?= $sp['payment_status'] === $st ? 'selected' : '' ?>><?= $st ?></option><?php endforeach; ?></select></div>
    <div class="leo-form-row"><label class="leo-input-label">Amount Paid</label><input type="number" step="0.01" name="amount_paid" class="leo-input" value="<?= htmlspecialchars($sp['amount_paid']) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Payment Mode</label><select name="payment_mode" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><option value="">—</option><?php foreach ($modes as $m): ?><option value="<?= htmlspecialchars($m['name']) ?>" <?= $sp['payment_mode'] === $m['name'] ? 'selected' : '' ?>><?= htmlspecialchars($m['name']) ?></option><?php endforeach; ?></select></div>
    <div class="leo-form-row"><label class="leo-input-label">Courier</label><input type="text" name="courier_name" class="leo-input" value="<?= htmlspecialchars($sp['courier_name'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Courier Phone</label><input type="tel" name="courier_phone" class="leo-input" value="<?= htmlspecialchars($sp['courier_phone'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Notes</label><textarea name="notes" rows="2" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><?= htmlspecialchars($sp['notes'] ?? '') ?></textarea></div>
</div>
</form>
<div class="leo-bottom-actions">
    <a href="supplies.php?delete=<?= (int)$sp['id'] ?>" data-confirm="Move to Bin?" class="leo-btn leo-btn--outline" style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;"><i class="fas fa-trash"></i></a>
    <a href="supplies.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="supForm" class="leo-btn leo-btn--primary">UPDATE</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
