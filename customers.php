<?php
$page_title = 'Customers';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

// Handle Delete (SOFT delete -> Recycle Bin)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("UPDATE customers SET deleted_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        flash('success', 'Customer moved to Recycle Bin. You can restore it from there.');
    } catch (PDOException $e) {
        flash('error', 'Could not delete customer: ' . $e->getMessage());
    }
    header('Location: customers.php');
    exit;
}

// Fetch only non-deleted customers
$customers = $pdo->query("SELECT * FROM customers WHERE deleted_at IS NULL ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Customers</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="recycle-bin.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-recycle"></i> BIN
        </a>
        <a href="customer-guide.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-circle-question"></i> GUIDE
        </a>
        <a href="customer-add.php" class="leo-save-btn"
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
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Phone</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Due</th>
                <th style="text-align:right;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($customers) > 0): ?>
                <?php foreach ($customers as $i => $c): ?>
                    <tr style="border-top:1px solid #EEF2F7;">
                        <td style="padding:1rem;font-size:0.9rem;color:var(--leo-muted);"><?= $i + 1 ?></td>
                        <td style="padding:1rem;font-size:0.95rem;font-weight:600;color:#1E293B;">
                            <?= htmlspecialchars($c['customer_name']) ?>
                        </td>
                        <td style="padding:1rem;font-size:0.9rem;color:#475569;">
                            <?= htmlspecialchars($c['phone'] ?? '—') ?>
                        </td>
                        <td style="padding:1rem;">
                            <span style="display:inline-block;padding:0.25rem 0.7rem;border-radius:999px;font-size:0.72rem;font-weight:700;background:<?= ((float)($c['due'] ?? 0) > 0) ? '#FEE2E2;color:#991B1B;border:1px solid #FCA5A5' : '#DCFCE7;color:#166534;border:1px solid #86EFAC' ?>;">
                                <?= number_format((float)($c['due'] ?? 0), 2) ?>
                            </span>
                        </td>
                        <td style="padding:1rem;text-align:right;white-space:nowrap;">
                            <a href="customer-view.php?id=<?= (int)$c['id'] ?>"
                               style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.78rem;font-weight:600;background:#E0F2FE;color:#0369A1;text-decoration:none;margin-right:0.3rem;">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="customer-edit.php?id=<?= (int)$c['id'] ?>"
                               style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.78rem;font-weight:600;background:var(--leo-blue-soft);color:var(--leo-primary);text-decoration:none;margin-right:0.3rem;">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <a href="customers.php?delete=<?= (int)$c['id'] ?>"
                               data-confirm="Move '<?= htmlspecialchars($c['customer_name'], ENT_QUOTES) ?>' to the Recycle Bin? You can restore it later."
                               data-confirm-ok="Yes, move to bin"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.78rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);font-size:0.9rem;">
                        <i class="fas fa-users" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                        No customers yet. Click <strong>ADD</strong> to create one.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>