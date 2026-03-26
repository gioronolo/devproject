<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class GHL_Forms {

    private $table;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'ghl_form_setups';
    }

    public function init() {
        add_action( 'admin_menu', array( $this, 'add_submenu' ) );
        add_action( 'wp_ajax_ghl_fetch_forms',   array( $this, 'ajax_fetch_forms' ) );
        add_action( 'wp_ajax_ghl_save_form',     array( $this, 'ajax_save_form' ) );
        add_action( 'wp_ajax_ghl_delete_form',   array( $this, 'ajax_delete_form' ) );
        add_action( 'wp_ajax_ghl_get_form',      array( $this, 'ajax_get_form' ) );
        add_action( 'wp_ajax_ghl_list_setups',   array( $this, 'ajax_list_setups' ) );
    }

    public function add_submenu() {
        add_submenu_page( 'ghl-connector', 'GHL Forms', 'Forms', 'manage_options', 'ghl-forms',
            array( $this, 'render_page' ) );
    }

    public function render_page() {
        include GHL_CONNECTOR_DIR . 'templates/forms.php';
    }

    private function make_api() {
        $s = get_option( 'ghl_connector_settings', array() );
        $k = isset( $s['location_api_key'] ) ? $s['location_api_key'] : '';
        $l = isset( $s['location_id'] )      ? $s['location_id']      : '';
        return empty( $k ) ? null : new GHL_API( $k, $l );
    }

    private function verify_nonce() {
        if ( ! check_ajax_referer( 'ghl_connector_nonce', 'nonce', false ) )
            wp_send_json_error( array( 'message' => 'Security check failed.' ), 403 );
        if ( ! current_user_can( 'manage_options' ) )
            wp_send_json_error( array( 'message' => 'Insufficient permissions.' ), 403 );
    }

    public function ajax_fetch_forms() {
        $this->verify_nonce();
        $api = $this->make_api();
        if ( ! $api ) wp_send_json_error( array( 'message' => 'Save your API settings first.' ) );
        $forms = $api->get_forms();
        if ( is_wp_error( $forms ) ) wp_send_json_error( array( 'message' => $forms->get_error_message() ) );
        wp_send_json_success( array( 'forms' => $forms ) );
    }

    public function ajax_save_form() {
        $this->verify_nonce();
        global $wpdb;
        $id = isset( $_POST['setup_id'] ) ? absint( $_POST['setup_id'] ) : 0;
        $data = array(
            'form_id'            => sanitize_text_field( $_POST['form_id'] ?? '' ),
            'form_name'          => sanitize_text_field( $_POST['form_name'] ?? '' ),
            'display_type'       => sanitize_text_field( $_POST['display_type'] ?? 'popup' ),
            'position'           => sanitize_text_field( $_POST['position'] ?? 'C' ),
            'width'              => absint( $_POST['width'] ?? 680 ),
            'animation'          => sanitize_text_field( $_POST['animation'] ?? 'slideUp' ),
            'animation_duration' => floatval( $_POST['animation_duration'] ?? 0.35 ),
            'panel_bg'           => sanitize_hex_color( $_POST['panel_bg'] ?? '#ffffff' ),
            'box_shadow'         => sanitize_text_field( $_POST['box_shadow'] ?? '' ),
            'overlay_color'      => sanitize_hex_color( $_POST['overlay_color'] ?? '#000000' ),
            'overlay_opacity'    => absint( $_POST['overlay_opacity'] ?? 90 ),
            'trigger_type'       => sanitize_text_field( $_POST['trigger_type'] ?? 'onload' ),
            'show_on'            => sanitize_text_field( $_POST['show_on'] ?? 'all' ),
            'on_submit_hide'     => isset( $_POST['on_submit_hide'] ) ? 1 : 0,
            'reshow_after'       => intval( $_POST['reshow_after'] ?? -1 ),
        );
        if ( $id > 0 ) {
            $wpdb->update( $this->table, $data, array( 'id' => $id ) );
        } else {
            $wpdb->insert( $this->table, $data );
            $id = $wpdb->insert_id;
        }
        wp_send_json_success( array( 'message' => 'Setup saved.', 'id' => $id ) );
    }

    public function ajax_delete_form() {
        $this->verify_nonce();
        global $wpdb;
        $id = absint( $_POST['setup_id'] ?? 0 );
        if ( $id ) $wpdb->delete( $this->table, array( 'id' => $id ) );
        wp_send_json_success( array( 'message' => 'Deleted.' ) );
    }

    public function ajax_get_form() {
        $this->verify_nonce();
        global $wpdb;
        $id  = absint( $_POST['setup_id'] ?? 0 );
        $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$this->table} WHERE id = %d", $id ), ARRAY_A );
        if ( ! $row ) wp_send_json_error( array( 'message' => 'Not found.' ) );
        wp_send_json_success( array( 'setup' => $row ) );
    }

    public function ajax_list_setups() {
        $this->verify_nonce();
        global $wpdb;
        $rows = $wpdb->get_results( "SELECT * FROM {$this->table} ORDER BY id DESC", ARRAY_A );
        wp_send_json_success( array( 'setups' => $rows ) );
    }
}
