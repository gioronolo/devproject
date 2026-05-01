<?php
/**
 * Plugin Name: Saint Johns Butchery
 * Plugin URI:  https://www.saintjohnsbutchery.co.nz
 * Description: Pages, block patterns, and styles for Saint Johns Butchery website.
 * Version:     1.0.0
 * Author:      Virtual Innovation
 * License:     GPL-2.0+
 * Text Domain: saint-johns-butchery
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SJB_DIR', plugin_dir_path( __FILE__ ) );
define( 'SJB_URL', plugin_dir_url( __FILE__ ) );
define( 'SJB_VERSION', '1.0.0' );
define( 'SJB_IMG', 'https://amzreijbdxyuomovdyvg.supabase.co/storage/v1/object/public/site-assets/cmms901ns000004laozo9ipk3/' );

require_once SJB_DIR . 'includes/page-setup.php';
require_once SJB_DIR . 'includes/block-patterns.php';

register_activation_hook( __FILE__, 'sjb_activate' );
function sjb_activate() {
	sjb_create_pages();
	flush_rewrite_rules();
}

/* Enqueue styles + Google Fonts on frontend */
add_action( 'wp_enqueue_scripts', 'sjb_frontend_assets' );
function sjb_frontend_assets() {
	wp_enqueue_style(
		'sjb-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'sjb-styles', SJB_URL . 'assets/css/frontend.css', [ 'sjb-fonts' ], SJB_VERSION );
}

/* Also load styles in block editor so previews match */
add_action( 'enqueue_block_editor_assets', 'sjb_editor_assets' );
function sjb_editor_assets() {
	wp_enqueue_style( 'sjb-editor', SJB_URL . 'assets/css/frontend.css', [], SJB_VERSION );
}

/* Structured data for local SEO */
add_action( 'wp_head', 'sjb_structured_data' );
function sjb_structured_data() {
	if ( ! is_front_page() && ! is_page() ) {
		return;
	}
	?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Butcher",
  "name": "Saint Johns Butchery",
  "description": "Free range butcher in St Johns, East Auckland. Fresh meat cut daily in store.",
  "url": "https://www.saintjohnsbutchery.co.nz",
  "telephone": "+6495216319",
  "email": "dave@saintjohnsbutchery.co.nz",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Corner of Felton Mathew Ave and Merton Rd",
    "addressLocality": "St Johns",
    "addressRegion": "Auckland",
    "addressCountry": "NZ"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": -36.879947, "longitude": 174.851011 },
  "openingHoursSpecification": [
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Monday", "opens": "00:00", "closes": "00:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Tuesday", "opens": "07:30", "closes": "18:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Wednesday", "opens": "07:30", "closes": "18:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Thursday", "opens": "07:30", "closes": "18:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Friday", "opens": "07:30", "closes": "18:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Saturday", "opens": "08:00", "closes": "18:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Sunday", "opens": "08:30", "closes": "17:00" }
  ],
  "sameAs": ["https://www.facebook.com/SaintJohnsButchery/"]
}
</script>
	<?php
}

/* Announcement bar via wp_body_open (supported by most modern themes) */
add_action( 'wp_body_open', 'sjb_announcement_bar' );
function sjb_announcement_bar() {
	echo '<div class="sjb-announcement">Open 6 days — Tue–Fri 7:30am–6pm &nbsp;|&nbsp; Sat 8am–6pm &nbsp;|&nbsp; Sun 8:30am–5pm</div>';
}
