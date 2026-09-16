<?php
$page_title = 'Add Sales';
require_once __DIR__ . '/config/db.php';
$next_invoice = 'S-00001';
try {
    $last = $pdo->query("SELECT id FROM sales ORDER BY id DESC LIMIT 1")->fetchColumn();
    if ($last) $next_invoice = 'S-' . str_pad($last + 1, 5, '0', STR_PAD_LEFT);
} catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="sales.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Sales</span>
    </div>
    <div class="leo-page-header-actions">
        <button class="leo-save-btn">SAVE</button>
    </div>
</header>

<div style="padding:0.85rem;">

    <!-- Invoice + Date -->
    <div class="leo-form-card" style="margin-bottom:0.75rem;">
        <div class="leo-form-card-body">
            <div class="leo-form-row leo-form-row-inline">
                <div>
                    <label class="leo-input-label">Invoice Number</label>
                    <div style="font-size:0.92rem;color:var(--leo-ink);font-weight:600;"><?php echo $next_invoice; ?></div>
                </div>
                <div>
                    <label class="leo-input-label">Date</label>
                    <div style="display:flex;align-items:center;gap:0.35rem;">
                        <span style="font-size:0.92rem;color:var(--leo-ink);font-weight:600;"><?php echo date('Y-m-d'); ?></span>
                        <i class="far fa-calendar-alt" style="color:var(--leo-primary);"></i>
                    </div>
                </div>
            </div>
            <div class="leo-form-row">
                <label class="leo-input-label">Customer Name</label>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:0.92rem;color:var(--leo-ink);font-weight:600;">Walk-in Customer</span>
                    <a href="customer-add.php" style="font-size:0.82rem;color:var(--leo-primary);font-weight:600;">Change Customer</a>
                </div>
            </div>
            <div class="leo-form-row">
                <label class="leo-input-label">Customer Phone Number</label>
                <input type="tel" class="leo-input" placeholder="Enter customer phone number">
            </div>
        </div>
    </div>

    <button class="leo-btn leo-btn--outline-soft leo-btn--block" style="margin-bottom:0.75rem;">
        <i class="fas fa-plus"></i> Add Products
    </button>

    <div class="leo-form-card" style="margin-bottom:0.75rem;">
        <div class="leo-form-card-body">
            <div class="leo-page-search-bar">
                <i class="fas fa-search" style="color:var(--leo-primary);"></i>
                <input type="text" placeholder="Scan Product Barcode" style="color:var(--leo-primary);font-weight:600;">
                <span class="leo-scan"><i class="fas fa-barcode"></i></span>
            </div>
        </div>
    </div>

    <!-- Cash / Credit tabs -->
    <div class="leo-tabs" style="margin-bottom:0.75rem;">
        <button class="leo-tab active"><i class="fas fa-money-bill"></i> Cash Sale</button>
        <button class="leo-tab"><i class="fas fa-credit-card"></i> Credit Sale</button>
    </div>

    <!-- Summary -->
    <div class="leo-summary-table" style="margin-bottom:0.75rem;">
        <div class="leo-summary-row">
            <span class="leo-summary-row-label">Subtotal</span>
            <span class="leo-summary-row-value">0</span>
        </div>
        <div class="leo-summary-row">
            <span class="leo-summary-row-label">Discount</span>
            <div style="display:flex;gap:0.5rem;align-items:center;">
                <select class="leo-input" style="padding:0.35rem 0.5rem;font-size:0.8rem;width:auto;"><option>Flat</option><option>%</option></select>
                <span class="leo-summary-row-value">0</span>
            </div>
        </div>
        <div class="leo-summary-row">
            <span class="leo-summary-row-label">Tax</span>
            <div style="display:flex;gap:0.5rem;align-items:center;">
                <select class="leo-input" style="padding:0.35rem 0.5rem;font-size:0.8rem;width:auto;"><option>Select One</option></select>
                <span class="leo-summary-row-value">0</span>
            </div>
        </div>
        <div class="leo-summary-row">
            <span class="leo-summary-row-label">Shipping Cost</span>
            <span class="leo-summary-row-value">0</span>
        </div>
        <div class="leo-summary-row leo-summary-row--grand">
            <span class="leo-summary-row-label">Grand Total</span>
            <span class="leo-summary-row-value">0</span>
        </div>
        <div class="leo-summary-row">
            <span class="leo-summary-row-label">Amount Received</span>
            <span class="leo-summary-row-value">0</span>
        </div>
        <div class="leo-summary-row">
            <span class="leo-summary-row-label">Amount Due</span>
            <span class="leo-summary-row-value">0</span>
        </div>
    </div>

    <!-- Payment -->
    <div class="leo-form-card" style="margin-bottom:0.75rem;">
        <div class="leo-form-card-body">
            <div class="leo-summary-row">
                <span class="leo-summary-row-label"><i class="fas fa-money-bill-wave" style="color:var(--leo-primary);"></i> Mode of Payment</span>
                <div style="display:flex;gap:0.5rem;align-items:center;">
                    <span style="font-weight:600;">Cash Pay</span>
                    <i class="fas fa-chevron-down" style="color:var(--leo-primary);"></i>
                </div>
            </div>
            <div class="leo-summary-row">
                <span class="leo-summary-row-label">Select Multiple Payment Methods</span>
                <i class="fas fa-chevron-right" style="color:var(--leo-primary);"></i>
            </div>

            <div class="leo-toggle-row">
                <span class="leo-toggle-label">Payment by Installments</span>
                <span class="leo-toggle"></span>
            </div>
            <div class="leo-toggle-row">
                <span class="leo-toggle-label">Delivery note required</span>
                <span class="leo-toggle"></span>
            </div>
            <div class="leo-toggle-row">
                <span class="leo-toggle-label">Products not taken yet</span>
                <span class="leo-toggle"></span>
            </div>
        </div>
    </div>

    <!-- Note -->
    <div class="leo-form-card" style="margin-bottom:5rem;">
        <div class="leo-form-card-body">
            <label class="leo-input-label">Note</label>
            <div style="display:flex;gap:0.5rem;align-items:flex-end;">
                <input type="text" class="leo-input" placeholder="Enter your opinion" style="flex:1;">
                <button class="leo-btn leo-btn--outline-soft" style="padding:0.5rem;flex-direction:column;gap:0.15rem;font-size:0.7rem;flex:0 0 auto;">
                    <i class="fas fa-camera"></i> Image
                </button>
            </div>
        </div>
    </div>
</div>

<div class="leo-bottom-actions">
    <a href="sales.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button class="leo-btn leo-btn--primary">SAVE</button>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
