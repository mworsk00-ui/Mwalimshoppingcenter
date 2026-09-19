<?php
$page_title = 'Edit Supply';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM supplies WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$sp = $stmt->fetch();

if (!$sp) {
    flash('warning', 'Supply record not found.');
    header('Location: supplies.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id   = (int)($_POST['customer_id'] ?? 0);
    $customer_name = trim($_POST['customer_name'] ?? '');
    $product_id    = (int)($_POST['product_id'] ?? 0);
    $product_name  = trim($_POST['product_name'] ?? '');
    $quantity      = (float)($_POST['quantity'] ?? 0);
    $unit          = trim($_POST['unit'] ?? 'pcs');
    $unit_price    = (float)($_POST['unit_price'] ?? 0);
    $total_amount  = (float)($_POST['total_amount'] ?? 0);
    $amount_paid   = (float)($_POST['amount_paid'] ?? 0);
    $balance       = $total_amount - $amount_paid;
    $supply_date   = $_POST['supply_date'] ?? date('Y-m-d');
    $pay_status    = trim($_POST['payment_status'] ?? 'Unpaid');
    $pay_mode      = trim($_POST['payment_mode'] ?? '');
    $courier_name  = trim($_POST['courier_name'] ?? '');
    $courier_phone = trim($_POST['courier_phone'] ?? '');
    $notes         = trim($_POST['notes'] ?? '');

    if ($customer_id > 0) {
        $st = $pdo->prepare("SELECT customer_name FROM customers WHERE id = ?");
        $st->execute([$customer_id]);
        $r = $st->fetch();
        if ($r) $customer_name = $r['customer_name'];
    }

    if ($customer_name === '' || $product_name === '') {
        flash('warning', 'Customer name and product name are required.');
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE supplies SET
                customer_id=?, customer_name=?, product_id=?, product_name=?,
                quantity=?, unit=?, unit_price=?, total_amount=?, amount_paid=?, balance=?,
                supply_date=?, payment_status=?, payment_mode=?,
                courier_name=?, courier_phone=?, notes=?
                WHERE id=?");
            $stmt->execute([
                $customer_id ?: null, $customer_name,
                $product_id  ?: null, $product_name,
                $quantity, $unit, $unit_price, $total_amount, $amount_paid, $balance,
                $supply_date, $pay_status, $pay_mode ?: null,
                $courier_name ?: null, $courier_phone ?: null, $notes ?: null,
                $id
            ]);
            flash('success', 'Supply record updated successfully!');
            header('Location: supplies.php');
            exit;
        } catch (PDOException $e) {
            flash('error', 'Error updating supply: ' . $e->getMessage());
        }
    }
}

$customers = $pdo->query("SELECT id, customer_name FROM customers WHERE deleted_at IS NULL ORDER BY customer_name")->fetchAll();
$products  = $pdo->query("SELECT id, product_name FROM products   WHERE deleted_at IS NULL ORDER BY product_name")->fetchAll();
$modes     = $pdo->query("SELECT id, name FROM payment_modes WHERE deleted_at IS NULL ORDER BY name")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<style>
    .pm-page-wrap { min-height: calc(100vh - 140px); display: flex; flex-direction: column; }
    .pm-page-wrap .leo-form-card { flex: 1; }
    .pm-bottom-actions {
        position: sticky; bottom: 0; background: #fff;
        border-top: 1px solid #E5EAF0; padding: 0.85rem 1rem;
        display: flex; gap: 0.6rem; margin-top: auto;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.04);
    }
    .pm-bottom-actions .leo-btn { flex: 1; justify-content: center; text-align: center; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="supplies.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Supply</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="supForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<div class="pm-page-wrap">
<form method="post" id="supForm" class="leo-form-card" style="margin:0.85rem;" data-loading="Updating…">
<div class="leo-form-card-body">

    <div style="text-align:center;margin:0.5rem 0 1rem;">
        <div style="width:90px;height:90px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.2rem;">
            <i class="fas fa-box-open"></i>
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Customer *</label>
        <select name="customer_id" id="customerSel" class="leo-input"
                style="width:100%;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="0">— Choose existing customer —</option>
            <?php foreach ($customers as $c): ?>
                <option value="<?= (int)$c['id'] ?>" <?= (int)$sp['customer_id'] === (int)$c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['customer_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Or type customer name</label>
        <input type="text" name="customer_name" id="customerName" class="leo-input"
               value="<?= htmlspecialchars($sp['customer_name']) ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Product *</label>
        <select name="product_id" id="productSel" class="leo-input"
                style="width:100%;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="0">— Choose existing product —</option>
            <?php foreach ($products as $p): ?>
                <option value="<?= (int)$p['id'] ?>" <?= (int)$sp['product_id'] === (int)$p['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['product_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Or type product name *</label>
        <input type="text" name="product_name" id="productName" class="leo-input"
               value="<?= htmlspecialchars($sp['product_name']) ?>" required
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Quantity *</label>
        <div style="display:flex;gap:0.5rem;">
            <input type="number" step="0.01" min="0" name="quantity" class="leo-input"
                   value="<?= htmlspecialchars($sp['quantity']) ?>"
                   style="flex:1;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <select name="unit" class="leo-input"
                    style="flex:1;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
                <?php
                $units = ['pcs'=>'Pieces (pcs)','kg'=>'Kilograms (kg)','g'=>'Grams (g)','mg'=>'Milligrams (mg)','t'=>'Tonnes (t)','L'=>'Litres (L)','ml'=>'Millilitres (ml)','m'=>'Metres (m)','cm'=>'Centimetres (cm)','box'=>'Box','carton'=>'Carton','case'=>'Case','pack'=>'Pack','bag'=>'Bag','sack'=>'Sack','bottle'=>'Bottle','can'=>'Can','sachet'=>'Sachet','dozen'=>'Dozen','roll'=>'Roll'];
                foreach ($units as $k => $v):
                ?>
                    <option value="<?= $k ?>" <?= $sp['unit'] === $k ? 'selected' : '' ?>><?= $v ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Unit Price</label>
        <input type="number" step="0.01" min="0" name="unit_price" class="leo-input"
               value="<?= htmlspecialchars($sp['unit_price']) ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Total Amount *</label>
        <input type="number" step="0.01" min="0" name="total_amount" class="leo-input"
               value="<?= htmlspecialchars($sp['total_amount']) ?>" required
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Supply Date *</label>
        <input type="date" name="supply_date" class="leo-input"
               value="<?= htmlspecialchars($sp['supply_date']) ?>" required
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Payment Status *</label>
        <select name="payment_status" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <?php foreach (['Unpaid','Partial','Paid'] as $st): ?>
                <option value="<?= $st ?>" <?= $sp['payment_status'] === $st ? 'selected' : '' ?>><?= $st ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Amount Paid</label>
        <input type="number" step="0.01" min="0" name="amount_paid" class="leo-input"
               value="<?= htmlspecialchars($sp['amount_paid']) ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Payment Mode</label>
        <select name="payment_mode" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="">— Not specified —</option>
            <?php foreach ($modes as $m): ?>
                <option value="<?= htmlspecialchars($m['name']) ?>"
                        <?= $sp['payment_mode'] === $m['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div style="margin:1.25rem 0 0.5rem;padding-top:1rem;border-top:1px dashed #E5EAF0;">
        <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.5rem;">
            <i class="fas fa-motorcycle"></i> Delivered By (Courier / Bodaboda)
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Courier Name</label>
        <input type="text" name="courier_name" class="leo-input"
               value="<?= htmlspecialchars($sp['courier_name'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Courier Phone</label>
        <input type="tel" name="courier_phone" class="leo-input"
               value="<?= htmlspecialchars($sp['courier_phone'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Notes</label>
        <textarea name="notes" class="leo-input" rows="3"
                  style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;resize:vertical;"><?= htmlspecialchars($sp['notes'] ?? '') ?></textarea>
    </div>

</div>
</form>

<div class="pm-bottom-actions">
    <a href="supplies.php?delete=<?= (int)$sp['id'] ?>"
       data-confirm="Move this supply record to the Recycle Bin? You can restore it later."
       data-confirm-ok="Yes, move to bin"
       data-confirm-cancel="Cancel"
       class="leo-btn leo-btn--outline"
       style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
        <i class="fas fa-trash"></i> DELETE
    </a>
    <a href="supplies.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="supForm" class="leo-btn leo-btn--primary">UPDATE</button>
</div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>