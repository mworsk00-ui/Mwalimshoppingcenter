<?php
$page_title = 'Supplies';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

// Soft delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("UPDATE supplies SET deleted_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        flash('success', 'Supply record moved to Recycle Bin. You can restore it from there.');
    } catch (PDOException $e) {
        flash('error', 'Could not delete supply: ' . $e->getMessage());
    }
    header('Location: supplies.php');
    exit;
}

// Filters
$filter_status = $_GET['status'] ?? '';
$filter_cust   = (int)($_GET['customer'] ?? 0);

$sql = "SELECT s.* FROM supplies s WHERE s.deleted_at IS NULL";
$params = [];
if ($filter_status !== '') {
    $sql .= " AND s.payment_status = ?";
    $params[] = $filter_status;
}
if ($filter_cust > 0) {
    $sql .= " AND s.customer_id = ?";
    $params[] = $filter_cust;
}
$sql .= " ORDER BY s.supply_date DESC, s.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$supplies = $stmt->fetchAll();

// Customers list for filter
$customers = $pdo->query("SELECT id, customer_name FROM customers WHERE deleted_at IS NULL ORDER BY customer_name")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Supplies</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="recycle-bin.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-recycle"></i> BIN
        </a>
        <a href="supply-guide.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-circle-question"></i> GUIDE
        </a>
        <a href="supply-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<!-- Filters -->
<form method="get" class="leo-form-card" style="margin:0.85rem;padding:0.85rem;display:flex;flex-wrap:wrap;gap:0.6rem;align-items:end;">
    <div style="flex:1;min-width:140px;">
        <label class="leo-input-label" style="font-size:0.8rem;">Customer</label>
        <select name="customer" class="leo-input" style="width:100%;">
            <option value="0">All customers</option>
            <?php foreach ($customers as $c): ?>
                <option value="<?= (int)$c['id'] ?>" <?= $filter_cust === (int)$c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['customer_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div style="flex:1;min-width:120px;">
        <label class="leo-input-label" style="font-size:0.8rem;">Payment Status</label>
        <select name="status" class="leo-input" style="width:100%;">
            <option value="">All statuses</option>
            <option value="Paid"    <?= $filter_status === 'Paid'    ? 'selected' : '' ?>>Paid</option>
            <option value="Partial" <?= $filter_status === 'Partial' ? 'selected' : '' ?>>Partial</option>
            <option value="Unpaid"  <?= $filter_status === 'Unpaid'  ? 'selected' : '' ?>>Unpaid</option>
        </select>
    </div>
    <button type="submit" class="leo-btn leo-btn--primary" style="padding:0.65rem 1rem;">
        <i class="fas fa-filter"></i> Filter
    </button>
    <a href="supplies.php" class="leo-btn leo-btn--outline" style="padding:0.65rem 1rem;">Reset</a>
</form>

<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:var(--leo-blue-soft);">
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Date</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Customer</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Product</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Qty</th>
                <th style="text-align:right;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Total</th>
                <th style="text-align:center;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Status</th>
                <th style="text-align:right;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($supplies) > 0): ?>
                <?php foreach ($supplies as $sp):
                    $statusColor = [
                        'Paid'    => '#DCFCE7;color:#166534;border:1px solid #86EFAC',
                        'Partial' => '#FEF3C7;color:#92400E;border:1px solid #FDE68A',
                        'Unpaid'  => '#FEE2E2;color:#991B1B;border:1px solid #FCA5A5',
                    ][$sp['payment_status']] ?? '#E0F2FE;color:#0369A1;border:1px solid #BAE6FD';
                ?>
                    <tr style="border-top:1px solid #EEF2F7;">
                        <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:#475569;">
                            <?= htmlspecialchars(date('d M Y', strtotime($sp['supply_date']))) ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.9rem;font-weight:600;color:#1E293B;">
                            <?= htmlspecialchars($sp['customer_name']) ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.88rem;color:#334155;">
                            <?= htmlspecialchars($sp['product_name']) ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:#475569;">
                            <?= (float)$sp['quantity'] ?> <?= htmlspecialchars($sp['unit']) ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.88rem;font-weight:600;color:#1E293B;text-align:right;">
                            <?= number_format((float)$sp['total_amount'], 2) ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;text-align:center;">
                            <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:999px;font-size:0.68rem;font-weight:700;background:<?= $statusColor ?>;">
                                <?= htmlspecialchars($sp['payment_status']) ?>
                            </span>
                        </td>
                        <td style="padding:0.85rem 0.7rem;text-align:right;white-space:nowrap;">
                            <a href="supply-view.php?id=<?= (int)$sp['id'] ?>"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#E0F2FE;color:#0369A1;text-decoration:none;margin-right:0.25rem;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="supply-edit.php?id=<?= (int)$sp['id'] ?>"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:var(--leo-blue-soft);color:var(--leo-primary);text-decoration:none;margin-right:0.25rem;">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="supplies.php?delete=<?= (int)$sp['id'] ?>"
                               data-confirm="Move this supply to the Recycle Bin? You can restore it later."
                               data-confirm-ok="Yes, move to bin"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);font-size:0.9rem;">
                        <i class="fas fa-box-open" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                        No supply records yet. Click <strong>ADD</strong> to create one.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>