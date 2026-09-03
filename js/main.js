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

  // 4. Navigation & Page Controller
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-menu .nav-link, .nav-menu .dropdown-link');

  // 2.5 Capabilities Dropdown Toggle
  const capDropdown = document.querySelector('.nav-item-dropdown');
  const capBtn = document.querySelector('.nav-link-dropdown') || document.getElementById('capabilitiesDropdownBtn');

  if (capBtn && capDropdown) {
    capBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      capDropdown.classList.toggle('open');
      const isOpen = capDropdown.classList.contains('open');
      capBtn.setAttribute('aria-expanded', isOpen);
    });

    // Close dropdown when clicking anywhere outside
    document.addEventListener('click', (e) => {
      if (!capDropdown.contains(e.target)) {
        capDropdown.classList.remove('open');
        capBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // 1. Detect current page name (e.g., "engineering.php", "careers.php", "index.php")
  const currentPath = window.location.pathname.split('/').pop() || 'index.php';
  const isHomePage = currentPath === 'index.php' || currentPath === '' || currentPath === 'index.html';

  // 2. Set active nav link based on current page
  document.querySelectorAll('.nav-menu .nav-link, .nav-menu .dropdown-link').forEach(link => {
    link.classList.remove('active');
    const href = link.getAttribute('href');

    if (href === currentPath || (isHomePage && (href === 'index.php' || href === '#hero'))) {
      link.classList.add('active');

      const parentDropdown = link.closest('.nav-item-dropdown');
      if (parentDropdown) {
        const parentBtn = parentDropdown.querySelector('.nav-link-dropdown');
        if (parentBtn) parentBtn.classList.add('active');
      }
    }
  });

  // 3. Handle page hash / SPA scroll only if on Home Page
  if (isHomePage) {
    const initialHash = window.location.hash;
    if (initialHash && initialHash !== '#hero') {
      const targetSec = document.querySelector(initialHash);
      if (targetSec) {
        setTimeout(() => targetSec.scrollIntoView({ behavior: 'smooth' }), 100);
      }
    }
  }

  // 4. In-page anchor link scrolling
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId && targetId !== '#' && targetId !== '#hero') {
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          e.preventDefault();
          const navOffset = 90;
          const elementPosition = targetEl.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - navOffset;
          window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
        }
      }
    });
  });

  // 5. Header Navigation Active ScrollSpy (active ONLY on full Home page)
  const updateNavActive = () => {
    if (!isHomePage) return;
    const scrollY = window.scrollY + 120;
    sections.forEach(section => {
      const sectionHeight = section.offsetHeight;
      const sectionTop = section.offsetTop;
      const sectionId = section.getAttribute('id');

      if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
        navLinks.forEach(link => {
          link.classList.remove('active');
          const href = link.getAttribute('href');
          if (href === `#${sectionId}` || (sectionId === 'hero' && href === 'index.php')) {
            link.classList.add('active');
          }
        });
      }
    });
  };

  if (isHomePage) {
    window.addEventListener('scroll', updateNavActive, { passive: true });
  }

  // 7. Integrated Superstructure Banner Carousel Controller
  const superSlides = document.querySelectorAll('.superstructure-slide');
  const prevBtn = document.getElementById('superstructure-prev');
  const nextBtn = document.getElementById('superstructure-next');

  // Preload all banner images immediately so they never lag or load weirdly
  [
    'assets/door.jpeg',
    'assets/wall.jpeg',
    'assets/ceiling.jpeg',
    'assets/wet-units.jpg',
    'assets/modular-cabins.jpg'
  ].forEach(src => {
    const preImg = new Image();
    preImg.src = src;
  });

  if (superSlides.length > 0 && prevBtn && nextBtn) {
    let currentSlide = 0;
    let prevSlide = -1;
    const totalSlides = superSlides.length;

    function showSlide(index) {
      if (superSlides.length === 0) return;
      const targetIndex = (index + totalSlides) % totalSlides;
      if (targetIndex === currentSlide) return;

      prevSlide = currentSlide;
      currentSlide = targetIndex;

      // Keep previous slide underneath so background NEVER flashes black
      superSlides.forEach((slide, i) => {
        if (i === currentSlide) {
          slide.classList.remove('prev-slide');
          slide.classList.add('active');
        } else if (i === prevSlide) {
          slide.classList.add('prev-slide');
          slide.classList.remove('active');
        } else {
          slide.classList.remove('active', 'prev-slide');
        }
      });

      setTimeout(() => {
        if (prevSlide >= 0 && superSlides[prevSlide] && prevSlide !== currentSlide) {
          superSlides[prevSlide].classList.remove('prev-slide');
        }
      }, 850);
    }

    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      showSlide(currentSlide - 1);
    });

    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      showSlide(currentSlide + 1);
    });

    // Auto-advance every 5.5s
    let autoInterval = setInterval(() => {
      showSlide(currentSlide + 1);
    }, 5500);

    const bannerCard = document.getElementById('superstructure-banner-card');
    if (bannerCard) {
      bannerCard.addEventListener('mouseenter', () => clearInterval(autoInterval));
      bannerCard.addEventListener('mouseleave', () => {
        clearInterval(autoInterval);
        autoInterval = setInterval(() => {
          showSlide(currentSlide + 1);
        }, 5500);
      });
    }
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initMainInteractions);
} else {
  initMainInteractions();
}

