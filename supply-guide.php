<?php
$page_title = 'Supplies Guide';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .sp-guide-wrap { max-width: 780px; margin: 0.85rem auto; padding-bottom: 2rem; }
    .sp-guide-hero {
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        color: #fff; border-radius: 16px; padding: 2rem 1.5rem; text-align: center;
        margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(37,99,235,0.25);
    }
    .sp-guide-hero i { font-size: 3rem; margin-bottom: 0.75rem; }
    .sp-guide-hero h1 { font-size: 1.5rem; margin-bottom: 0.4rem; }
    .sp-guide-hero p { opacity: 0.9; font-size: 0.9rem; }

    .sp-guide-card {
        background: #fff; border-radius: 14px; padding: 1.25rem;
        margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        border: 1px solid #EEF2F7;
    }
    .sp-guide-card h2 {
        font-size: 1.05rem; color: #1E3A8A; margin-bottom: 0.75rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .sp-guide-card h2 i {
        width: 32px; height: 32px; background: #DBEAFE; color: #1E40AF;
        border-radius: 8px; display: inline-flex; align-items: center;
        justify-content: center; font-size: 0.9rem;
    }
    .sp-guide-card p, .sp-guide-card li { font-size: 0.92rem; color: #334155; line-height: 1.6; }

    .sp-guide-step { display: flex; gap: 0.85rem; padding: 0.85rem 0; border-bottom: 1px dashed #EEF2F7; }
    .sp-guide-step:last-child { border-bottom: 0; }
    .sp-guide-step-num {
        flex: 0 0 32px; height: 32px; background: #2563EB; color: #fff;
        border-radius: 50%; display: inline-flex; align-items: center;
        justify-content: center; font-weight: 700; font-size: 0.85rem;
    }
    .sp-guide-step-body { flex: 1; }
    .sp-guide-step-body strong { color: #0F172A; display: block; margin-bottom: 0.2rem; font-size: 0.95rem; }

    .sp-guide-tip {
        background: #FEF3C7; border-left: 4px solid #F59E0B;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #78350F; margin-top: 0.75rem;
    }
    .sp-guide-tip i { color: #D97706; margin-right: 0.35rem; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="supplies.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Supplies Guide</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="supply-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="sp-guide-wrap">

    <div class="sp-guide-hero">
        <i class="fas fa-box-open"></i>
        <h1>How the Supplies Section Works</h1>
        <p>Record every product you send to a customer — with price, quantity, and who delivered it.</p>
    </div>

    <div class="sp-guide-card">
        <h2><i class="fas fa-lightbulb"></i> What is a Supply?</h2>
        <p>
            A <strong>supply</strong> is a record of goods you've <em>sent</em> to a customer.
            For example: <em>"I sent 5 kg of rice to Mr. John today for 20,000 TZS, delivered by Bodaboda Mike."</em>
        </p>
        <p>
            This section keeps a full history — who received it, what they got, how much they paid,
            and whether anything is still owed.
        </p>
    </div>

    <div class="sp-guide-card">
        <h2><i class="fas fa-list-check"></i> How to Use It</h2>

        <div class="sp-guide-step">
            <span class="sp-guide-step-num">1</span>
            <div class="sp-guide-step-body">
                <strong>Add a supply</strong>
                Tap <em>ADD</em>, then:
                <ul>
                    <li>Choose a customer from the dropdown, OR type a new name</li>
                    <li>Choose a product from the dropdown, OR type a new one</li>
                    <li>Enter quantity and pick its unit (kg, g, pcs, carton, bag, litre…)</li>
                    <li>Add unit price (optional) and total amount</li>
                    <li>Set the date and payment status</li>
                    <li>If delivered by someone, add their name + phone (e.g. Bodaboda)</li>
                </ul>
            </div>
        </div>

        <div class="sp-guide-step">
            <span class="sp-guide-step-num">2</span>
            <div class="sp-guide-step-body">
                <strong>See all supplies</strong>
                Back on the main page, you'll see every supply sorted by date.
                Use the filters to narrow by customer or payment status.
            </div>
        </div>

        <div class="sp-guide-step">
            <span class="sp-guide-step-num">3</span>
            <div class="sp-guide-step-body">
                <strong>View + Print</strong>
                Tap <em>👁 View</em> for the full record.
                Use the <em>Print</em> button to give the customer a receipt.
            </div>
        </div>

        <div class="sp-guide-step">
            <span class="sp-guide-step-num">4</span>
            <div class="sp-guide-step-body">
                <strong>Edit or Delete</strong>
                Tap <em>✏️ Edit</em> to fix mistakes.
                <em>🗑 Delete</em> sends the record to the Recycle Bin — restore later if needed.
            </div>
        </div>
    </div>

    <div class="sp-guide-card">
        <h2><i class="fas fa-star"></i> Why It Helps Your Business</h2>

        <ul>
            <li><strong>Know who owes you</strong> — filter by Unpaid to see balances</li>
            <li><strong>Full history per customer</strong> — see everything they've received</li>
            <li><strong>Courier tracking</strong> — record who delivered and their phone</li>
            <li><strong>Unit-aware</strong> — kg, g, L, carton, bag, pieces — all supported</li>
            <li><strong>Printable receipts</strong> — professional-looking for your customer</li>
            <li><strong>Accurate records</strong> — clean reports for tax and follow-up</li>
        </ul>

        <div class="sp-guide-tip">
            <i class="fas fa-lightbulb"></i>
            <strong>Tip:</strong> If the customer isn't yet in your Customers list,
            just type their name here. You can add them properly later.
        </div>
    </div>

</div>

<div class="leo-bottom-actions">
    <a href="supplies.php" class="leo-btn leo-btn--outline">BACK TO SUPPLIES</a>
    <a href="supply-add.php" class="leo-btn leo-btn--primary">ADD A SUPPLY</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>