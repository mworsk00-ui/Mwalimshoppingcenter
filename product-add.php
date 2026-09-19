<?php
$page_title = 'Add Product';
require_once __DIR__ . '/config/db.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['product_name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $qty = intval($_POST['stock_qty'] ?? 0);
    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (product_name, price, stock_qty) VALUES (?,?,?)");
            $stmt->execute([$name, $price, $qty]);
            header('Location: products.php');
            exit;
        } catch (Exception $e) { $msg = $e->getMessage(); }
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="products.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Product</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="productForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<form method="post" id="productForm" class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <?php if ($msg): ?><div style="color:#DC2626;font-size:0.82rem;margin-bottom:0.75rem;"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

        <div class="leo-form-row">
            <label class="leo-input-label">Product Name</label>
            <input type="text" name="product_name" class="leo-input" placeholder="Enter product name" required>
        </div>

        <div class="leo-form-row leo-form-row-inline">
            <div>
                <label class="leo-input-label">Price (TSH)</label>
                <input type="number" name="price" class="leo-input" placeholder="0" step="0.01" required>
            </div>
            <div>
                <label class="leo-input-label">Stock Quantity</label>
                <input type="number" name="stock_qty" class="leo-input" placeholder="0" required>
            </div>
        </div>

        <div class="leo-form-row">
            <label class="leo-input-label">Category (optional)</label>
            <select class="leo-input">
                <option>Select category</option>
                <option>Electronics</option>
                <option>Food</option>
                <option>Clothing</option>
            </select>
        </div>
    </div>
</form>

<div class="leo-bottom-actions">
    <a href="products.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="productForm" class="leo-btn leo-btn--primary">SAVE</button>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
