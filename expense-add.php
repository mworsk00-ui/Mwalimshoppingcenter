<?php
$page_title = 'Add Expense';
require_once __DIR__ . '/config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    if ($title !== '' && $amount > 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO expenses (title, amount) VALUES (?,?)");
            $stmt->execute([$title, $amount]);
            header('Location: expenses.php'); exit;
        } catch (Exception $e) {}
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Expense</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="expForm" class="leo-save-btn">SAVE</button>
    </div>
</header>
<form method="post" id="expForm" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div class="leo-form-row">
            <label class="leo-input-label">Expense Title</label>
            <input type="text" name="title" class="leo-input" placeholder="Enter expense title" required>
        </div>
        <div class="leo-form-row">
            <label class="leo-input-label">Amount (TSH)</label>
            <input type="number" name="amount" class="leo-input" placeholder="0" step="0.01" required>
        </div>
    </div>
</form>
<div class="leo-bottom-actions">
    <a href="menu.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="expForm" class="leo-btn leo-btn--primary">SAVE</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
