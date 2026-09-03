/**
 * SUNGMI INDIA — Careers Section Interactive Controller
 * Handles Job Details Modal, Role Data, and Career Application Forms
 */

(function () {
  'use strict';

  // Static Roles Dataset (Easily extensible/replaceable with real openings)
  const CAREER_ROLES_DATA = {
    'mechanical-production-engineer': {
      id: 'mechanical-production-engineer',
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
      id: 'quality-production-engineer',
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
      id: 'project-technical-coordinator',
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
        const role = CAREER_ROLES_DATA[activeRoleId];
        closeRoleModal();
        openApplyModal(role ? role.title : 'General Application', activeRoleId);
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
    const role = CAREER_ROLES_DATA[roleId];
    if (!role) return;

    activeRoleId = roleId;

    document.getElementById('modal-role-title').textContent = role.title;
    document.getElementById('modal-role-dept').textContent = role.department;
    document.getElementById('modal-role-location').textContent = role.location;
    document.getElementById('modal-role-type').textContent = role.type;
    document.getElementById('modal-role-overview').textContent = role.overview;

    const respList = document.getElementById('modal-role-responsibilities');
    respList.innerHTML = role.responsibilities.map(item => `<li>${item}</li>`).join('');

    const reqList = document.getElementById('modal-role-requirements');
    reqList.innerHTML = role.requirements.map(item => `<li>${item}</li>`).join('');

    const roleModal = document.getElementById('career-role-modal');
    roleModal.classList.add('active');
    roleModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
  }

  function closeRoleModal() {
    const roleModal = document.getElementById('career-role-modal');
    if (!roleModal) return;
    roleModal.classList.remove('active');
    roleModal.setAttribute('aria-hidden', 'true');
    if (!document.getElementById('career-apply-modal')?.classList.contains('active')) {
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

    document.getElementById('apply-modal-subtitle').textContent = `Applying for: ${roleName}`;
    
    // Select option or set hidden field
    const interestSelect = document.getElementById('apply-area-interest');
    if (interestSelect) {
      if (roleId && roleId !== 'general') {
        const role = CAREER_ROLES_DATA[roleId];
        if (role) {
          interestSelect.value = role.department;
        }
      } else {
        interestSelect.value = 'General / Any';
      }
    }

    const statusBox = document.getElementById('apply-form-status');
    if (statusBox) {
      statusBox.style.display = 'none';
      statusBox.className = 'apply-status-msg';
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
     3. File Upload Simulation
     -------------------------------------------------------------------------- */
  function setupFileUpload() {
    const fileInput = document.getElementById('apply-cv-file');
    const dropZone = document.getElementById('apply-cv-dropzone');
    const fileNameDisplay = document.getElementById('apply-cv-filename');

    if (!fileInput || !dropZone) return;

    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const file = this.files[0];
        fileNameDisplay.textContent = `Attached: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
        fileNameDisplay.style.display = 'block';
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
        fileNameDisplay.textContent = `Attached: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
        fileNameDisplay.style.display = 'block';
      }
    });
  }

  /* --------------------------------------------------------------------------
     4. Form Submission Handler
     -------------------------------------------------------------------------- */
  function handleApplicationSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const statusBox = document.getElementById('apply-form-status');
    const submitBtn = form.querySelector('button[type="submit"]');

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>SUBMITTING...</span>';

    setTimeout(() => {
      submitBtn.disabled = false;
      submitBtn.innerHTML = '<span>SUBMIT APPLICATION</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>';

      statusBox.textContent = 'Thank you for your application. Our recruitment team will review your profile and contact you shortly.';
      statusBox.className = 'apply-status-msg success';
      statusBox.style.display = 'block';

      form.reset();
      const fileNameDisplay = document.getElementById('apply-cv-filename');
      if (fileNameDisplay) fileNameDisplay.style.display = 'none';

      setTimeout(() => {
        closeApplyModal();
      }, 3500);
    }, 1200);
  }

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCareers);
  } else {
    initCareers();
  }
})();
