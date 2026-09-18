<?php
$page_title = 'Add Purchase';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier = trim($_POST['supplier_name'] ?? '');
    $product = trim($_POST['product_name'] ?? '');
    $qty = (float)($_POST['quantity'] ?? 0);
    $price = (float)($_POST['unit_price'] ?? 0);
    $total = (float)($_POST['total_amount'] ?? ($qty * $price));
    $status = trim($_POST['payment_status'] ?? 'Paid');
    $date = $_POST['purchase_date'] ?? date('Y-m-d');
    $notes = trim($_POST['notes'] ?? '');
    if ($supplier === '' || $product === '') { flash('warning','Supplier and product required.'); }
    else {
        try {
            $pdo->prepare("INSERT INTO purchases_list (supplier_name, product_name, quantity, unit_price, total_amount, payment_status, purchase_date, notes) VALUES (?,?,?,?,?,?,?,?)")->execute([$supplier,$product,$qty,$price,$total,$status,$date,$notes]);
            flash('success','Purchase recorded!'); header('Location: purchases.php'); exit;
        } catch (PDOException $e) { flash('error',$e->getMessage()); }
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left"><a href="purchases.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a><span class="leo-page-header-title">Add Purchase</span></div>
    <div class="leo-page-header-actions"><button type="submit" form="pForm" class="leo-save-btn">SAVE</button></div>
</header>
<form method="post" id="pForm" class="leo-form-card" style="margin:0.85rem;">
<div class="leo-form-card-body">
    <div style="text-align:center;margin:0.5rem 0 1rem;"><div style="width:90px;height:90px;border-radius:14px;background:#E0F2FE;display:inline-flex;align-items:center;justify-content:center;color:#0369A1;font-size:2.2rem;"><i class="fas fa-clipboard-list"></i></div></div>
    <div class="leo-form-row"><label class="leo-input-label">Supplier *</label><input type="text" name="supplier_name" class="leo-input" placeholder="Supplier name" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Product *</label><input type="text" name="product_name" class="leo-input" placeholder="Product name" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row leo-form-row-inline">
        <div><label class="leo-input-label">Quantity</label><input type="number" step="0.01" name="quantity" class="leo-input" value="1" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
        <div><label class="leo-input-label">Unit Price</label><input type="number" step="0.01" name="unit_price" class="leo-input" value="0" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Total Amount *</label><input type="number" step="0.01" name="total_amount" class="leo-input" value="0" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Date</label><input type="date" name="purchase_date" class="leo-input" value="<?= date('Y-m-d') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Status</label><select name="payment_status" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><option>Paid</option><option>Partial</option><option>Unpaid</option></select></div>
    <div class="leo-form-row"><label class="leo-input-label">Notes</label><textarea name="notes" rows="2" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></textarea></div>
</div>
</form>
<div class="leo-bottom-actions"><a href="purchases.php" class="leo-btn leo-btn--outline">CANCEL</a><button type="submit" form="pForm" class="leo-btn leo-btn--primary">SAVE PURCHASE</button></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
