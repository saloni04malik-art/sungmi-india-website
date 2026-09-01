/**
 * SUNGMI INDIA - ENGINEERING & MANUFACTURING JOURNEY CONTROLLER
 * Handles scroll-spy for the 4-step journey:
 * 01 Facility -> 02 Manufacturing -> 03 Type Approval -> 04 Certifications
 * Also handles interactive certificate modal inspector.
 */

document.addEventListener('DOMContentLoaded', () => {
  const journeySection = document.getElementById('engineering');
  if (!journeySection) return;

  const navItems = document.querySelectorAll('.eng-nav-item');
  const stepCards = document.querySelectorAll('.eng-step-card');
  const certCards = document.querySelectorAll('.cert-card');
  const certModal = document.getElementById('cert-modal');
  const certModalBackdrop = document.getElementById('cert-modal-backdrop');
  const certModalClose = document.getElementById('cert-modal-close');
  const certModalBody = document.getElementById('cert-modal-body');

  // Certificate Data from Official PPT
  const CERTIFICATES_DATA = {
    doors: {
      type: 'FIRE RESISTANT DOORS',
      certNo: 'ABS-21-HG2087541-PDA',
      issueDate: '21 JUL 2021',
      expiryDate: '20 JUL 2026',
      classRatings: 'A-0, A-60, B-15, H-120 Class',
      desc: 'Single and Double leaf fire protection doors fitted with heavy marine hardware, acoustic damping core, and fire-resistant glazing for marine vessels and offshore platforms.',
      rules: '2021 Marine Vessel Rules 1-1-4/3.7, 1-1-A3, 1-1-A4; IMO FTP Code 2010 Annex 1, Part 3'
    },
    wall: {
      type: 'WALL PANELS (B-0 & B-15 CLASS)',
      certNo: 'ABS-21-HG2087542-PDA',
      issueDate: '21 JUL 2021',
      expiryDate: '20 JUL 2026',
      classRatings: 'B-0 (25mm / 50mm) & B-15 (50mm)',
      desc: 'Bulkhead lining and partition panels with rockwool insulation core, galvanized steel sheet casing with PVC film decorative finish for shipboard accommodation spaces.',
      rules: '2021 Marine Vessel Rules 1-1-4/3.7, 1-1-A3, 1-1-A4; IMO FTP Code 2010 Annex 1, Part 3'
    },
    ceiling: {
      type: 'CEILING PANELS (B-0 & B-15 CLASS)',
      certNo: 'ABS-21-HG2087543-PDA',
      issueDate: '21 JUL 2021',
      expiryDate: '20 JUL 2026',
      classRatings: 'B-0 (25mm / 40mm) & B-15 (50mm / 75mm)',
      desc: 'Continuous and acoustic suspended ceiling panel systems integrated with marine lighting fixtures, air diffusers, and sprinkler penetrations.',
      rules: '2021 Marine Vessel Rules 1-1-4/3.7, 1-1-A3, 1-1-A4; IMO FTP Code 2010 Annex 1, Part 3'
    }
  };

  // Accurate ScrollSpy for Journey Progress
  const updateScrollSpy = () => {
    const triggerY = window.innerHeight * 0.45;
    let currentId = null;

    stepCards.forEach((card) => {
      const rect = card.getBoundingClientRect();
      if (rect.top <= triggerY && rect.bottom >= triggerY) {
        currentId = card.getAttribute('id');
      }
    });

    // Fallback to closest top card if above or below
    if (!currentId && stepCards.length > 0) {
      const firstRect = stepCards[0].getBoundingClientRect();
      const lastRect = stepCards[stepCards.length - 1].getBoundingClientRect();
      if (firstRect.top > triggerY) {
        currentId = stepCards[0].getAttribute('id');
      } else if (lastRect.bottom < triggerY) {
        currentId = stepCards[stepCards.length - 1].getAttribute('id');
      }
    }

    if (currentId) {
      stepCards.forEach(c => c.classList.remove('active-step'));
      const activeCard = document.getElementById(currentId);
      if (activeCard) activeCard.classList.add('active-step');

      navItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('data-step') === currentId) {
          item.classList.add('active');
        }
      });
    }
  };

  window.addEventListener('scroll', updateScrollSpy, { passive: true });
  window.addEventListener('resize', updateScrollSpy, { passive: true });
  updateScrollSpy();

  // Smooth Scroll on Nav Click with proper top header offset
  navItems.forEach(item => {
    const scrollToStep = (e) => {
      e.preventDefault();
      e.stopPropagation();
      const targetId = item.getAttribute('data-step');
      const targetEl = document.getElementById(targetId);
      if (targetEl) {
        // Ensure engineering section is visible if single-section mode is active
        const engSection = document.getElementById('engineering');
        if (engSection && engSection.style.display === 'none') {
          engSection.style.display = 'block';
        }

        const navOffset = 90;
        const elementPosition = targetEl.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - navOffset;
        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });

        // Set active states immediately
        navItems.forEach(ni => ni.classList.remove('active'));
        item.classList.add('active');
        stepCards.forEach(sc => sc.classList.remove('active-step'));
        targetEl.classList.add('active-step');
      }
    };

    item.addEventListener('click', scrollToStep);
  });

  // Certificate Lightbox Modal Handlers
  const certCardItems = document.querySelectorAll('.cert-card-item');
  const certModalTitle = document.getElementById('cert-modal-title');
  const certModalImg = document.getElementById('cert-modal-img');
  const certModalCloseBtn = document.getElementById('btn-cert-modal-close-action');

  const openCertModal = (card) => {
    if (!certModal) return;
    const title = card.getAttribute('data-cert-title') || 'Type Approval Certificate';
    const imgSrc = card.getAttribute('data-cert-img') || 'assets/cert_1.png';

    if (certModalTitle) certModalTitle.textContent = title;
    if (certModalImg) {
      certModalImg.src = imgSrc;
      certModalImg.alt = title;
    }

    certModal.classList.add('open');
    certModal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  };

  certCardItems.forEach(card => {
    card.addEventListener('click', (e) => {
      openCertModal(card);
    });

    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openCertModal(card);
      }
    });
  });

  const closeCertModal = () => {
    if (certModal) {
      certModal.classList.remove('open');
      certModal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }
  };

  if (certModalClose) certModalClose.addEventListener('click', closeCertModal);
  if (certModalCloseBtn) certModalCloseBtn.addEventListener('click', closeCertModal);
  if (certModalBackdrop) certModalBackdrop.addEventListener('click', closeCertModal);

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && certModal && certModal.classList.contains('open')) {
      closeCertModal();
    }
  });
});
