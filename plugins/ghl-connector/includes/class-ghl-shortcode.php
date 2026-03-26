<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class GHL_Shortcode {

    public function init() {
        add_shortcode( 'ghl_form', array( $this, 'render_shortcode' ) );
        add_action( 'wp_footer', array( $this, 'render_popups' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ) );
    }

    public function enqueue_frontend() {
        wp_enqueue_style( 'ghl-frontend', GHL_CONNECTOR_URL . 'assets/frontend.css', array(), GHL_CONNECTOR_VERSION );
        wp_enqueue_script( 'ghl-frontend', GHL_CONNECTOR_URL . 'assets/frontend.js', array(), GHL_CONNECTOR_VERSION, true );
    }

    private function get_setup( $id ) {
        global $wpdb;
        $table = $wpdb->prefix . 'ghl_form_setups';
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d", $id ), ARRAY_A );
    }

    public function render_shortcode( $atts ) {
        $atts = shortcode_atts( array( 'id' => 0 ), $atts );
        $setup = $this->get_setup( absint( $atts['id'] ) );
        if ( ! $setup ) return '<!-- GHL Form: setup not found -->';
        if ( $setup['display_type'] === 'inline' ) {
            return $this->render_inline( $setup );
        }
        return ''; // popup renders in footer
    }

    private function render_inline( $setup ) {
        $style = 'background:' . esc_attr( $setup['panel_bg'] ) . ';';
        if ( ! empty( $setup['box_shadow'] ) ) $style .= 'box-shadow:' . esc_attr( $setup['box_shadow'] ) . ';';
        $width = absint( $setup['width'] );
        return '<div class="ghl-inline-wrap" style="max-width:' . $width . 'px;' . $style . '">'
             . '<iframe src="https://api.leadconnectorhq.com/widget/form/' . esc_attr( $setup['form_id'] ) . '"'
             . ' style="width:100%;min-height:400px;border:none;" loading="lazy"></iframe>'
             . '</div>';
    }

    public function render_popups() {
        global $wpdb;
        $table  = $wpdb->prefix . 'ghl_form_setups';
        $setups = $wpdb->get_results( "SELECT * FROM $table WHERE display_type = 'popup'", ARRAY_A );
        foreach ( $setups as $setup ) {
            $overlay_rgba = $this->hex_to_rgba( $setup['overlay_color'], $setup['overlay_opacity'] / 100 );
            $panel_style  = 'background:' . esc_attr( $setup['panel_bg'] ) . ';width:' . absint( $setup['width'] ) . 'px;';
            if ( ! empty( $setup['box_shadow'] ) ) $panel_style .= 'box-shadow:' . esc_attr( $setup['box_shadow'] ) . ';';
            echo '<div class="ghl-popup-overlay" id="ghl-popup-' . $setup['id'] . '"'
               . ' data-trigger="' . esc_attr( $setup['trigger_type'] ) . '"'
               . ' data-animation="' . esc_attr( $setup['animation'] ) . '"'
               . ' data-duration="' . esc_attr( $setup['animation_duration'] ) . '"'
               . ' data-reshow="' . intval( $setup['reshow_after'] ) . '"'
               . ' data-on-submit-hide="' . intval( $setup['on_submit_hide'] ) . '"'
               . ' style="background:' . esc_attr( $overlay_rgba ) . ';display:none;">'
               . '<div class="ghl-popup-panel" style="' . $panel_style . '">'
               . '<button class="ghl-popup-close" aria-label="Close">&times;</button>'
               . '<iframe src="https://api.leadconnectorhq.com/widget/form/' . esc_attr( $setup['form_id'] ) . '"'
               . ' style="width:100%;min-height:500px;border:none;" loading="lazy"></iframe>'
               . '</div></div>';
        }
    }

    private function hex_to_rgba( $hex, $alpha ) {
        $hex = ltrim( $hex, '#' );
        if ( strlen( $hex ) === 3 ) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        $r = hexdec( substr( $hex, 0, 2 ) );
        $g = hexdec( substr( $hex, 2, 2 ) );
        $b = hexdec( substr( $hex, 4, 2 ) );
        return "rgba($r,$g,$b,$alpha)";
    }
}
