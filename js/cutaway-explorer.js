/**
 * SUNGMI INDIA - VESSEL ACCOMMODATION CUTAWAY EXPLORER
 * Synchronizes interactive numbered hotspots on the 3D ship cutaway
 * with the component list and handles seamless technical spec navigation.
 */

document.addEventListener('DOMContentLoaded', () => {
  const explorerSection = document.getElementById('accommodation-explorer');
  if (!explorerSection) return;

  const cutawayItems = explorerSection.querySelectorAll('.cutaway-item');
  const cutawayHotspots = explorerSection.querySelectorAll('.cutaway-hotspot');
  const specLinks = explorerSection.querySelectorAll('.cutaway-spec-link');

  let activeId = '01';

  // Activate specific component & hotspot
  const setActiveComponent = (id) => {
    if (!id) return;
    activeId = id;

    // Update List Items
    cutawayItems.forEach((item) => {
      const isMatch = item.getAttribute('data-cutaway-id') === id;
      item.classList.toggle('active', isMatch);
      item.setAttribute('aria-selected', isMatch ? 'true' : 'false');
    });

    // Update Hotspots
    cutawayHotspots.forEach((spot) => {
      const isMatch = spot.getAttribute('data-hotspot-id') === id;
      spot.classList.toggle('active', isMatch);
    });
  };

  // Hover & Click on List Items
  cutawayItems.forEach((item) => {
    const id = item.getAttribute('data-cutaway-id');

    item.addEventListener('mouseenter', () => {
      setActiveComponent(id);
    });

    item.addEventListener('click', (e) => {
      // Don't prevent default if clicking the spec link
      if (e.target.closest('.cutaway-spec-link')) return;
      setActiveComponent(id);
    });

    item.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        setActiveComponent(id);
      }
    });
  });

  // Click & Hover on Hotspots
  cutawayHotspots.forEach((spot) => {
    const id = spot.getAttribute('data-hotspot-id');

    spot.addEventListener('mouseenter', () => {
      setActiveComponent(id);
    });

    spot.addEventListener('click', (e) => {
      e.preventDefault();
      setActiveComponent(id);
    });
  });

  // Handle "VIEW TECHNICAL SPECS ->" Navigation
  specLinks.forEach((link) => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetProductId = link.getAttribute('data-scroll-target');
      const productsSection = document.getElementById('products');

      if (productsSection) {
        const headerOffset = 90;
        const targetCard = productsSection.querySelector(`.product-card[data-product-id="${targetProductId}"]`);

        let targetPosition = productsSection.getBoundingClientRect().top + window.pageYOffset - headerOffset;
        if (targetCard) {
          targetPosition = targetCard.getBoundingClientRect().top + window.pageYOffset - headerOffset - 20;
        }

        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });

        // Flash highlight on the target product card
        if (targetCard) {
          targetCard.classList.remove('product-highlight-flash');
          void targetCard.offsetWidth; // Trigger reflow
          targetCard.classList.add('product-highlight-flash');
          setTimeout(() => {
            targetCard.classList.remove('product-highlight-flash');
          }, 2400);
        }
      }
    });
  });
});
