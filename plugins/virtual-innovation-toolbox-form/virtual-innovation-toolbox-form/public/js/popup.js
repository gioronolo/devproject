/* Virtual Innovation Toolbox Form – Popup JS */
(function () {
    'use strict';

    var cfg      = window.VITF_Config || {};
    var trigger  = cfg.trigger      || 'on_load';
    var scrollPx = parseInt(cfg.scroll_px)  || 300;
    var closeSubmit = cfg.close_submit === '1';
    var reopenWeeks = parseInt(cfg.reopen_weeks) || 7;
    var formId   = cfg.form_id || '';

    var STORAGE_KEY_CLOSED    = 'vitf_closed_at';
    var STORAGE_KEY_SUBMITTED = 'vitf_submitted';

    var wrap    = null;
    var btn     = null;
    var shown   = false;
    var fired   = false;

    function isClosed() {
        // Permanent suppress after submit
        if (localStorage.getItem(STORAGE_KEY_SUBMITTED) === '1') return true;

        // Temporary suppress after close
        var closedAt = localStorage.getItem(STORAGE_KEY_CLOSED);
        if (closedAt) {
            var diff = Date.now() - parseInt(closedAt, 10);
            var weeks = diff / (1000 * 60 * 60 * 24 * 7);
            if (weeks < reopenWeeks) return true;
            // Expired – clear
            localStorage.removeItem(STORAGE_KEY_CLOSED);
        }
        return false;
    }

    function showPopup() {
        if (!wrap || isClosed()) return;
        wrap.classList.remove('vitf-hidden');
        wrap.classList.add('vitf-visible');
        if (btn) btn.classList.add('vitf-hidden');
        shown = true;
    }

    function hidePopup() {
        if (!wrap) return;
        wrap.classList.remove('vitf-visible');
        wrap.classList.add('vitf-hidden');
        if (btn) btn.classList.remove('vitf-hidden');
        shown = false;
    }

    function onClose() {
        localStorage.setItem(STORAGE_KEY_CLOSED, Date.now().toString());
        hidePopup();
    }

    function listenForSubmit() {
        if (!closeSubmit) return;
        // Listen for postMessage from iframe indicating form submit
        window.addEventListener('message', function (e) {
            try {
                var data = typeof e.data === 'string' ? JSON.parse(e.data) : e.data;
                if (
                    data &&
                    (data.type === 'form_submitted' ||
                     data.event === 'form_submitted' ||
                     (data.formId && data.submitted))
                ) {
                    localStorage.setItem(STORAGE_KEY_SUBMITTED, '1');
                    hidePopup();
                    if (btn) btn.style.display = 'none';
                }
            } catch (err) {}
        });
    }

    function attachTrigger() {
        if (isClosed()) return;

        if (trigger === 'on_load') {
            setTimeout(showPopup, 600);
            return;
        }

        if (trigger === 'on_scroll') {
            var handler = function () {
                if (fired) return;
                var scrolled = window.scrollY || document.documentElement.scrollTop;
                if (scrolled >= scrollPx) {
                    fired = true;
                    window.removeEventListener('scroll', handler);
                    showPopup();
                }
            };
            window.addEventListener('scroll', handler, { passive: true });
            return;
        }

        // Fallback – manual (trigger button only)
    }

    document.addEventListener('DOMContentLoaded', function () {
        wrap = document.getElementById('vitf-popup-wrap');
        btn  = document.getElementById('vitf-trigger-btn');

        if (!wrap) return;

        // Close button
        var closeBtn = document.getElementById('vitf-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', onClose);
        }

        // Trigger button (manual open)
        if (btn) {
            btn.addEventListener('click', function () {
                if (shown) {
                    hidePopup();
                } else {
                    // Clear closed state so button can always reopen
                    showPopup();
                }
            });

            // Hide trigger btn if permanently suppressed
            if (localStorage.getItem(STORAGE_KEY_SUBMITTED) === '1') {
                btn.style.display = 'none';
            }
        }

        listenForSubmit();
        attachTrigger();
    });
})();
