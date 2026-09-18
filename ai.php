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
            <span class="leo-ai-online"><span class="leo-ai-online-dot"></span>Online</span>
            <a href="index.php" class="leo-ai-close"><i class="fas fa-times"></i></a>
        </div>
    </div>
    <div class="leo-ai-subtitle">Business assistant · App + website</div>
</div>

<div class="leo-ai-welcome" id="welcomeCard">
    <div class="leo-ai-welcome-top">
        <span class="leo-ai-welcome-icon"><i class="fas fa-magic"></i></span>
        <div class="leo-ai-welcome-copy">
            <strong>Meet Mwalimushoppingcenter AI</strong>
            <span>Your shop guide</span>
        </div>
    </div>
    <div class="leo-ai-welcome-body">Naweza kukusaidia kujua:
• Mauzo ya leo / jumla
• Bidhaa zote na stock
• Wateja na madeni
• Matumizi na faida
• Miamala ya leo</div>
</div>

<div class="leo-ai-topics-title" id="topicsTitle">Quick topics</div>
<div class="leo-ai-topics" id="topicsList">
    <button class="leo-ai-chip" onclick="ask('Mauzo ya leo?')">Mauzo ya leo?</button>
    <button class="leo-ai-chip" onclick="ask('Mauzo yote?')">Mauzo yote?</button>
    <button class="leo-ai-chip" onclick="ask('Bidhaa zote?')">Bidhaa zote?</button>
    <button class="leo-ai-chip" onclick="ask('Bidhaa zenye stock ndogo?')">Low stock?</button>
    <button class="leo-ai-chip" onclick="ask('Madeni yote?')">Madeni?</button>
    <button class="leo-ai-chip" onclick="ask('Faida yangu?')">Faida?</button>
    <button class="leo-ai-chip" onclick="ask('Matumizi yote?')">Matumizi?</button>
    <button class="leo-ai-chip" onclick="ask('Wateja wangapi?')">Wateja?</button>
    <button class="leo-ai-chip" onclick="ask('Miamala ya leo?')">Miamala ya leo?</button>
    <button class="leo-ai-chip" onclick="ask('Salio linalopatikana?')">Salio?</button>
    <button class="leo-ai-chip" onclick="ask('Mwalimushoppingcenter ni nini?')">Ni nini?</button>
    <button class="leo-ai-chip" onclick="ask('Nisaidie')">Nisaidie</button>
</div>

<div class="leo-ai-messages" id="aiMessages"></div>

<div class="leo-ai-composer">
    <input type="text" class="leo-ai-input" id="aiInput" placeholder="Uliza swali lako..." onkeypress="if(event.key==='Enter')sendMessage()">
    <button class="leo-ai-send" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
</div>

<script>
function ask(question) {
    document.getElementById('aiInput').value = question;
    sendMessage();
}

function appendMessage(text, type) {
    var box = document.getElementById('aiMessages');
    var div = document.createElement('div');
    div.className = 'leo-ai-msg leo-ai-msg--' + type;

    var avatar = type === 'user'
        ? '<div class="leo-ai-msg-avatar"><i class="fas fa-user"></i></div>'
        : '<div class="leo-ai-msg-avatar"><i class="fas fa-magic"></i></div>';

    var formatted = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');

    div.innerHTML = avatar + '<div class="leo-ai-msg-bubble">' + formatted + '</div>';
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
}

function showTyping() {
    var box = document.getElementById('aiMessages');
    var div = document.createElement('div');
    div.className = 'leo-ai-msg leo-ai-msg--bot';
    div.id = 'typingIndicator';
    div.innerHTML = '<div class="leo-ai-msg-avatar"><i class="fas fa-magic"></i></div><div class="leo-ai-typing"><span></span><span></span><span></span></div>';
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
}

function hideTyping() {
    var t = document.getElementById('typingIndicator');
    if (t) t.remove();
}

function sendMessage() {
    var input = document.getElementById('aiInput');
    var q = input.value.trim();
    if (!q) return;

    // Ficha welcome + topics mara ya kwanza
    var w = document.getElementById('welcomeCard');
    var tt = document.getElementById('topicsTitle');
    var tl = document.getElementById('topicsList');
    if (w) w.style.display = 'none';
    if (tt) tt.style.display = 'none';
    if (tl) tl.style.display = 'none';

    appendMessage(q, 'user');
    input.value = '';
    showTyping();

    fetch('ai-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ question: q })
    })
    .then(function(r){ return r.json(); })
    .then(function(data){
        hideTyping();
        appendMessage(data.reply || 'Samahani, kuna tatizo.', 'bot');
    })
    .catch(function(){
        hideTyping();
        appendMessage('Kuna tatizo la mtandao. Jaribu tena.', 'bot');
    });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
