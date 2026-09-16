<?php
// customers.php
require_once 'includes/header.php';

$message = '';

// Handle Delete Customer
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
    if ($stmt->execute([$id])) {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Customer removed!</div>';
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);
    $edit_id = !empty($_POST['edit_id']) ? intval($_POST['edit_id']) : null;

    if (!empty($name)) {
        if ($edit_id) {
            $stmt = $pdo->prepare("UPDATE customers SET customer_name = ?, phone = ? WHERE id = ?");
            $stmt->execute([$name, $phone, $edit_id]);
            $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Customer profile updated!</div>';
        } else {
            $stmt = $pdo->prepare("INSERT INTO customers (customer_name, phone) VALUES (?, ?)");
            $stmt->execute([$name, $phone]);
            $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Customer added!</div>';
        }
    }
}

// Fetch edit target
$edit_cust = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $edit_cust = $stmt->fetch();
}

$customers = $pdo->query("SELECT * FROM customers ORDER BY id DESC")->fetchAll();
?>

<!-- Form Card -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--primary-green); margin-bottom: 12px;">
        <i class="fa-solid <?php echo $edit_cust ? 'fa-pen-to-square' : 'fa-user-plus'; ?>"></i>
        <?php echo $edit_cust ? 'Edit Customer' : 'Record Customer'; ?>
    </h3>
    <?php echo $message; ?>
    <form action="customers.php" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <input type="hidden" name="edit_id" value="<?php echo $edit_cust['id'] ?? ''; ?>">
        <input type="text" name="customer_name" placeholder="Customer Name" value="<?php echo htmlspecialchars($edit_cust['customer_name'] ?? ''); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        <input type="tel" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($edit_cust['phone'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        
        <button type="submit" style="background: var(--primary-green); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer;">
            <?php echo $edit_cust ? 'Update Customer' : 'Save Customer'; ?>
        </button>
        <?php if ($edit_cust): ?>
            <a href="customers.php" style="text-align: center; color: #888; font-size: 12px; text-decoration: none;">Cancel Edit</a>
        <?php endif; ?>
    </form>
</div>

<!-- Customer Directory -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--dark-forest); margin-bottom: 12px;"><i class="fa-solid fa-address-book"></i> Customer Directory</h3>
    <?php if (empty($customers)): ?>
        <p style="color: var(--text-muted); font-size: 13px;">No customers recorded yet.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <?php foreach ($customers as $cust): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: var(--bg-light); border-radius: 6px;">
                    <div>
                        <strong style="font-size: 14px; display: block; color: var(--text-main);"><?php echo htmlspecialchars($cust['customer_name']); ?></strong>
                        <span style="font-size: 12px; color: var(--text-muted);"><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($cust['phone'] ?: 'N/A'); ?></span>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span style="font-weight: 700; color: <?php echo $cust['dues_amount'] > 0 ? '#d32f2f' : 'var(--primary-green)'; ?>; font-size: 13px;">
                            TSH <?php echo number_format($cust['dues_amount'], 0); ?>
                        </span>
                        <a href="customers.php?edit=<?php echo $cust['id']; ?>" style="color: #0288d1; text-decoration: none;"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="customers.php?delete=<?php echo $cust['id']; ?>" onclick="return confirm('Delete customer profile?');" style="color: #d32f2f; text-decoration: none;"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/nav.php'; ?>