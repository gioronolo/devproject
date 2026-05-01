<?php
/**
 * Plugin Name: Saint Johns Butchery
 * Plugin URI:  https://www.saintjohnsbutchery.co.nz
 * Description: Pages, block patterns and styles for Saint Johns Butchery — built entirely with native Gutenberg blocks.
 * Version:     2.0.0
 * Author:      Virtual Innovation
 * License:     GPL-2.0+
 * Text Domain: saint-johns-butchery
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SJB_DIR',     plugin_dir_path( __FILE__ ) );
define( 'SJB_URL',     plugin_dir_url( __FILE__ ) );
define( 'SJB_VERSION', '2.0.0' );
define( 'SJB_IMG',     'https://amzreijbdxyuomovdyvg.supabase.co/storage/v1/object/public/site-assets/cmms901ns000004laozo9ipk3/' );

require_once SJB_DIR . 'includes/page-setup.php';
require_once SJB_DIR . 'includes/block-patterns.php';

register_activation_hook( __FILE__, 'sjb_activate' );
function sjb_activate() {
	sjb_switch_to_block_theme();
	sjb_create_pages();
	flush_rewrite_rules();
}

/* Switch to a block theme so native blocks render at full width */
function sjb_switch_to_block_theme() {
	$preferred = [ 'twentytwentyfive', 'twentytwentyfour', 'twentytwentythree' ];
	foreach ( $preferred as $theme ) {
		if ( wp_get_theme( $theme )->exists() ) {
			switch_theme( $theme );
			break;
		}
	}
}

/* Enqueue styles + Google Fonts */
add_action( 'wp_enqueue_scripts', 'sjb_frontend_assets' );
function sjb_frontend_assets() {
	wp_enqueue_style(
		'sjb-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap',
		[], null
	);
	wp_enqueue_style( 'sjb-styles', SJB_URL . 'assets/css/frontend.css', [ 'sjb-fonts' ], SJB_VERSION );
}

add_action( 'enqueue_block_editor_assets', 'sjb_editor_assets' );
function sjb_editor_assets() {
	wp_enqueue_style( 'sjb-editor', SJB_URL . 'assets/css/frontend.css', [], SJB_VERSION );
}

/* Local business structured data */
add_action( 'wp_head', 'sjb_structured_data' );
function sjb_structured_data() {
	?>
<script type="application/ld+json">{"@context":"https://schema.org","@type":"Butcher","name":"Saint Johns Butchery","url":"https://www.saintjohnsbutchery.co.nz","telephone":"+6495216319","email":"dave@saintjohnsbutchery.co.nz","address":{"@type":"PostalAddress","streetAddress":"Corner of Felton Mathew Ave and Merton Rd","addressLocality":"St Johns","addressRegion":"Auckland","addressCountry":"NZ"},"geo":{"@type":"GeoCoordinates","latitude":-36.879947,"longitude":174.851011},"openingHoursSpecification":[{"@type":"OpeningHoursSpecification","dayOfWeek":"Monday","opens":"00:00","closes":"00:00"},{"@type":"OpeningHoursSpecification","dayOfWeek":["Tuesday","Wednesday","Thursday","Friday"],"opens":"07:30","closes":"18:00"},{"@type":"OpeningHoursSpecification","dayOfWeek":"Saturday","opens":"08:00","closes":"18:00"},{"@type":"OpeningHoursSpecification","dayOfWeek":"Sunday","opens":"08:30","closes":"17:00"}],"sameAs":["https://www.facebook.com/SaintJohnsButchery/"]}</script>
	<?php
}

/* Announcement bar */
add_action( 'wp_body_open', 'sjb_announcement_bar' );
function sjb_announcement_bar() {
	echo '<div class="sjb-announcement">Open 6 days — Tue–Fri 7:30am–6pm &nbsp;|&nbsp; Sat 8am–6pm &nbsp;|&nbsp; Sun 8:30am–5pm</div>';
}

