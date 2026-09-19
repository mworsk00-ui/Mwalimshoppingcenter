<?php
$page_title = 'Customer Guide';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .guide-wrap { max-width: 780px; margin: 0.85rem auto; padding-bottom: 2rem; }
    .guide-hero {
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        color: #fff;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 24px rgba(37,99,235,0.25);
    }
    .guide-hero i { font-size: 3rem; margin-bottom: 0.75rem; }
    .guide-hero h1 { font-size: 1.5rem; margin-bottom: 0.4rem; }
    .guide-hero p { opacity: 0.9; font-size: 0.9rem; }

    .guide-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.25rem 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        border: 1px solid #EEF2F7;
    }
    .guide-card h2 {
        font-size: 1.05rem;
        color: #1E3A8A;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .guide-card h2 i {
        width: 32px; height: 32px;
        background: #DBEAFE;
        color: #1E40AF;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .guide-card p, .guide-card li {
        font-size: 0.92rem;
        color: #334155;
        line-height: 1.6;
    }
    .guide-card ol, .guide-card ul { padding-left: 1.2rem; margin: 0.5rem 0; }
    .guide-card li { margin-bottom: 0.35rem; }

    .guide-step {
        display: flex;
        gap: 0.85rem;
        padding: 0.85rem 0;
        border-bottom: 1px dashed #EEF2F7;
    }
    .guide-step:last-child { border-bottom: 0; }
    .guide-step-num {
        flex: 0 0 32px;
        height: 32px;
        background: #2563EB;
        color: #fff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .guide-step-body { flex: 1; }
    .guide-step-body strong { color: #0F172A; display: block; margin-bottom: 0.2rem; font-size: 0.95rem; }

    .guide-tip {
        background: #FEF3C7;
        border-left: 4px solid #F59E0B;
        padding: 0.85rem 1rem;
        border-radius: 8px;
        font-size: 0.88rem;
        color: #78350F;
        margin-top: 0.75rem;
    }
    .guide-tip i { color: #D97706; margin-right: 0.35rem; }

    .guide-benefit {
        display: flex;
        gap: 0.75rem;
        padding: 0.6rem 0;
    }
    .guide-benefit i {
        color: #16A34A;
        font-size: 1.1rem;
        flex: 0 0 24px;
        padding-top: 0.15rem;
    }
    .guide-benefit strong { display: block; color: #0F172A; font-size: 0.92rem; }
    .guide-benefit span { color: #475569; font-size: 0.85rem; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="customers.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Customer Guide</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="customer-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="guide-wrap">

    <div class="guide-hero">
        <i class="fas fa-users"></i>
        <h1>How the Customer Section Works</h1>
        <p>Everything you need to know — in 2 minutes.</p>
    </div>

    <div class="guide-card">
        <h2><i class="fas fa-lightbulb"></i> What is the Customer Section?</h2>
        <p>
            The Customer Section is where you keep a record of <strong>every person or business that buys from you</strong>.
            Think of it like a smart notebook — but one that remembers everything for you, helps you track who owes money,
            and lets you find any customer in seconds.
        </p>
    </div>

    <div class="guide-card">
        <h2><i class="fas fa-list-check"></i> What You Can Do</h2>

        <div class="guide-step">
            <span class="guide-step-num">1</span>
            <div class="guide-step-body">
                <strong>View all your customers</strong>
                Tap <em>Customers</em> from the home menu. You'll see a list with each person's name, phone number,
                and how much they owe you.
            </div>
        </div>

        <div class="guide-step">
            <span class="guide-step-num">2</span>
            <div class="guide-step-body">
                <strong>Add a new customer</strong>
                Tap the blue <em>ADD</em> button at the top-right. Fill in their name (required), phone number,
                and any other details. Tap <em>SAVE</em>. Done!
            </div>
        </div>

        <div class="guide-step">
            <span class="guide-step-num">3</span>
            <div class="guide-step-body">
                <strong>View a customer's full details</strong>
                Tap the <em>👁 View</em> button next to any customer to see their phone, email, TIN, address,
                and outstanding balance — all in one place.
            </div>
        </div>

        <div class="guide-step">
            <span class="guide-step-num">4</span>
            <div class="guide-step-body">
                <strong>Edit a customer</strong>
                Tap <em>✏️ Edit</em> to change their phone number, fix a typo, or update their details.
                You'll get a confirmation message once saved.
            </div>
        </div>

        <div class="guide-step">
            <span class="guide-step-num">5</span>
            <div class="guide-step-body">
                <strong>Delete a customer</strong>
                Tap <em>🗑 Delete</em>. A popup will ask you to confirm — this protects you from
                accidentally deleting someone. Tap <em>Yes, delete</em> to confirm.
            </div>
        </div>
    </div>

    <div class="guide-card">
        <h2><i class="fas fa-star"></i> Why It Helps Your Business</h2>

        <div class="guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Never lose a customer's contact again</strong>
                <span>Phone numbers, emails, and TINs are saved permanently.</span>
            </div>
        </div>

        <div class="guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Know who owes you money</strong>
                <span>The "Due" column shows at a glance who still has a balance.</span>
            </div>
        </div>

        <div class="guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Faster sales</strong>
                <span>When making a sale, just pick the customer — no need to type their details each time.</span>
            </div>
        </div>

        <div class="guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Better record-keeping</strong>
                <span>Every customer's history is in one place for tax, reports, or follow-ups.</span>
            </div>
        </div>

        <div class="guide-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Send reminders with confidence</strong>
                <span>See exactly who to call or message about unpaid balances.</span>
            </div>
        </div>

        <div class="guide-tip">
            <i class="fas fa-lightbulb"></i>
            <strong>Pro tip:</strong> Add a customer's TIN (Taxpayer Identification Number) if they're
            a business — it makes receipts and tax reports much easier later.
        </div>
    </div>

    <div class="guide-card">
        <h2><i class="fas fa-circle-question"></i> Common Questions</h2>

        <p><strong>What if I delete a customer by mistake?</strong><br>
        Contact your system admin — they can restore it from the database backup.</p>

        <p><strong>Can two customers have the same name?</strong><br>
        Yes, but to avoid confusion, add their phone number to tell them apart.</p>

        <p><strong>What does "Previous Due" mean?</strong><br>
        It's the amount the customer already owed you <em>before</em> this system. It's just a starting balance.</p>

        <p><strong>Do I have to fill every field?</strong><br>
        No — only the <em>Name</em> is required. Everything else is optional but recommended.</p>
    </div>

</div>

<div class="leo-bottom-actions">
    <a href="customers.php" class="leo-btn leo-btn--outline">BACK TO CUSTOMERS</a>
    <a href="customer-add.php" class="leo-btn leo-btn--primary">ADD A CUSTOMER</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>