<?php
$page_title = 'Major Branches';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

// Unda table kama haipo
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS branches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        branch_name VARCHAR(100) NOT NULL,
        location VARCHAR(255),
        manager VARCHAR(100),
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        deleted_at DATETIME DEFAULT NULL
    )");
} catch (Exception $e) {}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $pdo->prepare("UPDATE branches SET deleted_at = NOW() WHERE id = ?")->execute([$id]);
        flash('success', 'Branch deleted.');
    } catch (PDOException $e) { flash('error', $e->getMessage()); }
    header('Location: branches.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['branch_name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $manager = trim($_POST['manager'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($name === '') { flash('warning', 'Branch name required.'); }
    else {
        try {
            $pdo->prepare("INSERT INTO branches (branch_name, location, manager, phone) VALUES (?,?,?,?)")->execute([$name, $location, $manager, $phone]);
            flash('success', 'Branch added!');
        } catch (PDOException $e) { flash('error', $e->getMessage()); }
    }
    header('Location: branches.php'); exit;
}

$branches = $pdo->query("SELECT * FROM branches WHERE deleted_at IS NULL ORDER BY branch_name")->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="settings.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Major Branches</span>
    </div>
</header>

<form method="post" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;margin-bottom:0.75rem;"><i class="fas fa-plus-circle"></i> Add Branch</div>
        <div class="leo-form-row">
            <input type="text" name="branch_name" class="leo-input" placeholder="Branch name *" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <input type="text" name="location" class="leo-input" placeholder="Location" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row leo-form-row-inline">
            <input type="text" name="manager" class="leo-input" placeholder="Manager" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <input type="tel" name="phone" class="leo-input" placeholder="Phone" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <button type="submit" class="leo-btn leo-btn--primary" style="width:100%;margin-top:0.5rem;">
            <i class="fas fa-save"></i> SAVE BRANCH
        </button>
    </div>
</form>

<?php if (count($branches) > 0): ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($branches as $b): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-sitemap"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?= htmlspecialchars($b['branch_name']) ?></div>
            <div class="leo-person-sub"><?= htmlspecialchars($b['location'] ?: '—') ?> · <?= htmlspecialchars($b['manager'] ?: '') ?></div>
        </div>
        <a href="branches.php?delete=<?= (int)$b['id'] ?>" data-confirm="Delete this branch?" style="color:#EF4444;padding:0.5rem;"><i class="fas fa-trash"></i></a>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
