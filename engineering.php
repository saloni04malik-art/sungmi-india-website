 <?php
include 'includes/headerScript.php';
?>

  <!-- Minimal Site Navigation -->
  <?php include 'includes/header.php' ?>
    <!-- SECTION 04 ΓÇö ENGINEERING & MANUFACTURING (JOURNEY SCROLL EXPERIENCE) -->
    <section class="engineering-section site-section" id="engineering"
      aria-label="Engineering & Manufacturing Capabilities">
      <div class="engineering-container">

        <!-- Section Header Area -->
        <div class="eng-header-block">
          <div class="eng-pretag">
            <span class="pretag-dot"></span>
            <span>ENGINEERING &amp; MANUFACTURING</span>
          </div>
          <h2 class="eng-headline">BUILT WITH PRECISION, <br> TESTED FOR THE MARINE ENVIRONMENT.</h2>
          <p class="eng-subhead">
            From precision fabrication to testing and type approval Sungmi India manufactures marine accommodation
            systems with safety, reliability and performance at every step.
          </p>
        </div>

        <!-- 5-Step Continuous Journey Layout -->
        <div class="eng-journey-layout">

          <!-- Sticky Sidebar Progress Tracker -->
          <aside class="eng-progress-sidebar" aria-label="Journey Progress Navigation">
            <div class="eng-progress-title">JOURNEY PROGRESS</div>
            <ul class="eng-nav-list">
              <li class="eng-nav-item active" data-step="step-01-facility">
                <a href="#step-01-facility" class="eng-nav-link">
                  <span class="eng-nav-dot"></span>
                  <span>01 Facility</span>
                </a>
              </li>
              <li class="eng-nav-item" data-step="step-02-manufacturing">
                <a href="#step-02-manufacturing" class="eng-nav-link">
                  <span class="eng-nav-dot"></span>
                  <span>02 Manufacturing</span>
                </a>
              </li>
              <li class="eng-nav-item" data-step="step-04-approval">
                <a href="#step-04-approval" class="eng-nav-link">
                  <span class="eng-nav-dot"></span>
                  <span>03 Type Approval</span>
                </a>
              </li>
              <li class="eng-nav-item" data-step="step-05-certifications">
                <a href="#step-05-certifications" class="eng-nav-link">
                  <span class="eng-nav-dot"></span>
                  <span>04 Certifications</span>
                </a>
              </li>
            </ul>
          </aside>

          <!-- Main Stream of 5 Step Cards -->
          <div class="eng-journey-content">

            <!-- STEP 01 ΓÇö FACILITY -->
            <div class="eng-step-card active-step" id="step-01-facility">
              <div class="eng-step-header">
                <h3 class="eng-step-title">MANUFACTURING FACILITY <span class="highlight">VERNA, GOA</span></h3>
              </div>

              <div class="facility-address-bar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                  <circle cx="12" cy="10" r="3" />
                </svg>
                <span>Plot No. I-10, Verna Industrial Estate, Verna, Salcete, Goa ΓÇô 403722, India</span>
              </div>

              <div class="facility-hero-wrap">
                <img src="assets/factory.png" alt="Sungmi India Modern Manufacturing Plant, Verna Goa Industrial Estate"
                  class="facility-img" loading="lazy">

                <div class="facility-hud-overlay">
                  <div class="facility-hud-item">
                    <span class="facility-hud-label">FACILITY UNITS</span>
                    <span class="facility-hud-val">Manufacturing: 1 Unit ΓÇö Verna, Goa</span>
                  </div>
                  <div class="facility-hud-item">
                    <span class="facility-hud-label">LOGISTICS &amp; STORAGE</span>
                    <span class="facility-hud-val">Warehouse: On-site Integrated</span>
                  </div>
                  <div class="facility-hud-item">
                    <span class="facility-hud-label">STANDARDS</span>
                    <span class="facility-hud-val">IMO / SOLAS &amp; ABS Certified</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- STEP 02 ΓÇö MANUFACTURING CAPABILITIES -->
            <div class="eng-step-card" id="step-02-manufacturing">
              <div class="eng-step-header">
                <h3 class="eng-step-title">MANUFACTURING CAPABILITIES</h3>
                <p class="eng-step-sub">
                  Advanced machinery, skilled engineering and controlled processes ensure consistent quality across
                  every product we build.
                </p>
              </div>

              <div class="capabilities-grid">

                <!-- 1. CNC Plasma / Laser -->
                <div class="capability-card">
                  <div class="capability-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                    </svg>
                  </div>
                  <h4 class="capability-title">CNC PLASMA / LASER CUTTING</h4>
                  <p class="capability-desc">Precision steel fabrication</p>
                </div>

                <!-- 2. MIG / TIG Welding -->
                <div class="capability-card">
                  <div class="capability-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <circle cx="12" cy="12" r="9" />
                      <line x1="12" y1="3" x2="12" y2="7" />
                      <line x1="12" y1="17" x2="12" y2="21" />
                    </svg>
                  </div>
                  <h4 class="capability-title">MIG / TIG WELDING</h4>
                  <p class="capability-desc">Door frame &amp; panel assembly</p>
                </div>

                <!-- 3. Hydraulic Bending -->
                <div class="capability-card">
                  <div class="capability-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <rect x="4" y="4" width="16" height="16" rx="2" />
                      <line x1="4" y1="12" x2="20" y2="12" />
                    </svg>
                  </div>
                  <h4 class="capability-title">HYDRAULIC BENDING &amp; PRESSING</h4>
                  <p class="capability-desc">Sheet-metal forming</p>
                </div>

                <!-- 4. Panel Lamination -->
                <div class="capability-card">
                  <div class="capability-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <polygon points="12 2 2 7 12 12 22 7 12 2" />
                      <polyline points="2 17 12 22 22 17" />
                      <polyline points="2 12 12 17 22 12" />
                    </svg>
                  </div>
                  <h4 class="capability-title">PANEL LAMINATION &amp; BONDING</h4>
                  <p class="capability-desc">Panel manufacturing</p>
                </div>

                <!-- 5. Powder Coating -->
                <div class="capability-card">
                  <div class="capability-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <path d="M12 2v7.5" />
                      <path d="m19 5-5.5 4.5" />
                      <path d="m5 5 5.5 4.5" />
                      <rect x="6" y="14" width="12" height="8" rx="2" />
                    </svg>
                  </div>
                  <h4 class="capability-title">POWDER COATING</h4>
                  <p class="capability-desc">Surface finishing</p>
                </div>


              </div>
            </div>


            <!-- STEP 04 ΓÇö TYPE APPROVAL -->
            <div class="eng-step-card" id="step-04-approval">
              <div class="eng-step-header">
                <span class="type-approval-banner">FIRST INDIAN MANUFACTURER</span>
                <h3 class="eng-step-title">TYPE APPROVAL</h3>
                <p class="eng-step-sub">
                  Our products are approved to international maritime standards for global acceptance and offshore
                  readiness.
                </p>
              </div>

              <div class="approval-pillars-grid">

                <!-- Pillar 01 -->
                <div class="approval-pillar-card">
                  <div class="pillar-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                  </div>
                  <span class="pillar-num">01</span>
                  <h4 class="pillar-title">SOLAS COMPLIANCE</h4>
                  <p class="pillar-desc">
                    Strict adherence to the International Convention for the Safety of Life at Sea ΓÇö the absolute
                    baseline requirement for all international shipyard supply.
                  </p>
                </div>

                <!-- Pillar 02 -->
                <div class="approval-pillar-card">
                  <div class="pillar-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <circle cx="12" cy="12" r="10" />
                      <line x1="2" y1="12" x2="22" y2="12" />
                      <path
                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                    </svg>
                  </div>
                  <span class="pillar-num">02</span>
                  <h4 class="pillar-title">GLOBAL MARKET ACCESS</h4>
                  <p class="pillar-desc">
                    Signals to global shipyards that fire doors, panels &amp; modular wet units meet the highest
                    maritime safety and structural standards worldwide.
                  </p>
                </div>

                <!-- Pillar 03 -->
                <div class="approval-pillar-card">
                  <div class="pillar-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <path d="M12 2v20M7 22l5-10 5 10M2 14h20M6 8h12" />
                    </svg>
                  </div>
                  <span class="pillar-num">03</span>
                  <h4 class="pillar-title">OFFSHORE QUALIFICATION</h4>
                  <p class="pillar-desc">
                    Directly qualifies manufacturing lines for offshore drilling platforms &amp; production rigs, where
                    safety tolerances leave zero room for error.
                  </p>
                </div>

              </div>
            </div>

            <!-- STEP 05 ΓÇö CERTIFICATES -->
            <div class="eng-step-card" id="step-05-certifications">
              <div class="eng-step-header">
                <h3 class="eng-step-title">TYPE APPROVAL CERTIFICATES</h3>
                <p class="eng-step-sub">
                  Sungmi India products are ABS type approved.
                </p>
              </div>

              <div class="certs-showcase-wrap">
                <div class="certs-grid">

                  <!-- Certificate 01: B-15 Class Bulkhead (B-602) -->
                  <div class="cert-card-item" data-cert-index="1"
                    data-cert-title="ABS TYPE APPROVAL B-15 CLASS BULKHEAD (B-602)"
                    data-cert-img="assets/cert_1.png">
                    <div class="cert-img-frame">
                      <img src="assets/cert_1.png" alt="ABS Type Approval B-15 Class Bulkhead (B-602)"
                        loading="lazy" class="cert-thumb-img">
                    </div>
                    <div class="cert-card-body">
                      <div class="cert-card-badge">ABS TYPE APPROVAL</div>
                      <h4 class="cert-card-title">ABS TYPE APPROVAL B-15 CLASS BULKHEAD (B-602)</h4>
                      <p class="cert-card-desc">Type Approval for B-15 Class Bulkhead (B-602) constructed with 25mm
                        mineral wool core (140 kg/m┬│) and galvanized steel sheet casing.</p>
                      <button type="button" class="btn-view-cert"
                        aria-label="View ABS Type Approval B-15 Class Bulkhead (B-602) Certificate">
                        <span>VIEW CERTIFICATE</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                          <circle cx="12" cy="12" r="3" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Certificate 02: B-15 Bulkhead (B-502 Series) -->
                  <div class="cert-card-item" data-cert-index="2"
                    data-cert-title="ABS TYPE APPROVAL  B-15 BULKHEAD (B-502 SERIES)"
                    data-cert-img="assets/cert_2.png">
                    <div class="cert-img-frame">
                      <img src="assets/cert_2.png" alt="ABS Type Approval  B-15 Bulkhead (B-502 Series)"
                        loading="lazy" class="cert-thumb-img">
                    </div>
                    <div class="cert-card-body">
                      <div class="cert-card-badge">ABS TYPE APPROVAL</div>
                      <h4 class="cert-card-title">ABS TYPE APPROVAL  B-15 BULKHEAD (B-502 SERIES)</h4>
                      <p class="cert-card-desc">Type Approval for B-15 Class Bulkhead (B-502B/502C) with 50mm panel
                        thickness, internal cable conduit way, and STC 33 dB acoustic rating.</p>
                      <button type="button" class="btn-view-cert"
                        aria-label="View ABS Type Approval B-15 Bulkhead (B-502 Series) Certificate">
                        <span>VIEW CERTIFICATE</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                          <circle cx="12" cy="12" r="3" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Certificate 03: B-0 Ceiling System (C-004) -->
                  <div class="cert-card-item" data-cert-index="3"
                    data-cert-title="ABS TYPE APPROVAL B-0 CEILING SYSTEM (C-004)"
                    data-cert-img="assets/cert_3.png">
                    <div class="cert-img-frame">
                      <img src="assets/cert_3.png" alt="ABS Type Approval B-0 Ceiling System (C-004)" loading="lazy"
                        class="cert-thumb-img">
                    </div>
                    <div class="cert-card-body">
                      <div class="cert-card-badge">ABS TYPE APPROVAL</div>
                      <h4 class="cert-card-title">ABS TYPE APPROVAL  B-0 CEILING SYSTEM (C-004)</h4>
                      <p class="cert-card-desc">Type Approval for B-0 Class Ceiling (C-004) featuring 0.6mm galvanized
                        steel sheet with 25mm mineral wool insulation (60 kg/m┬│).</p>
                      <button type="button" class="btn-view-cert"
                        aria-label="View ABS Type Approval B-0 Ceiling System (C-004) Certificate">
                        <span>VIEW CERTIFICATE</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                          <circle cx="12" cy="12" r="3" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Certificate 04: B-15 & B-30 Fire Doors -->
                  <div class="cert-card-item" data-cert-index="4"
                    data-cert-title="ABS TYPE APPROVAL  B-15 &amp; B-30 FIRE DOORS"
                    data-cert-img="assets/cert_4.png">
                    <div class="cert-img-frame">
                      <img src="assets/cert_4.png" alt="ABS Type Approval  B-15 &amp; B-30 Fire Doors" loading="lazy"
                        class="cert-thumb-img">
                    </div>
                    <div class="cert-card-body">
                      <div class="cert-card-badge">ABS TYPE APPROVAL</div>
                      <h4 class="cert-card-title">ABS TYPE APPROVAL  B-15 &amp; B-30 FIRE DOORS</h4>
                      <p class="cert-card-desc">Type Approval for B-30 and B-15 Class Single Fire Doors (SM-B30-2B,
                        SM-B15-S1/SL/HS/HD/NS) with vision glass, kick-out escape panels, and louvers.</p>
                      <button type="button" class="btn-view-cert"
                        aria-label="View ABS Type Approval B-15 &amp; B-30 Fire Doors Certificate">
                        <span>VIEW CERTIFICATE</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                          <circle cx="12" cy="12" r="3" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Certificate 05: A-Class Fire Protection Doors -->
                  <div class="cert-card-item" data-cert-index="5"
                    data-cert-title="ABS TYPE APPROVAL  A-CLASS FIRE PROTECTION DOORS"
                    data-cert-img="assets/cert_5.png">
                    <div class="cert-img-frame">
                      <img src="assets/cert_5.png" alt="ABS Type Approval  A-Class Fire Protection Doors"
                        loading="lazy" class="cert-thumb-img">
                    </div>
                    <div class="cert-card-body">
                      <div class="cert-card-badge">ABS TYPE APPROVAL</div>
                      <h4 class="cert-card-title">ABS TYPE APPROVAL  A-CLASS FIRE PROTECTION DOORS</h4>
                      <p class="cert-card-desc">Type Approval for A-Class Fire Protection Doors (SM-A60, SM-A30, SM-A0
                        series) engineered for marine vessels and offshore installations.</p>
                      <button type="button" class="btn-view-cert"
                        aria-label="View ABS Type Approval A-Class Fire Protection Doors Certificate">
                        <span>VIEW CERTIFICATE</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                          <circle cx="12" cy="12" r="3" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Certificate 06: Bulkhead & Ceiling Systems (UB/UC Series) -->
                  <div class="cert-card-item" data-cert-index="6"
                    data-cert-title="ABS TYPE APPROVAL  BULKHEAD &amp; CEILING (UB/UC SERIES)"
                    data-cert-img="assets/cert_6.png">
                    <div class="cert-img-frame">
                      <img src="assets/cert_6.png" alt="ABS Type Approval Bulkhead &amp; Ceiling (UB/UC Series)"
                        loading="lazy" class="cert-thumb-img">
                    </div>
                    <div class="cert-card-body">
                      <div class="cert-card-badge">ABS TYPE APPROVAL</div>
                      <h4 class="cert-card-title">ABS TYPE APPROVAL BULKHEAD &amp; CEILING (UB/UC SERIES)</h4>
                      <p class="cert-card-desc">Type Approval for UB-801 (B-0 Bulkhead), UB-802 (B-15 Bulkhead with STC
                        44 dB), and UC-803 (B-0 Ceiling) acoustic insulation systems.</p>
                      <button type="button" class="btn-view-cert"
                        aria-label="View ABS Type Approval Bulkhead &amp; Ceiling (UB/UC Series) Certificate">
                        <span>VIEW CERTIFICATE</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                          <circle cx="12" cy="12" r="3" />
                        </svg>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <!-- Closing Section Banner -->
            <div class="eng-closing-banner">
              <div class="closing-text-col">
                <h3 class="closing-headline">ENGINEERED IN GOA.<br>READY FOR THE MARINE WORLD.</h3>
                <p class="closing-subhead">
                  Precision manufacturing, rigorous testing and type-approved accommodation systems for marine and
                  offshore applications.
                </p>
              </div>
              <a href="enquiry.php" class="btn-start-project" id="btn-eng-start-project">
                <span>START A PROJECT</span>
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

<?php
include 'includes/footer.php';
?>
