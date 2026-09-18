<?php
$page_title = 'Major Shops';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS shops_list (
        id INT AUTO_INCREMENT PRIMARY KEY,
        shop_name VARCHAR(100) NOT NULL,
        location VARCHAR(255),
        branch_id INT,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        deleted_at DATETIME DEFAULT NULL
    )");
} catch (Exception $e) {}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $pdo->prepare("UPDATE shops_list SET deleted_at = NOW() WHERE id = ?")->execute([$id]);
        flash('success', 'Shop deleted.');
    } catch (PDOException $e) { flash('error', $e->getMessage()); }
    header('Location: shops.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['shop_name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($name === '') { flash('warning', 'Shop name required.'); }
    else {
        try {
            $pdo->prepare("INSERT INTO shops_list (shop_name, location, phone) VALUES (?,?,?)")->execute([$name, $location, $phone]);
            flash('success', 'Shop added!');
        } catch (PDOException $e) { flash('error', $e->getMessage()); }
    }
    header('Location: shops.php'); exit;
}

$shops = $pdo->query("SELECT * FROM shops_list WHERE deleted_at IS NULL ORDER BY shop_name")->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="settings.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Major Shops</span>
    </div>
</header>

<form method="post" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;margin-bottom:0.75rem;"><i class="fas fa-plus-circle"></i> Add Shop</div>
        <div class="leo-form-row">
            <input type="text" name="shop_name" class="leo-input" placeholder="Shop name *" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <input type="text" name="location" class="leo-input" placeholder="Location" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <input type="tel" name="phone" class="leo-input" placeholder="Phone" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <button type="submit" class="leo-btn leo-btn--primary" style="width:100%;margin-top:0.5rem;">
            <i class="fas fa-save"></i> SAVE SHOP
        </button>
    </div>
</form>

<?php if (count($shops) > 0): ?>
<div class="leo-section-card" style="margin:0 0.85rem;">
    <?php foreach ($shops as $s): ?>
    <div class="leo-person-item">
        <div class="leo-person-avatar"><i class="fas fa-store"></i></div>
        <div class="leo-person-body">
            <div class="leo-person-name"><?= htmlspecialchars($s['shop_name']) ?></div>
            <div class="leo-person-sub"><?= htmlspecialchars($s['location'] ?: '—') ?></div>
        </div>
        <a href="shops.php?delete=<?= (int)$s['id'] ?>" data-confirm="Delete this shop?" style="color:#EF4444;padding:0.5rem;"><i class="fas fa-trash"></i></a>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
