<?php
$page_title = 'Recycle Bin Guide';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .rb-wrap { max-width: 780px; margin: 0.85rem auto; padding-bottom: 2rem; }
    .rb-hero {
        background: linear-gradient(135deg, #F59E0B, #B45309);
        color: #fff; border-radius: 16px; padding: 2rem 1.5rem; text-align: center;
        margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(180,83,9,0.25);
    }
    .rb-hero i { font-size: 3rem; margin-bottom: 0.75rem; }
    .rb-hero h1 { font-size: 1.5rem; margin-bottom: 0.4rem; }
    .rb-hero p { opacity: 0.9; font-size: 0.9rem; }

    .rb-card {
        background: #fff; border-radius: 14px; padding: 1.25rem;
        margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        border: 1px solid #EEF2F7;
    }
    .rb-card h2 {
        font-size: 1.05rem; color: #92400E; margin-bottom: 0.75rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .rb-card h2 i {
        width: 32px; height: 32px; background: #FEF3C7; color: #B45309;
        border-radius: 8px; display: inline-flex; align-items: center;
        justify-content: center; font-size: 0.9rem;
    }
    .rb-card p, .rb-card li { font-size: 0.92rem; color: #334155; line-height: 1.6; }

    .rb-step {
        display: flex; gap: 0.85rem; padding: 0.85rem 0;
        border-bottom: 1px dashed #EEF2F7;
    }
    .rb-step:last-child { border-bottom: 0; }
    .rb-step-num {
        flex: 0 0 32px; height: 32px;
        background: #F59E0B; color: #fff; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem;
    }
    .rb-step-body { flex: 1; }
    .rb-step-body strong { color: #0F172A; display: block; margin-bottom: 0.2rem; font-size: 0.95rem; }

    .rb-warn {
        background: #FEE2E2; border-left: 4px solid #DC2626;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #7F1D1D; margin-top: 0.75rem;
    }
    .rb-warn i { color: #DC2626; margin-right: 0.35rem; }

    .rb-tip {
        background: #FEF3C7; border-left: 4px solid #F59E0B;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #78350F; margin-top: 0.75rem;
    }
    .rb-tip i { color: #D97706; margin-right: 0.35rem; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="recycle-bin.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Recycle Bin Guide</span>
    </div>
</header>

<div class="rb-wrap">

    <div class="rb-hero">
        <i class="fas fa-recycle"></i>
        <h1>How the Recycle Bin Works</h1>
        <p>A safety net for accidental deletions.</p>
    </div>

    <div class="rb-card">
        <h2><i class="fas fa-shield-halved"></i> What is the Recycle Bin?</h2>
        <p>
            When you delete a customer or a payment mode, it doesn't disappear immediately.
            Instead, it moves into the <strong>Recycle Bin</strong> — just like the trash bin
            on your phone or computer. From there, you can either <strong>restore</strong> it
            or <strong>delete it forever</strong>.
        </p>
    </div>

    <div class="rb-card">
        <h2><i class="fas fa-list-check"></i> How to Use It</h2>

        <div class="rb-step">
            <span class="rb-step-num">1</span>
            <div class="rb-step-body">
                <strong>Delete an item normally</strong>
                On any list page (Customers, Payment Modes, etc.), tap <em>Delete</em> and confirm.
                The item moves to the Recycle Bin — it's <em>not gone yet</em>.
            </div>
        </div>

        <div class="rb-step">
            <span class="rb-step-num">2</span>
            <div class="rb-step-body">
                <strong>Open the Recycle Bin</strong>
                From the Menu (or wherever you placed it), tap <em>Recycle Bin</em>.
                You'll see everything you've deleted, with the date it was removed.
            </div>
        </div>

        <div class="rb-step">
            <span class="rb-step-num">3</span>
            <div class="rb-step-body">
                <strong>Restore something by mistake?</strong>
                Tap <em>🔄 Restore</em> next to any item. It instantly returns to where it came from.
            </div>
        </div>

        <div class="rb-step">
            <span class="rb-step-num">4</span>
            <div class="rb-step-body">
                <strong>Delete forever</strong>
                Tap <em>🗑 Delete Forever</em> to remove a single item permanently. You'll be asked to confirm.
            </div>
        </div>

        <div class="rb-step">
            <span class="rb-step-num">5</span>
            <div class="rb-step-body">
                <strong>Empty the whole bin</strong>
                Tap <em>🔥 EMPTY BIN</em> at the top to permanently wipe <strong>everything</strong> in it.
            </div>
        </div>
    </div>

    <div class="rb-card">
        <h2><i class="fas fa-triangle-exclamation"></i> Important Warning</h2>
        <p>
            Items in the Recycle Bin are still recoverable. But once you press
            <strong>Delete Forever</strong> or <strong>Empty Bin</strong>, the data is
            permanently erased from the database.
        </p>
        <div class="rb-warn">
            <i class="fas fa-circle-exclamation"></i>
            <strong>There is no way to recover</strong> items after they've been permanently deleted —
            unless you contact the developer to attempt recovery from a database backup
            <em>and</em> a recent backup exists.
        </div>
        <div class="rb-tip">
            <i class="fas fa-lightbulb"></i>
            <strong>Tip:</strong> If you're unsure, leave items in the Recycle Bin.
            They cost nothing to keep and can always be restored later.
        </div>
    </div>

    <div class="rb-card">
        <h2><i class="fas fa-circle-question"></i> Common Questions</h2>

        <p><strong>Does the Recycle Bin fill up automatically?</strong><br>
        No — items stay until you restore or permanently delete them.</p>

        <p><strong>Can I restore everything at once?</strong><br>
        Not yet — restore items one by one. (Feature can be added later.)</p>

        <p><strong>What happens if I empty the bin by mistake?</strong><br>
        Contact your developer immediately. Recovery is only possible if a database backup exists.</p>

        <p><strong>Do deleted items still count in reports?</strong><br>
        No — once an item is in the Recycle Bin, it disappears from your normal lists
        and reports. It only lives in the Recycle Bin.</p>
    </div>

</div>

<div class="leo-bottom-actions">
    <a href="recycle-bin.php" class="leo-btn leo-btn--outline">BACK TO BIN</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>