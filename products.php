<?php
require_once __DIR__ . '/admin/includes/db.php';
include 'includes/headerScript.php';
include 'includes/header.php';

/* ==========================================================================
   FETCH ACTIVE, NON-DELETED PRODUCTS AND FEATURES FROM MYSQL
   ========================================================================== */
$productsQuery = "SELECT id, display_order, name, category, short_description, image
                  FROM products
                  WHERE status = 1 AND is_deleted = 0
                  ORDER BY display_order ASC, id ASC";
$productsResult = mysqli_query($conn, $productsQuery);

$products = [];
if ($productsResult) {
    while ($prod = mysqli_fetch_assoc($productsResult)) {
        $products[] = $prod;
    }
}

// Fetch features for active products
$featuresByProduct = [];
$prodIds = array_column($products, 'id');
if (!empty($prodIds)) {
    $idsList = implode(',', array_map('intval', $prodIds));
    $featResult = mysqli_query($conn, "SELECT product_id, feature FROM product_features WHERE product_id IN ($idsList) ORDER BY display_order ASC, id ASC");
    if ($featResult) {
        while ($f = mysqli_fetch_assoc($featResult)) {
            $featuresByProduct[$f['product_id']][] = $f['feature'];
        }
    }
}

function getProductCardIcon($name, $category = '') {
    $catLower = strtolower(trim($category));
    if ($catLower === 'door' || strpos($catLower, 'door') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="2" width="14" height="20" rx="1.5" /><circle cx="9" cy="12" r="1.5" fill="currentColor" /></svg>';
    } elseif ($catLower === 'wall' || strpos($catLower, 'wall') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="18" rx="1" /><rect x="14" y="3" width="7" height="18" rx="1" /></svg>';
    } elseif ($catLower === 'ceiling' || strpos($catLower, 'ceiling') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 2 7 12 12 22 7 12 2" /><polyline points="2 17 12 22 22 17" /><polyline points="2 12 12 17 22 12" /></svg>';
    } elseif ($catLower === 'wetunit' || strpos($catLower, 'wet') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16a1 1 0 0 1 1 1v3a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4v-3a1 1 0 0 1 1-1z" /><path d="M6 12V5a2 2 0 0 1 2-2h1" /></svg>';
    } elseif ($catLower === 'cabin' || strpos($catLower, 'cabin') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /><polyline points="3.27 6.96 12 12.01 20.73 6.96" /><line x1="12" y1="22.08" x2="12" y2="12" /></svg>';
    }

    $nameLower = strtolower($name);
    if (strpos($nameLower, 'door') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="2" width="14" height="20" rx="1.5" /><circle cx="9" cy="12" r="1.5" fill="currentColor" /></svg>';
    } elseif (strpos($nameLower, 'wall') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="18" rx="1" /><rect x="14" y="3" width="7" height="18" rx="1" /></svg>';
    } elseif (strpos($nameLower, 'ceiling') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 2 7 12 12 22 7 12 2" /><polyline points="2 17 12 22 22 17" /><polyline points="2 12 12 17 22 12" /></svg>';
    } elseif (strpos($nameLower, 'wet') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16a1 1 0 0 1 1 1v3a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4v-3a1 1 0 0 1 1-1z" /><path d="M6 12V5a2 2 0 0 1 2-2h1" /></svg>';
    } elseif (strpos($nameLower, 'cabin') !== false) {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /><polyline points="3.27 6.96 12 12.01 20.73 6.96" /><line x1="12" y1="22.08" x2="12" y2="12" /></svg>';
    } else {
        return '<svg class="card-type-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>';
    }
}

function getProduct360Category($category, $name, $id) {
    if (!empty($category)) {
        $cat = strtolower(trim($category));
        if (strpos($cat, 'door') !== false) return 'door';
        if (strpos($cat, 'wall') !== false) return 'wall';
        if (strpos($cat, 'ceiling') !== false) return 'ceiling';
        if (strpos($cat, 'wet') !== false) return 'wetunit';
        if (strpos($cat, 'cabin') !== false) return 'cabin';
        return $cat;
    }
    return getProduct360Slug($name, $id);
}

function getProduct360Slug($name, $id) {
    $nameLower = strtolower($name);
    if (strpos($nameLower, 'door') !== false) {
        return 'door';
    } elseif (strpos($nameLower, 'wall') !== false) {
        return 'wall';
    } elseif (strpos($nameLower, 'ceiling') !== false) {
        return 'ceiling';
    } elseif (strpos($nameLower, 'wet') !== false) {
        return 'wetunit';
    } elseif (strpos($nameLower, 'cabin') !== false) {
        return 'cabin';
    } else {
        return 'product-' . (int)$id;
    }
}

function getProductImageSrc($image) {
    if (empty($image)) {
        return 'assets/door.jpeg';
    }
    if (file_exists(__DIR__ . '/' . $image)) {
        return $image;
    }
    $altJpg = preg_replace('/\.jpg$/i', '.jpeg', $image);
    if (file_exists(__DIR__ . '/' . $altJpg)) {
        return $altJpg;
    }
    $altJpeg = preg_replace('/\.jpeg$/i', '.jpg', $image);
    if (file_exists(__DIR__ . '/' . $altJpeg)) {
        return $altJpeg;
    }
    return $image;
}
?>
   <!-- SECTION 03 ΓÇö OUR PRODUCTS (TECHNICAL PRODUCT SHOWCASE) -->
    <section class="products-section site-section" id="products" aria-label="Marine & Naval Accommodation Products">
      <div class="products-container">

        <!-- Products Header Area -->
        <div class="products-header-row">
          <div class="products-title-col">
            <div class="products-pretag">
              <span class="pretag-dot"></span>
              <span>PRODUCTS</span>
            </div>
            <h2 class="products-headline">OUR PRODUCTS</h2>
            <p class="products-subhead">
              Engineered and manufactured to the highest maritime standards. Built for safety. Built to perform.
            </p>
          </div>

          <!-- Top-Right Global Certifications Ribbon -->
          <div class="products-cert-ribbon" aria-label="Key Maritime Certifications">
            <div class="cert-item">
              <svg class="cert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                <path d="m9 12 2 2 4-4" />
              </svg>
              <div class="cert-text">
                <span class="cert-title">ABS</span>
                <span class="cert-sub">APPROVED</span>
              </div>
            </div>
            <div class="cert-item">
              <svg class="cert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8">
                <path d="M2 20a6 6 0 0 0 12 0 6 6 0 0 0 10 0M4 14l3-8 5 4 4-6 4 10H4z" />
              </svg>
              <div class="cert-text">
                <span class="cert-title">SOLAS / IMO</span>
                <span class="cert-sub">COMPLIANT</span>
              </div>
            </div>
            <div class="cert-item">
              <svg class="cert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8">
                <path d="M12 2v20M7 22l5-10 5 10M2 14h20M6 8h12" />
              </svg>
              <div class="cert-text">
                <span class="cert-title">OFFSHORE</span>
                <span class="cert-sub">QUALIFIED</span>
              </div>
            </div>
            <div class="cert-item">
              <svg class="cert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8">
                <path d="M12 2c-4 4-6 8-6 12a6 6 0 0 0 12 0c0-4-2-8-6-12z" />
                <path d="M12 18a2 2 0 0 0 2-2c0-1.5-1-2.5-2-4-1 1.5-2 2.5-2 4a2 2 0 0 0 2 2z" />
              </svg>
              <div class="cert-text">
                <span class="cert-title">FIRE TESTED</span>
                <span class="cert-sub">&amp; TYPE APPROVED</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product Cards Grid -->
        <div class="products-grid">
        <?php if (!empty($products)) { ?>
          <?php 
          $index = 1;
          foreach ($products as $product) {
              $cardNum = sprintf('%02d', $index);
              $category = getProduct360Category($product['category'] ?? '', $product['name'], $product['id']);
              $imgSrc = getProductImageSrc($product['image']);
              $features = $featuresByProduct[$product['id']] ?? [];
              $tag = !empty($product['short_description']) ? $product['short_description'] : 'Marine Grade';
          ?>
          <!-- Card <?php echo $cardNum; ?>: <?php echo htmlspecialchars($product['name']); ?> -->
          <div class="product-card" data-product-id="<?php echo htmlspecialchars($category); ?>" data-category="<?php echo htmlspecialchars($product['category'] ?? $category); ?>">
            <div class="card-head">
              <div class="card-head-meta">
                <span class="card-num"><?php echo $cardNum; ?></span>
                <?php echo getProductCardIcon($product['name'], $category); ?>
              </div>
              <h3 class="card-title"><?php echo htmlspecialchars(strtoupper($product['name'])); ?></h3>
              <span class="card-tag"><?php echo htmlspecialchars($tag); ?></span>
            </div>

            <div class="card-image-wrap">
              <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"
                class="product-img" loading="lazy">
            </div>

            <ul class="card-specs-list" aria-label="<?php echo htmlspecialchars($product['name']); ?> Specifications">
              <?php foreach ($features as $feature) { ?>
              <li>
                <svg class="spec-check" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="2.5">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
                <span><?php echo htmlspecialchars($feature); ?></span>
              </li>
              <?php } ?>
            </ul>

            <button class="btn-inspect-360" data-open-360="<?php echo htmlspecialchars($category); ?>"
              aria-label="Inspect <?php echo htmlspecialchars($product['name']); ?> in 360 degrees">
              <svg class="cube-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path
                  d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                <line x1="12" y1="22.08" x2="12" y2="12" />
              </svg>
              <span>INSPECT IN 360</span>
              <svg class="arrow-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
            </button>
          </div>
          <?php 
              $index++;
          } 
          ?>
        <?php } else { ?>
          <p style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 2.5rem 0;">
            No products available at this time.
          </p>
        <?php } ?>
        </div>

        <!-- Bottom Trust Strip -->
        <div class="products-trust-strip">
          <div class="trust-features">

            <div class="trust-card">
              <div class="trust-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <circle cx="12" cy="12" r="3" />
                  <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                </svg>
              </div>
              <div class="trust-content">
                <span class="trust-heading">ENGINEERED</span>
                <span class="trust-sub">For Marine &amp; Offshore</span>
              </div>
            </div>

            <div class="trust-card">
              <div class="trust-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                  <path d="m9 12 2 2 4-4" />
                </svg>
              </div>
              <div class="trust-content">
                <span class="trust-heading">CERTIFIED</span>
                <span class="trust-sub">By Global Standards</span>
              </div>
            </div>

            <div class="trust-card">
              <div class="trust-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path d="M2 20h20" />
                  <path d="M4 20V10l6 4V10l6 4V4h4v16" />
                  <circle cx="16" cy="7" r="1" />
                </svg>
              </div>
              <div class="trust-content">
                <span class="trust-heading">BUILT</span>
                <span class="trust-sub">In Goa, India</span>
              </div>
            </div>

            <div class="trust-card">
              <div class="trust-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                  <circle cx="9" cy="7" r="4" />
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                  <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
              </div>
              <div class="trust-content">
                <span class="trust-heading">TRUSTED</span>
                <span class="trust-sub">By Global Clients</span>
              </div>
            </div>

          </div>

          <!-- Trust CTA -->
          <a href="enquiry.php" class="btn-trust-enquire" id="btn-products-enquire">
            <span>ENQUIRE NOW</span>
          </a>
        </div>

      </div>
    </section>

  <!-- 3D 360 Product Inspector Modal -->
  <div id="modal-360-viewer" class="modal-360" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="modal-360-title">
    <div class="modal-360-backdrop" id="modal-360-backdrop"></div>

    <div class="modal-360-container">

      <!-- Modal Top Header -->
      <div class="modal-360-header">
        <div class="modal-title-group">
          <span class="modal-tag" id="modal-360-tag">3D TECHNICAL INSPECTOR</span>
          <h3 class="modal-title" id="modal-360-title">01 — FIRE RESISTANT DOORS</h3>
        </div>

        <div class="modal-header-actions">
          <button class="btn-modal-action" id="btn-toggle-wireframe" title="Toggle Wireframe Mode"
            aria-label="Toggle Wireframe">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="18" height="18" rx="2" />
              <line x1="3" y1="9" x2="21" y2="9" />
              <line x1="3" y1="15" x2="21" y2="15" />
              <line x1="9" y1="3" x2="9" y2="21" />
              <line x1="15" y1="3" x2="15" y2="21" />
            </svg>
            <span>WIREFRAME</span>
          </button>
          <button class="btn-modal-action" id="btn-toggle-fullscreen" title="Toggle Fullscreen" aria-label="Toggle Fullscreen">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" />
  </svg>
</button>

          <button class="btn-modal-close" id="btn-close-360" aria-label="Close 360 Viewer">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Main 3D Canvas / 360 Viewport Area -->
      <div class="modal-360-viewport" id="modal-360-viewport">
        <canvas id="canvas-360-product" aria-label="Interactive 3D Product Canvas"></canvas>

        <!-- Viewer HUD Viewfinder Corner Accents -->
        <div class="viewer-hud-corner tl"></div>
        <div class="viewer-hud-corner tr"></div>
        <div class="viewer-hud-corner bl"></div>
        <div class="viewer-hud-corner br"></div>

        <!-- 360 Rotation Prompt & Compass -->
        <div class="viewer-hint-banner">
          <div class="compass-ring">
            <div class="compass-needle" id="viewer-compass-needle"></div>
          </div>
          <span>CLICK &amp; DRAG TO ROTATE 360° | SCROLL TO ZOOM</span>
        </div>

        <!-- Side Specs Drawer in Viewer -->
        <div class="viewer-specs-drawer" id="viewer-specs-drawer">
          <h4 class="drawer-heading">TECHNICAL SPECIFICATIONS</h4>
          <div class="drawer-specs-grid" id="viewer-specs-content">
            <!-- Injected dynamically via JS based on selected product -->
          </div>
        </div>
      </div>

      <!-- Viewer Bottom Controls Bar -->
      <div class="modal-360-controls">
        <div class="controls-left">
          <button class="control-btn" id="btn-reset-view" title="Reset View Angle">
           
              <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
              <polyline points="3 3 3 8 8 8" />
            </svg>
            <span>RESET VIEW</span>
          </button>
          <button class="control-btn active" id="btn-auto-rotate" title="Toggle Auto-Rotation">
              <circle cx="12" cy="12" r="10" />
              <polygon points="10 8 16 12 10 16 10 8" />
            </svg>
            <span id="rotate-btn-text">AUTO-ROTATE: ON</span>
          </button>
        </div>

        <div class="controls-center">
          <span class="rotation-angle-hud" id="rotation-angle-hud">Y-AXIS: 0° | X-AXIS: 0°</span>
        </div>

        <div class="controls-right">
          <button class="control-btn icon-only" id="btn-zoom-out" title="Zoom Out" aria-label="Zoom Out">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
          </button>
          <span class="zoom-level-text" id="zoom-level-text">100%</span>
          <button class="control-btn icon-only" id="btn-zoom-in" title="Zoom In" aria-label="Zoom In">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="5" x2="12" y2="19" />
              <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
          </button>
        </div>
      </div>

    </div>
  </div>

<?php
include 'includes/footer.php';
?>

<script>
  
  const PRODUCTS_DATA_360 = {
  door: {
    tag: '01 — MARINE PRODUCT INSPECTION',
    title: '01 — FIRE RESISTANT DOORS',
    specs: [
      { label: 'FIRE RATING', value: 'A-0, A-60, B-15, H-120 Class' },
      { label: 'WATER / WEATHER TIGHT', value: 'A-60 Marine Grade Gasket' },
      { label: 'CORE MATERIAL', value: 'High-density Ceramic / Mineral Wool' },
      { label: 'HARDWARE', value: 'Marine Grade 316 Stainless Steel' },
      { label: 'SOUND REDUCTION', value: 'Up to 44 dB Acoustic Damping' },
      { label: 'APPROVALS', value: 'ABS, MED, SOLAS / IMO Compliant' }
    ]
  },
  wall: {
    tag: '02 — MARINE PRODUCT INSPECTION',
    title: '02 — WALL PANELS',
    specs: [
      { label: 'FIRE CLASSIFICATION', value: 'B-0 & B-15 Class' },
      { label: 'THICKNESS OPTIONS', value: '25mm & 50mm Standard' },
      { label: 'JOINT PROFILES', value: 'Spline, Insert & C-Clip Systems' },
      { label: 'CORE COMPOSITION', value: 'Acoustic Rockwool Insulation' },
      { label: 'SURFACE FINISH', value: 'PVC Laminated / Galvanized Steel' },
      { label: 'APPLICATIONS', value: 'Accommodations, Passageways, Mess' }
    ]
  },
  ceiling: {
    tag: '03 — MARINE PRODUCT INSPECTION',
    title: '03 — CEILING PANELS',
    specs: [
      { label: 'FIRE RATING', value: 'B-0 (25/40mm) & B-15 (50/75mm)' },
      { label: 'CONSTRUCTION', value: 'Lightweight Composite / Micro-perforated' },
      { label: 'SUSPENSION', value: 'Integrated T-Carrier Grid & Spring Hangers' },
      { label: 'SERVICES INTEGRATION', value: 'Lighting, HVAC Diffusers, Sprinklers' },
      { label: 'SURFACE COATING', value: 'Polyester Powder Coated Marine Alloy' },
      { label: 'CERTIFICATION', value: 'Classification Society Type Approved' }
    ]
  },
  wetunit: {
    tag: '04 — MARINE PRODUCT INSPECTION',
    title: '04 — MARINE WET UNITS',
    specs: [
      { label: 'MODULE TYPE', value: 'Fully Pre-fitted Bathroom Pod' },
      { label: 'CONFIGURATIONS', value: 'Shower + WC / WC-Only Variant' },
      { label: 'ASSEMBLY', value: 'Land-assembled Turnkey Unit' },
      { label: 'PLUMBING & FIXTURES', value: 'Corrosion-Resistant Stainless / Chrome' },
      { label: 'BASE TRAY', value: 'Integrated Waterproof Composite Tray' },
      { label: 'CUSTOMIZATION', value: 'Tailored per Shipowner Requirements' }
    ]
  },
  cabin: {
    tag: '05 — MARINE PRODUCT INSPECTION',
    title: '05 — MODULAR CABINS',
    specs: [
      { label: 'STRUCTURE', value: 'Turnkey Living Quarters Module' },
      { label: 'APPLICATIONS', value: 'Naval, Commercial & Civil Marine' },
      { label: 'FIT-OUT SCOPE', value: 'Panels, Ceiling, WC Pod, Furniture' },
      { label: 'EFFICIENCY GAIN', value: 'Reduces Shipyard Fit-out by ~40-60%' },
      { label: 'INSULATION', value: 'High Thermal & Sound Damping' },
      { label: 'VESSEL TYPES', value: 'Naval, Tankers, Rigs, Offshore Platforms' }
    ]
  }
};
</script>
<script src="js/products-360.js?v=3.0"></script>