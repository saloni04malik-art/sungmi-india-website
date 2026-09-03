 <?php
require_once __DIR__ . '/admin/includes/db.php';
include 'includes/headerScript.php';
?>

  <!-- Minimal Site Navigation -->
  <?php include 'includes/header.php' ?>
 <!-- SECTION 06 ΓÇö PROJECTS & EXPERIENCE -->
    <section class="projects-section site-section" id="projects" aria-label="Projects and Experience">
      <div class="projects-container">

        <!-- 1. HERO BLOCK -->
        <div class="projects-hero-block">
          <div class="projects-hero-grid">

            <!-- Hero Left: Content -->
            <div class="projects-hero-content">
              <div class="projects-pretag">
                <span class="pretag-dot"></span>
                <span>PROJECTS &amp; EXPERIENCE</span>
              </div>

              <h2 class="projects-hero-headline">
                BUILT WHERE PERFORMANCE MATTERS
              </h2>


              <p class="projects-hero-desc">
                From shipbuilding and offshore platforms to specialized marine environments, Sungmi delivers
                accommodation systems built for demanding applications.
              </p>

              <!-- 3 Key Badges Row -->
              <div class="projects-badge-pills">

                <!-- Badge 1: 2018 Established -->
                <div class="project-badge-pill">
                  <div class="badge-pill-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                      <line x1="16" y1="2" x2="16" y2="6" />
                      <line x1="8" y1="2" x2="8" y2="6" />
                      <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                  </div>
                  <div class="badge-pill-text">
                    <span class="badge-pill-title">2018</span>
                    <span class="badge-pill-sub">ESTABLISHED</span>
                  </div>
                </div>

                <div class="badge-pill-divider"></div>

                <!-- Badge 2: India x Korea -->
                <div class="project-badge-pill">
                  <div class="badge-pill-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17" />
                      <path
                        d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.8-2.8l-1.6 1.4" />
                      <path d="M2 13l3.5-3.5a2 2 0 0 1 2.8 0L10 11" />
                    </svg>
                  </div>
                  <div class="badge-pill-text">
                    <span class="badge-pill-title">INDIA &times; KOREA</span>
                    <span class="badge-pill-sub">JOINT VENTURE</span>
                  </div>
                </div>

                <div class="badge-pill-divider"></div>

                <!-- Badge 3: Marine Accommodation Systems -->
                <div class="project-badge-pill">
                  <div class="badge-pill-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="1.8">
                      <polygon points="12 2 2 7 12 12 22 7 12 2" />
                      <polyline points="2 17 12 22 22 17" />
                      <polyline points="2 12 12 17 22 12" />
                    </svg>
                  </div>
                  <div class="badge-pill-text">
                    <span class="badge-pill-title">MARINE</span>
                    <span class="badge-pill-sub">ACCOMMODATION SYSTEMS</span>
                  </div>
                </div>

              </div>
            </div>

            <!-- Hero Right: High-Res Marine Vessel -->
            <div class="projects-hero-visual">
              <div class="hero-vessel-frame">
                <img src="assets/projects_hero_ship.jpg"
                  alt="Commercial marine vessel navigating at sunset - Sungmi Projects" class="hero-vessel-img"
                  loading="eager">
                <div class="vessel-frame-overlay"></div>
                <div class="vessel-corner-accent tl"></div>
                <div class="vessel-corner-accent tr"></div>
                <div class="vessel-corner-accent bl"></div>
                <div class="vessel-corner-accent br"></div>
              </div>
            </div>

          </div>
        </div>

        <!-- 2. INDUSTRIES WE SERVE -->
        <div class="projects-industries-block">
          <div class="block-section-header text-center">
            <span class="block-pretag">INDUSTRIES WE SERVE</span>
            <h3 class="block-title">ENGINEERED FOR COMPLEX ENVIRONMENTS</h3>
          </div>

          <div class="industries-grid">

            <!-- Card 1: Shipbuilding -->
            <div class="industry-card">
              <div class="industry-card-visual">
                <img src="assets/app_commercial_ship_1787755606765.jpg" alt="Shipbuilding - Commercial and Naval Ships"
                  class="industry-img" loading="lazy">
                <div class="industry-visual-overlay"></div>
              </div>
              <div class="industry-card-body">
                <div class="industry-icon-box">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M2 19h20M2 15l2-8h16l2 8M6 7l1-4h10l1 4M12 3v4" />
                  </svg>
                </div>
                <h4 class="industry-title">SHIPBUILDING</h4>
                <p class="industry-subtitle">Commercial &amp; Naval Ships</p>
                <div class="industry-arrow-btn">
                 
                </div>
              </div>
            </div>

            <!-- Card 2: Offshore -->
            <div class="industry-card">
              <div class="industry-card-visual">
                <img src="assets/app_offshore_platform_1787755777035.jpg" alt="Offshore - Rigs and Production Platforms"
                  class="industry-img" loading="lazy">
                <div class="industry-visual-overlay"></div>
              </div>
              <div class="industry-card-body">
                <div class="industry-icon-box">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 22h16M7 22l3-12h4l3 12M10 10l2-8 2 8M6 16h12" />
                  </svg>
                </div>
                <h4 class="industry-title">OFFSHORE</h4>
                <p class="industry-subtitle">Rigs &amp; Production Platforms</p>
                <div class="industry-arrow-btn">
                  
                </div>
              </div>
            </div>

            <!-- Card 3: Oil & Gas -->
            <div class="industry-card">
              <div class="industry-card-visual">
                <img src="assets/app_oil_gas_rig_1787755846799.jpg" alt="Oil & Gas - Industrial and Upstream Facilities"
                  class="industry-img" loading="lazy">
                <div class="industry-visual-overlay"></div>
              </div>
              <div class="industry-card-body">
                <div class="industry-icon-box">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 21h18M5 21V9l4-4v16M9 9h4v12M15 5h4v16M13 13h2" />
                  </svg>
                </div>
                <h4 class="industry-title">OIL &amp; GAS</h4>
                <p class="industry-subtitle">Industrial &amp; Upstream Facilities</p>
                <div class="industry-arrow-btn">
                 
                </div>
              </div>
            </div>

            <!-- Card 4: Passenger -->
            <div class="industry-card">
              <div class="industry-card-visual">
                <img src="assets/app_passenger_vessel_1787755668674.jpg" alt="Passenger - Cruise and Ferry Vessels"
                  class="industry-img" loading="lazy">
                <div class="industry-visual-overlay"></div>
              </div>
              <div class="industry-card-body">
                <div class="industry-icon-box">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 18h18M4 14l2-6h12l2 6M7 8l1-3h8l1 3M6 14h12M10 11h4" />
                  </svg>
                </div>
                <h4 class="industry-title">PASSENGER</h4>
                <p class="industry-subtitle">Cruise &amp; Ferry Vessels</p>
                <div class="industry-arrow-btn">
                  
                </div>
              </div>
            </div>

            <!-- Card 5: Specialized Structures -->
            <div class="industry-card">
              <div class="industry-card-visual">
                <img src="assets/app_wind_specialized.jpg" alt="Specialized Structures - Wind, HVAC Substations & More"
                  class="industry-img" loading="lazy">
                <div class="industry-visual-overlay"></div>
              </div>
              <div class="industry-card-body">
                <div class="industry-icon-box">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M12 22V12M12 12L7 4M12 12l9 3M12 12l-7 7M12 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                  </svg>
                </div>
                <h4 class="industry-title">SPECIALIZED STRUCTURES</h4>
                <p class="industry-subtitle">Wind, HVAC Substations &amp; More</p>
                <div class="industry-arrow-btn">
                 
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- 3. OUR CLIENTS & GLOBAL NETWORK -->
        <div class="projects-clients-block" id="projects-clients">

          <!-- Subtle Global Map Background Overlay -->
          <div class="clients-network-map" aria-hidden="true">
            <svg class="map-svg" viewBox="0 0 1200 480" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <radialGradient id="mapGlow1" cx="50%" cy="50%" r="50%">
                  <stop offset="0%" stop-color="#84cc16" stop-opacity="0.3" />
                  <stop offset="100%" stop-color="#84cc16" stop-opacity="0" />
                </radialGradient>
                <radialGradient id="mapGlow2" cx="50%" cy="50%" r="50%">
                  <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.25" />
                  <stop offset="100%" stop-color="#38bdf8" stop-opacity="0" />
                </radialGradient>
              </defs>

              <!-- Dotted World Map Grid -->
              <g opacity="0.12" fill="#94a3b8">
                <!-- North America -->
                <circle cx="210" cy="140" r="1.5" />
                <circle cx="230" cy="140" r="1.5" />
                <circle cx="250" cy="150" r="1.5" />
                <circle cx="270" cy="160" r="1.5" />
                <circle cx="290" cy="170" r="1.5" />
                <circle cx="240" cy="170" r="1.5" />
                <circle cx="220" cy="180" r="1.5" />
                <circle cx="260" cy="190" r="1.5" />
                <circle cx="280" cy="190" r="1.5" />
                <circle cx="300" cy="200" r="1.5" />
                <!-- Europe -->
                <circle cx="560" cy="130" r="1.5" />
                <circle cx="580" cy="120" r="1.5" />
                <circle cx="600" cy="120" r="1.5" />
                <circle cx="570" cy="140" r="1.5" />
                <circle cx="590" cy="140" r="1.5" />
                <circle cx="610" cy="140" r="1.5" />
                <circle cx="580" cy="160" r="1.5" />
                <circle cx="600" cy="160" r="1.5" />
                <!-- Middle East / UAE -->
                <circle cx="680" cy="200" r="1.5" />
                <circle cx="700" cy="210" r="1.5" />
                <circle cx="690" cy="220" r="1.5" />
                <circle cx="710" cy="230" r="1.5" />
                <!-- India & South Asia -->
                <circle cx="760" cy="220" r="1.5" />
                <circle cx="780" cy="220" r="1.5" />
                <circle cx="770" cy="240" r="1.5" />
                <circle cx="790" cy="240" r="1.5" />
                <circle cx="780" cy="260" r="1.5" />
                <circle cx="800" cy="260" r="1.5" />
                <circle cx="790" cy="280" r="1.5" />
                <!-- East Asia / Korea -->
                <circle cx="910" cy="170" r="1.5" />
                <circle cx="930" cy="170" r="1.5" />
                <circle cx="920" cy="190" r="1.5" />
                <circle cx="940" cy="190" r="1.5" />
                <circle cx="950" cy="210" r="1.5" />
                <!-- Australia -->
                <circle cx="960" cy="330" r="1.5" />
                <circle cx="980" cy="340" r="1.5" />
                <circle cx="1000" cy="350" r="1.5" />
                <circle cx="970" cy="360" r="1.5" />
                <circle cx="990" cy="370" r="1.5" />
                <circle cx="1010" cy="380" r="1.5" />
              </g>

              <!-- Connecting Flight / Shipping Route Arcs -->
              <path d="M 780 250 Q 735 220 700 215" stroke="rgba(132, 204, 22, 0.25)" stroke-width="1"
                stroke-dasharray="3 3" />
              <path d="M 780 250 Q 850 200 930 180" stroke="rgba(132, 204, 22, 0.25)" stroke-width="1"
                stroke-dasharray="3 3" />
              <path d="M 780 250 Q 880 300 980 350" stroke="rgba(56, 189, 248, 0.25)" stroke-width="1"
                stroke-dasharray="3 3" />
              <path d="M 780 250 Q 520 180 270 170" stroke="rgba(56, 189, 248, 0.2)" stroke-width="1"
                stroke-dasharray="4 4" />

              <!-- Interactive Pulsing Location Nodes -->
              <!-- Hub 1: India (Goa Headquarters) -->
              <circle cx="780" cy="250" r="14" fill="url(#mapGlow1)" />
              <circle cx="780" cy="250" r="4" fill="#84cc16" />
              <circle cx="780" cy="250" r="8" stroke="#84cc16" stroke-width="1" opacity="0.7" />

              <!-- Hub 2: South Korea -->
              <circle cx="930" cy="180" r="12" fill="url(#mapGlow1)" />
              <circle cx="930" cy="180" r="3.5" fill="#84cc16" />

              <!-- Hub 3: UAE / Middle East -->
              <circle cx="700" cy="215" r="10" fill="url(#mapGlow2)" />
              <circle cx="700" cy="215" r="3" fill="#38bdf8" />

              <!-- Hub 4: USA -->
              <circle cx="270" cy="170" r="10" fill="url(#mapGlow2)" />
              <circle cx="270" cy="170" r="3" fill="#38bdf8" />

              <!-- Hub 5: Australia -->
              <circle cx="980" cy="350" r="10" fill="url(#mapGlow2)" />
              <circle cx="980" cy="350" r="3" fill="#38bdf8" />
            </svg>
          </div>

          <div class="block-section-header text-center">
            <span class="block-pretag">TRUSTED BY GLOBAL LEADERS</span>
            <h3 class="block-title">OUR CLIENTS</h3>
          </div>

          <!-- Client Logos Showcase -->
          <div class="clients-showcase-container">

          <?php
          /* ==========================================================================
             FETCH ACTIVE, NON-DELETED CLIENTS FROM MYSQL
             ========================================================================== */
          $clientsQuery = "SELECT id, name, logo 
                           FROM clients 
                           WHERE status = 1 AND is_deleted = 0 
                           ORDER BY id ASC";
          $clientsResult = mysqli_query($conn, $clientsQuery);
          $clients = [];
          if ($clientsResult) {
              while ($row = mysqli_fetch_assoc($clientsResult)) {
                  $clients[] = $row;
              }
          }

          if (!function_exists('renderClientCard')) {
              function renderClientCard($client, $isCenterRow = false) {
                  $cardClass = 'client-logo-card' . ($isCenterRow ? ' card-modutec' : '');
                  $hasLogo = !empty($client['logo']) && file_exists(__DIR__ . '/' . $client['logo']);

                  $extraLogoClass = '';
                  if ($hasLogo) {
                      if (stripos($client['logo'], 's_one') !== false || stripos($client['name'], 'S-ONE') !== false) {
                          $extraLogoClass = ' logo-s-one';
                      } elseif (stripos($client['logo'], 'bright_marine') !== false || stripos($client['name'], 'Bright Marine') !== false) {
                          $extraLogoClass = ' logo-bright-marine';
                      }
                  }
          ?>
                <div class="<?php echo $cardClass; ?>">
                  <div class="client-card-inner">
                    <?php if ($hasLogo) { ?>
                      <img src="<?php echo htmlspecialchars($client['logo']); ?>"
                           alt="<?php echo htmlspecialchars($client['name']); ?>"
                           class="client-logo-img<?php echo $extraLogoClass; ?>">
                    <?php } else {
                        $name = trim($client['name']);
                        $mainName = $name;
                        $subName = '';

                        if (stripos($name, 'BLUE BAY') !== false) {
                            $mainName = 'BLUE BAY';
                            $subName = 'ENGINEERING';
                        } elseif (stripos($name, 'AR SHIP') !== false) {
                            $mainName = 'AR SHIP';
                            $subName = 'SOLUTIONS';
                        } elseif (stripos($name, 'DALHEERM') !== false) {
                            $mainName = 'DALHEERM';
                            $subName = 'INTERNATIONAL PVT. LTD.';
                        } else {
                            $words = explode(' ', $name);
                            if (count($words) >= 2) {
                                $subName = array_pop($words);
                                $mainName = implode(' ', $words);
                            }
                        }
                    ?>
                      <div class="client-info-group text-center">
                        <span class="client-company-name"><?php echo htmlspecialchars($mainName); ?></span>
                        <?php if ($subName !== '') { ?>
                          <span class="client-company-sub"><?php echo htmlspecialchars($subName); ?></span>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
          <?php
              }
          }

          if (!empty($clients)) {
              $totalClients = count($clients);
              $fullRowsCount = intdiv($totalClients, 6);
              $remainder = $totalClients % 6;

              // Rows of 6
              for ($r = 0; $r < $fullRowsCount; $r++) {
                  $rowClients = array_slice($clients, $r * 6, 6);
          ?>
            <div class="clients-cards-row row-six">
              <?php foreach ($rowClients as $client) {
                  renderClientCard($client, false);
              } ?>
            </div>
          <?php } ?>

          <?php
              // Remaining clients centered
              if ($remainder > 0) {
                  $remainingClients = array_slice($clients, $fullRowsCount * 6);
          ?>
            <div class="clients-cards-row row-center">
              <?php foreach ($remainingClients as $client) {
                  renderClientCard($client, true);
              } ?>
            </div>
          <?php } ?>

          <?php } else { ?>
            <p style="text-align: center; color: #94a3b8; padding: 2rem 0;">
              No clients available at this time.
            </p>
          <?php } ?>

          </div>
        </div>

        <!-- 4. FINAL CTA STRIP -->
        <div class="projects-cta-strip">

          <!-- Blueprint Vessel Line Graphic on Left -->
          <div class="cta-vessel-schematic" aria-hidden="true">
            <svg class="schematic-svg" viewBox="0 0 280 90" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M 5 65 L 45 78 L 220 78 L 270 58 L 275 42 L 230 42 L 210 25 L 180 25 L 175 42 L 100 42 L 95 32 L 65 32 L 60 42 L 5 50 Z"
                stroke="#b5cf2b" stroke-width="1.5" stroke-opacity="0.8" fill="none" />
              <line x1="5" y1="58" x2="265" y2="58" stroke="#b5cf2b" stroke-width="1" stroke-dasharray="3 3"
                stroke-opacity="0.6" />
              <line x1="45" y1="78" x2="45" y2="58" stroke="#b5cf2b" stroke-width="1" stroke-opacity="0.5" />
              <line x1="100" y1="78" x2="100" y2="42" stroke="#b5cf2b" stroke-width="1" stroke-opacity="0.5" />
              <line x1="160" y1="78" x2="160" y2="42" stroke="#b5cf2b" stroke-width="1" stroke-opacity="0.5" />
              <line x1="210" y1="78" x2="210" y2="25" stroke="#b5cf2b" stroke-width="1" stroke-opacity="0.5" />
              <rect x="185" y="15" width="20" height="10" stroke="#b5cf2b" stroke-width="1.2" stroke-opacity="0.7" />
              <line x1="195" y1="15" x2="195" y2="5" stroke="#b5cf2b" stroke-width="1.5" stroke-opacity="0.9" />
              <circle cx="195" cy="4" r="2" fill="#b5cf2b" />
            </svg>
          </div>

          <!-- Center Text -->
          <div class="cta-center-text">
            <h3 class="cta-title">HAVE A PROJECT IN MIND?</h3>
            <p class="cta-subtitle">
              Let's engineer the right accommodation solution for your next marine or offshore project.
            </p>
          </div>

          <!-- Right Action Button -->
          <a href="enquiry.php" class="btn-projects-cta" id="btn-projects-start-project">
            <span>START A PROJECT</span>
          </a>

        </div>

      </div>
    </section>

       <?php
  include 'includes/footer.php';
  ?>
