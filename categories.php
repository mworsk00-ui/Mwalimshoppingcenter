<?php
$page_title = 'Product Categories';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

// Soft delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("UPDATE categories SET deleted_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        flash('success', 'Category moved to Recycle Bin. You can restore it from there.');
    } catch (PDOException $e) {
        flash('error', 'Could not delete category: ' . $e->getMessage());
    }
    header('Location: categories.php');
    exit;
}

// Toggle Active/Inactive
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    try {
        $st = $pdo->prepare("SELECT category_name, status FROM categories WHERE id = ? AND deleted_at IS NULL");
        $st->execute([$id]);
        $row = $st->fetch();
        if ($row) {
            $new = ($row['status'] === 'Active') ? 'Inactive' : 'Active';
            $up = $pdo->prepare("UPDATE categories SET status = ? WHERE id = ?");
            $up->execute([$new, $id]);
            flash('success', "'{$row['category_name']}' is now {$new}.");
        }
    } catch (PDOException $e) {
        flash('error', 'Could not update status: ' . $e->getMessage());
    }
    header('Location: categories.php');
    exit;
}

// Fetch categories + count products in each
$categories = $pdo->query("
    SELECT c.*,
           (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.deleted_at IS NULL) AS product_count
    FROM categories c
    WHERE c.deleted_at IS NULL
    ORDER BY c.category_name ASC
")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Categories</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="recycle-bin.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-recycle"></i> BIN
        </a>
        <a href="category-guide.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-circle-question"></i> GUIDE
        </a>
        <a href="category-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:var(--leo-blue-soft);">
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">#</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Category</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Description</th>
                <th style="text-align:center;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Products</th>
                <th style="text-align:center;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Status</th>
                <th style="text-align:right;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($categories) > 0): ?>
                <?php foreach ($categories as $i => $c):
                    $isActive = $c['status'] === 'Active';
                    $stColor = $isActive
                        ? '#DCFCE7;color:#166534;border:1px solid #86EFAC'
                        : '#F1F5F9;color:#475569;border:1px solid #CBD5E1';
                    $toggleColor = $isActive
                        ? 'background:#FEF3C7;color:#92400E;'
                        : 'background:#DCFCE7;color:#166534;';
                    $toggleIcon  = $isActive ? 'fa-eye-slash' : 'fa-eye';
                    $confirmMsg  = $isActive
                        ? "Mark '{$c['category_name']}' as Inactive?"
                        : "Reactivate '{$c['category_name']}'?";
                ?>
                    <tr style="border-top:1px solid #EEF2F7; <?= $isActive ? '' : 'opacity:0.65;' ?>">
                        <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:var(--leo-muted);"><?= $i + 1 ?></td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.92rem;font-weight:600;color:#1E293B;">
                            <?= htmlspecialchars($c['category_name']) ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:#475569;">
                            <?= htmlspecialchars($c['description'] ?? '—') ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;text-align:center;">
                            <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:999px;font-size:0.72rem;font-weight:700;background:#E0F2FE;color:#0369A1;">
                                <?= (int)$c['product_count'] ?>
                            </span>
                        </td>
                        <td style="padding:0.85rem 0.7rem;text-align:center;">
                            <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:999px;font-size:0.68rem;font-weight:700;background:<?= $stColor ?>;">
                                <?= htmlspecialchars($c['status']) ?>
                            </span>
                        </td>
                        <td style="padding:0.85rem 0.7rem;text-align:right;white-space:nowrap;">
                            <a href="category-view.php?id=<?= (int)$c['id'] ?>" title="View"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#E0F2FE;color:#0369A1;text-decoration:none;margin-right:0.25rem;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="category-edit.php?id=<?= (int)$c['id'] ?>" title="Edit"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:var(--leo-blue-soft);color:var(--leo-primary);text-decoration:none;margin-right:0.25rem;">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="categories.php?toggle=<?= (int)$c['id'] ?>"
                               title="Toggle status"
                               data-confirm="<?= htmlspecialchars($confirmMsg, ENT_QUOTES) ?>"
                               data-confirm-ok="Yes, continue"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;<?= $toggleColor ?>text-decoration:none;margin-right:0.25rem;">
                                <i class="fas <?= $toggleIcon ?>"></i>
                            </a>
                            <a href="categories.php?delete=<?= (int)$c['id'] ?>" title="Delete"
                               data-confirm="Move '<?= htmlspecialchars($c['category_name'], ENT_QUOTES) ?>' to the Recycle Bin? You can restore later."
                               data-confirm-ok="Yes, move to bin"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);font-size:0.9rem;">
                        <i class="fas fa-list" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                        No categories yet. Click <strong>ADD</strong> to create one.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>