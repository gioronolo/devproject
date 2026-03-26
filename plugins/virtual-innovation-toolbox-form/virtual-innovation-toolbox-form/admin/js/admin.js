/* Virtual Innovation Toolbox Form – Admin JS */
(function ($) {
    'use strict';

    var cfg = window.VITF_Admin || {};
    var s   = cfg.settings || {};

    /* ----------------------------------------
       Helpers
    ---------------------------------------- */
    function el(tag, cls, html) {
        var e = document.createElement(tag);
        if (cls) e.className = cls;
        if (html !== undefined) e.innerHTML = html;
        return e;
    }

    function field(label, desc, control) {
        var row = el('div', 'vitf-field');
        var lbl = el('div', 'vitf-label');
        lbl.innerHTML = label;
        if (desc) lbl.innerHTML += '<small>' + desc + '</small>';
        row.appendChild(lbl);
        row.appendChild(control);
        return row;
    }

    function input(type, id, val, extra) {
        var i = el('input', 'vitf-input');
        i.type = type;
        i.id   = id;
        i.name = id;
        i.value = val || '';
        if (extra) Object.assign(i, extra);
        return i;
    }

    function select(id, opts, val) {
        var sel = el('select', 'vitf-select');
        sel.id = id;
        opts.forEach(function (o) {
            var opt = el('option', '', o.label);
            opt.value = o.value;
            if (o.value === val) opt.selected = true;
            sel.appendChild(opt);
        });
        return sel;
    }

    function toggleGroup(name, opts, val, multi) {
        var wrap = el('div', 'vitf-toggle-group');
        opts.forEach(function (o) {
            var lbl = el('label', 'vitf-toggle' + (o.value === val ? ' active' : ''));
            var inp = el('input');
            inp.type  = multi ? 'checkbox' : 'radio';
            inp.name  = name;
            inp.value = o.value;
            if (multi) {
                inp.checked = Array.isArray(val) && val.indexOf(o.value) > -1;
            } else {
                inp.checked = (o.value === val);
            }
            inp.addEventListener('change', function () {
                wrap.querySelectorAll('label').forEach(function (l) { l.classList.remove('active'); });
                if (this.checked) lbl.classList.add('active');
                if (typeof o.onChange === 'function') o.onChange(this.value, this.checked);
            });
            lbl.appendChild(inp);
            lbl.appendChild(document.createTextNode(o.label));
            wrap.appendChild(lbl);
        });
        return wrap;
    }

    /* ----------------------------------------
       Build UI
    ---------------------------------------- */
    function buildUI() {
        var app = document.getElementById('vitf-app');
        if (!app) return;
        app.innerHTML = '';

        // Header
        var hdr = el('div', 'vitf-header');
        hdr.innerHTML = '<div class="vitf-header-logo">VI</div><div><h1>Virtual Innovation Toolbox Form</h1><p>Configure your embedded form widget settings below.</p></div>';
        app.appendChild(hdr);

        /* ====== Card 1: General ====== */
        var card1 = el('div', 'vitf-card');
        card1.appendChild(Object.assign(el('p', 'vitf-card-title'), { textContent: 'General Settings' }));

        // Form ID
        var formIdInput = input('text', 'vitf_form_id', s.form_id || 'YduwAY4dBnaTjf7LmBMA');
        formIdInput.classList.add('vitf-input');
        formIdInput.style.maxWidth = '360px';
        card1.appendChild(field('Form ID', 'The unique ID from your GoHighLevel / Virtual Innovation form URL.', formIdInput));

        // Display type
        var displayWrap = el('div', 'vitf-toggle-group');
        ['popup', 'inline'].forEach(function (v) {
            var lbl = el('label', 'vitf-toggle' + (s.display_type === v ? ' active' : ''));
            var inp = el('input'); inp.type = 'radio'; inp.name = 'vitf_display_type'; inp.value = v; inp.checked = s.display_type === v;
            inp.addEventListener('change', function () {
                displayWrap.querySelectorAll('label').forEach(function (l) { l.classList.remove('active'); });
                lbl.classList.add('active');
                toggleSections(v);
            });
            lbl.appendChild(inp);
            lbl.appendChild(document.createTextNode(v === 'popup' ? '🪟 Popup' : '📄 Inline Embed'));
            displayWrap.appendChild(lbl);
        });
        card1.appendChild(field('Display Type', 'Choose how the form is presented to visitors.', displayWrap));

        app.appendChild(card1);

        /* ====== Card 2: Popup Settings ====== */
        var card2 = el('div', 'vitf-card' + (s.display_type !== 'popup' ? ' vitf-section-hidden' : ''));
        card2.id = 'vitf-card-popup';
        card2.appendChild(Object.assign(el('p', 'vitf-card-title'), { textContent: 'Popup Settings' }));

        // Position picker
        var posWrap = el('div', 'vitf-position-grid');
        var positions = [
            { value: 'top-left',      label: '↖ TL' },
            { value: 'center-top',    label: '↑ TC' },
            { value: 'top-right',     label: '↗ TR' },
            { value: 'center',        label: '⊕ Mid' },
            { value: '',              label: '' },
            { value: 'center',        label: '' },
            { value: 'bottom-left',   label: '↙ BL' },
            { value: 'center-bottom', label: '↓ BC' },
            { value: 'bottom-right',  label: '↘ BR' },
        ];
        positions.forEach(function (p) {
            if (!p.value && !p.label) { posWrap.appendChild(el('div')); return; }
            if (!p.value) { posWrap.appendChild(el('div')); return; }
            var btn = el('button', 'vitf-pos-btn' + (p.value === (s.popup_position || 'bottom-right') ? ' active' : ''), p.label);
            btn.type = 'button';
            btn.dataset.pos = p.value;
            btn.addEventListener('click', function () {
                posWrap.querySelectorAll('.vitf-pos-btn').forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
            });
            posWrap.appendChild(btn);
        });
        card2.appendChild(field('Position', 'Where the popup appears on screen.', posWrap));

        // Width / Height
        var sizeWrap = el('div', 'vitf-input-row');
        var wInput = input('number', 'vitf_popup_width', s.popup_width || 420, { min: 200, max: 1200, style: 'max-width:100px' });
        var hInput = input('number', 'vitf_popup_height', s.popup_height || 580, { min: 200, max: 900, style: 'max-width:100px' });
        sizeWrap.appendChild(Object.assign(el('span'), { textContent: 'W' }));
        sizeWrap.appendChild(wInput);
        sizeWrap.appendChild(Object.assign(el('span'), { textContent: 'px   H' }));
        sizeWrap.appendChild(hInput);
        sizeWrap.appendChild(Object.assign(el('span'), { textContent: 'px' }));
        var sizeNote = el('small', '', '(Responsive on mobile – snaps to full-width sheet)');
        sizeNote.style.color = '#94a3b8'; sizeNote.style.display = 'block'; sizeNote.style.marginTop = '4px';
        var sizeContainer = el('div');
        sizeContainer.appendChild(sizeWrap);
        sizeContainer.appendChild(sizeNote);
        card2.appendChild(field('Width / Height', 'Max dimensions for the popup panel.', sizeContainer));

        // Background
        var bgTypeWrap = el('div');
        var bgTypeToggle = el('div', 'vitf-toggle-group');
        var bgColorRow = el('div', 'vitf-input-row');
        bgColorRow.style.marginTop = '10px';
        var bgImageRow = el('div');
        bgImageRow.style.marginTop = '10px';

        ['color', 'image'].forEach(function (v) {
            var lbl = el('label', 'vitf-toggle' + (s.popup_bg_type === v ? ' active' : ''));
            var inp = el('input'); inp.type = 'radio'; inp.name = 'vitf_bg_type'; inp.value = v; inp.checked = s.popup_bg_type === v;
            inp.addEventListener('change', function () {
                bgTypeToggle.querySelectorAll('label').forEach(function (l) { l.classList.remove('active'); });
                lbl.classList.add('active');
                bgColorRow.style.display = v === 'color' ? 'flex' : 'none';
                bgImageRow.style.display = v === 'image' ? 'block' : 'none';
            });
            lbl.appendChild(inp);
            lbl.appendChild(document.createTextNode(v === 'color' ? '🎨 Color' : '🖼 Image'));
            bgTypeToggle.appendChild(lbl);
        });

        var colorPicker = input('color', 'vitf_bg_color', s.popup_bg_color || '#ffffff');
        colorPicker.style.minWidth = '44px'; colorPicker.style.width = '44px'; colorPicker.style.padding = '2px';
        bgColorRow.appendChild(colorPicker);
        bgColorRow.appendChild(Object.assign(el('span'), { textContent: 'Background color' }));
        bgColorRow.style.display = (s.popup_bg_type !== 'image') ? 'flex' : 'none';

        var imgUrlInput = input('url', 'vitf_bg_image', s.popup_bg_image || '');
        imgUrlInput.placeholder = 'https://...';
        imgUrlInput.style.maxWidth = '280px';
        var imgPreview = el('div', 'vitf-image-preview');
        imgPreview.innerHTML = '<img id="vitf-bg-img-preview" src="" alt="">';
        if (s.popup_bg_image) { imgPreview.style.display = 'block'; imgPreview.querySelector('img').src = s.popup_bg_image; }
        var uploadBtn = el('button', 'vitf-btn-secondary', '📁 Choose Image');
        uploadBtn.type = 'button';
        uploadBtn.style.marginTop = '8px';
        uploadBtn.addEventListener('click', function () {
            var frame = wp.media({ title: 'Select Background Image', button: { text: 'Use This Image' }, multiple: false });
            frame.on('select', function () {
                var att = frame.state().get('selection').first().toJSON();
                imgUrlInput.value = att.url;
                imgPreview.style.display = 'block';
                imgPreview.querySelector('img').src = att.url;
            });
            frame.open();
        });
        bgImageRow.appendChild(imgUrlInput);
        bgImageRow.appendChild(uploadBtn);
        bgImageRow.appendChild(imgPreview);
        bgImageRow.style.display = s.popup_bg_type === 'image' ? 'block' : 'none';

        bgTypeWrap.appendChild(bgTypeToggle);
        bgTypeWrap.appendChild(bgColorRow);
        bgTypeWrap.appendChild(bgImageRow);
        card2.appendChild(field('Background', 'Set popup background color or image.', bgTypeWrap));

        // Box shadow
        var shadowInput = input('text', 'vitf_box_shadow', s.popup_box_shadow || '0 8px 40px rgba(0,0,0,0.18)');
        shadowInput.placeholder = 'e.g. 0 8px 40px rgba(0,0,0,0.18)';
        card2.appendChild(field('Box Shadow', 'CSS box-shadow value for the popup.', shadowInput));

        // Trigger
        var triggerSel = select('vitf_trigger', [
            { value: 'on_load',   label: '⚡ On page load' },
            { value: 'on_scroll', label: '📜 On scroll' },
            { value: 'manual',    label: '🖱 Button click only' },
        ], s.popup_trigger || 'on_load');
        var scrollWrap = el('div');
        scrollWrap.style.marginTop = '8px';
        scrollWrap.style.display = (s.popup_trigger === 'on_scroll') ? 'flex' : 'none';
        scrollWrap.classList.add('vitf-input-row');
        var scrollInput = input('number', 'vitf_scroll_px', s.popup_scroll_px || 300, { min: 0, max: 9999, style: 'max-width:100px' });
        scrollWrap.appendChild(Object.assign(el('span'), { textContent: 'Show after scrolling' }));
        scrollWrap.appendChild(scrollInput);
        scrollWrap.appendChild(Object.assign(el('span'), { textContent: 'px down the page' }));
        triggerSel.addEventListener('change', function () {
            scrollWrap.style.display = this.value === 'on_scroll' ? 'flex' : 'none';
        });
        var triggerWrap = el('div');
        triggerWrap.appendChild(triggerSel);
        triggerWrap.appendChild(scrollWrap);
        card2.appendChild(field('Open Trigger', 'When should the popup appear?', triggerWrap));

        app.appendChild(card2);

        /* ====== Card 3: Visibility ====== */
        var card3 = el('div', 'vitf-card' + (s.display_type !== 'popup' ? ' vitf-section-hidden' : ''));
        card3.id = 'vitf-card-visibility';
        card3.appendChild(Object.assign(el('p', 'vitf-card-title'), { textContent: 'Visibility Rules' }));

        var showOnOpts = [
            { value: 'all',            label: '🌐 All pages' },
            { value: 'homepage',       label: '🏠 Homepage only' },
            { value: 'all_pages',      label: '📄 All pages (static)' },
            { value: 'selected_pages', label: '🔖 Selected pages' },
            { value: 'all_posts',      label: '📝 All posts' },
            { value: 'selected_posts', label: '✏️ Selected posts' },
        ];
        var pagesListWrap = el('div');
        pagesListWrap.id = 'vitf-pages-list-wrap';
        pagesListWrap.style.display = 'none';
        pagesListWrap.style.marginTop = '10px';
        var postsListWrap = el('div');
        postsListWrap.id = 'vitf-posts-list-wrap';
        postsListWrap.style.display = 'none';
        postsListWrap.style.marginTop = '10px';

        var showOnToggle = el('div', 'vitf-toggle-group');
        showOnOpts.forEach(function (o) {
            var lbl = el('label', 'vitf-toggle' + (o.value === (s.show_on || 'all') ? ' active' : ''));
            var inp = el('input'); inp.type = 'radio'; inp.name = 'vitf_show_on'; inp.value = o.value; inp.checked = o.value === (s.show_on || 'all');
            inp.addEventListener('change', function () {
                showOnToggle.querySelectorAll('label').forEach(function (l) { l.classList.remove('active'); });
                lbl.classList.add('active');
                pagesListWrap.style.display = this.value === 'selected_pages' ? 'block' : 'none';
                postsListWrap.style.display = this.value === 'selected_posts' ? 'block' : 'none';
                if (this.value === 'selected_pages' && !pagesListWrap.dataset.loaded) {
                    loadPostList('page', pagesListWrap, s.show_pages || []);
                }
                if (this.value === 'selected_posts' && !postsListWrap.dataset.loaded) {
                    loadPostList('post', postsListWrap, s.show_posts || []);
                }
            });
            lbl.appendChild(inp);
            lbl.appendChild(document.createTextNode(o.label));
            showOnToggle.appendChild(lbl);
        });

        var showOnWrap = el('div');
        showOnWrap.appendChild(showOnToggle);
        showOnWrap.appendChild(pagesListWrap);
        showOnWrap.appendChild(postsListWrap);
        card3.appendChild(field('Show On', 'Control which pages/posts display the popup.', showOnWrap));

        // Pre-load lists if needed
        if (s.show_on === 'selected_pages') {
            pagesListWrap.style.display = 'block';
            loadPostList('page', pagesListWrap, s.show_pages || []);
        }
        if (s.show_on === 'selected_posts') {
            postsListWrap.style.display = 'block';
            loadPostList('post', postsListWrap, s.show_posts || []);
        }

        app.appendChild(card3);

        /* ====== Card 4: Behavior ====== */
        var card4 = el('div', 'vitf-card' + (s.display_type !== 'popup' ? ' vitf-section-hidden' : ''));
        card4.id = 'vitf-card-behavior';
        card4.appendChild(Object.assign(el('p', 'vitf-card-title'), { textContent: 'Popup Behavior' }));

        // Close on submit
        var cbSubmit = el('input'); cbSubmit.type = 'checkbox'; cbSubmit.id = 'vitf_close_on_submit'; cbSubmit.checked = s.close_on_submit !== '0';
        var cbLbl = el('label', 'vitf-checkbox-label');
        cbLbl.appendChild(cbSubmit);
        cbLbl.appendChild(document.createTextNode('Disable & hide popup after form is submitted'));
        card4.appendChild(field('On Submit', 'Permanently hides popup once user submits the form.', cbLbl));

        // Reopen after X weeks
        var weeksWrap = el('div', 'vitf-input-row');
        var weeksInput = input('number', 'vitf_reopen_weeks', s.reopen_weeks || 7, { min: 1, max: 52, style: 'max-width:80px' });
        weeksWrap.appendChild(Object.assign(el('span'), { textContent: 'Re-show popup after' }));
        weeksWrap.appendChild(weeksInput);
        weeksWrap.appendChild(Object.assign(el('span'), { textContent: 'weeks when closed by user' }));
        card4.appendChild(field('Re-show After', 'After the user closes the popup, how many weeks before it appears again?', weeksWrap));

        app.appendChild(card4);

        /* ====== Card 5: Inline ====== */
        var card5 = el('div', 'vitf-card' + (s.display_type !== 'inline' ? ' vitf-section-hidden' : ''));
        card5.id = 'vitf-card-inline';
        card5.appendChild(Object.assign(el('p', 'vitf-card-title'), { textContent: 'Inline Embed' }));

        var scBox = el('div', 'vitf-shortcode-box', '[vitf_inline]');
        var cpyBtn = el('button', 'vitf-copy-btn', 'Copy');
        cpyBtn.type = 'button';
        cpyBtn.addEventListener('click', function () {
            navigator.clipboard.writeText('[vitf_inline]').then(function () {
                cpyBtn.textContent = 'Copied!';
                setTimeout(function () { cpyBtn.textContent = 'Copy'; }, 1800);
            });
        });
        scBox.appendChild(cpyBtn);
        var scNote = el('p', '', 'Paste this shortcode into any page or post where you want the form to appear inline. You can also override the form ID: <code>[vitf_inline form_id="YOUR_ID"]</code>');
        scNote.style.fontSize = '13px'; scNote.style.color = '#64748b'; scNote.style.marginTop = '8px';
        var scWrap = el('div');
        scWrap.appendChild(scBox);
        scWrap.appendChild(scNote);
        card5.appendChild(field('Shortcode', 'Use this shortcode to embed the form inline.', scWrap));

        app.appendChild(card5);

        /* ====== Save Button ====== */
        var saveCard = el('div', 'vitf-card');
        var saveWrap = el('div', 'vitf-save-wrap');
        var saveBtn = el('button', 'vitf-btn-save', 'Save Settings');
        saveBtn.type = 'button';
        var saveMsg = el('span', 'vitf-save-msg');
        saveBtn.addEventListener('click', function () { saveSettings(saveBtn, saveMsg); });
        saveWrap.appendChild(saveBtn);
        saveWrap.appendChild(saveMsg);
        saveCard.appendChild(saveWrap);
        app.appendChild(saveCard);
    }

    function loadPostList(postType, wrap, selected) {
        wrap.dataset.loaded = '1';
        wrap.innerHTML = '<span style="color:#94a3b8;font-size:13px;">Loading...</span>';
        $.post(cfg.ajax_url, {
            action: 'vitf_get_pages',
            nonce: cfg.nonce,
            post_type: postType
        }, function (res) {
            if (!res.success) { wrap.innerHTML = '<span style="color:red;font-size:13px;">Could not load.</span>'; return; }
            var list = el('div', 'vitf-post-list');
            res.data.forEach(function (p) {
                var lbl = el('label');
                var chk = el('input'); chk.type = 'checkbox'; chk.name = 'vitf_show_' + postType + 's[]'; chk.value = p.id;
                chk.checked = selected.indexOf(p.id) > -1 || selected.indexOf(String(p.id)) > -1;
                lbl.appendChild(chk);
                lbl.appendChild(document.createTextNode(' ' + p.title));
                list.appendChild(lbl);
            });
            wrap.innerHTML = '';
            wrap.appendChild(list);
        });
    }

    function toggleSections(type) {
        var popupSections = ['vitf-card-popup', 'vitf-card-visibility', 'vitf-card-behavior'];
        popupSections.forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            el.classList.toggle('vitf-section-hidden', type !== 'popup');
        });
        var inlineCard = document.getElementById('vitf-card-inline');
        if (inlineCard) inlineCard.classList.toggle('vitf-section-hidden', type !== 'inline');
    }

    function collectSettings() {
        var d = {};

        d.form_id        = val('vitf_form_id');
        d.display_type   = radVal('vitf_display_type');
        d.popup_position = (document.querySelector('.vitf-pos-btn.active') || {}).dataset?.pos || 'bottom-right';
        d.popup_width    = val('vitf_popup_width');
        d.popup_height   = val('vitf_popup_height');
        d.popup_bg_type  = radVal('vitf_bg_type');
        d.popup_bg_color = val('vitf_bg_color');
        d.popup_bg_image = val('vitf_bg_image');
        d.popup_box_shadow = val('vitf_box_shadow');
        d.popup_trigger  = val('vitf_trigger');
        d.popup_scroll_px = val('vitf_scroll_px');
        d.show_on        = radVal('vitf_show_on');
        d.show_pages     = checkVals('vitf_show_pages[]');
        d.show_posts     = checkVals('vitf_show_posts[]');
        d.close_on_submit = document.getElementById('vitf_close_on_submit')?.checked ? '1' : '0';
        d.reopen_weeks   = val('vitf_reopen_weeks');

        return d;
    }

    function val(id) {
        var e = document.getElementById(id);
        return e ? e.value : '';
    }

    function radVal(name) {
        var e = document.querySelector('input[name="' + name + '"]:checked');
        return e ? e.value : '';
    }

    function checkVals(name) {
        return Array.from(document.querySelectorAll('input[name="' + name + '"]:checked')).map(function (e) { return e.value; });
    }

    function saveSettings(btn, msg) {
        btn.disabled = true;
        btn.textContent = 'Saving…';
        msg.className = 'vitf-save-msg';
        msg.textContent = '';

        $.post(cfg.ajax_url, {
            action: 'vitf_save_settings',
            nonce: cfg.nonce,
            settings: collectSettings()
        }, function (res) {
            btn.disabled = false;
            btn.textContent = 'Save Settings';
            if (res.success) {
                msg.textContent = '✓ ' + res.data.message;
                msg.className = 'vitf-save-msg vitf-success';
            } else {
                msg.textContent = '✗ Save failed.';
                msg.className = 'vitf-save-msg vitf-error';
            }
            setTimeout(function () { msg.className = 'vitf-save-msg'; }, 3500);
        }).fail(function () {
            btn.disabled = false;
            btn.textContent = 'Save Settings';
            msg.textContent = '✗ Request failed.';
            msg.className = 'vitf-save-msg vitf-error';
        });
    }

    $(document).ready(buildUI);

})(jQuery);
