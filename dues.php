<?php
// dues.php
require_once 'includes/header.php';

$message = '';

// Handle Clearing or Paying off Dues
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_due'])) {
    $customer_id = intval($_POST['customer_id']);
    $pay_amount = floatval($_POST['pay_amount']);

    if ($customer_id > 0 && $pay_amount > 0) {
        // Fetch current debt
        $stmt = $pdo->prepare("SELECT dues_amount FROM customers WHERE id = ?");
        $stmt->execute([$customer_id]);
        $current_due = $stmt->fetchColumn() ?: 0;

        $new_due = max(0, $current_due - $pay_amount);

        // Update customer balance
        $update = $pdo->prepare("UPDATE customers SET dues_amount = ? WHERE id = ?");
        $update->execute([$new_due, $customer_id]);

        $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Payment recorded! Remaining Debt: TSH ' . number_format($new_due, 0) . '</div>';
    } else {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Please enter a valid payment amount.</div>';
    }
}

// Fetch Customers with Active Dues (Debt > 0)
$debtors = $pdo->query("SELECT * FROM customers WHERE dues_amount > 0 ORDER BY dues_amount DESC")->fetchAll();
$total_unpaid_dues = $pdo->query("SELECT SUM(dues_amount) AS total FROM customers")->fetch()['total'] ?? 0;
?>

<!-- Total Dues Summary Header -->
<div class="card" style="background: linear-gradient(135deg, #d32f2f, #9a0007); color: white;">
    <div style="font-size: 13px; opacity: 0.9;">Total Unpaid Dues (Debts)</div>
    <div style="font-size: 22px; font-weight: 700; margin-top: 4px;">TSH <?php echo number_format($total_unpaid_dues, 0); ?></div>
</div>

<!-- Dues List & Payment Action Card -->
<div class="card">
    <h3 style="font-size: 15px; color: #d32f2f; margin-bottom: 12px;"><i class="fa-solid fa-clipboard-list"></i> Customer Dues List</h3>
    <?php echo $message; ?>

    <?php if (empty($debtors)): ?>
        <p style="color: var(--text-muted); font-size: 13px;">No outstanding debts recorded!</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <?php foreach ($debtors as $debtor): ?>
                <div style="padding: 12px; background: var(--bg-light); border-radius: 8px; border-left: 4px solid #d32f2f;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                        <div>
                            <strong style="font-size: 14px; display: block; color: var(--text-main);"><?php echo htmlspecialchars($debtor['customer_name']); ?></strong>
                            <span style="font-size: 12px; color: var(--text-muted);"><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($debtor['phone'] ?: 'No Phone'); ?></span>
                        </div>
                        <span style="font-weight: 700; color: #d32f2f; font-size: 15px;">TSH <?php echo number_format($debtor['dues_amount'], 0); ?></span>
                    </div>

                    <!-- Quick Pay Form -->
                    <form action="dues.php" method="POST" style="display: flex; gap: 8px; margin-top: 8px;">
                        <input type="hidden" name="customer_id" value="<?php echo $debtor['id']; ?>">
                        <input type="number" step="0.01" name="pay_amount" placeholder="Amount Paid" required style="width: 60%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
                        <button type="submit" name="clear_due" style="width: 40%; background: var(--primary-green); color: white; border: none; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer;">
                            Clear Debt
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/nav.php'; ?>