<?php
$page_title = 'View Customer';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch();

if (!$c) {
    flash('warning', 'Customer not found.');
    header('Location: customers.php');
    exit;
}
require_once __DIR__ . '/includes/header.php';
?>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="customers.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Customer Details</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="customer-edit.php?id=<?= (int)$c['id'] ?>" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-pen"></i> EDIT
        </a>
    </div>
</header>

<div class="leo-form-card" style="margin:0.85rem;padding:0;">
    <div class="leo-form-card-body">

        <div style="text-align:center;margin:0.5rem 0 1.5rem;">
            <div style="width:110px;height:110px;border-radius:50%;background:var(--leo-blue-soft);display:inline-flex;align-items:center;justify-content:center;color:var(--leo-primary);font-size:3rem;">
                <i class="fas fa-user"></i>
            </div>
            <h2 style="margin-top:0.75rem;font-size:1.25rem;color:#0F172A;"><?= htmlspecialchars($c['customer_name']) ?></h2>
            <?php if (!empty($c['phone'])): ?>
                <p style="color:var(--leo-muted);font-size:0.9rem;"><?= htmlspecialchars($c['phone']) ?></p>
            <?php endif; ?>
        </div>

        <?php
        $rows = [
            'Phone'         => $c['phone']         ?? '—',
            'Email'         => $c['email']         ?? '—',
            'TIN'           => $c['tin']           ?? '—',
            'Address'       => $c['address']       ?? '—',
            'Previous Due'  => number_format((float)($c['due'] ?? 0), 2),
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
    <a href="customers.php?delete=<?= (int)$c['id'] ?>"
       data-confirm="Do you want to delete the customer '<?= htmlspecialchars($c['customer_name'], ENT_QUOTES) ?>'?"
       data-confirm-ok="Yes, delete"
       data-confirm-cancel="Cancel"
       class="leo-btn leo-btn--outline"
       style="flex:0.7;background:#FEE2E2;color:#991B1B;border-color:#FCA5A5;">
        <i class="fas fa-trash"></i> DELETE
    </a>
    <a href="customers.php" class="leo-btn leo-btn--outline">BACK</a>
    <a href="customer-edit.php?id=<?= (int)$c['id'] ?>" class="leo-btn leo-btn--primary">EDIT</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>