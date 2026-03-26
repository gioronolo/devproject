<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VITF_Frontend {

    private $settings;

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'wp_footer', [ $this, 'render_popup' ] );
        add_shortcode( 'vitf_inline', [ $this, 'render_inline' ] );
    }

    private function load_settings() {
        if ( $this->settings ) return $this->settings;
        $s = new VITF_Settings();
        $this->settings = $s->get_settings();
        return $this->settings;
    }

    private function should_show() {
        $s = $this->load_settings();
        $show_on = $s['show_on'];
        if ( $show_on === 'all' )            return true;
        if ( $show_on === 'homepage' )       return is_front_page() || is_home();
        if ( $show_on === 'all_pages' )      return is_page();
        if ( $show_on === 'all_posts' )      return is_singular( 'post' );
        if ( $show_on === 'selected_pages' ) return is_page( array_map( 'absint', (array) $s['show_pages'] ) );
        if ( $show_on === 'selected_posts' ) return is_single( array_map( 'absint', (array) $s['show_posts'] ) );
        return false;
    }

    public function enqueue_assets() {
        $s = $this->load_settings();
        if ( $s['display_type'] !== 'popup' ) return;
        if ( ! $this->should_show() ) return;

        wp_enqueue_style( 'vitf-public', VITF_PLUGIN_URL . 'public/css/popup.css', [], VITF_VERSION );
        wp_enqueue_script( 'vitf-public', VITF_PLUGIN_URL . 'public/js/popup.js', [], VITF_VERSION, true );

        $width         = absint( $s['popup_width'] );
        $bg_color      = esc_attr( $s['popup_bg_color'] );
        $box_shadow    = esc_attr( $s['popup_box_shadow'] );
        $overlay_color = esc_attr( $s['popup_overlay_color'] ?? 'rgba(0,0,0,0)' );
        $anim_sec      = floatval( $s['popup_anim_seconds'] ?? 0.35 );

        // Only non-positional vars in :root
        $inline_css = ":root {
            --vitf-width: {$width}px;
            --vitf-bg: {$bg_color};
            --vitf-shadow: {$box_shadow};
            --vitf-overlay: {$overlay_color};
            --vitf-anim-dur: {$anim_sec}s;
        }";
        wp_add_inline_style( 'vitf-public', $inline_css );

        wp_localize_script( 'vitf-public', 'VITF_Config', [
            'trigger'          => $s['popup_trigger'],
            'scroll_px'        => (int) $s['popup_scroll_px'],
            'close_submit'     => $s['close_on_submit'],
            'reopen_days'      => $s['reopen_days'],
            'form_id'          => esc_js( $s['form_id'] ),
            'animation'        => esc_js( $s['popup_animation'] ?? 'slide-up' ),
            'trigger_selector' => esc_js( $s['trigger_selector'] ?? '' ),
            'trigger_sel_type' => esc_js( $s['trigger_selector_type'] ?? 'id' ),
            'position'         => esc_js( $s['popup_position'] ?? 'bottom-right' ),
        ]);
    }

    public function render_popup() {
        $s = $this->load_settings();
        if ( $s['display_type'] !== 'popup' ) return;
        if ( ! $this->should_show() ) return;

        $form_id  = esc_attr( $s['form_id'] );
        $src      = "https://go.virtualinnovation.co.nz/widget/form/{$form_id}";
        $anim     = esc_attr( $s['popup_animation'] ?? 'slide-up' );
        $pos      = $s['popup_position'] ?? 'bottom-right';

        // Build DIRECT inline position styles — no CSS vars for position
        $pos_style = $this->get_position_style( $pos );
        ?>
        <!-- VI Form Embed Toolbox -->
        <div id="vitf-overlay"></div>
        <div id="vitf-popup-wrap"
             class="vitf-anim-<?php echo $anim; ?>"
             style="<?php echo esc_attr( $pos_style ); ?>"
             role="dialog" aria-modal="true" aria-label="Contact Form">
            <div id="vitf-popup">
                <button id="vitf-close" type="button" aria-label="Close form">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
                <div id="vitf-popup-body">
                    <iframe
                        src="<?php echo esc_url( $src ); ?>"
                        id="vitf-iframe"
                        width="100%"
                        height="100%"
                        style="border:0;display:block;"
                        loading="lazy"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Returns direct inline CSS string for position — no CSS vars.
     * This is the only reliable cross-browser approach.
     */
    private function get_position_style( $pos ) {
        // base: fixed positioning with explicit values for all 4 edges
        $map = [
            'bottom-right'  => 'bottom:24px; right:24px; left:auto; top:auto; transform:none;',
            'bottom-left'   => 'bottom:24px; left:24px;  right:auto; top:auto; transform:none;',
            'top-right'     => 'top:24px;    right:24px; bottom:auto; left:auto; transform:none;',
            'top-left'      => 'top:24px;    left:24px;  bottom:auto; right:auto; transform:none;',
            'center'        => 'top:50%;     left:50%;   bottom:auto; right:auto; transform:translate(-50%,-50%);',
            'center-bottom' => 'bottom:24px; left:50%;   right:auto;  top:auto;   transform:translateX(-50%);',
            'center-top'    => 'top:24px;    left:50%;   bottom:auto; right:auto; transform:translateX(-50%);',
        ];
        return $map[ $pos ] ?? $map['bottom-right'];
    }

    public function render_inline( $atts ) {
        $s    = $this->load_settings();
        $atts = shortcode_atts([ 'form_id' => $s['form_id'] ], $atts, 'vitf_inline' );
        $src  = "https://go.virtualinnovation.co.nz/widget/form/" . esc_attr( $atts['form_id'] );
        return '<div class="vitf-inline-wrap"><iframe src="' . esc_url( $src ) . '" width="100%" style="border:0;min-height:600px;height:100vh;" loading="lazy" allowfullscreen></iframe></div>';
    }
}
