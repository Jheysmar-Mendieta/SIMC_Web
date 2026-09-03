(function () {
  const canvas = document.getElementById('heroCanvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let W, H, particles = [], animFrame;
  const isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const PARTICLE_COUNT = window.innerWidth < 768 ? 40 : 75;
  const MAX_DIST = 130;
  const SPEED = isReducedMotion ? 0 : 0.35;

  const COLOR_NODE = 'rgba(0, 242, 254, ';
  const COLOR_LINE = 'rgba(37, 99, 235, ';
  const COLOR_GLOW = 'rgba(0, 242, 254, ';

  function resize() {
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    W = canvas.offsetWidth;
    H = canvas.offsetHeight;
    canvas.width = W * dpr;
    canvas.height = H * dpr;
    ctx.scale(dpr, dpr);
  }

  class Particle {
    constructor() {
      this.reset();
    }

    reset() {
      this.x  = Math.random() * W;
      this.y  = Math.random() * H;
      this.vx = (Math.random() - 0.5) * SPEED;
      this.vy = (Math.random() - 0.5) * SPEED;
      this.r  = Math.random() * 1.8 + 1.2;
      this.alpha = Math.random() * 0.5 + 0.3;
      this.pulseSpeed = Math.random() * 0.02 + 0.01;
      this.pulsePhase = Math.random() * Math.PI * 2;
    }

    update() {
      if (isReducedMotion) return;
      this.x += this.vx;
      this.y += this.vy;

      if (this.x < 0 || this.x > W) this.vx *= -1;
      if (this.y < 0 || this.y > H) this.vy *= -1;

      this.pulsePhase += this.pulseSpeed;
      this.currentAlpha = this.alpha + Math.sin(this.pulsePhase) * 0.15;
    }

    draw() {
      const a = Math.max(0.1, Math.min(1, this.currentAlpha || this.alpha));

      // Resplandor del nodo
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r * 2.5, 0, Math.PI * 2);
      ctx.fillStyle = COLOR_GLOW + (a * 0.25) + ')';
      ctx.fill();

      // Nodo central
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
      ctx.fillStyle = COLOR_NODE + a + ')';
      ctx.fill();
    }
  }

  function init() {
    resize();
    particles = [];
    for (let i = 0; i < PARTICLE_COUNT; i++) {
      particles.push(new Particle());
    }
  }

  function drawLines() {
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < MAX_DIST) {
          const alpha = (1 - dist / MAX_DIST) * 0.35;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.strokeStyle = COLOR_LINE + alpha + ')';
          ctx.lineWidth = 0.8;
          ctx.stroke();
        }
      }
    }
  }

  function loop() {
    ctx.clearRect(0, 0, W, H);

    drawLines();

    for (let i = 0; i < particles.length; i++) {
      particles[i].update();
      particles[i].draw();
    }

    if (!isReducedMotion) {
      animFrame = requestAnimationFrame(loop);
    }
  }

  // Eventos de redimensionamiento
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      resize();
      init();
    }, 150);
  }, { passive: true });

  // Pausar render cuando la pestaña está en segundo plano
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      cancelAnimationFrame(animFrame);
    } else if (!isReducedMotion) {
      animFrame = requestAnimationFrame(loop);
    }
  });

  init();
  loop();

  // Soporte para cursor interactivo en hero
  let mouse = { x: -9999, y: -9999 };
  const heroSection = document.getElementById('hero');

  if (heroSection && !isReducedMotion) {
    heroSection.addEventListener('mousemove', (e) => {
      const rect = canvas.getBoundingClientRect();
      mouse.x = e.clientX - rect.left;
      mouse.y = e.clientY - rect.top;

      // Atraer partículas cercanas levemente hacia el cursor
      for (let p of particles) {
        const dx = mouse.x - p.x;
        const dy = mouse.y - p.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 100 && dist > 0) {
          const force = (100 - dist) / 100 * 0.04;
          p.x -= (dx / dist) * force * 15;
          p.y -= (dy / dist) * force * 15;
        }
      }
    }, { passive: true });

    heroSection.addEventListener('mouseleave', () => {
      mouse.x = -9999;
      mouse.y = -9999;
    });
  }

})();