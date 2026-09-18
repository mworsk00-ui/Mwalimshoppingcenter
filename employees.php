<?php
$page_title = 'Employees';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $pdo->prepare("UPDATE employees SET deleted_at = NOW() WHERE id = ?")->execute([$id]);
        flash('success', 'Employee moved to Recycle Bin.');
    } catch (PDOException $e) { flash('error', 'Could not delete: ' . $e->getMessage()); }
    header('Location: employees.php'); exit;
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    try {
        $st = $pdo->prepare("SELECT employee_name, status FROM employees WHERE id = ? AND deleted_at IS NULL");
        $st->execute([$id]);
        $row = $st->fetch();
        if ($row) {
            $new = ($row['status'] === 'Active') ? 'Inactive' : 'Active';
            $pdo->prepare("UPDATE employees SET status = ? WHERE id = ?")->execute([$new, $id]);
            flash('success', "'{$row['employee_name']}' is now {$new}.");
        }
    } catch (PDOException $e) { flash('error', 'Could not update: ' . $e->getMessage()); }
    header('Location: employees.php'); exit;
}

$employees = $pdo->query("SELECT * FROM employees WHERE deleted_at IS NULL ORDER BY employee_name ASC")->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="menu.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Employees</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="employee-guide.php" class="leo-save-btn" style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;background:#FEF3C7;color:#92400E;margin-right:0.4rem;"><i class="fas fa-circle-question"></i></a>
        <a href="employee-add.php" class="leo-save-btn" style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;"><i class="fas fa-plus"></i> ADD</a>
    </div>
</header>

<div class="leo-form-card" style="margin:0.85rem;padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:var(--leo-blue-soft);">
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Name</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Role</th>
                <th style="text-align:left;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Pay</th>
                <th style="text-align:center;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Status</th>
                <th style="text-align:right;padding:0.9rem 0.7rem;font-size:0.75rem;text-transform:uppercase;color:var(--leo-primary);">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($employees) > 0): foreach ($employees as $e):
                $isActive = ($e['status'] ?? 'Active') === 'Active';
                $stColor = $isActive ? '#DCFCE7;color:#166534;border:1px solid #86EFAC' : '#F1F5F9;color:#475569;border:1px solid #CBD5E1';
                $toggleColor = $isActive ? 'background:#FEF3C7;color:#92400E;' : 'background:#DCFCE7;color:#166534;';
            ?>
                <tr style="border-top:1px solid #EEF2F7; <?= $isActive ? '' : 'opacity:0.65;' ?>">
                    <td style="padding:0.85rem 0.7rem;">
                        <div style="font-size:0.92rem;font-weight:600;color:#1E293B;"><?= htmlspecialchars($e['employee_name']) ?></div>
                        <?php if (!empty($e['phone'])): ?>
                            <div style="font-size:0.78rem;color:#64748B;"><i class="fas fa-phone" style="font-size:0.7rem;"></i> <?= htmlspecialchars($e['phone']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="padding:0.85rem 0.7rem;font-size:0.85rem;color:#475569;"><?= htmlspecialchars($e['role'] ?? '—') ?></td>
                    <td style="padding:0.85rem 0.7rem;">
                        <div style="font-size:0.82rem;font-weight:600;color:#1E293B;"><?= number_format((float)($e['salary'] ?? 0), 2) ?></div>
                        <div style="font-size:0.72rem;color:#64748B;text-transform:uppercase;"><?= htmlspecialchars($e['pay_type'] ?? '') ?></div>
                    </td>
                    <td style="padding:0.85rem 0.7rem;text-align:center;">
                        <span style="display:inline-block;padding:0.2rem 0.6rem;border-radius:999px;font-size:0.68rem;font-weight:700;background:<?= $stColor ?>;">
                            <?= htmlspecialchars($e['status'] ?? 'Active') ?>
                        </span>
                    </td>
                    <td style="padding:0.85rem 0.7rem;text-align:right;white-space:nowrap;">
                        <a href="employee-view.php?id=<?= (int)$e['id'] ?>" style="display:inline-flex;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#E0F2FE;color:#0369A1;text-decoration:none;margin-right:0.25rem;"><i class="fas fa-eye"></i></a>
                        <a href="employee-edit.php?id=<?= (int)$e['id'] ?>" style="display:inline-flex;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:var(--leo-blue-soft);color:var(--leo-primary);text-decoration:none;margin-right:0.25rem;"><i class="fas fa-pen"></i></a>
                        <a href="employees.php?toggle=<?= (int)$e['id'] ?>" data-confirm="Change status?" style="display:inline-flex;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;<?= $toggleColor ?>text-decoration:none;margin-right:0.25rem;"><i class="fas <?= $isActive ? 'fa-user-slash' : 'fa-user-check' ?>"></i></a>
                        <a href="employees.php?delete=<?= (int)$e['id'] ?>" data-confirm="Move '<?= htmlspecialchars($e['employee_name'], ENT_QUOTES) ?>' to Bin?" style="display:inline-flex;padding:0.4rem 0.6rem;border-radius:8px;font-size:0.75rem;font-weight:600;background:#FEE2E2;color:#991B1B;text-decoration:none;"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="5" style="text-align:center;padding:2.5rem 1rem;color:var(--leo-muted);">
                    <i class="fas fa-user-tie" style="font-size:1.8rem;display:block;margin-bottom:0.6rem;opacity:0.5;"></i>
                    No employees yet. Click <strong>ADD</strong>.
                </td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
