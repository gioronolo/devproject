<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class GHL_Admin {

    public function init() {
        add_action( 'admin_menu',            array( $this, 'add_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_ajax_ghl_save_settings',   array( $this, 'ajax_save_settings' ) );
        add_action( 'wp_ajax_ghl_test_connection', array( $this, 'ajax_test_connection' ) );
        add_action( 'wp_ajax_ghl_fetch_contacts',  array( $this, 'ajax_fetch_contacts' ) );
        add_action( 'wp_ajax_ghl_clear_cache',     array( $this, 'ajax_clear_cache' ) );
    }

    public function add_menu() {
        add_menu_page( 'GHL Connector', 'GHL Connector', 'manage_options', 'ghl-connector',
            array( $this, 'render_page' ), 'dashicons-networking', 30 );
    }

    public function enqueue_assets( $hook ) {
        if ( strpos( $hook, 'ghl-connector' ) === false ) return;
        wp_enqueue_style( 'ghl-admin', GHL_CONNECTOR_URL . 'assets/admin.css', array(), GHL_CONNECTOR_VERSION );
        wp_enqueue_script( 'ghl-admin', GHL_CONNECTOR_URL . 'assets/admin.js', array( 'jquery', 'wp-color-picker' ), GHL_CONNECTOR_VERSION, true );
        wp_enqueue_style( 'wp-color-picker' );
        wp_localize_script( 'ghl-admin', 'GHL_AJAX', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'ghl_connector_nonce' ),
        ) );
    }

    public function render_page() {
        $settings         = get_option( 'ghl_connector_settings', array() );
        $location_api_key = isset( $settings['location_api_key'] ) ? $settings['location_api_key'] : '';
        $location_id      = isset( $settings['location_id'] )      ? $settings['location_id']      : '';
        include GHL_CONNECTOR_DIR . 'templates/main.php';
    }

    private function make_api() {
        $s = get_option( 'ghl_connector_settings', array() );
        $k = isset( $s['location_api_key'] ) ? $s['location_api_key'] : '';
        $l = isset( $s['location_id'] )      ? $s['location_id']      : '';
        return empty( $k ) ? null : new GHL_API( $k, $l );
    }

    public function ajax_save_settings() {
        $this->verify_nonce();
        $key = sanitize_text_field( isset( $_POST['location_api_key'] ) ? $_POST['location_api_key'] : '' );
        $lid = sanitize_text_field( isset( $_POST['location_id'] )      ? $_POST['location_id']      : '' );
        update_option( 'ghl_connector_settings', array( 'location_api_key' => $key, 'location_id' => $lid ) );
        global $wpdb;
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_ghl_%'" );
        wp_send_json_success( array( 'message' => 'Settings saved.' ) );
    }

    public function ajax_test_connection() {
        $this->verify_nonce();
        $key = sanitize_text_field( isset( $_POST['location_api_key'] ) ? $_POST['location_api_key'] : '' );
        $lid = sanitize_text_field( isset( $_POST['location_id'] )      ? $_POST['location_id']      : '' );
        if ( empty( $key ) ) wp_send_json_error( array( 'message' => 'Access Token is required.' ) );
        $api    = new GHL_API( $key, $lid );
        $result = $api->validate_credentials();
        if ( is_wp_error( $result ) ) wp_send_json_error( array( 'message' => $result->get_error_message() ) );
        wp_send_json_success( array( 'message' => 'Connected to: ' . $result, 'location_id' => $api->get_location_id() ) );
    }

    public function ajax_fetch_contacts() {
        $this->verify_nonce();
        $limit = isset( $_POST['limit'] ) ? absint( $_POST['limit'] ) : 20;
        $skip  = isset( $_POST['skip'] )  ? absint( $_POST['skip'] )  : 0;
        $api   = $this->make_api();
        if ( ! $api ) wp_send_json_error( array( 'message' => 'Save your settings first.' ) );
        $result = $api->get_contacts( $limit, $skip );
        if ( is_wp_error( $result ) ) wp_send_json_error( array( 'message' => $result->get_error_message() ) );
        $contacts = isset( $result['contacts'] ) ? $result['contacts'] : array();
        $total    = isset( $result['total'] )    ? $result['total']    : count( $contacts );
        wp_send_json_success( array( 'contacts' => $contacts, 'total' => $total ) );
    }

    public function ajax_clear_cache() {
        $this->verify_nonce();
        global $wpdb;
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_ghl_%'" );
        wp_send_json_success( array( 'message' => 'Cache cleared.' ) );
    }

    private function verify_nonce() {
        if ( ! check_ajax_referer( 'ghl_connector_nonce', 'nonce', false ) )
            wp_send_json_error( array( 'message' => 'Security check failed.' ), 403 );
        if ( ! current_user_can( 'manage_options' ) )
            wp_send_json_error( array( 'message' => 'Insufficient permissions.' ), 403 );
    }
}
