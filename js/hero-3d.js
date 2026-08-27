/**
 * SUNGMI INDIA - CINEMATIC LIVING MARINE ENGINE
 * Combines high-resolution cinematic marine rendering with dynamic WebGL
 * ocean water simulation, realistic buoyancy floating dynamics, wake trails,
 * atmospheric depth, and interactive camera choreography.
 */

class LivingMarineHero {
  constructor(canvasId) {
    this.canvas = document.getElementById(canvasId);
    if (!this.canvas) return;

    this.clock = new THREE.Clock();

    // Interaction states
    this.mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
    this.scrollProgress = 0;
    this.targetScrollProgress = 0;

    this.scene = null;
    this.camera = null;
    this.renderer = null;
    this.waterMesh = null;
    this.shipPlane = null;
    this.particles = null;

    this.init();
  }

  init() {
    this.createScene();
    this.createCamera();
    this.createRenderer();
    this.createLighting();
    this.createLivingEnvironment();
    this.bindEvents();
    this.animate();

    setTimeout(() => {
      const loader = document.getElementById('scene-loader');
      if (loader) loader.classList.add('loaded');
    }, 250);
  }

  createScene() {
    this.scene = new THREE.Scene();
    this.scene.background = new THREE.Color(0x080d16);
    this.scene.fog = new THREE.FogExp2(0x0a1424, 0.008);
  }

  createCamera() {
    const aspect = window.innerWidth / window.innerHeight;
    this.camera = new THREE.PerspectiveCamera(42, aspect, 0.1, 1000);
    this.baseCamPos = new THREE.Vector3(0, 0, 24);
    this.camera.position.copy(this.baseCamPos);
    this.camera.lookAt(new THREE.Vector3(0, 0, 0));
  }

  createRenderer() {
    this.renderer = new THREE.WebGLRenderer({
      canvas: this.canvas,
      antialias: true,
      powerPreference: 'high-performance',
      alpha: false
    });
    this.renderer.setSize(window.innerWidth, window.innerHeight);
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
    this.renderer.toneMappingExposure = 1.15;
  }

  createLighting() {
    // Ambient oceanic light
    const ambientLight = new THREE.AmbientLight(0x2a3e5c, 1.6);
    this.scene.add(ambientLight);

    // Warm Sunset Key Light (matching reference image)
    const sunsetLight = new THREE.DirectionalLight(0xffb74d, 2.8);
    sunsetLight.position.set(30, 10, 20);
    this.scene.add(sunsetLight);

    // Deep Navy Fill Light
    const fillLight = new THREE.DirectionalLight(0x1e3a8a, 1.8);
    fillLight.position.set(-30, 20, -10);
    this.scene.add(fillLight);
  }

  createLivingEnvironment() {
    const textureLoader = new THREE.TextureLoader();

    // 1. Photographic Mega-Vessel Hero Layer
    textureLoader.load('assets/hero_ship_cinematic.jpg', (texture) => {
      texture.generateMipmaps = true;
      texture.minFilter = THREE.LinearMipmapLinearFilter;

      // Create curved cinematic backdrop mesh
      const planeGeo = new THREE.PlaneGeometry(42, 23.6, 64, 64);
      
      // Custom vertex shader for living water displacement & ship buoyancy
      const customMaterial = new THREE.ShaderMaterial({
        uniforms: {
          uTexture: { value: texture },
          uTime: { value: 0 },
          uMouse: { value: new THREE.Vector2(0, 0) },
          uScroll: { value: 0 }
        },
        vertexShader: `
          uniform float uTime;
          uniform vec2 uMouse;
          uniform float uScroll;
          varying vec2 vUv;
          varying float vWaterIntensity;

          void main() {
            vUv = uv;
            vec3 pos = position;

            // Water Region (Lower third of image where ocean swells exist)
            float waterMask = smoothstep(0.55, 0.05, uv.y);

            // Multi-harmonic ocean wave ripples
            float wave1 = sin(pos.x * 0.8 + uTime * 2.2) * cos(pos.y * 1.2 + uTime * 1.8) * 0.28;
            float wave2 = sin(pos.x * 1.6 - uTime * 1.5 + pos.y * 0.9) * 0.15;
            float wave3 = cos(pos.x * 2.8 + uTime * 3.0) * 0.08;

            float totalWaterWave = (wave1 + wave2 + wave3) * waterMask;
            pos.z += totalWaterWave;
            pos.y += totalWaterWave * 0.35;

            // Natural Vessel Buoyancy Physics (Gentle ship pitch & heave)
            float shipHeave = sin(uTime * 1.2) * 0.18;
            float shipPitch = sin(uTime * 0.95) * 0.08 * (pos.x / 20.0);
            float shipRoll = cos(uTime * 0.85) * 0.06 * (pos.y / 10.0);

            // Apply buoyancy across the whole vessel
            pos.y += shipHeave;
            pos.z += shipPitch + shipRoll;

            // Interactive Parallax shift
            pos.x += uMouse.x * 0.6 * (1.0 - uv.y * 0.3);
            pos.y += -uMouse.y * 0.4 * (1.0 - uv.y * 0.3);

            vWaterIntensity = waterMask * abs(wave1 + wave2);

            gl_Position = projectionMatrix * modelViewMatrix * vec4(pos, 1.0);
          }
        `,
        fragmentShader: `
          uniform sampler2D uTexture;
          uniform float uTime;
          varying vec2 vUv;
          varying float vWaterIntensity;

          void main() {
            vec2 uv = vUv;

            // Refractive water displacement ripples on lower ocean section
            float waterMask = smoothstep(0.52, 0.08, uv.y);
            if (waterMask > 0.01) {
              float rippleX = sin(uv.y * 60.0 + uTime * 3.5) * 0.0035 * waterMask;
              float rippleY = cos(uv.x * 45.0 + uTime * 2.8) * 0.0045 * waterMask;
              uv += vec2(rippleX, rippleY);
            }

            vec4 color = texture2D(uTexture, uv);

            // Subtle golden sunset caustics glinting on water wave crests
            if (waterMask > 0.05) {
              float glint = pow(max(0.0, sin(uv.x * 50.0 + uTime * 2.5) * cos(uv.y * 70.0 + uTime * 2.0)), 4.0);
              vec3 sunGlintColor = vec3(1.0, 0.82, 0.45) * glint * 0.45 * waterMask;
              color.rgb += sunGlintColor;
            }

            gl_FragColor = color;
          }
        `
      });

      this.shipPlane = new THREE.Mesh(planeGeo, customMaterial);
      this.shipPlane.position.set(0, 0, 0);
      this.scene.add(this.shipPlane);
    });

    // 2. Atmospheric Golden Dusk / Oceanic Mist Particles
    const particleCount = 200;
    const pGeo = new THREE.BufferGeometry();
    const pPos = new Float32Array(particleCount * 3);

    for (let i = 0; i < particleCount; i++) {
      pPos[i * 3] = (Math.random() - 0.5) * 38;
      pPos[i * 3 + 1] = (Math.random() - 0.5) * 20;
      pPos[i * 3 + 2] = Math.random() * 8 + 2;
    }

    pGeo.setAttribute('position', new THREE.BufferAttribute(pPos, 3));

    const pMat = new THREE.PointsMaterial({
      color: 0xfed7aa,
      size: 0.25,
      transparent: true,
      opacity: 0.35,
      blending: THREE.AdditiveBlending
    });

    this.particles = new THREE.Points(pGeo, pMat);
    this.scene.add(this.particles);
  }

  bindEvents() {
    window.addEventListener('mousemove', (e) => {
      this.mouse.targetX = (e.clientX / window.innerWidth - 0.5) * 2;
      this.mouse.targetY = (e.clientY / window.innerHeight - 0.5) * 2;
    });

    window.addEventListener('touchmove', (e) => {
      if (e.touches.length > 0) {
        this.mouse.targetX = (e.touches[0].clientX / window.innerWidth - 0.5) * 2;
        this.mouse.targetY = (e.touches[0].clientY / window.innerHeight - 0.5) * 2;
      }
    }, { passive: true });

    window.addEventListener('scroll', () => {
      this.targetScrollProgress = Math.min(1, Math.max(0, window.scrollY / (window.innerHeight * 0.8)));
    }, { passive: true });

    window.addEventListener('resize', () => this.onResize());
  }

  onResize() {
    if (!this.camera || !this.renderer) return;
    this.camera.aspect = window.innerWidth / window.innerHeight;
    this.camera.updateProjectionMatrix();
    this.renderer.setSize(window.innerWidth, window.innerHeight);
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  }

  animate() {
    requestAnimationFrame(() => this.animate());

    const elapsed = this.clock.getElapsedTime();

    // Lerp mouse parallax
    this.mouse.x += (this.mouse.targetX - this.mouse.x) * 0.045;
    this.mouse.y += (this.mouse.targetY - this.mouse.y) * 0.045;
    this.scrollProgress += (this.targetScrollProgress - this.scrollProgress) * 0.06;

    // Update custom shader uniforms for fluid water movement
    if (this.shipPlane && this.shipPlane.material.uniforms) {
      this.shipPlane.material.uniforms.uTime.value = elapsed;
      this.shipPlane.material.uniforms.uMouse.value.set(this.mouse.x, this.mouse.y);
      this.shipPlane.material.uniforms.uScroll.value = this.scrollProgress;
    }

    // Camera choreography
    this.camera.position.x = this.baseCamPos.x + this.mouse.x * 0.8;
    this.camera.position.y = this.baseCamPos.y - this.mouse.y * 0.6 - this.scrollProgress * 2.0;
    this.camera.position.z = this.baseCamPos.z - this.scrollProgress * 3.5;
    this.camera.lookAt(new THREE.Vector3(0, -this.scrollProgress * 1.5, 0));

    // Drift particles
    if (this.particles) {
      const pos = this.particles.geometry.attributes.position;
      for (let i = 0; i < pos.count; i++) {
        pos.array[i * 3] += 0.012;
        if (pos.array[i * 3] > 20) pos.array[i * 3] = -20;
      }
      pos.needsUpdate = true;
    }

    this.renderer.render(this.scene, this.camera);
  }
}

function initLivingHero() {
  if (!window.livingMarineHero && document.getElementById('hero-canvas')) {
    window.livingMarineHero = new LivingMarineHero('hero-canvas');
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initLivingHero);
} else {
  initLivingHero();
}
