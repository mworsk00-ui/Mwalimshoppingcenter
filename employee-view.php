<?php
$page_title = 'View Employee';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$e = $stmt->fetch();

if (!$e) {
    flash('warning', 'Employee not found.');
    header('Location: employees.php');
    exit;
}
require_once __DIR__ . '/includes/header.php';

$day_names = ['Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday','Sat'=>'Saturday','Sun'=>'Sunday'];
$days = array_filter(explode(',', $e['work_days'] ?? ''));
$days_text = $days ? implode(', ', array_map(fn($d) => $day_names[$d] ?? $d, $days)) : '—';
$stColor = $e['status'] === 'Active'
    ? '#DCFCE7;color:#166534;border:1px solid #86EFAC'
    : '#F1F5F9;color:#475569;border:1px solid #CBD5E1';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="employees.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Employee Details</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="employee-edit.php?id=<?= (int)$e['id'] ?>" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-pen"></i> EDIT
        </a>
    </div>
</header>

<div class="leo-form-card" style="margin:0.85rem;padding:0;">
    <div class="leo-form-card-body">

        <div style="text-align:center;margin:0.5rem 0 1.5rem;">
            <div style="width:110px;height:110px;border-radius:50%;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:3rem;">
                <i class="fas fa-user-tie"></i>
            </div>
            <h2 style="margin-top:0.75rem;font-size:1.25rem;color:#0F172A;"><?= htmlspecialchars($e['employee_name']) ?></h2>
            <?php if (!empty($e['role'])): ?>
                <p style="color:var(--leo-muted);font-size:0.9rem;"><?= htmlspecialchars($e['role']) ?></p>
            <?php endif; ?>
            <span style="display:inline-block;margin-top:0.4rem;padding:0.25rem 0.8rem;border-radius:999px;font-size:0.72rem;font-weight:700;background:<?= $stColor ?>;">
                <?= htmlspecialchars($e['status']) ?>
            </span>
        </div>

        <!-- Quick status toggle -->
        <div style="text-align:center;margin-bottom:1.25rem;">
            <?php if ($e['status'] === 'Active'): ?>
                <a href="employees.php?toggle=<?= (int)$e['id'] ?>"
                   data-confirm="Mark '<?= htmlspecialchars($e['employee_name'], ENT_QUOTES) ?>' as Inactive? They will be greyed out but not deleted."
                   data-confirm-ok="Yes, mark inactive"
                   data-confirm-cancel="Cancel"
                   style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1rem;border-radius:10px;font-size:0.85rem;font-weight:600;background:#FEF3C7;color:#92400E;text-decoration:none;border:1px solid #FDE68A;">
                    <i class="fas fa-user-slash"></i> Mark as Inactive
                </a>
            <?php else: ?>
                <a href="employees.php?toggle=<?= (int)$e['id'] ?>"
                   data-confirm="Reactivate '<?= htmlspecialchars($e['employee_name'], ENT_QUOTES) ?>'?"
                   data-confirm-ok="Yes, reactivate"
                   data-confirm-cancel="Cancel"
                   style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1rem;border-radius:10px;font-size:0.85rem;font-weight:600;background:#DCFCE7;color:#166534;text-decoration:none;border:1px solid #86EFAC;">
                    <i class="fas fa-user-check"></i> Reactivate Employee
                </a>
            <?php endif; ?>
        </div>

        <?php
        $rows = [
            'Phone'         => $e['phone']       ?? '—',
            'Email'         => $e['email']       ?? '—',
            'Address'       => $e['address']     ?? '—',
            'Shop'          => $e['shop_name']   ?? '—',
            'Start Date'    => $e['start_date']  ? date('d M Y', strtotime($e['start_date'])) : '—',
            'Pay Type'      => $e['pay_type'],
            'Salary'        => number_format((float)$e['salary'], 2),
            'Payment Mode'  => $e['payment_mode'] ?? '—',
            'Working Days'  => $days_text,
            'Work Hours'    => ($e['work_start'] && $e['work_end'])
                                ? substr($e['work_start'],0,5) . ' – ' . substr($e['work_end'],0,5)
                                : '—',
            'Notes'         => $e['notes'] ?? '—',
        ];
        foreach ($rows as $label => $value):
        ?>
        <div class="leo-form-row" style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 0;border-bottom:1px solid #EEF2F7;">
            <span style="font-size:0.85rem;color:var(--leo-muted);font-weight:600;"><?= $label ?></span>
            <span style="font-size:0.92rem;color:#1E293B;font-weight:500;text-align:right;max-width:60%;word-break:break-word;">
                <?= htmlspecialchars($value) ?>
            </span>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<div class="leo-bottom-actions">
    <a href="employees.php?delete=<?= (int)$e['id'] ?>"
       data-confirm="Move '<?= htmlspecialchars($e['employee_name'], ENT_QUOTES) ?>' to the Recycle Bin?"
       data-confirm-ok="Yes, move to bin"
       data-confirm-cancel="Cancel"
       class="leo-btn leo-btn--outline"
       style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
        <i class="fas fa-trash"></i> DELETE
    </a>
    <a href="employees.php" class="leo-btn leo-btn--outline">BACK</a>
    <a href="employee-edit.php?id=<?= (int)$e['id'] ?>" class="leo-btn leo-btn--primary">EDIT</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>