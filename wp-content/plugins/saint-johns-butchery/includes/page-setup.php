<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
   Block builder helpers
   ============================================================ */

/** Single product card as a wp:column → wp:group (no wp:html) */
function sjb_product_card_block( $title, $slug, $img_file, $alt, $desc ) {
	$img  = SJB_IMG . $img_file;
	$href = "/products/{$slug}/";
	return <<<BLOCK

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"sjb-product-card","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"color":{"background":"#ffffff"}}} -->
<div class="wp-block-group sjb-product-card has-background" style="background-color:#ffffff;padding:0">

<!-- wp:image {"sizeSlug":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<figure class="wp-block-image size-full" style="margin-top:0;margin-bottom:0"><img src="{$img}" alt="{$alt}" loading="lazy"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"sjb-product-card__body","style":{"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group sjb-product-card__body" style="padding:1.5rem">

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"top":"0","bottom":"0.5rem"}}}} -->
<h3 class="wp-block-heading" style="font-size:1.25rem;margin-top:0;margin-bottom:0.5rem">{$title}</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"top":"0","bottom":"1rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.875rem;margin-top:0;margin-bottom:1rem">{$desc}</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"sjb-card-link","style":{"color":{"text":"#2b6374","background":"transparent"},"border":{"radius":"0"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"0.85rem","fontWeight":"600"}}} -->
<div class="wp-block-button sjb-card-link"><a class="wp-block-button__link wp-element-button" href="{$href}" style="color:#2b6374;background-color:transparent;border-radius:0;padding:0;font-size:0.85rem;font-weight:600">View range →</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

BLOCK;
}

/** Page header (full-width sky gradient, breadcrumb + h1 + optional desc) */
function sjb_page_header_block( $title, $desc = '', $breadcrumbs = [] ) {
	$crumbs = '<a href="/">Home</a>';
	foreach ( $breadcrumbs as $label => $href ) {
		$crumbs .= ' <span style="color:#c4cad0">/</span> ';
		if ( $href ) {
			$crumbs .= '<a href="' . esc_attr( $href ) . '">' . esc_html( $label ) . '</a>';
		} else {
			$crumbs .= esc_html( $label );
		}
	}

	$desc_block = '';
	if ( $desc ) {
		$desc_block = <<<BLOCK

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"1.1rem"},"spacing":{"margin":{"top":"0.5rem","bottom":"0"}}}} -->
<p class="has-text-align-center has-text-color" style="color:#6b7b8a;font-size:1.1rem;margin-top:0.5rem;margin-bottom:0">{$desc}</p>
<!-- /wp:paragraph -->
BLOCK;
	}

	return <<<BLOCK

<!-- wp:group {"align":"full","className":"sjb-page-header","style":{"color":{"gradient":"linear-gradient(170deg,#e8f6f9 0%,#d0f0f5 60%,#ffffff 100%)"},"spacing":{"padding":{"top":"4rem","bottom":"3rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group alignfull sjb-page-header" style="background:linear-gradient(170deg,#e8f6f9 0%,#d0f0f5 60%,#ffffff 100%);padding-top:4rem;padding-right:1.5rem;padding-bottom:3rem;padding-left:1.5rem">

<!-- wp:paragraph {"align":"center","className":"sjb-breadcrumb","style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.8rem"},"spacing":{"margin":{"top":"0","bottom":"1rem"}}}} -->
<p class="has-text-align-center has-text-color sjb-breadcrumb" style="color:#6b7b8a;font-size:0.8rem;margin-top:0;margin-bottom:1rem">{$crumbs}</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"spacing":{"margin":{"top":"0","bottom":"0.5rem"}}}} -->
<h1 class="wp-block-heading has-text-align-center" style="margin-top:0;margin-bottom:0.5rem">{$title}</h1>
<!-- /wp:heading -->
{$desc_block}
</div>
<!-- /wp:group -->

BLOCK;
}

/** CTA banner (full-width green gradient) */
function sjb_cta_block( $heading, $body, $btn_text, $btn_href ) {
	return <<<BLOCK

<!-- wp:group {"align":"full","className":"sjb-cta","style":{"color":{"gradient":"linear-gradient(135deg,#5a9a1f 0%,#3d6e14 100%)"},"spacing":{"padding":{"top":"4rem","bottom":"4rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group alignfull sjb-cta" style="background:linear-gradient(135deg,#5a9a1f 0%,#3d6e14 100%);padding-top:4rem;padding-right:1.5rem;padding-bottom:4rem;padding-left:1.5rem">

<!-- wp:heading {"textAlign":"center","level":2,"style":{"color":{"text":"#ffffff"},"spacing":{"margin":{"top":"0","bottom":"0.5rem"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;margin-top:0;margin-bottom:0.5rem">{$heading}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.9)"},"typography":{"fontSize":"1.05rem"},"spacing":{"margin":{"top":"0","bottom":"2rem"}}}} -->
<p class="has-text-align-center has-text-color" style="color:rgba(255,255,255,0.9);font-size:1.05rem;margin-top:0;margin-bottom:2rem">{$body}</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#ffffff","text":"#3d6e14"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2rem","right":"2rem"}},"typography":{"fontSize":"1rem","fontWeight":"600"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="{$btn_href}" style="border-radius:9999px;color:#3d6e14;background-color:#ffffff;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem;font-size:1rem;font-weight:600">{$btn_text}</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->

BLOCK;
}

/** Two rows of 4 product cards */
function sjb_products_grid_block( $include_all = true ) {
	$row1  = sjb_product_card_block( 'Lamb',           'lamb',           'images-Saint-Johns-Butchery-Lamb.jpg',                 'Fresh free range lamb cuts',         'Premium free range lamb cuts, from racks to shanks.' );
	$row1 .= sjb_product_card_block( 'Beef',           'beef',           'images-Saint-Johns-Butchery-Beef1.jpg',                'Quality pasture-fed beef',           'From premium steaks to slow-cook cuts and mince.' );
	$row1 .= sjb_product_card_block( 'Pork',           'pork',           'images-Saint-Johns-Butchery-Pork.jpg',                 'Free range pork',                    'Free range pork including chops, roasts, and belly.' );
	$row1 .= sjb_product_card_block( 'Chicken',        'chicken',        'images-Saint-Johns-Butchery-Flavoured-Chicken.jpg',    'Free range chicken',                 'Whole chickens, portions, and our famous flavoured chicken.' );

	$row2  = sjb_product_card_block( 'Sausages',       'sausages',       'images-Hanging-Sausages.jpg',                          'Handmade sausages',                  'Handmade in store daily with a huge range of flavours.' );
	$row2 .= sjb_product_card_block( 'Specialty Meats','specialty-meats','images-Saint-Johns-Butchery-Specialty-Meats-Hams.jpg', 'Specialty and game meats',           'Venison, rabbit, duck, and other specialty meats.' );
	$row2 .= sjb_product_card_block( 'Small Goods',    'small-goods',    'images-Saint-Johns-Butchery-Small-Goods-Hams.jpg',     'Small goods, bacon, and ham',        'Bacon, ham, salami, and other deli favourites.' );
	$row2 .= sjb_product_card_block( 'Condiments',     'condiments',     'images-Four-Saucemen-Sauces-St-Johns.jpg',             'Sauces and condiments',              'Sauces, marinades, and condiments to complement your meal.' );

	return <<<BLOCK

<!-- wp:columns {"align":"wide","isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"top":"1.5rem","left":"1.5rem"},"margin":{"bottom":"1.5rem"}}}} -->
<div class="wp-block-columns alignwide" style="margin-bottom:1.5rem">{$row1}</div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide","isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"top":"1.5rem","left":"1.5rem"}}}} -->
<div class="wp-block-columns alignwide">{$row2}</div>
<!-- /wp:columns -->

BLOCK;
}

/** Product detail cuts list (wp:list — no wp:html) */
function sjb_cuts_list_block( array $cuts ) {
	$items = '';
	foreach ( $cuts as $cut ) {
		$items .= "\n<!-- wp:list-item --><li>" . esc_html( $cut ) . '</li><!-- /wp:list-item -->';
	}
	return <<<BLOCK

<!-- wp:list {"className":"sjb-product-list","style":{"spacing":{"padding":{"top":"1rem","bottom":"0"}}}} -->
<ul class="wp-block-list sjb-product-list" style="padding-top:1rem;padding-bottom:0">{$items}
</ul>
<!-- /wp:list -->

BLOCK;
}

/* ============================================================
   Page content functions
   ============================================================ */

/* ---- HOME ---- */
function sjb_home_content() {
	$img = SJB_IMG;

	$grid = sjb_products_grid_block();
	$cta  = sjb_cta_block(
		'Call &amp; Collect',
		"In a hurry? Call us with your order and we'll have it ready for quick collection. Custom meat packs available on request.",
		'Call 09 521 6319',
		'tel:095216319'
	);

	return <<<BLOCKS

<!-- wp:group {"align":"full","className":"sjb-hero","style":{"color":{"gradient":"linear-gradient(170deg,#e8f6f9 0%,#d0f0f5 40%,#ffffff 100%)"},"spacing":{"padding":{"top":"6rem","bottom":"4rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull sjb-hero" style="background:linear-gradient(170deg,#e8f6f9 0%,#d0f0f5 40%,#ffffff 100%);padding-top:6rem;padding-right:0;padding-bottom:4rem;padding-left:0">

<!-- wp:columns {"align":"wide","isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"left":"4rem"}}}} -->
<div class="wp-block-columns alignwide">

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">

<!-- wp:paragraph {"className":"sjb-badge","style":{"color":{"background":"#8cc63f","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"0.25rem","bottom":"0.25rem","left":"1rem","right":"1rem"},"margin":{"top":"0","bottom":"1.5rem"}},"typography":{"fontSize":"0.75rem","fontWeight":"700","textTransform":"uppercase","letterSpacing":"0.1em"}}} -->
<p class="sjb-badge has-text-color has-background" style="border-radius:9999px;color:#ffffff;background-color:#8cc63f;margin-top:0;margin-bottom:1.5rem;padding-top:0.25rem;padding-right:1rem;padding-bottom:0.25rem;padding-left:1rem;font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase">100% Free Range</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"clamp(2rem,5vw,3.2rem)","lineHeight":"1.2"},"spacing":{"margin":{"top":"0","bottom":"1.5rem"}}}} -->
<h1 class="wp-block-heading" style="font-size:clamp(2rem,5vw,3.2rem);line-height:1.2;margin-top:0;margin-bottom:1.5rem">Top Quality, <em style="font-style:normal;color:#2b6374">Free Range</em> Meats at Competitive Prices</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"1.1rem"},"spacing":{"margin":{"top":"0","bottom":"2rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:1.1rem;margin-top:0;margin-bottom:2rem">Your trusted local butcher in St Johns, East Auckland. We source only the finest free range meats, hand-cut and prepared fresh in store every day.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"blockGap":"1rem"}}} -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#2b6374","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2rem","right":"2rem"}},"typography":{"fontSize":"1rem","fontWeight":"600"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="/products/" style="border-radius:9999px;color:#ffffff;background-color:#2b6374;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem;font-size:1rem;font-weight:600">View Our Products</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline","style":{"color":{"text":"#2b6374"},"border":{"radius":"9999px","color":"#2b6374","width":"2px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2rem","right":"2rem"}},"typography":{"fontSize":"1rem","fontWeight":"600"}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color wp-element-button" href="/contact/" style="border-radius:9999px;border-color:#2b6374;border-width:2px;color:#2b6374;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem;font-size:1rem;font-weight:600">Get in Touch</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">

<!-- wp:image {"sizeSlug":"full","style":{"border":{"radius":"20px"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<figure class="wp-block-image size-full" style="border-radius:20px;margin-top:0;margin-bottom:0"><img src="{$img}images-bbq-sausages-and-onions.jpg" alt="Saint Johns Butchery sausages on the BBQ" loading="eager"/></figure>
<!-- /wp:image -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"sjb-info-bar","style":{"color":{"background":"#ffffff"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull sjb-info-bar has-background" style="background-color:#ffffff;padding:0">

<!-- wp:columns {"align":"wide","isStackedOnMobile":false} -->
<div class="wp-block-columns alignwide">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="margin-top:0;margin-bottom:0.25rem">✓ 100% Free Range</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin:0">Ethically sourced meats</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="margin-top:0;margin-bottom:0.25rem">✦ Processed In Store</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin:0">Cut fresh daily</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="margin-top:0;margin-bottom:0.25rem">◷ Open 6 Days</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin:0">Tue–Sun, closed Mon</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="margin-top:0;margin-bottom:0.25rem">⊡ Easy Parking</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin:0">Off-street parking available</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"sjb-about","style":{"color":{"background":"#f8fafb"},"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull sjb-about has-background" style="background-color:#f8fafb;padding-top:6rem;padding-right:0;padding-bottom:6rem;padding-left:0">

<!-- wp:columns {"align":"wide","isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"left":"4rem"}}}} -->
<div class="wp-block-columns alignwide">

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">
<!-- wp:image {"sizeSlug":"full","style":{"border":{"radius":"12px"}}} -->
<figure class="wp-block-image size-full" style="border-radius:12px"><img src="{$img}images-Saint-Johns-Butchery-Storefront-and-Neighbours-April2018.jpg" alt="Saint Johns Butchery storefront" loading="lazy"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">

<!-- wp:heading {"level":2,"style":{"spacing":{"margin":{"top":"0","bottom":"1.5rem"}}}} -->
<h2 class="wp-block-heading" style="margin-top:0;margin-bottom:1.5rem">Your Trusted Local Butcher</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"}}} -->
<p class="has-text-color" style="color:#6b7b8a">Welcome to Saint Johns Butchery, where we pride ourselves on offering top quality, free range meats at competitive prices. All of our meats are free range and processed in store, so you can be sure of freshness and quality every time.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"}}} -->
<p class="has-text-color" style="color:#6b7b8a">We provide dairy-free and gluten-free products. If you can't find what you're looking for, let us know and we'll do our best to get it for you. We also offer custom packing on request.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;margin-bottom:2rem">Whether you're after the perfect Sunday roast, a weeknight stir-fry, or gourmet sausages for the BBQ, we've got you covered.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#2b6374","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="/contact/" style="border-radius:9999px;color:#ffffff;background-color:#2b6374;padding-top:0.75rem;padding-right:1.5rem;padding-bottom:0.75rem;padding-left:1.5rem">Contact Us</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"color":{"background":"#f1f3f5"},"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull has-background" style="background-color:#f1f3f5;padding-top:6rem;padding-right:0;padding-bottom:6rem;padding-left:0">

<!-- wp:heading {"textAlign":"center","level":2,"className":"sjb-section-heading","style":{"spacing":{"margin":{"top":"0","bottom":"0.75rem"}}}} -->
<h2 class="wp-block-heading has-text-align-center sjb-section-heading" style="margin-top:0;margin-bottom:0.75rem">Our Products</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"sjb-section-desc","style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"1.05rem"},"spacing":{"margin":{"top":"0","bottom":"3rem"}}}} -->
<p class="has-text-align-center has-text-color sjb-section-desc" style="color:#6b7b8a;font-size:1.05rem;margin-top:0;margin-bottom:3rem">An amazing selection of free range meats, all processed in store. From sausages and steaks to ham and chicken.</p>
<!-- /wp:paragraph -->

{$grid}

</div>
<!-- /wp:group -->

{$cta}

BLOCKS;
}

/* ---- PRODUCTS overview ---- */
function sjb_products_content() {
	$grid = sjb_products_grid_block();
	$header = sjb_page_header_block(
		'Our Products',
		'Top quality, free range meats — all processed in store and cut fresh every day.',
		[ 'Products' => null ]
	);
	$cta = sjb_cta_block(
		"Can't Find What You Need?",
		"We can source and custom cut almost anything. Get in touch and we'll sort it out for you.",
		'Call 09 521 6319',
		'tel:095216319'
	);

	return <<<BLOCKS
{$header}

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:6rem;padding-right:0;padding-bottom:6rem;padding-left:0">
{$grid}
</div>
<!-- /wp:group -->

{$cta}
BLOCKS;
}

/* ---- PRODUCT DETAIL (generic) ---- */
function sjb_product_detail_content( array $data ) {
	$img    = SJB_IMG . $data['image'];
	$title  = $data['title'];
	$alt    = $data['alt'];
	$desc   = $data['description'];
	$cuts   = sjb_cuts_list_block( $data['cuts'] );
	$header = sjb_page_header_block( $title, '', [ 'Products' => '/products/', $title => null ] );
	$cta    = sjb_cta_block(
		'Fresh Cut Every Day',
		'All our meats are processed in store daily. Call ahead for custom cuts or large orders.',
		'Call 09 521 6319',
		'tel:095216319'
	);

	return <<<BLOCKS
{$header}

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:6rem;padding-right:0;padding-bottom:6rem;padding-left:0">

<!-- wp:columns {"align":"wide","isStackedOnMobile":true,"className":"sjb-product-detail","style":{"spacing":{"blockGap":{"left":"4rem"}}}} -->
<div class="wp-block-columns alignwide sjb-product-detail">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:image {"sizeSlug":"full","style":{"border":{"radius":"12px"}}} -->
<figure class="wp-block-image size-full" style="border-radius:12px"><img src="{$img}" alt="{$alt}" loading="lazy"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">

<!-- wp:heading {"level":2,"style":{"spacing":{"margin":{"top":"0","bottom":"1.5rem"}}}} -->
<h2 class="wp-block-heading" style="margin-top:0;margin-bottom:1.5rem">About Our {$title}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"}}} -->
<p class="has-text-color" style="color:#6b7b8a">{$desc}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"spacing":{"margin":{"bottom":"0.5rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;margin-bottom:0.5rem">All cuts are available from our store at the corner of Felton Mathew Ave and Merton Rd, St Johns. Call ahead and we'll have your order ready.</p>
<!-- /wp:paragraph -->

{$cuts}

<!-- wp:buttons {"style":{"spacing":{"blockGap":"1rem","margin":{"top":"2rem"}}}} -->
<div class="wp-block-buttons" style="margin-top:2rem">
<!-- wp:button {"style":{"color":{"background":"#2b6374","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="tel:095216319" style="border-radius:9999px;color:#ffffff;background-color:#2b6374;padding:0.75rem 1.5rem">Call to Order</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline","style":{"color":{"text":"#2b6374"},"border":{"radius":"9999px","color":"#2b6374","width":"2px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color wp-element-button" href="/contact/" style="border-radius:9999px;border-color:#2b6374;border-width:2px;color:#2b6374;padding:0.75rem 1.5rem">Contact Us</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

{$cta}
BLOCKS;
}

/* ---- RECIPES ---- */
function sjb_recipes_content() {
	$img    = SJB_IMG;
	$header = sjb_page_header_block(
		'Recipes',
		'Make the most of your free range meats with these simple, delicious recipes from our butchers.',
		[ 'Recipes' => null ]
	);

	return <<<BLOCKS
{$header}

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:6rem;padding-right:0;padding-bottom:6rem;padding-left:0">

<!-- wp:group {"align":"wide","className":"sjb-recipe-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignwide sjb-recipe-card has-background" style="background-color:#ffffff;border-radius:12px;padding:0">
<!-- wp:columns {"isStackedOnMobile":true} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"280px"} -->
<div class="wp-block-column" style="flex-basis:280px">
<!-- wp:image {"sizeSlug":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<figure class="wp-block-image size-full" style="margin:0"><img src="{$img}images-bbq-sausages-and-onions.jpg" alt="BBQ sausages" loading="lazy"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-group" style="padding:2rem">
<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"1.4rem"},"spacing":{"margin":{"top":"0","bottom":"0.5rem"}}}} -->
<h2 class="wp-block-heading" style="font-size:1.4rem;margin-top:0;margin-bottom:0.5rem">Classic NZ BBQ Sausages with Caramelised Onions</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"sjb-recipe-meta","style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.8rem"},"spacing":{"margin":{"top":"0","bottom":"1rem"}}}} -->
<p class="sjb-recipe-meta has-text-color" style="color:#6b7b8a;font-size:0.8rem;margin-top:0;margin-bottom:1rem">Prep: 10 min &nbsp;·&nbsp; Cook: 20 min &nbsp;·&nbsp; Serves: 4</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.9rem"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.9rem;margin-bottom:1rem">The quintessential Kiwi BBQ — our handmade pork &amp; fennel sausages paired with sweet caramelised onions.</p>
<!-- /wp:paragraph -->
<!-- wp:details {"className":"sjb-recipe-accordion"} -->
<details class="wp-block-details sjb-recipe-accordion"><summary>Ingredients</summary>
<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item --><li>8 Saint Johns Butchery pork &amp; fennel sausages</li><!-- /wp:list-item --><!-- wp:list-item --><li>2 large onions, thinly sliced</li><!-- /wp:list-item --><!-- wp:list-item --><li>2 tbsp butter, 1 tbsp brown sugar, 1 tbsp balsamic vinegar</li><!-- /wp:list-item --><!-- wp:list-item --><li>Salt and pepper to taste</li><!-- /wp:list-item --><!-- wp:list-item --><li>Burger buns and condiments to serve (optional)</li><!-- /wp:list-item --></ul>
<!-- /wp:list -->
</details>
<!-- /wp:details -->
<!-- wp:details {"className":"sjb-recipe-accordion"} -->
<details class="wp-block-details sjb-recipe-accordion"><summary>Method</summary>
<!-- wp:list {"ordered":true,"className":"sjb-recipe-method"} -->
<ol class="wp-block-list sjb-recipe-method"><!-- wp:list-item --><li>Preheat BBQ or grill to medium heat.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Melt butter in a pan over medium-low heat. Add onions and salt. Cook, stirring, for 15 minutes until golden.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Add brown sugar and balsamic vinegar. Cook a further 5 minutes until caramelised.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Cook sausages on the BBQ, turning regularly, for 12–15 minutes until cooked through.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Serve sausages topped with caramelised onions.</li><!-- /wp:list-item --></ol>
<!-- /wp:list -->
</details>
<!-- /wp:details -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"sjb-recipe-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignwide sjb-recipe-card has-background" style="background-color:#ffffff;border-radius:12px;padding:0">
<!-- wp:columns {"isStackedOnMobile":true} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"280px"} -->
<div class="wp-block-column" style="flex-basis:280px">
<!-- wp:image {"sizeSlug":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<figure class="wp-block-image size-full" style="margin:0"><img src="{$img}images-Saint-Johns-Butchery-Lamb.jpg" alt="Lamb shanks" loading="lazy"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-group" style="padding:2rem">
<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"1.4rem"},"spacing":{"margin":{"top":"0","bottom":"0.5rem"}}}} -->
<h2 class="wp-block-heading" style="font-size:1.4rem;margin-top:0;margin-bottom:0.5rem">Slow-Braised Lamb Shanks with Red Wine &amp; Rosemary</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"sjb-recipe-meta","style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.8rem"},"spacing":{"margin":{"top":"0","bottom":"1rem"}}}} -->
<p class="sjb-recipe-meta has-text-color" style="color:#6b7b8a;font-size:0.8rem;margin-top:0;margin-bottom:1rem">Prep: 20 min &nbsp;·&nbsp; Cook: 2.5 hrs &nbsp;·&nbsp; Serves: 4</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.9rem"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.9rem;margin-bottom:1rem">A classic winter warmer. Free range lamb shanks braised low and slow in red wine until the meat falls off the bone.</p>
<!-- /wp:paragraph -->
<!-- wp:details {"className":"sjb-recipe-accordion"} -->
<details class="wp-block-details sjb-recipe-accordion"><summary>Ingredients</summary>
<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item --><li>4 free range lamb shanks</li><!-- /wp:list-item --><!-- wp:list-item --><li>2 onions (diced), 3 carrots (chopped), 4 garlic cloves (crushed)</li><!-- /wp:list-item --><!-- wp:list-item --><li>1 cup red wine, 2 x 400g tins crushed tomatoes, 1 cup beef stock</li><!-- /wp:list-item --><!-- wp:list-item --><li>2 sprigs rosemary, 3 sprigs thyme, olive oil, salt and pepper</li><!-- /wp:list-item --></ul>
<!-- /wp:list -->
</details>
<!-- /wp:details -->
<!-- wp:details {"className":"sjb-recipe-accordion"} -->
<details class="wp-block-details sjb-recipe-accordion"><summary>Method</summary>
<!-- wp:list {"ordered":true,"className":"sjb-recipe-method"} -->
<ol class="wp-block-list sjb-recipe-method"><!-- wp:list-item --><li>Preheat oven to 160°C. Season shanks and brown all sides in hot oil (8 min). Remove.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Sauté onions, carrots, garlic for 5 minutes. Pour in wine; simmer 2 minutes.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Add tomatoes, stock, herbs, and shanks. Cover and braise 2–2.5 hours until meat is falling off the bone.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Serve over creamy mashed potato.</li><!-- /wp:list-item --></ol>
<!-- /wp:list -->
</details>
<!-- /wp:details -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"sjb-recipe-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignwide sjb-recipe-card has-background" style="background-color:#ffffff;border-radius:12px;padding:0">
<!-- wp:columns {"isStackedOnMobile":true} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"280px"} -->
<div class="wp-block-column" style="flex-basis:280px">
<!-- wp:image {"sizeSlug":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<figure class="wp-block-image size-full" style="margin:0"><img src="{$img}images-Saint-Johns-Butchery-Beef1.jpg" alt="Eye fillet steak" loading="lazy"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-group" style="padding:2rem">
<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"1.4rem"},"spacing":{"margin":{"top":"0","bottom":"0.5rem"}}}} -->
<h2 class="wp-block-heading" style="font-size:1.4rem;margin-top:0;margin-bottom:0.5rem">Pan-Seared Eye Fillet with Garlic Herb Butter</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"sjb-recipe-meta","style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.8rem"},"spacing":{"margin":{"top":"0","bottom":"1rem"}}}} -->
<p class="sjb-recipe-meta has-text-color" style="color:#6b7b8a;font-size:0.8rem;margin-top:0;margin-bottom:1rem">Prep: 10 min &nbsp;·&nbsp; Cook: 10 min &nbsp;·&nbsp; Serves: 2</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.9rem"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.9rem;margin-bottom:1rem">The king of steaks, simply cooked. Let the quality of the meat do the talking.</p>
<!-- /wp:paragraph -->
<!-- wp:details {"className":"sjb-recipe-accordion"} -->
<details class="wp-block-details sjb-recipe-accordion"><summary>Ingredients</summary>
<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item --><li>2 eye fillet steaks (200g each, ~4cm thick)</li><!-- /wp:list-item --><!-- wp:list-item --><li>1 tbsp neutral oil, 50g butter, 3 garlic cloves (crushed)</li><!-- /wp:list-item --><!-- wp:list-item --><li>Fresh thyme, rosemary, flaky salt and black pepper</li><!-- /wp:list-item --></ul>
<!-- /wp:list -->
</details>
<!-- /wp:details -->
<!-- wp:details {"className":"sjb-recipe-accordion"} -->
<details class="wp-block-details sjb-recipe-accordion"><summary>Method</summary>
<!-- wp:list {"ordered":true,"className":"sjb-recipe-method"} -->
<ol class="wp-block-list sjb-recipe-method"><!-- wp:list-item --><li>Remove steaks from fridge 30 min before cooking. Pat dry, season generously.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Heat a heavy pan until smoking. Add oil and sear steaks 2.5 min per side.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Add butter, garlic, and herbs. Baste steaks continuously for 1–2 minutes.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Rest for 5 minutes before serving.</li><!-- /wp:list-item --></ol>
<!-- /wp:list -->
</details>
<!-- /wp:details -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
BLOCKS;
}

/* ---- LOCATION ---- */
function sjb_location_content() {
	$header = sjb_page_header_block(
		'Find Us',
		"We're in St Johns, East Auckland — easy to find with plenty of off-street parking.",
		[ 'Location' => null ]
	);

	return <<<BLOCKS
{$header}

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:6rem;padding-right:0;padding-bottom:6rem;padding-left:0">

<!-- wp:columns {"align":"wide","isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"left":"2rem"}}}} -->
<div class="wp-block-columns alignwide">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"sjb-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-group sjb-card has-background" style="background-color:#ffffff;border-radius:12px;padding:2rem">

<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0","bottom":"1.5rem"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0;margin-bottom:1.5rem">Opening Hours</h3>
<!-- /wp:heading -->

<!-- wp:table {"className":"sjb-hours-table","style":{"spacing":{"margin":{"top":"0"}}}} -->
<figure class="wp-block-table sjb-hours-table" style="margin-top:0"><table><tbody>
<tr class="sjb-closed"><td><strong>Monday</strong></td><td>Closed</td></tr>
<tr><td><strong>Tuesday</strong></td><td>7:30am – 6:00pm</td></tr>
<tr><td><strong>Wednesday</strong></td><td>7:30am – 6:00pm</td></tr>
<tr><td><strong>Thursday</strong></td><td>7:30am – 6:00pm</td></tr>
<tr><td><strong>Friday</strong></td><td>7:30am – 6:00pm</td></tr>
<tr><td><strong>Saturday</strong></td><td>8:00am – 6:00pm</td></tr>
<tr><td><strong>Sunday</strong></td><td>8:30am – 5:00pm</td></tr>
</tbody></table></figure>
<!-- /wp:table -->

</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"sjb-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-group sjb-card has-background" style="background-color:#ffffff;border-radius:12px;padding:2rem">

<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0","bottom":"1.5rem"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0;margin-bottom:1.5rem">Contact &amp; Address</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.85rem"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.85rem;margin-top:0;margin-bottom:0.25rem">Address</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.875rem;margin-bottom:1.5rem">Corner of Felton Mathew Ave &amp; Merton Rd<br>St Johns, Auckland, New Zealand</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.85rem"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.85rem;margin-top:0;margin-bottom:0.25rem">Phone</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.875rem;margin-bottom:1.5rem"><a href="tel:095216319" style="color:#2b6374">09 521 6319</a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.85rem"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.85rem;margin-top:0;margin-bottom:0.25rem">Email</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.875rem;margin-bottom:1.5rem"><a href="mailto:dave@saintjohnsbutchery.co.nz" style="color:#2b6374">dave@saintjohnsbutchery.co.nz</a></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"style":{"color":{"background":"#2b6374","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="https://maps.google.com/?q=Saint+Johns+Butchery+St+Johns+Auckland" target="_blank" rel="noopener noreferrer" style="border-radius:9999px;color:#ffffff;background-color:#2b6374;padding:0.75rem 1.5rem">View on Google Maps</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->
BLOCKS;
}

/* ---- CONTACT ---- */
function sjb_contact_content() {
	$header = sjb_page_header_block(
		'Get in Touch',
		'Have a question or want to place a custom order? We\'d love to hear from you.',
		[ 'Contact' => null ]
	);
	$cta = sjb_cta_block(
		'Prefer to Talk?',
		"Give us a call during business hours and we'll help straight away.",
		'Call 09 521 6319',
		'tel:095216319'
	);

	return <<<BLOCKS
{$header}

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem","left":"0","right":"0"}}}} -->
<div class="wp-block-group alignfull" style="padding-top:6rem;padding-right:0;padding-bottom:6rem;padding-left:0">

<!-- wp:columns {"align":"wide","isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"left":"2rem"}}}} -->
<div class="wp-block-columns alignwide">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"sjb-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-group sjb-card has-background" style="background-color:#ffffff;border-radius:12px;padding:2rem">

<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0","bottom":"0.5rem"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0;margin-bottom:0.5rem">Contact Info</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.9rem"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.9rem;margin-bottom:1.5rem">For orders and enquiries, call us during business hours or send us an email.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.85rem"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.85rem;margin-top:0;margin-bottom:0.25rem">Phone</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"1.25rem"}}}} -->
<p style="margin-bottom:1.25rem"><a href="tel:095216319" style="color:#2b6374;font-weight:600;font-size:1.1rem">09 521 6319</a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.85rem"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.85rem;margin-top:0;margin-bottom:0.25rem">Email</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"1.25rem"}}}} -->
<p style="margin-bottom:1.25rem"><a href="mailto:dave@saintjohnsbutchery.co.nz" style="color:#2b6374">dave@saintjohnsbutchery.co.nz</a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.85rem"},"spacing":{"margin":{"top":"0","bottom":"0.25rem"}}}} -->
<h4 class="wp-block-heading" style="font-size:0.85rem;margin-top:0;margin-bottom:0.25rem">Address</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"spacing":{"margin":{"bottom":"0"}}}} -->
<p class="has-text-color" style="color:#6b7b8a;margin-bottom:0">Corner of Felton Mathew Ave &amp; Merton Rd<br>St Johns, Auckland</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"sjb-card","style":{"color":{"background":"#ffffff"},"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-group sjb-card has-background" style="background-color:#ffffff;border-radius:12px;padding:2rem">

<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0","bottom":"1.5rem"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0;margin-bottom:1.5rem">Opening Hours</h3>
<!-- /wp:heading -->

<!-- wp:table {"className":"sjb-hours-table"} -->
<figure class="wp-block-table sjb-hours-table"><table><tbody>
<tr class="sjb-closed"><td><strong>Monday</strong></td><td>Closed</td></tr>
<tr><td><strong>Tue – Fri</strong></td><td>7:30am – 6:00pm</td></tr>
<tr><td><strong>Saturday</strong></td><td>8:00am – 6:00pm</td></tr>
<tr><td><strong>Sunday</strong></td><td>8:30am – 5:00pm</td></tr>
</tbody></table></figure>
<!-- /wp:table -->

<!-- wp:separator {"style":{"spacing":{"margin":{"top":"1.5rem","bottom":"1.5rem"}}},"className":"is-style-wide"} -->
<hr class="wp-block-separator is-style-wide" style="margin-top:1.5rem;margin-bottom:1.5rem"/>
<!-- /wp:separator -->

<!-- wp:paragraph {"style":{"color":{"text":"#6b7b8a"},"typography":{"fontSize":"0.875rem"}}} -->
<p class="has-text-color" style="color:#6b7b8a;font-size:0.875rem">To place an order or enquire about custom cuts, the easiest way is to call us during business hours. We're always happy to help.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"1.5rem"}}}} -->
<div class="wp-block-buttons" style="margin-top:1.5rem">
<!-- wp:button {"style":{"color":{"background":"#2b6374","text":"#ffffff"},"border":{"radius":"9999px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" href="tel:095216319" style="border-radius:9999px;color:#ffffff;background-color:#2b6374;padding:0.75rem 1.5rem">Call 09 521 6319</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

{$cta}
BLOCKS;
}

/* ============================================================
   Product page data
   ============================================================ */
function sjb_get_product_pages() {
	return [
		'lamb' => [
			'title'       => 'Lamb',
			'image'       => 'images-Saint-Johns-Butchery-Lamb.jpg',
			'alt'         => 'Fresh free range lamb cuts at Saint Johns Butchery',
			'description' => 'Our lamb is sourced from New Zealand\'s finest free range farms — animals that graze on lush green pasture. Every cut is prepared fresh in store by our experienced butchers, ensuring outstanding quality and flavour.',
			'cuts'        => [ 'Lamb Rack', 'Lamb Cutlets', 'Lamb Chops', 'Lamb Loin Chops', 'Lamb Shoulder (bone-in)', 'Lamb Shoulder (boneless)', 'Lamb Leg (bone-in)', 'Lamb Leg (boneless)', 'Lamb Shanks', 'Lamb Mince', 'Lamb Stir Fry', 'Lamb Sausages', 'Lamb Ribs' ],
		],
		'beef' => [
			'title'       => 'Beef',
			'image'       => 'images-Saint-Johns-Butchery-Beef1.jpg',
			'alt'         => 'Quality pasture-fed beef at Saint Johns Butchery',
			'description' => 'All our beef is sourced from grass-fed, pasture-raised New Zealand cattle. Pasture-fed beef is naturally richer in flavour and higher in beneficial omega-3 fatty acids. Our butchers hand-select each animal and prepare every cut fresh in store.',
			'cuts'        => [ 'Eye Fillet (Tenderloin)', 'Scotch Fillet / Ribeye', 'Sirloin Steak', 'Rump Steak', 'T-Bone Steak', 'Flat Iron Steak', 'Beef Mince', 'Beef Stir Fry', 'Chuck Steak', 'Blade Steak', 'Oxtail', 'Short Ribs', 'Brisket', 'Topside Roast', 'Silverside', 'Osso Bucco', 'Corned Beef' ],
		],
		'pork' => [
			'title'       => 'Pork',
			'image'       => 'images-Saint-Johns-Butchery-Pork.jpg',
			'alt'         => 'Free range pork at Saint Johns Butchery',
			'description' => 'Our pork comes from free range farms where pigs are raised outdoors on a natural diet. Ask our butchers about seasonal specials, and we can score pork skin to guarantee perfect crackling every time.',
			'cuts'        => [ 'Pork Loin Chops', 'Pork Shoulder Chops', 'Pork Belly (whole & sliced)', 'Pork Shoulder Roast', 'Pork Leg Roast', 'Pork Scotch Fillet', 'Pork Mince', 'Pork Stir Fry', 'Pork Ribs', 'Pork Spare Ribs', 'Pork Knuckle', 'Pork Neck Steaks' ],
		],
		'chicken' => [
			'title'       => 'Chicken',
			'image'       => 'images-Saint-Johns-Butchery-Flavoured-Chicken.jpg',
			'alt'         => 'Free range chicken at Saint Johns Butchery',
			'description' => 'Our chicken is sourced from free range farms where birds have access to outdoor areas. We stock a full range from whole birds to individual portions, plus our popular range of marinated and flavoured chicken.',
			'cuts'        => [ 'Whole Chicken', 'Chicken Breasts', 'Chicken Thighs (bone-in)', 'Chicken Thighs (boneless)', 'Chicken Drumsticks', 'Chicken Wings', 'Chicken Nibbles', 'Chicken Mince', 'Marinated Lemon & Herb Thighs', 'Marinated Satay Thighs', 'Marinated BBQ Thighs', 'Spatchcock Chicken' ],
		],
		'sausages' => [
			'title'       => 'Sausages',
			'image'       => 'images-Hanging-Sausages.jpg',
			'alt'         => 'Handmade sausages at Saint Johns Butchery',
			'description' => 'Our sausages are made fresh in store every day using our own recipes and quality free range meats. We use natural casings and real ingredients — no fillers or artificial preservatives. Gluten-free options are available; just ask.',
			'cuts'        => [ 'Pork & Fennel', 'Pork & Leek', 'Traditional Pork', 'Beef & Caramelised Onion', 'Beef & Pepper', 'Lamb & Rosemary', 'Lamb & Mint', 'Chicken & Herb', 'Chicken & Sundried Tomato', 'Chorizo-style', 'Italian-style', 'Venison', 'Gluten-Free (ask in store)' ],
		],
		'specialty-meats' => [
			'title'       => 'Specialty Meats',
			'image'       => 'images-Saint-Johns-Butchery-Specialty-Meats-Hams.jpg',
			'alt'         => 'Specialty and game meats at Saint Johns Butchery',
			'description' => 'Explore our range of specialty and game meats sourced from quality New Zealand producers. From delicate venison to rich duck, these meats offer a unique flavour experience. We can also source less common meats on request.',
			'cuts'        => [ 'Venison (farmed & wild)', 'Rabbit', 'Duck (whole & portions)', 'Quail', 'Hare', 'Turkey (seasonal)', 'Ox Tongue', 'Lamb Kidney', 'Beef Kidney', 'Chicken Liver', 'Lamb Liver', 'Beef Liver', 'Beef Heart' ],
		],
		'small-goods' => [
			'title'       => 'Small Goods',
			'image'       => 'images-Saint-Johns-Butchery-Small-Goods-Hams.jpg',
			'alt'         => 'Small goods, bacon and ham at Saint Johns Butchery',
			'description' => 'Our small goods are sourced from quality New Zealand producers who share our values around animal welfare and food quality. From thick-cut bacon to premium whole leg hams, our deli range is ideal for breakfast and entertaining.',
			'cuts'        => [ 'Streaky Bacon', 'Middle Bacon', 'Back Bacon', 'Thick-Cut Bacon', 'Whole Leg Ham', 'Half Leg Ham', 'Boneless Leg Ham', 'Salami', 'Prosciutto', 'Chorizo (cured)', 'Kabana', 'Smoked Chicken', 'Pastrami', 'Cooked Corned Beef' ],
		],
		'condiments' => [
			'title'       => 'Condiments',
			'image'       => 'images-Four-Saucemen-Sauces-St-Johns.jpg',
			'alt'         => 'Sauces and condiments at Saint Johns Butchery',
			'description' => 'Complement your meat with our curated range of sauces, marinades, and condiments. We stock the popular Four Saucemen range made in New Zealand, along with mustards, relishes, and rubs that pair perfectly with everything from a Sunday roast to a weeknight BBQ.',
			'cuts'        => [ 'Four Saucemen BBQ Sauce', 'Four Saucemen Hot Sauce', 'Four Saucemen Chipotle', 'Dijon Mustard', 'Wholegrain Mustard', 'Honey Mustard', 'Apple & Mint Jelly', 'Redcurrant Jelly', 'Herb & Garlic Rub', 'Smoky BBQ Rub', 'Cajun Spice Mix', 'Teriyaki Marinade', 'Lemon & Herb Marinade' ],
		],
	];
}

/* ============================================================
   Main page creator
   ============================================================ */
function sjb_create_pages() {
	$home_id = sjb_upsert_page( 'Home', 'home', sjb_home_content(), 0 );
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	$products_id = sjb_upsert_page( 'Products', 'products', sjb_products_content(), 0 );

	foreach ( sjb_get_product_pages() as $slug => $data ) {
		sjb_upsert_page( $data['title'], $slug, sjb_product_detail_content( $data ), $products_id ?: 0 );
	}

	sjb_upsert_page( 'Recipes',  'recipes',  sjb_recipes_content(),  0 );
	sjb_upsert_page( 'Location', 'location', sjb_location_content(), 0 );
	sjb_upsert_page( 'Contact',  'contact',  sjb_contact_content(),  0 );
}

function sjb_upsert_page( $title, $slug, $content, $parent ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) return (int) $existing->ID;
	return wp_insert_post( [
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_parent'  => $parent,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	] );
}
