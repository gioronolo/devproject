<?php
/**
 * Plugin Name: Farm Inventory System
 * Description: Farm inventory management for chicken, hog, and other livestock with AJAX-based one-page admin app.
 * Version: 1.0.0
 * Author: Virtual Innovation
 * Text Domain: farm-inventory-system
 */

if (!defined('ABSPATH')) {
    exit;
}

define('FIS_VERSION', '1.0.0');
define('FIS_PLUGIN_FILE', __FILE__);
define('FIS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('FIS_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once FIS_PLUGIN_PATH . 'includes/class-fis-db.php';
require_once FIS_PLUGIN_PATH . 'includes/class-fis-helper.php';
require_once FIS_PLUGIN_PATH . 'includes/class-fis-admin.php';
require_once FIS_PLUGIN_PATH . 'includes/class-fis-ajax.php';

register_activation_hook(__FILE__, ['FIS_DB', 'activate']);

function fis_init_plugin() {
    FIS_Admin::init();
    FIS_Ajax::init();
}
add_action('plugins_loaded', 'fis_init_plugin');


add_shortcode('farm_inventory_app', function () {

    wp_enqueue_script('fis-frontend', plugin_dir_url(__FILE__) . 'assets/js/frontend.js', ['jquery'], null, true);
    wp_enqueue_style('fis-style', plugin_dir_url(__FILE__) . 'assets/css/frontend.css');

    wp_localize_script('fis-frontend', 'fis_ajax', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    ob_start();
    ?>
    <div id="fis-app"></div>
    <?php
    return ob_get_clean();
});