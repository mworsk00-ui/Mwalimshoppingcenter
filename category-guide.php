<?php
$page_title = 'Categories Guide';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .cg-wrap { max-width: 780px; margin: 0.85rem auto; padding-bottom: 2rem; }
    .cg-hero {
        background: linear-gradient(135deg, #2563EB, #1E40AF);
        color: #fff; border-radius: 16px; padding: 2rem 1.5rem; text-align: center;
        margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(37,99,235,0.25);
    }
    .cg-hero i { font-size: 3rem; margin-bottom: 0.75rem; }
    .cg-hero h1 { font-size: 1.5rem; margin-bottom: 0.4rem; }
    .cg-hero p { opacity: 0.9; font-size: 0.9rem; }

    .cg-card {
        background: #fff; border-radius: 14px; padding: 1.25rem;
        margin-bottom: 1rem; box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        border: 1px solid #EEF2F7;
    }
    .cg-card h2 {
        font-size: 1.05rem; color: #1E3A8A; margin-bottom: 0.75rem;
        display: flex; align-items: center; gap: 0.5rem;
    }
    .cg-card h2 i {
        width: 32px; height: 32px; background: #DBEAFE; color: #1E40AF;
        border-radius: 8px; display: inline-flex; align-items: center;
        justify-content: center; font-size: 0.9rem;
    }
    .cg-card p, .cg-card li { font-size: 0.92rem; color: #334155; line-height: 1.6; }

    .cg-step { display: flex; gap: 0.85rem; padding: 0.85rem 0; border-bottom: 1px dashed #EEF2F7; }
    .cg-step:last-child { border-bottom: 0; }
    .cg-step-num {
        flex: 0 0 32px; height: 32px; background: #2563EB; color: #fff;
        border-radius: 50%; display: inline-flex; align-items: center;
        justify-content: center; font-weight: 700; font-size: 0.85rem;
    }
    .cg-step-body { flex: 1; }
    .cg-step-body strong { color: #0F172A; display: block; margin-bottom: 0.2rem; font-size: 0.95rem; }

    .cg-benefit { display: flex; gap: 0.75rem; padding: 0.6rem 0; }
    .cg-benefit i { color: #16A34A; font-size: 1.1rem; flex: 0 0 24px; padding-top: 0.15rem; }
    .cg-benefit strong { display: block; color: #0F172A; font-size: 0.92rem; }
    .cg-benefit span { color: #475569; font-size: 0.85rem; }

    .cg-tip {
        background: #FEF3C7; border-left: 4px solid #F59E0B;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #78350F; margin-top: 0.75rem;
    }
    .cg-tip i { color: #D97706; margin-right: 0.35rem; }

    .cg-example {
        background: #F0F9FF; border-left: 4px solid #0284C7;
        padding: 0.85rem 1rem; border-radius: 8px;
        font-size: 0.88rem; color: #0C4A6E; margin-top: 0.5rem;
    }
    .cg-example strong { display: block; margin-bottom: 0.2rem; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="categories.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Categories Guide</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="category-add.php" class="leo-save-btn"
           style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="cg-wrap">

    <div class="cg-hero">
        <i class="fas fa-list"></i>
        <h1>How Product Categories Work</h1>
        <p>Group similar products together — faster to find, easier to report.</p>
    </div>

    <div class="cg-card">
        <h2><i class="fas fa-lightbulb"></i> What is a Category?</h2>
        <p>
            A <strong>category</strong> is simply a <em>group name</em> for products
            that belong together. Instead of having one long list of products, you
            organise them into sections.
        </p>
        <p>
            It's like a supermarket: rice, sugar, and flour go under <em>Food</em>;
            soda, water, and juice under <em>Beverages</em>.
        </p>
    </div>

    <div class="cg-card">
        <h2><i class="fas fa-list-check"></i> How to Use It</h2>

        <div class="cg-step">
            <span class="cg-step-num">1</span>
            <div class="cg-step-body">
                <strong>Add a category</strong>
                Tap <em>ADD</em> — give it a name (e.g. "Food", "Beverages", "Electronics")
                and an optional description. Save.
            </div>
        </div>

        <div class="cg-step">
            <span class="cg-step-num">2</span>
            <div class="cg-step-body">
                <strong>Assign products to it</strong>
                When adding or editing a product, choose the category from a dropdown.
            </div>
        </div>

        <div class="cg-step">
            <span class="cg-step-num">3</span>
            <div class="cg-step-body">
                <strong>Filter by category</strong>
                On the product list, pick a category to see only that group.
            </div>
        </div>

        <div class="cg-step">
            <span class="cg-step-num">4</span>
            <div class="cg-step-body">
                <strong>Mark as Inactive</strong>
                If you don't use a category anymore, mark it Inactive instead of deleting
                — old products keep their link.
            </div>
        </div>

        <div class="cg-step">
            <span class="cg-step-num">5</span>
            <div class="cg-step-body">
                <strong>Delete safely</strong>
                Deleting a category moves it to the <strong>Recycle Bin</strong> — you can
                restore it if needed.
            </div>
        </div>

        <div class="cg-example">
            <strong>📋 Example categories:</strong>
            • Food &amp; Groceries — Rice, Maize flour, Sugar, Cooking oil<br>
            • Beverages — Soda, Water, Juice, Beer<br>
            • Electronics — Phones, Chargers, Cables<br>
            • Household — Soap, Detergent, Brooms<br>
            • Stationery — Pens, Books, Exercise books
        </div>
    </div>

    <div class="cg-card">
        <h2><i class="fas fa-star"></i> Why It Helps Your Business</h2>

        <div class="cg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Find products faster</strong>
                <span>No more scrolling through a long list — filter by category.</span>
            </div>
        </div>

        <div class="cg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Cleaner reports</strong>
                <span>See sales, stock, and profit per category.</span>
            </div>
        </div>

        <div class="cg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Spot what sells</strong>
                <span>Know which category brings the most money.</span>
            </div>
        </div>

        <div class="cg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Faster stocktaking</strong>
                <span>Count and adjust section by section.</span>
            </div>
        </div>

        <div class="cg-benefit">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Better customer experience</strong>
                <span>Customers find what they want easily.</span>
            </div>
        </div>

        <div class="cg-tip">
            <i class="fas fa-lightbulb"></i>
            <strong>Tip:</strong> Keep categories <em>broad</em>. Instead of "Rice (5kg)",
            "Rice (10kg)", just use "Food". You can also add more detail in the product name.
        </div>
    </div>

    <div class="cg-card">
        <h2><i class="fas fa-recycle"></i> Recycle Bin — Safety Net</h2>
        <p>
            Deleting a category doesn't remove it forever. It goes into the
            <strong>Recycle Bin</strong>, where you can <em>Restore</em> or <em>Delete Forever</em>.
        </p>
        <p>
            Once permanently deleted, only a database backup can bring it back —
            so contact the developer if that ever happens.
        </p>
    </div>

    <div class="cg-card">
        <h2><i class="fas fa-circle-question"></i> Common Questions</h2>

        <p><strong>Can one product be in two categories?</strong><br>
        Not currently — each product belongs to one category. But you can always
        add a second product entry if needed.</p>

        <p><strong>What if I delete a category that has products?</strong><br>
        The products stay, but they lose their category link (become "Uncategorised").</p>

        <p><strong>Do I need categories?</strong><br>
        No, but they help a lot once you have more than ~10 products.</p>

        <p><strong>Can I reorder categories?</strong><br>
        Not yet — they list alphabetically. Reordering can be added later.</p>
    </div>

</div>

<div class="leo-bottom-actions">
    <a href="categories.php" class="leo-btn leo-btn--outline">BACK TO CATEGORIES</a>
    <a href="category-add.php" class="leo-btn leo-btn--primary">ADD A CATEGORY</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>