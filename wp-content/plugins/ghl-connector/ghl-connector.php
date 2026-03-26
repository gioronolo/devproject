<?php
/**
 * Plugin Name: GHL Connector - GIO
 * Description: Connect WordPress to GoHighLevel - Contacts & Form Embed Manager.
 * Version: 3.0.0
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GHL_CONNECTOR_VERSION', '3.0.0' );
define( 'GHL_CONNECTOR_DIR', plugin_dir_path( __FILE__ ) );
define( 'GHL_CONNECTOR_URL', plugin_dir_url( __FILE__ ) );

require_once GHL_CONNECTOR_DIR . 'includes/class-ghl-api.php';
require_once GHL_CONNECTOR_DIR . 'includes/class-ghl-admin.php';
require_once GHL_CONNECTOR_DIR . 'includes/class-ghl-forms.php';
require_once GHL_CONNECTOR_DIR . 'includes/class-ghl-shortcode.php';

function ghl_connector_init() {
    $admin     = new GHL_Admin();
    $admin->init();
    $forms     = new GHL_Forms();
    $forms->init();
    $shortcode = new GHL_Shortcode();
    $shortcode->init();
}
add_action( 'plugins_loaded', 'ghl_connector_init' );

register_activation_hook( __FILE__, function () {
    add_option( 'ghl_connector_settings', array(
        'location_api_key' => '',
        'location_id'      => '',
    ) );
    global $wpdb;
    $charset = $wpdb->get_charset_collate();
    $table   = $wpdb->prefix . 'ghl_form_setups';
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        form_id varchar(100) NOT NULL,
        form_name varchar(255) NOT NULL,
        display_type varchar(10) NOT NULL DEFAULT 'popup',
        position varchar(5) DEFAULT 'C',
        width int(5) DEFAULT 680,
        animation varchar(50) DEFAULT 'slideUp',
        animation_duration float DEFAULT 0.35,
        panel_bg varchar(20) DEFAULT '#ffffff',
        box_shadow varchar(200) DEFAULT '',
        overlay_color varchar(20) DEFAULT '#000000',
        overlay_opacity int(3) DEFAULT 90,
        trigger_type varchar(30) DEFAULT 'onload',
        show_on varchar(20) DEFAULT 'all',
        on_submit_hide tinyint(1) DEFAULT 1,
        reshow_after int(4) DEFAULT -1,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
} );
