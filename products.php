<?php
// products.php
require_once 'includes/header.php';

$message = '';

// Handle Delete Action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        $message = '<div style="color: red; font-weight: 600; margin-bottom: 10px;">Product deleted successfully!</div>';
    }
}

// Handle Add or Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $price = floatval($_POST['price']);
    $stock_qty = intval($_POST['stock_qty']);
    $edit_id = !empty($_POST['edit_id']) ? intval($_POST['edit_id']) : null;

    if (!empty($product_name) && $price >= 0) {
        if ($edit_id) {
            // Update Existing Product
            $stmt = $pdo->prepare("UPDATE products SET product_name = ?, price = ?, stock_qty = ? WHERE id = ?");
            $stmt->execute([$product_name, $price, $stock_qty, $edit_id]);
            $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Product updated successfully!</div>';
        } else {
            // Insert New Product
            $stmt = $pdo->prepare("INSERT INTO products (product_name, price, stock_qty) VALUES (?, ?, ?)");
            $stmt->execute([$product_name, $price, $stock_qty]);
            $message = '<div style="color: var(--primary-green); font-weight: 600; margin-bottom: 10px;">Product saved successfully!</div>';
        }
    }
}

// Check if Editing a Record
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_product = $stmt->fetch();
}

// Fetch All Products
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<!-- Add / Edit Product Form Card -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--primary-green); margin-bottom: 12px;">
        <i class="fa-solid <?php echo $edit_product ? 'fa-pen-to-square' : 'fa-plus-circle'; ?>"></i> 
        <?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?>
    </h3>
    <?php echo $message; ?>
    <form action="products.php" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
        <input type="hidden" name="edit_id" value="<?php echo $edit_product['id'] ?? ''; ?>">
        
        <input type="text" name="product_name" placeholder="Product Name" value="<?php echo htmlspecialchars($edit_product['product_name'] ?? ''); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        
        <div style="display: flex; gap: 10px;">
            <input type="number" step="0.01" name="price" placeholder="Base Cost (TSH)" value="<?php echo $edit_product['price'] ?? ''; ?>" required style="width: 50%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
            <input type="number" name="stock_qty" placeholder="Quantity" value="<?php echo $edit_product['stock_qty'] ?? '1'; ?>" required style="width: 50%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        </div>
        
        <button type="submit" style="background: var(--primary-green); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer;">
            <?php echo $edit_product ? 'Update Product' : 'Save Product'; ?>
        </button>
        <?php if ($edit_product): ?>
            <a href="products.php" style="text-align: center; color: #888; font-size: 12px; text-decoration: none;">Cancel Edit</a>
        <?php endif; ?>
    </form>
</div>

<!-- Products Inventory List -->
<div class="card">
    <h3 style="font-size: 15px; color: var(--dark-forest); margin-bottom: 12px;"><i class="fa-solid fa-boxes-stacked"></i> Product Inventory</h3>
    <?php if (empty($products)): ?>
        <p style="color: var(--text-muted); font-size: 13px;">No products added yet.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <?php foreach ($products as $item): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: var(--bg-light); border-radius: 6px; border-left: 3px solid var(--primary-green);">
                    <div>
                        <strong style="font-size: 14px; display: block; color: var(--text-main);"><?php echo htmlspecialchars($item['product_name']); ?></strong>
                        <span style="font-size: 12px; color: var(--text-muted);">Stock: <?php echo $item['stock_qty']; ?> units | TSH <?php echo number_format($item['price'], 0); ?></span>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <a href="products.php?edit=<?php echo $item['id']; ?>" style="color: #0288d1; text-decoration: none;"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="products.php?delete=<?php echo $item['id']; ?>" onclick="return confirm('Delete this product?');" style="color: #d32f2f; text-decoration: none;"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/nav.php'; ?>