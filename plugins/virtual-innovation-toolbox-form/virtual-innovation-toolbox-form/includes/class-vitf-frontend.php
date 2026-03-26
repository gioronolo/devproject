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
        require_once VITF_PLUGIN_DIR . 'includes/class-vitf-settings.php';
        $s = new VITF_Settings();
        $this->settings = $s->get_settings();
        return $this->settings;
    }

    private function should_show() {
        $s = $this->load_settings();
        $show_on = $s['show_on'];

        if ( $show_on === 'all' ) return true;
        if ( $show_on === 'homepage' ) return is_front_page() || is_home();

        if ( $show_on === 'selected_pages' ) {
            $ids = array_map( 'absint', (array) $s['show_pages'] );
            return is_page( $ids );
        }

        if ( $show_on === 'selected_posts' ) {
            $ids = array_map( 'absint', (array) $s['show_posts'] );
            return is_single( $ids );
        }

        if ( $show_on === 'all_posts' ) return is_singular( 'post' );
        if ( $show_on === 'all_pages' ) return is_page();

        return false;
    }

    public function enqueue_assets() {
        $s = $this->load_settings();
        if ( $s['display_type'] !== 'popup' ) return;
        if ( ! $this->should_show() ) return;

        wp_enqueue_style( 'vitf-public', VITF_PLUGIN_URL . 'public/css/popup.css', [], VITF_VERSION );
        wp_enqueue_script( 'vitf-public', VITF_PLUGIN_URL . 'public/js/popup.js', [], VITF_VERSION, true );

        // Build CSS variables from settings
        $pos          = $s['popup_position'];
        $width        = absint( $s['popup_width'] );
        $height       = absint( $s['popup_height'] );
        $bg_type      = $s['popup_bg_type'];
        $bg_color     = esc_attr( $s['popup_bg_color'] );
        $bg_image     = esc_url( $s['popup_bg_image'] );
        $box_shadow   = esc_attr( $s['popup_box_shadow'] );

        $pos_css = $this->get_position_css( $pos );

        $bg_css = $bg_type === 'image' && $bg_image
            ? "url('{$bg_image}') center center / cover no-repeat"
            : $bg_color;

        $inline_css = "
        :root {
            --vitf-width: {$width}px;
            --vitf-height: {$height}px;
            --vitf-bg: {$bg_css};
            --vitf-shadow: {$box_shadow};
            {$pos_css}
        }";

        wp_add_inline_style( 'vitf-public', $inline_css );
        wp_localize_script( 'vitf-public', 'VITF_Config', [
            'trigger'       => $s['popup_trigger'],
            'scroll_px'     => (int) $s['popup_scroll_px'],
            'close_submit'  => $s['close_on_submit'],
            'reopen_weeks'  => (int) $s['reopen_weeks'],
            'form_id'       => esc_js( $s['form_id'] ),
        ]);
    }

    private function get_position_css( $pos ) {
        $map = [
            'bottom-right'  => '--vitf-bottom:24px; --vitf-right:24px; --vitf-left:auto; --vitf-top:auto; --vitf-transform:none;',
            'bottom-left'   => '--vitf-bottom:24px; --vitf-left:24px; --vitf-right:auto; --vitf-top:auto; --vitf-transform:none;',
            'top-right'     => '--vitf-top:24px; --vitf-right:24px; --vitf-bottom:auto; --vitf-left:auto; --vitf-transform:none;',
            'top-left'      => '--vitf-top:24px; --vitf-left:24px; --vitf-bottom:auto; --vitf-right:auto; --vitf-transform:none;',
            'center'        => '--vitf-top:50%; --vitf-left:50%; --vitf-bottom:auto; --vitf-right:auto; --vitf-transform:translate(-50%,-50%);',
            'center-bottom' => '--vitf-bottom:24px; --vitf-left:50%; --vitf-right:auto; --vitf-top:auto; --vitf-transform:translateX(-50%);',
            'center-top'    => '--vitf-top:24px; --vitf-left:50%; --vitf-right:auto; --vitf-bottom:auto; --vitf-transform:translateX(-50%);',
        ];
        return $map[ $pos ] ?? $map['bottom-right'];
    }

    public function render_popup() {
        $s = $this->load_settings();
        if ( $s['display_type'] !== 'popup' ) return;
        if ( ! $this->should_show() ) return;

        $form_id = esc_attr( $s['form_id'] );
        $src     = "https://go.virtualinnovation.co.nz/widget/form/{$form_id}";
        ?>
        <div id="vitf-popup-wrap" class="vitf-hidden" role="dialog" aria-modal="true" aria-label="Contact Form">
            <div id="vitf-popup">
                <button id="vitf-close" aria-label="Close form">&times;</button>
                <div id="vitf-popup-body">
                    <iframe
                        src="<?php echo esc_url( $src ); ?>"
                        id="vitf-iframe"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        loading="lazy"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
        <button id="vitf-trigger-btn" aria-label="Open contact form" title="Contact Us">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
        </button>
        <?php
    }

    public function render_inline( $atts ) {
        $s    = $this->load_settings();
        $atts = shortcode_atts([ 'form_id' => $s['form_id'] ], $atts, 'vitf_inline' );
        $src  = "https://go.virtualinnovation.co.nz/widget/form/" . esc_attr( $atts['form_id'] );
        return '<div class="vitf-inline-wrap"><iframe src="' . esc_url( $src ) . '" width="100%" style="border:0;min-height:500px;" loading="lazy" allowfullscreen></iframe></div>';
    }
}
