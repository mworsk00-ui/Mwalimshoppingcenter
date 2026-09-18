<?php
$page_title = 'Edit Payment Mode';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM payment_modes WHERE id = ?");
$stmt->execute([$id]);
$mode = $stmt->fetch();
if (!$mode) { flash('warning', 'Not found.'); header('Location: payment-modes.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');
    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("UPDATE payment_modes SET name=?, description=?, status=? WHERE id=?");
            $stmt->execute([$name, $description ?: null, $status, $id]);
            flash('success', 'Updated!');
            header('Location: payment-modes.php'); exit;
        } catch (PDOException $e) { flash('error', 'Error: ' . $e->getMessage()); }
    } else { flash('warning', 'Name is required.'); }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="payment-modes.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Payment Mode</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="pmForm" class="leo-save-btn">SAVE</button>
    </div>
</header>
<form method="post" id="pmForm" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div class="leo-form-row">
            <label class="leo-input-label">Payment Method Name *</label>
            <div class="leo-input-row">
                <input type="text" name="name" class="leo-input" value="<?= htmlspecialchars($mode['name']) ?>" required>
                <span class="leo-input-row-icon"><i class="fas fa-tag"></i></span>
            </div>
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Description</label>
            <input type="text" name="description" class="leo-input" value="<?= htmlspecialchars($mode['description'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Status</label>
            <select name="status" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
                <option value="Active"   <?= ($mode['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option>
                <option value="Inactive" <?= ($mode['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
    </div>
</form>
<div class="leo-bottom-actions">
    <a href="payment-modes.php?delete=<?= (int)$mode['id'] ?>" data-confirm="Move to Recycle Bin?" class="leo-btn leo-btn--outline" style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
        <i class="fas fa-trash"></i> DELETE
    </a>
    <a href="payment-modes.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="pmForm" class="leo-btn leo-btn--primary">UPDATE</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
