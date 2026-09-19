<?php
$page_title = 'Employees';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

// Soft delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("UPDATE employees SET deleted_at = NOW() WHERE id = ?");
        $stmt->execute([$id]);
        flash('success', 'Employee moved to Recycle Bin. You can restore it from there.');
    } catch (PDOException $e) {
        flash('error', 'Could not delete employee: ' . $e->getMessage());
    }
    header('Location: employees.php');
    exit;
}

// Toggle Active/Inactive
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    try {
        // Fetch current
        $st = $pdo->prepare("SELECT employee_name, status FROM employees WHERE id = ? AND deleted_at IS NULL");
        $st->execute([$id]);
        $row = $st->fetch();
        if ($row) {
            $newStatus = ($row['status'] === 'Active') ? 'Inactive' : 'Active';
            $up = $pdo->prepare("UPDATE employees SET status = ? WHERE id = ?");
            $up->execute([$newStatus, $id]);
            flash('success', "'{$row['employee_name']}' is now {$newStatus}.");
        } else {
            flash('warning', 'Employee not found.');
        }
    } catch (PDOException $e) {
        flash('error', 'Could not update status: ' . $e->getMessage());
    }
    header('Location: employees.php');
    exit;
}

// Filters
$filter_status = $_GET['status'] ?? '';
$filter_pay    = $_GET['pay']    ?? '';

$sql = "SELECT * FROM employees WHERE deleted_at IS NULL";
$params = [];
if ($filter_status !== '') { $sql .= " AND status = ?";   $params[] = $filter_status; }
if ($filter_pay    !== '') { $sql .= " AND pay_type = ?"; $params[] = $filter_pay; }
$sql .= " ORDER BY employee_name ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employees = $stmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="index.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Employees</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="recycle-bin.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-recycle"></i> BIN
        </a>
        <a href="employee-guide.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;">
            <i class="fas fa-circle-question"></i> GUIDE
        </a>
        <a href="employee-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<!-- Filters -->
<form method="get" class="leo-form-card" style="margin:0.85rem;padding:0.85rem;display:flex;flex-wrap:wrap;gap:0.6rem;align-items:end;">
    <div style="flex:1;min-width:130px;">
        <label class="leo-input-label" style="font-size:0.8rem;">Status</label>
        <select name="status" class="leo-input" style="width:100%;">
            <option value="">All</option>
            <option value="Active"   <?= $filter_status === 'Active'   ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= $filter_status === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <div style="flex:1;min-width:130px;">
        <label class="leo-input-label" style="font-size:0.8rem;">Pay Type</label>
        <select name="pay" class="leo-input" style="width:100%;">
            <option value="">All</option>
            <option value="Daily"   <?= $filter_pay === 'Daily'   ? 'selected' : '' ?>>Daily</option>
            <option value="Weekly"  <?= $filter_pay === 'Weekly'  ? 'selected' : '' ?>>Weekly</option>
            <option value="Monthly" <?= $filter_pay === 'Monthly' ? 'selected' : '' ?>>Monthly</option>
        </select>
    </div>
    <button type="submit" class="leo-btn leo-btn--primary" style="padding:0.65rem 1rem;">
        <i class="fas fa-filter"></i> Filter
    </button>
</form>

<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:var(--leo-blue-soft);">
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Name</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Role</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Shop</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Pay</th>
                <th style="text-align:center;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Status</th>
                <th style="text-align:right;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($employees) > 0): ?>
                <?php foreach ($employees as $e):
                    $isActive = $e['status'] === 'Active';
                    $stColor = $isActive
                        ? '#DCFCE7;color:#166534;border:1px solid #86EFAC'
                        : '#F1F5F9;color:#475569;border:1px solid #CBD5E1';
                    $toggleColor = $isActive
                        ? 'background:#FEF3C7;color:#92400E;'
                        : 'background:#DCFCE7;color:#166534;';
                    $toggleIcon  = $isActive ? 'fa-user-slash' : 'fa-user-check';
                    $toggleTitle = $isActive ? 'Mark Inactive' : 'Reactivate';
                    $confirmMsg  = $isActive
                        ? "Mark '{$e['employee_name']}' as Inactive?"
                        : "Reactivate '{$e['employee_name']}'?";
                ?>
                    <tr style="border-top:1px solid #EEF2F7; <?= $isActive ? '' : 'opacity:0.65;' ?>">
                        <td style="padding:0.85rem 0.7rem;">
                            <div style="font-size:0.92rem;font-weight:600;color:#1E293B;">
                                <?= htmlspecialchars($e['employee_name']) ?>
                            </div>
                            <?php if (!empty($e['phone'])): ?>
                                <div style="font-size:0.78rem;color:#64748B;">
                                    <i class="fas fa-phone" style="font-size:0.7rem;"></i>
                                    <?= htmlspecialchars($e['phone']) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:#475569;">
                            <?= htmlspecialchars($e['role'] ?? '—') ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:#475569;">
                            <?= htmlspecialchars($e['shop_name'] ?? '—') ?>
                        </td>
                        <td style="padding:0.85rem 0.7rem;">
                            <div style="font-size:0.82rem;font-weight:600;color:#1E293B;">
                                <?= number_format((float)$e['salary'], 2) ?>
                            </div>
                            <div style="font-size:0.72rem;color:#64748B;text-transform:uppercase;letter-spacing:0.04em;">
                                <?= htmlspecialchars($e['pay_type']) ?>
                            </div>
                        </td>
                        <td style="padding:0.85rem 0.7rem;text-align:center;">
                            <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:999px;font-size:0.68rem;font-weight:700;background:<?= $stColor ?>;">
                                <?= htmlspecialchars($e['status']) ?>
                            </span>
                        </td>
                        <td style="padding:0.85rem 0.7rem;text-align:right;white-space:nowrap;">
                            <a href="employee-view.php?id=<?= (int)$e['id'] ?>"
                               title="View"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#E0F2FE;color:#0369A1;text-decoration:none;margin-right:0.25rem;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="employee-edit.php?id=<?= (int)$e['id'] ?>"
                               title="Edit"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:var(--leo-blue-soft);color:var(--leo-primary);text-decoration:none;margin-right:0.25rem;">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="employees.php?toggle=<?= (int)$e['id'] ?>"
                               title="<?= $toggleTitle ?>"
                               data-confirm="<?= htmlspecialchars($confirmMsg, ENT_QUOTES) ?>"
                               data-confirm-ok="Yes, continue"
                               data-confirm-cancel="Cancel"
                               style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;<?= $toggleColor ?>text-decoration:none;margin-right:0.25rem;">
                                <i class="fas <?= $toggleIcon ?>"></i>
                            </a>
                            <a href="employees.php?delete=<?= (int)$e['id'] ?>"
                               title="Delete"
                               data-confirm="Move '<?= htmlspecialchars($e['employee_name'], ENT_QUOTES) ?>' to the Recycle Bin? You can restore later."
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
                    <td colspan="6" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);font-size:0.9rem;">
                        <i class="fas fa-user-tie" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                        No employees yet. Click <strong>ADD</strong> to create one.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>