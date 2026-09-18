<?php
$page_title = 'Sales Settings';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$settings = [];
try {
    $rows = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll();
    foreach ($rows as $r) $settings[$r['setting_key']] = $r['setting_value'];
} catch (Exception $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'setting_') === 0) {
                $realKey = substr($key, 8);
                $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([$realKey, trim($value)]);
            }
        }
        flash('success', 'Sales settings saved!');
        header('Location: sales-settings.php'); exit;
    } catch (PDOException $e) { flash('error', 'Error: ' . $e->getMessage()); }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="settings.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Sales Settings</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="salesForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<form method="post" id="salesForm" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div class="leo-form-row">
            <label class="leo-input-label">Default Tax Rate (%)</label>
            <input type="number" step="0.01" name="setting_default_tax" class="leo-input" value="<?= htmlspecialchars($settings['default_tax'] ?? '0') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Default Currency</label>
            <input type="text" name="setting_default_currency" class="leo-input" value="<?= htmlspecialchars($settings['default_currency'] ?? 'TSH') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Invoice Prefix</label>
            <input type="text" name="setting_invoice_prefix" class="leo-input" value="<?= htmlspecialchars($settings['invoice_prefix'] ?? 'S-') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Low Stock Alert Threshold</label>
            <input type="number" name="setting_low_stock_threshold" class="leo-input" value="<?= htmlspecialchars($settings['low_stock_threshold'] ?? '5') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
        </div>
    </div>
</form>

<div class="leo-bottom-actions">
    <a href="settings.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="salesForm" class="leo-btn leo-btn--primary">SAVE</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
