<?php
$page_title = 'Supplies';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $pdo->prepare("UPDATE supplies SET deleted_at = NOW() WHERE id = ?")->execute([$id]);
        flash('success', 'Supply moved to Recycle Bin.');
    } catch (PDOException $e) { flash('error', $e->getMessage()); }
    header('Location: supplies.php'); exit;
}

$supplies = $pdo->query("SELECT * FROM supplies WHERE deleted_at IS NULL ORDER BY supply_date DESC, id DESC")->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Supplies</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="supply-guide.php" class="leo-save-btn" style="text-decoration:none;background:#FEF3C7;color:#92400E;margin-right:0.4rem;"><i class="fas fa-circle-question"></i></a>
        <a href="supply-add.php" class="leo-save-btn" style="text-decoration:none;"><i class="fas fa-plus"></i> ADD</a>
    </div>
</header>
<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead><tr style="background:var(--leo-blue-soft);">
            <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Date</th>
            <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Customer</th>
            <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Product</th>
            <th style="text-align:right;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Total</th>
            <th style="text-align:right;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Actions</th>
        </tr></thead>
        <tbody>
            <?php if (count($supplies) > 0): foreach ($supplies as $sp): ?>
                <tr style="border-top:1px solid #EEF2F7;">
                    <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:#475569;"><?= date('d M Y', strtotime($sp['supply_date'])) ?></td>
                    <td style="padding:0.85rem 0.7rem;font-size:0.9rem;font-weight:600;color:#1E293B;"><?= htmlspecialchars($sp['customer_name']) ?></td>
                    <td style="padding:0.85rem 0.7rem;font-size:0.88rem;color:#334155;"><?= htmlspecialchars($sp['product_name']) ?> (<?= (float)$sp['quantity'] ?> <?= htmlspecialchars($sp['unit']) ?>)</td>
                    <td style="padding:0.85rem 0.7rem;text-align:right;font-size:0.88rem;font-weight:600;"><?= number_format((float)$sp['total_amount'], 2) ?></td>
                    <td style="padding:0.85rem 0.7rem;text-align:right;white-space:nowrap;">
                        <a href="supply-view.php?id=<?= (int)$sp['id'] ?>" style="display:inline-flex;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#E0F2FE;color:#0369A1;text-decoration:none;margin-right:0.25rem;"><i class="fas fa-eye"></i></a>
                        <a href="supply-edit.php?id=<?= (int)$sp['id'] ?>" style="display:inline-flex;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:var(--leo-blue-soft);color:var(--leo-primary);text-decoration:none;margin-right:0.25rem;"><i class="fas fa-pen"></i></a>
                        <a href="supplies.php?delete=<?= (int)$sp['id'] ?>" data-confirm="Move to Bin?" style="display:inline-flex;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="5" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);"><i class="fas fa-box-open" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>No supply records yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
