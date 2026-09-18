<?php
$page_title = 'Add New Product';
require_once __DIR__ . '/config/db.php';

// ==== AJAX: Save Category ====
if (isset($_POST['ajax_add_category'])) {
    header('Content-Type: application/json');
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
            $stmt->execute([$name]);
            echo json_encode(['ok' => true, 'name' => $name]);
        } catch (Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['ok' => false, 'error' => 'Jina linahitajika']);
    }
    exit;
}

// ==== AJAX: Save Brand ====
if (isset($_POST['ajax_add_brand'])) {
    header('Content-Type: application/json');
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO brands (brand_name) VALUES (?)");
            $stmt->execute([$name]);
            echo json_encode(['ok' => true, 'name' => $name]);
        } catch (Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['ok' => false, 'error' => 'Jina linahitajika']);
    }
    exit;
}

// ==== SAVE PRODUCT ====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    $name = trim($_POST['product_name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $brand = trim($_POST['brand'] ?? '');
    $barcode = trim($_POST['barcode'] ?? '');
    $stock_qty = intval($_POST['stock_qty'] ?? 0);
    $unit = trim($_POST['unit'] ?? '');
    $purchase_price = floatval($_POST['purchase_price'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $wholesale_price = floatval($_POST['wholesale_price'] ?? 0);
    $dealer_price = floatval($_POST['dealer_price'] ?? 0);
    $low_stock = intval($_POST['low_stock'] ?? 5);
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null;
    $notes = trim($_POST['notes'] ?? '');

    if ($name !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO products 
                (product_name, category, brand, barcode, stock_qty, unit, purchase_price, price, wholesale_price, dealer_price, low_stock, expiry_date, notes) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$name, $category, $brand, $barcode, $stock_qty, $unit, $purchase_price, $price, $wholesale_price, $dealer_price, $low_stock, $expiry_date, $notes]);
            header('Location: products.php'); exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

require_once __DIR__ . '/includes/header.php';

$categories = [];
$brands = [];
$units = ['Piece', 'Kg', 'Litre', 'Box', 'Packet', 'Bottle', 'Carton'];
try {
    $categories = $pdo->query("SELECT category_name FROM categories ORDER BY category_name ASC")->fetchAll();
    $brands = $pdo->query("SELECT brand_name FROM brands ORDER BY brand_name ASC")->fetchAll();
} catch (Exception $e) {}
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="products.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add New Product</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="productForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<?php if (!empty($error)): ?>
<div style="margin:0.85rem;padding:0.75rem;background:#FEF2F2;color:#DC2626;border-radius:10px;font-size:0.85rem;">
    <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<form method="post" id="productForm">

    <!-- Upload Image -->
    <div class="leo-form-card" style="margin:0.85rem;">
        <div class="leo-form-card-body" style="text-align:center;">
            <div style="font-size:0.9rem;font-weight:700;color:#1F2937;margin-bottom:0.75rem;">Upload Image</div>
            <label class="leo-upload-box">
                <i class="fas fa-shopping-cart"></i>
                <input type="file" accept="image/*" name="product_image">
            </label>
        </div>
    </div>

    <!-- Basic Info -->
    <div class="leo-form-card" style="margin:0.85rem;">
        <div class="leo-form-card-body">

            <div class="leo-form-row">
                <label class="leo-input-label">Name</label>
                <input type="text" name="product_name" class="leo-underline-input" placeholder="Please enter a product name" required>
            </div>

            <!-- CATEGORY na + BUTTON -->
            <div class="leo-form-row">
                <label class="leo-input-label">Category</label>
                <div class="leo-select-arrow">
                    <select name="category" id="categorySelect">
                        <option value="" disabled selected hidden>Select product category(optional)</option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?php echo htmlspecialchars($c['category_name']); ?>"><?php echo htmlspecialchars($c['category_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="arrow"><i class="fas fa-play"></i></span>
                    <button type="button" class="add-btn" onclick="openAddModal('category')" title="Add category">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <!-- BRAND na + BUTTON -->
            <div class="leo-form-row">
                <label class="leo-input-label">Brand</label>
                <div class="leo-select-arrow">
                    <select name="brand" id="brandSelect">
                        <option value="" disabled selected hidden>Select a brand(optional)</option>
                        <?php foreach ($brands as $b): ?>
                            <option value="<?php echo htmlspecialchars($b['brand_name']); ?>"><?php echo htmlspecialchars($b['brand_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="arrow"><i class="fas fa-play"></i></span>
                    <button type="button" class="add-btn" onclick="openAddModal('brand')" title="Add brand">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="leo-form-row">
                <label class="leo-input-label">Product Barcode</label>
                <div class="leo-input-with-icon">
                    <input type="text" name="barcode" class="leo-underline-input" placeholder="Enter product barcode(optional)">
                    <span class="icon"><i class="fas fa-barcode"></i></span>
                </div>
            </div>

        </div>
    </div>

    <!-- Product Details -->
    <div class="leo-form-card" style="margin:0.85rem;">
        <div class="leo-form-card-body">

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.85rem;">
                <div style="font-size:0.9rem;font-weight:700;color:#4A90E2;">Product Details</div>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <span style="font-size:0.8rem;font-weight:600;color:#1F2937;">Pack Sizes</span>
                    <span class="leo-toggle" onclick="this.classList.toggle('on')"></span>
                </div>
            </div>

            <div class="leo-form-row leo-form-row-inline">
                <div>
                    <label class="leo-input-label">Stock</label>
                    <input type="number" name="stock_qty" class="leo-underline-input" placeholder="Enter quantity">
                </div>
                <div>
                    <label class="leo-input-label">Product Unit</label>
                    <div class="leo-select-arrow">
                        <select name="unit">
                            <option value="" disabled selected hidden>Select product unit</option>
                            <?php foreach ($units as $u): ?>
                                <option value="<?php echo $u; ?>"><?php echo $u; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="arrow"><i class="fas fa-play"></i></span>
                    </div>
                </div>
            </div>

            <div class="leo-form-row leo-form-row-inline">
                <div>
                    <label class="leo-input-label">Purchasing Price</label>
                    <input type="number" name="purchase_price" step="0.01" class="leo-underline-input" placeholder="Enter purchasing price">
                </div>
                <div>
                    <label class="leo-input-label">Profit Type</label>
                    <div class="leo-select-arrow">
                        <select name="profit_type">
                            <option value="Flat" selected>Flat</option>
                            <option value="Percentage">Percentage</option>
                        </select>
                        <span class="arrow"><i class="fas fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>

            <div class="leo-form-row leo-form-row-inline">
                <div>
                    <label class="leo-input-label">Selling Price</label>
                    <input type="number" name="price" step="0.01" class="leo-underline-input" placeholder="Enter selling price" required>
                </div>
                <div>
                    <label class="leo-input-label">Profit Margin</label>
                    <input type="number" name="profit_margin" step="0.01" class="leo-underline-input" placeholder="Enter profit">
                </div>
            </div>

            <div class="leo-form-row leo-form-row-inline">
                <div>
                    <label class="leo-input-label">Wholesale Price</label>
                    <input type="number" name="wholesale_price" step="0.01" class="leo-underline-input" placeholder="Enter wholesale price">
                </div>
                <div>
                    <label class="leo-input-label">Dealer Price</label>
                    <input type="number" name="dealer_price" step="0.01" class="leo-underline-input" placeholder="Enter dealer price">
                </div>
            </div>

            <div class="leo-form-row leo-form-row-inline">
                <div>
                    <label class="leo-input-label">Low Stock</label>
                    <input type="number" name="low_stock" class="leo-underline-input" placeholder="Enter low stock" value="5">
                </div>
                <div>
                    <label class="leo-input-label">Expiry Date</label>
                    <div class="leo-input-with-icon">
                        <input type="date" name="expiry_date" class="leo-underline-input" placeholder="Select date">
                        <span class="icon"><i class="far fa-calendar-alt"></i></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- More Details -->
    <div class="leo-form-card" style="margin:0.85rem 0.85rem 6rem;">
        <div class="leo-form-card-body">
            <label class="leo-input-label">More Details</label>
            <textarea name="notes" class="leo-underline-input" rows="3" placeholder="Add more details here"></textarea>
        </div>
    </div>

</form>

<div class="leo-bottom-actions">
    <a href="products.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="productForm" class="leo-btn leo-btn--primary">SAVE</button>
</div>

<!-- MODAL: ADD CATEGORY / BRAND -->
<div class="leo-modal-backdrop" id="addModal">
    <div class="leo-modal">
        <div class="leo-modal-title" id="modalTitle">Add Category</div>
        <div class="leo-form-row">
            <label class="leo-input-label" id="modalLabel">Category Name</label>
            <input type="text" id="modalInput" class="leo-underline-input" placeholder="Enter name" autocomplete="off">
        </div>
        <p id="modalError" style="color:#DC2626;font-size:0.82rem;margin-top:0.5rem;display:none;"></p>
        <div class="leo-modal-actions">
            <button type="button" class="leo-btn leo-btn--outline" onclick="closeAddModal()">CANCEL</button>
            <button type="button" class="leo-btn leo-btn--primary" id="modalSaveBtn" onclick="saveItem()">SAVE</button>
        </div>
    </div>
</div>

<script>
var currentType = 'category';

function openAddModal(type) {
    currentType = type;
    var title = document.getElementById('modalTitle');
    var label = document.getElementById('modalLabel');
    var input = document.getElementById('modalInput');
    var err = document.getElementById('modalError');

    if (type === 'category') {
        title.textContent = 'Add Category';
        label.textContent = 'Category Name';
        input.placeholder = 'Enter category name';
    } else {
        title.textContent = 'Add Brand';
        label.textContent = 'Brand Name';
        input.placeholder = 'Enter brand name';
    }
    input.value = '';
    err.style.display = 'none';
    document.getElementById('addModal').classList.add('show');
    setTimeout(function(){ input.focus(); }, 100);
}

function closeAddModal() {
    document.getElementById('addModal').classList.remove('show');
}

function saveItem() {
    var input = document.getElementById('modalInput');
    var err = document.getElementById('modalError');
    var btn = document.getElementById('modalSaveBtn');
    var name = input.value.trim();

    if (!name) {
        err.textContent = 'Tafadhali andika jina.';
        err.style.display = 'block';
        return;
    }

    err.style.display = 'none';
    btn.disabled = true;
    btn.textContent = 'Inahifadhi...';

    var fd = new FormData();
    fd.append(currentType === 'category' ? 'ajax_add_category' : 'ajax_add_brand', '1');
    fd.append('name', name);

    fetch('product-add.php', { method: 'POST', body: fd })
        .then(function(r){ return r.json(); })
        .then(function(data){
            btn.disabled = false;
            btn.textContent = 'SAVE';

            if (data.ok) {
                // Ongeza option kwenye select
                var selectId = currentType === 'category' ? 'categorySelect' : 'brandSelect';
                var select = document.getElementById(selectId);
                var opt = document.createElement('option');
                opt.value = data.name;
                opt.textContent = data.name;
                opt.selected = true;
                select.appendChild(opt);

                closeAddModal();
            } else {
                err.textContent = data.error || 'Kuna tatizo.';
                err.style.display = 'block';
            }
        })
        .catch(function(){
            btn.disabled = false;
            btn.textContent = 'SAVE';
            err.textContent = 'Network error. Jaribu tena.';
            err.style.display = 'block';
        });
}

// Enter key = Save
document.getElementById('modalInput').addEventListener('keypress', function(e){
    if (e.key === 'Enter') { e.preventDefault(); saveItem(); }
});

// Bonyeza nje ya modal = close
document.getElementById('addModal').addEventListener('click', function(e){
    if (e.target === this) closeAddModal();
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
