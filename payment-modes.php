<?php
$page_title = 'Modes of Payment';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

// Handle Delete (SOFT delete -> Recycle Bin)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("UPDATE payment_modes SET deleted_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        flash('success', 'Payment mode moved to Recycle Bin. You can restore it from there.');
    } catch (PDOException $e) {
        flash('error', 'Could not delete payment mode: ' . $e->getMessage());
    }
    header('Location: payment-modes.php');
    exit;
}

// Fetch only non-deleted
$payment_modes = $pdo->query("SELECT * FROM payment_modes WHERE deleted_at IS NULL ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Modes of Payment</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="recycle-bin.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-recycle"></i> BIN
        </a>
        <a href="payment-mode-guide.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-circle-question"></i> GUIDE
        </a>
        <a href="payment-mode-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:var(--leo-blue-soft);">
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">#</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Name</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Description</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Status</th>
                <th style="text-align:right;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($payment_modes) > 0): ?>
                <?php foreach ($payment_modes as $i => $mode): ?>
                    <tr style="border-top:1px solid #EEF2F7;">
                        <td style="padding:1rem;font-size:0.9rem;color:var(--leo-muted);"><?= $i + 1 ?></td>
                        <td style="padding:1rem;font-size:0.95rem;font-weight:600;color:#1E293B;">
                            <?= htmlspecialchars($mode['name']) ?>
                        </td>
                        <td style="padding:1rem;font-size:0.9rem;color:#475569;">
                            <?= htmlspecialchars($mode['description'] ?? '—') ?>
                        </td>
                        <td style="padding:1rem;">
                            <span style="display:inline-block;padding:0.25rem 0.7rem;border-radius:999px;font-size:0.72rem;font-weight:700;text-transform:uppercase;background:#FEF3C7;color:#92400E;border:1px solid #FDE68A;">
                                <?= htmlspecialchars($mode['status'] ?? 'Active') ?>
                            </span>
                        </td>
                        <td style="padding:1rem;text-align:right;white-space:nowrap;">
                            <a href="payment-mode-edit.php?id=<?= (int)$mode['id'] ?>"
                               style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.8rem;border-radius:8px;font-size:0.8rem;font-weight:600;background:var(--leo-blue-soft);color:var(--leo-primary);text-decoration:none;margin-right:0.35rem;">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <a href="payment-modes.php?delete=<?= (int)$mode['id'] ?>"
                               data-confirm="Move '<?= htmlspecialchars($mode['name'], ENT_QUOTES) ?>' to the Recycle Bin? You can restore it later."
                               data-confirm-ok="Yes, move to bin"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.8rem;border-radius:8px;font-size:0.8rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);font-size:0.9rem;">
                        <i class="fas fa-inbox" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                        No payment modes added yet. Click <strong>ADD</strong> to create one.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>