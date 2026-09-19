<?php
$page_title = 'Edit Category';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$c = $stmt->fetch();

if (!$c) {
    flash('warning', 'Category not found.');
    header('Location: categories.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['category_name'] ?? '');
    $desc   = trim($_POST['description']   ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($name === '') {
        flash('warning', 'Category name is required.');
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE categories SET category_name=?, description=?, status=? WHERE id=?");
            $stmt->execute([$name, $desc ?: null, $status, $id]);
            flash('success', 'Category updated successfully!');
            header('Location: categories.php');
            exit;
        } catch (PDOException $e) {
            flash('error', 'Error updating category: ' . $e->getMessage());
        }
    }
}
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .pm-page-wrap { min-height: calc(100vh - 140px); display: flex; flex-direction: column; }
    .pm-page-wrap .leo-form-card { flex: 1; }
    .pm-bottom-actions {
        position: sticky; bottom: 0; background: #fff;
        border-top: 1px solid #E5EAF0; padding: 0.85rem 1rem;
        display: flex; gap: 0.6rem; margin-top: auto;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.04);
    }
    .pm-bottom-actions .leo-btn { flex: 1; justify-content: center; text-align: center; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="categories.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Category</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="catForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<div class="pm-page-wrap">
<form method="post" id="catForm" class="leo-form-card" style="margin:0.85rem;" data-loading="Updating…">
<div class="leo-form-card-body">

    <div style="text-align:center;margin:0.5rem 0 1rem;">
        <div style="width:90px;height:90px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.2rem;">
            <i class="fas fa-list"></i>
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Category Name *</label>
        <div class="leo-input-row">
            <input type="text" name="category_name" class="leo-input"
                   value="<?= htmlspecialchars($c['category_name']) ?>" required>
            <span class="leo-input-row-icon"><i class="fas fa-tag"></i></span>
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Description</label>
        <input type="text" name="description" class="leo-input"
               value="<?= htmlspecialchars($c['description'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Status</label>
        <select name="status" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="Active"   <?= $c['status'] === 'Active'   ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= $c['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>

</div>
</form>

<div class="pm-bottom-actions">
    <a href="categories.php?delete=<?= (int)$c['id'] ?>"
       data-confirm="Move '<?= htmlspecialchars($c['category_name'], ENT_QUOTES) ?>' to the Recycle Bin?"
       data-confirm-ok="Yes, move to bin"
       data-confirm-cancel="Cancel"
       class="leo-btn leo-btn--outline"
       style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
        <i class="fas fa-trash"></i> DELETE
    </a>
    <a href="categories.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="catForm" class="leo-btn leo-btn--primary">UPDATE</button>
</div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>