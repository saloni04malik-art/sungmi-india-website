/**
 * SUNGMI INDIA - MAIN INTERACTION CONTROLLER
 * Handles header dynamics, telemetry HUD updates, CTA micro-interactions,
 * and navigation states.
 */

function initMainInteractions() {
  // 1. Header scroll effect
  const header = document.querySelector('.site-header');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }, { passive: true });

  // 2. Mobile Navigation Toggle
  const menuToggle = document.querySelector('.menu-toggle');
  const navMenu = document.querySelector('.nav-menu');

  if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
      navMenu.classList.toggle('open');
      const isOpen = navMenu.classList.contains('open');
      menuToggle.setAttribute('aria-expanded', isOpen);
      menuToggle.innerHTML = isOpen 
        ? `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`
        : `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>`;
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!navMenu.contains(e.target) && !menuToggle.contains(e.target) && navMenu.classList.contains('open')) {
        navMenu.classList.remove('open');
        menuToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // 3. Dynamic Real-time Telemetry updates (Subtle marine HUD effect)
  const coordsElement = document.getElementById('telemetry-coords');
  
  if (coordsElement) {
    let lat = 15.3991; // Approx Goa Marine Hub coordinates (India facility)
    let lng = 73.8115;
    
    setInterval(() => {
      const deltaLat = (Math.random() - 0.5) * 0.0004;
      const deltaLng = (Math.random() - 0.5) * 0.0004;
      lat += deltaLat;
      lng += deltaLng;
      coordsElement.textContent = `${lat.toFixed(4)}° N, ${lng.toFixed(4)}° E`;
    }, 2400);
  }

  // 4. Section Navigation & View Controller
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-menu .nav-link');
  const navMenuElement = document.querySelector('.nav-menu');
  const menuToggleBtn = document.querySelector('.menu-toggle');

  function showAllSections(scrollToTarget = '#hero') {
    document.body.classList.remove('single-section-mode');
    sections.forEach(sec => {
      sec.style.display = '';
    });
    
    // Update active nav link
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === scrollToTarget) {
        link.classList.add('active');
      }
    });

    const targetEl = document.querySelector(scrollToTarget);
    if (targetEl) {
      targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  }

  function showSingleSection(targetId) {
    const targetSection = document.querySelector(targetId);
    if (!targetSection) return;

    document.body.classList.add('single-section-mode');

    // Hide all sections except the chosen one
    sections.forEach(sec => {
      if (`#${sec.getAttribute('id')}` === targetId) {
        sec.style.display = 'block';
      } else {
        sec.style.display = 'none';
      }
    });

    // Update active nav link
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === targetId) {
        link.classList.add('active');
      }
    });

    // Scroll to top of that section
    window.scrollTo({ top: 0, behavior: 'instant' });
    targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function navigateTo(targetId) {
    if (!targetId || targetId === '#' || targetId === '#hero') {
      showAllSections('#hero');
      history.pushState(null, '', '#hero');
    } else {
      // Check if target is a top-level section
      const targetSection = document.querySelector(`section${targetId}`);
      if (targetSection) {
        showSingleSection(targetId);
        history.pushState(null, '', targetId);
      } else {
        // Internal page element (e.g., #step-01-facility)
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          const parentSec = targetEl.closest('section');
          if (parentSec && parentSec.style.display === 'none') {
            showSingleSection(`#${parentSec.getAttribute('id')}`);
          }
          const navOffset = 90;
          const elementPosition = targetEl.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - navOffset;
          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
          });
        }
      }
    }

    // Close mobile menu if open
    if (navMenuElement && navMenuElement.classList.contains('open')) {
      navMenuElement.classList.remove('open');
      if (menuToggleBtn) menuToggleBtn.setAttribute('aria-expanded', 'false');
    }
  }

  // Handle all anchor link clicks
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId) {
        // Bypass top-level navigation handler for internal journey step links to let engineering.js handle smoothly
        if (targetId.startsWith('#step-') || this.closest('.eng-progress-sidebar') || this.classList.contains('eng-nav-link')) {
          return;
        }
        e.preventDefault();
        navigateTo(targetId);
      }
    });
  });

  // Handle browser back/forward buttons
  window.addEventListener('popstate', () => {
    const hash = window.location.hash || '#hero';
    if (hash === '#hero' || hash === '') {
      showAllSections('#hero');
    } else {
      showSingleSection(hash);
    }
  });

  // Initialize on page load based on current hash
  const initialHash = window.location.hash;
  if (initialHash && initialHash !== '#hero') {
    showSingleSection(initialHash);
  } else {
    showAllSections('#hero');
  }

  // 5. Header Navigation Active ScrollSpy (active only when on full Home page)
  const updateNavActive = () => {
    if (document.body.classList.contains('single-section-mode')) return;
    const scrollY = window.scrollY + 120;
    sections.forEach(section => {
      const sectionHeight = section.offsetHeight;
      const sectionTop = section.offsetTop;
      const sectionId = section.getAttribute('id');
      
      if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
        navLinks.forEach(link => {
          link.classList.remove('active');
          const href = link.getAttribute('href');
          if (href === `#${sectionId}`) {
            link.classList.add('active');
          }
        });
      }
    });
  };

  window.addEventListener('scroll', updateNavActive, { passive: true });
  updateNavActive();

  // 6. Magnetic CTA Button micro-interaction
  const buttons = document.querySelectorAll('.btn-hero-action, .btn-cta-primary, .btn-cta-secondary');
  buttons.forEach(btn => {
    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      btn.style.transform = `translate(${x * 0.15}px, ${y * 0.15}px)`;
    });

    btn.addEventListener('mouseleave', () => {
      btn.style.transform = '';
    });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMainInteractions);
} else {
  initMainInteractions();
}
