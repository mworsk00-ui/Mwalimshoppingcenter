<?php
$page_title = 'Recycle Bin Guide';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="recycle-bin.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Recycle Bin Guide</span>
    </div>
</header>

<div style="margin:0.85rem;padding:2rem 1.5rem;background:linear-gradient(135deg,#F59E0B,#B45309);color:#fff;border-radius:16px;text-align:center;">
    <i class="fas fa-recycle" style="font-size:3rem;margin-bottom:0.75rem;"></i>
    <h1 style="font-size:1.5rem;margin-bottom:0.4rem;">How the Recycle Bin Works</h1>
    <p style="opacity:0.9;">A safety net for accidental deletions.</p>
</div>

<div style="margin:0.85rem;padding:1.25rem;background:#fff;border-radius:14px;">
    <h2 style="color:#92400E;margin-bottom:0.75rem;"><i class="fas fa-shield-halved" style="background:#FEF3C7;color:#B45309;width:32px;height:32px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;margin-right:0.5rem;"></i> What is it?</h2>
    <p style="color:#334155;line-height:1.6;">When you delete a customer, payment mode, employee, supply, or category — it doesn't disappear. It goes into the <strong>Recycle Bin</strong>, where you can <strong>Restore</strong> or <strong>Delete Forever</strong>.</p>
</div>

<div style="margin:0.85rem;padding:1.25rem;background:#fff;border-radius:14px;">
    <h2 style="color:#92400E;margin-bottom:0.75rem;"><i class="fas fa-list-check" style="background:#FEF3C7;color:#B45309;width:32px;height:32px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;margin-right:0.5rem;"></i> How to Use</h2>
    <ol style="color:#334155;line-height:1.8;padding-left:1.2rem;">
        <li><strong>Delete anything</strong> from any list page — it goes to the Bin</li>
        <li><strong>Open Recycle Bin</strong> from Menu → System</li>
        <li><strong>Restore</strong> items deleted by mistake</li>
        <li><strong>Delete Forever</strong> removes permanently</li>
        <li><strong>Empty Bin</strong> wipes everything at once</li>
    </ol>
</div>

<div style="margin:0.85rem;padding:1rem;background:#FEE2E2;border-left:4px solid #DC2626;border-radius:8px;color:#7F1D1D;font-size:0.88rem;">
    <i class="fas fa-circle-exclamation" style="color:#DC2626;margin-right:0.35rem;"></i>
    <strong>Warning:</strong> Once you press <em>Delete Forever</em> or <em>Empty Bin</em>, data is permanently erased.
</div>

<div class="leo-bottom-actions">
    <a href="recycle-bin.php" class="leo-btn leo-btn--outline">BACK TO BIN</a>
    <a href="menu.php" class="leo-btn leo-btn--primary">BACK TO MENU</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
