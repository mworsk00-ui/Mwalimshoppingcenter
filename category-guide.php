<?php
$page_title = 'Categories Guide';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/header.php';
?>

<style>
    .cg-hero { background: linear-gradient(135deg,#2563EB,#1E40AF); color:#fff; border-radius:16px; padding:2rem 1.5rem; text-align:center; margin:0.85rem; box-shadow:0 8px 24px rgba(37,99,235,0.25); }
    .cg-hero i { font-size:3rem; margin-bottom:0.75rem; }
    .cg-hero h1 { font-size:1.5rem; margin-bottom:0.4rem; }
    .cg-hero p { opacity:0.9; font-size:0.9rem; }
    .cg-card { background:#fff; border-radius:14px; padding:1.25rem; margin:0.85rem; box-shadow:0 2px 10px rgba(15,23,42,0.05); border:1px solid #EEF2F7; }
    .cg-card h2 { font-size:1.05rem; color:#1E3A8A; margin-bottom:0.75rem; display:flex; align-items:center; gap:0.5rem; }
    .cg-card h2 i { width:32px; height:32px; background:#DBEAFE; color:#1E40AF; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:0.9rem; }
    .cg-card p, .cg-card li { font-size:0.92rem; color:#334155; line-height:1.6; }
    .cg-step { display:flex; gap:0.85rem; padding:0.85rem 0; border-bottom:1px dashed #EEF2F7; }
    .cg-step:last-child { border-bottom:0; }
    .cg-step-num { flex:0 0 32px; height:32px; background:#2563EB; color:#fff; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:0.85rem; }
    .cg-step-body { flex:1; }
    .cg-step-body strong { color:#0F172A; display:block; margin-bottom:0.2rem; font-size:0.95rem; }
</style>

<header class="leo-page-header">
    <div class="leo-page-header-left">
        <a href="categories.php" class="leo-back-btn"><i class="fas fa-chevron-left"></i></a>
        <span class="leo-page-header-title">Categories Guide</span>
    </div>
    <div class="leo-page-header-actions">
        <a href="category-add.php" class="leo-save-btn" style="text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="fas fa-plus"></i> ADD
        </a>
    </div>
</header>

<div class="cg-hero">
    <i class="fas fa-list"></i>
    <h1>How Product Categories Work</h1>
    <p>Group similar products together — faster to find, easier to report.</p>
</div>

<div class="cg-card">
    <h2><i class="fas fa-lightbulb"></i> What is a Category?</h2>
    <p>A <strong>category</strong> is a group name for products that belong together. Instead of one long list, you organize them into sections.</p>
    <p>It's like a supermarket: rice, sugar, and flour go under <em>Food</em>; soda, water, and juice under <em>Beverages</em>.</p>
</div>

<div class="cg-card">
    <h2><i class="fas fa-list-check"></i> How to Use It</h2>
    <div class="cg-step"><span class="cg-step-num">1</span><div class="cg-step-body"><strong>Add a category</strong>Tap <em>ADD</em> — give it a name and optional description. Save.</div></div>
    <div class="cg-step"><span class="cg-step-num">2</span><div class="cg-step-body"><strong>Assign products</strong>When adding/editing a product, choose the category from a dropdown.</div></div>
    <div class="cg-step"><span class="cg-step-num">3</span><div class="cg-step-body"><strong>Filter by category</strong>On the product list, pick a category to see only that group.</div></div>
    <div class="cg-step"><span class="cg-step-num">4</span><div class="cg-step-body"><strong>Mark as Inactive</strong>If you don't use a category anymore, mark it Inactive instead of deleting.</div></div>
    <div class="cg-step"><span class="cg-step-num">5</span><div class="cg-step-body"><strong>Delete safely</strong>Deleting moves to the <strong>Recycle Bin</strong> — you can restore it if needed.</div></div>
</div>

<div class="leo-bottom-actions">
    <a href="categories.php" class="leo-btn leo-btn--outline">BACK TO CATEGORIES</a>
    <a href="category-add.php" class="leo-btn leo-btn--primary">ADD A CATEGORY</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
