<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
   Page content helpers
   ============================================================ */

function sjb_arrow_svg() {
	return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>';
}

function sjb_img( $filename ) {
	return SJB_IMG . $filename;
}

/* ---- HOME ---- */
function sjb_home_content() {
	$img = SJB_IMG;
	$arrow = sjb_arrow_svg();
	return <<<HTML
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

<!-- wp:html -->
<section class="info-bar">
  <div class="container">
    <div class="info-item">
      <div class="info-item__icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
      </div>
      <div class="info-item__text"><strong>100% Free Range</strong><span>Ethically sourced meats</span></div>
    </div>
    <div class="info-item">
      <div class="info-item__icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
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
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
      </div>
      <div class="info-item__text"><strong>Easy Parking</strong><span>Off-street parking available</span></div>
    </div>
  </div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="about-section section">
  <div class="container">
    <div class="about-image">
      <img src="{$img}images-Saint-Johns-Butchery-Storefront-and-Neighbours-April2018.jpg" alt="Saint Johns Butchery storefront" width="600" height="400" loading="lazy">
    </div>
    <div class="about-content">
      <h2>Your Trusted Local Butcher</h2>
      <p>Welcome to Saint Johns Butchery, where we pride ourselves on offering top quality, free range meats at competitive prices. All of our meats are free range and processed in store, so you can be sure of freshness and quality every time.</p>
      <p>We provide our customers with a range of dairy-free and gluten-free products. If you can't find what you're looking for, let us know and we'll do our best to get it for you. We also offer custom packing on request.</p>
      <p>Whether you're after the perfect Sunday roast, a weeknight stir-fry, or gourmet sausages for the BBQ, we've got you covered.</p>
      <a href="/contact/" class="btn btn--primary" style="margin-top:1.5rem;">Contact Us</a>
    </div>
  </div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="section" style="background:var(--gray-100);">
  <div class="container">
    <div class="section-header">
      <h2>Our Products</h2>
      <p>An amazing selection of free range meats, all processed in store. From sausages and steaks to ham and chicken.</p>
    </div>
    <div class="products-grid">
      <a href="/products/lamb/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Lamb.jpg" alt="Fresh lamb cuts" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Lamb</h3>
          <p class="product-card__desc">Premium free range lamb cuts, from racks to shanks.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/beef/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Beef1.jpg" alt="Quality beef" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Beef</h3>
          <p class="product-card__desc">From premium steaks to slow-cook cuts and mince.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/pork/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Pork.jpg" alt="Free range pork" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Pork</h3>
          <p class="product-card__desc">Free range pork including chops, roasts, and belly.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/chicken/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Flavoured-Chicken.jpg" alt="Flavoured chicken" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Chicken</h3>
          <p class="product-card__desc">Whole chickens, portions, and our famous flavoured chicken.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/sausages/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Hanging-Sausages.jpg" alt="Handmade sausages" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Sausages</h3>
          <p class="product-card__desc">Handmade in store with a huge range of flavours.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/specialty-meats/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Specialty-Meats-Hams.jpg" alt="Specialty meats" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Specialty Meats</h3>
          <p class="product-card__desc">Venison, rabbit, duck, and other specialty meats.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/small-goods/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Small-Goods-Hams.jpg" alt="Small goods and hams" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Small Goods</h3>
          <p class="product-card__desc">Bacon, ham, salami, and other deli favourites.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/condiments/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Four-Saucemen-Sauces-St-Johns.jpg" alt="Sauces and condiments" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Condiments</h3>
          <p class="product-card__desc">Sauces, marinades, and condiments to complement your meal.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
    </div>
  </div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="cta-banner">
  <div class="container">
    <h2>Call &amp; Collect</h2>
    <p>In a hurry? Call us with your order and we'll have it ready for quick collection. Custom meat packs available on request.</p>
    <a href="tel:095216319" class="btn btn--primary btn--lg">Call 09 521 6319</a>
  </div>
</section>
<!-- /wp:html -->
HTML;
}

/* ---- PRODUCTS (overview) ---- */
function sjb_products_content() {
	$img   = SJB_IMG;
	$arrow = sjb_arrow_svg();
	return <<<HTML
<!-- wp:html -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>/</span><span>Products</span>
    </nav>
    <h1>Our Products</h1>
    <p>Top quality, free range meats — all processed in store and cut fresh every day.</p>
  </div>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<section class="section">
  <div class="container">
    <div class="products-grid">
      <a href="/products/lamb/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Lamb.jpg" alt="Fresh lamb cuts" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Lamb</h3>
          <p class="product-card__desc">Premium free range lamb cuts, from racks to shanks. Sourced from New Zealand's finest farms.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/beef/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Beef1.jpg" alt="Quality beef" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Beef</h3>
          <p class="product-card__desc">Pasture-fed beef from premium NZ farms — steaks, roasts, mince, and slow-cook cuts.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/pork/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Pork.jpg" alt="Free range pork" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Pork</h3>
          <p class="product-card__desc">Free range pork including chops, belly, roasts, and ribs.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/chicken/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Flavoured-Chicken.jpg" alt="Flavoured chicken" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Chicken</h3>
          <p class="product-card__desc">Whole chickens, portions, and our famous flavoured and marinated chicken.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/sausages/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Hanging-Sausages.jpg" alt="Handmade sausages" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Sausages</h3>
          <p class="product-card__desc">Handmade in store daily — a huge range of flavours including gluten-free options.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/specialty-meats/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Specialty-Meats-Hams.jpg" alt="Specialty meats" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Specialty Meats</h3>
          <p class="product-card__desc">Venison, rabbit, duck, quail, and other premium specialty and game meats.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/small-goods/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Saint-Johns-Butchery-Small-Goods-Hams.jpg" alt="Small goods and hams" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Small Goods</h3>
          <p class="product-card__desc">Bacon, ham, salami, prosciutto, and other quality deli favourites.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
      <a href="/products/condiments/" class="product-card">
        <div class="product-card__image"><img src="{$img}images-Four-Saucemen-Sauces-St-Johns.jpg" alt="Sauces and condiments" width="400" height="300" loading="lazy"></div>
        <div class="product-card__body">
          <h3 class="product-card__title">Condiments</h3>
          <p class="product-card__desc">Sauces, marinades, herb rubs, and condiments to complement your meat.</p>
          <span class="product-card__link">View range {$arrow}</span>
        </div>
      </a>
    </div>
  </div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="cta-banner">
  <div class="container">
    <h2>Can't Find What You Need?</h2>
    <p>We can source and custom cut almost anything. Get in touch and we'll sort it out for you.</p>
    <a href="tel:095216319" class="btn btn--primary btn--lg">Call 09 521 6319</a>
  </div>
</section>
<!-- /wp:html -->
HTML;
}

/* ---- PRODUCT DETAIL (generic builder) ---- */
function sjb_product_detail_content( array $data ) {
	$img       = SJB_IMG;
	$title     = esc_html( $data['title'] );
	$image     = $data['image'];
	$alt       = esc_attr( $data['alt'] );
	$desc      = $data['description'];
	$parent    = $data['parent_label'] ?? 'Products';
	$parent_url = $data['parent_url']  ?? '/products/';

	$cuts_html = '';
	foreach ( $data['cuts'] as $cut ) {
		$cuts_html .= '<li>' . esc_html( $cut ) . '</li>';
	}

	return <<<HTML
<!-- wp:html -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>/</span>
      <a href="{$parent_url}">{$parent}</a><span>/</span>
      <span>{$title}</span>
    </nav>
    <h1>{$title}</h1>
  </div>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<section class="section">
  <div class="container">
    <div class="product-detail">
      <div class="product-detail__image">
        <img src="{$img}{$image}" alt="{$alt}" width="600" height="450" loading="lazy">
      </div>
      <div class="product-detail__content">
        <h2>About Our {$title}</h2>
        <p>{$desc}</p>
        <p>All cuts are available from our store at the corner of Felton Mathew Ave and Merton Rd, St Johns. Call ahead and we'll have your order ready for quick collection.</p>
        <ul class="product-list">
          {$cuts_html}
        </ul>
        <div style="margin-top:2rem;display:flex;gap:1rem;flex-wrap:wrap;">
          <a href="tel:095216319" class="btn btn--primary">Call to Order</a>
          <a href="/contact/" class="btn btn--secondary">Contact Us</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="cta-banner">
  <div class="container">
    <h2>Fresh Cut Every Day</h2>
    <p>All our meats are processed in store daily. Call ahead for custom cuts or large orders.</p>
    <a href="tel:095216319" class="btn btn--primary btn--lg">Call 09 521 6319</a>
  </div>
</section>
<!-- /wp:html -->
HTML;
}

/* ---- RECIPES ---- */
function sjb_recipes_content() {
	$img = SJB_IMG;
	return <<<HTML
<!-- wp:html -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Recipes</span></nav>
    <h1>Recipes</h1>
    <p>Make the most of your free range meats with these simple, delicious recipes from our butchers.</p>
  </div>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<section class="section">
  <div class="container">

    <!-- Recipe 1 -->
    <article class="recipe-card">
      <div class="recipe-card__image">
        <img src="{$img}images-bbq-sausages-and-onions.jpg" alt="BBQ sausages and caramelised onions" loading="lazy">
      </div>
      <div class="recipe-card__body">
        <h2 class="recipe-card__title">Classic NZ BBQ Sausages with Caramelised Onions</h2>
        <div class="recipe-card__meta">
          <span>Prep: 10 min</span><span>Cook: 20 min</span><span>Serves: 4</span>
        </div>
        <p class="recipe-card__desc">The quintessential Kiwi BBQ — our handmade pork &amp; fennel sausages paired with sweet caramelised onions.</p>
        <details class="recipe-accordion">
          <summary>Ingredients</summary>
          <ul class="recipe-ingredients">
            <li>8 Saint Johns Butchery pork &amp; fennel sausages</li>
            <li>2 large onions, thinly sliced</li>
            <li>2 tbsp butter</li>
            <li>1 tbsp brown sugar</li>
            <li>1 tbsp balsamic vinegar</li>
            <li>Salt and pepper to taste</li>
            <li>Burger buns and condiments to serve (optional)</li>
          </ul>
        </details>
        <details class="recipe-accordion">
          <summary>Method</summary>
          <ol class="recipe-method">
            <li>Preheat BBQ or grill to medium heat. Brush grates lightly with oil.</li>
            <li>Melt butter in a frying pan over medium-low heat. Add onions and a pinch of salt. Cook slowly, stirring occasionally, for 15 minutes until soft and golden.</li>
            <li>Add brown sugar and balsamic vinegar to onions. Stir and cook a further 5 minutes until caramelised. Keep warm.</li>
            <li>Cook sausages on the BBQ, turning regularly, for 12–15 minutes until cooked through with no pink centre.</li>
            <li>Serve sausages topped with caramelised onions.</li>
          </ol>
        </details>
      </div>
    </article>

    <!-- Recipe 2 -->
    <article class="recipe-card">
      <div class="recipe-card__image">
        <img src="{$img}images-Saint-Johns-Butchery-Lamb.jpg" alt="Slow-braised lamb shanks" loading="lazy">
      </div>
      <div class="recipe-card__body">
        <h2 class="recipe-card__title">Slow-Braised Lamb Shanks with Red Wine &amp; Rosemary</h2>
        <div class="recipe-card__meta">
          <span>Prep: 20 min</span><span>Cook: 2.5 hrs</span><span>Serves: 4</span>
        </div>
        <p class="recipe-card__desc">A classic winter warmer. Free range lamb shanks braised low and slow in red wine until the meat falls off the bone.</p>
        <details class="recipe-accordion">
          <summary>Ingredients</summary>
          <ul class="recipe-ingredients">
            <li>4 free range lamb shanks</li>
            <li>2 tbsp olive oil</li>
            <li>2 onions, diced</li>
            <li>3 carrots, roughly chopped</li>
            <li>4 garlic cloves, crushed</li>
            <li>1 cup red wine</li>
            <li>2 x 400g tins crushed tomatoes</li>
            <li>1 cup beef stock</li>
            <li>2 sprigs fresh rosemary</li>
            <li>3 sprigs fresh thyme</li>
            <li>Salt and freshly ground black pepper</li>
          </ul>
        </details>
        <details class="recipe-accordion">
          <summary>Method</summary>
          <ol class="recipe-method">
            <li>Preheat oven to 160°C (320°F). Season lamb shanks generously with salt and pepper.</li>
            <li>Heat oil in a large oven-proof casserole dish over high heat. Brown shanks on all sides (about 8 minutes). Remove and set aside.</li>
            <li>Reduce heat to medium. Add onions, carrots, and garlic. Cook for 5 minutes until softened.</li>
            <li>Pour in red wine and let it bubble for 2 minutes, scraping up any bits from the bottom.</li>
            <li>Add crushed tomatoes, stock, rosemary, and thyme. Return shanks to the pot — they should be mostly submerged.</li>
            <li>Cover and braise in the oven for 2–2.5 hours until the meat is falling off the bone.</li>
            <li>Serve over creamy mashed potato or polenta.</li>
          </ol>
        </details>
      </div>
    </article>

    <!-- Recipe 3 -->
    <article class="recipe-card">
      <div class="recipe-card__image">
        <img src="{$img}images-Saint-Johns-Butchery-Pork.jpg" alt="Crispy pork belly" loading="lazy">
      </div>
      <div class="recipe-card__body">
        <h2 class="recipe-card__title">Crispy Pork Belly with Apple Sauce</h2>
        <div class="recipe-card__meta">
          <span>Prep: 15 min (+ overnight)</span><span>Cook: 2 hrs</span><span>Serves: 6</span>
        </div>
        <p class="recipe-card__desc">Perfectly crispy crackling every time. Ask our butchers to score the skin for you — we're happy to help.</p>
        <details class="recipe-accordion">
          <summary>Ingredients</summary>
          <ul class="recipe-ingredients">
            <li>1.5 kg free range pork belly, skin scored</li>
            <li>2 tsp flaky sea salt</li>
            <li>1 tsp fennel seeds, crushed</li>
            <li>1 tsp black pepper</li>
            <li>Olive oil</li>
            <li><strong>Apple Sauce:</strong> 4 Granny Smith apples (peeled, cored, chopped), 2 tbsp water, 1 tbsp sugar, squeeze of lemon</li>
          </ul>
        </details>
        <details class="recipe-accordion">
          <summary>Method</summary>
          <ol class="recipe-method">
            <li>The night before: pat skin completely dry with paper towels. Rub salt, fennel, and pepper generously into the skin. Leave uncovered in the fridge overnight.</li>
            <li>Remove from fridge 30 minutes before cooking. Preheat oven to 220°C (430°F).</li>
            <li>Place pork skin-side up on a rack in a roasting tray. Rub skin with a little olive oil.</li>
            <li>Roast at 220°C for 30 minutes until skin begins to crackle and blister.</li>
            <li>Reduce oven to 170°C (340°F) and roast for a further 1.5 hours until the meat is tender.</li>
            <li>Meanwhile, simmer apple sauce ingredients in a small saucepan for 15 minutes, then mash or blend to desired texture.</li>
            <li>Rest pork for 10 minutes before slicing. Serve with apple sauce and roasted vegetables.</li>
          </ol>
        </details>
      </div>
    </article>

    <!-- Recipe 4 -->
    <article class="recipe-card">
      <div class="recipe-card__image">
        <img src="{$img}images-Saint-Johns-Butchery-Beef1.jpg" alt="Pan-seared eye fillet steak" loading="lazy">
      </div>
      <div class="recipe-card__body">
        <h2 class="recipe-card__title">Pan-Seared Eye Fillet with Garlic Herb Butter</h2>
        <div class="recipe-card__meta">
          <span>Prep: 10 min</span><span>Cook: 10 min</span><span>Serves: 2</span>
        </div>
        <p class="recipe-card__desc">The king of steaks, simply cooked. Let the quality of the meat do the talking — ask us to cut your fillet to the right thickness.</p>
        <details class="recipe-accordion">
          <summary>Ingredients</summary>
          <ul class="recipe-ingredients">
            <li>2 eye fillet steaks (200–220g each, about 4cm thick)</li>
            <li>1 tbsp neutral oil (e.g. rice bran)</li>
            <li>50g butter</li>
            <li>3 garlic cloves, crushed</li>
            <li>3 sprigs fresh thyme</li>
            <li>1 sprig fresh rosemary</li>
            <li>Flaky sea salt and freshly cracked black pepper</li>
          </ul>
        </details>
        <details class="recipe-accordion">
          <summary>Method</summary>
          <ol class="recipe-method">
            <li>Remove steaks from fridge 30 minutes before cooking. Pat dry and season generously with salt and pepper on all sides.</li>
            <li>Heat a heavy-based pan (cast iron is ideal) over very high heat until smoking hot. Add oil.</li>
            <li>Add steaks and sear for 2.5 minutes per side (for medium-rare) without moving them. Sear the edges briefly using tongs.</li>
            <li>Reduce heat to medium. Add butter, garlic, thyme, and rosemary. Once butter is foaming, tilt the pan and baste the steaks continuously for 1–2 minutes.</li>
            <li>Remove steaks to a warm plate. Rest for 5 minutes before serving — this is crucial for juicy results.</li>
            <li>Serve with the pan butter drizzled over and your choice of sides.</li>
          </ol>
        </details>
      </div>
    </article>

  </div>
</section>
<!-- /wp:html -->
HTML;
}

/* ---- LOCATION ---- */
function sjb_location_content() {
	return <<<HTML
<!-- wp:html -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Location</span></nav>
    <h1>Find Us</h1>
    <p>We're in St Johns, East Auckland — easy to find with plenty of off-street parking.</p>
  </div>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<section class="section">
  <div class="container">
    <div class="contact-grid">

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

      <div class="card">
        <h3>Contact &amp; Address</h3>

        <div class="contact-item">
          <div class="contact-item__icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
          </div>
          <div class="contact-item__text">
            <strong>Address</strong>
            <span>Corner of Felton Mathew Ave &amp; Merton Rd<br>St Johns, Auckland, New Zealand</span>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-item__icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
          </div>
          <div class="contact-item__text">
            <strong>Phone</strong>
            <a href="tel:095216319">09 521 6319</a>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-item__icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
          </div>
          <div class="contact-item__text">
            <strong>Email</strong>
            <a href="mailto:dave@saintjohnsbutchery.co.nz">dave@saintjohnsbutchery.co.nz</a>
          </div>
        </div>

        <div class="contact-item">
          <div class="contact-item__icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
          </div>
          <div class="contact-item__text">
            <strong>Parking</strong>
            <span>Free off-street parking available on site</span>
          </div>
        </div>
      </div>
    </div>

    <div class="map-container" style="margin-top:3rem;">
      <iframe
        title="Saint Johns Butchery on Google Maps"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3190.174804878299!2d174.8484323!3d-36.879947!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d0d4b1b3b3b3b3b%3A0x0!2sSaint+Johns+Butchery!5e0!3m2!1sen!2snz!4v1234567890"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>
<!-- /wp:html -->
HTML;
}

/* ---- CONTACT ---- */
function sjb_contact_content() {
	return <<<HTML
<!-- wp:html -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Contact</span></nav>
    <h1>Get in Touch</h1>
    <p>Have a question or want to place a custom order? We'd love to hear from you.</p>
  </div>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<section class="section">
  <div class="container">
    <div class="contact-grid">

      <div class="card">
        <h3>Send Us a Message</h3>
        <p style="color:var(--gray-500);margin-bottom:1.5rem;font-size:0.9rem;">For orders and enquiries, fill out the form below or give us a call during business hours.</p>

        <form action="" method="post" style="display:flex;flex-direction:column;gap:1rem;">
          <div>
            <label for="contact-name" style="display:block;font-size:0.85rem;font-weight:600;color:var(--gray-900);margin-bottom:0.4rem;">Name *</label>
            <input type="text" id="contact-name" name="name" required
              style="width:100%;padding:0.75rem 1rem;border:1px solid var(--gray-300);border-radius:var(--radius-sm);font-family:var(--font-body);font-size:0.9rem;">
          </div>
          <div>
            <label for="contact-email" style="display:block;font-size:0.85rem;font-weight:600;color:var(--gray-900);margin-bottom:0.4rem;">Email *</label>
            <input type="email" id="contact-email" name="email" required
              style="width:100%;padding:0.75rem 1rem;border:1px solid var(--gray-300);border-radius:var(--radius-sm);font-family:var(--font-body);font-size:0.9rem;">
          </div>
          <div>
            <label for="contact-phone" style="display:block;font-size:0.85rem;font-weight:600;color:var(--gray-900);margin-bottom:0.4rem;">Phone</label>
            <input type="tel" id="contact-phone" name="phone"
              style="width:100%;padding:0.75rem 1rem;border:1px solid var(--gray-300);border-radius:var(--radius-sm);font-family:var(--font-body);font-size:0.9rem;">
          </div>
          <div>
            <label for="contact-message" style="display:block;font-size:0.85rem;font-weight:600;color:var(--gray-900);margin-bottom:0.4rem;">Message *</label>
            <textarea id="contact-message" name="message" rows="5" required
              style="width:100%;padding:0.75rem 1rem;border:1px solid var(--gray-300);border-radius:var(--radius-sm);font-family:var(--font-body);font-size:0.9rem;resize:vertical;"></textarea>
          </div>
          <button type="submit" class="btn btn--primary">Send Message</button>
        </form>
      </div>

      <div>
        <div class="card" style="margin-bottom:1.5rem;">
          <h3>Contact Info</h3>
          <div class="contact-item">
            <div class="contact-item__icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
            </div>
            <div class="contact-item__text">
              <strong>Phone</strong>
              <a href="tel:095216319">09 521 6319</a>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-item__icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
            </div>
            <div class="contact-item__text">
              <strong>Email</strong>
              <a href="mailto:dave@saintjohnsbutchery.co.nz">dave@saintjohnsbutchery.co.nz</a>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-item__icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            </div>
            <div class="contact-item__text">
              <strong>Address</strong>
              <span>Corner of Felton Mathew Ave &amp; Merton Rd, St Johns, Auckland</span>
            </div>
          </div>
        </div>

        <div class="card">
          <h3>Opening Hours</h3>
          <table class="hours-table">
            <tbody>
              <tr class="closed"><td>Monday</td><td>Closed</td></tr>
              <tr><td>Tue – Fri</td><td>7:30am – 6:00pm</td></tr>
              <tr><td>Saturday</td><td>8:00am – 6:00pm</td></tr>
              <tr><td>Sunday</td><td>8:30am – 5:00pm</td></tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- /wp:html -->
HTML;
}

/* ============================================================
   Page data definitions
   ============================================================ */

function sjb_get_product_pages() {
	return [
		'lamb' => [
			'title'       => 'Lamb',
			'image'       => 'images-Saint-Johns-Butchery-Lamb.jpg',
			'alt'         => 'Fresh free range lamb cuts at Saint Johns Butchery',
			'description' => 'Our lamb is sourced from New Zealand\'s finest free range farms — animals that graze on lush green pasture. Every cut is prepared fresh in store by our experienced butchers, ensuring outstanding quality and flavour. Whether you\'re after a show-stopping rack for a dinner party or everyday mince for a family meal, we have you covered.',
			'cuts'        => [
				'Lamb Rack', 'Lamb Cutlets', 'Lamb Chops', 'Lamb Loin Chops',
				'Lamb Shoulder (bone-in)', 'Lamb Shoulder (boneless)', 'Lamb Leg (bone-in)',
				'Lamb Leg (boneless)', 'Lamb Shanks', 'Lamb Mince', 'Lamb Stir Fry',
				'Lamb Sausages', 'Lamb Ribs', 'Lamb Kidney', 'Lamb Liver',
			],
		],
		'beef' => [
			'title'       => 'Beef',
			'image'       => 'images-Saint-Johns-Butchery-Beef1.jpg',
			'alt'         => 'Quality pasture-fed beef at Saint Johns Butchery',
			'description' => 'All our beef is sourced from grass-fed, pasture-raised New Zealand cattle. Pasture-fed beef is naturally richer in flavour and higher in beneficial omega-3 fatty acids. Our butchers hand-select each animal and prepare every cut fresh in store — from tender eye fillet to flavoursome slow-cook cuts.',
			'cuts'        => [
				'Eye Fillet (Tenderloin)', 'Scotch Fillet / Ribeye', 'Sirloin Steak',
				'Rump Steak', 'T-Bone Steak', 'Flat Iron Steak', 'Flank Steak',
				'Beef Mince', 'Beef Stir Fry', 'Chuck Steak', 'Blade Steak',
				'Oxtail', 'Short Ribs', 'Brisket', 'Topside Roast',
				'Silverside', 'Osso Bucco', 'Corned Beef',
			],
		],
		'pork' => [
			'title'       => 'Pork',
			'image'       => 'images-Saint-Johns-Butchery-Pork.jpg',
			'alt'         => 'Free range pork at Saint Johns Butchery',
			'description' => 'Our pork comes from free range farms where pigs are raised outdoors on a natural diet, giving the meat exceptional flavour and texture. Ask our butchers about seasonal specials including whole roasting pigs for events, and we can also score pork skin to guarantee perfect crackling every time.',
			'cuts'        => [
				'Pork Loin Chops', 'Pork Shoulder Chops', 'Pork Belly (whole & sliced)',
				'Pork Shoulder Roast', 'Pork Leg Roast', 'Pork Scotch Fillet',
				'Pork Mince', 'Pork Stir Fry', 'Pork Ribs', 'Pork Spare Ribs',
				'Pork Knuckle', 'Pork Neck Steaks',
			],
		],
		'chicken' => [
			'title'       => 'Chicken',
			'image'       => 'images-Saint-Johns-Butchery-Flavoured-Chicken.jpg',
			'alt'         => 'Free range chicken at Saint Johns Butchery',
			'description' => 'Our chicken is sourced from free range farms where birds have access to outdoor areas and are raised without unnecessary antibiotics. We stock a full range from whole birds to individual portions, plus our popular range of marinated and flavoured chicken — perfect for a quick midweek dinner.',
			'cuts'        => [
				'Whole Chicken', 'Chicken Breasts (single & double)', 'Chicken Thighs (bone-in)',
				'Chicken Thighs (boneless)', 'Chicken Drumsticks', 'Chicken Wings',
				'Chicken Nibbles', 'Chicken Mince', 'Chicken Stir Fry',
				'Marinated Lemon & Herb Thighs', 'Marinated Satay Thighs',
				'Marinated BBQ Thighs', 'Spatchcock Chicken',
			],
		],
		'sausages' => [
			'title'       => 'Sausages',
			'image'       => 'images-Hanging-Sausages.jpg',
			'alt'         => 'Handmade sausages at Saint Johns Butchery',
			'description' => 'Our sausages are made fresh in store every day using our own recipes and quality free range meats. We use natural casings and real ingredients — no fillers or artificial preservatives. With a huge range of flavours, there\'s something for every taste. Gluten-free options are also available; just ask.',
			'cuts'        => [
				'Pork & Fennel', 'Pork & Leek', 'Traditional Pork',
				'Beef & Caramelised Onion', 'Beef & Pepper',
				'Lamb & Rosemary', 'Lamb & Mint',
				'Chicken & Herb', 'Chicken & Sundried Tomato',
				'Chorizo-style', 'Italian-style', 'Venison',
				'Gluten-Free options (ask in store)',
			],
		],
		'specialty-meats' => [
			'title'       => 'Specialty Meats',
			'image'       => 'images-Saint-Johns-Butchery-Specialty-Meats-Hams.jpg',
			'alt'         => 'Specialty and game meats at Saint Johns Butchery',
			'description' => 'Explore our range of specialty and game meats sourced from quality New Zealand producers. From delicate venison to rich duck, these meats offer a unique flavour experience beyond everyday cuts. We can also source less common meats on request — just give us a call.',
			'cuts'        => [
				'Venison (farmed & wild)', 'Rabbit', 'Duck (whole & portions)',
				'Quail', 'Hare', 'Turkey (seasonal)',
				'Ox Tongue', 'Lamb Kidney', 'Beef Kidney',
				'Chicken Liver', 'Lamb Liver', 'Beef Liver',
				'Beef Heart', 'Tripe',
			],
		],
		'small-goods' => [
			'title'       => 'Small Goods',
			'image'       => 'images-Saint-Johns-Butchery-Small-Goods-Hams.jpg',
			'alt'         => 'Small goods, bacon and ham at Saint Johns Butchery',
			'description' => 'Our small goods are sourced from quality New Zealand producers who share our values around animal welfare and food quality. From thick-cut bacon to premium whole leg hams, our deli range is ideal for breakfast, entertaining, and everything in between.',
			'cuts'        => [
				'Streaky Bacon', 'Middle Bacon', 'Back Bacon', 'Thick-Cut Bacon',
				'Whole Leg Ham', 'Half Leg Ham', 'Boneless Leg Ham',
				'Salami', 'Prosciutto', 'Chorizo (cured)',
				'Kabana', 'Smoked Chicken', 'Pastrami',
				'Cooked Corned Beef',
			],
		],
		'condiments' => [
			'title'       => 'Condiments',
			'image'       => 'images-Four-Saucemen-Sauces-St-Johns.jpg',
			'alt'         => 'Sauces and condiments at Saint Johns Butchery',
			'description' => 'Complement your meat with our curated range of sauces, marinades, and condiments. We stock the popular Four Saucemen range made right here in New Zealand, along with a selection of mustards, relishes, and rubs that pair perfectly with everything from a Sunday roast to a weeknight BBQ.',
			'cuts'        => [
				'Four Saucemen BBQ Sauce', 'Four Saucemen Hot Sauce', 'Four Saucemen Chipotle',
				'Dijon Mustard', 'Wholegrain Mustard', 'Honey Mustard',
				'Apple & Mint Jelly', 'Redcurrant Jelly',
				'Herb & Garlic Rub', 'Smoky BBQ Rub', 'Cajun Spice Mix',
				'Teriyaki Marinade', 'Lemon & Herb Marinade', 'Garlic & Herb Marinade',
			],
		],
	];
}

/* ============================================================
   Main page creator — runs on plugin activation
   ============================================================ */

function sjb_create_pages() {

	/* 1. Home */
	$home_id = sjb_upsert_page( [
		'post_title'   => 'Home',
		'post_name'    => 'home',
		'post_content' => sjb_home_content(),
		'post_parent'  => 0,
	] );
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	/* 2. Products overview */
	$products_id = sjb_upsert_page( [
		'post_title'   => 'Products',
		'post_name'    => 'products',
		'post_content' => sjb_products_content(),
		'post_parent'  => 0,
	] );

	/* 3. Individual product pages */
	foreach ( sjb_get_product_pages() as $slug => $data ) {
		$data['parent_label'] = 'Products';
		$data['parent_url']   = '/products/';
		sjb_upsert_page( [
			'post_title'   => $data['title'],
			'post_name'    => $slug,
			'post_content' => sjb_product_detail_content( $data ),
			'post_parent'  => $products_id ?: 0,
		] );
	}

	/* 4. Recipes */
	sjb_upsert_page( [
		'post_title'   => 'Recipes',
		'post_name'    => 'recipes',
		'post_content' => sjb_recipes_content(),
		'post_parent'  => 0,
	] );

	/* 5. Location */
	sjb_upsert_page( [
		'post_title'   => 'Location',
		'post_name'    => 'location',
		'post_content' => sjb_location_content(),
		'post_parent'  => 0,
	] );

	/* 6. Contact */
	sjb_upsert_page( [
		'post_title'   => 'Contact',
		'post_name'    => 'contact',
		'post_content' => sjb_contact_content(),
		'post_parent'  => 0,
	] );
}

/**
 * Insert a page if it doesn't already exist (matched by slug + parent).
 * Returns the page ID.
 */
function sjb_upsert_page( array $args ) {
	$existing = get_page_by_path( $args['post_name'] );
	if ( $existing ) {
		return (int) $existing->ID;
	}

	return wp_insert_post( [
		'post_title'   => $args['post_title'],
		'post_name'    => $args['post_name'],
		'post_content' => $args['post_content'],
		'post_parent'  => $args['post_parent'] ?? 0,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	] );
}
