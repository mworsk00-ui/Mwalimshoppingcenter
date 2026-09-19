<?php
$page_title = 'Add Supply';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

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

    // If customer chosen from dropdown, use its name
    if ($customer_id > 0) {
        $st = $pdo->prepare("SELECT customer_name FROM customers WHERE id = ?");
        $st->execute([$customer_id]);
        $row = $st->fetch();
        if ($row) $customer_name = $row['customer_name'];
    }

    if ($customer_name === '' || $product_name === '') {
        flash('warning', 'Customer name and product name are required.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO supplies
                (customer_id, customer_name, product_id, product_name, quantity, unit,
                 unit_price, total_amount, amount_paid, balance, supply_date,
                 payment_status, payment_mode, courier_name, courier_phone, notes)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([
                $customer_id ?: null, $customer_name,
                $product_id  ?: null, $product_name,
                $quantity, $unit, $unit_price, $total_amount, $amount_paid, $balance,
                $supply_date, $pay_status, $pay_mode ?: null,
                $courier_name ?: null, $courier_phone ?: null, $notes ?: null
            ]);
            flash('success', 'Supply record saved successfully!');
            header('Location: supplies.php');
            exit;
        } catch (PDOException $e) {
            flash('error', 'Error saving supply: ' . $e->getMessage());
        }
    }
}

// Data for dropdowns
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
        <span class="leo-page-header-title">Add Supply</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="supForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<div class="pm-page-wrap">
<form method="post" id="supForm" class="leo-form-card" style="margin:0.85rem;" data-loading="Saving…">
<div class="leo-form-card-body">

    <div style="text-align:center;margin:0.5rem 0 1rem;">
        <div style="width:90px;height:90px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.2rem;">
            <i class="fas fa-box-open"></i>
        </div>
    </div>

    <!-- CUSTOMER -->
    <div class="leo-form-row">
        <label class="leo-input-label">Customer *</label>
        <select name="customer_id" id="customerSel" class="leo-input"
                style="width:100%;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="0">— Choose existing customer —</option>
            <?php foreach ($customers as $c): ?>
                <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['customer_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="leo-form-row" id="custNameWrap">
        <label class="leo-input-label">Or type customer name</label>
        <input type="text" name="customer_name" id="customerName" class="leo-input"
               placeholder="Type a new / different name"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <!-- PRODUCT -->
    <div class="leo-form-row">
        <label class="leo-input-label">Product *</label>
        <select name="product_id" id="productSel" class="leo-input"
                style="width:100%;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="0">— Choose existing product —</option>
            <?php foreach ($products as $p): ?>
                <option value="<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['product_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Or type product name *</label>
        <input type="text" name="product_name" id="productName" class="leo-input"
               placeholder="Type a new / different product"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <!-- QUANTITY + UNIT -->
    <div class="leo-form-row">
        <label class="leo-input-label">Quantity *</label>
        <div style="display:flex;gap:0.5rem;">
            <input type="number" step="0.01" min="0" name="quantity" id="quantity" class="leo-input"
                   placeholder="0" style="flex:1;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <select name="unit" id="unit" class="leo-input"
                    style="flex:1;border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
                <option value="pcs">Pieces (pcs)</option>
                <option value="kg">Kilograms (kg)</option>
                <option value="g">Grams (g)</option>
                <option value="mg">Milligrams (mg)</option>
                <option value="t">Tonnes (t)</option>
                <option value="L">Litres (L)</option>
                <option value="ml">Millilitres (ml)</option>
                <option value="m">Metres (m)</option>
                <option value="cm">Centimetres (cm)</option>
                <option value="box">Box</option>
                <option value="carton">Carton</option>
                <option value="case">Case</option>
                <option value="pack">Pack</option>
                <option value="bag">Bag</option>
                <option value="sack">Sack</option>
                <option value="bottle">Bottle</option>
                <option value="can">Can</option>
                <option value="sachet">Sachet</option>
                <option value="dozen">Dozen</option>
                <option value="roll">Roll</option>
            </select>
        </div>
    </div>

    <!-- PRICE + TOTAL -->
    <div class="leo-form-row">
        <label class="leo-input-label">Unit Price (optional)</label>
        <input type="number" step="0.01" min="0" name="unit_price" id="unitPrice" class="leo-input"
               placeholder="0.00" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>
    <div class="leo-form-row">
        <label class="leo-input-label">Total Amount *</label>
        <input type="number" step="0.01" min="0" name="total_amount" id="totalAmount" class="leo-input"
               placeholder="0.00" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        <span style="font-size:0.72rem;color:var(--leo-muted);">Tip: type it in, or leave and it fills from Qty × Unit Price</span>
    </div>

    <!-- DATE -->
    <div class="leo-form-row">
        <label class="leo-input-label">Supply Date *</label>
        <input type="date" name="supply_date" class="leo-input" value="<?= date('Y-m-d') ?>" required
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <!-- PAYMENT STATUS -->
    <div class="leo-form-row">
        <label class="leo-input-label">Payment Status *</label>
        <select name="payment_status" id="payStatus" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="Unpaid">Unpaid</option>
            <option value="Partial">Partial</option>
            <option value="Paid">Paid</option>
        </select>
    </div>

    <div class="leo-form-row" id="paidWrap" style="display:none;">
        <label class="leo-input-label">Amount Paid</label>
        <input type="number" step="0.01" min="0" name="amount_paid" id="amountPaid" class="leo-input"
               placeholder="0.00" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <!-- PAYMENT MODE -->
    <div class="leo-form-row">
        <label class="leo-input-label">Payment Mode</label>
        <select name="payment_mode" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="">— Not specified —</option>
            <?php foreach ($modes as $m): ?>
                <option value="<?= htmlspecialchars($m['name']) ?>"><?= htmlspecialchars($m['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- COURIER / SUPPLIER DETAILS -->
    <div style="margin:1.25rem 0 0.5rem;padding-top:1rem;border-top:1px dashed #E5EAF0;">
        <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:0.5rem;">
            <i class="fas fa-motorcycle"></i> Delivered By (Courier / Bodaboda)
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Courier Name</label>
        <input type="text" name="courier_name" class="leo-input" placeholder="e.g. John (Bodaboda)"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Courier Phone</label>
        <input type="tel" name="courier_phone" class="leo-input" placeholder="e.g. 07XX XXX XXX"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <!-- NOTES -->
    <div class="leo-form-row">
        <label class="leo-input-label">Notes</label>
        <textarea name="notes" class="leo-input" rows="3" placeholder="Any extra details…"
                  style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;resize:vertical;"></textarea>
    </div>

</div>
</form>

<div class="pm-bottom-actions">
    <a href="supplies.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="supForm" class="leo-btn leo-btn--primary">SAVE SUPPLY</button>
</div>
</div>

<script>
(function(){
    const custSel   = document.getElementById('customerSel');
    const custName  = document.getElementById('customerName');
    const prodSel   = document.getElementById('productSel');
    const prodName  = document.getElementById('productName');
    const qty       = document.getElementById('quantity');
    const unitPrice = document.getElementById('unitPrice');
    const total     = document.getElementById('totalAmount');
    const payStatus = document.getElementById('payStatus');
    const paidWrap  = document.getElementById('paidWrap');

    // Auto-fill total from qty × unit price when total is empty
    function autoTotal() {
        if (total.dataset.touched === '1') return;
        const q = parseFloat(qty.value) || 0;
        const p = parseFloat(unitPrice.value) || 0;
        if (q > 0 && p > 0) total.value = (q * p).toFixed(2);
    }
    qty.addEventListener('input', autoTotal);
    unitPrice.addEventListener('input', autoTotal);
    total.addEventListener('input', () => { total.dataset.touched = '1'; });

    // Customer select fills name field
    custSel.addEventListener('change', function(){
        if (this.value !== '0') {
            custName.value = this.options[this.selectedIndex].text;
            custName.readOnly = true;
            custName.style.opacity = '0.7';
        } else {
            custName.value = '';
            custName.readOnly = false;
            custName.style.opacity = '1';
        }
    });

    // Product select fills name field
    prodSel.addEventListener('change', function(){
        if (this.value !== '0') {
            prodName.value = this.options[this.selectedIndex].text;
            prodName.readOnly = true;
            prodName.style.opacity = '0.7';
        } else {
            prodName.value = '';
            prodName.readOnly = false;
            prodName.style.opacity = '1';
        }
    });

    // Show amount paid when status is Paid/Partial
    function updatePaidVisibility() {
        paidWrap.style.display = (payStatus.value === 'Paid' || payStatus.value === 'Partial') ? '' : 'none';
    }
    payStatus.addEventListener('change', updatePaidVisibility);
    updatePaidVisibility();
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>