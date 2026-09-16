/* ================= LEO AI ASSISTANT ================= */
(function () {
  'use strict';

  // DOM Element Selectors
  var toggle = document.getElementById('aiToggle');
  var win = document.getElementById('aiWindow');
  var closeBtn = document.getElementById('aiClose');
  var body = document.getElementById('aiBody');
  var input = document.getElementById('aiInput');
  var sendBtn = document.getElementById('aiSend');

  if (!toggle || !win) return;

  var isOpen = false;
  var isLoading = false;

  // Suggested Quick Questions
  var QUICK = [
    { i: '📊', t: 'Mauzo ya leo', q: 'Mauzo ya leo?' },
    { i: '📅', t: 'Mauzo ya mwezi', q: 'Mauzo ya mwezi?' },
    { i: '💰', t: 'Jumla ya mauzo', q: 'Jumla ya mauzo?' },
    { i: '🏆', t: 'Bidhaa top', q: 'Bidhaa inayouza zaidi?' },
    { i: '⚠️', t: 'Stock ndogo', q: 'Stock ipi inapungua?' },
    { i: '📦', t: 'Idadi ya bidhaa', q: 'Nina bidhaa ngapi?' },
    { i: '💡', t: 'Ushauri', q: 'Nipe ushauri' }
  ];

  // Render Chat Message
  function addMsg(text, who) {
    var div = document.createElement('div');
    div.className = 'ai-msg ' + who;
    div.innerHTML = text
      .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
      .replace(/\n/g, '<br>');
    body.appendChild(div);
    body.scrollTop = body.scrollHeight;
    return div;
  }

  // Render Suggested Quick Question Buttons
  function addQuick() {
    var title = document.createElement('div');
    title.className = 'ai-quick-title';
    title.innerHTML = '💬 <strong>Maswali ya haraka:</strong>';
    body.appendChild(title);

    var wrap = document.createElement('div');
    wrap.className = 'ai-quick-btns';
    QUICK.forEach(function (item) {
      var b = document.createElement('button');
      b.innerHTML = item.i + ' ' + item.t;
      b.addEventListener('click', function () { handleSend(item.q); });
      wrap.appendChild(b);
    });
    body.appendChild(wrap);
    body.scrollTop = body.scrollHeight;
  }

  // Process and Send User Query to API Endpoint
  function handleSend(text) {
    text = (text || input.value).trim();
    if (!text || isLoading) return;
    
    input.value = '';
    addMsg(text, 'user');
    isLoading = true;
    if (sendBtn) sendBtn.disabled = true;

    var typing = addMsg('Leo AI anaangalia mfumo...', 'bot typing');

    fetch('api/ai.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ question: text })
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
      typing.remove();
      addMsg(data.answer, 'bot');
      addQuick();
    })
    .catch(function () {
      typing.remove();
      addMsg('Samahani, imefeli kupata taarifa za mfumo.', 'bot');
    })
    .finally(function () {
      isLoading = false;
      if (sendBtn) sendBtn.disabled = false;
      if (input) input.focus();
    });
  }

  // Event Listeners
  toggle.addEventListener('click', function () {
    isOpen = !isOpen;
    win.classList.toggle('open', isOpen);
    
    if (isOpen && body.children.length === 0) {
      addMsg('Habari! 👋 Mimi ni **Leo AI**.\n\nBonyeza swali hapa chini au uliza mwenyewe.', 'bot');
      addQuick();
    }
    if (isOpen && input) setTimeout(function () { input.focus(); }, 300);
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', function () {
      isOpen = false;
      win.classList.remove('open');
    });
  }

  if (sendBtn) sendBtn.addEventListener('click', function () { handleSend(); });
  
  if (input) {
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') handleSend();
    });
  }
})();