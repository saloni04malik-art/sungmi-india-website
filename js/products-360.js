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
    this.camera.position.set(0, 0, 5.5);

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

    // Lighting Setup
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
    this.scene.add(ambientLight);

    const dirLight1 = new THREE.DirectionalLight(0xffffff, 1.2);
    dirLight1.position.set(5, 8, 5);
    dirLight1.castShadow = true;
    this.scene.add(dirLight1);

    const dirLight2 = new THREE.DirectionalLight(0x38bdf8, 0.6);
    dirLight2.position.set(-5, -2, -3);
    this.scene.add(dirLight2);

    const rimLight = new THREE.DirectionalLight(0x84cc16, 0.4);
    rimLight.position.set(0, 5, -5);
    this.scene.add(rimLight);

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

    // Init 3D Scene
    setTimeout(() => {
      this.initThree();
      this.buildProductModel(productId);
      this.resetView();
      this.onResize();
      this.animate();
    }, 50);
  }

  close() {
    if (!this.modal) return;
    this.modal.classList.remove('open');
    this.modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (this.animId) cancelAnimationFrame(this.animId);
  }

  buildProductModel(productId) {
    if (!this.productGroup) return;

    // Clear previous model
    while (this.productGroup.children.length > 0) {
      const obj = this.productGroup.children[0];
      if (obj.geometry) obj.geometry.dispose();
      if (obj.material) {
        if (Array.isArray(obj.material)) obj.material.forEach(m => m.dispose());
        else obj.material.dispose();
      }
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
    const steelMat = new THREE.MeshStandardMaterial({ color: 0x334155, roughness: 0.35, metalness: 0.8, wireframe });
    const darkSteelMat = new THREE.MeshStandardMaterial({ color: 0x1e293b, roughness: 0.5, metalness: 0.6, wireframe });
    const chromeMat = new THREE.MeshStandardMaterial({ color: 0xe2e8f0, roughness: 0.15, metalness: 0.95, wireframe });
    const glassMat = new THREE.MeshStandardMaterial({ color: 0x38bdf8, roughness: 0.1, metalness: 0.9, transparent: true, opacity: 0.6, wireframe });

    // Outer Door Frame
    const frameGeo = new THREE.BoxGeometry(2.4, 3.8, 0.25);
    const frame = new THREE.Mesh(frameGeo, darkSteelMat);
    this.productGroup.add(frame);

    // Inner Door Leaf
    const leafGeo = new THREE.BoxGeometry(2.0, 3.4, 0.18);
    const leaf = new THREE.Mesh(leafGeo, steelMat);
    leaf.position.z = 0.04;
    this.productGroup.add(leaf);

    // Circular Porthole Bezel
    const ringGeo = new THREE.CylinderGeometry(0.45, 0.45, 0.08, 32);
    ringGeo.rotateX(Math.PI / 2);
    const ring = new THREE.Mesh(ringGeo, chromeMat);
    ring.position.set(0, 0.6, 0.16);
    this.productGroup.add(ring);

    // Vision Glass
    const glassGeo = new THREE.CylinderGeometry(0.35, 0.35, 0.04, 32);
    glassGeo.rotateX(Math.PI / 2);
    const glass = new THREE.Mesh(glassGeo, glassMat);
    glass.position.set(0, 0.6, 0.17);
    this.productGroup.add(glass);

    // Heavy Marine Hinges (3 units)
    [-1.2, 0, 1.2].forEach(y => {
      const hingeGeo = new THREE.CylinderGeometry(0.06, 0.06, 0.3, 16);
      const hinge = new THREE.Mesh(hingeGeo, chromeMat);
      hinge.position.set(-1.12, y, 0.1);
      this.productGroup.add(hinge);
    });

    // Lever Handle & Lock Plate
    const plateGeo = new THREE.BoxGeometry(0.14, 0.5, 0.03);
    const plate = new THREE.Mesh(plateGeo, chromeMat);
    plate.position.set(0.75, -0.2, 0.14);
    this.productGroup.add(plate);

    const handleGeo = new THREE.BoxGeometry(0.25, 0.05, 0.05);
    const handle = new THREE.Mesh(handleGeo, chromeMat);
    handle.position.set(0.78, -0.15, 0.2);
    this.productGroup.add(handle);

    // Hydraulic Door Closer at top
    const closerGeo = new THREE.BoxGeometry(0.6, 0.12, 0.12);
    const closer = new THREE.Mesh(closerGeo, darkSteelMat);
    closer.position.set(0, 1.55, 0.18);
    this.productGroup.add(closer);
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
    const podMat = new THREE.MeshStandardMaterial({ color: 0x1e293b, roughness: 0.5, metalness: 0.5, wireframe });
    const interiorMat = new THREE.MeshStandardMaterial({ color: 0xf8fafc, roughness: 0.2, metalness: 0.2, wireframe });
    const chromeMat = new THREE.MeshStandardMaterial({ color: 0xe2e8f0, roughness: 0.1, metalness: 0.95, wireframe });
    const glassMat = new THREE.MeshStandardMaterial({ color: 0x38bdf8, transparent: true, opacity: 0.45, roughness: 0.1, wireframe });

    // Outer Pod Enclosure (Cutaway Front & Top)
    const backWall = new THREE.Mesh(new THREE.BoxGeometry(2.6, 2.6, 0.1), podMat);
    backWall.position.z = -1.25;
    const leftWall = new THREE.Mesh(new THREE.BoxGeometry(0.1, 2.6, 2.6), podMat);
    leftWall.position.x = -1.25;
    const floor = new THREE.Mesh(new THREE.BoxGeometry(2.6, 0.1, 2.6), podMat);
    floor.position.y = -1.25;

    this.productGroup.add(backWall, leftWall, floor);

    // Shower Glass Partition
    const glassScreen = new THREE.Mesh(new THREE.BoxGeometry(0.04, 2.2, 1.2), glassMat);
    glassScreen.position.set(0.1, -0.15, 0.2);
    this.productGroup.add(glassScreen);

    // Shower Column & Head
    const column = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, 1.8, 16), chromeMat);
    column.position.set(-0.9, 0, -1.1);
    const head = new THREE.Mesh(new THREE.CylinderGeometry(0.18, 0.18, 0.04, 24), chromeMat);
    head.position.set(-0.7, 0.85, -1.1);
    this.productGroup.add(column, head);

    // Marine WC Toilet Unit
    const toiletBase = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.18, 0.45, 20), interiorMat);
    toiletBase.position.set(0.7, -1.0, -0.7);
    const toiletSeat = new THREE.Mesh(new THREE.BoxGeometry(0.4, 0.06, 0.46), interiorMat);
    toiletSeat.position.set(0.7, -0.75, -0.7);
    this.productGroup.add(toiletBase, toiletSeat);

    // Vanity Sink & Mirror
    const vanity = new THREE.Mesh(new THREE.BoxGeometry(0.5, 0.35, 0.4), interiorMat);
    vanity.position.set(0.7, -0.4, 0.5);
    const mirror = new THREE.Mesh(new THREE.BoxGeometry(0.4, 0.7, 0.03), chromeMat);
    mirror.position.set(0.7, 0.25, 0.7);
    this.productGroup.add(vanity, mirror);
  }

  buildCabinModel(wireframe) {
    const wallMat = new THREE.MeshStandardMaterial({ color: 0x334155, roughness: 0.6, metalness: 0.3, wireframe });
    const woodMat = new THREE.MeshStandardMaterial({ color: 0xa16207, roughness: 0.5, metalness: 0.1, wireframe });
    const bedMat = new THREE.MeshStandardMaterial({ color: 0xe2e8f0, roughness: 0.8, metalness: 0.1, wireframe });
    const frameMat = new THREE.MeshStandardMaterial({ color: 0x1e293b, roughness: 0.3, metalness: 0.8, wireframe });

    // Cabin Floor & Back/Side Insulated Shell
    const floor = new THREE.Mesh(new THREE.BoxGeometry(3.6, 0.12, 2.8), frameMat);
    floor.position.y = -1.2;
    const backWall = new THREE.Mesh(new THREE.BoxGeometry(3.6, 2.4, 0.1), wallMat);
    backWall.position.set(0, 0, -1.35);
    const leftWall = new THREE.Mesh(new THREE.BoxGeometry(0.1, 2.4, 2.8), wallMat);
    leftWall.position.set(-1.75, 0, 0);

    this.productGroup.add(floor, backWall, leftWall);

    // Fitted Marine Bunk Bed
    const bedBase = new THREE.Mesh(new THREE.BoxGeometry(1.3, 0.45, 2.2), woodMat);
    bedBase.position.set(-0.95, -0.95, 0.1);
    const mattress = new THREE.Mesh(new THREE.BoxGeometry(1.2, 0.2, 2.1), bedMat);
    mattress.position.set(-0.95, -0.65, 0.1);
    const pillow = new THREE.Mesh(new THREE.BoxGeometry(0.8, 0.12, 0.4), bedMat);
    pillow.position.set(-0.95, -0.5, -0.7);
    this.productGroup.add(bedBase, mattress, pillow);

    // Study Desk & Storage Locker
    const desk = new THREE.Mesh(new THREE.BoxGeometry(0.75, 0.7, 1.1), woodMat);
    desk.position.set(0.35, -0.85, -0.65);
    const wardrobe = new THREE.Mesh(new THREE.BoxGeometry(0.7, 2.0, 0.8), woodMat);
    wardrobe.position.set(1.2, 0.1, -0.8);
    this.productGroup.add(desk, wardrobe);

    // Ceiling Beams with Downlights
    const ceilingBeam = new THREE.Mesh(new THREE.BoxGeometry(3.6, 0.08, 0.2), frameMat);
    ceilingBeam.position.set(0, 1.15, 0);
    this.productGroup.add(ceilingBeam);
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
      this.camera.position.z = 5.5 / this.zoomLevel;
    }
    if (this.zoomText) {
      this.zoomText.textContent = `${Math.round(this.zoomLevel * 100)}%`;
    }
  }

  resetView() {
    this.zoomLevel = 1.0;
    if (this.camera) this.camera.position.set(0, 0, 5.5);
    if (this.productGroup) this.productGroup.rotation.set(0.15, -0.35, 0);
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
