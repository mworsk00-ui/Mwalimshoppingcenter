<?php
$page_title = 'Add Employee';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

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

    if ($name === '') {
        flash('warning', 'Employee name is required.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO employees (employee_name, phone, email, address, role, shop_name, start_date, pay_type, salary, payment_mode, work_days, work_start, work_end, status, notes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$name, $phone, $email, $address, $role, $shop_name, $start_date, $pay_type, $salary, $payment_mode ?: null, $work_days ?: null, $work_start, $work_end, $status, $notes ?: null]);
            flash('success', 'Employee saved!');
            header('Location: employees.php'); exit;
        } catch (PDOException $e) { flash('error', 'Error: ' . $e->getMessage()); }
    }
}

$modes = [];
try { $modes = $pdo->query("SELECT name FROM payment_modes WHERE deleted_at IS NULL ORDER BY name")->fetchAll(); } catch (Exception $e) {}
require_once __DIR__ . '/includes/header.php';
?>
<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="employees.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Add Employee</span>
    </div>
    <div class="leo-page-header-actions">
        <button type="submit" form="empForm" class="leo-save-btn">SAVE</button>
    </div>
</header>

<form method="post" id="empForm" class="leo-form-card" style="margin:0.85rem;">
<div class="leo-form-card-body">
    <div style="text-align:center;margin:0.5rem 0 1rem;">
        <div style="width:90px;height:90px;border-radius:14px;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:2.2rem;">
            <i class="fas fa-user-tie"></i>
        </div>
    </div>

    <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;margin-bottom:0.5rem;"><i class="fas fa-user"></i> Personal Details</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Full Name *</label>
        <div class="leo-input-row">
            <input type="text" name="employee_name" class="leo-input" placeholder="Enter name" required>
            <span class="leo-input-row-icon"><i class="fas fa-user"></i></span>
        </div>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Phone</label><input type="tel" name="phone" class="leo-input" placeholder="07XX XXX XXX" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Email</label><input type="email" name="email" class="leo-input" placeholder="email@example.com" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Address</label><input type="text" name="address" class="leo-input" placeholder="Home address" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>

    <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;margin:1.25rem 0 0.5rem;padding-top:1rem;border-top:1px dashed #E5EAF0;"><i class="fas fa-briefcase"></i> Work Details</div>

    <div class="leo-form-row"><label class="leo-input-label">Role</label><input type="text" name="role" class="leo-input" placeholder="e.g. Cashier" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Shop</label><input type="text" name="shop_name" class="leo-input" placeholder="e.g. Main Branch" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">Start Date</label><input type="date" name="start_date" class="leo-input" value="<?= date('Y-m-d') ?>" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>

    <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;margin:1.25rem 0 0.5rem;padding-top:1rem;border-top:1px dashed #E5EAF0;"><i class="fas fa-money-bill-wave"></i> Payment</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Pay Type *</label>
        <select name="pay_type" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="Daily">Daily</option>
            <option value="Weekly">Weekly</option>
            <option value="Monthly" selected>Monthly</option>
        </select>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Salary *</label><input type="number" step="0.01" name="salary" class="leo-input" placeholder="0.00" required style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row">
        <label class="leo-input-label">Payment Mode</label>
        <select name="payment_mode" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="">— Not specified —</option>
            <?php foreach ($modes as $m): ?>
                <option value="<?= htmlspecialchars($m['name']) ?>"><?= htmlspecialchars($m['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div style="font-size:0.85rem;font-weight:700;color:var(--leo-primary);text-transform:uppercase;margin:1.25rem 0 0.5rem;padding-top:1rem;border-top:1px dashed #E5EAF0;"><i class="fas fa-clock"></i> Schedule</div>

    <div class="leo-form-row">
        <label class="leo-input-label">Working Days</label>
        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
            <?php foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d): ?>
                <label style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.4rem 0.7rem;border-radius:8px;border:1px solid #E5EAF0;font-size:0.82rem;cursor:pointer;background:#F8FAFC;">
                    <input type="checkbox" name="work_days[]" value="<?= $d ?>"> <?= $d ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Start Time</label><input type="time" name="work_start" class="leo-input" value="08:00" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>
    <div class="leo-form-row"><label class="leo-input-label">End Time</label><input type="time" name="work_end" class="leo-input" value="18:00" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></div>

    <div class="leo-form-row">
        <label class="leo-input-label">Status</label>
        <select name="status" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>
    <div class="leo-form-row"><label class="leo-input-label">Notes</label><textarea name="notes" rows="3" class="leo-input" style="border:0;border-bottom:1px solid #E5EAF0;border-radius:0;padding-left:0;"></textarea></div>
</div>
</form>

<div class="leo-bottom-actions">
    <a href="employees.php" class="leo-btn leo-btn--outline">CANCEL</a>
    <button type="submit" form="empForm" class="leo-btn leo-btn--primary">SAVE EMPLOYEE</button>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
