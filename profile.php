<?php
$page_title = 'Profile';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

// Chukua user wa kwanza (au kwa session baadaye)
$user = null;
try {
    $user = $pdo->query("SELECT * FROM users ORDER BY id ASC LIMIT 1")->fetch();
} catch (Exception $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $business_name = trim($_POST['business_name'] ?? '');
    if ($username === '') {
        flash('warning', 'Username is required.');
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE users SET username=?, email=?, business_name=? WHERE id=?");
            $stmt->execute([$username, $email, $business_name, $user['id']]);
            flash('success', 'Profile updated!');
            header('Location: profile.php'); exit;
        } catch (PDOException $e) { flash('error', 'Error: ' . $e->getMessage()); }
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="settings.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Profile</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="profForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<form method="post" id="profForm" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div style="text-align:center;margin:0.5rem 0 1.25rem;">
            <div style="width:110px;height:110px;border-radius:50%;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:3rem;">
                <i class="fas fa-user"></i>
            </div>
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Username *</label>
            <input type="text" name="username" class="leo-input" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Email</label>
            <input type="email" name="email" class="leo-input" value="<?= htmlspecialchars($user['email'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Business Name</label>
            <input type="text" name="business_name" class="leo-input" value="<?= htmlspecialchars($user['business_name'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Package</label>
            <div style="font-size:0.92rem;color:#1E293B;padding:0.5rem 0;"><?= htmlspecialchars($user['package_status'] ?? 'Free Package') ?> · <?= (int)($user['package_days_left'] ?? 7) ?> days left</div>
        </div>
    </div>
</form>

<div class="leo-bottom-actions">
    <a href="settings.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="profForm" class="leo-btn leo-btn--primary">SAVE</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
