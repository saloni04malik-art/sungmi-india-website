/**
 * SUNGMI INDIA - ENGINEERING & MANUFACTURING JOURNEY CONTROLLER
 * Handles scroll-spy for the 5-step journey:
 * 01 Facility -> 02 Manufacturing -> 03 Testing -> 04 Type Approval -> 05 Certifications
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
    const link = item.querySelector('.eng-nav-link');
    if (link) {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = item.getAttribute('data-step');
        const targetEl = document.getElementById(targetId);
        if (targetEl) {
          const navOffset = 100;
          const elementPosition = targetEl.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - navOffset;
          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
          });
        }
      });
    }
  });

  // Certificate Modal Handlers
  certCards.forEach(card => {
    card.addEventListener('click', () => {
      const certKey = card.getAttribute('data-cert');
      const data = CERTIFICATES_DATA[certKey];
      if (!data || !certModal || !certModalBody) return;

      certModalBody.innerHTML = `
        <div style="border-bottom: 2px solid #002b49; padding-bottom: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
          <div>
            <div style="font-size: 1.6rem; font-weight: 900; color: #002b49; font-family: var(--font-heading);">ABS</div>
            <div style="font-size: 0.85rem; font-weight: 700; color: #475569; letter-spacing: 0.05em;">Confirmation of Product Type Approval</div>
          </div>
          <div style="background: #e0f2fe; color: #0369a1; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; font-family: var(--font-mono);">
            TYPE APPROVED
          </div>
        </div>

        <div style="margin-bottom: 1.25rem;">
          <div style="font-size: 0.75rem; color: #64748b; font-family: var(--font-mono);">MANUFACTURER</div>
          <div style="font-size: 1.05rem; font-weight: 800; color: #0f172a; font-family: var(--font-heading);">SUNGMI INDIA PRIVATE LIMITED</div>
          <div style="font-size: 0.82rem; color: #334155;">Plot No. I-10, Verna Industrial Estate, Verna, Salcete, Goa – 403722, India</div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1.25rem; margin-bottom: 1.5rem;">
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
            <div>
              <div style="font-size: 0.7rem; color: #64748b; font-family: var(--font-mono);">PRODUCT TYPE</div>
              <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">${data.type}</div>
            </div>
            <div>
              <div style="font-size: 0.7rem; color: #64748b; font-family: var(--font-mono);">CERTIFICATE NUMBER</div>
              <div style="font-weight: 700; color: #0369a1; font-family: var(--font-mono); font-size: 0.85rem;">${data.certNo}</div>
            </div>
            <div>
              <div style="font-size: 0.7rem; color: #64748b; font-family: var(--font-mono);">ISSUE DATE</div>
              <div style="font-weight: 600; color: #0f172a; font-size: 0.85rem;">${data.issueDate}</div>
            </div>
            <div>
              <div style="font-size: 0.7rem; color: #64748b; font-family: var(--font-mono);">EXPIRY DATE</div>
              <div style="font-weight: 600; color: #16a34a; font-size: 0.85rem;">${data.expiryDate} (Active)</div>
            </div>
          </div>

          <div style="margin-bottom: 0.75rem;">
            <div style="font-size: 0.7rem; color: #64748b; font-family: var(--font-mono);">RATINGS & CLASSIFICATION</div>
            <div style="font-weight: 700; color: #0f172a; font-size: 0.85rem;">${data.classRatings}</div>
          </div>

          <div>
            <div style="font-size: 0.7rem; color: #64748b; font-family: var(--font-mono);">DESCRIPTION & INTENDED SERVICE</div>
            <div style="font-size: 0.82rem; color: #334155; line-height: 1.5;">${data.desc}</div>
          </div>
        </div>

        <div style="font-size: 0.75rem; color: #64748b; line-height: 1.4; border-top: 1px dashed #cbd5e1; padding-top: 0.75rem;">
          <strong>ABS Standards Compliance:</strong> ${data.rules}
        </div>
      `;

      certModal.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  });

  const closeCertModal = () => {
    if (certModal) {
      certModal.classList.remove('open');
      document.body.style.overflow = '';
    }
  };

  if (certModalClose) certModalClose.addEventListener('click', closeCertModal);
  if (certModalBackdrop) certModalBackdrop.addEventListener('click', closeCertModal);
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeCertModal();
  });
});
