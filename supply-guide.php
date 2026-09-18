<?php
$page_title = 'Supplies Guide';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="supplies.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Supplies Guide</span>
    </div>
</header>
<div style="margin:0.85rem;padding:2rem 1.5rem;background:linear-gradient(135deg,#2563EB,#1E40AF);color:#fff;border-radius:16px;text-align:center;">
    <i class="fas fa-box-open" style="font-size:3rem;margin-bottom:0.75rem;"></i>
    <h1 style="font-size:1.5rem;">How Supplies Work</h1>
    <p style="opacity:0.9;">Record every product you send to a customer — with price, quantity, and courier.</p>
</div>
<div style="margin:0.85rem;padding:1.25rem;background:#fff;border-radius:14px;">
    <h2 style="color:#1E3A8A;margin-bottom:0.75rem;">What is a Supply?</h2>
    <p style="color:#334155;line-height:1.6;">A <strong>supply</strong> is a record of goods sent to a customer: "I sent 5kg of rice to Mr. John for 20,000 TZS, delivered by Bodaboda Mike."</p>
</div>
<div style="margin:0.85rem;padding:1.25rem;background:#fff;border-radius:14px;">
    <h2 style="color:#1E3A8A;margin-bottom:0.75rem;">Features</h2>
    <ul style="color:#334155;line-height:1.8;padding-left:1.2rem;">
        <li>Track customer and product</li>
        <li>Quantity with units (kg, L, pcs, carton)</li>
        <li>Payment status (Paid/Partial/Unpaid)</li>
        <li>Courier / Bodaboda details</li>
        <li>Printable receipt</li>
        <li>Soft delete to Recycle Bin</li>
    </ul>
</div>
<div class="leo-bottom-actions">
    <a href="supplies.php" class="leo-btn leo-btn--outline">BACK</a>
    <a href="supply-add.php" class="leo-btn leo-btn--primary">ADD SUPPLY</a>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
