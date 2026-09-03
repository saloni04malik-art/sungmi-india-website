<?php
include 'includes/headerScript.php';
?>

  <!-- Minimal Site Navigation -->
  <?php include 'includes/header.php' ?>

  <!-- Main Hero Section -->
  <main id="main-content">
    <section class="hero-section site-section active-page" id="hero" aria-label="Marine & Naval Accommodation Hero">

      <!-- Hero Background Video -->
      <video class="hero-video-bg" id="hero-bg-video" autoplay muted loop playsinline preload="auto">
        <source src="assets/landingpage2.mp4" type="video/mp4">
      </video>

      <!-- Atmospheric Gradient Overlay -->
      <div class="hero-gradient-overlay" aria-hidden="true"></div>

      <!-- Hero Content -->
      <div class="hero-content-wrapper">
        <div class="hero-interactive-zone">

          <!-- Main Headline -->
          <h1 class="hero-headline">
            <span class="headline-line">ENGINEERED</span>
            <span class="headline-line">FOR THE</span>
            <span class="headline-line">DEMANDS</span>
            <span class="headline-line">OF THE SEA</span>
          </h1>

          <!-- Supporting Text -->
          <p class="hero-supporting-text">
            Sungmi India is an India–Korea joint venture providing accommodation systems for ships, oil & gas, rigs,
            platforms, wind motors and offshore HVAC sub-stations.
          </p>

          <!-- Action Buttons -->
          <div class="hero-cta-group">
            <a href="products.php" class="btn-hero-action" id="cta-explore-products">
              <span>EXPLORE PRODUCTS</span>
            </a>
            <a href="enquiry.php" class="btn-hero-action" id="cta-start-project">
              <span>START A PROJECT</span>
            </a>
          </div>

        </div>
      </div>

    </section>

    <!-- SECTION 02 — WHERE WE ENGINEER (APPLICATIONS SHOWCASE) -->
    <section class="solutions-showcase-section site-section" id="solutions"
      aria-label="Where We Engineer - Marine & Offshore Accommodation Applications">
      <div class="showcase-container">

        <!-- Section Header -->
        <div class="showcase-header">
          <div class="showcase-pretag">
            <span class="pretag-dot"></span>
            <span>WHERE WE ENGINEER</span>
          </div>
          <h2 class="showcase-headline">Accommodation systems for environments where performance matters.</h2>
        </div>

        <!-- 60/40 Showcase Layout Grid -->
        <div class="showcase-layout">

          <!-- 60% Left: Cinematic Visual Frame -->
          <div class="showcase-visual-frame" id="showcase-visual-frame">

            <!-- Layered Cinematic Environment Images -->
            <div class="visual-layers">
              <!-- 01 Marine & Naval (Default Active) -->
              <div class="visual-layer active" data-app-id="01"
                style="background-image: url('assets/app_naval_vessel_1787755569474.jpg');" role="img"
                aria-label="Marine and Naval vessel environment"></div>

              <!-- 02 Commercial Vessels -->
              <div class="visual-layer" data-app-id="02"
                style="background-image: url('assets/app_commercial_ship_1787755606765.jpg');" role="img"
                aria-label="Commercial ship environment"></div>

              <!-- 03 Passenger Vessels -->
              <div class="visual-layer" data-app-id="03"
                style="background-image: url('assets/app_passenger_vessel_1787755668674.jpg');" role="img"
                aria-label="Passenger vessel environment"></div>

              <!-- 04 Tankers -->
              <div class="visual-layer" data-app-id="04"
                style="background-image: url('assets/app_tanker_vessel_1787755715026.jpg');" role="img"
                aria-label="Tanker vessel environment"></div>

              <!-- 05 Offshore -->
              <div class="visual-layer" data-app-id="05"
                style="background-image: url('assets/app_offshore_platform_1787755777035.jpg');" role="img"
                aria-label="Offshore platform environment"></div>

              <!-- 06 Oil & Gas -->
              <div class="visual-layer" data-app-id="06"
                style="background-image: url('assets/app_oil_gas_rig_1787755846799.jpg');" role="img"
                aria-label="Oil and gas rig environment"></div>
            </div>

            <!-- Cinematic Film Vignette & Subtle Technical Grid Overlay -->
            <div class="visual-overlay-film" aria-hidden="true"></div>
            <div class="visual-engineering-grid" aria-hidden="true"></div>

            <!-- Viewfinder Architectural Framing Accents -->
            <div class="visual-corner top-left" aria-hidden="true"></div>
            <div class="visual-corner top-right" aria-hidden="true"></div>
            <div class="visual-corner bottom-left" aria-hidden="true"></div>
            <div class="visual-corner bottom-right" aria-hidden="true"></div>

            <!-- Subtle Engineering Technical Label (HUD) -->
            <div class="visual-technical-label">
              <div class="tech-tag" id="visual-tech-tag">APPLICATION / 01</div>
              <div class="tech-title" id="visual-tech-title">MARINE & NAVAL</div>
              <div class="tech-sub" id="visual-tech-sub">MARINE ACCOMMODATION SYSTEM</div>
            </div>

            <!-- Telemetry Spec Badge -->
            <div class="visual-telemetry">
              <span class="telemetry-item" id="visual-telemetry-spec">SPEC: DEFENSE & NAVAL CLASS</span>
              <span class="telemetry-divider">/</span>
              <span class="telemetry-item">HIGH INTEGRITY</span>
            </div>

          </div>

          <!-- 40% Right: Vertical Interactive Application Selector -->
          <div class="showcase-selector-col">

            <div class="app-selector-list" role="tablist" aria-label="Application Environments">

              <!-- 01 Marine & Naval (Active Default) -->
              <button class="app-selector-item active" data-app-id="01" role="tab" aria-selected="true">
                <div class="item-head">
                  <span class="item-num">01</span>
                  <span class="item-name">MARINE & NAVAL</span>
                </div>
                <div class="item-desc-wrap">
                  <p class="item-desc">Marine accommodation systems for naval applications.</p>
                </div>
              </button>

              <!-- 02 Commercial Vessels -->
              <button class="app-selector-item" data-app-id="02" role="tab" aria-selected="false">
                <div class="item-head">
                  <span class="item-num">02</span>
                  <span class="item-name">COMMERCIAL VESSELS</span>
                </div>
                <div class="item-desc-wrap">
                  <p class="item-desc">Engineered accommodation systems for commercial ships.</p>
                </div>
              </button>

              <!-- 03 Passenger Vessels -->
              <button class="app-selector-item" data-app-id="03" role="tab" aria-selected="false">
                <div class="item-head">
                  <span class="item-num">03</span>
                  <span class="item-name">PASSENGER VESSELS</span>
                </div>
                <div class="item-desc-wrap">
                  <p class="item-desc">Accommodation solutions for passenger vessels.</p>
                </div>
              </button>

              <!-- 04 Tankers -->
              <button class="app-selector-item" data-app-id="04" role="tab" aria-selected="false">
                <div class="item-head">
                  <span class="item-num">04</span>
                  <span class="item-name">TANKERS</span>
                </div>
                <div class="item-desc-wrap">
                  <p class="item-desc">Specialized accommodation applications for tanker environments.</p>
                </div>
              </button>

              <!-- 05 Offshore -->
              <button class="app-selector-item" data-app-id="05" role="tab" aria-selected="false">
                <div class="item-head">
                  <span class="item-num">05</span>
                  <span class="item-name">OFFSHORE</span>
                </div>
                <div class="item-desc-wrap">
                  <p class="item-desc">Accommodation systems for offshore platforms and structures.</p>
                </div>
              </button>

              <!-- 06 Oil & Gas -->
              <button class="app-selector-item" data-app-id="06" role="tab" aria-selected="false">
                <div class="item-head">
                  <span class="item-num">06</span>
                  <span class="item-name">OIL & GAS</span>
                </div>
                <div class="item-desc-wrap">
                  <p class="item-desc">Solutions for demanding oil & gas and rig environments.</p>
                </div>
              </button>

            </div>

            <!-- Footer Action Callout -->
            <div class="showcase-cta-wrap">
              <div class="cta-eyebrow">FROM VESSEL TO ACCOMMODATION</div>
              <a href="products.php" class="btn-explore-solutions" id="btn-showcase-explore">
                <span>EXPLORE PRODUCTS</span>
              </a>
            </div>

          </div>

        </div>

      </div>
    </section>

    <!-- SECTION 02.5 — VESSEL ACCOMMODATION CUTAWAY EXPLORER -->
    <section class="cutaway-explorer-section site-section" id="accommodation-explorer"
      aria-label="Vessel Accommodation Superstructure Blueprint">
      <div class="cutaway-container">

        <!-- Section Header -->
        <div class="cutaway-header">
          <div class="cutaway-pretag">
            <span class="pretag-dot"></span>
            <span>INTEGRATED SUPERSTRUCTURE</span>
          </div>
          <h2 class="cutaway-headline">TURNKEY VESSEL ACCOMMODATION SYSTEMS</h2>
          <p class="cutaway-subhead">
            Explore where each Sungmi marine-grade accommodation component integrates inside the vessel superstructure.
          </p>
        </div>

        <!-- Cutaway Interactive Showcase Layout -->
        <div class="cutaway-showcase-box">

          <!-- Left Column: 5 Interactive Product Components (Ordered to match Products section) -->
          <div class="cutaway-list-col" role="tablist" aria-label="Marine Accommodation Components">

            <!-- 01 Fire Resistant Doors -->
            <div class="cutaway-item active" data-cutaway-id="01" data-product-target="door" role="tab"
              aria-selected="true" tabindex="0">
              <div class="cutaway-item-indicator"></div>
              <div class="cutaway-item-content">
                <div class="cutaway-item-head">
                  <span class="cutaway-num-badge">01</span>
                  <h3 class="cutaway-item-title">A-60 / B-15 FIRE RESISTANT DOORS</h3>
                </div>
                <p class="cutaway-item-desc">
                  Single and double-leaf fire hinged/sliding doors constructed with galvanized steel cores and
                  heavy-duty marine hardware.
                </p>
                <a href="products.php" class="cutaway-spec-link" data-scroll-target="door">
                  <span>VIEW TECHNICAL SPECS</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- 02 Wall Panels -->
            <div class="cutaway-item" data-cutaway-id="02" data-product-target="wall" role="tab" aria-selected="false"
              tabindex="0">
              <div class="cutaway-item-indicator"></div>
              <div class="cutaway-item-content">
                <div class="cutaway-item-head">
                  <span class="cutaway-num-badge">02</span>
                  <h3 class="cutaway-item-title">B-15 / B-0 CLASS WALL PANELS</h3>
                </div>
                <p class="cutaway-item-desc">
                  Composite rockwool insulated bulkhead linings featuring spline joinery for rapid shipyard installation
                  and acoustic isolation.
                </p>
                <a href="products.php" class="cutaway-spec-link" data-scroll-target="wall">
                  <span>VIEW TECHNICAL SPECS</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- 03 Ceiling Panels -->
            <div class="cutaway-item" data-cutaway-id="03" data-product-target="ceiling" role="tab"
              aria-selected="false" tabindex="0">
              <div class="cutaway-item-indicator"></div>
              <div class="cutaway-item-content">
                <div class="cutaway-item-head">
                  <span class="cutaway-num-badge">03</span>
                  <h3 class="cutaway-item-title">SELF-SUPPORTING CEILING GRIDS</h3>
                </div>
                <p class="cutaway-item-desc">
                  Self-supporting acoustic panel ceilings designed to withstand vessel vibration and pitch in heavy
                  seas.
                </p>
                <a href="products.php" class="cutaway-spec-link" data-scroll-target="ceiling">
                  <span>VIEW TECHNICAL SPECS</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- 04 Marine Wet Units -->
            <div class="cutaway-item" data-cutaway-id="04" data-product-target="wetunit" role="tab"
              aria-selected="false" tabindex="0">
              <div class="cutaway-item-indicator"></div>
              <div class="cutaway-item-content">
                <div class="cutaway-item-head">
                  <span class="cutaway-num-badge">04</span>
                  <h3 class="cutaway-item-title">PREFABRICATED MARINE WET UNITS</h3>
                </div>
                <p class="cutaway-item-desc">
                  Fully wired and plumbed modular bathroom capsules delivered ready for rapid hook-up on shipyard decks.
                </p>
                <a href="products.php" class="cutaway-spec-link" data-scroll-target="wetunit">
                  <span>VIEW TECHNICAL SPECS</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- 05 Modular Cabins -->
            <div class="cutaway-item" data-cutaway-id="05" data-product-target="cabin" role="tab" aria-selected="false"
              tabindex="0">
              <div class="cutaway-item-indicator"></div>
              <div class="cutaway-item-content">
                <div class="cutaway-item-head">
                  <span class="cutaway-num-badge">05</span>
                  <h3 class="cutaway-item-title">COMPLETE MODULAR CABINS</h3>
                </div>
                <p class="cutaway-item-desc">
                  Turnkey crew accommodation spaces integrating wall linings, ceilings, doors, wet units, and integrated
                  furniture.
                </p>
                <a href="products.php" class="cutaway-spec-link" data-scroll-target="cabin">
                  <span>VIEW TECHNICAL SPECS</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </a>
              </div>
            </div>

          </div>

          <!-- Right Column: Interactive 3D Cutaway Visual with Glowing Hotspots -->
          <div class="cutaway-visual-col">
            <div class="cutaway-image-wrapper">
              <img src="assets/vessel.png?v=1.0" alt="Sungmi 3D Vessel Accommodation Cross-Section Cutaway Blueprint"
                class="cutaway-main-img" loading="lazy">

              <!-- Ambient overlays & framing -->
              <div class="cutaway-vignette" aria-hidden="true"></div>
              <div class="cutaway-corner top-left" aria-hidden="true"></div>
              <div class="cutaway-corner top-right" aria-hidden="true"></div>
              <div class="cutaway-corner bottom-left" aria-hidden="true"></div>
              <div class="cutaway-corner bottom-right" aria-hidden="true"></div>

              <!-- Hotspot 01: Fire Resistant Doors -->
              <button class="cutaway-hotspot active" data-hotspot-id="01" style="top: 71%; left: 13.5%;"
                aria-label="Hotspot 01: A-60 / B-15 Fire Resistant Doors">
                <span class="hotspot-pulse"></span>
                <span class="hotspot-badge">01</span>
                <span class="hotspot-tooltip">01 • Fire Resistant Doors</span>
              </button>

              <!-- Hotspot 02: Wall Panels -->
              <button class="cutaway-hotspot" data-hotspot-id="02" style="top: 71%; left: 45%;"
                aria-label="Hotspot 02: B-15 / B-0 Wall Panels">
                <span class="hotspot-pulse"></span>
                <span class="hotspot-badge">02</span>
                <span class="hotspot-tooltip">02 • B-15 Wall Panels</span>
              </button>

              <!-- Hotspot 03: Ceiling Panels -->
              <button class="cutaway-hotspot" data-hotspot-id="03" style="top: 23%; left: 22%;"
                aria-label="Hotspot 03: Self-Supporting Ceiling Grids">
                <span class="hotspot-pulse"></span>
                <span class="hotspot-badge">03</span>
                <span class="hotspot-tooltip">03 • Ceiling Grids</span>
              </button>

              <!-- Hotspot 04: Marine Wet Units -->
              <button class="cutaway-hotspot" data-hotspot-id="04" style="top: 71%; left: 75%;"
                aria-label="Hotspot 04: Prefabricated Marine Wet Units">
                <span class="hotspot-pulse"></span>
                <span class="hotspot-badge">04</span>
                <span class="hotspot-tooltip">04 • Wet Unit Pod</span>
              </button>

              <!-- Hotspot 05: Modular Cabins -->
              <button class="cutaway-hotspot" data-hotspot-id="05" style="top: 28%; left: 71%;"
                aria-label="Hotspot 05: Complete Modular Cabins">
                <span class="hotspot-pulse"></span>
                <span class="hotspot-badge">05</span>
                <span class="hotspot-tooltip">05 • Modular Cabins</span>
              </button>

              <!-- HUD Status Tag -->
              <div class="cutaway-hud-badge">
                <span class="hud-live-dot"></span>
                <span class="hud-text">3D VESSEL ACCOMMODATION BLUEPRINT</span>
              </div>

            </div>
          </div>
        </div>

        <!-- INTEGRATED SUPERSTRUCTURE SOLUTIONS BANNER -->
        <div class="superstructure-banner-card" id="superstructure-banner-card">

          <!-- Left Column: Text & CTA -->
          <div class="superstructure-content-col">
            <h2 class="superstructure-banner-title">INTEGRATED SUPERSTRUCTURE<br>SOLUTIONS</h2>
            <p class="superstructure-banner-desc">
              Sungmi India offers a complete range of modular accommodation and superstructure solutions engineered for
              safety, durability and performance in demanding environments.
            </p>
            <div class="superstructure-btn-wrap">
              <a href="products.php" class="btn-superstructure-products" id="btn-superstructure-all-products">
                <span>VIEW ALL PRODUCTS</span>
              </a>
            </div>
          </div>

          <!-- Right Column: Angled Superstructure Visual & Navigation Arrows -->
          <div class="superstructure-visual-col">
            <div class="superstructure-image-wrapper">
              <div class="superstructure-slide active" data-slide="0" style="background-image: url('assets/door.jpeg');"
                role="img" aria-label="Fire Resistant Marine Doors"></div>
              <div class="superstructure-slide" data-slide="1" style="background-image: url('assets/wall.jpeg');"
                role="img" aria-label="Marine Wall Panels and Partition Systems"></div>
              <div class="superstructure-slide" data-slide="2" style="background-image: url('assets/ceiling.jpeg');"
                role="img" aria-label="Marine Acoustic Ceiling Systems"></div>
              <div class="superstructure-slide" data-slide="3" style="background-image: url('assets/wet-units.jpg');"
                role="img" aria-label="Prefabricated Marine Wet Units"></div>
              <div class="superstructure-slide" data-slide="4"
                style="background-image: url('assets/modular-cabins.jpg');" role="img"
                aria-label="Complete Modular Marine Cabins"></div>

              <!-- Bottom Right Carousel Navigation Buttons -->
              <div class="superstructure-nav-arrows" aria-label="Slide Controls">
                <button class="superstructure-nav-btn prev-btn" id="superstructure-prev"
                  aria-label="Previous Superstructure Image">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                  </svg>
                </button>
                <button class="superstructure-nav-btn next-btn" id="superstructure-next"
                  aria-label="Next Superstructure Image">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

        </div>

        <!-- SECTION — ABOUT SUNGMI (ENGINEERING BUILT ON EXPERIENCE) -->
        <div class="home-about-card" id="home-about-card">

          <!-- Left Column: Content & Metrics -->
          <div class="home-about-content-col">
            <div class="home-about-pretag">ABOUT SUNGMI</div>

            <h2 class="home-about-title">
              Engineering Built on Experience<span class="dot-accent"></span>
            </h2>

            <p class="home-about-desc">
              Sungmi India delivers high-quality accommodation and engineering solutions for marine, offshore and
              industrial environments — engineered in Goa and trusted by clients worldwide.
            </p>

            <!-- 3 Stat Metrics Row -->
            <div class="home-about-stats-row">

              <!-- Stat 1: 2018 Established -->
              <div class="home-about-stat-item">
                <div class="stat-icon-wrap">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                  </svg>
                </div>
                <div class="stat-val-text">2018</div>
                <div class="stat-label-text">Established</div>
              </div>

              <div class="stat-divider"></div>

              <!-- Stat 2: Goa, India -->
              <div class="home-about-stat-item">
                <div class="stat-icon-wrap">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                  </svg>
                </div>
                <div class="stat-val-text">Goa, India</div>
                <div class="stat-label-text">Engineering &amp;<br>Manufacturing</div>
              </div>

              <div class="stat-divider"></div>

              <!-- Stat 3: Global -->
              <div class="home-about-stat-item">
                <div class="stat-icon-wrap">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="2" y1="12" x2="22" y2="12" />
                    <path
                      d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                  </svg>
                </div>
                <div class="stat-val-text">Global</div>
                <div class="stat-label-text">Clients &amp;<br>Projects</div>
              </div>

            </div>

            <!-- CTA Button -->
            <div class="home-about-btn-wrap">
              <a href="about.php" class="btn-home-about-cta" id="btn-home-about-discover">
                <span>DISCOVER ABOUT US</span>
              </a>
            </div>

          </div>

          <!-- Right Column: Factory Image with Diagonal Cut -->
          <div class="home-about-visual-col">
            <div class="home-about-image-wrapper">
              <img src="assets/factory.png" alt="Sungmi India Manufacturing Facility Goa" class="home-about-img"
                loading="lazy">
            </div>
          </div>

        </div>

        <!-- SECTION — ENGINEERING & MANUFACTURING (CAPABILITIES & STANDARDS) -->
        <div class="home-engineering-card" id="home-engineering-card">

          <!-- Left Column: Precision Marine Fabrication Visual -->
          <div class="home-eng-visual-col">
            <div class="home-eng-image-wrapper">
              <img src="assets/ship_cutaway_hero_1787745117157.png"
                alt="Sungmi India Precision Marine Engineering & Fabrication" class="home-eng-img" loading="lazy">
            </div>
          </div>

          <!-- Right Column: Content & Certification Badges -->
          <div class="home-eng-content-col">
            <h2 class="home-eng-title">ENGINEERING &amp; MANUFACTURING</h2>

            <p class="home-eng-desc">
              State-of-the-art manufacturing in Goa combining precision Korean engineering with skilled fabrication —
              delivering ABS and IMO/SOLAS certified marine accommodation systems.
            </p>

            <!-- 4 Badges Grid -->
            <div class="home-eng-specs-grid">

              <!-- Badge 1: 01 Facility -->
              <div class="home-eng-spec-badge">
                <span class="eng-badge-val">Goa</span>
                <span class="eng-badge-label">Manufacturing<br>Facility</span>
              </div>

              <!-- Badge 2: 2018 Established -->
              <div class="home-eng-spec-badge">
                <span class="eng-badge-val">2018</span>
                <span class="eng-badge-label">Established</span>
              </div>

              <!-- Badge 3: IMO / SOLAS -->
              <div class="home-eng-spec-badge">
                <span class="eng-badge-val">IMO / SOLAS</span>
                <span class="eng-badge-label">Standards</span>
              </div>

              <!-- Badge 4: ABS -->
              <div class="home-eng-spec-badge">
                <span class="eng-badge-val">ABS</span>
                <span class="eng-badge-label">Type Approved</span>
              </div>

            </div>

            <!-- CTA Button -->
            <div class="home-eng-btn-wrap">
              <a href="engineering.php" class="btn-home-eng-cta" id="btn-home-explore-engineering">
                <span>EXPLORE ENGINEERING</span>
              </a>
            </div>

          </div>

        </div>

        <!-- SECTION — FEATURED PROJECTS & GLOBAL CLIENTS (DUAL ROW) -->
        <div class="home-dual-cards-row" id="home-projects-clients-row">

          <!-- Card 1: Featured Projects -->
          <div class="home-dual-card projects-card">
            <div>
              <div class="dual-card-header">
                <h3 class="dual-card-title">INDUSTRIES WE SERVE</h3>
              </div>

              <div class="home-projects-subgrid">

                <!-- Project 1 -->
                <div class="home-project-mini-card">
                  <div class="mini-project-img-frame">
                    <img src="assets/projects_hero_ship.jpg" alt="Offshore Accommodation Complex"
                      class="mini-project-img" loading="lazy">
                  </div>
                  <div class="mini-project-body">
                    <h4 class="mini-project-title">Commercial Vessels</h4>
                    <a href="projects.php" class="mini-project-link">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                      </svg>
                    </a>
                  </div>
                </div>

                <!-- Project 2 -->
                <div class="home-project-mini-card">
                  <div class="mini-project-img-frame">
                    <img src="assets/app_passenger_vessel_1787755668674.jpg" alt="Passenger Vessel Accommodation"
                      class="mini-project-img" loading="lazy">
                  </div>
                  <div class="mini-project-body">
                    <h4 class="mini-project-title">Passenger Vessel Accommodation</h4>
                    <a href="projects.php" class="mini-project-link">
                     
                        <path d="M5 12h14M12 5l7 7-7 7" />
                      </svg>
                    </a>
                  </div>
                </div>

                <!-- Project 3 -->
                <div class="home-project-mini-card">
                  <div class="mini-project-img-frame">
                    <img src="assets/app_offshore_platform_1787755777035.jpg" alt="Offshore Module Fabrication"
                      class="mini-project-img" loading="lazy">
                  </div>
                  <div class="mini-project-body">
                    <h4 class="mini-project-title">Offshore Module Fabrication</h4>
                    <a href="projects.php" class="mini-project-link">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                      </svg>
                    </a>
                  </div>
                </div>

              </div>
            </div>

            <div class="dual-card-btn-wrap">
              <a href="projects.php" class="btn-dual-card-action" id="btn-home-all-projects">
                <span>VIEW INDUSTRIES WE SERVE</span>
              </a>
            </div>
          </div>

          <!-- Card 2: Trusted by Global Clients -->
          <div class="home-dual-card clients-card">
            <div>
              <div class="dual-card-header">
                <h3 class="dual-card-title">TRUSTED BY GLOBAL CLIENTS</span></h3>
              </div>

              <div class="home-clients-subgrid">

                <!-- Client 1 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_antara.png" alt="Antara Cruise" class="mini-client-logo" loading="lazy">
                </div>

                <!-- Client 2 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_bright_marine.png" alt="Bright Marine" class="mini-client-logo"
                    loading="lazy">
                </div>

                <!-- Client 3 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_chowgule.png" alt="Chowgule Shipyard" class="mini-client-logo" loading="lazy">
                </div>

                <!-- Client 4 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_dynamic_energy.png" alt="Dynamic Energy" class="mini-client-logo"
                    loading="lazy">
                </div>

                <!-- Client 5 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_gandi_enterprise.png" alt="Gandhi Enterprises" class="mini-client-logo"
                    loading="lazy">
                </div>

                <!-- Client 6 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_marinor.png" alt="Marinor India" class="mini-client-logo" loading="lazy">
                </div>

                <!-- Client 7 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_moc_shipyards.png" alt="MOC Shipyards" class="mini-client-logo"
                    loading="lazy">
                </div>

                <!-- Client 8 -->
                <div class="home-client-mini-card">
                  <img src="assets/client_modutec.png" alt="Modutec" class="mini-client-logo" loading="lazy">
                </div>

                <!-- Client 9 -->
                <div class="home-client-mini-card">
                  <img src="assets/s_one.png" alt="S-One" class="mini-client-logo" loading="lazy">
                </div>

              </div>
            </div>

            <div class="dual-card-btn-wrap">
              <a href="projects.php" class="btn-dual-card-action" id="btn-home-all-clients">
                <span>VIEW ALL CLIENTS</span>
              </a>
            </div>
          </div>

        </div>

        <!-- SECTION — BUILD YOUR CAREER & LATEST INSIGHTS (BOTTOM DUAL ROW) -->
        <div class="home-dual-cards-row home-bottom-dual-row" id="home-careers-insights-row">

          <!-- Card 1: Build Your Career With Sungmi -->
          <div class="home-dual-card career-banner-card">
            <div class="career-card-content">
              <h3 class="career-card-title">BUILD YOUR CAREER WITH SUNGMI</h3>
              <p class="career-card-desc">
                Join our team of engineers, technicians and specialists delivering precision marine accommodation systems. Explore rewarding career opportunities across engineering, manufacturing, QA/QC and offshore project execution.
              </p>
              <div class="home-career-btn-wrap">
                <a href="careers.php" class="btn-dual-card-action" id="btn-home-explore-careers">
                  <span>EXPLORE CAREERS</span>
                </a>
                <a href="careers.php#careers-openings" class="btn-dual-card-action" id="btn-home-view-roles">
                 <span>VIEW ROLES</span>
                </a>

              </div>
            </div>

            <div class="career-card-visual">
              <div class="career-image-wrap">
                <img src="assets/emp.png" alt="Build Your Career With Sungmi India" class="career-engineer-img"
                  loading="lazy">
              </div>
            </div>
          </div>

          <!-- Card 2: Latest Insights -->
          <div class="home-dual-card insights-card">
            <div>
              <div class="dual-card-header">
                <h3 class="dual-card-title">LATEST INSIGHTS</h3>  
              </div>

              <div class="home-insights-subgrid">

                <!-- Blog 1 -->
                <div class="home-insight-mini-card">
                  <div class="mini-insight-img-frame">
                    <img src="assets/ship_cutaway_hero_1787745117157.png" alt="Future of Marine Accommodation Systems"
                      class="mini-insight-img" loading="lazy">
                  </div>
                  <div class="mini-insight-body">
                    <span class="mini-insight-date">02 SEP 2026</span>
                    <h4 class="mini-insight-title">FUTURE OF MARINE ENGINEERING</h4>
                    <a >
                     
                    </a>
                  </div>
                </div>

                <!-- Blog 2 -->
                <div class="home-insight-mini-card">
                  <div class="mini-insight-img-frame">
                    <img src="assets/app_offshore_platform_1787755777035.jpg" alt="Building Excellence in Marine Fabrication"
                      class="mini-insight-img" loading="lazy">
                  </div>
                  <div class="mini-insight-body">
                    <span class="mini-insight-date">03 SEP 2026</span>
                    <h4 class="mini-insight-title">OFFSHORE ENGINEERING</h4>
                    <a>
                    </a>
                  </div>
                </div>

              </div>
            </div>

            <div class="dual-card-btn-wrap">
              <a href="blogs.php" class="btn-dual-card-action" id="btn-home-view-all-insights">
                <span>VIEW ALL INSIGHTS</span>
              </a>
            </div>
          </div>

        </div>

      </div>
    </section>

 




   


   
  <!-- CERTIFICATE INSPECTION LIGHTBOX MODAL -->
  <div id="cert-modal" class="cert-modal" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="cert-modal-title">
    <div class="cert-modal-backdrop" id="cert-modal-backdrop"></div>
    <div class="cert-modal-dialog">
      <!-- Modal Header -->
      <div class="cert-modal-header">
        <h3 class="cert-modal-title" id="cert-modal-title">ABS TYPE APPROVAL — B-15 CLASS BULKHEAD (B-602)</h3>
        <button class="cert-modal-close" id="cert-modal-close" aria-label="Close Certificate Modal">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg>
        </button>
      </div>

      <!-- Modal Body (Image Container) -->
      <div class="cert-modal-body" id="cert-modal-body">
        <div class="cert-modal-img-frame">
          <img src="assets/cert_1.png" alt="ABS Certificate Preview" id="cert-modal-img" class="cert-modal-full-img">
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="cert-modal-footer">
        <div class="cert-modal-status">
          <span class="cert-status-dot"></span>
          <span>ABS Type Approval Official Document</span>
        </div>
        <button type="button" class="btn-cert-modal-close-action" id="btn-cert-modal-close-action">
          CLOSE WINDOW
        </button>
      </div>
    </div>
  </div>

  <!-- FULLSCREEN 360° PRODUCT INSPECTOR MODAL -->
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
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
              <polyline points="3 3 3 8 8 8" />
            </svg>
            <span>RESET VIEW</span>
          </button>
          <button class="control-btn active" id="btn-auto-rotate" title="Toggle Auto-Rotation">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

  <!-- Career Role Details Modal -->
  <div id="career-role-modal" class="career-modal" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="modal-role-title">
    <div class="career-modal-backdrop" id="career-role-backdrop" aria-hidden="true"></div>
    <div class="career-modal-container">
      <button type="button" class="career-modal-close-btn" id="career-role-close" aria-label="Close role modal">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>

      <div class="modal-role-header">
        <h2 class="modal-role-headline" id="modal-role-title">Mechanical / Production Engineer</h2>
        <div class="modal-role-meta-tags">
          <span class="modal-role-tag" id="modal-role-dept">Engineering</span>
          <span class="modal-role-tag" id="modal-role-location">Goa, India</span>
          <span class="modal-role-tag" id="modal-role-type">Full Time</span>
        </div>
      </div>

      <div class="modal-role-body">
        <div>
          <h4 class="modal-section-h4">Role Overview</h4>
          <p id="modal-role-overview"></p>
        </div>

        <div>
          <h4 class="modal-section-h4">Key Responsibilities</h4>
          <ul class="modal-bullet-list" id="modal-role-responsibilities"></ul>
        </div>

        <div>
          <h4 class="modal-section-h4">Requirements &amp; Qualifications</h4>
          <ul class="modal-bullet-list" id="modal-role-requirements"></ul>
        </div>

        <div class="modal-actions-row">
          <button type="button" class="btn-careers-cta-submit" id="btn-apply-from-role"
            style="width: 100%; justify-content: center;">
            <span>APPLY FOR THIS ROLE</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
              <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Career Application Form Modal -->
  <div id="career-apply-modal" class="career-modal" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="apply-modal-title">
    <div class="career-modal-backdrop" id="career-apply-backdrop" aria-hidden="true"></div>
    <div class="career-modal-container">
      <button type="button" class="career-modal-close-btn" id="career-apply-close" aria-label="Close application modal">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>

      <div class="apply-form-header">
        <h2 class="apply-modal-title" id="apply-modal-title">CAREER APPLICATION</h2>
        <p class="apply-modal-subtitle" id="apply-modal-subtitle">Submit your details and CV below.</p>
      </div>

      <form id="career-application-form" class="career-apply-form" novalidate>
        <div class="form-grid-row">
          <div class="form-group">
            <label for="apply-name" class="form-label">Full Name <span class="req">*</span></label>
            <input type="text" id="apply-name" name="name" class="form-input" placeholder="Enter your full name"
              required>
          </div>
          <div class="form-group">
            <label for="apply-email" class="form-label">Email Address <span class="req">*</span></label>
            <input type="email" id="apply-email" name="email" class="form-input" placeholder="Enter your email"
              required>
          </div>
        </div>

        <div class="form-grid-row">
          <div class="form-group">
            <label for="apply-phone" class="form-label">Mobile Number <span class="req">*</span></label>
            <input type="tel" id="apply-phone" name="phone" class="form-input" placeholder="+91 XXXXX XXXXX" required>
          </div>
          <div class="form-group">
            <label for="apply-area-interest" class="form-label">Area of Interest <span class="req">*</span></label>
            <div class="custom-select-wrapper">
              <select id="apply-area-interest" name="area_of_interest" class="form-select" required>
                <option value="Engineering">Engineering</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Projects">Projects</option>
                <option value="Corporate">Corporate</option>
                <option value="General / Any" selected>General / Any</option>
              </select>
              <div class="select-chevron">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Resume Upload -->
        <div class="form-group">
          <label class="form-label">Resume / CV Upload <span class="req">*</span></label>
          <div class="apply-drop-zone" id="apply-cv-dropzone">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#84cc16" stroke-width="1.8">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
              <polyline points="17 8 12 3 7 8" />
              <line x1="12" y1="3" x2="12" y2="15" />
            </svg>
            <span class="drop-zone-text-primary">Click to upload or drag &amp; drop your CV</span>
            <span class="drop-zone-text-sub">PDF, DOC, DOCX (Max 10MB)</span>
            <input type="file" id="apply-cv-file" name="resume" accept=".pdf,.doc,.docx" style="display:none;" required>
            <div class="attached-filename" id="apply-cv-filename" style="display:none;"></div>
          </div>
        </div>

        <!-- Message -->
        <div class="form-group">
          <label for="apply-message" class="form-label">Message / Brief Introduction</label>
          <textarea id="apply-message" name="message" class="form-textarea" rows="3"
            placeholder="Tell us briefly about your background and what you are looking for..."></textarea>
        </div>

        <div id="apply-form-status" class="apply-status-msg" role="alert"></div>

        <div class="form-submit-row" style="margin-top: 0.5rem;">
          <button type="submit" class="btn-careers-cta-submit" style="width: 100%; justify-content: center;">
            <span>SUBMIT APPLICATION</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
              <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php
  include 'includes/footer.php';
  ?>
