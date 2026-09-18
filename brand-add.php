<?php
$page_title = 'Add Brand';
require_once __DIR__ . '/config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['brand_name'] ?? '');
    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO brands (brand_name) VALUES (?)");
            $stmt->execute([$name]);
            header('Location: brands.php'); exit;
        } catch (Exception $e) {}
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="brands.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Brand</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="brandForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<form method="post" id="brandForm">
    <div class="leo-form-card" style="margin:0.85rem;">
        <div class="leo-form-card-body">
            <div class="leo-icon-hero">
                <div class="leo-icon-hero-icon"><i class="fas fa-cube"></i></div>
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Brand Name</label>
                <input type="text" name="brand_name" class="leo-underline-input" placeholder="Enter a brand name" required>
            </div>
        </div>
    </div>
</form>

<div class="leo-bottom-actions">
    <a href="brands.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="brandForm" class="leo-btn leo-btn--primary">SAVE</button>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
