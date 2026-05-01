<?php
/**
 * Register reusable block patterns so editors can insert
 * any SJB section from the Inserter → Patterns tab.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'sjb_register_block_pattern_category' );
function sjb_register_block_pattern_category() {
	register_block_pattern_category( 'saint-johns-butchery', [
		'label' => __( 'Saint Johns Butchery', 'saint-johns-butchery' ),
	] );
}

add_action( 'init', 'sjb_register_block_patterns' );
function sjb_register_block_patterns() {
	$img = SJB_IMG;

	/* ---- Hero Section ---- */
	register_block_pattern( 'sjb/hero', [
		'title'      => __( 'SJB Hero Section', 'saint-johns-butchery' ),
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => <<<HTML
<!-- wp:html -->
<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-badge">100% Free Range</div>
      <h1>Top Quality, <em>Free Range</em> Meats at Competitive Prices</h1>
      <p class="hero-text">Your trusted local butcher in St Johns, East Auckland. We source only the finest free range meats, hand-cut and prepared fresh in store every day.</p>
      <div class="hero-actions">
        <a href="/products/" class="btn btn--primary btn--lg">View Our Products</a>
        <a href="/contact/" class="btn btn--secondary btn--lg">Get in Touch</a>
      </div>
    </div>
    <div class="hero-image">
      <img src="{$img}images-bbq-sausages-and-onions.jpg" alt="Saint Johns Butchery sausages on the BBQ" width="800" height="480" loading="eager">
    </div>
  </div>
</section>
<!-- /wp:html -->
HTML,
	] );

	/* ---- Info Bar ---- */
	register_block_pattern( 'sjb/info-bar', [
		'title'      => __( 'SJB Info Bar', 'saint-johns-butchery' ),
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => <<<'HTML'
<!-- wp:html -->
<section class="info-bar">
  <div class="container">
    <div class="info-item">
      <div class="info-item__icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div class="info-item__text"><strong>100% Free Range</strong><span>Ethically sourced meats</span></div>
    </div>
    <div class="info-item">
      <div class="info-item__icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
      </div>
      <div class="info-item__text"><strong>Processed In Store</strong><span>Cut fresh daily</span></div>
    </div>
    <div class="info-item">
      <div class="info-item__icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div class="info-item__text"><strong>Open 6 Days</strong><span>Tue–Sun, closed Mon</span></div>
    </div>
    <div class="info-item">
      <div class="info-item__icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
      </div>
      <div class="info-item__text"><strong>Easy Parking</strong><span>Off-street parking available</span></div>
    </div>
  </div>
</section>
<!-- /wp:html -->
HTML,
	] );

	/* ---- CTA Banner ---- */
	register_block_pattern( 'sjb/cta-banner', [
		'title'      => __( 'SJB Call & Collect Banner', 'saint-johns-butchery' ),
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => <<<'HTML'
<!-- wp:html -->
<section class="cta-banner">
  <div class="container">
    <h2>Call &amp; Collect</h2>
    <p>In a hurry? Call us with your order and we'll have it ready for quick collection. Custom meat packs available on request.</p>
    <a href="tel:095216319" class="btn btn--primary btn--lg">Call 09 521 6319</a>
  </div>
</section>
<!-- /wp:html -->
HTML,
	] );

	/* ---- Page Header ---- */
	register_block_pattern( 'sjb/page-header', [
		'title'      => __( 'SJB Page Header', 'saint-johns-butchery' ),
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => <<<'HTML'
<!-- wp:html -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>/</span><span>Page Title</span>
    </nav>
    <h1>Page Title</h1>
    <p>A short description of this page goes here.</p>
  </div>
</div>
<!-- /wp:html -->
HTML,
	] );

	/* ---- Opening Hours Card ---- */
	register_block_pattern( 'sjb/hours-card', [
		'title'      => __( 'SJB Opening Hours Card', 'saint-johns-butchery' ),
		'categories' => [ 'saint-johns-butchery' ],
		'content'    => <<<'HTML'
<!-- wp:html -->
<div class="card">
  <h3>Opening Hours</h3>
  <table class="hours-table">
    <tbody>
      <tr class="closed"><td>Monday</td><td>Closed</td></tr>
      <tr><td>Tuesday</td><td>7:30am – 6:00pm</td></tr>
      <tr><td>Wednesday</td><td>7:30am – 6:00pm</td></tr>
      <tr><td>Thursday</td><td>7:30am – 6:00pm</td></tr>
      <tr><td>Friday</td><td>7:30am – 6:00pm</td></tr>
      <tr><td>Saturday</td><td>8:00am – 6:00pm</td></tr>
      <tr><td>Sunday</td><td>8:30am – 5:00pm</td></tr>
    </tbody>
  </table>
</div>
<!-- /wp:html -->
HTML,
	] );

	/* ---- Product Card (single, reusable) ---- */
	register_block_pattern( 'sjb/product-card', [
		'title'       => __( 'SJB Product Card', 'saint-johns-butchery' ),
		'categories'  => [ 'saint-johns-butchery' ],
		'description' => __( 'Single product card. Duplicate and adjust for additional products.', 'saint-johns-butchery' ),
		'content'     => <<<HTML
<!-- wp:html -->
<a href="/products/lamb/" class="product-card">
  <div class="product-card__image">
    <img src="{$img}images-Saint-Johns-Butchery-Lamb.jpg" alt="Free range lamb" width="400" height="300" loading="lazy">
  </div>
  <div class="product-card__body">
    <h3 class="product-card__title">Lamb</h3>
    <p class="product-card__desc">Premium free range lamb cuts, from racks to shanks.</p>
    <span class="product-card__link">View range <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg></span>
  </div>
</a>
<!-- /wp:html -->
HTML,
	] );
}
