<?php
$page_title = 'Mwalimushoppingcenter AI';
require_once __DIR__ . '/includes/header.php';
?>

<div class="leo-ai-header">
    <div class="leo-ai-header-top">
        <div class="leo-ai-header-left">
            <span class="leo-ai-avatar"><i class="fas fa-magic"></i></span>
            <span class="leo-ai-badge">Mwalimushoppingcenter AI</span>
        </div>
        <div class="leo-ai-header-right">
            <span class="leo-ai-online">
                <span class="leo-ai-online-dot"></span>
                Online
            </span>
            <a href="index.php" class="leo-ai-close"><i class="fas fa-times"></i></a>
        </div>
    </div>
    <div class="leo-ai-subtitle">Business assistant · App + website</div>
</div>

<div class="leo-ai-welcome">
    <div class="leo-ai-welcome-top">
        <span class="leo-ai-welcome-icon"><i class="fas fa-magic"></i></span>
        <div class="leo-ai-welcome-copy">
            <strong>Meet Mwalimushoppingcenter AI</strong>
            <span>Your shop guide for Mwalimushoppingcenter</span>
        </div>
    </div>
    <div class="leo-ai-welcome-body">I help you understand your business data and learn how to use the app and website: using the same names you see on screen (for example "Record Products").

I can share "Today's Summary", "Products List", and "Dues List" when your role allows.

I don't answer questions about people, celebrities, or anything outside your shop.</div>
</div>

<div class="leo-ai-topics-title">Quick topics</div>
<div class="leo-ai-topics">
    <button class="leo-ai-chip" onclick="sendMessage('What is Mwalimushoppingcenter?')">What is Mwalimushoppingcenter?</button>
    <button class="leo-ai-chip" onclick="sendMessage('How can Mwalimushoppingcenter help my business?')">How can Mwalimushoppingcenter help my business?</button>
    <button class="leo-ai-chip" onclick="sendMessage('How does POS work?')">How does POS work?</button>
    <button class="leo-ai-chip" onclick="sendMessage('Who is Mwalimushoppingcenter AI?')">Who is Mwalimushoppingcenter AI?</button>
    <button class="leo-ai-chip" onclick="sendMessage('What are subscription packages?')">What are subscription packages?</button>
    <button class="leo-ai-chip" onclick="sendMessage('What is blocked on the Free package?')">What is blocked on the Free package?</button>
    <button class="leo-ai-chip" onclick="sendMessage('How do I use Record Products?')">How do I use Record Products?</button>
    <button class="leo-ai-chip" onclick="sendMessage('How do I use Record Sales?')">How do I use Record Sales?</button>
    <button class="leo-ai-chip" onclick="sendMessage('How do I process a Return Sales?')">How do I process a Return Sales?</button>
    <button class="leo-ai-chip" onclick="sendMessage('How does prepaid work?')">How does prepaid work?</button>
    <button class="leo-ai-chip" onclick="sendMessage('How much are Today\u2019s Summary?')">How much are Today's Summary?</button>
    <button class="leo-ai-chip" onclick="sendMessage('Total sales all time')">Total sales all time</button>
    <button class="leo-ai-chip" onclick="sendMessage('Total purchases this month')">Total purchases this month</button>
    <button class="leo-ai-chip" onclick="sendMessage('Money collected this week')">Money collected this week</button>
    <button class="leo-ai-chip" onclick="sendMessage('Total discount all time')">Total discount all time</button>
    <button class="leo-ai-chip" onclick="sendMessage('How many transactions today?')">How many transactions today?</button>
    <button class="leo-ai-chip" onclick="sendMessage('Available balance today')">Available balance today</button>
    <button class="leo-ai-chip" onclick="sendMessage('What can I do on the website?')">What can I do on the website?</button>
</div>

<div class="leo-ai-composer">
    <input type="text" class="leo-ai-input" id="aiInput" placeholder="Message Mwalimushoppingcenter AI..." onkeypress="if(event.key==='Enter')sendMessage()">
    <button class="leo-ai-send" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
</div>

<script>
function sendMessage(text) {
    var input = document.getElementById('aiInput');
    var msg = text || input.value.trim();
    if (!msg) return;
    alert('You asked: ' + msg + '\n\n(AI backend coming soon)');
    if (!text) input.value = '';
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
