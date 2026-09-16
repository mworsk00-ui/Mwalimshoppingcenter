<?php
// sales.php
require_once 'includes/header.php';

$message = '';

// Handle Delete Sale Entry
if (isset($_GET['delete'])) {
    $sale_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM sales WHERE id = ?");
    if ($stmt->execute([$sale_id])) {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Sale record removed!</div>';
    }
}

// Handle Record Sale Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_sale'])) {
    $product_id = intval($_POST['product_id']);
    $qty_sold = intval($_POST['quantity']);
    $selling_price = floatval($_POST['selling_price']);
    $payment_status = $_POST['payment_status']; 
    $customer_id = !empty($_POST['customer_id']) ? intval($_POST['customer_id']) : null;

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product && $product['stock_qty'] >= $qty_sold && $qty_sold > 0 && $selling_price >= 0) {
        $total_price = $selling_price * $qty_sold;

        // 1. Record Sale
        $sale_stmt = $pdo->prepare("INSERT INTO sales (total_amount, payment_status, customer_id) VALUES (?, ?, ?)");
        $sale_stmt->execute([$total_price, $payment_status, $customer_id]);

        // 2. Deduct Inventory
        $update_stock = $pdo->prepare("UPDATE products SET stock_qty = stock_qty - ? WHERE id = ?");
        $update_stock->execute([$qty_sold, $product_id]);

        // 3. Update Dues if Unpaid
        if ($payment_status === 'due' && $customer_id) {
            $update_due = $pdo->prepare("UPDATE customers SET dues_amount = dues_amount + ? WHERE id = ?");
            $update_due->execute([$total_price, $customer_id]);
        }

        $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Sale recorded! Total: TSH ' . number_format($total_price, 0) . '</div>';
    } else {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Insufficient stock or invalid inputs.</div>';
    }
}

$products = $pdo->query("SELECT * FROM products WHERE stock_qty > 0 ORDER BY product_name ASC")->fetchAll();
$customers = $pdo->query("SELECT * FROM customers ORDER BY customer_name ASC")->fetchAll();
$sales_history = $pdo->query("SELECT sales.*, customers.customer_name FROM sales LEFT JOIN customers ON sales.customer_id = customers.id ORDER BY sales.id DESC LIMIT 10")->fetchAll();
?>

<!-- Record Sale Form -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--primary-green); margin-bottom: 12px;"><i class="fa-solid fa-cart-plus"></i> Record New Sale</h3>
    <?php echo $message; ?>
    <form action="sales.php" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <select name="product_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; background: #fff;">
            <option value="">-- Select Product --</option>
            <?php foreach ($products as $prod): ?>
                <option value="<?php echo $prod['id']; ?>">
                    <?php echo htmlspecialchars($prod['product_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div style="display: flex; gap: 10px;">
            <div style="width: 50%;">
                <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 2px;">Selling Price (TSH)</label>
                <input type="number" step="0.01" name="selling_price" placeholder="Type Selling Price" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
            </div>
            <div style="width: 50%;">
                <label style="font-size: 11px; color: var(--text-muted); font-weight: bold; display: block; margin-bottom: 2px;">Quantity</label>
                <input type="number" name="quantity" value="1" min="1" placeholder="Quantity" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

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

        <button type="submit" name="record_sale" style="background: var(--primary-green); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer;">
            Complete Sale
        </button>
    </form>
</div>

<!-- Recent Sales Activity -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--dark-forest); margin-bottom: 12px;"><i class="fa-solid fa-receipt"></i> Recent Sales</h3>
    <?php if (empty($sales_history)): ?>
        <p style="color: var(--text-muted); font-size: 13px;">No sales recorded yet.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <?php foreach ($sales_history as $sale): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: var(--bg-light); border-radius: 6px;">
                    <div>
                        <strong style="font-size: 13px; display: block; color: var(--text-main);">
                            #SALE-<?php echo $sale['id']; ?> <?php echo $sale['customer_name'] ? '(' . htmlspecialchars($sale['customer_name']) . ')' : ''; ?>
                        </strong>
                        <span style="font-size: 11px; color: var(--text-muted);"><?php echo $sale['created_at']; ?></span>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <div style="text-align: right;">
                            <span style="font-weight: 700; color: var(--primary-green); font-size: 13px;">TSH <?php echo number_format($sale['total_amount'], 0); ?></span>
                            <span style="display: block; font-size: 10px; font-weight: bold; text-transform: uppercase; color: <?php echo $sale['payment_status'] === 'paid' ? 'green' : 'red'; ?>;">
                                <?php echo $sale['payment_status']; ?>
                            </span>
                        </div>
                        <a href="sales.php?delete=<?php echo $sale['id']; ?>" onclick="return confirm('Delete this sale record?');" style="color: #d32f2f; text-decoration: none;"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/nav.php'; ?>