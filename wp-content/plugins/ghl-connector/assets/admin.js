(function ($) {
    'use strict';

    /* ── Helpers ── */
    function showNotice(id, type, msg) {
        var $n = $('#' + id);
        $n.removeClass('success error info').addClass(type).html(msg).show();
        if (type === 'success') setTimeout(function () { $n.fadeOut(400, function () { $n.hide().removeClass('success error info').text(''); }); }, 4000);
    }
    function setStatus(state, text) {
        var $b = $('#ghl-status-badge');
        $b.removeClass('connected error');
        if (state === 'connected') $b.addClass('connected');
        else if (state === 'error') $b.addClass('error');
        $('#ghl-status-text').text(text);
    }
    function esc(s) { return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
    function post(action, data, done, fail) {
        data = $.extend({ action: action, nonce: GHL_AJAX.nonce }, data || {});
        $.post(GHL_AJAX.ajax_url, data).done(done).fail(fail || function () {});
    }

    /* ── Toggle password ── */
    $(document).on('click', '.ghl-toggle-pw', function () {
        var $i = $('#' + $(this).data('target'));
        $i.attr('type', $i.attr('type') === 'password' ? 'text' : 'password');
    });

    /* ─────────────────────────────────────────
       SETTINGS PAGE (main.php)
    ───────────────────────────────────────── */
    function getSettings() {
        return { location_api_key: $('#ghl-location-api-key').val().trim(), location_id: $('#ghl-location-id').val().trim() };
    }

    $('#ghl-test-btn').on('click', function () {
        var $b = $(this).prop('disabled', true).html('Testing&hellip;');
        post('ghl_test_connection', getSettings(), function (r) {
            if (r.success) {
                showNotice('ghl-settings-notice', 'success', '&#9989; ' + r.data.message);
                setStatus('connected', 'Connected');
                if (r.data.location_id && !$('#ghl-location-id').val()) $('#ghl-location-id').val(r.data.location_id);
            } else { showNotice('ghl-settings-notice', 'error', '&#10060; ' + r.data.message); setStatus('error', 'Failed'); }
        }).always(function () { $b.prop('disabled', false).html('&#128302; Test Connection'); });
    });

    $('#ghl-save-btn').on('click', function () {
        var $b = $(this).prop('disabled', true).html('Saving&hellip;');
        post('ghl_save_settings', getSettings(), function (r) {
            if (r.success) showNotice('ghl-settings-notice', 'success', '&#9989; ' + r.data.message);
            else showNotice('ghl-settings-notice', 'error', '&#10060; ' + r.data.message);
        }).always(function () { $b.prop('disabled', false).html('&#128190; Save Settings'); });
    });

    $('#ghl-clear-cache-btn').on('click', function () {
        var $b = $(this).prop('disabled', true);
        post('ghl_clear_cache', {}, function (r) {
            if (r.success) showNotice('ghl-settings-notice', 'info', '&#128465; ' + r.data.message);
        }).always(function () { $b.prop('disabled', false).html('&#128465; Clear Cache'); });
    });

    /* ── Contacts Table ── */
    var contactsPerPage = 20, contactsPage = 0, contactsTotal = 0;

    $('#ghl-load-contacts-btn').on('click', function () { loadContacts(0); });

    function loadContacts(skip) {
        var $b = $('#ghl-load-contacts-btn').prop('disabled', true).html('Loading&hellip;');
        $('#ghl-contacts-loader').show();
        $('#ghl-contacts-table-wrap, #ghl-contacts-empty').hide();
        $('#ghl-contacts-notice').hide().removeClass('success error info');

        post('ghl_fetch_contacts', { limit: contactsPerPage, skip: skip }, function (r) {
            if (r.success) {
                contactsTotal = r.data.total || r.data.contacts.length;
                contactsPage  = Math.floor(skip / contactsPerPage);
                renderContactsTable(r.data.contacts, skip);
            } else {
                showNotice('ghl-contacts-notice', 'error', '&#10060; ' + r.data.message);
                $('#ghl-contacts-empty').show();
            }
        }).always(function () {
            $('#ghl-contacts-loader').hide();
            $b.prop('disabled', false).html('&#8635; Load Contacts');
        });
    }

    function renderContactsTable(contacts, skip) {
        var $tbody = $('#ghl-contacts-tbody').empty();
        if (!contacts || !contacts.length) { $('#ghl-contacts-empty').show(); return; }
        $.each(contacts, function (i, c) {
            var name  = [c.firstName, c.lastName].filter(Boolean).join(' ') || c.name || '—';
            var tags  = (c.tags && c.tags.length) ? c.tags.map(function(t){ return '<span class="ghl-tag">'+esc(t)+'</span>'; }).join('') : '<span class="ghl-tag-empty">None</span>';
            var date  = c.dateAdded ? new Date(c.dateAdded).toLocaleDateString() : '—';
            $tbody.append(
                '<tr><td>' + (skip + i + 1) + '</td>' +
                '<td><strong>' + esc(name) + '</strong></td>' +
                '<td>' + esc(c.email || '—') + '</td>' +
                '<td>' + esc(c.phone || '—') + '</td>' +
                '<td>' + tags + '</td>' +
                '<td>' + esc(c.source || '—') + '</td>' +
                '<td>' + esc(date) + '</td></tr>'
            );
        });
        $('#ghl-contacts-table-wrap').show();
        renderPagination();
    }

    function renderPagination() {
        var $p = $('#ghl-contacts-pagination').empty();
        var totalPages = Math.ceil(contactsTotal / contactsPerPage);
        if (totalPages <= 1) return;
        var $prev = $('<button class="ghl-page-btn">&#8592; Prev</button>').prop('disabled', contactsPage === 0);
        $prev.on('click', function () { loadContacts((contactsPage - 1) * contactsPerPage); });
        $p.append($prev);
        var start = Math.max(0, contactsPage - 2), end = Math.min(totalPages - 1, start + 4);
        for (var i = start; i <= end; i++) {
            (function(pg) {
                var $btn = $('<button class="ghl-page-btn' + (pg === contactsPage ? ' active' : '') + '">' + (pg + 1) + '</button>');
                $btn.on('click', function () { loadContacts(pg * contactsPerPage); });
                $p.append($btn);
            })(i);
        }
        var $next = $('<button class="ghl-page-btn">Next &#8594;</button>').prop('disabled', contactsPage >= totalPages - 1);
        $next.on('click', function () { loadContacts((contactsPage + 1) * contactsPerPage); });
        $p.append($next);
        $p.append('<span class="ghl-page-info">Showing ' + (contactsPage * contactsPerPage + 1) + '–' + Math.min((contactsPage + 1) * contactsPerPage, contactsTotal) + ' of ' + contactsTotal + '</span>');
    }

    /* ─────────────────────────────────────────
       FORMS PAGE (forms.php)
    ───────────────────────────────────────── */

    /* Color pickers */
    if ($.fn.wpColorPicker) {
        $('.ghl-color-picker').wpColorPicker({ change: function () {} });
    }

    /* Opacity slider */
    $('#setup-overlay-opacity').on('input', function () { $('#overlay-opacity-val').text($(this).val()); });

    /* Position grid */
    $(document).on('click', '.ghl-pos-btn', function () {
        $('.ghl-pos-btn').removeClass('active');
        $(this).addClass('active');
        $('#setup-position').val($(this).data('pos'));
    });

    /* Display type toggle — show/hide popup-only sections */
    $(document).on('change', 'input[name=display_type]', function () {
        var isPopup = $(this).val() === 'popup';
        $('#overlay-card, #trigger-card, #visibility-card, #behavior-card, #animation-group, #position-group').toggle(isPopup);
    });

    /* Form dropdown change */
    $('#setup-form-id').on('change', function () {
        var text = $(this).find('option:selected').text();
        $('#setup-form-id-display').text($(this).val() || '—');
        updateShortcode();
    });

    function updateShortcode() {
        var id = $('#setup-id').val();
        if (id && id !== '0') {
            $('#setup-shortcode').text('[ghl_form id="' + id + '"]');
            $('#shortcode-card').show();
        }
    }

    /* Load GHL forms into dropdown */
    $('#ghl-load-forms-btn').on('click', function () {
        var $b = $(this).prop('disabled', true).html('&#8635; Loading&hellip;');
        post('ghl_fetch_forms', {}, function (r) {
            if (r.success) {
                var $sel = $('#setup-form-id').empty().append('<option value="">— Select a GHL Form —</option>');
                $.each(r.data.forms, function (i, f) {
                    $sel.append('<option value="' + esc(f.id) + '">' + esc(f.name) + '</option>');
                });
                showNotice('ghl-form-notice', 'success', '&#9989; Loaded ' + r.data.forms.length + ' form(s).');
            } else showNotice('ghl-form-notice', 'error', '&#10060; ' + r.data.message);
        }).always(function () { $b.prop('disabled', false).html('&#8635; Load Forms'); });
    });

    /* Copy shortcode */
    $('#copy-shortcode-btn').on('click', function () {
        var text = $('#setup-shortcode').text();
        navigator.clipboard.writeText(text).then(function () {
            var $b = $('#copy-shortcode-btn').text('Copied!');
            setTimeout(function () { $b.html('&#128203; Copy'); }, 2000);
        });
    });

    /* New setup */
    $('#ghl-new-setup-btn').on('click', function () {
        resetBuilder();
        $('#ghl-setups-card').hide();
        $('#ghl-form-builder').show();
        $('#shortcode-card').hide();
        $('#ghl-delete-setup-btn').hide();
    });

    /* Cancel */
    $('#ghl-cancel-setup-btn').on('click', function () {
        $('#ghl-form-builder').hide();
        $('#ghl-setups-card').show();
        loadSetups();
    });

    /* Save setup */
    $('#ghl-save-setup-btn').on('click', function () {
        var formId = $('#setup-form-id').val();
        if (!formId) { showNotice('ghl-form-notice', 'error', 'Please select a GHL Form first.'); return; }
        var $b = $(this).prop('disabled', true).html('Saving&hellip;');
        var data = {
            setup_id:           $('#setup-id').val(),
            form_id:            formId,
            form_name:          $('#setup-form-id option:selected').text(),
            display_type:       $('input[name=display_type]:checked').val(),
            position:           $('#setup-position').val(),
            width:              $('#setup-width').val(),
            animation:          $('#setup-animation').val(),
            animation_duration: $('#setup-animation-duration').val(),
            panel_bg:           $('#setup-panel-bg').val(),
            box_shadow:         $('#setup-box-shadow').val(),
            overlay_color:      $('#setup-overlay-color').val(),
            overlay_opacity:    $('#setup-overlay-opacity').val(),
            trigger_type:       $('#setup-trigger').val(),
            show_on:            $('input[name=show_on]:checked').val(),
            on_submit_hide:     $('#setup-on-submit-hide').is(':checked') ? 1 : 0,
            reshow_after:       $('#setup-reshow').val(),
        };
        post('ghl_save_form', data, function (r) {
            if (r.success) {
                $('#setup-id').val(r.data.id);
                showNotice('ghl-form-notice', 'success', '&#9989; ' + r.data.message);
                $('#ghl-delete-setup-btn').show();
                updateShortcode();
            } else showNotice('ghl-form-notice', 'error', '&#10060; ' + r.data.message);
        }).always(function () { $b.prop('disabled', false).html('&#128190; Save Setup'); });
    });

    /* Delete setup */
    $('#ghl-delete-setup-btn').on('click', function () {
        if (!confirm('Delete this setup?')) return;
        post('ghl_delete_form', { setup_id: $('#setup-id').val() }, function (r) {
            if (r.success) { $('#ghl-cancel-setup-btn').trigger('click'); }
        });
    });

    /* Load setups list */
    function loadSetups() {
        $('#ghl-setups-loader').show();
        $('#ghl-setups-list').empty();
        $('#ghl-setups-empty').hide();
        post('ghl_list_setups', {}, function (r) {
            $('#ghl-setups-loader').hide();
            if (r.success && r.data.setups.length) {
                $.each(r.data.setups, function (i, s) {
                    var badge = s.display_type === 'popup' ?
                        '<span class="ghl-setup-badge ghl-badge-popup">Popup</span>' :
                        '<span class="ghl-setup-badge ghl-badge-inline">Inline</span>';
                    $('#ghl-setups-list').append(
                        '<div class="ghl-setup-row">' +
                        '<div><div class="ghl-setup-name">' + esc(s.form_name) + ' ' + badge + '</div>' +
                        '<div class="ghl-setup-meta">ID: ' + esc(s.form_id) + ' &nbsp;&bull;&nbsp; Shortcode: [ghl_form id="' + s.id + '"]</div></div>' +
                        '<div class="ghl-setup-actions">' +
                        '<button class="ghl-btn ghl-btn-secondary ghl-edit-setup" data-id="' + s.id + '">Edit</button>' +
                        '</div></div>'
                    );
                });
            } else $('#ghl-setups-empty').show();
        });
    }

    /* Edit setup */
    $(document).on('click', '.ghl-edit-setup', function () {
        var id = $(this).data('id');
        post('ghl_get_form', { setup_id: id }, function (r) {
            if (!r.success) return;
            var s = r.data.setup;
            resetBuilder();
            $('#setup-id').val(s.id);
            $('#setup-form-id').val(s.form_id);
            $('#setup-form-id-display').text(s.form_id);
            $('input[name=display_type][value=' + s.display_type + ']').prop('checked', true).trigger('change');
            $('.ghl-pos-btn').removeClass('active').filter('[data-pos=' + s.position + ']').addClass('active');
            $('#setup-position').val(s.position);
            $('#setup-width').val(s.width);
            $('#setup-animation').val(s.animation);
            $('#setup-animation-duration').val(s.animation_duration);
            if ($.fn.wpColorPicker) {
                $('#setup-panel-bg').wpColorPicker('color', s.panel_bg);
                $('#setup-overlay-color').wpColorPicker('color', s.overlay_color);
            } else {
                $('#setup-panel-bg').val(s.panel_bg);
                $('#setup-overlay-color').val(s.overlay_color);
            }
            $('#setup-box-shadow').val(s.box_shadow);
            $('#setup-overlay-opacity').val(s.overlay_opacity);
            $('#overlay-opacity-val').text(s.overlay_opacity);
            $('#setup-trigger').val(s.trigger_type);
            $('input[name=show_on][value=' + s.show_on + ']').prop('checked', true);
            $('#setup-on-submit-hide').prop('checked', s.on_submit_hide == 1);
            $('#setup-reshow').val(s.reshow_after);
            updateShortcode();
            $('#ghl-delete-setup-btn').show();
            $('#ghl-setups-card').hide();
            $('#ghl-form-builder').show();
        });
    });

    function resetBuilder() {
        $('#setup-id').val('0');
        $('#setup-form-id').val('');
        $('#setup-form-id-display').text('—');
        $('input[name=display_type][value=popup]').prop('checked', true).trigger('change');
        $('.ghl-pos-btn').removeClass('active').filter('[data-pos=C]').addClass('active');
        $('#setup-position').val('C');
        $('#setup-width').val(680);
        $('#setup-animation').val('slideUp');
        $('#setup-animation-duration').val(0.35);
        $('#setup-box-shadow').val('');
        $('#setup-overlay-opacity').val(90);
        $('#overlay-opacity-val').text(90);
        $('#setup-trigger').val('onload');
        $('input[name=show_on][value=all]').prop('checked', true);
        $('#setup-on-submit-hide').prop('checked', true);
        $('#setup-reshow').val(-1);
        $('#ghl-form-notice').hide().removeClass('success error info');
        $('#ghl-delete-setup-btn').hide();
    }

    /* Init forms page */
    if ($('#ghl-setups-card').length) loadSetups();

})(jQuery);
