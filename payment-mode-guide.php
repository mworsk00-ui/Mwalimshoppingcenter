<?php
$page_title = 'Payment Modes Guide';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="payment-modes.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Payment Modes Guide</span>
    </div>
</header>
<div style="margin:0.85rem;padding:2rem 1.5rem;background:linear-gradient(135deg,#2563EB,#1E40AF);color:#fff;border-radius:16px;text-align:center;">
    <i class="fas fa-credit-card" style="font-size:3rem;margin-bottom:0.75rem;"></i>
    <h1 style="font-size:1.5rem;margin-bottom:0.4rem;">How Payment Modes Work</h1>
    <p style="opacity:0.9;">Set up how your customers can pay — cash, mobile money, bank, more.</p>
</div>
<div style="margin:0.85rem;padding:1.25rem;background:#fff;border-radius:14px;">
    <h2 style="color:#1E3A8A;margin-bottom:0.75rem;">What are Modes of Payment?</h2>
    <p>A <strong>mode of payment</strong> is the way a customer pays you: Cash, M-Pesa, Tigo Pesa, Bank Transfer, etc.</p>
    <p style="margin-top:0.75rem;">Once created, they appear when recording sales or purchases.</p>
</div>
<div class="leo-bottom-actions">
    <a href="payment-modes.php" class="leo-btn leo-btn--outline">BACK</a>
    <a href="payment-mode-add.php" class="leo-btn leo-btn--primary">ADD A MODE</a>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
