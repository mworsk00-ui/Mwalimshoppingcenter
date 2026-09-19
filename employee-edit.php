<?php
$page_title = 'Edit Employee';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = trim($_POST['employee_name'] ?? '');
    $phone        = trim($_POST['phone']   ?? '');
    $email        = trim($_POST['email']   ?? '');
    $address      = trim($_POST['address'] ?? '');
    $role         = trim($_POST['role']    ?? '');
    $shop_name    = trim($_POST['shop_name'] ?? '');
    $start_date   = $_POST['start_date'] ?: null;
    $pay_type     = trim($_POST['pay_type'] ?? 'Monthly');
    $salary       = (float)($_POST['salary'] ?? 0);
    $payment_mode = trim($_POST['payment_mode'] ?? '');
    $work_days    = isset($_POST['work_days']) ? implode(',', $_POST['work_days']) : '';
    $work_start   = $_POST['work_start'] ?: null;
    $work_end     = $_POST['work_end']   ?: null;
    $status       = trim($_POST['status'] ?? 'Active');
    $notes        = trim($_POST['notes'] ?? '');

    if ($name === '') {
        flash('warning', 'Employee name is required.');
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE employees SET
                employee_name=?, phone=?, email=?, address=?, role=?, shop_name=?, start_date=?,
                pay_type=?, salary=?, payment_mode=?, work_days=?, work_start=?, work_end=?,
                status=?, notes=?
                WHERE id=?");
            $stmt->execute([
                $name, $phone, $email, $address, $role, $shop_name, $start_date,
                $pay_type, $salary, $payment_mode ?: null, $work_days ?: null,
                $work_start, $work_end, $status, $notes ?: null, $id
            ]);
            flash('success', 'Employee updated successfully!');
            header('Location: employees.php');
            exit;
        } catch (PDOException $ex) {
            flash('error', 'Error updating employee: ' . $ex->getMessage());
        }
    }
}

$modes = $pdo->query("SELECT name FROM payment_modes WHERE deleted_at IS NULL ORDER BY name")->fetchAll();
$current_days = array_filter(explode(',', $e['work_days'] ?? ''));
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .pm-page-wrap { min-height: calc(100vh - 140px); display: flex; flex-direction: column; }
    .pm-page-wrap .leo-form-card { flex: 1; }
    .pm-bottom-actions {
        position: sticky; bottom: 0; background: #fff;
        border-top: 1px solid #E5EAF0; padding: 0.85rem 1rem;
        display: flex; gap: 0.6rem; margin-top: auto;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.04);
    }
    .pm-bottom-actions .leo-btn { flex: 1; justify-content: center; text-align: center; }
    .eg-section-title {
        font-size:0.85rem;font-weight:700;color:var(--leo-primary);
        text-transform:uppercase;letter-spacing:0.04em;
        margin:1.25rem 0 0.5rem;padding-top:1rem;border-top:1px dashed #E5EAF0;
    }
    .eg-section-title:first-of-type { border-top:0;padding-top:0;margin-top:0.5rem; }
    .eg-days { display:flex;flex-wrap:wrap;gap:0.4rem;margin-top:0.35rem; }
    .eg-day {
        display:inline-flex;align-items:center;gap:0.35rem;
        padding:0.4rem 0.7rem;border-radius:8px;border:1px solid #E5EAF0;
        font-size:0.82rem;color:#334155;cursor:pointer;background:#F8FAFC;
    }
    .eg-day input { margin:0; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="employees.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Edit Employee</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="empForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<div class="pm-page-wrap">
<form method="post" id="empForm" class="leo-form-card" style="margin:0.85rem;" data-loading="Updating…">
<div class="leo-form-card-body">

    <div style="text-align:center;margin:0.5rem 0 1rem;">
        <div style="width:90px;height:90px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.2rem;">
            <i class="fas fa-user-tie"></i>
        </div>
    </div>

    <div class="eg-section-title"><i class="fas fa-user"></i> Personal Details</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Full Name *</label>
        <div class="leo-input-row">
            <input type="text" name="employee_name" class="leo-input"
                   value="<?= htmlspecialchars($e['employee_name']) ?>" required>
            <span class="leo-input-row-icon"><i class="fas fa-user"></i></span>
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Phone Number</label>
        <input type="tel" name="phone" class="leo-input"
               value="<?= htmlspecialchars($e['phone'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Email Address</label>
        <input type="email" name="email" class="leo-input"
               value="<?= htmlspecialchars($e['email'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Home Address</label>
        <input type="text" name="address" class="leo-input"
               value="<?= htmlspecialchars($e['address'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="eg-section-title"><i class="fas fa-briefcase"></i> Work Details</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Role / Position</label>
        <input type="text" name="role" class="leo-input"
               value="<?= htmlspecialchars($e['role'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Shop / Workplace Name</label>
        <input type="text" name="shop_name" class="leo-input"
               value="<?= htmlspecialchars($e['shop_name'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Start Date</label>
        <input type="date" name="start_date" class="leo-input"
               value="<?= htmlspecialchars($e['start_date'] ?? '') ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="eg-section-title"><i class="fas fa-money-bill-wave"></i> Payment Details</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Pay Type *</label>
        <select name="pay_type" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <?php foreach (['Daily','Weekly','Monthly'] as $p): ?>
                <option value="<?= $p ?>" <?= $e['pay_type'] === $p ? 'selected' : '' ?>><?= $p ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Salary Amount *</label>
        <input type="number" step="0.01" min="0" name="salary" class="leo-input"
               value="<?= htmlspecialchars($e['salary']) ?>" required
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Payment Mode</label>
        <select name="payment_mode" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="">— Not specified —</option>
            <?php foreach ($modes as $m): ?>
                <option value="<?= htmlspecialchars($m['name']) ?>"
                        <?= $e['payment_mode'] === $m['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="eg-section-title"><i class="fas fa-clock"></i> Work Schedule</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Working Days</label>
        <div class="eg-days">
            <?php foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d): ?>
                <label class="eg-day">
                    <input type="checkbox" name="work_days[]" value="<?= $d ?>"
                           <?= in_array($d, $current_days, true) ? 'checked' : '' ?>>
                    <?= $d ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Work Start Time</label>
        <input type="time" name="work_start" class="leo-input"
               value="<?= htmlspecialchars(substr($e['work_start'] ?? '08:00', 0, 5)) ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Work End Time</label>
        <input type="time" name="work_end" class="leo-input"
               value="<?= htmlspecialchars(substr($e['work_end'] ?? '18:00', 0, 5)) ?>"
               style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
    </div>

    <div class="eg-section-title"><i class="fas fa-flag"></i> Status & Notes</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Status</label>
        <select name="status" class="leo-input"
                style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="Active"   <?= $e['status'] === 'Active'   ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= $e['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>

    <div class="leo-form-row">
        <label class="leo-input-label">Notes</label>
        <textarea name="notes" rows="3" class="leo-input"
                  style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;resize:vertical;"><?= htmlspecialchars($e['notes'] ?? '') ?></textarea>
    </div>

</div>
</form>

<div class="pm-bottom-actions">
    <a href="employees.php?delete=<?= (int)$e['id'] ?>"
       data-confirm="Move '<?= htmlspecialchars($e['employee_name'], ENT_QUOTES) ?>' to the Recycle Bin?"
       data-confirm-ok="Yes, move to bin"
       data-confirm-cancel="Cancel"
       class="leo-btn leo-btn--outline"
       style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
        <i class="fas fa-trash"></i> DELETE
    </a>
    <a href="employees.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="empForm" class="leo-btn leo-btn--primary">UPDATE</button>
</div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>