<?php
$page_title = 'Security';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$user = null;
try { $user = $pdo->query("SELECT * FROM users ORDER BY id ASC LIMIT 1")->fetch(); } catch (Exception $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (strlen($new) < 6) {
        flash('warning', 'Password must be at least 6 characters.');
    } elseif ($new !== $confirm) {
        flash('warning', 'Passwords do not match.');
    } else {
        try {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
            $stmt->execute([$hash, $user['id']]);
            flash('success', 'Password changed successfully!');
            header('Location: security.php'); exit;
        } catch (PDOException $e) { flash('error', 'Error: ' . $e->getMessage()); }
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="settings.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Security</span>
    </div>
</header>

<form method="post" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div style="text-align:center;margin:0.5rem 0 1.25rem;">
            <div style="width:100px;height:100px;border-radius:50%;background:#DBEAFE;display:inline-flex;align-items:center;justify-content:center;color:#1E40AF;font-size:2.5rem;">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Current Password</label>
            <input type="password" name="current_password" class="leo-input" placeholder="Enter current password" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">New Password *</label>
            <input type="password" name="new_password" class="leo-input" placeholder="At least 6 characters" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Confirm New Password *</label>
            <input type="password" name="confirm_password" class="leo-input" placeholder="Re-enter new password" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
    </div>
</form>

<div class="leo-bottom-actions">
    <a href="settings.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="secForm" class="leo-btn leo-btn--primary" onclick="document.querySelector('form').submit()">CHANGE PASSWORD</button>
</div>

<form id="secForm" method="post" style="display:none;"></form>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
