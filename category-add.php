<?php
$page_title = 'Add Category';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['category_name'] ?? '');
    $desc   = trim($_POST['description']   ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($name === '') {
        flash('warning', 'Category name is required.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (category_name, description, status) VALUES (?,?,?)");
            $stmt->execute([$name, $desc ?: null, $status]);
            flash('success', 'Category saved successfully!');
            header('Location: categories.php');
            exit;
        } catch (PDOException $e) {
            flash('error', 'Error saving category: ' . $e->getMessage());
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
        <span class="leo-page-header-title">Add Category</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="catForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<div class="pm-page-wrap">
<form method="post" id="catForm" class="leo-form-card" style="margin:0.85rem;" data-loading="Saving…">
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
                   placeholder="e.g. Food, Beverages, Electronics" required>
            <span class="leo-input-row-icon"><i class="fas fa-tag"></i></span>
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Description</label>
        <input type="text" name="description" class="leo-input"
               placeholder="Optional — short description"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Status</label>
        <select name="status" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="Active" selected>Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>

</div>
</form>

<div class="pm-bottom-actions">
    <a href="categories.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="catForm" class="leo-btn leo-btn--primary">SAVE CATEGORY</button>
</div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>