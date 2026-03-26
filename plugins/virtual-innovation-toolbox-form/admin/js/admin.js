/* VI Form Embed Toolbox – Admin JS v1.3 */
(function ($) {
    'use strict';

    var cfg = window.VITF_Admin || {};
    var s   = cfg.settings || {};

    /* ══════════════════════════════════════
       DOM HELPERS
    ══════════════════════════════════════ */
    function mk(tag, cls, html) {
        var e = document.createElement(tag);
        if (cls) e.className = cls;
        if (html !== undefined) e.innerHTML = html;
        return e;
    }

    function inp(type, id, val, attrs) {
        var e = mk('input', 'vitf-input');
        e.type = type; e.id = id; e.name = id;
        e.value = val !== undefined ? String(val) : '';
        if (attrs) Object.keys(attrs).forEach(function(k) {
            if (k === 'style') e.style.cssText = attrs[k];
            else e[k] = attrs[k];
        });
        return e;
    }

    function sel(id, opts, cur) {
        var e = mk('select', 'vitf-select');
        e.id = id;
        opts.forEach(function(o) {
            var opt = mk('option', '', o.label);
            opt.value = o.value;
            opt.selected = o.value === String(cur);
            e.appendChild(opt);
        });
        return e;
    }

    function field(labelTxt, descTxt, ctrl) {
        var w = mk('div', 'vitf-field');
        var l = mk('label', 'vitf-label', labelTxt);
        l.htmlFor = ctrl && ctrl.id ? ctrl.id : '';
        if (descTxt) l.innerHTML += '<small>' + descTxt + '</small>';
        w.appendChild(l);
        w.appendChild(ctrl);
        return w;
    }

    function radioGroup(name, opts, cur, onChange) {
        var wrap = mk('div', 'vitf-toggle-group');
        opts.forEach(function(o) {
            var lbl = mk('label', 'vitf-toggle' + (String(o.value) === String(cur) ? ' active' : ''));
            var r = mk('input'); r.type = 'radio'; r.name = name; r.value = o.value; r.checked = String(o.value) === String(cur);
            r.addEventListener('change', function() {
                wrap.querySelectorAll('label').forEach(function(l) { l.classList.remove('active'); });
                lbl.classList.add('active');
                if (onChange) onChange(o.value);
            });
            lbl.appendChild(r); lbl.appendChild(document.createTextNode(o.label));
            wrap.appendChild(lbl);
        });
        return wrap;
    }

    /* Simple color swatch + hex label */
    function colorSwatch(id, val) {
        val = val || '#000000';
        var wrap = mk('div', 'vitf-color-wrap');
        var sw   = mk('div', 'vitf-color-swatch');
        var prev = mk('div', 'vitf-color-swatch-preview');
        prev.style.background = val;
        var ci = mk('input'); ci.type = 'color'; ci.id = id; ci.name = id; ci.value = val;
        var hex = mk('span', 'vitf-color-hex', val);
        ci.addEventListener('input', function() { prev.style.background = this.value; hex.textContent = this.value; });
        sw.appendChild(prev); sw.appendChild(ci);
        wrap.appendChild(sw); wrap.appendChild(hex);
        return wrap;
    }

    /* Overlay: color picker + opacity slider → outputs rgba */
    function parseOverlay(rgba) {
        rgba = rgba || 'rgba(0,0,0,0)';
        var m = rgba.match(/rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)(?:\s*,\s*([0-9.]+))?\s*\)/);
        if (m) {
            var r = parseInt(m[1]), g = parseInt(m[2]), b = parseInt(m[3]);
            var a = m[4] !== undefined ? parseFloat(m[4]) : 1;
            return { hex: rgbToHex(r,g,b), opacity: Math.round(a * 100) };
        }
        return { hex: '#000000', opacity: 0 };
    }

    function rgbToHex(r,g,b) {
        return '#' + [r,g,b].map(function(v){ return ('0'+v.toString(16)).slice(-2); }).join('');
    }

    function hexToRgb(hex) {
        return { r: parseInt(hex.slice(1,3),16), g: parseInt(hex.slice(3,5),16), b: parseInt(hex.slice(5,7),16) };
    }

    function buildOverlayControl(curVal) {
        var parsed = parseOverlay(curVal);
        var wrap   = mk('div', 'vitf-overlay-wrap');

        /* Row 1: color picker */
        var row1 = mk('div', 'vitf-overlay-row');
        var sw   = mk('div', 'vitf-overlay-color-swatch');
        var prev = mk('div', 'vitf-overlay-color-preview');
        prev.style.background = 'rgba(' + (function(){ var rgb=hexToRgb(parsed.hex); return rgb.r+','+rgb.g+','+rgb.b+','+parsed.opacity/100; })() + ')';
        var ci = mk('input'); ci.type = 'color'; ci.value = parsed.hex;
        sw.appendChild(prev); sw.appendChild(ci);
        var colorLbl = mk('span', '', 'Overlay color');
        colorLbl.style.cssText = 'font-size:12.5px;color:#64748b;';
        row1.appendChild(sw); row1.appendChild(colorLbl);

        /* Row 2: opacity slider */
        var row2 = mk('div', 'vitf-overlay-row');
        row2.style.marginTop = '8px';
        var slider = mk('input', 'vitf-range');
        slider.type = 'range'; slider.min = 0; slider.max = 100; slider.value = parsed.opacity;
        slider.id = 'vitf_overlay_opacity';
        slider.style.cssText = '--range-pct:' + parsed.opacity + '%; flex:1;';
        var opLbl = mk('span', 'vitf-opacity-label', parsed.opacity + '%');
        row2.appendChild(slider); row2.appendChild(opLbl);

        /* hidden field stores final rgba */
        var hidden = mk('input'); hidden.type = 'hidden'; hidden.id = 'vitf_overlay_color'; hidden.name = 'vitf_overlay_color'; hidden.value = curVal || 'rgba(0,0,0,0)';

        function update() {
            var rgb = hexToRgb(ci.value);
            var op  = parseFloat((parseInt(slider.value)/100).toFixed(2));
            hidden.value = 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+op+')';
            prev.style.background = hidden.value;
            slider.style.setProperty('--range-pct', slider.value + '%');
            opLbl.textContent = slider.value + '%';
        }

        ci.addEventListener('input', update);
        slider.addEventListener('input', update);

        var note = mk('p', 'vitf-note', 'Dims the page behind the popup. Opacity 0 = no overlay. Click overlay to close popup.');

        wrap.appendChild(row1); wrap.appendChild(row2); wrap.appendChild(note); wrap.appendChild(hidden);
        return wrap;
    }

    /* ══════════════════════════════════════
       CARD HELPER
    ══════════════════════════════════════ */
    function card(icon, title, cls) {
        var c = mk('div', 'vitf-card' + (cls ? ' ' + cls : ''));
        c.appendChild(mk('p', 'vitf-card-title', icon + ' ' + title));
        return c;
    }

    /* ══════════════════════════════════════
       BUILD UI
    ══════════════════════════════════════ */
    function buildUI() {
        var app = document.getElementById('vitf-app');
        if (!app) return;
        app.innerHTML = '';

        /* Header */
        var hdr = mk('div', 'vitf-header');
        hdr.innerHTML = '<div class="vitf-header-logo">VI</div><div><h1>VI Form Embed Toolbox</h1><p>Configure your embedded form popup or inline widget.</p></div>';
        app.appendChild(hdr);

        var grid = mk('div', 'vitf-grid');
        app.appendChild(grid);

        /* ══════════════════════════════
           LEFT COLUMN
        ══════════════════════════════ */
        var left = mk('div', 'vitf-col');
        grid.appendChild(left);

        /* ── Card: General ── */
        var cGen = card('⚙️', 'General');
        var formIdInp = inp('text', 'vitf_form_id', s.form_id || 'YduwAY4dBnaTjf7LmBMA');
        cGen.appendChild(field('Form ID', 'Unique ID from your form URL', formIdInp));
        var dispToggle = radioGroup('vitf_display_type', [
            { value: 'popup',  label: '🪟 Popup' },
            { value: 'inline', label: '📄 Inline' },
        ], s.display_type || 'popup', function(v) { toggleSections(v); });
        cGen.appendChild(field('Display Type', '', dispToggle));
        left.appendChild(cGen);

        /* ── Card: Appearance ── */
        var cAppear = card('🎨', 'Appearance', 'vitf-popup-only');

        // Position grid
        var posGrid = mk('div', 'vitf-position-grid');
        var posMap = [
            {v:'top-left',l:'↖ TL'}, {v:'center-top',l:'↑ TC'}, {v:'top-right',l:'↗ TR'},
            {v:'',l:''},             {v:'center',l:'⊕ C'},       {v:'',l:''},
            {v:'bottom-left',l:'↙ BL'}, {v:'center-bottom',l:'↓ BC'}, {v:'bottom-right',l:'↘ BR'},
        ];
        posMap.forEach(function(p) {
            if (!p.v) { posGrid.appendChild(mk('div','vitf-pos-btn vitf-pos-empty')); return; }
            var b = mk('button','vitf-pos-btn'+(p.v===(s.popup_position||'bottom-right')?' active':''), p.l);
            b.type='button'; b.dataset.pos=p.v;
            b.addEventListener('click', function() {
                posGrid.querySelectorAll('.vitf-pos-btn').forEach(function(x){x.classList.remove('active');});
                b.classList.add('active');
            });
            posGrid.appendChild(b);
        });
        cAppear.appendChild(field('Position', '', posGrid));

        // Width
        var wInp = inp('number', 'vitf_popup_width', s.popup_width || 420, {min:200, max:1200});
        var wRow = mk('div', 'vitf-input-row');
        wRow.appendChild(wInp); wRow.appendChild(mk('span','','px  (Height: full viewport)'));
        cAppear.appendChild(field('Width', '', wRow));

        // Animation + seconds on same row
        var animWrap = mk('div');
        var animRow  = mk('div', 'vitf-input-row');
        var animSel  = sel('vitf_animation', [
            {value:'slide-up',   label:'⬆ Slide Up'},
            {value:'slide-down', label:'⬇ Slide Down'},
            {value:'zoom',       label:'🔍 Zoom In'},
            {value:'fade',       label:'💫 Fade'},
            {value:'flip',       label:'🔄 Flip'},
        ], s.popup_animation || 'slide-up');
        animSel.style.flex = '1';
        var secInp = inp('number', 'vitf_anim_seconds', s.popup_anim_seconds || 0.35, {min:0.1, max:3.0, step:0.05, style:'max-width:72px'});
        var secLbl = mk('span','','s');
        animRow.appendChild(animSel); animRow.appendChild(secInp); animRow.appendChild(secLbl);
        animWrap.appendChild(animRow);
        cAppear.appendChild(field('Animation', 'Style + duration in seconds', animWrap));

        left.appendChild(cAppear);

        /* ── Card: Popup Panel Background ── */
        var cBg = card('🖼️', 'Popup Panel Background', 'vitf-popup-only');

        var bgRow = mk('div');
        bgRow.appendChild(colorSwatch('vitf_bg_color', s.popup_bg_color || '#ffffff'));
        cBg.appendChild(field('Panel Background Color', '', bgRow));

        var shadowInp = inp('text', 'vitf_box_shadow', s.popup_box_shadow || '0 8px 40px rgba(0,0,0,0.18)');
        cBg.appendChild(field('Box Shadow', 'CSS box-shadow value', shadowInp));

        var shadowColorWrap = colorSwatch('vitf_shadow_color', s.popup_shadow_color || '#000000');
        cBg.appendChild(field('Shadow Color Reference', '', shadowColorWrap));

        left.appendChild(cBg);

        /* ── Card: Inline ── */
        var cInline = card('📄', 'Inline Embed', 'vitf-inline-only');
        cInline.style.display = s.display_type === 'inline' ? 'block' : 'none';
        var scBox = mk('div', 'vitf-shortcode-box');
        scBox.innerHTML = '<code>[vitf_inline]</code>';
        var cpyBtn = mk('button', 'vitf-copy-btn', 'Copy'); cpyBtn.type='button';
        cpyBtn.addEventListener('click', function() {
            navigator.clipboard.writeText('[vitf_inline]').then(function() {
                cpyBtn.textContent='✓ Copied'; setTimeout(function(){cpyBtn.textContent='Copy';},1800);
            });
        });
        scBox.appendChild(cpyBtn);
        var scNote = mk('p','vitf-note','Paste into any page or post to embed the form inline.<br><small>Override: <code>[vitf_inline form_id="YOUR_ID"]</code></small>');
        var inlineBody = mk('div'); inlineBody.appendChild(scBox); inlineBody.appendChild(scNote);
        cInline.appendChild(inlineBody);
        left.appendChild(cInline);

        /* ══════════════════════════════
           RIGHT COLUMN
        ══════════════════════════════ */
        var right = mk('div', 'vitf-col');
        grid.appendChild(right);

        /* ── Card: Background Overlay ── */
        var cOverlay = card('🌫️', 'Background Overlay', 'vitf-popup-only');
        cOverlay.appendChild(buildOverlayControl(s.popup_overlay_color || 'rgba(0,0,0,0)'));
        right.appendChild(cOverlay);

        /* ── Card: Open Trigger ── */
        var cTrig = card('⚡', 'Open Trigger', 'vitf-popup-only');

        var scrollRow = mk('div','vitf-input-row');
        scrollRow.id='vitf-scroll-row'; scrollRow.style.display='none'; scrollRow.style.marginTop='8px';
        var scrollInp = inp('number','vitf_scroll_px',s.popup_scroll_px||300,{min:0,max:99999,style:'max-width:90px'});
        scrollRow.appendChild(mk('span','','After')); scrollRow.appendChild(scrollInp); scrollRow.appendChild(mk('span','','px'));

        var selectorRow = mk('div'); selectorRow.id='vitf-selector-row';
        selectorRow.style.display='none'; selectorRow.style.marginTop='8px';
        var selTypeToggle = radioGroup('vitf_selector_type',[
            {value:'id',label:'# ID'},{value:'class',label:'. Class'},
        ], s.trigger_selector_type||'id', function(v){
            var pfx=document.getElementById('vitf-sel-prefix');
            if(pfx) pfx.textContent = v==='id'?'#':'.';
        });
        var selInputRow = mk('div','vitf-selector-row');
        var selPfx = mk('span','vitf-selector-prefix');
        selPfx.id='vitf-sel-prefix';
        selPfx.textContent=(s.trigger_selector_type||'id')==='id'?'#':'.';
        var selInp = inp('text','vitf_trigger_selector',s.trigger_selector||'');
        selInp.placeholder='element-id-or-class';
        selInputRow.appendChild(selPfx); selInputRow.appendChild(selInp);
        selectorRow.appendChild(selTypeToggle); selectorRow.appendChild(selInputRow);

        var trigSel2 = sel('vitf_trigger',[
            {value:'on_load',  label:'⚡ On page load'},
            {value:'on_scroll',label:'📜 On scroll'},
            {value:'manual',   label:'🖱 Element click'},
        ], s.popup_trigger||'on_load');
        trigSel2.addEventListener('change', function() {
            scrollRow.style.display   = this.value==='on_scroll'?'flex':'none';
            selectorRow.style.display = this.value==='manual'?'block':'none';
        });
        if (s.popup_trigger==='on_scroll') scrollRow.style.display='flex';
        if (s.popup_trigger==='manual')    selectorRow.style.display='block';

        var trigWrap = mk('div');
        trigWrap.appendChild(trigSel2); trigWrap.appendChild(scrollRow); trigWrap.appendChild(selectorRow);
        cTrig.appendChild(field('Trigger','When should the popup open?',trigWrap));
        right.appendChild(cTrig);

        /* ── Card: Visibility Rules ── */
        var cVis = card('👁️','Visibility Rules','vitf-popup-only');

        var pagesDiv = mk('div'); pagesDiv.style.display='none';
        var postsDiv = mk('div'); postsDiv.style.display='none';

        var showOnToggle = radioGroup('vitf_show_on',[
            {value:'all',            label:'🌐 All'},
            {value:'homepage',       label:'🏠 Homepage'},
            {value:'all_pages',      label:'📄 All Pages'},
            {value:'selected_pages', label:'🔖 Select Pages'},
            {value:'all_posts',      label:'📝 All Posts'},
            {value:'selected_posts', label:'✏️ Select Posts'},
        ], s.show_on||'all', function(v) {
            pagesDiv.style.display = v==='selected_pages'?'block':'none';
            postsDiv.style.display = v==='selected_posts'?'block':'none';
            if (v==='selected_pages'&&!pagesDiv.dataset.loaded) loadList('page',pagesDiv,s.show_pages||[]);
            if (v==='selected_posts'&&!postsDiv.dataset.loaded) loadList('post',postsDiv,s.show_posts||[]);
        });
        var showOnWrap=mk('div');
        showOnWrap.appendChild(showOnToggle); showOnWrap.appendChild(pagesDiv); showOnWrap.appendChild(postsDiv);
        cVis.appendChild(field('Show On','',showOnWrap));
        if (s.show_on==='selected_pages'){pagesDiv.style.display='block'; loadList('page',pagesDiv,s.show_pages||[]);}
        if (s.show_on==='selected_posts'){postsDiv.style.display='block'; loadList('post',postsDiv,s.show_posts||[]);}
        right.appendChild(cVis);

        /* ── Card: Popup Behavior ── */
        var cBeh = card('🔧','Popup Behavior','vitf-popup-only');

        var cbSub = mk('input'); cbSub.type='checkbox'; cbSub.id='vitf_close_on_submit'; cbSub.value='1';
        cbSub.checked = s.close_on_submit!=='0';
        var cbLbl = mk('label','vitf-checkbox-label');
        cbLbl.appendChild(cbSub); cbLbl.appendChild(document.createTextNode('Hide popup permanently after form submit'));
        cBeh.appendChild(field('On Submit','',cbLbl));

        var daysInp = inp('number','vitf_reopen_days', s.reopen_days!==undefined?s.reopen_days:'-1', {style:'max-width:80px'});
        var dRow = mk('div','vitf-input-row');
        dRow.appendChild(daysInp); dRow.appendChild(mk('span','','days'));
        var dNote = mk('p','vitf-note','<b>-1</b> = always reopen  |  <b>0+</b> = days before re-showing after close');
        var dWrap = mk('div'); dWrap.appendChild(dRow); dWrap.appendChild(dNote);
        cBeh.appendChild(field('Re-show After','',dWrap));
        right.appendChild(cBeh);

        /* ── Save bar (full width) ── */
        var saveCard = mk('div','vitf-card vitf-full');
        var saveRow  = mk('div','vitf-save-row');
        var saveBtn  = mk('button','vitf-btn-save','💾 Save Settings'); saveBtn.type='button';
        var saveMsg  = mk('span','vitf-save-msg');
        saveBtn.addEventListener('click', function(){ doSave(saveBtn,saveMsg); });
        saveRow.appendChild(saveBtn); saveRow.appendChild(saveMsg);
        saveCard.appendChild(saveRow);
        grid.appendChild(saveCard);

        toggleSections(s.display_type||'popup');
    }

    /* ══════════════════════════════════════
       SECTION TOGGLE
    ══════════════════════════════════════ */
    function toggleSections(type) {
        document.querySelectorAll('.vitf-popup-only').forEach(function(el){
            el.style.display = type==='popup'?'block':'none';
        });
        document.querySelectorAll('.vitf-inline-only').forEach(function(el){
            el.style.display = type==='inline'?'block':'none';
        });
    }

    /* ══════════════════════════════════════
       LOAD POST/PAGE LIST
    ══════════════════════════════════════ */
    function loadList(postType,wrap,selected) {
        wrap.dataset.loaded='1';
        wrap.innerHTML='<span style="font-size:12px;color:#94a3b8;padding:6px 0;display:block">Loading…</span>';
        $.post(cfg.ajax_url,{action:'vitf_get_pages',nonce:cfg.nonce,post_type:postType},function(res){
            if(!res.success){wrap.innerHTML='<span style="color:red;font-size:12px">Could not load.</span>';return;}
            var list=mk('div','vitf-post-list');
            res.data.forEach(function(p){
                var lbl=mk('label');
                var chk=mk('input'); chk.type='checkbox'; chk.name='vitf_show_'+postType+'s[]'; chk.value=p.id;
                chk.checked = selected.indexOf(p.id)>-1||selected.indexOf(String(p.id))>-1;
                lbl.appendChild(chk); lbl.appendChild(document.createTextNode(' '+p.title));
                list.appendChild(lbl);
            });
            wrap.innerHTML=''; wrap.appendChild(list);
        });
    }

    /* ══════════════════════════════════════
       COLLECT + SAVE
    ══════════════════════════════════════ */
    function getVal(id)    { var e=document.getElementById(id); return e?e.value:''; }
    function getRadio(nm)  { var e=document.querySelector('input[name="'+nm+'"]:checked'); return e?e.value:''; }
    function getChecks(nm) { return Array.from(document.querySelectorAll('input[name="'+nm+'"]:checked')).map(function(e){return e.value;}); }

    function collectSettings() {
        return {
            form_id:               getVal('vitf_form_id'),
            display_type:          getRadio('vitf_display_type'),
            popup_position:        (document.querySelector('.vitf-pos-btn.active')||{}).dataset?.pos||'bottom-right',
            popup_width:           getVal('vitf_popup_width'),
            popup_overlay_color:   getVal('vitf_overlay_color'),
            popup_bg_color:        getVal('vitf_bg_color'),
            popup_box_shadow:      getVal('vitf_box_shadow'),
            popup_shadow_color:    getVal('vitf_shadow_color'),
            popup_animation:       getVal('vitf_animation'),
            popup_anim_seconds:    getVal('vitf_anim_seconds'),
            popup_trigger:         getVal('vitf_trigger'),
            popup_scroll_px:       getVal('vitf_scroll_px'),
            trigger_selector:      getVal('vitf_trigger_selector'),
            trigger_selector_type: getRadio('vitf_selector_type'),
            show_on:               getRadio('vitf_show_on'),
            show_pages:            getChecks('vitf_show_pages[]'),
            show_posts:            getChecks('vitf_show_posts[]'),
            close_on_submit:       document.getElementById('vitf_close_on_submit')?.checked?'1':'0',
            reopen_days:           getVal('vitf_reopen_days'),
        };
    }

    function doSave(btn,msg) {
        btn.disabled=true; btn.textContent='Saving…';
        msg.className='vitf-save-msg'; msg.textContent='';
        $.post(cfg.ajax_url,{action:'vitf_save_settings',nonce:cfg.nonce,settings:collectSettings()},function(res){
            btn.disabled=false; btn.textContent='💾 Save Settings';
            if(res.success){ msg.textContent='✓ '+res.data.message; msg.className='vitf-save-msg vitf-ok'; }
            else            { msg.textContent='✗ Save failed.';      msg.className='vitf-save-msg vitf-err'; }
            setTimeout(function(){ msg.className='vitf-save-msg'; },3500);
        }).fail(function(){
            btn.disabled=false; btn.textContent='💾 Save Settings';
            msg.textContent='✗ Request failed.'; msg.className='vitf-save-msg vitf-err';
            setTimeout(function(){ msg.className='vitf-save-msg'; },3500);
        });
    }

    $(document).ready(buildUI);

})(jQuery);
