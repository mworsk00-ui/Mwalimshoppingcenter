<?php /* includes/leo-ui.php — Global Alerts, Confirm, Loading */ ?>

<style>
    /* ---- Modal overlay ---- */
    .leo-modal-backdrop {
        position: fixed; inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(2px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 1rem;
        animation: leoFadeIn 0.15s ease;
    }
    .leo-modal-backdrop.leo-open { display: flex; }

    @keyframes leoFadeIn { from { opacity: 0 } to { opacity: 1 } }
    @keyframes leoPop     { from { transform: scale(0.92); opacity: 0 } to { transform: scale(1); opacity: 1 } }

    /* ---- Modal box ---- */
    .leo-modal {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 400px;
        padding: 1.75rem 1.5rem 1.25rem;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        animation: leoPop 0.18s ease;
        font-family: inherit;
    }

    .leo-modal-icon {
        width: 72px; height: 72px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .leo-modal-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 0.4rem;
    }
    .leo-modal-text {
        font-size: 0.92rem;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 1.4rem;
        word-break: break-word;
    }

    /* ---- Actions bar: buttons aligned to the RIGHT ---- */
    .leo-modal-actions {
        display: flex;
        justify-content: flex-end;   /* <- pushes buttons to bottom-right */
        gap: 0.6rem;
    }
    .leo-modal-actions .leo-btn {
        flex: 0 0 auto;
        min-width: 90px;
        justify-content: center;
    }

    /* Color variants */
    .leo-modal--success .leo-modal-icon { background:#DCFCE7; color:#166534; }
    .leo-modal--error   .leo-modal-icon { background:#FEE2E2; color:#991B1B; }
    .leo-modal--warning .leo-modal-icon { background:#FEF3C7; color:#92400E; }
    .leo-modal--info    .leo-modal-icon { background:#DBEAFE; color:#1E40AF; }
    .leo-modal--confirm .leo-modal-icon { background:#FEF3C7; color:#92400E; }

    .leo-modal-btn-ok {
        background: var(--leo-primary, #2563eb);
        color: #fff;
        border: none;
        padding: 0.7rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.9rem;
    }
    .leo-modal-btn-ok:hover { filter: brightness(0.95); }

    .leo-modal-btn-cancel {
        background: #F1F5F9;
        color: #334155;
        border: 1px solid #E2E8F0;
        padding: 0.7rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.9rem;
    }
    .leo-modal-btn-cancel:hover { background: #E2E8F0; }

    /* ---- Loading overlay ---- */
    .leo-loading {
        position: fixed; inset: 0;
        background: rgba(255,255,255,0.75);
        backdrop-filter: blur(2px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        flex-direction: column;
        gap: 1rem;
    }
    .leo-loading.leo-open { display: flex; }

    .leo-loading-spinner {
        width: 48px; height: 48px;
        border: 4px solid #DBEAFE;
        border-top-color: var(--leo-primary, #2563eb);
        border-radius: 50%;
        animation: leoSpin 0.8s linear infinite;
    }
    @keyframes leoSpin { to { transform: rotate(360deg) } }

    .leo-loading-text {
        color: #1E293B;
        font-size: 0.9rem;
        font-weight: 600;
    }
</style>

<!-- Alert / Confirm modal -->
<div class="leo-modal-backdrop" id="leoModalBackdrop">
    <div class="leo-modal" id="leoModal" role="dialog" aria-modal="true">
        <div class="leo-modal-icon" id="leoModalIcon"><i class="fas fa-check"></i></div>
        <div class="leo-modal-title" id="leoModalTitle">Success</div>
        <div class="leo-modal-text" id="leoModalText">Operation completed.</div>
        <div class="leo-modal-actions" id="leoModalActions"></div>
    </div>
</div>

<!-- Loading overlay -->
<div class="leo-loading" id="leoLoading">
    <div class="leo-loading-spinner"></div>
    <div class="leo-loading-text" id="leoLoadingText">Please wait…</div>
</div>

<script>
(function () {
    'use strict';

    function init() {
        const backdrop   = document.getElementById('leoModalBackdrop');
        const modal      = document.getElementById('leoModal');
        const iconEl     = document.getElementById('leoModalIcon');
        const titleEl    = document.getElementById('leoModalTitle');
        const textEl     = document.getElementById('leoModalText');
        const actionsEl  = document.getElementById('leoModalActions');
        const loading    = document.getElementById('leoLoading');
        const loadingTxt = document.getElementById('leoLoadingText');

        if (!backdrop || !modal) {
            console.error('[LeoUI] Modal markup missing in DOM.');
            return;
        }

        const ICONS = {
            success: 'fa-check',
            error:   'fa-times',
            warning: 'fa-exclamation',
            info:    'fa-info',
            confirm: 'fa-question'
        };
        const TITLES = {
            success: 'Success',
            error:   'Error',
            warning: 'Warning',
            info:    'Notice',
            confirm: 'Are you sure?'
        };

        let autoCloseTimer = null;

        function clearAutoClose() {
            if (autoCloseTimer) {
                clearTimeout(autoCloseTimer);
                autoCloseTimer = null;
            }
        }

        /**
         * openModal(type, message, opts)
         * opts:
         *   title, okText, cancelText, onOk, onCancel
         *   showCancel: bool
         *   autoCloseMs: number|null   -> auto-dismiss after N ms (ignored for confirm)
         */
        function openModal(type, message, opts) {
            opts = opts || {};
            clearAutoClose();

            const kind = ICONS[type] ? type : 'info';
            const isConfirm = (kind === 'confirm');

            modal.className = 'leo-modal leo-modal--' + kind;
            iconEl.innerHTML = '<i class="fas ' + ICONS[kind] + '"></i>';
            titleEl.textContent = opts.title || TITLES[kind];
            textEl.textContent  = message || '';
            actionsEl.innerHTML = '';

            if (isConfirm || opts.showCancel) {
                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.className = 'leo-modal-btn-cancel';
                cancelBtn.textContent = opts.cancelText || 'Cancel';
                cancelBtn.onclick = function () { clearAutoClose(); close(); if (opts.onCancel) opts.onCancel(); };
                actionsEl.appendChild(cancelBtn);
            }

            const okBtn = document.createElement('button');
            okBtn.type = 'button';
            okBtn.className = 'leo-modal-btn-ok';
            okBtn.textContent = opts.okText || 'OK';
            okBtn.onclick = function () { clearAutoClose(); close(); if (opts.onOk) opts.onOk(); };
            actionsEl.appendChild(okBtn);

            backdrop.classList.add('leo-open');
            setTimeout(function () { okBtn.focus(); }, 50);

            /* ---- AUTO-DISMISS ----
             * Confirm dialogs NEVER auto-dismiss (safety).
             * Info popups auto-dismiss after 3s by default.
             */
            if (!isConfirm) {
                const ms = (typeof opts.autoCloseMs === 'number')
                    ? opts.autoCloseMs
                    : 3000;              // default 3 seconds
                if (ms > 0) {
                    autoCloseTimer = setTimeout(function () {
                        close();
                        if (opts.onOk) opts.onOk();   // treat like "OK was pressed"
                    }, ms);
                }
            }
        }

        function close() {
            clearAutoClose();
            backdrop.classList.remove('leo-open');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') close();
        });
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) close();
        });

        window.LeoAlert = {
            success: function (m, o) { openModal('success', m, o); },
            error:   function (m, o) { openModal('error',   m, o); },
            warning: function (m, o) { openModal('warning', m, o); },
            info:    function (m, o) { openModal('info',    m, o); },
            confirm: function (m, o) {
                o = o || {};
                o.showCancel = true;
                o.okText     = o.okText     || 'Yes, continue';
                o.cancelText = o.cancelText || 'Cancel';
                openModal('confirm', m, o);   // confirm never auto-closes
            }
        };

        window.LeoLoading = {
            show: function (text) { if (text) loadingTxt.textContent = text; loading.classList.add('leo-open'); },
            hide: function ()      { loading.classList.remove('leo-open'); }
        };

        /* ---- Auto-render flash messages ---- */
        if (window.__LEO_FLASH__ && Array.isArray(window.__LEO_FLASH__)) {
            window.__LEO_FLASH__.forEach(function (f, i) {
                setTimeout(function () { openModal(f.type, f.message); }, i * 250);
            });
            window.__LEO_FLASH__ = [];
        }

        /* ---- Auto-confirm on [data-confirm] ---- */
        document.addEventListener('click', function (e) {
            const el = e.target.closest('[data-confirm]');
            if (!el) return;
            e.preventDefault();
            const msg      = el.getAttribute('data-confirm');
            const okText   = el.getAttribute('data-confirm-ok')     || 'Yes, delete';
            const cancelTx = el.getAttribute('data-confirm-cancel') || 'Cancel';

            window.LeoAlert.confirm(msg, {
                okText: okText,
                cancelText: cancelTx,
                onOk: function () {
                    if (el.tagName === 'A' && el.href) {
                        window.location.href = el.href;
                    } else if (el.form) {
                        el.form.submit();
                    } else if (typeof el.click === 'function') {
                        el.removeAttribute('data-confirm');
                        el.click();
                    }
                }
            });
        });

        /* ---- Auto-loading on form submit ---- */
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form || form.hasAttribute('data-no-loading')) return;
            window.LeoLoading.show(form.getAttribute('data-loading') || 'Saving…');
        });

        console.log('[LeoUI] Ready.');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>