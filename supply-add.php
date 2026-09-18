<?php
$page_title = 'Add Supply';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

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

    if ($customer_name === '' || $product_name === '') {
        flash('warning', 'Customer and product name required.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO supplies (customer_name, product_name, quantity, unit, unit_price, total_amount, amount_paid, balance, supply_date, payment_status, payment_mode, courier_name, courier_phone, notes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$customer_name, $product_name, $quantity, $unit, $unit_price, $total_amount, $amount_paid, $balance, $supply_date, $pay_status, $pay_mode ?: null, $courier_name ?: null, $courier_phone ?: null, $notes ?: null]);
            flash('success', 'Supply saved!');
            header('Location: supplies.php'); exit;
        } catch (PDOException $e) { flash('error', 'Error: ' . $e->getMessage()); }
    }
}

$customers = $pdo->query("SELECT customer_name FROM customers WHERE deleted_at IS NULL ORDER BY customer_name")->fetchAll();
$products = $pdo->query("SELECT product_name FROM products WHERE deleted_at IS NULL ORDER BY product_name")->fetchAll();
$modes = [];
try { $modes = $pdo->query("SELECT name FROM payment_modes WHERE deleted_at IS NULL ORDER BY name")->fetchAll(); } catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="supplies.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Supply</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="supForm" class="leo-save-btn">SAVE</button>
    </div>
</header>
<form method="post" id="supForm" class="leo-form-card" style="margin:0.85rem;">
<div class="leo-form-card-body">
    <div style="text-align:center;margin:0.5rem 0 1rem;">
        <div style="width:90px;height:90px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.2rem;"><i class="fas fa-box-open"></i></div>
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Customer *</label>
        <input type="text" name="customer_name" class="leo-input" list="custList" placeholder="Type or select customer" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        <datalist id="custList"><?php foreach ($customers as $c): ?><option value="<?= htmlspecialchars($c['customer_name']) ?>"><?php endforeach; ?></datalist>
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Product *</label>
        <input type="text" name="product_name" class="leo-input" list="prodList" placeholder="Type or select product" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        <datalist id="prodList"><?php foreach ($products as $p): ?><option value="<?= htmlspecialchars($p['product_name']) ?>"><?php endforeach; ?></datalist>
    </div>
    <div class="leo-form-row leo-form-row-inline">
        <div><label class="leo-input-label">Quantity</label><input type="number" step="0.01" name="quantity" class="leo-input" value="1" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
        <div><label class="leo-input-label">Unit</label>
            <select name="unit" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
                <option value="pcs">pcs</option><option value="kg">kg</option><option value="g">g</option><option value="L">L</option><option value="ml">ml</option><option value="box">box</option><option value="carton">carton</option><option value="bag">bag</option><option value="bottle">bottle</option><option value="dozen">dozen</option>
            </select>
        </div>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Unit Price</label><input type="number" step="0.01" name="unit_price" class="leo-input" placeholder="0.00" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Total Amount *</label><input type="number" step="0.01" name="total_amount" class="leo-input" placeholder="0.00" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Supply Date *</label><input type="date" name="supply_date" class="leo-input" value="<?= date('Y-m-d') ?>" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row">
        <label class="leo-input-label">Payment Status</label>
        <select name="payment_status" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><option>Unpaid</option><option>Partial</option><option>Paid</option></select>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Amount Paid</label><input type="number" step="0.01" name="amount_paid" class="leo-input" placeholder="0.00" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row">
        <label class="leo-input-label">Payment Mode</label>
        <select name="payment_mode" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><option value="">—</option><?php foreach ($modes as $m): ?><option value="<?= htmlspecialchars($m['name']) ?>"><?= htmlspecialchars($m['name']) ?></option><?php endforeach; ?></select>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Courier Name</label><input type="text" name="courier_name" class="leo-input" placeholder="e.g. Bodaboda John" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Courier Phone</label><input type="tel" name="courier_phone" class="leo-input" placeholder="07XX" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Notes</label><textarea name="notes" rows="2" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></textarea></div>
</div>
</form>
<div class="leo-bottom-actions">
    <a href="supplies.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="supForm" class="leo-btn leo-btn--primary">SAVE SUPPLY</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
