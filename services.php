<?php
// services.php
require_once 'includes/header.php';

$message = '';

// Handle Delete Service Entry
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM sales WHERE id = ? AND is_service = 1");
    if ($stmt->execute([$id])) {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Service entry deleted!</div>';
    }
}

// Handle Record Service Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_service'])) {
    $service_name = trim($_POST['service_name']);
    $service_fee = floatval($_POST['service_fee']);
    $payment_status = $_POST['payment_status'];
    $customer_id = !empty($_POST['customer_id']) ? intval($_POST['customer_id']) : null;

    if (!empty($service_name) && $service_fee >= 0) {
        // Record as a sale entry marked as a service (is_service = 1)
        $stmt = $pdo->prepare("INSERT INTO sales (total_amount, payment_status, customer_id, service_name, is_service) VALUES (?, ?, ?, ?, 1)");
        $stmt->execute([$service_fee, $payment_status, $customer_id, $service_name]);

        // If unpaid, add to customer debt balance
        if ($payment_status === 'due' && $customer_id) {
            $update_due = $pdo->prepare("UPDATE customers SET dues_amount = dues_amount + ? WHERE id = ?");
            $update_due->execute([$service_fee, $customer_id]);
        }

        $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Service recorded! Total: TSH ' . number_format($service_fee, 0) . '</div>';
    } else {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Please enter valid service details.</div>';
    }
}

// Fetch Customers and Service History
$customers = $pdo->query("SELECT * FROM customers ORDER BY customer_name ASC")->fetchAll();
$service_history = $pdo->query("SELECT sales.*, customers.customer_name FROM sales LEFT JOIN customers ON sales.customer_id = customers.id WHERE is_service = 1 ORDER BY sales.id DESC LIMIT 10")->fetchAll();
?>

<!-- Record Service Form -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--primary-green); margin-bottom: 12px;"><i class="fa-solid fa-hand-holding-hand"></i> Record Provided Service</h3>
    <?php echo $message; ?>
    <form action="services.php" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <input type="text" name="service_name" placeholder="Service Name / Description (e.g. Delivery, Repair)" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        
        <input type="number" step="0.01" name="service_fee" placeholder="Service Fee (TSH)" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

        <div style="display: flex; gap: 10px;">
            <select name="payment_status" style="width: 50%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; background: #fff;">
                <option value="paid">Paid</option>
                <option value="due">Unpaid / Debt</option>
            </select>

            <select name="customer_id" style="width: 50%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; background: #fff;">
                <option value="">-- Customer (Optional) --</option>
                <?php foreach ($customers as $cust): ?>
                    <option value="<?php echo $cust['id']; ?>"><?php echo htmlspecialchars($cust['customer_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="record_service" style="background: var(--primary-green); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer;">
            Save Service Entry
        </button>
    </form>
</div>

<!-- Recent Services Log -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--dark-forest); margin-bottom: 12px;"><i class="fa-solid fa-list-check"></i> Service Activity</h3>
    <?php if (empty($service_history)): ?>
        <p style="color: var(--text-muted); font-size: 13px;">No services logged yet.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <?php foreach ($service_history as $srv): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: var(--bg-light); border-radius: 6px;">
                    <div>
                        <strong style="font-size: 13px; display: block; color: var(--text-main);">
                            <?php echo htmlspecialchars($srv['service_name']); ?> <?php echo $srv['customer_name'] ? '(' . htmlspecialchars($srv['customer_name']) . ')' : ''; ?>
                        </strong>
                        <span style="font-size: 11px; color: var(--text-muted);"><?php echo $srv['created_at']; ?></span>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <div style="text-align: right;">
                            <span style="font-weight: 700; color: var(--primary-green); font-size: 13px;">TSH <?php echo number_format($srv['total_amount'], 0); ?></span>
                            <span style="display: block; font-size: 10px; font-weight: bold; text-transform: uppercase; color: <?php echo $srv['payment_status'] === 'paid' ? 'green' : 'red'; ?>;">
                                <?php echo $srv['payment_status']; ?>
                            </span>
                        </div>
                        <a href="services.php?delete=<?php echo $srv['id']; ?>" onclick="return confirm('Delete this service record?');" style="color: #d32f2f; text-decoration: none;"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/nav.php'; ?>