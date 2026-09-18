<?php
$page_title = 'Recycle Bin';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$TYPE_MAP = [
    'customer'     => ['table' => 'customers',     'label' => 'Customer'],
    'payment_mode' => ['table' => 'payment_modes', 'label' => 'Payment Mode'],
    'employee'     => ['table' => 'employees',     'label' => 'Employee'],
    'supply'       => ['table' => 'supplies',      'label' => 'Supply'],
    'category'     => ['table' => 'categories',    'label' => 'Category'],
];

if (isset($_GET['restore'])) {
    $id = (int)$_GET['restore']; $type = $_GET['type'] ?? '';
    if (isset($TYPE_MAP[$type])) {
        try {
            $tbl = $TYPE_MAP[$type]['table'];
            $pdo->prepare("UPDATE {$tbl} SET deleted_at = NULL WHERE id = ?")->execute([$id]);
            flash('success', 'Item restored successfully.');
        } catch (PDOException $e) { flash('error', 'Could not restore: ' . $e->getMessage()); }
    }
    header('Location: recycle-bin.php'); exit;
}

if (isset($_GET['purge'])) {
    $id = (int)$_GET['purge']; $type = $_GET['type'] ?? '';
    if (isset($TYPE_MAP[$type])) {
        try {
            $tbl = $TYPE_MAP[$type]['table'];
            $pdo->prepare("DELETE FROM {$tbl} WHERE id = ? AND deleted_at IS NOT NULL")->execute([$id]);
            flash('success', 'Item permanently deleted.');
        } catch (PDOException $e) { flash('error', 'Could not purge: ' . $e->getMessage()); }
    }
    header('Location: recycle-bin.php'); exit;
}

if (isset($_GET['empty'])) {
    try {
        foreach ($TYPE_MAP as $cfg) {
            $pdo->exec("DELETE FROM {$cfg['table']} WHERE deleted_at IS NOT NULL");
        }
        flash('warning', 'Recycle Bin emptied. Items gone forever.');
    } catch (PDOException $e) { flash('error', 'Could not empty bin: ' . $e->getMessage()); }
    header('Location: recycle-bin.php'); exit;
}

$items = [];

try {
    $rows = $pdo->query("SELECT id, customer_name AS label, phone AS meta, deleted_at FROM customers WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC")->fetchAll();
    foreach ($rows as $r) { $r['type'] = 'customer'; $r['type_label'] = 'Customer'; $items[] = $r; }
} catch (PDOException $e) {}

try {
    $rows = $pdo->query("SELECT id, name AS label, description AS meta, deleted_at FROM payment_modes WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC")->fetchAll();
    foreach ($rows as $r) { $r['type'] = 'payment_mode'; $r['type_label'] = 'Payment Mode'; $items[] = $r; }
} catch (PDOException $e) {}

try {
    $rows = $pdo->query("SELECT id, employee_name AS label, role AS meta, deleted_at FROM employees WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC")->fetchAll();
    foreach ($rows as $r) { $r['type'] = 'employee'; $r['type_label'] = 'Employee'; $items[] = $r; }
} catch (PDOException $e) {}

try {
    $rows = $pdo->query("SELECT id, CONCAT(product_name, ' → ', customer_name) AS label, CONCAT(quantity, ' ', unit) AS meta, deleted_at FROM supplies WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC")->fetchAll();
    foreach ($rows as $r) { $r['type'] = 'supply'; $r['type_label'] = 'Supply'; $items[] = $r; }
} catch (PDOException $e) {}

try {
    $rows = $pdo->query("SELECT id, category_name AS label, description AS meta, deleted_at FROM categories WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC")->fetchAll();
    foreach ($rows as $r) { $r['type'] = 'category'; $r['type_label'] = 'Category'; $items[] = $r; }
} catch (PDOException $e) {}

usort($items, fn($a, $b) => strcmp($b['deleted_at'], $a['deleted_at']));

require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Recycle Bin</span>
    </div>
    <div class="leo-page-header-actions">
        <?php if (count($items) > 0): ?>
            <a href="recycle-bin.php?empty=1" data-confirm="⚠️ Permanently delete ALL items in the Recycle Bin? This cannot be undone." class="leo-save-btn" style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEE2E2;color:#991B1B;">
                <i class="fas fa-fire"></i> EMPTY
            </a>
        <?php endif; ?>
    </div>
</header>

<div style="margin:0.85rem;padding:0.85rem 1rem;border-radius:12px;background:#FEF3C7;border:1px solid #FDE68A;color:#78350F;font-size:0.87rem;display:flex;gap:0.6rem;align-items:flex-start;">
    <i class="fas fa-triangle-exclamation" style="color:#D97706;font-size:1.1rem;margin-top:0.1rem;"></i>
    <div><strong>Important:</strong> Items here can still be restored. But if you press <em>Empty</em>, they are permanently deleted.</div>
</div>

<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:var(--leo-blue-soft);">
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);">Type</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);">Item</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);">Deleted</th>
                <th style="text-align:right;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($items) > 0): foreach ($items as $it): ?>
                <tr style="border-top:1px solid #EEF2F7;">
                    <td style="padding:1rem;">
                        <span style="display:inline-block;padding:0.25rem 0.7rem;border-radius:999px;font-size:0.72rem;font-weight:700;background:#E0F2FE;color:#0369A1;">
                            <?= htmlspecialchars($it['type_label']) ?>
                        </span>
                    </td>
                    <td style="padding:1rem;">
                        <div style="font-size:0.95rem;font-weight:600;color:#1E293B;"><?= htmlspecialchars($it['label']) ?></div>
                        <?php if (!empty($it['meta'])): ?>
                            <div style="font-size:0.82rem;color:#64748B;"><?= htmlspecialchars($it['meta']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="padding:1rem;font-size:0.85rem;color:#64748B;">
                        <?= htmlspecialchars(date('d M Y, H:i', strtotime($it['deleted_at']))) ?>
                    </td>
                    <td style="padding:1rem;text-align:right;white-space:nowrap;">
                        <a href="recycle-bin.php?restore=<?= (int)$it['id'] ?>&type=<?= urlencode($it['type']) ?>" data-confirm="Restore '<?= htmlspecialchars($it['label'], ENT_QUOTES) ?>'?" style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.78rem;font-weight:600;background:#DCFCE7;color:#166534;text-decoration:none;margin-right:0.3rem;">
                            <i class="fas fa-rotate-left"></i> Restore
                        </a>
                        <a href="recycle-bin.php?purge=<?= (int)$it['id'] ?>&type=<?= urlencode($it['type']) ?>" data-confirm="⚠️ Permanently delete '<?= htmlspecialchars($it['label'], ENT_QUOTES) ?>'?" style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.78rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;">
                            <i class="fas fa-trash"></i> Delete Forever
                        </a>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="4" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);font-size:0.9rem;">
                    <i class="fas fa-recycle" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                    Recycle Bin is empty.
                </td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
