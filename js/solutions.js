/**
 * SUNGMI INDIA - WHERE WE ENGINEER (APPLICATIONS SHOWCASE)
 * Interactive 60/40 showcase controller handling desktop hover,
 * mobile/touch selection, smooth cinematic transitions, and technical HUD updates.
 */

const APPLICATIONS_DATA = {
  '01': {
    tag: 'APPLICATION / 01',
    title: 'MARINE & NAVAL',
    sub: 'MARINE ACCOMMODATION SYSTEM',
    telemetry: 'SPEC: DEFENSE & NAVAL CLASS',
    desc: 'Marine accommodation systems for naval applications.'
  },
  '02': {
    tag: 'APPLICATION / 02',
    title: 'COMMERCIAL VESSELS',
    sub: 'COMMERCIAL ACCOMMODATION SYSTEM',
    telemetry: 'SPEC: CARGO & BULK CARRIER',
    desc: 'Engineered accommodation systems for commercial ships.'
  },
  '03': {
    tag: 'APPLICATION / 03',
    title: 'PASSENGER VESSELS',
    sub: 'PASSENGER ACCOMMODATION SYSTEM',
    telemetry: 'SPEC: CRUISE & HIGH SPEED CRAFT',
    desc: 'Accommodation solutions for passenger vessels.'
  },
  '04': {
    tag: 'APPLICATION / 04',
    title: 'TANKERS',
    sub: 'SPECIALIZED TANKER ACCOMMODATION',
    telemetry: 'SPEC: OIL, CHEMICAL & LNG CLASS',
    desc: 'Specialized accommodation applications for tanker environments.'
  },
  '05': {
    tag: 'APPLICATION / 05',
    title: 'OFFSHORE',
    sub: 'OFFSHORE STRUCTURE ACCOMMODATION',
    telemetry: 'SPEC: HVDC & SUB-STATIONS',
    desc: 'Accommodation systems for offshore platforms and structures.'
  },
  '06': {
    tag: 'APPLICATION / 06',
    title: 'OIL & GAS',
    sub: 'DEMANDING RIG ACCOMMODATION',
    telemetry: 'SPEC: SEMI-SUBMERSIBLE RIGS',
    desc: 'Solutions for demanding oil & gas and rig environments.'
  }
};

class ApplicationsShowcase {
  constructor() {
    this.currentAppId = '01';
    this.selectorItems = document.querySelectorAll('.app-selector-item');
    this.visualLayers = document.querySelectorAll('.visual-layer');
    
    this.techTag = document.getElementById('visual-tech-tag');
    this.techTitle = document.getElementById('visual-tech-title');
    this.techSub = document.getElementById('visual-tech-sub');
    this.telemetrySpec = document.getElementById('visual-telemetry-spec');
    
    this.init();
  }

  init() {
    if (!this.selectorItems.length || !this.visualLayers.length) return;

    this.selectorItems.forEach((item, index) => {
      const appId = item.getAttribute('data-app-id');

      // Desktop: Fast hover response
      item.addEventListener('mouseenter', () => {
        this.selectApplication(appId);
      });

      // Click & Touch interactions
      item.addEventListener('click', (e) => {
        e.preventDefault();
        this.selectApplication(appId);
      });

      // Keyboard navigation (Arrow keys, Enter, Space)
      item.addEventListener('keydown', (e) => {
        let nextIndex = index;
        if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
          e.preventDefault();
          nextIndex = (index + 1) % this.selectorItems.length;
          this.selectorItems[nextIndex].focus();
          this.selectApplication(this.selectorItems[nextIndex].getAttribute('data-app-id'));
        } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
          e.preventDefault();
          nextIndex = (index - 1 + this.selectorItems.length) % this.selectorItems.length;
          this.selectorItems[nextIndex].focus();
          this.selectApplication(this.selectorItems[nextIndex].getAttribute('data-app-id'));
        }
      });
    });
  }

  selectApplication(appId) {
    if (this.currentAppId === appId || !APPLICATIONS_DATA[appId]) return;

    this.currentAppId = appId;
    const data = APPLICATIONS_DATA[appId];

    // 1. Update Selector Items (Active highlight & ARIA state)
    this.selectorItems.forEach(item => {
      const isActive = item.getAttribute('data-app-id') === appId;
      item.classList.toggle('active', isActive);
      item.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });

    // 2. Smoothly Crossfade Visual Layers (0.65s transition)
    this.visualLayers.forEach(layer => {
      const isTarget = layer.getAttribute('data-app-id') === appId;
      layer.classList.toggle('active', isTarget);
    });

    // 3. Update Technical HUD Labels with subtle text fade
    this.updateHUD(data);
  }

  updateHUD(data) {
    const hudElements = [this.techTag, this.techTitle, this.techSub];

    hudElements.forEach(el => {
      if (el) el.style.opacity = '0.3';
    });

    setTimeout(() => {
      if (this.techTag) this.techTag.textContent = data.tag;
      if (this.techTitle) this.techTitle.textContent = data.title;
      if (this.techSub) this.techSub.textContent = data.sub;
      if (this.telemetrySpec) this.telemetrySpec.textContent = data.telemetry;

      hudElements.forEach(el => {
        if (el) el.style.opacity = '1';
      });
    }, 180);
  }
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    new ApplicationsShowcase();
  });
} else {
  new ApplicationsShowcase();
}
