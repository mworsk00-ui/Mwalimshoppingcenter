<?php
$page_title = 'Add Purchase';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Purchase</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-save-btn">SAVE</button>
    </div>
</header>
<div class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div class="leo-form-row">
            <label class="leo-input-label">Supplier</label>
            <input type="text" class="leo-input" placeholder="Select supplier">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Product</label>
            <input type="text" class="leo-input" placeholder="Enter product">
        </div>
        <div class="leo-form-row leo-form-row-inline">
            <div>
                <label class="leo-input-label">Quantity</label>
                <input type="number" class="leo-input" placeholder="0">
            </div>
            <div>
                <label class="leo-input-label">Unit Price</label>
                <input type="number" class="leo-input" placeholder="0">
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
