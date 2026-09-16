<?php
$page_title = 'Add Service';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Service</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-save-btn">SAVE</button>
    </div>
</header>
<div class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div class="leo-form-row">
            <label class="leo-input-label">Service Name</label>
            <input type="text" class="leo-input" placeholder="Enter service name">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Price (TSH)</label>
            <input type="number" class="leo-input" placeholder="0">
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
