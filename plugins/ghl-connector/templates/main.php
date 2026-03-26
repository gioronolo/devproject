<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="ghl-wrap" id="ghl-app">

  <div class="ghl-header">
    <div class="ghl-header-inner">
      <div class="ghl-logo">
        <span class="ghl-logo-icon">&#9889;</span>
        <div><h1>GHL Connector</h1><p>GoHighLevel Dashboard</p></div>
      </div>
      <div class="ghl-status-badge" id="ghl-status-badge">
        <span class="ghl-status-dot"></span>
        <span id="ghl-status-text">Not Connected</span>
      </div>
    </div>
  </div>

  <div class="ghl-main">

    <!-- Settings -->
    <div class="ghl-card">
      <div class="ghl-card-header">
        <h2>&#128273; API Settings</h2>
        <p>Agency Access Token (<code>pit-...</code>) or Location JWT (<code>eyJ...</code>)</p>
      </div>
      <div class="ghl-card-body">
        <div class="ghl-two-col">
          <div class="ghl-field-group">
            <label>Access Token</label>
            <div class="ghl-input-wrapper">
              <input type="password" id="ghl-location-api-key" placeholder="pit-xxxx  or  eyJhbGci..." value="<?php echo esc_attr( $location_api_key ); ?>" autocomplete="off" />
              <button class="ghl-toggle-pw" type="button" data-target="ghl-location-api-key">&#128065;</button>
            </div>
          </div>
          <div class="ghl-field-group">
            <label>Location ID <span class="ghl-optional">(required for pit- tokens)</span></label>
            <input type="text" id="ghl-location-id" placeholder="e.g. 2ViYhIjuzpQ15EOqr88X" value="<?php echo esc_attr( $location_id ); ?>" />
          </div>
        </div>
        <div class="ghl-actions">
          <button class="ghl-btn ghl-btn-primary" id="ghl-test-btn">&#128302; Test Connection</button>
          <button class="ghl-btn ghl-btn-secondary" id="ghl-save-btn">&#128190; Save Settings</button>
          <button class="ghl-btn ghl-btn-ghost" id="ghl-clear-cache-btn">&#128465; Clear Cache</button>
        </div>
        <div class="ghl-notice" id="ghl-settings-notice"></div>
      </div>
    </div>

    <!-- Contacts -->
    <div class="ghl-card">
      <div class="ghl-card-header">
        <div class="ghl-card-header-row">
          <div><h2>&#128100; Contacts</h2><p>All contacts from your GHL location.</p></div>
          <button class="ghl-btn ghl-btn-primary" id="ghl-load-contacts-btn">&#8635; Load Contacts</button>
        </div>
      </div>
      <div class="ghl-card-body" style="padding:0;">
        <div id="ghl-contacts-loader" class="ghl-loader" style="display:none;padding:32px;">
          <div class="ghl-spinner"></div><span>Loading contacts&hellip;</span>
        </div>
        <div class="ghl-notice" id="ghl-contacts-notice" style="margin:16px 24px 0;"></div>
        <div id="ghl-contacts-table-wrap" style="display:none;">
          <div class="ghl-table-scroll">
            <table class="ghl-table" id="ghl-contacts-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Tags</th>
                  <th>Source</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody id="ghl-contacts-tbody"></tbody>
            </table>
          </div>
          <div class="ghl-pagination" id="ghl-contacts-pagination"></div>
        </div>
        <div id="ghl-contacts-empty" class="ghl-empty" style="display:none;">
          <span>&#128100;</span><p>No contacts found. Click "Load Contacts".</p>
        </div>
      </div>
    </div>

  </div>
</div>
