/* VI Form Embed Toolbox – Popup JS v1.4 */
(function () {
    'use strict';

    var cfg         = window.VITF_Config || {};
    var trigger     = cfg.trigger      || 'on_load';
    var scrollPx    = parseInt(cfg.scroll_px) || 300;
    var closeSubmit = cfg.close_submit === '1';
    var reopenDays  = cfg.reopen_days;
    var trigSel     = cfg.trigger_selector  || '';
    var trigSelType = cfg.trigger_sel_type  || 'id';
    var position    = cfg.position || 'bottom-right';

    var KEY_CLOSED    = 'vitf_closed_at';
    var KEY_SUBMITTED = 'vitf_submitted';

    var wrap    = null;
    var overlay = null;
    var shown   = false;
    var fired   = false;

    /* ── Suppression ── */
    function isSuppressed() {
        if (localStorage.getItem(KEY_SUBMITTED) === '1') return true;
        if (reopenDays === '-1' || parseInt(reopenDays) < 0) return false;
        var closedAt = localStorage.getItem(KEY_CLOSED);
        if (!closedAt) return false;
        var diffDays = (Date.now() - parseInt(closedAt, 10)) / 86400000;
        if (diffDays < (parseInt(reopenDays, 10) || 0)) return true;
        localStorage.removeItem(KEY_CLOSED);
        return false;
    }

    /* ── Resolve the "resting" transform for center positions ──
       The inline style already has e.g. transform:translate(-50%,-50%)
       We read it and store in --vitf-pos-transform so the animation
       CSS can compose on top of it.
    ── */
    function applyPositionTransform() {
        if (!wrap) return;
        // Read the inline style transform set by PHP
        var inlineTransform = wrap.style.transform || 'none';
        // Store it as a CSS custom property on the element
        wrap.style.setProperty('--vitf-pos-transform', inlineTransform);
        // Now clear the inline transform so CSS controls it
        wrap.style.transform = '';
    }

    /* ── Show ── */
    function showPopup() {
        if (!wrap || isSuppressed()) return;
        if (overlay) {
            overlay.style.display = 'block';
            requestAnimationFrame(function () {
                overlay.classList.add('vitf-visible');
            });
        }
        requestAnimationFrame(function () {
            wrap.classList.add('vitf-visible');
        });
        shown = true;
    }

    /* ── Hide ── */
    function hidePopup() {
        if (!wrap) return;
        wrap.classList.remove('vitf-visible');
        if (overlay) {
            overlay.classList.remove('vitf-visible');
            setTimeout(function () {
                if (!shown) overlay.style.display = 'none';
            }, 400);
        }
        shown = false;
    }

    /* ── Close (with suppression storage) ── */
    function onClose() {
        if (reopenDays !== '-1' && parseInt(reopenDays) >= 0) {
            localStorage.setItem(KEY_CLOSED, Date.now().toString());
        }
        hidePopup();
    }

    /* ── Submit listener ── */
    function listenForSubmit() {
        if (!closeSubmit) return;
        window.addEventListener('message', function (e) {
            try {
                var data = typeof e.data === 'string' ? JSON.parse(e.data) : e.data;
                if (data && (
                    data.type === 'form_submitted' ||
                    data.event === 'form_submitted' ||
                    data.type === 'FORM_SUBMITTED' ||
                    (data.formId && data.submitted)
                )) {
                    localStorage.setItem(KEY_SUBMITTED, '1');
                    hidePopup();
                }
            } catch (err) {}
        });
    }

    /* ── External element trigger ── */
    function bindExternalTriggers() {
        if (!trigSel) return;
        var selector = trigSelType === 'id' ? '#' + trigSel : '.' + trigSel;
        document.querySelectorAll(selector).forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                shown ? hidePopup() : forceShow();
            });
        });
    }

    function forceShow() {
        if (!wrap) return;
        if (overlay) {
            overlay.style.display = 'block';
            requestAnimationFrame(function () { overlay.classList.add('vitf-visible'); });
        }
        requestAnimationFrame(function () { wrap.classList.add('vitf-visible'); });
        shown = true;
    }

    /* ── Auto trigger ── */
    function attachTrigger() {
        if (trigger === 'manual') return;
        if (isSuppressed()) return;

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
        }
    }

    /* ── Init ── */
    document.addEventListener('DOMContentLoaded', function () {
        wrap    = document.getElementById('vitf-popup-wrap');
        overlay = document.getElementById('vitf-overlay');

        if (!wrap) return;

        // Move inline transform to CSS var so animations compose correctly
        applyPositionTransform();

        // Close button — only way to close
        var closeBtn = document.getElementById('vitf-close');
        if (closeBtn) closeBtn.addEventListener('click', onClose);

        // NO overlay click handler — clicking outside does NOT close popup

        listenForSubmit();
        bindExternalTriggers();
        attachTrigger();
    });
})();
