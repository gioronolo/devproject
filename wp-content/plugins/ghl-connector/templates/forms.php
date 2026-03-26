<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="ghl-wrap" id="ghl-app">

  <div class="ghl-header">
    <div class="ghl-header-inner">
      <div class="ghl-logo">
        <span class="ghl-logo-icon">&#9889;</span>
        <div><h1>GHL Form Embed Toolbox</h1><p>Configure your embedded form popup or inline widget.</p></div>
      </div>
      <button class="ghl-btn ghl-btn-primary" id="ghl-new-setup-btn">&#43; New Setup</button>
    </div>
  </div>

  <div class="ghl-main">

    <!-- Existing Setups List -->
    <div class="ghl-card" id="ghl-setups-card">
      <div class="ghl-card-header">
        <h2>&#128221; Saved Form Setups</h2>
        <p>Click a setup to edit, or create a new one above.</p>
      </div>
      <div class="ghl-card-body" style="padding:0;">
        <div id="ghl-setups-loader" class="ghl-loader" style="display:none;padding:24px;">
          <div class="ghl-spinner"></div><span>Loading setups&hellip;</span>
        </div>
        <div id="ghl-setups-list"></div>
        <div id="ghl-setups-empty" class="ghl-empty" style="display:none;">
          <span>&#128221;</span><p>No form setups yet. Click "+ New Setup" to create one.</p>
        </div>
      </div>
    </div>

    <!-- Form Builder -->
    <div id="ghl-form-builder" style="display:none;">
      <input type="hidden" id="setup-id" value="0" />

      <div class="ghl-builder-grid">

        <!-- LEFT COLUMN -->
        <div class="ghl-builder-col">

          <!-- General -->
          <div class="ghl-card">
            <div class="ghl-card-header ghl-section-header">
              <span class="ghl-section-icon">&#9881;</span>
              <span class="ghl-section-title">GENERAL</span>
            </div>
            <div class="ghl-card-body">
              <div class="ghl-field-group">
                <label>Form</label>
                <div class="ghl-form-select-row">
                  <select id="setup-form-id" class="ghl-select">
                    <option value="">— Select a GHL Form —</option>
                  </select>
                  <button class="ghl-btn ghl-btn-ghost" id="ghl-load-forms-btn" style="white-space:nowrap;">&#8635; Load Forms</button>
                </div>
                <span class="ghl-hint">Form ID: <code id="setup-form-id-display">—</code></span>
              </div>
              <div class="ghl-field-group">
                <label>Display Type</label>
                <div class="ghl-radio-group">
                  <label class="ghl-radio-btn">
                    <input type="radio" name="display_type" value="popup" checked />
                    <span>&#128243; Popup</span>
                  </label>
                  <label class="ghl-radio-btn">
                    <input type="radio" name="display_type" value="inline" />
                    <span>&#9711; Inline</span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Appearance -->
          <div class="ghl-card">
            <div class="ghl-card-header ghl-section-header">
              <span class="ghl-section-icon">&#127775;</span>
              <span class="ghl-section-title">APPEARANCE</span>
            </div>
            <div class="ghl-card-body">
              <div class="ghl-field-group" id="position-group">
                <label>Position</label>
                <div class="ghl-position-grid">
                  <button class="ghl-pos-btn" data-pos="TL" title="Top Left">&#8598; TL</button>
                  <button class="ghl-pos-btn" data-pos="TC" title="Top Center">&#8593; TC</button>
                  <button class="ghl-pos-btn" data-pos="TR" title="Top Right">&#8599; TR</button>
                  <button class="ghl-pos-btn" data-pos="C"  title="Center" class="active">&#9679; C</button>
                  <button class="ghl-pos-btn" data-pos="BL" title="Bottom Left">&#8601; BL</button>
                  <button class="ghl-pos-btn" data-pos="BC" title="Bottom Center">&#8595; BC</button>
                  <button class="ghl-pos-btn" data-pos="BR" title="Bottom Right">&#8600; BR</button>
                </div>
                <input type="hidden" id="setup-position" value="C" />
              </div>
              <div class="ghl-field-group">
                <label>Width</label>
                <div class="ghl-input-with-unit">
                  <input type="number" id="setup-width" value="680" min="280" max="1200" />
                  <span class="ghl-unit">px (Height: full viewport)</span>
                </div>
              </div>
              <div class="ghl-field-group" id="animation-group">
                <label>Animation</label>
                <div class="ghl-anim-row">
                  <select id="setup-animation" class="ghl-select">
                    <option value="slideUp">&#8679; Slide Up</option>
                    <option value="slideDown">&#8681; Slide Down</option>
                    <option value="fadeIn">&#9788; Fade In</option>
                    <option value="zoomIn">&#8853; Zoom In</option>
                    <option value="none">&#8212; None</option>
                  </select>
                  <input type="number" id="setup-animation-duration" value="0.35" min="0.1" max="2" step="0.05" style="width:70px;" />
                  <span class="ghl-unit">s</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Panel Background -->
          <div class="ghl-card">
            <div class="ghl-card-header ghl-section-header">
              <span class="ghl-section-icon">&#127795;</span>
              <span class="ghl-section-title">POPUP PANEL BACKGROUND</span>
            </div>
            <div class="ghl-card-body">
              <div class="ghl-field-group">
                <label>Panel Background Color</label>
                <input type="text" id="setup-panel-bg" value="#ffffff" class="ghl-color-picker" />
              </div>
              <div class="ghl-field-group">
                <label>Box Shadow <span class="ghl-optional">CSS box-shadow value</span></label>
                <input type="text" id="setup-box-shadow" placeholder="e.g. 0 4px 32px rgba(0,0,0,0.3)" />
              </div>
            </div>
          </div>

        </div><!-- end left col -->

        <!-- RIGHT COLUMN -->
        <div class="ghl-builder-col">

          <!-- Background Overlay -->
          <div class="ghl-card" id="overlay-card">
            <div class="ghl-card-header ghl-section-header">
              <span class="ghl-section-icon">&#127775;</span>
              <span class="ghl-section-title">BACKGROUND OVERLAY</span>
            </div>
            <div class="ghl-card-body">
              <div class="ghl-field-group">
                <label>Overlay Color</label>
                <input type="text" id="setup-overlay-color" value="#000000" class="ghl-color-picker" />
              </div>
              <div class="ghl-field-group">
                <label>Opacity: <strong id="overlay-opacity-val">90</strong>%</label>
                <input type="range" id="setup-overlay-opacity" min="0" max="100" value="90" />
                <span class="ghl-hint">Dims the page behind the popup. Opacity 0 = no overlay. Click overlay to close popup.</span>
              </div>
            </div>
          </div>

          <!-- Open Trigger -->
          <div class="ghl-card" id="trigger-card">
            <div class="ghl-card-header ghl-section-header">
              <span class="ghl-section-icon">&#9889;</span>
              <span class="ghl-section-title">OPEN TRIGGER</span>
            </div>
            <div class="ghl-card-body">
              <div class="ghl-field-group">
                <label>Trigger — When should the popup open?</label>
                <select id="setup-trigger" class="ghl-select">
                  <option value="onload">&#9889; On page load</option>
                  <option value="delay">&#8987; After delay (seconds)</option>
                  <option value="scroll">&#8595; On scroll %</option>
                  <option value="exit">&#8592; On exit intent</option>
                  <option value="manual">&#128432; Manual (shortcode/button)</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Visibility Rules -->
          <div class="ghl-card" id="visibility-card">
            <div class="ghl-card-header ghl-section-header">
              <span class="ghl-section-icon">&#128308;</span>
              <span class="ghl-section-title">VISIBILITY RULES</span>
            </div>
            <div class="ghl-card-body">
              <div class="ghl-field-group">
                <label>Show On</label>
                <div class="ghl-radio-group ghl-radio-wrap">
                  <label class="ghl-radio-btn"><input type="radio" name="show_on" value="all" checked /><span>&#127760; All</span></label>
                  <label class="ghl-radio-btn"><input type="radio" name="show_on" value="homepage" /><span>&#127968; Homepage</span></label>
                  <label class="ghl-radio-btn"><input type="radio" name="show_on" value="all_pages" /><span>&#128196; All Pages</span></label>
                  <label class="ghl-radio-btn"><input type="radio" name="show_on" value="all_posts" /><span>&#128221; All Posts</span></label>
                </div>
              </div>
            </div>
          </div>

          <!-- Popup Behavior -->
          <div class="ghl-card" id="behavior-card">
            <div class="ghl-card-header ghl-section-header">
              <span class="ghl-section-icon">&#128295;</span>
              <span class="ghl-section-title">POPUP BEHAVIOR</span>
            </div>
            <div class="ghl-card-body">
              <div class="ghl-field-group">
                <label>On Submit</label>
                <label class="ghl-checkbox-row">
                  <input type="checkbox" id="setup-on-submit-hide" checked />
                  <span>Hide popup permanently after form submit</span>
                </label>
              </div>
              <div class="ghl-field-group">
                <label>Re-show After</label>
                <div class="ghl-input-with-unit">
                  <input type="number" id="setup-reshow" value="-1" min="-1" />
                  <span class="ghl-unit">days</span>
                </div>
                <span class="ghl-hint">-1 = always reopen &nbsp;|&nbsp; 0+ = days before re-showing after close</span>
              </div>
            </div>
          </div>

        </div><!-- end right col -->
      </div><!-- end builder grid -->

      <!-- Shortcode Preview -->
      <div class="ghl-card" id="shortcode-card" style="display:none;">
        <div class="ghl-card-header ghl-section-header">
          <span class="ghl-section-icon">&#128279;</span>
          <span class="ghl-section-title">SHORTCODE</span>
        </div>
        <div class="ghl-card-body">
          <p style="color:var(--ghl-muted);font-size:.85rem;margin:0 0 10px;">Copy and paste this shortcode into any page or post:</p>
          <div class="ghl-shortcode-box">
            <code id="setup-shortcode"></code>
            <button class="ghl-btn ghl-btn-ghost" id="copy-shortcode-btn">&#128203; Copy</button>
          </div>
        </div>
      </div>

      <!-- Save / Cancel -->
      <div class="ghl-builder-actions">
        <button class="ghl-btn ghl-btn-primary ghl-btn-lg" id="ghl-save-setup-btn">&#128190; Save Setup</button>
        <button class="ghl-btn ghl-btn-ghost" id="ghl-cancel-setup-btn">Cancel</button>
        <button class="ghl-btn ghl-btn-danger" id="ghl-delete-setup-btn" style="display:none;">&#128465; Delete</button>
      </div>
      <div class="ghl-notice" id="ghl-form-notice"></div>

    </div><!-- end form builder -->

  </div>
</div>
