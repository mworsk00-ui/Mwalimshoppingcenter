<?php
// expenses.php
require_once 'includes/header.php';

$message = '';

// Handle Delete Expense
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = ?");
    if ($stmt->execute([$id])) {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Expense deleted!</div>';
    }
}

// Handle Save/Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $amount = floatval($_POST['amount']);
    $edit_id = !empty($_POST['edit_id']) ? intval($_POST['edit_id']) : null;

    if (!empty($title) && $amount > 0) {
        if ($edit_id) {
            $stmt = $pdo->prepare("UPDATE expenses SET title = ?, amount = ? WHERE id = ?");
            $stmt->execute([$title, $amount, $edit_id]);
            $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Expense updated!</div>';
        } else {
            $stmt = $pdo->prepare("INSERT INTO expenses (title, amount) VALUES (?, ?)");
            $stmt->execute([$title, $amount]);
            $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Expense logged!</div>';
        }
    }
}

// Fetch edit target
$edit_expense = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $edit_expense = $stmt->fetch();
}

$expenses = $pdo->query("SELECT * FROM expenses ORDER BY id DESC LIMIT 15")->fetchAll();
$total_expense_sum = $pdo->query("SELECT SUM(amount) AS total FROM expenses")->fetch()['total'] ?? 0;
?>

<!-- Form Card -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--primary-green); margin-bottom: 12px;">
        <i class="fa-solid <?php echo $edit_expense ? 'fa-pen-to-square' : 'fa-file-invoice-dollar'; ?>"></i>
        <?php echo $edit_expense ? 'Edit Expense' : 'Record Business Expense'; ?>
    </h3>
    <?php echo $message; ?>
    <form action="expenses.php" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <input type="hidden" name="edit_id" value="<?php echo $edit_expense['id'] ?? ''; ?>">
        <input type="text" name="title" placeholder="Expense Description" value="<?php echo htmlspecialchars($edit_expense['title'] ?? ''); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        <input type="number" step="0.01" name="amount" placeholder="Amount (TSH)" value="<?php echo $edit_expense['amount'] ?? ''; ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        
        <button type="submit" style="background: var(--primary-green); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer;">
            <?php echo $edit_expense ? 'Update Expense' : 'Save Expense'; ?>
        </button>
        <?php if ($edit_expense): ?>
            <a href="expenses.php" style="text-align: center; color: #888; font-size: 12px; text-decoration: none;">Cancel Edit</a>
        <?php endif; ?>
    </form>
</div>

<!-- History List -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
        <h3 style="font-size: 15px; color: var(--dark-forest);"><i class="fa-solid fa-list-check"></i> Expense History</h3>
        <span style="font-size: 12px; font-weight: 700; color: #d32f2f;">Total: TSH <?php echo number_format($total_expense_sum, 0); ?></span>
    </div>

    <?php if (empty($expenses)): ?>
        <p style="color: var(--text-muted); font-size: 13px;">No expenses recorded yet.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <?php foreach ($expenses as $exp): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: var(--bg-light); border-radius: 6px; border-left: 3px solid #d32f2f;">
                    <div>
                        <strong style="font-size: 14px; display: block; color: var(--text-main);"><?php echo htmlspecialchars($exp['title']); ?></strong>
                        <span style="font-size: 11px; color: var(--text-muted);"><?php echo $exp['created_at']; ?></span>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span style="font-weight: 700; color: #d32f2f; font-size: 14px;">TSH <?php echo number_format($exp['amount'], 0); ?></span>
                        <a href="expenses.php?edit=<?php echo $exp['id']; ?>" style="color: #0288d1; text-decoration: none;"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="expenses.php?delete=<?php echo $exp['id']; ?>" onclick="return confirm('Delete expense?');" style="color: #d32f2f; text-decoration: none;"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/nav.php'; ?>