/**
 * SUNGMI INDIA — Careers Section Interactive Controller
 * Handles Job Details Modal, Role Data, and Career Application Forms
 */

(function () {
  'use strict';

  // Dynamic Roles Dataset with Fallback
  const CAREER_ROLES_DATA = (typeof window !== 'undefined' && window.CAREER_ROLES_DATA && Object.keys(window.CAREER_ROLES_DATA).length > 0)
    ? window.CAREER_ROLES_DATA
    : {
    'mechanical-production-engineer': {
      id: '1',
      slug: 'mechanical-production-engineer',
      title: 'Mechanical / Production Engineer',
      department: 'Engineering',
      location: 'Goa, India',
      type: 'Full Time',
      summary: 'Work on the design, development and production of marine accommodation systems and related engineering solutions.',
      overview: 'As a Mechanical / Production Engineer at Sungmi India, you will contribute to the engineering design, technical drafting, and manufacturing integration of marine accommodation systems, fire-rated doors, and modular living quarters conforming to international classification standards.',
      responsibilities: [
        'Develop 2D fabrication drawings and 3D CAD/BIM models for marine accommodation packages.',
        'Coordinate with factory production teams to ensure manufacturing tolerances and weld specifications are met.',
        'Review technical specifications against SOLAS, IMO, and classification society requirements (IRS, ABS, DNV).',
        'Prepare bill of quantities (BOQ), material cut-lists, and production work instructions.'
      ],
      requirements: [
        'Bachelor\'s Degree or Diploma in Mechanical / Marine / Production Engineering.',
        'Proficiency in AutoCAD, SolidWorks, or marine CAD drafting software.',
        'Understanding of sheet metal fabrication, welding standards, and interior outfitting.',
        'Strong problem-solving skills and ability to work in multidisciplinary teams.'
      ]
    },
    'quality-production-engineer': {
      id: '2',
      slug: 'quality-production-engineer',
      title: 'Quality / Production Engineer',
      department: 'Manufacturing',
      location: 'Goa, India',
      type: 'Full Time',
      summary: 'Ensure product quality and manufacturing excellence through process control, inspection and continuous improvement.',
      overview: 'The Quality / Production Engineer is responsible for maintaining quality assurance standards across all manufacturing processes at our Goa facility, ensuring that every panel, fire door, and modular unit meets stringent marine classification benchmarks.',
      responsibilities: [
        'Conduct incoming, in-process, and final inspection of manufactured marine accommodation components.',
        'Maintain QA/QC documentation, dimensional inspection reports, and fire door certification records.',
        'Collaborate with classification society surveyors and third-party inspectors during formal audits.',
        'Drive root-cause analysis and continuous process improvement on the production floor.'
      ],
      requirements: [
        'Degree or Diploma in Mechanical, Industrial, or Production Engineering.',
        '2+ years of experience in QA/QC within sheet metal, marine manufacturing, or fabrication environments.',
        'Familiarity with ISO 9001 quality systems and marine test standards (IMO FTP Code).',
        'High attention to detail and precision measurement capabilities.'
      ]
    },
    'project-technical-coordinator': {
      id: '3',
      slug: 'project-technical-coordinator',
      title: 'Project / Technical Coordinator',
      department: 'Projects',
      location: 'Goa, India',
      type: 'Full Time',
      summary: 'Coordinate technical activities and project documentation to ensure smooth execution and timely delivery.',
      overview: 'The Project / Technical Coordinator acts as the central link between our engineering office, factory manufacturing, and shipyard installation sites, ensuring project milestones, technical approvals, and client deliverables are executed seamlessly.',
      responsibilities: [
        'Track project milestone schedules, drawing submission approvals, and material procurement timelines.',
        'Liaise between client technical teams, shipyard project managers, and internal engineering departments.',
        'Prepare technical submittals, variation logs, and delivery dispatch documentation.',
        'Support site supervisors during vessel accommodation installation and dockside trials.'
      ],
      requirements: [
        'Degree in Engineering, Naval Architecture, or Project Management discipline.',
        'Prior experience or strong interest in shipbuilding, offshore outfitting, or technical project coordination.',
        'Excellent written and verbal communication skills with client-facing professionalism.',
        'Proficiency in MS Project, Excel, and document control management.'
      ]
    }
  };

  let activeRoleId = null;
  let selectedRoleTitle = '';
  let selectedRoleId = null;

  function getRoleById(roleId) {
    if (!roleId) return null;
    const dataset = (typeof window !== 'undefined' && window.CAREER_ROLES_DATA && Object.keys(window.CAREER_ROLES_DATA).length > 0)
      ? window.CAREER_ROLES_DATA
      : CAREER_ROLES_DATA;

    if (dataset[roleId]) return dataset[roleId];
    return Object.values(dataset).find(r => String(r.id) === String(roleId) || (r.slug && r.slug === String(roleId)));
  }

  function initCareers() {
    setupRoleDetailsModal();
    setupApplicationModal();
    setupFileUpload();
  }

  /* --------------------------------------------------------------------------
     1. Role Details Modal
     -------------------------------------------------------------------------- */
  function setupRoleDetailsModal() {
    const roleModal = document.getElementById('career-role-modal');
    const closeBtn = document.getElementById('career-role-close');
    const backdrop = document.getElementById('career-role-backdrop');
    const viewRoleButtons = document.querySelectorAll('.btn-view-role');
    const applyFromRoleBtn = document.getElementById('btn-apply-from-role');

    if (!roleModal) return;

    viewRoleButtons.forEach(btn => {
      btn.addEventListener('click', function () {
        const roleId = this.getAttribute('data-role-id');
        openRoleModal(roleId);
      });
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', closeRoleModal);
    }
    if (backdrop) {
      backdrop.addEventListener('click', closeRoleModal);
    }

    if (applyFromRoleBtn) {
      applyFromRoleBtn.addEventListener('click', function () {
        const role = getRoleById(activeRoleId);
        closeRoleModal();
        openApplyModal(role ? role.title : 'General Application', role ? role.id : 'general');
      });
    }

    // Escape key listener
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        if (roleModal.classList.contains('active')) closeRoleModal();
        const applyModal = document.getElementById('career-apply-modal');
        if (applyModal && applyModal.classList.contains('active')) closeApplyModal();
      }
    });
  }

  function openRoleModal(roleId) {
    const role = getRoleById(roleId);
    if (!role) return;

    activeRoleId = role.id;

    const titleEl = document.getElementById('modal-role-title');
    const deptEl = document.getElementById('modal-role-dept');
    const locEl = document.getElementById('modal-role-location');
    const typeEl = document.getElementById('modal-role-type');
    const overviewEl = document.getElementById('modal-role-overview');
    const respList = document.getElementById('modal-role-responsibilities');
    const reqList = document.getElementById('modal-role-requirements');

    if (titleEl) titleEl.textContent = role.title;
    if (deptEl) deptEl.textContent = role.department;
    if (locEl) locEl.textContent = role.location;
    if (typeEl) typeEl.textContent = role.type;
    if (overviewEl) overviewEl.textContent = role.overview;

    if (respList) {
      if (Array.isArray(role.responsibilities) && role.responsibilities.length) {
        respList.innerHTML = role.responsibilities.map(item => `<li>${item}</li>`).join('');
      } else if (typeof role.responsibilities === 'string' && role.responsibilities.trim() !== '') {
        respList.innerHTML = role.responsibilities.split('\n').filter(Boolean).map(item => `<li>${item.trim()}</li>`).join('');
      } else {
        respList.innerHTML = '<li>Details will be shared during the interview process.</li>';
      }
    }
    if (reqList) {
      const requirements = role.requirements || role.qualifications;
      if (Array.isArray(requirements) && requirements.length) {
        reqList.innerHTML = requirements.map(item => `<li>${item}</li>`).join('');
      } else if (typeof requirements === 'string' && requirements.trim() !== '') {
        reqList.innerHTML = requirements.split('\n').filter(Boolean).map(item => `<li>${item.trim()}</li>`).join('');
      } else {
        reqList.innerHTML = '<li>Relevant engineering qualification and experience.</li>';
      }
    }

    const roleModal = document.getElementById('career-role-modal');
    if (roleModal) {
      roleModal.classList.add('active');
      roleModal.setAttribute('aria-hidden', 'false');
      document.body.classList.add('modal-open');
    }
  }

  function closeRoleModal() {
    const roleModal = document.getElementById('career-role-modal');
    if (!roleModal) return;
    roleModal.classList.remove('active');
    roleModal.setAttribute('aria-hidden', 'true');
    const applyModal = document.getElementById('career-apply-modal');
    if (!applyModal || !applyModal.classList.contains('active')) {
      document.body.classList.remove('modal-open');
    }
  }

  /* --------------------------------------------------------------------------
     2. Application Form Modal
     -------------------------------------------------------------------------- */
  function setupApplicationModal() {
    const applyModal = document.getElementById('career-apply-modal');
    const closeBtn = document.getElementById('career-apply-close');
    const backdrop = document.getElementById('career-apply-backdrop');
    const generalApplyButtons = document.querySelectorAll('#btn-careers-send-cv, #btn-careers-submit-cv, .btn-open-general-apply');
    const form = document.getElementById('career-application-form');

    if (!applyModal) return;

    generalApplyButtons.forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        openApplyModal('General Career Application', 'general');
      });
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', closeApplyModal);
    }
    if (backdrop) {
      backdrop.addEventListener('click', closeApplyModal);
    }

    if (form) {
      form.addEventListener('submit', handleApplicationSubmit);
    }
  }

  function openApplyModal(roleName, roleId) {
    const applyModal = document.getElementById('career-apply-modal');
    if (!applyModal) return;

    const isSpecific = (roleId && roleId !== 'general');
    const subtitleEl = document.getElementById('apply-modal-subtitle');
    if (subtitleEl) {
      subtitleEl.textContent = isSpecific
        ? `Applying for: ${roleName}`
        : 'Submit your details and CV below.';
    }

    selectedRoleTitle = isSpecific ? roleName : '';
    selectedRoleId = isSpecific ? roleId : null;

    const interestSelect = document.getElementById('apply-area-interest');
    if (interestSelect) {
      if (isSpecific) {
        const role = getRoleById(roleId);
        if (role && role.department) {
          let found = false;
          for (let opt of interestSelect.options) {
            if (opt.value.toLowerCase() === role.department.toLowerCase()) {
              opt.selected = true;
              found = true;
              break;
            }
          }
          if (!found) {
            const newOpt = new Option(role.department, role.department, true, true);
            interestSelect.add(newOpt);
          }
        }
      } else {
        interestSelect.value = 'General / Any';
      }
    }

    const statusBox = document.getElementById('apply-form-status');
    if (statusBox) {
      statusBox.style.display = 'none';
      statusBox.className = 'apply-status-msg';
      statusBox.textContent = '';
    }

    applyModal.classList.add('active');
    applyModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
  }

  function closeApplyModal() {
    const applyModal = document.getElementById('career-apply-modal');
    if (!applyModal) return;
    applyModal.classList.remove('active');
    applyModal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
  }

  /* --------------------------------------------------------------------------
     3. File Upload Simulation & Interaction
     -------------------------------------------------------------------------- */
  function setupFileUpload() {
    const fileInput = document.getElementById('apply-cv-file');
    const dropZone = document.getElementById('apply-cv-dropzone');
    const fileNameDisplay = document.getElementById('apply-cv-filename');

    if (!fileInput || !dropZone) return;

    dropZone.addEventListener('click', (e) => {
      if (e.target !== fileInput) {
        fileInput.click();
      }
    });

    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const file = this.files[0];
        if (fileNameDisplay) {
          fileNameDisplay.textContent = `Attached: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
          fileNameDisplay.style.display = 'block';
        }
      }
    });

    ['dragenter', 'dragover'].forEach(eventName => {
      dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.classList.add('drag-active');
      });
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-active');
      });
    });

    dropZone.addEventListener('drop', (e) => {
      if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        fileInput.files = e.dataTransfer.files;
        const file = e.dataTransfer.files[0];
        if (fileNameDisplay) {
          fileNameDisplay.textContent = `Attached: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
          fileNameDisplay.style.display = 'block';
        }
      }
    });
  }

  /* --------------------------------------------------------------------------
     4. Form Submission Handler
     -------------------------------------------------------------------------- */
  async function handleApplicationSubmit(e) {
    e.preventDefault();

    const form = e.target;
    const statusBox = document.getElementById('apply-form-status');
    const submitBtn = form.querySelector('button[type="submit"]');

    /* Browser validation */
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    /* Check CV */
    const fileInput = document.getElementById('apply-cv-file');
    if (!fileInput || !fileInput.files || !fileInput.files.length) {
      if (statusBox) {
        statusBox.textContent = 'Please upload your CV.';
        statusBox.className = 'apply-status-msg error';
        statusBox.style.display = 'block';
      }
      return;
    }

    /* Check CV size */
    const file = fileInput.files[0];
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
      if (statusBox) {
        statusBox.textContent = 'CV file size must not exceed 10MB.';
        statusBox.className = 'apply-status-msg error';
        statusBox.style.display = 'block';
      }
      return;
    }

    /* Disable submit button & loading state */
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span>SUBMITTING...</span>';
    }

    /* Create FormData */
    const formData = new FormData(form);

    /* Send selected role title and job_role_id */
    if (selectedRoleTitle && selectedRoleTitle !== '') {
      formData.append('role_title', selectedRoleTitle);
    }
    if (selectedRoleId && selectedRoleId !== 'general') {
      formData.append('job_role_id', selectedRoleId);
    }

    try {
      const response = await fetch('career_submit.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.success) {
        if (statusBox) {
          statusBox.textContent = result.message || 'Your application has been submitted successfully.';
          statusBox.className = 'apply-status-msg success';
          statusBox.style.display = 'block';
        }

        form.reset();
        selectedRoleTitle = '';
        selectedRoleId = null;

        const fileNameDisplay = document.getElementById('apply-cv-filename');
        if (fileNameDisplay) {
          fileNameDisplay.textContent = '';
          fileNameDisplay.style.display = 'none';
        }

        setTimeout(() => {
          closeApplyModal();
        }, 3500);

      } else {
        if (statusBox) {
          statusBox.textContent = result.message || 'Unable to submit application.';
          statusBox.className = 'apply-status-msg error';
          statusBox.style.display = 'block';
        }
      }

    } catch (err) {
      if (statusBox) {
        statusBox.textContent = 'A network error occurred. Please check your connection and try again.';
        statusBox.className = 'apply-status-msg error';
        statusBox.style.display = 'block';
      }
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
          <span>SUBMIT APPLICATION</span>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        `;
      }
    }
  }

  // Global exports
  window.openCareerRoleModal = openRoleModal;
  window.openCareerApplyModal = openApplyModal;
  window.closeCareerRoleModal = closeRoleModal;
  window.closeCareerApplyModal = closeApplyModal;

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCareers);
  } else {
    initCareers();
  }
})();