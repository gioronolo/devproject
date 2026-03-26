<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VITF_Settings {

    private $option_name = 'vitf_settings';
    private $defaults = [
        'display_type'        => 'popup',
        'form_id'             => 'YduwAY4dBnaTjf7LmBMA',
        // Popup settings
        'popup_position'      => 'bottom-right',
        'popup_width'         => '420',
        'popup_height'        => '580',
        'popup_bg_type'       => 'color',
        'popup_bg_color'      => '#ffffff',
        'popup_bg_image'      => '',
        'popup_box_shadow'    => '0 8px 40px rgba(0,0,0,0.18)',
        'popup_trigger'       => 'on_load',
        'popup_scroll_px'     => '300',
        // Visibility
        'show_on'             => 'all',
        'show_pages'          => [],
        'show_posts'          => [],
        // Behavior
        'close_on_submit'     => '1',
        'reopen_weeks'        => '7',
        // Inline settings
        'inline_shortcode'    => '',
    ];

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
        add_action( 'wp_ajax_vitf_save_settings', [ $this, 'ajax_save' ] );
        add_action( 'wp_ajax_vitf_get_pages', [ $this, 'ajax_get_pages' ] );
    }

    public function add_menu() {
        add_options_page(
            'Virtual Innovation Toolbox Form',
            'VI Toolbox Form',
            'manage_options',
            'vitf-settings',
            [ $this, 'render_page' ]
        );
    }

    public function get_settings() {
        $saved = get_option( $this->option_name, [] );
        return wp_parse_args( $saved, $this->defaults );
    }

    public function enqueue_admin_assets( $hook ) {
        if ( $hook !== 'settings_page_vitf-settings' ) return;
        wp_enqueue_media();
        wp_enqueue_style( 'vitf-admin', VITF_PLUGIN_URL . 'admin/css/admin.css', [], VITF_VERSION );
        wp_enqueue_script( 'vitf-admin', VITF_PLUGIN_URL . 'admin/js/admin.js', [ 'jquery', 'wp-util' ], VITF_VERSION, true );
        wp_localize_script( 'vitf-admin', 'VITF_Admin', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'vitf_nonce' ),
            'settings' => $this->get_settings(),
        ]);
    }

    public function ajax_save() {
        check_ajax_referer( 'vitf_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Unauthorized' );

        $raw = isset( $_POST['settings'] ) ? $_POST['settings'] : [];
        $settings = [];

        $settings['display_type']     = sanitize_text_field( $raw['display_type'] ?? 'popup' );
        $settings['form_id']          = sanitize_text_field( $raw['form_id'] ?? '' );
        $settings['popup_position']   = sanitize_text_field( $raw['popup_position'] ?? 'bottom-right' );
        $settings['popup_width']      = absint( $raw['popup_width'] ?? 420 );
        $settings['popup_height']     = absint( $raw['popup_height'] ?? 580 );
        $settings['popup_bg_type']    = sanitize_text_field( $raw['popup_bg_type'] ?? 'color' );
        $settings['popup_bg_color']   = sanitize_hex_color( $raw['popup_bg_color'] ?? '#ffffff' ) ?? '#ffffff';
        $settings['popup_bg_image']   = esc_url_raw( $raw['popup_bg_image'] ?? '' );
        $settings['popup_box_shadow'] = sanitize_text_field( $raw['popup_box_shadow'] ?? '' );
        $settings['popup_trigger']    = sanitize_text_field( $raw['popup_trigger'] ?? 'on_load' );
        $settings['popup_scroll_px']  = absint( $raw['popup_scroll_px'] ?? 300 );
        $settings['show_on']          = sanitize_text_field( $raw['show_on'] ?? 'all' );
        $settings['show_pages']       = array_map( 'absint', (array)( $raw['show_pages'] ?? [] ) );
        $settings['show_posts']       = array_map( 'absint', (array)( $raw['show_posts'] ?? [] ) );
        $settings['close_on_submit']  = isset( $raw['close_on_submit'] ) ? '1' : '0';
        $settings['reopen_weeks']     = absint( $raw['reopen_weeks'] ?? 7 );

        update_option( $this->option_name, $settings );
        wp_send_json_success( [ 'message' => 'Settings saved!' ] );
    }

    public function ajax_get_pages() {
        check_ajax_referer( 'vitf_nonce', 'nonce' );
        $type = sanitize_text_field( $_POST['post_type'] ?? 'page' );
        $posts = get_posts([ 'post_type' => $type, 'posts_per_page' => -1, 'post_status' => 'publish' ]);
        $data = array_map( fn($p) => [ 'id' => $p->ID, 'title' => $p->post_title ], $posts );
        wp_send_json_success( $data );
    }

    public function render_page() {
        ?>
        <div id="vitf-app"><!-- React/JS admin app mounts here --></div>
        <?php
    }
}
