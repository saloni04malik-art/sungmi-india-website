/**
 * SUNGMI INDIA - 360° TECHNICAL PRODUCT INSPECTOR
 * Fullscreen Interactive 3D Viewer with Three.js
 * Supports 360 drag rotation, zoom in/out, reset view, auto-rotate, wireframe toggle,
 * and dynamic technical specs drawer.
 */

const PRODUCTS_DATA_360 = {
  door: {
    tag: '01 — MARINE PRODUCT INSPECTION',
    title: '01 — FIRE RESISTANT DOORS',
    specs: [
      { label: 'FIRE RATING', value: 'A-0, A-60, B-15, H-120 Class' },
      { label: 'WATER / WEATHER TIGHT', value: 'A-60 Marine Grade Gasket' },
      { label: 'CORE MATERIAL', value: 'High-density Ceramic / Mineral Wool' },
      { label: 'HARDWARE', value: 'Marine Grade 316 Stainless Steel' },
      { label: 'SOUND REDUCTION', value: 'Up to 44 dB Acoustic Damping' },
      { label: 'APPROVALS', value: 'ABS, MED, SOLAS / IMO Compliant' }
    ]
  },
  wall: {
    tag: '02 — MARINE PRODUCT INSPECTION',
    title: '02 — WALL PANELS',
    specs: [
      { label: 'FIRE CLASSIFICATION', value: 'B-0 & B-15 Class' },
      { label: 'THICKNESS OPTIONS', value: '25mm & 50mm Standard' },
      { label: 'JOINT PROFILES', value: 'Spline, Insert & C-Clip Systems' },
      { label: 'CORE COMPOSITION', value: 'Acoustic Rockwool Insulation' },
      { label: 'SURFACE FINISH', value: 'PVC Laminated / Galvanized Steel' },
      { label: 'APPLICATIONS', value: 'Accommodations, Passageways, Mess' }
    ]
  },
  ceiling: {
    tag: '03 — MARINE PRODUCT INSPECTION',
    title: '03 — CEILING PANELS',
    specs: [
      { label: 'FIRE RATING', value: 'B-0 (25/40mm) & B-15 (50/75mm)' },
      { label: 'CONSTRUCTION', value: 'Lightweight Composite / Micro-perforated' },
      { label: 'SUSPENSION', value: 'Integrated T-Carrier Grid & Spring Hangers' },
      { label: 'SERVICES INTEGRATION', value: 'Lighting, HVAC Diffusers, Sprinklers' },
      { label: 'SURFACE COATING', value: 'Polyester Powder Coated Marine Alloy' },
      { label: 'CERTIFICATION', value: 'Classification Society Type Approved' }
    ]
  },
  wetunit: {
    tag: '04 — MARINE PRODUCT INSPECTION',
    title: '04 — MARINE WET UNITS',
    specs: [
      { label: 'MODULE TYPE', value: 'Fully Pre-fitted Bathroom Pod' },
      { label: 'CONFIGURATIONS', value: 'Shower + WC / WC-Only Variant' },
      { label: 'ASSEMBLY', value: 'Land-assembled Turnkey Unit' },
      { label: 'PLUMBING & FIXTURES', value: 'Corrosion-Resistant Stainless / Chrome' },
      { label: 'BASE TRAY', value: 'Integrated Waterproof Composite Tray' },
      { label: 'CUSTOMIZATION', value: 'Tailored per Shipowner Requirements' }
    ]
  },
  cabin: {
    tag: '05 — MARINE PRODUCT INSPECTION',
    title: '05 — MODULAR CABINS',
    specs: [
      { label: 'STRUCTURE', value: 'Turnkey Living Quarters Module' },
      { label: 'APPLICATIONS', value: 'Naval, Commercial & Civil Marine' },
      { label: 'FIT-OUT SCOPE', value: 'Panels, Ceiling, WC Pod, Furniture' },
      { label: 'EFFICIENCY GAIN', value: 'Reduces Shipyard Fit-out by ~40-60%' },
      { label: 'INSULATION', value: 'High Thermal & Sound Damping' },
      { label: 'VESSEL TYPES', value: 'Naval, Tankers, Rigs, Offshore Platforms' }
    ]
  }
};

class ProductInspector360 {
  constructor() {
    this.modal = document.getElementById('modal-360-viewer');
    this.backdrop = document.getElementById('modal-360-backdrop');
    this.closeBtn = document.getElementById('btn-close-360');
    this.canvas = document.getElementById('canvas-360-product');
    this.viewport = document.getElementById('modal-360-viewport');
    
    this.modalTag = document.getElementById('modal-360-tag');
    this.modalTitle = document.getElementById('modal-360-title');
    this.specsContent = document.getElementById('viewer-specs-content');
    
    this.resetBtn = document.getElementById('btn-reset-view');
    this.autoRotateBtn = document.getElementById('btn-auto-rotate');
    this.rotateBtnText = document.getElementById('rotate-btn-text');
    this.wireframeBtn = document.getElementById('btn-toggle-wireframe');
    this.fullscreenBtn = document.getElementById('btn-toggle-fullscreen');
    this.zoomInBtn = document.getElementById('btn-zoom-in');
    this.zoomOutBtn = document.getElementById('btn-zoom-out');
    this.zoomText = document.getElementById('zoom-level-text');
    this.angleHUD = document.getElementById('rotation-angle-hud');
    this.compassNeedle = document.getElementById('viewer-compass-needle');
    
    this.currentProductId = 'door';
    this.isAutoRotating = true;
    this.isWireframe = false;
    this.zoomLevel = 1.0;
    this.isDragging = false;
    this.prevMousePos = { x: 0, y: 0 };
    
    this.scene = null;
    this.camera = null;
    this.renderer = null;
    this.productGroup = null;
    this.animId = null;
    
    this.init();
  }

  init() {
    // Attach click events on all 360 buttons
    document.querySelectorAll('[data-open-360]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const prodId = btn.getAttribute('data-open-360');
        this.open(prodId);
      });
    });

    // Close events
    if (this.closeBtn) this.closeBtn.addEventListener('click', () => this.close());
    if (this.backdrop) this.backdrop.addEventListener('click', () => this.close());

    // ESC key close
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.modal && this.modal.classList.contains('open')) {
        this.close();
      }
    });

    // Controls
    if (this.resetBtn) {
      this.resetBtn.addEventListener('click', () => this.resetView());
    }

    if (this.autoRotateBtn) {
      this.autoRotateBtn.addEventListener('click', () => this.toggleAutoRotate());
    }

    if (this.wireframeBtn) {
      this.wireframeBtn.addEventListener('click', () => this.toggleWireframe());
    }

    if (this.fullscreenBtn) {
      this.fullscreenBtn.addEventListener('click', () => this.toggleFullscreen());
    }

    if (this.zoomInBtn) {
      this.zoomInBtn.addEventListener('click', () => this.adjustZoom(0.15));
    }

    if (this.zoomOutBtn) {
      this.zoomOutBtn.addEventListener('click', () => this.adjustZoom(-0.15));
    }

    // Drag interaction on viewport
    if (this.viewport) {
      this.viewport.addEventListener('mousedown', (e) => this.onMouseDown(e));
      window.addEventListener('mousemove', (e) => this.onMouseMove(e));
      window.addEventListener('mouseup', () => this.onMouseUp());

      // Touch interactions
      this.viewport.addEventListener('touchstart', (e) => this.onTouchStart(e), { passive: false });
      window.addEventListener('touchmove', (e) => this.onTouchMove(e), { passive: false });
      window.addEventListener('touchend', () => this.onMouseUp());

      // Wheel Zoom
      this.viewport.addEventListener('wheel', (e) => {
        e.preventDefault();
        this.adjustZoom(e.deltaY > 0 ? -0.1 : 0.1);
      }, { passive: false });
    }

    // Window resize
    window.addEventListener('resize', () => {
      if (this.modal && this.modal.classList.contains('open')) {
        this.onResize();
      }
    });
  }

  initThree() {
    if (this.renderer) return; // already initialized

    const width = this.viewport.clientWidth;
    const height = this.viewport.clientHeight;

    this.scene = new THREE.Scene();
    this.camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    this.camera.position.set(0, 0, 4.4);

    this.renderer = new THREE.WebGLRenderer({
      canvas: this.canvas,
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance'
    });
    this.renderer.setSize(width, height);
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    this.renderer.shadowMap.enabled = true;
    this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;

    // Lighting Setup for 360 Visibility (Studio Balanced, Soft Diffusion)
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.65);
    this.scene.add(ambientLight);

    // Front Main & Fill Lights (Warm Key + Soft Fill)
    const frontLight = new THREE.DirectionalLight(0xfff6ea, 0.85);
    frontLight.position.set(4, 7, 6);
    this.scene.add(frontLight);

    const frontFill = new THREE.DirectionalLight(0xdbe4f0, 0.45);
    frontFill.position.set(-5, 3, 5);
    this.scene.add(frontFill);

    // Back Main & Fill Lights
    const backLight = new THREE.DirectionalLight(0xfff6ea, 0.75);
    backLight.position.set(-4, 7, -6);
    this.scene.add(backLight);

    const backFill = new THREE.DirectionalLight(0xdbe4f0, 0.35);
    backFill.position.set(5, 3, -5);
    this.scene.add(backFill);

    // Overhead Rim Light
    const topLight = new THREE.DirectionalLight(0xffffff, 0.35);
    topLight.position.set(0, 8, 0);
    this.scene.add(topLight);

    this.productGroup = new THREE.Group();
    this.scene.add(this.productGroup);
  }

  open(productId) {
    this.currentProductId = productId;
    const data = PRODUCTS_DATA_360[productId];
    if (!data) return;

    // Update Header & Specs
    if (this.modalTag) this.modalTag.textContent = data.tag;
    if (this.modalTitle) this.modalTitle.textContent = data.title;

    if (this.specsContent) {
      this.specsContent.innerHTML = data.specs.map(s => `
        <div class="drawer-spec-item">
          <span class="drawer-spec-label">${s.label}</span>
          <span class="drawer-spec-value">${s.value}</span>
        </div>
      `).join('');
    }

    // Show modal
    this.modal.classList.add('open');
    this.modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    // Init 3D Scene immediately and adjust for animation completion
    this.initThree();
    this.buildProductModel(productId);
    this.resetView();
    this.onResize();

    if (this.animId) cancelAnimationFrame(this.animId);
    this.animate();

    setTimeout(() => {
      this.onResize();
    }, 150);

    setTimeout(() => {
      this.onResize();
    }, 380);
  }

  close() {
    if (!this.modal) return;
    this.modal.classList.remove('open');
    this.modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (this.animId) cancelAnimationFrame(this.animId);
  }

  disposeObject(obj) {
    if (!obj) return;
    if (obj.children && obj.children.length > 0) {
      for (let i = obj.children.length - 1; i >= 0; i--) {
        this.disposeObject(obj.children[i]);
      }
    }
    if (obj.geometry) obj.geometry.dispose();
    if (obj.material) {
      if (Array.isArray(obj.material)) {
        obj.material.forEach(m => {
          if (m.map) m.map.dispose();
          m.dispose();
        });
      } else {
        if (obj.material.map) obj.material.map.dispose();
        obj.material.dispose();
      }
    }
  }

  createBlueDoorTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 1024;
    canvas.height = 2048;
    const ctx = canvas.getContext('2d');

    // Base Marine Blue (Matching photo reference: #2b4f7c)
    ctx.fillStyle = '#2b4f7c';
    ctx.fillRect(0, 0, 1024, 2048);

    // Subtle brushed lighting gradient
    const grad = ctx.createLinearGradient(0, 0, 1024, 2048);
    grad.addColorStop(0, 'rgba(255,255,255,0.06)');
    grad.addColorStop(0.5, 'rgba(0,0,0,0)');
    grad.addColorStop(1, 'rgba(0,0,0,0.12)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, 1024, 2048);

    // Outer edge seam line
    ctx.strokeStyle = '#1d395a';
    ctx.lineWidth = 6;
    ctx.strokeRect(8, 8, 1008, 2032);

    // 1. Digital Access Keypad (Left side)
    ctx.fillStyle = '#d1d5db';
    if (ctx.roundRect) {
      ctx.beginPath();
      ctx.roundRect(70, 840, 64, 150, 6);
      ctx.fill();
    } else {
      ctx.fillRect(70, 840, 64, 150);
    }
    ctx.fillStyle = '#1e293b';
    ctx.fillRect(76, 856, 52, 122);
    // Keypad numbers grid
    ctx.fillStyle = '#ffffff';
    for (let r = 0; r < 4; r++) {
      for (let c = 0; c < 3; c++) {
        ctx.fillRect(82 + c * 15, 866 + r * 25, 9, 14);
      }
    }
    // Keypad Status LED
    ctx.fillStyle = '#22c55e';
    ctx.beginPath();
    ctx.arc(102, 848, 3.5, 0, Math.PI * 2);
    ctx.fill();

    // 2. Bottom Left Escape Hatch (Matching photo)
    ctx.fillStyle = '#244369';
    ctx.fillRect(70, 1720, 220, 220);
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = 12;
    ctx.strokeRect(70, 1720, 220, 220);
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 3;
    ctx.strokeRect(82, 1732, 196, 196);
    // Hatch Latch Bolt & Brass Barrel
    ctx.fillStyle = '#cbd5e1';
    ctx.fillRect(280, 1795, 14, 60);
    ctx.fillStyle = '#d97706';
    ctx.fillRect(276, 1815, 8, 24);

    const texture = new THREE.CanvasTexture(canvas);
    texture.anisotropy = 8;
    return texture;
  }

  createYellowDoorTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 1024;
    canvas.height = 2048;
    const ctx = canvas.getContext('2d');

    // Base Golden Safety Yellow (Matching photo reference: #f1b81e)
    ctx.fillStyle = '#f1b81e';
    ctx.fillRect(0, 0, 1024, 2048);

    // Subtle brushed lighting gradient
    const grad = ctx.createLinearGradient(0, 0, 1024, 2048);
    grad.addColorStop(0, 'rgba(255,255,255,0.08)');
    grad.addColorStop(0.5, 'rgba(0,0,0,0)');
    grad.addColorStop(1, 'rgba(0,0,0,0.10)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, 1024, 2048);

    // Outer edge border
    ctx.strokeStyle = '#d49b00';
    ctx.lineWidth = 6;
    ctx.strokeRect(8, 8, 1008, 2032);

    // Specification Placard Plate (Right of canvas -> maps to left of yellow door!)
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(520, 770, 430, 265);
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 3;
    ctx.strokeRect(520, 770, 430, 265);

    // Blue header bar
    ctx.fillStyle = '#1e40af';
    ctx.fillRect(520, 770, 430, 52);
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 15px "Segoe UI", Arial, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('B-15 CLASS FIRE RETARDING HINGED DOOR', 735, 792);
    ctx.font = 'bold 11px "Segoe UI", Arial, sans-serif';
    ctx.fillStyle = '#bfdbfe';
    ctx.fillText('FOR PUBLIC SPACE  |  SM-615-10', 735, 810);

    // Placard table text
    ctx.textAlign = 'left';
    const specs = [
      ['Core Material', 'Ceramic Wool / Rockwool'],
      ['Skin Plate', '1.2mm Galvanized Steel'],
      ['Door Thickness', '40mm Certified Core'],
      ['Sound Damping', '38 dB Acoustic Isolation'],
      ['Fire Rating', 'B-15 Class SOLAS / IMO'],
      ['Approvals', 'ABS / MED / DNV Certified']
    ];
    specs.forEach((item, i) => {
      const y = 844 + i * 29;
      if (i % 2 === 0) {
        ctx.fillStyle = '#f1f5f9';
        ctx.fillRect(526, y - 15, 418, 25);
      }
      ctx.fillStyle = '#0f172a';
      ctx.font = 'bold 12px "Segoe UI", Arial, sans-serif';
      ctx.fillText(item[0] + ':', 534, y + 2);
      ctx.fillStyle = '#334155';
      ctx.font = '12px "Segoe UI", Arial, sans-serif';
      ctx.fillText(item[1], 648, y + 2);
    });

    // 4 Corner Screws for Placard
    ctx.fillStyle = '#64748b';
    [[530, 780], [940, 780], [530, 1024], [940, 1024]].forEach(([cx, cy]) => {
      ctx.beginPath();
      ctx.arc(cx, cy, 4, 0, Math.PI * 2);
      ctx.fill();
    });

    const texture = new THREE.CanvasTexture(canvas);
    texture.anisotropy = 8;
    return texture;
  }

  createBlueTileTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const ctx = canvas.getContext('2d');

    // Royal Blue Marine Ceramic Tile Base (Matching photo: #1a4fa0)
    ctx.fillStyle = '#1a4fa0';
    ctx.fillRect(0, 0, 512, 512);

    const tileSize = 32;
    const grout = 2.5;

    for (let x = 0; x < 512; x += tileSize) {
      for (let y = 0; y < 512; y += tileSize) {
        // Individual tile gloss gradient
        const grad = ctx.createLinearGradient(x, y, x + tileSize, y + tileSize);
        grad.addColorStop(0, '#2563eb');
        grad.addColorStop(0.4, '#1d4ed8');
        grad.addColorStop(1, '#1e3a8a');
        ctx.fillStyle = grad;
        ctx.fillRect(x + grout, y + grout, tileSize - grout * 2, tileSize - grout * 2);
      }
    }

    // Crisp white grout grid lines
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = grout;
    for (let x = 0; x <= 512; x += tileSize) {
      ctx.beginPath();
      ctx.moveTo(x, 0);
      ctx.lineTo(x, 512);
      ctx.stroke();
    }
    for (let y = 0; y <= 512; y += tileSize) {
      ctx.beginPath();
      ctx.moveTo(0, y);
      ctx.lineTo(512, y);
      ctx.stroke();
    }

    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.RepeatWrapping;
    texture.repeat.set(2, 2);
    texture.anisotropy = 8;
    return texture;
  }

  createDrainGrateTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 128;
    canvas.height = 128;
    const ctx = canvas.getContext('2d');

    // Stainless steel face
    ctx.fillStyle = '#cbd5e1';
    ctx.fillRect(0, 0, 128, 128);
    ctx.strokeStyle = '#94a3b8';
    ctx.lineWidth = 4;
    ctx.strokeRect(2, 2, 124, 124);

    // Circular perforated drain holes
    ctx.fillStyle = '#1e293b';
    const center = 64;
    for (let r = 10; r <= 48; r += 12) {
      const count = Math.floor(2 * Math.PI * r / 14);
      for (let i = 0; i < count; i++) {
        const angle = (i / count) * Math.PI * 2;
        const x = center + Math.cos(angle) * r;
        const y = center + Math.sin(angle) * r;
        ctx.beginPath();
        ctx.arc(x, y, 3.5, 0, Math.PI * 2);
        ctx.fill();
      }
    }
    // Center hole
    ctx.beginPath();
    ctx.arc(64, 64, 4.5, 0, Math.PI * 2);
    ctx.fill();

    const texture = new THREE.CanvasTexture(canvas);
    return texture;
  }

  createOakWoodTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const ctx = canvas.getContext('2d');

    // Rich Honey Marine Oak base tone
    ctx.fillStyle = '#b88955';
    ctx.fillRect(0, 0, 512, 512);

    // Vertical Wood Grain Lines
    for (let x = 0; x < 512; x += 3) {
      const alpha = 0.08 + Math.random() * 0.14;
      ctx.fillStyle = Math.random() > 0.45 ? `rgba(92, 58, 26, ${alpha})` : `rgba(235, 198, 150, ${alpha})`;
      ctx.fillRect(x, 0, 2 + Math.random() * 3, 512);
    }

    // Subtle Natural Wood Knots & Rings
    for (let i = 0; i < 4; i++) {
      const kx = 60 + Math.random() * 390;
      const ky = 60 + Math.random() * 390;
      for (let r = 8; r < 50; r += 7) {
        ctx.strokeStyle = 'rgba(80, 48, 20, 0.12)';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.ellipse(kx, ky, r * 0.4, r, 0, 0, Math.PI * 2);
        ctx.stroke();
      }
    }

    // Vertical Plank Seam Grooves
    ctx.strokeStyle = 'rgba(60, 36, 14, 0.35)';
    ctx.lineWidth = 2.0;
    [128, 256, 384].forEach(x => {
      ctx.beginPath();
      ctx.moveTo(x, 0);
      ctx.lineTo(x, 512);
      ctx.stroke();
    });

    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.RepeatWrapping;
    texture.repeat.set(1, 1);
    texture.anisotropy = 8;
    return texture;
  }

  createCarpetTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const ctx = canvas.getContext('2d');

    // Warm taupe / beige ribbed carpet base
    ctx.fillStyle = '#b09f8c';
    ctx.fillRect(0, 0, 512, 512);

    // Fine linear pinstripe ridges (matching photo ribbed weave)
    const stripeWidth = 6;
    for (let x = 0; x < 512; x += stripeWidth) {
      ctx.fillStyle = (x / stripeWidth) % 2 === 0 ? '#9a8874' : '#c4b5a2';
      ctx.fillRect(x, 0, stripeWidth - 1.5, 512);
    }

    // Noise fibers
    for (let i = 0; i < 6000; i++) {
      const px = Math.random() * 512;
      const py = Math.random() * 512;
      const shade = Math.floor(Math.random() * 40);
      ctx.fillStyle = `rgba(${160 + shade}, ${145 + shade}, ${130 + shade}, 0.25)`;
      ctx.fillRect(px, py, 2, 2);
    }

    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.RepeatWrapping;
    texture.repeat.set(4, 4);
    texture.anisotropy = 8;
    return texture;
  }

  createOceanWindowTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 768;
    const ctx = canvas.getContext('2d');

    // Sky Gradient (Top half)
    const skyGrad = ctx.createLinearGradient(0, 0, 0, 420);
    skyGrad.addColorStop(0, '#0284c7');
    skyGrad.addColorStop(0.5, '#38bdf8');
    skyGrad.addColorStop(1, '#bae6fd');
    ctx.fillStyle = skyGrad;
    ctx.fillRect(0, 0, 512, 420);

    // Soft Clouds
    ctx.fillStyle = 'rgba(255, 255, 255, 0.75)';
    [[140, 240, 70], [200, 225, 90], [260, 235, 60], [380, 290, 80], [430, 280, 60]].forEach(([cx, cy, r]) => {
      ctx.beginPath();
      ctx.arc(cx, cy, r, 0, Math.PI * 2);
      ctx.fill();
    });

    // Horizon Line
    ctx.strokeStyle = '#0284c7';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(0, 420);
    ctx.lineTo(512, 420);
    ctx.stroke();

    // Deep Ocean Water (Bottom half)
    const oceanGrad = ctx.createLinearGradient(0, 420, 0, 768);
    oceanGrad.addColorStop(0, '#0284c7');
    oceanGrad.addColorStop(0.4, '#0369a1');
    oceanGrad.addColorStop(1, '#075985');
    ctx.fillStyle = oceanGrad;
    ctx.fillRect(0, 420, 512, 348);

    // Water ripple highlights
    ctx.strokeStyle = 'rgba(255, 255, 255, 0.18)';
    ctx.lineWidth = 1.5;
    for (let y = 430; y < 768; y += 18) {
      ctx.beginPath();
      ctx.moveTo(0, y);
      ctx.bezierCurveTo(128, y + 4, 256, y - 4, 512, y + 2);
      ctx.stroke();
    }

    const texture = new THREE.CanvasTexture(canvas);
    texture.anisotropy = 8;
    return texture;
  }

  createLifeJacketLabelTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 128;
    canvas.height = 80;
    const ctx = canvas.getContext('2d');

    // Navy Blue Placard
    ctx.fillStyle = '#0f274a';
    ctx.fillRect(0, 0, 128, 80);
    ctx.strokeStyle = '#ffffff';
    ctx.lineWidth = 2;
    ctx.strokeRect(4, 4, 120, 72);

    // Life Jacket Text
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 11px Arial, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('LIFE', 64, 34);
    ctx.fillText('JACKETS', 64, 52);

    const texture = new THREE.CanvasTexture(canvas);
    return texture;
  }

  buildProductModel(productId) {
    if (!this.productGroup) return;

    // Clear previous model completely
    while (this.productGroup.children.length > 0) {
      const obj = this.productGroup.children[0];
      this.disposeObject(obj);
      this.productGroup.remove(obj);
    }

    const wireMat = this.isWireframe;

    switch (productId) {
      case 'door':
        this.buildDoorModel(wireMat);
        break;
      case 'wall':
        this.buildWallPanelModel(wireMat);
        break;
      case 'ceiling':
        this.buildCeilingPanelModel(wireMat);
        break;
      case 'wetunit':
        this.buildWetUnitModel(wireMat);
        break;
      case 'cabin':
        this.buildCabinModel(wireMat);
        break;
      default:
        this.buildDoorModel(wireMat);
    }
  }

  buildDoorModel(wireframe) {
    // 1. High-Fidelity Textures & Materials matching assets/door.jpeg
    const blueDoorTex = this.createBlueDoorTexture();
    const yellowDoorTex = this.createYellowDoorTexture();

    const blueDoorLeafMat = new THREE.MeshStandardMaterial({ map: blueDoorTex, roughness: 0.35, metalness: 0.20, wireframe });
    const yellowDoorLeafMat = new THREE.MeshStandardMaterial({ map: yellowDoorTex, roughness: 0.32, metalness: 0.15, wireframe });
    const stainlessMat = new THREE.MeshStandardMaterial({ color: 0xf3f4f6, roughness: 0.16, metalness: 0.95, wireframe });
    const marineFrameMat = new THREE.MeshStandardMaterial({ color: 0x334155, roughness: 0.40, metalness: 0.65, wireframe });
    const rubberGasketMat = new THREE.MeshStandardMaterial({ color: 0x0f172a, roughness: 0.90, metalness: 0.05, wireframe });
    const darkerMetalMat = new THREE.MeshStandardMaterial({ color: 0x1e293b, roughness: 0.50, metalness: 0.70, wireframe });
    const glassMat = new THREE.MeshStandardMaterial({ color: 0xa5d8f3, roughness: 0.05, metalness: 0.95, transparent: true, opacity: 0.55, wireframe });

    const doorUnit = new THREE.Group();
    this.productGroup.add(doorUnit);

    // ==========================================
    // 1. HEAVY-DUTY MARINE STEEL SURROUND FRAME
    // ==========================================
    const frameWidth = 1.34;
    const frameHeight = 2.62;
    const frameDepth = 0.14;
    const jambThickness = 0.10;

    // Top Header Jamb
    const topJamb = new THREE.Mesh(new THREE.BoxGeometry(frameWidth, jambThickness, frameDepth), marineFrameMat);
    topJamb.position.set(0, (frameHeight - jambThickness) / 2, 0);
    doorUnit.add(topJamb);

    // Bottom Sill / Threshold (with stainless steel wear plate)
    const bottomJamb = new THREE.Mesh(new THREE.BoxGeometry(frameWidth, jambThickness, frameDepth), marineFrameMat);
    bottomJamb.position.set(0, -(frameHeight - jambThickness) / 2, 0);
    const thresholdPlate = new THREE.Mesh(new THREE.BoxGeometry(frameWidth - 0.02, 0.015, frameDepth + 0.02), stainlessMat);
    thresholdPlate.position.set(0, -(frameHeight - jambThickness) / 2 + jambThickness / 2 + 0.008, 0);
    doorUnit.add(bottomJamb, thresholdPlate);

    // Left Frame Jamb
    const leftJamb = new THREE.Mesh(new THREE.BoxGeometry(jambThickness, frameHeight - 2 * jambThickness, frameDepth), marineFrameMat);
    leftJamb.position.set(-(frameWidth - jambThickness) / 2, 0, 0);
    doorUnit.add(leftJamb);

    // Right Frame Jamb
    const rightJamb = new THREE.Mesh(new THREE.BoxGeometry(jambThickness, frameHeight - 2 * jambThickness, frameDepth), marineFrameMat);
    rightJamb.position.set((frameWidth - jambThickness) / 2, 0, 0);
    doorUnit.add(rightJamb);

    // Inner Rubber Gasket Seal (weather/watertight A-60 / B-15 gasket)
    const gasketBevel = new THREE.Mesh(new THREE.BoxGeometry(frameWidth - 0.12, frameHeight - 0.12, 0.04), rubberGasketMat);
    gasketBevel.position.set(0, 0, 0);
    doorUnit.add(gasketBevel);

    // Marine Frame Mounting Brackets / Flange Lug Plates
    [-0.9, 0, 0.9].forEach(y => {
      [-1, 1].forEach(side => {
        const lug = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.14, 0.06), stainlessMat);
        lug.position.set(side * (frameWidth / 2 + 0.015), y, 0);
        doorUnit.add(lug);
      });
    });

    // ==========================================
    // 2. COMPOSITE MARINE FIRE DOOR LEAF
    // ==========================================
    const leafWidth = 1.12;
    const leafHeight = 2.40;
    const leafDepth = 0.08;

    // Direct multi-material box: Front = Blue, Back = Yellow, Edges = Stainless Steel
    const doorLeafMaterials = [
      stainlessMat,       // +X (Right edge)
      stainlessMat,       // -X (Left edge)
      stainlessMat,       // +Y (Top edge)
      stainlessMat,       // -Y (Bottom edge)
      blueDoorLeafMat,    // +Z (Front Blue Marine Face)
      yellowDoorLeafMat   // -Z (Back Yellow Safety Face)
    ];

    const doorLeafMesh = new THREE.Mesh(new THREE.BoxGeometry(leafWidth, leafHeight, leafDepth), doorLeafMaterials);
    doorUnit.add(doorLeafMesh);

    // ----------------------------------------------------
    // FRONT FACE (+Z): 3D HARDWARE (BLUE SIDE)
    // ----------------------------------------------------
    const frontZ = leafDepth / 2; // +0.04

    // Top Overhead Hydraulic Door Closer (Silver body + slide track + arm)
    const slideTrack = new THREE.Mesh(new THREE.BoxGeometry(0.48, 0.035, 0.035), stainlessMat);
    slideTrack.position.set(0.10, 1.15, frontZ + 0.02);
    const closerBody = new THREE.Mesh(new THREE.BoxGeometry(0.32, 0.075, 0.065), new THREE.MeshStandardMaterial({ color: 0xe5e7eb, roughness: 0.25, metalness: 0.85, wireframe }));
    closerBody.position.set(0.10, 1.04, frontZ + 0.035);
    const closerArm1 = new THREE.Mesh(new THREE.CylinderGeometry(0.008, 0.008, 0.16, 12), stainlessMat);
    closerArm1.position.set(0.10, 1.10, frontZ + 0.035);
    closerArm1.rotation.z = Math.PI / 4;
    const closerArm2 = new THREE.Mesh(new THREE.CylinderGeometry(0.008, 0.008, 0.14, 12), stainlessMat);
    closerArm2.position.set(0.18, 1.13, frontZ + 0.035);
    closerArm2.rotation.z = -Math.PI / 5;
    doorUnit.add(slideTrack, closerBody, closerArm1, closerArm2);

    // Square Fire Vision Glass Window
    const blueWinFrame = new THREE.Mesh(new THREE.BoxGeometry(0.36, 0.36, 0.025), stainlessMat);
    blueWinFrame.position.set(0, 0.50, frontZ + 0.012);
    const blueWinGlass = new THREE.Mesh(new THREE.BoxGeometry(0.26, 0.26, 0.01), glassMat);
    blueWinGlass.position.set(0, 0.50, frontZ + 0.015);
    // Window Corner Rivets / Studs
    [-0.15, 0.15].forEach(dx => {
      [-0.15, 0.15].forEach(dy => {
        const rivet = new THREE.Mesh(new THREE.CylinderGeometry(0.005, 0.005, 0.008, 12), stainlessMat);
        rivet.position.set(dx, 0.50 + dy, frontZ + 0.026);
        rivet.rotation.x = Math.PI / 2;
        doorUnit.add(rivet);
      });
    });
    doorUnit.add(blueWinFrame, blueWinGlass);

    // Digital Security Keypad Unit (Raised 3D Housing)
    const keypadBase = new THREE.Mesh(new THREE.BoxGeometry(0.065, 0.16, 0.022), stainlessMat);
    keypadBase.position.set(-0.43, 0.02, frontZ + 0.011);
    const keypadFace = new THREE.Mesh(new THREE.BoxGeometry(0.048, 0.12, 0.006), darkerMetalMat);
    keypadFace.position.set(-0.43, 0.02, frontZ + 0.023);
    const keypadLed = new THREE.Mesh(new THREE.SphereGeometry(0.005, 12, 12), new THREE.MeshBasicMaterial({ color: 0x22c55e }));
    keypadLed.position.set(-0.43, 0.085, frontZ + 0.023);
    doorUnit.add(keypadBase, keypadFace, keypadLed);

    // Marine Lever Door Handle & Escutcheon Plate (Front Blue Side)
    const blueEscutcheon = new THREE.Mesh(new THREE.BoxGeometry(0.045, 0.14, 0.018), stainlessMat);
    blueEscutcheon.position.set(-0.43, -0.20, frontZ + 0.009);
    const blueHandle = new THREE.Mesh(new THREE.BoxGeometry(0.14, 0.024, 0.024), stainlessMat);
    blueHandle.position.set(-0.37, -0.20, frontZ + 0.028);
    const blueKeyhole = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.01, 0.01, 16), darkerMetalMat);
    blueKeyhole.position.set(-0.43, -0.11, frontZ + 0.018);
    blueKeyhole.rotation.x = Math.PI / 2;
    doorUnit.add(blueEscutcheon, blueHandle, blueKeyhole);

    // Bottom Left Emergency Escape / Kickplate Hatch
    const hatchBorder = new THREE.Mesh(new THREE.BoxGeometry(0.24, 0.24, 0.015), stainlessMat);
    hatchBorder.position.set(-0.35, -0.96, frontZ + 0.008);
    const hatchLatch = new THREE.Mesh(new THREE.BoxGeometry(0.018, 0.05, 0.014), stainlessMat);
    hatchLatch.position.set(-0.25, -0.96, frontZ + 0.016);
    const latchKnob = new THREE.Mesh(new THREE.CylinderGeometry(0.006, 0.006, 0.02, 12), new THREE.MeshStandardMaterial({ color: 0xd97706, roughness: 0.3, metalness: 0.8 }));
    latchKnob.position.set(-0.25, -0.96, frontZ + 0.022);
    latchKnob.rotation.x = Math.PI / 2;
    doorUnit.add(hatchBorder, hatchLatch, latchKnob);

    // ----------------------------------------------------
    // BACK FACE (-Z): 3D HARDWARE (YELLOW SIDE)
    // ----------------------------------------------------
    const backZ = -leafDepth / 2; // -0.04

    // Vertical Rectangular Fire Vision Glass Window
    const yellowWinFrame = new THREE.Mesh(new THREE.BoxGeometry(0.30, 0.88, 0.025), stainlessMat);
    yellowWinFrame.position.set(0.18, 0.44, backZ - 0.012);
    const yellowWinGlass = new THREE.Mesh(new THREE.BoxGeometry(0.22, 0.80, 0.01), glassMat);
    yellowWinGlass.position.set(0.18, 0.44, backZ - 0.015);
    // Window Corner Rivets
    [-0.12, 0.12].forEach(dx => {
      [-0.41, 0.41].forEach(dy => {
        const rivet = new THREE.Mesh(new THREE.CylinderGeometry(0.005, 0.005, 0.008, 12), stainlessMat);
        rivet.position.set(0.18 + dx, 0.44 + dy, backZ - 0.026);
        rivet.rotation.x = Math.PI / 2;
        doorUnit.add(rivet);
      });
    });
    doorUnit.add(yellowWinFrame, yellowWinGlass);

    // 4 Raised Corner Screws for the Placard on the Yellow Door
    [-0.19, 0.19].forEach(dx => {
      [-0.12, 0.12].forEach(dy => {
        const screw = new THREE.Mesh(new THREE.CylinderGeometry(0.006, 0.006, 0.008, 12), stainlessMat);
        screw.position.set(-0.16 + dx, -0.04 + dy, backZ - 0.006);
        screw.rotation.x = Math.PI / 2;
        doorUnit.add(screw);
      });
    });

    // Lower Stainless Steel Ventilation Louver Grille Panel
    const louverFrame = new THREE.Mesh(new THREE.BoxGeometry(0.50, 0.56, 0.025), stainlessMat);
    louverFrame.position.set(0.10, -0.64, backZ - 0.012);
    const louverBack = new THREE.Mesh(new THREE.BoxGeometry(0.44, 0.50, 0.01), darkerMetalMat);
    louverBack.position.set(0.10, -0.64, backZ - 0.008);
    doorUnit.add(louverFrame, louverBack);

    // 10 Horizontal Stainless Steel Louver Slats (3D Angled Louvers)
    for (let i = 0; i < 10; i++) {
      const slatY = -0.85 + i * 0.047;
      const slat = new THREE.Mesh(new THREE.BoxGeometry(0.42, 0.022, 0.024), stainlessMat);
      slat.position.set(0.10, slatY, backZ - 0.018);
      slat.rotation.x = -Math.PI / 5;
      doorUnit.add(slat);
    }
    // Louver Center Vertical Divider Spine
    const louverDivider = new THREE.Mesh(new THREE.BoxGeometry(0.024, 0.50, 0.022), stainlessMat);
    louverDivider.position.set(0.10, -0.64, backZ - 0.018);
    // 4 Corner Louver Mounting Clips
    [-0.22, 0.22].forEach(dx => {
      [-0.25, 0.25].forEach(dy => {
        const clip = new THREE.Mesh(new THREE.BoxGeometry(0.03, 0.04, 0.012), stainlessMat);
        clip.position.set(0.10 + dx, -0.64 + dy, backZ - 0.025);
        doorUnit.add(clip);
      });
    });
    doorUnit.add(louverDivider);

    // Marine Lever Door Handle & Escutcheon Plate (Back Yellow Side)
    const yellowEscutcheon = new THREE.Mesh(new THREE.BoxGeometry(0.045, 0.14, 0.018), stainlessMat);
    yellowEscutcheon.position.set(0.43, -0.20, backZ - 0.009);
    const yellowHandle = new THREE.Mesh(new THREE.BoxGeometry(0.14, 0.024, 0.024), stainlessMat);
    yellowHandle.position.set(0.37, -0.20, backZ - 0.028);
    const yellowKeyhole = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.01, 0.01, 16), darkerMetalMat);
    yellowKeyhole.position.set(0.43, -0.11, backZ - 0.018);
    yellowKeyhole.rotation.x = Math.PI / 2;
    doorUnit.add(yellowEscutcheon, yellowHandle, yellowKeyhole);

    // ==========================================
    // 3. HEAVY-DUTY MARINE STEEL HINGES
    // ==========================================
    [-0.85, 0.05, 0.95].forEach(y => {
      const hingeBarrel = new THREE.Mesh(new THREE.CylinderGeometry(0.028, 0.028, 0.20, 16), stainlessMat);
      hingeBarrel.position.set(leafWidth / 2 + 0.035, y, 0);
      const hingeFlange1 = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.08, 0.015), stainlessMat);
      hingeFlange1.position.set(leafWidth / 2 + 0.01, y, 0.02);
      const hingeFlange2 = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.08, 0.015), stainlessMat);
      hingeFlange2.position.set(leafWidth / 2 + 0.06, y, 0);
      doorUnit.add(hingeBarrel, hingeFlange1, hingeFlange2);
    });
  }

  buildWallPanelModel(wireframe) {
    const skinMat = new THREE.MeshStandardMaterial({ color: 0xd4d4d8, roughness: 0.4, metalness: 0.3, wireframe });
    const coreMat = new THREE.MeshStandardMaterial({ color: 0xa16207, roughness: 0.9, metalness: 0.1, wireframe }); // rockwool color
    const frameMat = new THREE.MeshStandardMaterial({ color: 0x64748b, roughness: 0.3, metalness: 0.8, wireframe });

    // Panel 1 (Full Section)
    const p1 = new THREE.Group();
    const skin1 = new THREE.Mesh(new THREE.BoxGeometry(1.4, 3.2, 0.04), skinMat);
    skin1.position.z = 0.06;
    const skinBack = new THREE.Mesh(new THREE.BoxGeometry(1.4, 3.2, 0.04), skinMat);
    skinBack.position.z = -0.06;
    const core1 = new THREE.Mesh(new THREE.BoxGeometry(1.36, 3.16, 0.08), coreMat);
    const border1 = new THREE.Mesh(new THREE.BoxGeometry(1.44, 3.24, 0.16), frameMat);
    border1.position.z = 0;
    
    p1.add(skin1, skinBack, core1);
    p1.position.x = -0.85;
    this.productGroup.add(p1);

    // Panel 2 (Cutaway Showing Internal Rockwool Core)
    const p2 = new THREE.Group();
    const skin2Half = new THREE.Mesh(new THREE.BoxGeometry(0.7, 3.2, 0.04), skinMat);
    skin2Half.position.set(-0.35, 0, 0.06);
    const exposedCore = new THREE.Mesh(new THREE.BoxGeometry(1.36, 3.16, 0.1), coreMat);
    const edgeSpline = new THREE.Mesh(new THREE.BoxGeometry(0.08, 3.2, 0.16), frameMat);
    edgeSpline.position.x = -0.72;

    p2.add(skin2Half, exposedCore, edgeSpline);
    p2.position.x = 0.85;
    this.productGroup.add(p2);
  }

  buildCeilingPanelModel(wireframe) {
    const tileMat = new THREE.MeshStandardMaterial({ color: 0xe2e8f0, roughness: 0.3, metalness: 0.4, wireframe });
    const coreMat = new THREE.MeshStandardMaterial({ color: 0x854d0e, roughness: 0.9, metalness: 0.1, wireframe });
    const railMat = new THREE.MeshStandardMaterial({ color: 0x334155, roughness: 0.2, metalness: 0.9, wireframe });
    const lightMat = new THREE.MeshBasicMaterial({ color: 0xffffff, wireframe });

    // 4 Interlocking Planks floating horizontally
    [-1.0, -0.33, 0.33, 1.0].forEach((y, i) => {
      const plankGeo = new THREE.BoxGeometry(2.8, 0.6, 0.12);
      const plank = new THREE.Mesh(plankGeo, tileMat);
      plank.position.set(0, y, i * 0.08);
      this.productGroup.add(plank);

      const coreGeo = new THREE.BoxGeometry(2.7, 0.54, 0.08);
      const core = new THREE.Mesh(coreGeo, coreMat);
      core.position.set(0, y, i * 0.08);
      this.productGroup.add(core);
    });

    // Top T-Runner Suspension Grid Rails
    [-1.0, 1.0].forEach(x => {
      const railGeo = new THREE.BoxGeometry(0.08, 3.0, 0.2);
      const rail = new THREE.Mesh(railGeo, railMat);
      rail.position.set(x, 0, 0.25);
      this.productGroup.add(rail);

      // Suspension Hanger Rod
      const rodGeo = new THREE.CylinderGeometry(0.02, 0.02, 1.0, 12);
      const rod = new THREE.Mesh(rodGeo, railMat);
      rod.position.set(x, 0.8, 0.7);
      rod.rotation.x = Math.PI / 4;
      this.productGroup.add(rod);
    });

    // Integrated LED channel
    const ledGeo = new THREE.BoxGeometry(2.8, 0.06, 0.02);
    const led = new THREE.Mesh(ledGeo, lightMat);
    led.position.set(0, 0.02, 0.12);
    this.productGroup.add(led);
  }

  buildWetUnitModel(wireframe) {
    // 1. Materials matching user reference photo
    const ceramicTileTex = this.createBlueTileTexture();
    const tileMat = new THREE.MeshStandardMaterial({ map: ceramicTileTex, roughness: 0.22, metalness: 0.12, wireframe });
    const drainTex = this.createDrainGrateTexture();
    const drainMat = new THREE.MeshStandardMaterial({ map: drainTex, roughness: 0.20, metalness: 0.90, wireframe });
    const whiteCeramicMat = new THREE.MeshStandardMaterial({ color: 0xffffff, roughness: 0.12, metalness: 0.05, wireframe });
    const chromeMat = new THREE.MeshStandardMaterial({ color: 0xf1f5f9, roughness: 0.10, metalness: 0.98, wireframe });
    const paperMat = new THREE.MeshStandardMaterial({ color: 0xffffff, roughness: 0.90, metalness: 0.0, wireframe });
    const pipeMat = new THREE.MeshStandardMaterial({ color: 0xf1f5f9, roughness: 0.40, metalness: 0.10, wireframe });
    const stainlessMat = new THREE.MeshStandardMaterial({ color: 0xe2e8f0, roughness: 0.18, metalness: 0.90, wireframe });

    const wetUnitGroup = new THREE.Group();
    // Center the wet unit fixtures around origin
    wetUnitGroup.position.set(0, -0.25, 0);
    this.productGroup.add(wetUnitGroup);

    // ==========================================
    // 1. MARINE TILED FLOOR TRAY (ROYAL BLUE)
    // ==========================================
    const floorSize = 1.70;
    const floorDepth = 0.08;
    const floorY = -0.55;

    // Floor Base with Blue Ceramic Tile Top Face
    const floorMaterials = [
      stainlessMat,   // +X (Right edge)
      stainlessMat,   // -X (Left edge)
      tileMat,        // +Y (Tiled Ceramic Top Surface)
      stainlessMat,   // -Y (Bottom)
      stainlessMat,   // +Z (Front edge)
      stainlessMat    // -Z (Back edge)
    ];
    const floorTray = new THREE.Mesh(new THREE.BoxGeometry(floorSize, floorDepth, floorSize), floorMaterials);
    floorTray.position.set(0, floorY, 0);
    wetUnitGroup.add(floorTray);

    // Stainless Steel Perimeter Coaming / Edge Curb
    const rimTrim = new THREE.Mesh(new THREE.BoxGeometry(floorSize + 0.03, 0.04, floorSize + 0.03), stainlessMat);
    rimTrim.position.set(0, floorY + 0.03, 0);
    wetUnitGroup.add(rimTrim);

    // Stainless Steel Corner Floor Drain Grate
    const drainGrate = new THREE.Mesh(new THREE.PlaneGeometry(0.20, 0.20), drainMat);
    drainGrate.rotation.x = -Math.PI / 2;
    drainGrate.position.set(-0.56, floorY + floorDepth / 2 + 0.003, 0.54);
    wetUnitGroup.add(drainGrate);

    // ==========================================
    // 2. WHITE CERAMIC MARINE TOILET (WC)
    // ==========================================
    const wcGroup = new THREE.Group();
    wcGroup.position.set(-0.38, floorY + floorDepth / 2, -0.15);
    wetUnitGroup.add(wcGroup);

    // Toilet Cistern Tank
    const cistern = new THREE.Mesh(new THREE.BoxGeometry(0.38, 0.46, 0.24), whiteCeramicMat);
    cistern.position.set(0, 0.56, -0.34);
    const cisternLid = new THREE.Mesh(new THREE.BoxGeometry(0.40, 0.04, 0.26), whiteCeramicMat);
    cisternLid.position.set(0, 0.81, -0.34);
    wcGroup.add(cistern, cisternLid);

    // Dual Flush Chrome Push Button on Top Lid
    const flushBtn = new THREE.Mesh(new THREE.CylinderGeometry(0.035, 0.035, 0.012, 24), chromeMat);
    flushBtn.position.set(0, 0.835, -0.34);
    wcGroup.add(flushBtn);

    // Toilet Bowl Pedestal Base (Molded Marine Shape)
    const bowlPedestal = new THREE.Mesh(new THREE.CylinderGeometry(0.20, 0.18, 0.40, 24), whiteCeramicMat);
    bowlPedestal.position.set(0, 0.20, 0.04);
    const bowlFoot = new THREE.Mesh(new THREE.BoxGeometry(0.30, 0.06, 0.46), whiteCeramicMat);
    bowlFoot.position.set(0, 0.03, 0.04);
    wcGroup.add(bowlPedestal, bowlFoot);

    // Toilet Bowl Rim Body
    const bowlRim = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.20, 0.18, 24), whiteCeramicMat);
    bowlRim.position.set(0, 0.38, 0.08);
    bowlRim.scale.set(1.0, 1.0, 1.25);
    wcGroup.add(bowlRim);

    // Toilet Seat Ring & Closed Top Cover
    const toiletSeatRing = new THREE.Mesh(new THREE.CylinderGeometry(0.25, 0.25, 0.025, 24), whiteCeramicMat);
    toiletSeatRing.position.set(0, 0.48, 0.10);
    toiletSeatRing.scale.set(1.0, 1.0, 1.28);
    const toiletCover = new THREE.Mesh(new THREE.CylinderGeometry(0.255, 0.255, 0.02, 24), whiteCeramicMat);
    toiletCover.position.set(0, 0.50, 0.10);
    toiletCover.scale.set(1.0, 1.0, 1.28);
    wcGroup.add(toiletSeatRing, toiletCover);

    // Chrome Seat Hinges
    [-0.09, 0.09].forEach(x => {
      const hinge = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.01, 0.03, 12), chromeMat);
      hinge.position.set(x, 0.51, -0.18);
      wcGroup.add(hinge);
    });

    // ==========================================
    // 3. TOILET PAPER ROLL DISPENSER
    // ==========================================
    const tpHolder = new THREE.Group();
    tpHolder.position.set(0.06, floorY + 0.85, -0.48);
    wetUnitGroup.add(tpHolder);

    const tpBracket = new THREE.Mesh(new THREE.BoxGeometry(0.03, 0.05, 0.06), chromeMat);
    tpBracket.position.set(0, 0, 0);
    const tpBar = new THREE.Mesh(new THREE.CylinderGeometry(0.008, 0.008, 0.15, 12), chromeMat);
    tpBar.position.set(0, -0.02, 0.04);
    tpBar.rotation.z = Math.PI / 2;
    const tpRoll = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.045, 0.12, 20), paperMat);
    tpRoll.position.set(0, -0.02, 0.04);
    tpRoll.rotation.z = Math.PI / 2;
    tpHolder.add(tpBracket, tpBar, tpRoll);

    // ==========================================
    // 4. CORNER CERAMIC WASHBASIN / SINK
    // ==========================================
    const sinkGroup = new THREE.Group();
    sinkGroup.position.set(0.44, floorY + 0.95, -0.42);
    wetUnitGroup.add(sinkGroup);

    // Ceramic Sink Basin Body (Curved Front)
    const sinkBody = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.16, 0.18, 24), whiteCeramicMat);
    sinkBody.position.set(0, 0, 0);
    sinkBody.scale.set(1.1, 1.0, 1.0);
    const sinkDeck = new THREE.Mesh(new THREE.BoxGeometry(0.48, 0.04, 0.42), whiteCeramicMat);
    sinkDeck.position.set(0, 0.09, -0.05);
    sinkGroup.add(sinkBody, sinkDeck);

    // Inner Basin Hollow
    const basinInner = new THREE.Mesh(new THREE.CylinderGeometry(0.20, 0.12, 0.15, 24), whiteCeramicMat);
    basinInner.position.set(0, 0.03, 0.02);
    sinkGroup.add(basinInner);

    // Chrome Mixer Faucet
    const faucetBase = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.024, 0.08, 16), chromeMat);
    faucetBase.position.set(0, 0.14, -0.16);
    const faucetSpout = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.012, 0.12, 16), chromeMat);
    faucetSpout.position.set(0, 0.18, -0.10);
    faucetSpout.rotation.x = Math.PI / 4;
    const faucetLever = new THREE.Mesh(new THREE.BoxGeometry(0.015, 0.01, 0.06), chromeMat);
    faucetLever.position.set(0, 0.18, -0.16);
    sinkGroup.add(faucetBase, faucetSpout, faucetLever);

    // Chrome Drain Plug Ring
    const sinkDrain = new THREE.Mesh(new THREE.CylinderGeometry(0.032, 0.032, 0.008, 16), chromeMat);
    sinkDrain.position.set(0, -0.04, 0.02);
    sinkGroup.add(sinkDrain);

    // White P-Trap Waste Drain Pipe Assembly
    const pipeVertical = new THREE.Mesh(new THREE.CylinderGeometry(0.018, 0.018, 0.26, 16), pipeMat);
    pipeVertical.position.set(0, -0.22, 0.02);
    const pTrapBend = new THREE.Mesh(new THREE.TorusGeometry(0.045, 0.018, 12, 16, Math.PI), pipeMat);
    pTrapBend.position.set(0, -0.35, -0.025);
    pTrapBend.rotation.y = Math.PI / 2;
    const pipeToWall = new THREE.Mesh(new THREE.CylinderGeometry(0.018, 0.018, 0.35, 16), pipeMat);
    pipeToWall.position.set(0, -0.305, -0.20);
    pipeToWall.rotation.x = Math.PI / 2;
    sinkGroup.add(pipeVertical, pTrapBend, pipeToWall);

    // ==========================================
    // 5. STAINLESS STEEL MARINE DOOR HANDLE
    // ==========================================
    const handleGroup = new THREE.Group();
    handleGroup.position.set(floorSize / 2 - 0.08, floorY + 0.90, 0.28);
    wetUnitGroup.add(handleGroup);

    const handleGrip = new THREE.Mesh(new THREE.CylinderGeometry(0.014, 0.014, 0.22, 16), stainlessMat);
    handleGrip.position.set(0, 0, 0);
    const handleStandoff1 = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.012, 0.04, 16), stainlessMat);
    handleStandoff1.position.set(0.02, 0.09, 0);
    handleStandoff1.rotation.z = Math.PI / 2;
    const handleStandoff2 = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.012, 0.04, 16), stainlessMat);
    handleStandoff2.position.set(0.02, -0.09, 0);
    handleStandoff2.rotation.z = Math.PI / 2;
    handleGroup.add(handleGrip, handleStandoff1, handleStandoff2);
  }

  buildCabinModel(wireframe) {
    // 1. High-Resolution Marine Textures & Materials (Non-Glare Satin Matte)
    const woodTex = this.createOakWoodTexture();
    const woodMat = new THREE.MeshStandardMaterial({ 
      map: woodTex, 
      color: 0xb5824e, 
      roughness: 0.72, 
      metalness: 0.0, 
      wireframe 
    });
    
    const carpetTex = this.createCarpetTexture();
    const carpetMat = new THREE.MeshStandardMaterial({ 
      map: carpetTex, 
      color: 0x9c8b78, 
      roughness: 0.92, 
      metalness: 0.0, 
      wireframe 
    });
    
    const oceanTex = this.createOceanWindowTexture();
    const oceanMat = new THREE.MeshBasicMaterial({ map: oceanTex, wireframe });
    
    const labelTex = this.createLifeJacketLabelTexture();
    const labelMat = new THREE.MeshStandardMaterial({ map: labelTex, roughness: 0.40, metalness: 0.05, wireframe });

    const wallMat = new THREE.MeshStandardMaterial({ color: 0xd2c6b4, roughness: 0.88, metalness: 0.0, wireframe });
    const beddingMat = new THREE.MeshStandardMaterial({ color: 0xeee9de, roughness: 0.82, metalness: 0.0, wireframe });
    const olivePillowMat = new THREE.MeshStandardMaterial({ color: 0x73961f, roughness: 0.65, metalness: 0.0, wireframe });
    const curtainMat = new THREE.MeshStandardMaterial({ color: 0x63821b, roughness: 0.70, metalness: 0.0, wireframe });
    const curtainTieMat = new THREE.MeshStandardMaterial({ color: 0x4e6812, roughness: 0.60, metalness: 0.0, wireframe });
    const innerCurtainMat = new THREE.MeshStandardMaterial({ color: 0xc4beaF, roughness: 0.80, metalness: 0.0, wireframe });
    const stainlessMat = new THREE.MeshStandardMaterial({ color: 0xb0bac5, roughness: 0.30, metalness: 0.85, wireframe });
    const darkMetalMat = new THREE.MeshStandardMaterial({ color: 0x222b38, roughness: 0.60, metalness: 0.50, wireframe });
    const ottomanMat = new THREE.MeshStandardMaterial({ color: 0xcac0af, roughness: 0.85, metalness: 0.0, wireframe });
    const sofaMat = new THREE.MeshStandardMaterial({ color: 0xe2dcd0, roughness: 0.85, metalness: 0.0, wireframe });
    const lightGlowMat = new THREE.MeshBasicMaterial({ color: 0xffeed1, wireframe });
    const ceilingMat = new THREE.MeshStandardMaterial({ color: 0xdcd8ce, roughness: 0.90, metalness: 0.0, wireframe });

    const cabinGroup = new THREE.Group();
    cabinGroup.position.set(0, -0.05, 0);
    this.productGroup.add(cabinGroup);

    const floorWidth = 2.65;
    const floorDepth = 2.10;
    const floorY = -1.12;
    const roomH = 2.26;

    // ==========================================
    // 1. CARPETED MARINE FLOOR PLATFORM
    // ==========================================
    const floorMaterials = [
      darkMetalMat, // +X
      darkMetalMat, // -X
      carpetMat,    // +Y (Ribbed Carpet Surface)
      darkMetalMat, // -Y
      darkMetalMat, // +Z
      darkMetalMat  // -Z
    ];
    const floor = new THREE.Mesh(new THREE.BoxGeometry(floorWidth, 0.08, floorDepth), floorMaterials);
    floor.position.set(0, floorY, 0.10);
    cabinGroup.add(floor);

    const floorRim = new THREE.Mesh(new THREE.BoxGeometry(floorWidth + 0.02, 0.03, floorDepth + 0.02), darkMetalMat);
    floorRim.position.set(0, floorY + 0.025, 0.10);
    cabinGroup.add(floorRim);

    // ==========================================
    // 2. BACK & LEFT MARINE BULKHEAD WALLS
    // ==========================================
    // Back Bulkhead Wall (Beige paneling)
    const backWall = new THREE.Mesh(new THREE.BoxGeometry(floorWidth, roomH, 0.04), wallMat);
    backWall.position.set(0, floorY + roomH / 2, -floorDepth / 2 + 0.12);
    cabinGroup.add(backWall);

    // Left Bulkhead Wall with Window cutout area
    const leftWall = new THREE.Mesh(new THREE.BoxGeometry(0.04, roomH, floorDepth), wallMat);
    leftWall.position.set(-floorWidth / 2 + 0.02, floorY + roomH / 2, 0.10);
    cabinGroup.add(leftWall);

    // Overhead Ceiling Slab
    const ceiling = new THREE.Mesh(new THREE.BoxGeometry(floorWidth, 0.06, floorDepth), ceilingMat);
    ceiling.position.set(0, floorY + roomH + 0.03, 0.10);
    cabinGroup.add(ceiling);

    // Ceiling Recessed LED Downlights with Glow
    [-0.55, 0.15, 0.85].forEach(x => {
      const bezel = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.06, 0.015, 20), stainlessMat);
      bezel.position.set(x, floorY + roomH - 0.005, 0.20);
      const bulb = new THREE.Mesh(new THREE.CylinderGeometry(0.042, 0.042, 0.018, 16), lightGlowMat);
      bulb.position.set(x, floorY + roomH - 0.008, 0.20);
      cabinGroup.add(bezel, bulb);
    });

    // ==========================================
    // 3. DOUBLE-DECK MARINE BUNK BED (CENTER-LEFT)
    // ==========================================
    const bunkGroup = new THREE.Group();
    bunkGroup.position.set(-0.24, 0, -0.26);
    cabinGroup.add(bunkGroup);

    const bedW = 1.28; // Length along X-axis
    const bedD = 0.88; // Depth along Z-axis
    const bedH = 2.18; // Full bunk height

    // Back Panel (against bulkhead)
    const bedBack = new THREE.Mesh(new THREE.BoxGeometry(bedW, bedH, 0.04), woodMat);
    bedBack.position.set(0, 0, -bedD / 2 + 0.02);

    // Left End Wall (Headboard side with window neighbor)
    const bedLeftEnd = new THREE.Mesh(new THREE.BoxGeometry(0.05, bedH, bedD), woodMat);
    bedLeftEnd.position.set(-bedW / 2 + 0.025, 0, 0);

    // Right Divider Pillar (separates bed from wardrobe)
    const bedRightPillar = new THREE.Mesh(new THREE.BoxGeometry(0.06, bedH, bedD), woodMat);
    bedRightPillar.position.set(bedW / 2 - 0.03, 0, 0);

    // Top Canopy Header
    const bedTopHeader = new THREE.Mesh(new THREE.BoxGeometry(bedW, 0.08, bedD), woodMat);
    bedTopHeader.position.set(0, bedH / 2 - 0.04, 0);

    bunkGroup.add(bedBack, bedLeftEnd, bedRightPillar, bedTopHeader);

    // --- UPPER BUNK BERTH ---
    const upperY = 0.28;
    const upperBase = new THREE.Mesh(new THREE.BoxGeometry(bedW - 0.08, 0.06, bedD - 0.06), woodMat);
    upperBase.position.set(0, upperY, 0);

    // Upper Front Safety Rail Board
    const upperFrontRail = new THREE.Mesh(new THREE.BoxGeometry(bedW - 0.08, 0.20, 0.04), woodMat);
    upperFrontRail.position.set(0, upperY + 0.08, bedD / 2 - 0.02);

    // Upper Mattress
    const upperMattress = new THREE.Mesh(new THREE.BoxGeometry(bedW - 0.14, 0.15, bedD - 0.12), beddingMat);
    upperMattress.position.set(0, upperY + 0.10, 0);

    // Upper Pillows: Crisp White Pillow + Olive Green Accent Pillow
    const upperPillowWhite = new THREE.Mesh(new THREE.BoxGeometry(0.38, 0.12, 0.52), beddingMat);
    upperPillowWhite.position.set(-bedW / 2 + 0.28, upperY + 0.20, 0);

    const upperPillowOlive = new THREE.Mesh(new THREE.BoxGeometry(0.30, 0.10, 0.44), olivePillowMat);
    upperPillowOlive.position.set(-bedW / 2 + 0.38, upperY + 0.23, 0);
    upperPillowOlive.rotation.z = 0.22;

    // Recessed Reading Light Niche
    const upperNiche = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.14, 0.22), darkMetalMat);
    upperNiche.position.set(-bedW / 2 + 0.04, upperY + 0.46, 0);
    const upperLight = new THREE.Mesh(new THREE.CylinderGeometry(0.03, 0.03, 0.02, 16), lightGlowMat);
    upperLight.position.set(-bedW / 2 + 0.06, upperY + 0.46, 0);
    upperLight.rotation.z = Math.PI / 2;

    // Privacy Curtains: Tied-back Olive Drape on Right Pillar
    const upperCurtain = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.075, 0.65, 16), curtainMat);
    upperCurtain.position.set(bedW / 2 - 0.08, upperY + 0.38, bedD / 2 - 0.08);
    const upperTie = new THREE.Mesh(new THREE.CylinderGeometry(0.076, 0.076, 0.045, 16), curtainTieMat);
    upperTie.position.set(bedW / 2 - 0.08, upperY + 0.38, bedD / 2 - 0.08);

    // Patterned Inner Drape on Left End
    const upperInnerCurtain = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.055, 0.65, 16), innerCurtainMat);
    upperInnerCurtain.position.set(-bedW / 2 + 0.08, upperY + 0.38, bedD / 2 - 0.08);

    bunkGroup.add(upperBase, upperFrontRail, upperMattress, upperPillowWhite, upperPillowOlive, upperNiche, upperLight, upperCurtain, upperTie, upperInnerCurtain);

    // --- LOWER BUNK BERTH ---
    const lowerY = -0.46;
    const lowerBase = new THREE.Mesh(new THREE.BoxGeometry(bedW - 0.08, 0.06, bedD - 0.06), woodMat);
    lowerBase.position.set(0, lowerY, 0);

    // Lower Front Edge Board
    const lowerFrontRail = new THREE.Mesh(new THREE.BoxGeometry(bedW - 0.08, 0.16, 0.04), woodMat);
    lowerFrontRail.position.set(0, lowerY + 0.06, bedD / 2 - 0.02);

    // Lower Mattress
    const lowerMattress = new THREE.Mesh(new THREE.BoxGeometry(bedW - 0.14, 0.15, bedD - 0.12), beddingMat);
    lowerMattress.position.set(0, lowerY + 0.10, 0);

    // Lower Pillows: Crisp White Pillow + Olive Green Accent Pillow
    const lowerPillowWhite = new THREE.Mesh(new THREE.BoxGeometry(0.38, 0.12, 0.52), beddingMat);
    lowerPillowWhite.position.set(-bedW / 2 + 0.28, lowerY + 0.20, 0);

    const lowerPillowOlive = new THREE.Mesh(new THREE.BoxGeometry(0.30, 0.10, 0.44), olivePillowMat);
    lowerPillowOlive.position.set(-bedW / 2 + 0.38, lowerY + 0.23, 0);
    lowerPillowOlive.rotation.z = 0.22;

    // Recessed Reading Light Niche
    const lowerNiche = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.14, 0.22), darkMetalMat);
    lowerNiche.position.set(-bedW / 2 + 0.04, lowerY + 0.46, 0);
    const lowerLight = new THREE.Mesh(new THREE.CylinderGeometry(0.03, 0.03, 0.02, 16), lightGlowMat);
    lowerLight.position.set(-bedW / 2 + 0.06, lowerY + 0.46, 0);
    lowerLight.rotation.z = Math.PI / 2;

    // Privacy Curtains: Tied-back Olive Drape on Right Pillar
    const lowerCurtain = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.075, 0.65, 16), curtainMat);
    lowerCurtain.position.set(bedW / 2 - 0.08, lowerY + 0.38, bedD / 2 - 0.08);
    const lowerTie = new THREE.Mesh(new THREE.CylinderGeometry(0.076, 0.076, 0.045, 16), curtainTieMat);
    lowerTie.position.set(bedW / 2 - 0.08, lowerY + 0.38, bedD / 2 - 0.08);

    // Patterned Inner Drape on Left End
    const lowerInnerCurtain = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.055, 0.65, 16), innerCurtainMat);
    lowerInnerCurtain.position.set(-bedW / 2 + 0.08, lowerY + 0.38, bedD / 2 - 0.08);

    bunkGroup.add(lowerBase, lowerFrontRail, lowerMattress, lowerPillowWhite, lowerPillowOlive, lowerNiche, lowerLight, lowerCurtain, lowerTie, lowerInnerCurtain);

    // --- UNDER-BED 4 OAK STORAGE DRAWERS ---
    const drawerBaseY = -0.78;
    const drawerBase = new THREE.Mesh(new THREE.BoxGeometry(bedW, 0.46, bedD), woodMat);
    drawerBase.position.set(0, drawerBaseY, 0);
    bunkGroup.add(drawerBase);

    [-0.44, -0.15, 0.15, 0.44].forEach(x => {
      // Drawer Front Face Panel
      const drawerFace = new THREE.Mesh(new THREE.BoxGeometry(0.26, 0.36, 0.015), woodMat);
      drawerFace.position.set(x, drawerBaseY, bedD / 2 + 0.008);
      // Dark Recessed Pull Handle
      const drawerPull = new THREE.Mesh(new THREE.BoxGeometry(0.10, 0.05, 0.02), darkMetalMat);
      drawerPull.position.set(x, drawerBaseY, bedD / 2 + 0.016);
      bunkGroup.add(drawerFace, drawerPull);
    });

    // --- SLANTED OAK WOODEN BUNK LADDER ---
    const ladderGroup = new THREE.Group();
    ladderGroup.position.set(-bedW / 2 + 0.22, -0.06, bedD / 2 + 0.16);
    ladderGroup.rotation.x = 0.16; // Slanted forward matching photo
    bunkGroup.add(ladderGroup);

    const ladderRail1 = new THREE.Mesh(new THREE.BoxGeometry(0.04, 1.85, 0.07), woodMat);
    ladderRail1.position.set(-0.16, 0, 0);
    const ladderRail2 = new THREE.Mesh(new THREE.BoxGeometry(0.04, 1.85, 0.07), woodMat);
    ladderRail2.position.set(0.16, 0, 0);
    ladderGroup.add(ladderRail1, ladderRail2);

    // 5 Flat Oak Ladder Rungs
    [-0.65, -0.32, 0.02, 0.36, 0.68].forEach(y => {
      const rung = new THREE.Mesh(new THREE.BoxGeometry(0.32, 0.03, 0.06), woodMat);
      rung.position.set(0, y, 0);
      ladderGroup.add(rung);
    });

    // ==========================================
    // 4. FULL-HEIGHT MODULAR OAK WARDROBE (RIGHT)
    // ==========================================
    const wardrobeGroup = new THREE.Group();
    wardrobeGroup.position.set(0.78, 0, -0.26);
    cabinGroup.add(wardrobeGroup);

    const wardW = 0.82;
    const wardD = 0.58;
    const wardH = 2.18;

    // Wardrobe Main Carcass
    const wardBody = new THREE.Mesh(new THREE.BoxGeometry(wardW, wardH, wardD), woodMat);
    wardrobeGroup.add(wardBody);

    // Door Face Panels with Vertical Reveal Grooves
    const wardDoor1 = new THREE.Mesh(new THREE.BoxGeometry(0.36, 1.62, 0.015), woodMat);
    wardDoor1.position.set(-0.20, 0.18, wardD / 2 + 0.008);

    const wardDoor2 = new THREE.Mesh(new THREE.BoxGeometry(0.36, 1.62, 0.015), woodMat);
    wardDoor2.position.set(0.20, 0.18, wardD / 2 + 0.008);

    wardrobeGroup.add(wardDoor1, wardDoor2);

    // 2 Long Brushed Stainless Steel Handles on Main Doors
    [-0.08, 0.08].forEach(x => {
      const handleBar = new THREE.Mesh(new THREE.BoxGeometry(0.016, 0.36, 0.016), stainlessMat);
      handleBar.position.set(x, 0.08, wardD / 2 + 0.032);
      const post1 = new THREE.Mesh(new THREE.BoxGeometry(0.014, 0.014, 0.02), stainlessMat);
      post1.position.set(x, 0.22, wardD / 2 + 0.02);
      const post2 = new THREE.Mesh(new THREE.BoxGeometry(0.014, 0.014, 0.02), stainlessMat);
      post2.position.set(x, -0.06, wardD / 2 + 0.02);
      wardrobeGroup.add(handleBar, post1, post2);
    });

    // Keyholes below handles
    const keyhole = new THREE.Mesh(new THREE.CylinderGeometry(0.008, 0.008, 0.01, 16), stainlessMat);
    keyhole.position.set(0, -0.12, wardD / 2 + 0.018);
    keyhole.rotation.x = Math.PI / 2;
    wardrobeGroup.add(keyhole);

    // Navy Blue "LIFE JACKETS" Placard on Right Door
    const jacketBadge = new THREE.Mesh(new THREE.PlaneGeometry(0.12, 0.075), labelMat);
    jacketBadge.position.set(0.22, 0.32, wardD / 2 + 0.018);
    wardrobeGroup.add(jacketBadge);

    // Bottom Storage Drawer with Recessed Pull
    const wardDrawer = new THREE.Mesh(new THREE.BoxGeometry(0.76, 0.38, 0.015), woodMat);
    wardDrawer.position.set(0, -0.84, wardD / 2 + 0.008);
    const wardDrawerPull = new THREE.Mesh(new THREE.BoxGeometry(0.14, 0.05, 0.02), darkMetalMat);
    wardDrawerPull.position.set(0, -0.84, wardD / 2 + 0.02);
    wardrobeGroup.add(wardDrawer, wardDrawerPull);

    // ==========================================
    // 5. MARINE WINDOW WITH OCEAN VIEW & CURTAINS (LEFT)
    // ==========================================
    const winGroup = new THREE.Group();
    winGroup.position.set(-floorWidth / 2 + 0.05, 0.30, 0.12);
    cabinGroup.add(winGroup);

    // Window Casing Frame (White with rounded corners)
    const winCasing = new THREE.Mesh(new THREE.BoxGeometry(0.04, 1.08, 0.72), ceilingMat);
    winGroup.add(winCasing);

    // Ocean View Glass Pane
    const oceanPane = new THREE.Mesh(new THREE.PlaneGeometry(0.64, 0.98), oceanMat);
    oceanPane.position.set(0.022, 0, 0);
    oceanPane.rotation.y = Math.PI / 2;
    winGroup.add(oceanPane);

    // Top Green Ruffled Valance Pelmet
    const winValance = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.18, 0.78), curtainMat);
    winValance.position.set(0.03, 0.52, 0);
    winGroup.add(winValance);

    // Olive Green Drapery Curtain Tied Back on Right
    const winCurtain = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.07, 0.88, 16), curtainMat);
    winCurtain.position.set(0.04, -0.05, 0.32);
    const winTieback = new THREE.Mesh(new THREE.CylinderGeometry(0.072, 0.072, 0.045, 16), curtainTieMat);
    winTieback.position.set(0.04, -0.05, 0.32);
    winGroup.add(winCurtain, winTieback);

    // ==========================================
    // 6. STORAGE OTTOMAN / POUF BENCH (LEFT)
    // ==========================================
    const ottomanGroup = new THREE.Group();
    ottomanGroup.position.set(-floorWidth / 2 + 0.36, floorY + 0.24, 0.12);
    cabinGroup.add(ottomanGroup);

    const ottomanBody = new THREE.Mesh(new THREE.BoxGeometry(0.42, 0.42, 0.44), ottomanMat);
    const ottomanHandle = new THREE.Mesh(new THREE.CylinderGeometry(0.008, 0.008, 0.08, 12), stainlessMat);
    ottomanHandle.position.set(0.22, -0.08, 0);
    ottomanHandle.rotation.x = Math.PI / 2;
    ottomanGroup.add(ottomanBody, ottomanHandle);

    // ==========================================
    // 7. FOREGROUND SOFA CORNER (LEFT FOREGROUND)
    // ==========================================
    const sofaGroup = new THREE.Group();
    sofaGroup.position.set(-floorWidth / 2 + 0.32, floorY + 0.20, 0.85);
    cabinGroup.add(sofaGroup);

    const sofaArm = new THREE.Mesh(new THREE.BoxGeometry(0.36, 0.36, 0.44), sofaMat);
    const sofaPillow = new THREE.Mesh(new THREE.BoxGeometry(0.22, 0.22, 0.10), olivePillowMat);
    sofaPillow.position.set(0.08, 0.16, 0.04);
    sofaPillow.rotation.y = 0.25;
    sofaGroup.add(sofaArm, sofaPillow);

    // ==========================================
    // 8. ENTRY DOOR BULKHEAD (FAR RIGHT)
    // ==========================================
    const doorGroup = new THREE.Group();
    doorGroup.position.set(floorWidth / 2 - 0.03, 0.0, 0.32);
    cabinGroup.add(doorGroup);

    const doorLeaf = new THREE.Mesh(new THREE.BoxGeometry(0.03, 2.15, 0.48), ceilingMat);
    const doorLever = new THREE.Mesh(new THREE.BoxGeometry(0.015, 0.025, 0.14), stainlessMat);
    doorLever.position.set(-0.022, -0.06, -0.12);
    const cardReader = new THREE.Mesh(new THREE.BoxGeometry(0.015, 0.10, 0.05), darkMetalMat);
    cardReader.position.set(-0.022, 0.25, -0.15);
    const lightSwitch = new THREE.Mesh(new THREE.BoxGeometry(0.012, 0.12, 0.06), ceilingMat);
    lightSwitch.position.set(-0.022, 0.06, -0.15);
    const louverGrille = new THREE.Mesh(new THREE.BoxGeometry(0.012, 0.45, 0.26), darkMetalMat);
    louverGrille.position.set(-0.022, -0.78, 0);

    doorGroup.add(doorLeaf, doorLever, cardReader, lightSwitch, louverGrille);
  }

  animate() {
    if (!this.modal.classList.contains('open')) return;

    this.animId = requestAnimationFrame(() => this.animate());

    if (this.productGroup) {
      if (this.isAutoRotating && !this.isDragging) {
        this.productGroup.rotation.y += 0.006;
      }

      // Update HUD rotation angles
      const degY = Math.round((this.productGroup.rotation.y * 180 / Math.PI) % 360);
      const degX = Math.round((this.productGroup.rotation.x * 180 / Math.PI) % 360);
      if (this.angleHUD) {
        this.angleHUD.textContent = `Y-AXIS: ${degY}° | X-AXIS: ${degX}°`;
      }
      if (this.compassNeedle) {
        this.compassNeedle.style.transform = `rotate(${degY}deg)`;
      }
    }

    if (this.renderer && this.scene && this.camera) {
      this.renderer.render(this.scene, this.camera);
    }
  }

  onMouseDown(e) {
    this.isDragging = true;
    this.prevMousePos = { x: e.clientX, y: e.clientY };
  }

  onMouseMove(e) {
    if (!this.isDragging || !this.productGroup) return;

    const deltaX = e.clientX - this.prevMousePos.x;
    const deltaY = e.clientY - this.prevMousePos.y;

    this.productGroup.rotation.y += deltaX * 0.008;
    this.productGroup.rotation.x += deltaY * 0.008;

    // Clamp X rotation to prevent flipping
    this.productGroup.rotation.x = Math.max(-Math.PI / 3, Math.min(Math.PI / 3, this.productGroup.rotation.x));

    this.prevMousePos = { x: e.clientX, y: e.clientY };
  }

  onTouchStart(e) {
    if (e.touches.length === 1) {
      this.isDragging = true;
      this.prevMousePos = { x: e.touches[0].clientX, y: e.touches[0].clientY };
    }
  }

  onTouchMove(e) {
    if (!this.isDragging || e.touches.length !== 1 || !this.productGroup) return;
    e.preventDefault();
    const deltaX = e.touches[0].clientX - this.prevMousePos.x;
    const deltaY = e.touches[0].clientY - this.prevMousePos.y;

    this.productGroup.rotation.y += deltaX * 0.008;
    this.productGroup.rotation.x += deltaY * 0.008;
    this.productGroup.rotation.x = Math.max(-Math.PI / 3, Math.min(Math.PI / 3, this.productGroup.rotation.x));

    this.prevMousePos = { x: e.touches[0].clientX, y: e.touches[0].clientY };
  }

  onMouseUp() {
    this.isDragging = false;
  }

  adjustZoom(delta) {
    this.zoomLevel = Math.max(0.6, Math.min(2.0, this.zoomLevel + delta));
    if (this.camera) {
      this.camera.position.z = 4.4 / this.zoomLevel;
    }
    if (this.zoomText) {
      this.zoomText.textContent = `${Math.round(this.zoomLevel * 100)}%`;
    }
  }

  resetView() {
    this.zoomLevel = 1.0;
    if (this.camera) this.camera.position.set(0, 0, 4.4);
    if (this.productGroup) {
      if (this.currentProductId === 'wetunit') {
        this.productGroup.rotation.set(0.45, -0.40, 0);
      } else if (this.currentProductId === 'cabin') {
        this.productGroup.rotation.set(0.14, 0.26, 0);
      } else {
        this.productGroup.rotation.set(0.04, -0.28, 0);
      }
    }
    if (this.zoomText) this.zoomText.textContent = '100%';
  }

  toggleAutoRotate() {
    this.isAutoRotating = !this.isAutoRotating;
    if (this.autoRotateBtn) this.autoRotateBtn.classList.toggle('active', this.isAutoRotating);
    if (this.rotateBtnText) {
      this.rotateBtnText.textContent = this.isAutoRotating ? 'AUTO-ROTATE: ON' : 'AUTO-ROTATE: OFF';
    }
  }

  toggleWireframe() {
    this.isWireframe = !this.isWireframe;
    if (this.wireframeBtn) this.wireframeBtn.classList.toggle('active', this.isWireframe);
    this.buildProductModel(this.currentProductId);
  }

  toggleFullscreen() {
    if (!document.fullscreenElement) {
      this.modal.requestFullscreen().catch(() => {});
    } else {
      document.exitFullscreen().catch(() => {});
    }
  }

  onResize() {
    if (!this.viewport || !this.camera || !this.renderer) return;
    const width = this.viewport.clientWidth;
    const height = this.viewport.clientHeight;
    this.camera.aspect = width / height;
    this.camera.updateProjectionMatrix();
    this.renderer.setSize(width, height);
  }
}

// Auto-initialize when ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => new ProductInspector360());
} else {
  new ProductInspector360();
}
