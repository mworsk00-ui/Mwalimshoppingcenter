<?php
$page_title = 'Edit Payment Mode';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);

// Fetch existing
$stmt = $pdo->prepare("SELECT * FROM payment_modes WHERE id = ?");
$stmt->execute([$id]);
$mode = $stmt->fetch();

if (!$mode) {
    flash('warning', 'Payment mode not found.');
    header('Location: payment-modes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status      = trim($_POST['status'] ?? 'Active');

    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("UPDATE payment_modes SET name = ?, description = ?, status = ? WHERE id = ?");
            $stmt->execute([$name, $description, $status, $id]);
            flash('success', 'Payment mode updated successfully!');
            header('Location: payment-modes.php');
            exit;
        } catch (PDOException $e) {
            flash('error', 'Error updating payment mode: ' . $e->getMessage());
        }
    } else {
        flash('warning', 'Payment mode name is required.');
    }
}
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .pm-page-wrap {
        min-height: calc(100vh - 140px);
        display: flex;
        flex-direction: column;
    }
    .pm-page-wrap .leo-form-card { flex: 1; }
    .pm-bottom-actions {
        position: sticky;
        bottom: 0;
        background: #ffffff;
        border-top: 1px solid #E5EAF0;
        padding: 0.85rem 1rem;
        display: flex;
        gap: 0.6rem;
        margin-top: auto;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.04);
    }
    .pm-bottom-actions .leo-btn {
        flex: 1;
        justify-content: center;
        text-align: center;
    }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="payment-modes.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Payment Mode</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="pmForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<div class="pm-page-wrap">

    <form method="post" id="pmForm" class="leo-form-card" style="margin:0.85rem;" data-loading="Updating…">
        <div class="leo-form-card-body">

            <div style="text-align:center;margin:0.5rem 0 1.25rem;">
                <div style="width:100px;height:100px;border-radius:14px;background:#FEF3C7;display:inline-flex;align-items:center;justify-content:center;color:#B45309;font-size:2.5rem;">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Payment Method Name *</label>
                <div class="leo-input-row">
                    <input type="text" name="name" class="leo-input"
                           value="<?= htmlspecialchars($mode['name']) ?>" required>
                    <span class="leo-input-row-icon"><i class="fas fa-tag"></i></span>
                </div>
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Description</label>
                <input type="text" name="description" class="leo-input"
                       value="<?= htmlspecialchars($mode['description'] ?? '') ?>"
                       style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Status</label>
                <select name="status" class="leo-input"
                        style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
                    <option value="Active"   <?= ($mode['status'] ?? 'Active') === 'Active'   ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= ($mode['status'] ?? 'Active') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

        </div>
    </form>

    <div class="pm-bottom-actions">
        <a href="payment-modes.php?delete=<?= (int)$mode['id'] ?>"
           data-confirm="Do you want to delete the payment mode '<?= htmlspecialchars($mode['name'], ENT_QUOTES) ?>'?"
           data-confirm-ok="Yes, delete"
           data-confirm-cancel="Cancel"
           class="leo-btn leo-btn--outline"
           style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
            <i class="fas fa-trash"></i> DELETE
        </a>
        <a href="payment-modes.php" class="leo-btn leo-btn--outline">CANCEL</a>
        <button type="submit" form="pmForm" class="leo-btn leo-btn--primary">UPDATE</button>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>