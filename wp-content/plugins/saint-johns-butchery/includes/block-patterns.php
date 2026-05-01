<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'sjb_register_block_patterns' );
function sjb_register_block_patterns() {
	register_block_pattern_category( 'saint-johns-butchery', [ 'label' => 'Saint Johns Butchery' ] );

	/* ---- Hero ---- */
	register_block_pattern( 'sjb/hero', [
		'title'      => 'SJB Hero Section',
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => sjb_pattern_hero(),
	] );

	/* ---- Info Bar ---- */
	register_block_pattern( 'sjb/info-bar', [
		'title'      => 'SJB Info Bar',
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => sjb_pattern_info_bar(),
	] );

	/* ---- Product Cards Grid ---- */
	register_block_pattern( 'sjb/products-grid', [
		'title'      => 'SJB Products Grid',
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => sjb_products_grid_block(),
	] );

	/* ---- CTA Banner ---- */
	register_block_pattern( 'sjb/cta', [
		'title'      => 'SJB CTA Banner',
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => sjb_cta_block(
			'Ready to order?',
			'Visit us in store or call ahead to place a custom order.',
			'Call Us',
			'tel:+6495216319'
		),
	] );

	/* ---- About ---- */
	register_block_pattern( 'sjb/about', [
		'title'      => 'SJB About Section',
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => sjb_pattern_about(),
	] );
}

/* ============================================================
   Pattern content functions
   ============================================================ */

function sjb_pattern_hero() {
	$img = SJB_IMG . 'images-Saint-Johns-Butchery-Beef1.jpg';
	return <<<BLOCK

<!-- wp:group {"align":"full","className":"sjb-hero","style":{"color":{"gradient":"linear-gradient(170deg,#e8f6f9 0%,#d0f0f5 40%,#ffffff 100%)"},"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group alignfull sjb-hero" style="background:linear-gradient(170deg,#e8f6f9 0%,#d0f0f5 40%,#ffffff 100%);padding-top:5rem;padding-right:1.5rem;padding-bottom:5rem;padding-left:1.5rem">

<!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"3rem","left":"4rem"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center">

<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">

<!-- wp:paragraph {"style":{"color":{"background":"#2b6374","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"0.4rem","bottom":"0.4rem","left":"1rem","right":"1rem"}},"typography":{"fontSize":"0.8rem","fontWeight":"500"}}} -->
<p class="sjb-badge has-text-color has-background" style="background-color:#2b6374;color:#ffffff;border-radius:9999px;padding-top:0.4rem;padding-right:1rem;padding-bottom:0.4rem;padding-left:1rem;font-size:0.8rem;font-weight:500">St Johns, Auckland — Est. 1982</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"clamp(2.5rem,5vw,3.75rem)","lineHeight":"1.1"},"spacing":{"margin":{"top":"1.25rem","bottom":"1rem"}}}} -->
<h1 class="wp-block-heading" style="font-size:clamp(2.5rem,5vw,3.75rem);line-height:1.1;margin-top:1.25rem;margin-bottom:1rem">Your Local <em>Free Range</em> Butchery</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#3a4650"},"typography":{"fontSize":"1.15rem"},"spacing":{"margin":{"top":"0","bottom":"2rem"}}}} -->
<p class="has-text-color" style="color:#3a4650;font-size:1.15rem;margin-top:0;margin-bottom:2rem">Premium free range meats, handmade sausages &amp; specialty cuts — all processed in store. Open Tuesday to Sunday.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"blockGap":"1rem"}}} -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#5a9a1f","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2rem","right":"2rem"}},"typography":{"fontSize":"1rem","fontWeight":"600"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="/products/" style="border-radius:9999px;color:#ffffff;background-color:#5a9a1f;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem;font-size:1rem;font-weight:600">Shop Our Range</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline","style":{"color":{"text":"#2b6374"},"border":{"radius":"9999px","color":"#2b6374","width":"2px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2rem","right":"2rem"}},"typography":{"fontSize":"1rem","fontWeight":"600"}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/location/" style="border-radius:9999px;color:#2b6374;border:2px solid #2b6374;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem;font-size:1rem;font-weight:600">Find Us</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">

<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="{$img}" alt="Premium free range beef at Saint Johns Butchery" loading="lazy"/></figure>
<!-- /wp:image -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

BLOCK;
}

function sjb_pattern_info_bar() {
	return <<<BLOCK

<!-- wp:group {"align":"full","className":"sjb-info-bar","style":{"color":{"background":"#ffffff"},"spacing":{"padding":{"top":"0","bottom":"0","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group alignfull sjb-info-bar has-background" style="background-color:#ffffff;padding-top:0;padding-right:1.5rem;padding-bottom:0;padding-left:1.5rem">

<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"0"}}}} -->
<div class="wp-block-columns alignwide">

<!-- wp:column {"style":{"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1rem","right":"1rem"}}}} -->
<div class="wp-block-column" style="padding-top:1.5rem;padding-right:1rem;padding-bottom:1.5rem;padding-left:1rem">
<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.875rem","fontWeight":"700"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.875rem;font-weight:700;margin-top:0;margin-bottom:0.25rem">✓ 100% Free Range</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.75rem"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.75rem;margin-top:0;margin-bottom:0">Ethically sourced from NZ farms</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1rem","right":"1rem"}}}} -->
<div class="wp-block-column" style="padding-top:1.5rem;padding-right:1rem;padding-bottom:1.5rem;padding-left:1rem">
<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.875rem","fontWeight":"700"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.875rem;font-weight:700;margin-top:0;margin-bottom:0.25rem">✦ Processed In Store</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.75rem"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.75rem;margin-top:0;margin-bottom:0">Cut fresh daily by our butchers</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1rem","right":"1rem"}}}} -->
<div class="wp-block-column" style="padding-top:1.5rem;padding-right:1rem;padding-bottom:1.5rem;padding-left:1rem">
<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.875rem","fontWeight":"700"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.875rem;font-weight:700;margin-top:0;margin-bottom:0.25rem">◷ Open 6 Days</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.75rem"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.75rem;margin-top:0;margin-bottom:0">Tue–Fri 7:30am–6pm, Sat–Sun 8am</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1rem","right":"1rem"}}}} -->
<div class="wp-block-column" style="padding-top:1.5rem;padding-right:1rem;padding-bottom:1.5rem;padding-left:1rem">
<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.875rem","fontWeight":"700"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.875rem;font-weight:700;margin-top:0;margin-bottom:0.25rem">⊡ Easy Parking</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.75rem"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.75rem;margin-top:0;margin-bottom:0">Corner of Felton Mathew Ave &amp; Merton Rd</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

BLOCK;
}

function sjb_pattern_about() {
	$img = SJB_IMG . 'images-Saint-Johns-Butchery-About.jpg';
	return <<<BLOCK

<!-- wp:group {"align":"wide","className":"sjb-about","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}}} -->
<div class="wp-block-group alignwide sjb-about" style="padding-top:5rem;padding-bottom:5rem">

<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"3rem","left":"4rem"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">

<!-- wp:image {"sizeSlug":"full"} -->
<figure class="wp-block-image size-full"><img src="{$img}" alt="Saint Johns Butchery team" loading="lazy"/></figure>
<!-- /wp:image -->

</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">

<!-- wp:heading {"level":2,"style":{"spacing":{"margin":{"top":"0","bottom":"1rem"}}}} -->
<h2 class="wp-block-heading" style="margin-top:0;margin-bottom:1rem">A family butchery since 1982</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#3a4650"},"typography":{"fontSize":"1.05rem"},"spacing":{"margin":{"top":"0","bottom":"1rem"}}}} -->
<p class="has-text-color" style="color:#3a4650;font-size:1.05rem;margin-top:0;margin-bottom:1rem">Saint Johns Butchery has been serving the St Johns community for over 40 years. We pride ourselves on sourcing only free range, ethically raised animals from New Zealand farms.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#3a4650"},"typography":{"fontSize":"1.05rem"},"spacing":{"margin":{"top":"0","bottom":"2rem"}}}} -->
<p class="has-text-color" style="color:#3a4650;font-size:1.05rem;margin-top:0;margin-bottom:2rem">Everything is processed in store by our experienced butchers, so you get the freshest cuts every time. From everyday mince to custom wedding orders — we do it all.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#2b6374","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"0.875rem","bottom":"0.875rem","left":"1.75rem","right":"1.75rem"}},"typography":{"fontSize":"0.95rem","fontWeight":"600"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="/contact/" style="border-radius:9999px;color:#ffffff;background-color:#2b6374;padding-top:0.875rem;padding-right:1.75rem;padding-bottom:0.875rem;padding-left:1.75rem;font-size:0.95rem;font-weight:600">Get in Touch</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

BLOCK;
}
