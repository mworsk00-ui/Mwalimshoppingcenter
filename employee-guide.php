<?php
$page_title = 'Employees Guide';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .eg-wrap { max-width: 780px; margin: 0.85rem auto; padding-bottom: 2rem; }
    .eg-hero {
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        color: #fff; border-radius: 16px; padding: 2rem 1.5rem; text-align: center;
        margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(37,99,235,0.25);
    }
    .eg-hero i { font-size: 3rem; margin-bottom: 0.75rem; }
    .eg-hero h1 { font-size: 1.5rem; margin-bottom: 0.4rem; }
    .eg-hero p { opacity: 0.9; font-size: 0.9rem; }

    .eg-card {
        background: #fff; border-radius: 14px; padding: 1.25rem;
        margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        border: 1px solid #EEF2F7;
    }
    .eg-card h2 {
        font-size: 1.05rem; color: #1E3A8A; margin-bottom: 0.75rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .eg-card h2 i {
        width: 32px; height: 32px; background: #DBEAFE; color: #1E40AF;
        border-radius: 8px; display: inline-flex; align-items: center;
        justify-content: center; font-size: 0.9rem;
    }
    .eg-card p, .eg-card li { font-size: 0.92rem; color: #334155; line-height: 1.6; }

    .eg-step { display: flex; gap: 0.85rem; padding: 0.85rem 0; border-bottom: 1px dashed #EEF2F7; }
    .eg-step:last-child { border-bottom: 0; }
    .eg-step-num {
        flex: 0 0 32px; height: 32px; background: #2563EB; color: #fff;
        border-radius: 50%; display: inline-flex; align-items: center;
        justify-content: center; font-weight: 700; font-size: 0.85rem;
    }
    .eg-step-body { flex: 1; }
    .eg-step-body strong { color: #0F172A; display: block; margin-bottom: 0.2rem; font-size: 0.95rem; }

    .eg-benefit { display: flex; gap: 0.75rem; padding: 0.6rem 0; }
    .eg-benefit i { color: #16A34A; font-size: 1.1rem; flex: 0 0 24px; padding-top: 0.15rem; }
    .eg-benefit strong { display: block; color: #0F172A; font-size: 0.92rem; }
    .eg-benefit span { color: #475569; font-size: 0.85rem; }

    .eg-tip {
        background: #FEF3C7; border-left: 4px solid #F59E0B;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #78350F; margin-top: 0.75rem;
    }
    .eg-tip i { color: #D97706; margin-right: 0.35rem; }

    .eg-example {
        background: #F0F9FF; border-left: 4px solid #0284C7;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #0C4A6E; margin-top: 0.5rem;
    }
    .eg-example strong { display: block; margin-bottom: 0.2rem; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="employees.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Employees Guide</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="employee-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="eg-wrap">

    <div class="eg-hero">
        <i class="fas fa-user-tie"></i>
        <h1>How the Employees Section Works</h1>
        <p>Record everyone who works for you — their contact, pay, and work schedule.</p>
    </div>

    <div class="eg-card">
        <h2><i class="fas fa-lightbulb"></i> What is an Employee Record?</h2>
        <p>
            An <strong>employee record</strong> is a digital profile of someone who works for you.
            It holds their <em>contact details</em>, <em>how much they're paid</em>,
            <em>when they work</em>, and <em>where they work</em>.
        </p>
        <p>
            Think of it as an ID card + payslip + schedule all in one place — easy to find anytime.
        </p>
    </div>

    <div class="eg-card">
        <h2><i class="fas fa-list-check"></i> What Information Do I Record?</h2>

        <div class="eg-step">
            <span class="eg-step-num">1</span>
            <div class="eg-step-body">
                <strong>Personal details</strong>
                Full name (required), phone number, email address, home address.
            </div>
        </div>

        <div class="eg-step">
            <span class="eg-step-num">2</span>
            <div class="eg-step-body">
                <strong>Work details</strong>
                Their role (e.g. Cashier, Salesperson, Cleaner), the shop they work in,
                and the date they started.
            </div>
        </div>

        <div class="eg-step">
            <span class="eg-step-num">3</span>
            <div class="eg-step-body">
                <strong>Payment details</strong>
                How they get paid — <em>Daily</em>, <em>Weekly</em>, or <em>Monthly</em> —
                the amount, and the payment method (Cash, M-Pesa, etc.).
            </div>
        </div>

        <div class="eg-step">
            <span class="eg-step-num">4</span>
            <div class="eg-step-body">
                <strong>Work schedule</strong>
                Which days they work and what time they start / finish.
                For example: Mon–Sat, 8:00 AM – 6:00 PM.
            </div>
        </div>

        <div class="eg-step">
            <span class="eg-step-num">5</span>
            <div class="eg-step-body">
                <strong>Status & notes</strong>
                Mark them Active or Inactive. Add any extra notes (e.g. holidays, warnings, bonuses).
            </div>
        </div>

        <div class="eg-example">
            <strong>📋 Example record:</strong>
            <em>Name:</em> John Mwangi<br>
            <em>Phone:</em> 0712 345 678<br>
            <em>Role:</em> Cashier<br>
            <em>Shop:</em> Mwalim Shopping Center — Main Branch<br>
            <em>Pay:</em> Monthly — 250,000 TZS via M-Pesa<br>
            <em>Schedule:</em> Mon–Sat, 8:00 AM – 6:00 PM<br>
            <em>Status:</em> Active
        </div>
    </div>

    <div class="eg-card">
        <h2><i class="fas fa-star"></i> Why It Helps Your Business</h2>

        <div class="eg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Know who works where</strong>
                <span>Every employee's role and shop in one place.</span>
            </div>
        </div>

        <div class="eg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Pay correctly and on time</strong>
                <span>Pay type and amount saved — no more guessing.</span>
            </div>
        </div>

        <div class="eg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Plan your week</strong>
                <span>See at a glance who works which days and hours.</span>
            </div>
        </div>

        <div class="eg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Emergency contacts ready</strong>
                <span>Call an employee in seconds if something happens.</span>
            </div>
        </div>

        <div class="eg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Clean records for tax</strong>
                <span>Salary and start dates ready for any report.</span>
            </div>
        </div>

        <div class="eg-tip">
            <i class="fas fa-lightbulb"></i>
            <strong>Tip:</strong> Mark an employee <em>Inactive</em> instead of deleting
            them when they leave — their history stays for your records.
        </div>
    </div>

    <div class="eg-card">
        <h2><i class="fas fa-recycle"></i> Recycle Bin — Safety Net</h2>
        <p>
            Deleting an employee doesn't remove them forever. They go into the
            <strong>Recycle Bin</strong>, where you can <em>Restore</em> or <em>Delete Forever</em>.
        </p>
        <p>
            Once permanently deleted, only a database backup can bring them back —
            so contact the developer if that ever happens.
        </p>
    </div>

    <div class="eg-card">
        <h2><i class="fas fa-circle-question"></i> Common Questions</h2>

        <p><strong>Can I record someone who works part-time?</strong><br>
        Yes — set their pay type (Daily) and work days to whatever they actually work.</p>

        <p><strong>What if the salary changes?</strong><br>
        Just tap <em>Edit</em> and update the amount. The old record is replaced.</p>

        <p><strong>Can one employee work in two shops?</strong><br>
        Yes — create two separate records, one per shop, so each has its own schedule.</p>

        <p><strong>Do I need a photo?</strong><br>
        Not required, but helpful for larger teams.</p>
    </div>

</div>

<div class="leo-bottom-actions">
    <a href="employees.php" class="leo-btn leo-btn--outline">BACK TO EMPLOYEES</a>
    <a href="employee-add.php" class="leo-btn leo-btn--primary">ADD AN EMPLOYEE</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>