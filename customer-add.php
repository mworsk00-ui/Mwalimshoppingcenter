<?php
$page_title = 'Add Customer';
require_once __DIR__ . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['customer_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO customers (customer_name, phone) VALUES (?,?)");
            $stmt->execute([$name, $phone]);
            header('Location: customers.php');
            exit;
        } catch (Exception $e) {}
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="customers.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Please Add a Customer</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="custForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<form method="post" id="custForm" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">

        <div class="leo-form-row">
            <label class="leo-input-label">Name</label>
            <div class="leo-input-row">
                <input type="text" name="customer_name" class="leo-input" placeholder="Enter customer name" required>
                <span class="leo-input-row-icon"><i class="fas fa-address-card"></i></span>
            </div>
        </div>

        <div style="text-align:center;margin:1rem 0;">
            <div style="width:100px;height:100px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.5rem;">
                <i class="fas fa-user"></i>
            </div>
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Phone Number</label>
            <input type="tel" name="phone" class="leo-input" placeholder="Enter your phone number" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>

        <div class="leo-form-row">
            <label class="leo-form-radio-row">
                <span class="leo-form-radio checked"></span>
                <span class="leo-form-radio-label">End Customer (Retailer)</span>
            </label>
            <label class="leo-form-radio-row">
                <span class="leo-form-radio"></span>
                <span class="leo-form-radio-label">Wholesaler</span>
            </label>
            <label class="leo-form-radio-row">
                <span class="leo-form-radio"></span>
                <span class="leo-form-radio-label">Dealer</span>
            </label>
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Email Address</label>
            <input type="email" name="email" class="leo-input" placeholder="Enter email address" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Taxpayer Identification Number</label>
            <input type="text" name="tin" class="leo-input" placeholder="Enter taxpayer identification number" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Address</label>
            <input type="text" name="address" class="leo-input" placeholder="Enter personal address" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Previous Due</label>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <input type="number" name="due" class="leo-input" placeholder="Amount" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
                <span style="font-size:0.75rem;color:var(--leo-muted);text-align:right;">Customer<br>Signature</span>
            </div>
        </div>
    </div>
</form>

<div class="leo-bottom-actions">
    <a href="customers.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="custForm" class="leo-btn leo-btn--primary">SAVE</button>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
