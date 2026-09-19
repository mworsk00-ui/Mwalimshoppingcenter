<?php
$page_title = 'Payment Modes Guide';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .pm-guide-wrap { max-width: 780px; margin: 0.85rem auto; padding-bottom: 2rem; }
    .pm-guide-hero {
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        color: #fff; border-radius: 16px; padding: 2rem 1.5rem; text-align: center;
        margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(37,99,235,0.25);
    }
    .pm-guide-hero i { font-size: 3rem; margin-bottom: 0.75rem; }
    .pm-guide-hero h1 { font-size: 1.5rem; margin-bottom: 0.4rem; }
    .pm-guide-hero p { opacity: 0.9; font-size: 0.9rem; }

    .pm-guide-card {
        background: #fff; border-radius: 14px; padding: 1.25rem;
        margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        border: 1px solid #EEF2F7;
    }
    .pm-guide-card h2 {
        font-size: 1.05rem; color: #1E3A8A; margin-bottom: 0.75rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .pm-guide-card h2 i {
        width: 32px; height: 32px; background: #DBEAFE; color: #1E40AF;
        border-radius: 8px; display: inline-flex; align-items: center;
        justify-content: center; font-size: 0.9rem;
    }
    .pm-guide-card p, .pm-guide-card li { font-size: 0.92rem; color: #334155; line-height: 1.6; }

    .pm-guide-step {
        display: flex; gap: 0.85rem; padding: 0.85rem 0;
        border-bottom: 1px dashed #EEF2F7;
    }
    .pm-guide-step:last-child { border-bottom: 0; }
    .pm-guide-step-num {
        flex: 0 0 32px; height: 32px;
        background: #2563EB; color: #fff; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem;
    }
    .pm-guide-step-body { flex: 1; }
    .pm-guide-step-body strong { color: #0F172A; display: block; margin-bottom: 0.2rem; font-size: 0.95rem; }

    .pm-guide-benefit { display: flex; gap: 0.75rem; padding: 0.6rem 0; }
    .pm-guide-benefit i { color: #16A34A; font-size: 1.1rem; flex: 0 0 24px; padding-top: 0.15rem; }
    .pm-guide-benefit strong { display: block; color: #0F172A; font-size: 0.92rem; }
    .pm-guide-benefit span { color: #475569; font-size: 0.85rem; }

    .pm-guide-tip {
        background: #FEF3C7; border-left: 4px solid #F59E0B;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #78350F; margin-top: 0.75rem;
    }
    .pm-guide-tip i { color: #D97706; margin-right: 0.35rem; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="payment-modes.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Payment Modes Guide</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="payment-mode-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="pm-guide-wrap">

    <div class="pm-guide-hero">
        <i class="fas fa-credit-card"></i>
        <h1>How Modes of Payment Work</h1>
        <p>Set up how your customers can pay — cash, mobile money, bank, and more.</p>
    </div>

    <div class="pm-guide-card">
        <h2><i class="fas fa-lightbulb"></i> What are Modes of Payment?</h2>
        <p>
            A <strong>mode of payment</strong> is simply the <em>way</em> a customer pays you.
            For example: <strong>Cash</strong>, <strong>M-Pesa</strong>, <strong>Tigo Pesa</strong>,
            <strong>Bank Transfer</strong>, <strong>Cheque</strong>, or <strong>Card</strong>.
        </p>
        <p>
            In this section, you build the list of payment methods your shop accepts.
            Once created, they can be used when recording a sale or a purchase.
        </p>
    </div>

    <div class="pm-guide-card">
        <h2><i class="fas fa-list-check"></i> How to Use It</h2>

        <div class="pm-guide-step">
            <span class="pm-guide-step-num">1</span>
            <div class="pm-guide-step-body">
                <strong>View all payment modes</strong>
                Open <em>Modes of Payment</em> from the menu. You'll see every method you've added,
                along with its description and status.
            </div>
        </div>

        <div class="pm-guide-step">
            <span class="pm-guide-step-num">2</span>
            <div class="pm-guide-step-body">
                <strong>Add a new mode</strong>
                Tap the blue <em>ADD</em> button. Give it a name (e.g. "M-Pesa"), an optional
                description, and choose its status (Active / Inactive). Tap <em>SAVE</em>.
            </div>
        </div>

        <div class="pm-guide-step">
            <span class="pm-guide-step-num">3</span>
            <div class="pm-guide-step-body">
                <strong>Edit a mode</strong>
                Tap <em>✏️ Edit</em> to rename or update its description, or flip it to
                <em>Inactive</em> if you no longer use it (it will stop showing in sales dropdowns).
            </div>
        </div>

        <div class="pm-guide-step">
            <span class="pm-guide-step-num">4</span>
            <div class="pm-guide-step-body">
                <strong>Delete a mode</strong>
                Tap <em>🗑 Delete</em>. It's moved to the <strong>Recycle Bin</strong> —
                not deleted permanently, so you can restore it if you change your mind.
            </div>
        </div>
    </div>

    <div class="pm-guide-card">
        <h2><i class="fas fa-star"></i> Why It Helps Your Business</h2>

        <div class="pm-guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Organised daily cash flow</strong>
                <span>At the end of the day you can see exactly how much came from cash, M-Pesa, bank, etc.</span>
            </div>
        </div>

        <div class="pm-guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Cleaner reports</strong>
                <span>Sales and reports group totals by payment method — useful for tax and reconciliation.</span>
            </div>
        </div>

        <div class="pm-guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Faster checkout</strong>
                <span>Staff pick from a dropdown instead of typing — fewer mistakes.</span>
            </div>
        </div>

        <div class="pm-guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Adapt to your business</strong>
                <span>Only show the methods you actually accept. Hide the ones you don't.</span>
            </div>
        </div>

        <div class="pm-guide-tip">
            <i class="fas fa-lightbulb"></i>
            <strong>Tip:</strong> Set a mode to <em>Inactive</em> instead of deleting it if you
            might use it again later — that keeps its history in old sales records.
        </div>
    </div>

    <div class="pm-guide-card">
        <h2><i class="fas fa-recycle"></i> Recycle Bin — Safety Net</h2>
        <p>
            Deleting a payment mode doesn't remove it forever. It goes into the
            <strong>Recycle Bin</strong>, where you can:
        </p>
        <ul>
            <li><strong>Restore</strong> it if it was deleted by mistake</li>
            <li><strong>Delete Forever</strong> when you're sure</li>
        </ul>
        <p>
            Once an item is permanently deleted (or the bin is emptied), it
            <strong>cannot be recovered</strong> from inside the app — you'd need to contact the
            developer to attempt recovery from a database backup.
        </p>
    </div>

    <div class="pm-guide-card">
        <h2><i class="fas fa-circle-question"></i> Common Questions</h2>

        <p><strong>How many modes can I add?</strong><br>
        As many as you need — there's no limit.</p>

        <p><strong>Can I have two modes with the same name?</strong><br>
        Yes, but it's not recommended. Use distinct names like "M-Pesa (Retail)" and "M-Pesa (Wholesale)" if needed.</p>

        <p><strong>What does "Inactive" do?</strong><br>
        The mode stays in your records but stops appearing in the sales form dropdowns.</p>

        <p><strong>Do old sales use the deleted mode?</strong><br>
        Yes — old sales keep the payment mode name they were recorded with, even if you delete the mode later.</p>
    </div>

</div>

<div class="leo-bottom-actions">
    <a href="payment-modes.php" class="leo-btn leo-btn--outline">BACK TO MODES</a>
    <a href="payment-mode-add.php" class="leo-btn leo-btn--primary">ADD A MODE</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>