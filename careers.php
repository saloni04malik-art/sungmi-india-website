<?php
require_once __DIR__ . '/admin/includes/db.php';
include 'includes/headerScript.php';
include 'includes/header.php';

/* ==========================================================================
   FETCH ACTIVE, NON-DELETED JOB ROLES FROM MYSQL
   ========================================================================== */
$rolesQuery = "SELECT id, title, department, location, employment_type, short_description, overview, responsibilities, qualifications, created_at
               FROM job_roles
               WHERE status = 1 AND is_deleted = 0
               ORDER BY id ASC";
$rolesResult = mysqli_query($conn, $rolesQuery);

$jobRoles = [];
if ($rolesResult) {
    while ($row = mysqli_fetch_assoc($rolesResult)) {
        $jobRoles[] = $row;
    }
}

/* Map default legacy slugs for migrated roles */
$slugMap = [
    1 => 'mechanical-production-engineer',
    2 => 'quality-production-engineer',
    3 => 'project-technical-coordinator'
];

/* Build dynamic dataset for client-side role modals */
$rolesForJs = [];
foreach ($jobRoles as $r) {
    $roleId = (int)$r['id'];
    $slug = $slugMap[$roleId] ?? ('role-' . $roleId);

    // Split responsibilities into array of lines
    $respArray = [];
    if (!empty($r['responsibilities'])) {
        $lines = preg_split('/\r\n|\r|\n/', trim($r['responsibilities']));
        foreach ($lines as $line) {
            $line = trim($line, " \t\n\r\0\x0B•-");
            if ($line !== '') {
                $respArray[] = $line;
            }
        }
    }

    // Split qualifications into array of lines
    $reqArray = [];
    if (!empty($r['qualifications'])) {
        $lines = preg_split('/\r\n|\r|\n/', trim($r['qualifications']));
        foreach ($lines as $line) {
            $line = trim($line, " \t\n\r\0\x0B•-");
            if ($line !== '') {
                $reqArray[] = $line;
            }
        }
    }

    $roleData = [
        'id'               => (string)$roleId,
        'slug'             => $slug,
        'title'            => $r['title'],
        'department'       => $r['department'],
        'location'         => $r['location'],
        'type'             => $r['employment_type'],
        'summary'          => $r['short_description'],
        'overview'         => $r['overview'],
        'responsibilities' => $respArray,
        'requirements'     => $reqArray
    ];

    $rolesForJs[$roleId] = $roleData;
    if (!empty($slug)) {
        $rolesForJs[$slug] = $roleData;
    }
}

function getRoleCardIcon($department, $title) {
    $search = strtolower($department . ' ' . $title);
    if (strpos($search, 'quality') !== false || strpos($search, 'manufactur') !== false) {
        return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 20h20"/><path d="M5 20V8l5 4V8l5 4V4h4v16"/></svg>';
    } elseif (strpos($search, 'project') !== false || strpos($search, 'coordinat') !== false) {
        return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>';
    } else {
        return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>';
    }
}
?>

    <!-- SECTION 09 — CAREERS AT SUNGMI -->
    <section class="careers-section site-section" id="careers" aria-label="Careers at Sungmi">

      <!-- 1. FULL-WIDTH NATURAL HERO BANNER (Edge-to-Edge, Seamless Blend) -->
      <div class="careers-hero-banner">
        <div class="careers-hero-gradient-overlay" aria-hidden="true"></div>
        <div class="careers-hero-bottom-fade" aria-hidden="true"></div>
        <div class="careers-hero-inner">
          <div class="careers-hero-content">
            <div class="careers-pretag-hero">
              <span>CAREERS AT SUNGMI</span>
            </div>
            <h2 class="careers-hero-headline">
              BUILD YOUR CAREER<br>WITH SUNGMI
            </h2>
            <p class="careers-hero-desc">
              Join a team working at the intersection of marine engineering,<br> manufacturing and innovative accommodation
              solutions.
            </p>
            <a href="#careers-openings" class="btn-careers-hero-cta" id="btn-careers-explore">
              <span>EXPLORE OPPORTUNITIES</span>
            </a>
          </div>
        </div>
      </div>

      <div class="careers-container">

        <!-- 2. WHY JOIN SUNGMI? -->
        <div class="careers-why-section">
          <div class="careers-center-header">
            <span class="careers-center-pretag">WHY JOIN SUNGMI?</span>
            <h3 class="careers-center-headline">A PLACE TO LEARN, GROW AND MAKE AN IMPACT</h3>
          </div>

          <div class="careers-why-grid">
            <!-- Card 1: Engineering Exposure -->
            <div class="why-template-card">
              <div class="why-circle-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="3" />
                  <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                </svg>
              </div>
              <h4 class="why-template-title">ENGINEERING EXPOSURE</h4>
              <p class="why-template-desc">
                Work on real-world marine and offshore engineering solutions that make a difference.
              </p>
            </div>

            <!-- Card 2: Learn & Grow -->
            <div class="why-template-card">
              <div class="why-circle-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                  <circle cx="9" cy="7" r="4" />
                  <polyline points="16 11 18 13 22 9" />
                </svg>
              </div>
              <h4 class="why-template-title">LEARN &amp; GROW</h4>
              <p class="why-template-desc">
                Develop practical knowledge across engineering, manufacturing and project environments.
              </p>
            </div>

            <!-- Card 3: Collaborative Culture -->
            <div class="why-template-card">
              <div class="why-circle-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                  <circle cx="9" cy="7" r="4" />
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                  <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
              </div>
              <h4 class="why-template-title">COLLABORATIVE CULTURE</h4>
              <p class="why-template-desc">
                Be part of a collaborative team that values respect, trust and shared success.
              </p>
            </div>

            <!-- Card 4: Meaningful Work -->
            <div class="why-template-card">
              <div class="why-circle-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10" />
                  <circle cx="12" cy="12" r="6" />
                  <circle cx="12" cy="12" r="2" />
                </svg>
              </div>
              <h4 class="why-template-title">MEANINGFUL WORK</h4>
              <p class="why-template-desc">
                Contribute to products and solutions used in demanding marine and offshore environments.
              </p>
            </div>
          </div>
        </div>

        <!-- 3. CURRENT OPENINGS (CRISP WHITE CONTAINER AS IN TEMPLATE) -->
        <div class="careers-openings-section" id="careers-openings">
          <span id="roles" style="position:relative; top:-90px; display:block; visibility:hidden;"></span>
          <div class="careers-center-header">
            <span class="careers-center-pretag">CURRENT OPENINGS</span>
            <h3 class="careers-center-headline">EXPLORE OPPORTUNITIES AT SUNGMI</h3>
          </div>

          <div class="openings-cards-list">

          <?php if (!empty($jobRoles)) { ?>
            <?php foreach ($jobRoles as $role) {
                $roleId = (int)$role['id'];
                $slug = $slugMap[$roleId] ?? ('role-' . $roleId);
            ?>
            <!-- Opening <?php echo $roleId; ?>: <?php echo htmlspecialchars($role['title']); ?> -->
            <div class="opening-row-card" id="opening-role-<?php echo $roleId; ?>">
              <div class="opening-card-left">
                <div class="opening-card-icon">
                  <?php echo getRoleCardIcon($role['department'], $role['title']); ?>
                </div>
                <div class="opening-card-info">
                  <h4 class="opening-card-title"><?php echo htmlspecialchars($role['title']); ?></h4>
                  <div class="opening-meta-row">
                    <span class="meta-item">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                      </svg>
                      <span><?php echo htmlspecialchars($role['department']); ?></span>
                    </span>
                    <span class="meta-divider">|</span>
                    <span class="meta-item">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                      </svg>
                      <span><?php echo htmlspecialchars($role['location']); ?></span>
                    </span>
                    <span class="meta-divider">|</span>
                    <span class="meta-item">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                      </svg>
                      <span><?php echo htmlspecialchars($role['employment_type']); ?></span>
                    </span>
                  </div>
                  <p class="opening-card-summary">
                    <?php echo htmlspecialchars($role['short_description']); ?>
                  </p>
                </div>
              </div>

              <button type="button" class="btn-view-role" data-role-id="<?php echo $roleId; ?>"
                onclick="window.openCareerRoleModal ? window.openCareerRoleModal('<?php echo $roleId; ?>') : null"
                aria-label="View details for <?php echo htmlspecialchars($role['title']); ?> role">
                <span>VIEW ROLE</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
              </button>
            </div>
            <?php } ?>
          <?php } else { ?>
            <p style="text-align: center; color: #94a3b8; padding: 2.5rem 0;">
              No open positions at this time. You are welcome to send us your CV using the button below.
            </p>
          <?php } ?>

          </div>

          <!-- Bottom Footer Action -->
          <div class="openings-footer-link">
            <button type="button" class="btn-dont-see-role btn-open-general-apply" id="btn-careers-send-cv"
              onclick="window.openCareerApplyModal ? window.openCareerApplyModal('General Career Application', 'general') : null">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 19V5M5 12l7-7 7 7" />
              </svg>
              <span>DON'T SEE A ROLE THAT FITS? SEND US YOUR CV</span>
            </button>
          </div>
        </div>

        <!-- 4. FINAL CTA STRIP -->
        <div class="careers-final-cta-wrapper">
          <div class="careers-cta-strip">
            <div class="careers-cta-left">
              <div class="careers-cta-icon-box">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                  <polyline points="22,6 12,13 2,6" />
                </svg>
              </div>
              <div class="careers-cta-info">
                <span class="careers-cta-pretag">READY TO GROW WITH SUNGMI?</span>
                <h3 class="careers-cta-headline">Let’s build the future together.</h3>
                <p class="careers-cta-subdesc">
                  Send us your CV and tell us how you can contribute to our team and our mission.
                </p>
              </div>
            </div>

            <button type="button" class="btn-careers-cta-submit btn-open-general-apply" id="btn-careers-submit-cv"
              onclick="window.openCareerApplyModal ? window.openCareerApplyModal('General Career Application', 'general') : null">
              <span>SUBMIT YOUR CV</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
                <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
            </button>
          </div>

          <div class="careers-security-note">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#84cc16" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            <span>Your information is secure and will only be used to respond to your application.</span>
          </div>
        </div>

      </div>
    </section>


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

      <form id="career-application-form" class="career-apply-form" novalidate enctype="multipart/form-data">
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

  <script>
    window.CAREER_ROLES_DATA = <?php echo json_encode($rolesForJs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
  </script>

<?php
include 'includes/footer.php';
?>
