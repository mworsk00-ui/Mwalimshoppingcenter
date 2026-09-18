<?php $current_period = $_GET['period'] ?? 'today'; ?>
<div class="leo-period-wrap">
    <button type="button" class="leo-period-btn" onclick="togglePeriodMenu(this)">
        <span id="periodLabel"><?php
            $labels = ['today'=>'Today','yesterday'=>'Yesterday','this_week'=>'This Week','last_week'=>'Last Week','this_month'=>'This Month','last_month'=>'Last Month','this_year'=>'This Year'];
            echo $labels[$current_period] ?? 'Today';
        ?></span>
        <i class="fas fa-chevron-down arrow"></i>
    </button>
    <div class="leo-period-menu">
        <?php foreach ($labels as $key => $name): ?>
        <a href="?period=<?php echo $key; ?>" class="leo-period-item <?php echo ($current_period === $key) ? 'active' : ''; ?>">
            <span class="check"><i class="fas fa-check"></i></span> <?php echo $name; ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<script>
function togglePeriodMenu(btn) {
    var menu = btn.nextElementSibling;
    document.querySelectorAll('.leo-period-menu').forEach(function(m){ if (m !== menu) m.classList.remove('show'); });
    menu.classList.toggle('show');
}
document.addEventListener('click', function(e){
    if (!e.target.closest('.leo-period-wrap')) {
        document.querySelectorAll('.leo-period-menu').forEach(function(m){ m.classList.remove('show'); });
    }
});
</script>
