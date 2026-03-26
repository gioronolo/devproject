<?php
if (!defined('ABSPATH')) {
    exit;
}

class FIS_Admin {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'register_menu']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
    }

    public static function register_menu() {
        add_menu_page(
            __('Farm Inventory', 'farm-inventory-system'),
            __('Farm Inventory', 'farm-inventory-system'),
            'manage_options',
            'farm-inventory-system',
            [__CLASS__, 'render_admin_page'],
            'dashicons-chart-bar',
            26
        );
    }

    public static function enqueue_assets($hook) {
        if ($hook !== 'toplevel_page_farm-inventory-system') {
            return;
        }

        wp_enqueue_style(
            'fis-admin-css',
            FIS_PLUGIN_URL . 'assets/css/admin.css',
            [],
            FIS_VERSION
        );

        wp_enqueue_script(
            'fis-admin-js',
            FIS_PLUGIN_URL . 'assets/js/admin.js',
            ['jquery'],
            FIS_VERSION,
            true
        );

        wp_localize_script('fis-admin-js', 'fisAdmin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('fis_admin_nonce'),
            'today'   => current_time('Y-m-d'),
            'types'   => FIS_DB::get_types(),
        ]);
    }

    public static function render_admin_page() {
        include FIS_PLUGIN_PATH . 'templates/admin-page.php';
    }
}