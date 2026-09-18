<?php
$page_title = 'View Employee';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$e = $stmt->fetch();
if (!$e) { flash('warning', 'Employee not found.'); header('Location: employees.php'); exit; }
require_once __DIR__ . '/includes/header.php';
$day_names = ['Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday','Sat'=>'Saturday','Sun'=>'Sunday'];
$days = array_filter(explode(',', $e['work_days'] ?? ''));
$days_text = $days ? implode(', ', array_map(fn($d) => $day_names[$d] ?? $d, $days)) : '—';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="employees.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Employee Details</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="employee-edit.php?id=<?= (int)$e['id'] ?>" class="leo-save-btn" style="text-decoration:none;"><i class="fas fa-pen"></i> EDIT</a>
    </div>
</header>
<div class="leo-form-card" style="margin:0.85rem;">
    <div class="leo-form-card-body">
        <div style="text-align:center;margin:0.5rem 0 1.5rem;">
            <div style="width:110px;height:110px;border-radius:50%;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:3rem;"><i class="fas fa-user-tie"></i></div>
            <h2 style="margin-top:0.75rem;color:#0F172A;"><?= htmlspecialchars($e['employee_name']) ?></h2>
            <?php if (!empty($e['role'])): ?><p style="color:var(--leo-muted);"><?= htmlspecialchars($e['role']) ?></p><?php endif; ?>
        </div>
        <?php
        $rows = [
            'Phone' => $e['phone'] ?? '—',
            'Email' => $e['email'] ?? '—',
            'Address' => $e['address'] ?? '—',
            'Shop' => $e['shop_name'] ?? '—',
            'Start Date' => $e['start_date'] ? date('d M Y', strtotime($e['start_date'])) : '—',
            'Pay Type' => $e['pay_type'],
            'Salary' => number_format((float)$e['salary'], 2),
            'Payment Mode' => $e['payment_mode'] ?? '—',
            'Working Days' => $days_text,
            'Work Hours' => ($e['work_start'] && $e['work_end']) ? substr($e['work_start'],0,5).' – '.substr($e['work_end'],0,5) : '—',
            'Status' => $e['status'],
        ];
        foreach ($rows as $label => $value): ?>
            <div style="display:flex;justify-content:space-between;padding:0.75rem 0;border-bottom:1px solid #EEF2F7;">
                <span style="font-size:0.85rem;color:var(--leo-muted);font-weight:600;"><?= $label ?></span>
                <span style="font-size:0.92rem;color:#1E293B;text-align:right;"><?= htmlspecialchars($value) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="leo-bottom-actions">
    <a href="employees.php" class="leo-btn leo-btn--outline">BACK</a>
    <a href="employee-edit.php?id=<?= (int)$e['id'] ?>" class="leo-btn leo-btn--primary">EDIT</a>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
