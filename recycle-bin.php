<?php
$page_title = 'Recycle Bin';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

/* ---------- ACTIONS ---------- */

// Restore one item
if (isset($_GET['restore'])) {
    $id   = (int)$_GET['restore'];
    $type = $_GET['type'] ?? '';
    $map  = [
        'customer'     => 'customers',
        'payment_mode' => 'payment_modes',
    ];
    if (isset($map[$type])) {
        try {
            $stmt = $pdo->prepare("UPDATE {$map[$type]} SET deleted_at = NULL WHERE id = ?");
            $stmt->execute([$id]);
            flash('success', 'Item restored successfully.');
        } catch (PDOException $e) {
            flash('error', 'Could not restore: ' . $e->getMessage());
        }
    }
    header('Location: recycle-bin.php');
    exit;
}

// Delete forever (single item)
if (isset($_GET['purge'])) {
    $id   = (int)$_GET['purge'];
    $type = $_GET['type'] ?? '';
    $map  = [
        'customer'     => 'customers',
        'payment_mode' => 'payment_modes',
    ];
    if (isset($map[$type])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM {$map[$type]} WHERE id = ? AND deleted_at IS NOT NULL");
            $stmt->execute([$id]);
            flash('success', 'Item permanently deleted.');
        } catch (PDOException $e) {
            flash('error', 'Could not purge: ' . $e->getMessage());
        }
    }
    header('Location: recycle-bin.php');
    exit;
}

// Empty the whole bin
if (isset($_GET['empty'])) {
    try {
        $pdo->exec("DELETE FROM customers     WHERE deleted_at IS NOT NULL");
        $pdo->exec("DELETE FROM payment_modes WHERE deleted_at IS NOT NULL");
        flash('warning', 'Recycle Bin emptied. These items are gone forever.');
    } catch (PDOException $e) {
        flash('error', 'Could not empty bin: ' . $e->getMessage());
    }
    header('Location: recycle-bin.php');
    exit;
}

/* ---------- FETCH ITEMS ---------- */

$items = [];

$rows = $pdo->query("SELECT id, customer_name AS label, phone AS meta, deleted_at
                     FROM customers
                     WHERE deleted_at IS NOT NULL
                     ORDER BY deleted_at DESC")->fetchAll();
foreach ($rows as $r) {
    $r['type']      = 'customer';
    $r['type_label']= 'Customer';
    $items[] = $r;
}

$rows = $pdo->query("SELECT id, name AS label, description AS meta, deleted_at
                     FROM payment_modes
                     WHERE deleted_at IS NOT NULL
                     ORDER BY deleted_at DESC")->fetchAll();
foreach ($rows as $r) {
    $r['type']      = 'payment_mode';
    $r['type_label']= 'Payment Mode';
    $items[] = $r;
}

// Sort newest first
usort($items, fn($a, $b) => strcmp($b['deleted_at'], $a['deleted_at']));

require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Recycle Bin</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="recycle-bin-guide.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-circle-question"></i> GUIDE
        </a>
        <?php if (count($items) > 0): ?>
            <a href="recycle-bin.php?empty=1"
               data-confirm="⚠️ This will permanently delete ALL items in the Recycle Bin. This cannot be undone. Continue?"
               data-confirm-ok="Yes, empty bin"
               data-confirm-cancel="Cancel"
               class="leo-save-btn"
               style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEE2E2;color:#991B1B;">
                <i class="fas fa-fire"></i> EMPTY BIN
            </a>
        <?php endif; ?>
    </div>
</header>

<!-- Warning banner -->
<div style="margin:0.85rem;padding:0.85rem 1rem;border-radius:12px;background:#FEF3C7;border:1px solid #FDE68A;color:#78350F;font-size:0.87rem;display:flex;gap:0.6rem;align-items:flex-start;">
    <i class="fas fa-triangle-exclamation" style="color:#D97706;font-size:1.1rem;margin-top:0.1rem;"></i>
    <div>
        <strong>Important:</strong> Items here can still be restored. But if you press
        <em>Empty Bin</em>, they are <strong>permanently deleted</strong> and
        <strong>cannot be recovered</strong> from inside the app. You would need to contact the
        developer to attempt recovery from a database backup.
    </div>
</div>

<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:var(--leo-blue-soft);">
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Type</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Item</th>
                <th style="text-align:left;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Deleted</th>
                <th style="text-align:right;padding:0.9rem 1rem;font-size:0.8rem;text-transform:uppercase;color:var(--leo-primary);letter-spacing:0.04em;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($items) > 0): ?>
                <?php foreach ($items as $it): ?>
                    <tr style="border-top:1px solid #EEF2F7;">
                        <td style="padding:1rem;">
                            <span style="display:inline-block;padding:0.25rem 0.7rem;border-radius:999px;font-size:0.72rem;font-weight:700;background:#E0F2FE;color:#0369A1;">
                                <?= htmlspecialchars($it['type_label']) ?>
                            </span>
                        </td>
                        <td style="padding:1rem;">
                            <div style="font-size:0.95rem;font-weight:600;color:#1E293B;">
                                <?= htmlspecialchars($it['label']) ?>
                            </div>
                            <?php if (!empty($it['meta'])): ?>
                                <div style="font-size:0.82rem;color:#64748B;">
                                    <?= htmlspecialchars($it['meta']) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="padding:1rem;font-size:0.85rem;color:#64748B;">
                            <?= htmlspecialchars(date('d M Y, H:i', strtotime($it['deleted_at']))) ?>
                        </td>
                        <td style="padding:1rem;text-align:right;white-space:nowrap;">
                            <a href="recycle-bin.php?restore=<?= (int)$it['id'] ?>&type=<?= urlencode($it['type']) ?>"
                               data-confirm="Restore '<?= htmlspecialchars($it['label'], ENT_QUOTES) ?>'?"
                               data-confirm-ok="Yes, restore"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.78rem;font-weight:600;background:#DCFCE7;color:#166534;text-decoration:none;margin-right:0.3rem;">
                                <i class="fas fa-rotate-left"></i> Restore
                            </a>
                            <a href="recycle-bin.php?purge=<?= (int)$it['id'] ?>&type=<?= urlencode($it['type']) ?>"
                               data-confirm="⚠️ Permanently delete '<?= htmlspecialchars($it['label'], ENT_QUOTES) ?>'? This CANNOT be undone."
                               data-confirm-ok="Yes, delete forever"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.78rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;">
                                <i class="fas fa-trash"></i> Delete Forever
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);font-size:0.9rem;">
                        <i class="fas fa-recycle" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                        Recycle Bin is empty.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>