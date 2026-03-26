<?php
/**
 * Plugin Name: Virtual Innovation Toolbox Form
 * Plugin URI:  https://virtualinnovation.co.nz
 * Description: Display a configurable form widget as a popup or inline embed with full display control.
 * Version:     1.0.0
 * Author:      Virtual Innovation
 * License:     GPL-2.0+
 * Text Domain: vitf
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VITF_VERSION', '1.0.0' );
define( 'VITF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VITF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once VITF_PLUGIN_DIR . 'includes/class-vitf-settings.php';
require_once VITF_PLUGIN_DIR . 'includes/class-vitf-frontend.php';

function vitf_init() {
    new VITF_Settings();
    new VITF_Frontend();
}
add_action( 'plugins_loaded', 'vitf_init' );

register_activation_hook( __FILE__, function() {
    if ( false === get_option( 'vitf_settings' ) ) {
        add_option( 'vitf_settings', [] );
    }
});
