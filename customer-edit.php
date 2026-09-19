<?php
$page_title = 'Edit Customer';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);

// Fetch existing
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch();

if (!$c) {
    flash('warning', 'Customer not found.');
    header('Location: customers.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['customer_name'] ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $email   = trim($_POST['email']   ?? '');
    $tin     = trim($_POST['tin']     ?? '');
    $address = trim($_POST['address'] ?? '');
    $due     = (float)($_POST['due']  ?? 0);

    if ($name === '') {
        flash('warning', 'Customer name is required.');
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE customers SET customer_name=?, phone=?, email=?, tin=?, address=?, due=? WHERE id=?");
            $stmt->execute([$name, $phone, $email, $tin, $address, $due, $id]);
            flash('success', 'Customer updated successfully!');
            header('Location: customers.php');
            exit;
        } catch (PDOException $e) {
            flash('error', 'Error updating customer: ' . $e->getMessage());
        }
    }
}
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .pm-page-wrap { min-height: calc(100vh - 140px); display: flex; flex-direction: column; }
    .pm-page-wrap .leo-form-card { flex: 1; }
    .pm-bottom-actions {
        position: sticky; bottom: 0; background: #ffffff;
        border-top: 1px solid #E5EAF0; padding: 0.85rem 1rem;
        display: flex; gap: 0.6rem; margin-top: auto;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.04);
    }
    .pm-bottom-actions .leo-btn { flex: 1; justify-content: center; text-align: center; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="customers.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Customer</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="custForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<div class="pm-page-wrap">
    <form method="post" id="custForm" class="leo-form-card" style="margin:0.85rem;" data-loading="Updating…">
        <div class="leo-form-card-body">

            <div style="text-align:center;margin:0.5rem 0 1.25rem;">
                <div style="width:100px;height:100px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.5rem;">
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Name *</label>
                <div class="leo-input-row">
                    <input type="text" name="customer_name" class="leo-input" value="<?= htmlspecialchars($c['customer_name']) ?>" required>
                    <span class="leo-input-row-icon"><i class="fas fa-address-card"></i></span>
                </div>
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Phone Number</label>
                <input type="tel" name="phone" class="leo-input" value="<?= htmlspecialchars($c['phone'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Email Address</label>
                <input type="email" name="email" class="leo-input" value="<?= htmlspecialchars($c['email'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">TIN</label>
                <input type="text" name="tin" class="leo-input" value="<?= htmlspecialchars($c['tin'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Address</label>
                <input type="text" name="address" class="leo-input" value="<?= htmlspecialchars($c['address'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Previous Due</label>
                <input type="number" step="0.01" name="due" class="leo-input" value="<?= htmlspecialchars($c['due'] ?? 0) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            </div>

        </div>
    </form>

    <div class="pm-bottom-actions">
        <a href="customers.php?delete=<?= (int)$c['id'] ?>"
           data-confirm="Do you want to delete the customer '<?= htmlspecialchars($c['customer_name'], ENT_QUOTES) ?>'?"
           data-confirm-ok="Yes, delete"
           data-confirm-cancel="Cancel"
           class="leo-btn leo-btn--outline"
           style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
            <i class="fas fa-trash"></i> DELETE
        </a>
        <a href="customers.php" class="leo-btn leo-btn--outline">CANCEL</a>
        <button type="submit" form="custForm" class="leo-btn leo-btn--primary">UPDATE</button>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>