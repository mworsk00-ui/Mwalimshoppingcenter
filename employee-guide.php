<?php
$page_title = 'Employees Guide';
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="employees.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Employees Guide</span>
    </div>
</header>
<div style="margin:0.85rem;padding:2rem 1.5rem;background:linear-gradient(135deg,#2563EB,#1E40AF);color:#fff;border-radius:16px;text-align:center;">
    <i class="fas fa-user-tie" style="font-size:3rem;margin-bottom:0.75rem;"></i>
    <h1 style="font-size:1.5rem;">How Employees Work</h1>
    <p style="opacity:0.9;">Record everyone who works for you — contact, pay, schedule.</p>
</div>
<div style="margin:0.85rem;padding:1.25rem;background:#fff;border-radius:14px;">
    <h2 style="color:#1E3A8A;margin-bottom:0.75rem;">What you can do:</h2>
    <ul style="color:#334155;line-height:1.8;padding-left:1.2rem;">
        <li>Add employee with role, salary, schedule</li>
        <li>Track daily/weekly/monthly pay</li>
        <li>Set working days and hours</li>
        <li>Mark Active or Inactive</li>
        <li>Soft delete to Recycle Bin</li>
    </ul>
</div>
<div class="leo-bottom-actions">
    <a href="employees.php" class="leo-btn leo-btn--outline">BACK</a>
    <a href="employee-add.php" class="leo-btn leo-btn--primary">ADD EMPLOYEE</a>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
