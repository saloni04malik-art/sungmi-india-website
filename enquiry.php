 <?php
include 'includes/headerScript.php';
?>

  <!-- Minimal Site Navigation -->
  <?php include 'includes/header.php' ?>

   <!-- SECTION 08 PROJECT ENQUIRY (OFFICIAL TEMPLATE SPECIFICATION) -->
    <section class="enquiry-section site-section" id="enquiry" aria-label="Tell Us About Your Project">

      <!-- Subtle World Map Watermark Background -->
      <div class="enquiry-map-bg" aria-hidden="true"></div>

      <div class="enquiry-container">

        <!-- 1. HERO HEADER BLOCK -->
        <div class="enquiry-hero-block">
          <div class="enquiry-hero-grid">

            <!-- Left: Text Title & Description -->
            <div class="enquiry-hero-content">
              <div class="enquiry-pretag">
                <span class="pretag-dot"></span>
                <span>PRODUCT ENQUIRY</span>
              </div>

              <h2 class="enquiry-hero-headline">
                TELL US ABOUT<br>YOUR REQUIREMENT
              </h2>

              <p class="enquiry-hero-desc">
                Share your requirement and our team will get in touch with you.
              </p>
            </div>

            <!-- Right: Marine Vessel Schematic Graphic -->
            <div class="enquiry-hero-graphic" aria-hidden="true">
              <div class="hero-graphic-halo"></div>
              <svg class="enquiry-vessel-art" viewBox="0 0 540 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Hull lines -->
                <path
                  d="M 20 155 L 110 190 L 440 190 L 520 142 L 505 85 L 420 85 L 400 58 L 330 58 L 320 85 L 180 85 L 170 112 L 20 112 Z"
                  stroke="#84cc16" stroke-width="1.8" fill="none" />
                <!-- Deck lines -->
                <line x1="20" y1="155" x2="510" y2="155" stroke="rgba(132, 204, 22, 0.4)" stroke-width="1.2"
                  stroke-dasharray="4 4" />
                <line x1="110" y1="190" x2="110" y2="155" stroke="rgba(132, 204, 22, 0.4)" stroke-width="1" />
                <line x1="220" y1="190" x2="220" y2="85" stroke="rgba(132, 204, 22, 0.4)" stroke-width="1" />
                <line x1="330" y1="190" x2="330" y2="58" stroke="rgba(132, 204, 22, 0.4)" stroke-width="1" />
                <line x1="420" y1="190" x2="420" y2="85" stroke="rgba(132, 204, 22, 0.4)" stroke-width="1" />
                <!-- Bridge & Navigation Tower -->
                <rect x="340" y="38" width="55" height="20" stroke="#84cc16" stroke-width="1.4" fill="none" />
                <line x1="367" y1="38" x2="367" y2="12" stroke="#84cc16" stroke-width="1.8" />
                <circle cx="367" cy="10" r="3" fill="#84cc16" />
                <line x1="355" y1="22" x2="380" y2="22" stroke="rgba(132, 204, 22, 0.7)" stroke-width="1.2" />
                <!-- Radar beacon on stern -->
                <path d="M 480 145 L 488 100 L 498 100 L 506 145 Z" stroke="#eab308" stroke-width="1.2" fill="none" />
                <circle cx="493" cy="92" r="2.5" fill="#eab308" />
                <line x1="493" y1="100" x2="493" y2="92" stroke="#eab308" stroke-width="1.2" />
              </svg>
            </div>

          </div>
        </div>

        <!-- 2. DARK FORM CARD CONTAINER -->
        <div class="enquiry-card-wrapper">

          <!-- Interactive Form -->
          <form id="project-enquiry-form" class="enquiry-form" novalidate>

            <!-- SECTION 1: CONTACT DETAILS -->
            <div class="form-section-group">
              <div class="form-section-header">
                <div class="form-section-icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                  </svg>
                </div>
                <h3 class="form-section-title">CONTACT DETAILS</h3>
                <div class="form-section-divider"></div>
              </div>

              <div class="form-grid-row">
                <!-- Full Name -->
                <div class="form-group">
                  <label for="enquiry-name" class="form-label">Full Name <span class="req">*</span></label>
                  <input type="text" id="enquiry-name" name="name" class="form-input" placeholder="Enter your full name"
                    required autocomplete="name">
                </div>

                <!-- Company Name -->
                <div class="form-group">
                  <label for="enquiry-company" class="form-label">Company Name <span class="req">*</span></label>
                  <input type="text" id="enquiry-company" name="company" class="form-input"
                    placeholder="Enter your company name" required autocomplete="organization">
                </div>
              </div>

              <div class="form-grid-row">
                <!-- Email Address -->
                <div class="form-group">
                  <label for="enquiry-email" class="form-label">Email Address <span class="req">*</span></label>
                  <input type="email" id="enquiry-email" name="email" class="form-input"
                    placeholder="Enter your email address" required autocomplete="email">
                </div>

                <!-- Mobile Number with International Country Code Selector -->
                <div class="form-group">
                  <label for="enquiry-phone" class="form-label">Mobile Number <span class="req">*</span></label>
                  <div class="intl-phone-wrapper">

                    <!-- Country Selector Button -->
                    <button type="button" class="country-picker-btn" id="enquiry-country-btn" aria-haspopup="true"
                      aria-expanded="false" title="Select Country Code">
                      <span class="country-dial" id="selected-country-dial">+91</span>
                      <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9" />
                      </svg>
                    </button>

                    <!-- Hidden input for selected country dial code -->
                    <input type="hidden" name="country_code" id="enquiry-country-code" value="+91">

                    <!-- Phone Number Input -->
                    <input type="tel" id="enquiry-phone" name="phone" class="form-input phone-input"
                      placeholder="Enter mobile number" required autocomplete="tel-national">

                    <!-- Country Picker Dropdown Panel -->
                    <div class="country-dropdown-panel" id="enquiry-country-dropdown" role="listbox">
                      <div class="country-search-box">
                        <input type="text" id="country-search-input" placeholder="Search country or code..."
                          autocomplete="off">
                      </div>
                      <div class="country-options-list" id="country-options-list">
                        <!-- Populated by enquiry.js -->
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- SECTION 2: ENQUIRY DETAILS -->
            <div class="form-section-group">
              <div class="form-section-header">
                <div class="form-section-icon">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path
                      d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                    <line x1="12" y1="22.08" x2="12" y2="12" />
                  </svg>
                </div>
                <h3 class="form-section-title">ENQUIRY DETAILS</h3>
                <div class="form-section-divider"></div>
              </div>

              <div class="form-grid-row">
                <!-- Product / Solution Required -->
                <div class="form-group">
                  <label for="enquiry-product" class="form-label">Product / Solution Required <span
                      class="req">*</span></label>
                  <div class="custom-select-wrapper">
                    <select id="enquiry-product" name="product_required" class="form-select" required>
                      <option value="" disabled selected>Select product / solution</option>
                      <option value="Fire Resistant Doors">Fire Resistant Doors</option>
                      <option value="Wall Panels">Wall Panels</option>
                      <option value="Ceiling Panels">Ceiling Panels</option>
                      <option value="Wet Units / Toilet Modules">Wet Units / Toilet Modules</option>
                      <option value="Modular Cabins">Modular Cabins</option>
                      <option value="Complete Marine Accommodation System">Complete Marine Accommodation System</option>
                      <option value="Other">Other</option>
                    </select>
                    <div class="select-chevron">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9" />
                      </svg>
                    </div>
                  </div>
                </div>

                <!-- Project Type -->
                <div class="form-group">
                  <label for="enquiry-project-type" class="form-label">Project Type <span class="req">*</span></label>
                  <div class="custom-select-wrapper">
                    <select id="enquiry-project-type" name="project_type" class="form-select" required>
                      <option value="" disabled selected>Select project type</option>
                      <option value="Shipbuilding">Shipbuilding</option>
                      <option value="Naval / Defense Vessel">Naval / Defense Vessel</option>
                      <option value="Commercial Ship">Commercial Ship</option>
                      <option value="Passenger Vessel">Passenger Vessel</option>
                      <option value="Offshore Platform">Offshore Platform</option>
                      <option value="Oil & Gas Rig">Oil &amp; Gas Rig</option>
                      <option value="Offshore Substation">Offshore Substation</option>
                      <option value="Specialized / Other">Specialized / Other</option>
                    </select>
                    <div class="select-chevron">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Your Requirement -->
              <div class="form-group full-width" style="margin-top: 0.5rem;">
                <label for="enquiry-message" class="form-label">Your Requirement <span class="req">*</span></label>
                <textarea id="enquiry-message" name="message" class="form-textarea" rows="4"
                  placeholder="Tell us about your product requirement..." required></textarea>
              </div>
            </div>

            <!-- Form Status / Global Feedback -->
            <div id="enquiry-form-status" class="enquiry-status-msg" role="alert"></div>

            <!-- SUBMIT BUTTON -->
            <div class="form-submit-row">
              <button type="submit" class="btn-submit-enquiry" id="btn-submit-enquiry">
                <span>SUBMIT ENQUIRY</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
                  <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
              </button>
            </div>

          </form>

        </div>

        <!-- 3. BOTTOM 4 VALUE PROPOSITION BADGES -->
        <div class="enquiry-value-badges-grid">

          <!-- Badge 1: Quality Assured -->
          <div class="value-badge-card">
            <div class="value-badge-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#b5cf2b" stroke-width="1.8">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                <polyline points="9 12 11 14 15 10" />
              </svg>
            </div>
            <div class="value-badge-text">
              <h4 class="value-badge-title">Quality Assured</h4>
              <p class="value-badge-desc">International standards and certifications</p>
            </div>
          </div>

          <!-- Badge 2: Engineering Excellence -->
          <div class="value-badge-card">
            <div class="value-badge-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#b5cf2b" stroke-width="1.8">
                <circle cx="12" cy="12" r="3" />
                <path
                  d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
              </svg>
            </div>
            <div class="value-badge-text">
              <h4 class="value-badge-title">Engineering Excellence</h4>
              <p class="value-badge-desc">Custom solutions for complex requirements</p>
            </div>
          </div>

          <!-- Badge 3: Reliable Partner -->
          <div class="value-badge-card">
            <div class="value-badge-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#b5cf2b" stroke-width="1.8">
                <path d="M11 17a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-2z" />
                <path
                  d="M18 11h-2.5a1.5 1.5 0 0 0-1.5 1.5v3a1.5 1.5 0 0 0 1.5 1.5H18a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2z" />
                <path d="M6 11h2.5A1.5 1.5 0 0 1 10 12.5v3A1.5 1.5 0 0 1 8.5 17H6a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2z" />
                <path d="M8 11V7a4 4 0 0 1 8 0v4" />
              </svg>
            </div>
            <div class="value-badge-text">
              <h4 class="value-badge-title">Reliable Partner</h4>
              <p class="value-badge-desc">Committed to your project success</p>
            </div>
          </div>

          <!-- Badge 4: Global Experience -->
          <div class="value-badge-card">
            <div class="value-badge-icon">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#b5cf2b" stroke-width="1.8">
                <circle cx="12" cy="12" r="10" />
                <line x1="2" y1="12" x2="22" y2="12" />
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
              </svg>
            </div>
            <div class="value-badge-text">
              <h4 class="value-badge-title">Global Experience</h4>
              <p class="value-badge-desc">Serving clients across marine &amp; offshore industries</p>
            </div>
          </div>

        </div>

      </div>


</section>

     <?php
  include 'includes/footer.php';
  ?>
