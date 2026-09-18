<?php
$page_title = 'Edit Employee';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$e = $stmt->fetch();
if (!$e) { flash('warning', 'Employee not found.'); header('Location: employees.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['employee_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $shop_name = trim($_POST['shop_name'] ?? '');
    $start_date = $_POST['start_date'] ?: null;
    $pay_type = trim($_POST['pay_type'] ?? 'Monthly');
    $salary = (float)($_POST['salary'] ?? 0);
    $payment_mode = trim($_POST['payment_mode'] ?? '');
    $work_days = isset($_POST['work_days']) ? implode(',', $_POST['work_days']) : '';
    $work_start = $_POST['work_start'] ?: null;
    $work_end = $_POST['work_end'] ?: null;
    $status = trim($_POST['status'] ?? 'Active');
    $notes = trim($_POST['notes'] ?? '');

    if ($name === '') { flash('warning', 'Name is required.'); }
    else {
        try {
            $stmt = $pdo->prepare("UPDATE employees SET employee_name=?, phone=?, email=?, address=?, role=?, shop_name=?, start_date=?, pay_type=?, salary=?, payment_mode=?, work_days=?, work_start=?, work_end=?, status=?, notes=? WHERE id=?");
            $stmt->execute([$name, $phone, $email, $address, $role, $shop_name, $start_date, $pay_type, $salary, $payment_mode ?: null, $work_days ?: null, $work_start, $work_end, $status, $notes ?: null, $id]);
            flash('success', 'Employee updated!');
            header('Location: employees.php'); exit;
        } catch (PDOException $ex) { flash('error', 'Error: ' . $ex->getMessage()); }
    }
}

$modes = [];
try { $modes = $pdo->query("SELECT name FROM payment_modes WHERE deleted_at IS NULL ORDER BY name")->fetchAll(); } catch (Exception $ex) {}
$current_days = array_filter(explode(',', $e['work_days'] ?? ''));
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="employees.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Employee</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="empForm" class="leo-save-btn">SAVE</button>
    </div>
</header>
<form method="post" id="empForm" class="leo-form-card" style="margin:0.85rem;">
<div class="leo-form-card-body">
    <div class="leo-form-row"><label class="leo-input-label">Full Name *</label><input type="text" name="employee_name" class="leo-input" value="<?= htmlspecialchars($e['employee_name']) ?>" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Phone</label><input type="tel" name="phone" class="leo-input" value="<?= htmlspecialchars($e['phone'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Email</label><input type="email" name="email" class="leo-input" value="<?= htmlspecialchars($e['email'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Address</label><input type="text" name="address" class="leo-input" value="<?= htmlspecialchars($e['address'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Role</label><input type="text" name="role" class="leo-input" value="<?= htmlspecialchars($e['role'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Shop</label><input type="text" name="shop_name" class="leo-input" value="<?= htmlspecialchars($e['shop_name'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Start Date</label><input type="date" name="start_date" class="leo-input" value="<?= htmlspecialchars($e['start_date'] ?? '') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Pay Type</label><select name="pay_type" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><?php foreach (['Daily','Weekly','Monthly'] as $p): ?><option value="<?= $p ?>" <?= ($e['pay_type'] ?? '') === $p ? 'selected' : '' ?>><?= $p ?></option><?php endforeach; ?></select></div>
    <div class="leo-form-row"><label class="leo-input-label">Salary</label><input type="number" step="0.01" name="salary" class="leo-input" value="<?= htmlspecialchars($e['salary'] ?? 0) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Payment Mode</label><select name="payment_mode" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><option value="">—</option><?php foreach ($modes as $m): ?><option value="<?= htmlspecialchars($m['name']) ?>" <?= ($e['payment_mode'] ?? '') === $m['name'] ? 'selected' : '' ?>><?= htmlspecialchars($m['name']) ?></option><?php endforeach; ?></select></div>
    <div class="leo-form-row">
        <label class="leo-input-label">Working Days</label>
        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
            <?php foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d): ?>
                <label style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.4rem 0.7rem;border-radius:8px;border:1px solid #E5EAF0;font-size:0.82rem;cursor:pointer;background:#F8FAFC;">
                    <input type="checkbox" name="work_days[]" value="<?= $d ?>" <?= in_array($d, $current_days, true) ? 'checked' : '' ?>> <?= $d ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Start Time</label><input type="time" name="work_start" class="leo-input" value="<?= htmlspecialchars(substr($e['work_start'] ?? '08:00', 0, 5)) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">End Time</label><input type="time" name="work_end" class="leo-input" value="<?= htmlspecialchars(substr($e['work_end'] ?? '18:00', 0, 5)) ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Status</label><select name="status" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><option value="Active" <?= ($e['status'] ?? '') === 'Active' ? 'selected' : '' ?>>Active</option><option value="Inactive" <?= ($e['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option></select></div>
    <div class="leo-form-row"><label class="leo-input-label">Notes</label><textarea name="notes" rows="3" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"><?= htmlspecialchars($e['notes'] ?? '') ?></textarea></div>
</div>
</form>
<div class="leo-bottom-actions">
    <a href="employees.php?delete=<?= (int)$e['id'] ?>" data-confirm="Move to Bin?" class="leo-btn leo-btn--outline" style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;"><i class="fas fa-trash"></i> DELETE</a>
    <a href="employees.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="empForm" class="leo-btn leo-btn--primary">UPDATE</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
