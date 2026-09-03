'use strict';

document.addEventListener('DOMContentLoaded', () => {

  // 1. Estado del navbar al hacer scroll
  const navbar = document.getElementById('navbar');

  function handleNavScroll() {
    if (!navbar) return;
    if (window.scrollY > 20) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', handleNavScroll, { passive: true });
  handleNavScroll();

  // 2. Control de navegación móvil
  const hamburger = document.getElementById('hamburger');
  const navLinks  = document.getElementById('navLinks');

  if (hamburger && navLinks) {
    function toggleMenu(forceState) {
      const isCurrentlyOpen = navLinks.classList.contains('open');
      const shouldOpen = forceState !== undefined ? forceState : !isCurrentlyOpen;

      hamburger.classList.toggle('open', shouldOpen);
      navLinks.classList.toggle('open', shouldOpen);
      hamburger.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');

      if (shouldOpen) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    }

    hamburger.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      toggleMenu();
    });

    // Cerrar al pulsar un enlace de navegación
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        toggleMenu(false);
      });
    });

    // Cerrar si se presiona fuera del menú en mobile
    document.addEventListener('click', (e) => {
      if (navLinks.classList.contains('open') && !navLinks.contains(e.target) && !hamburger.contains(e.target)) {
        toggleMenu(false);
      }
    });

    // Cerrar con la tecla Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && navLinks.classList.contains('open')) {
        toggleMenu(false);
        hamburger.focus();
      }
    });
  }

  // 3. Selector de membresías (Mensual / Anual)
  const billingBtns = document.querySelectorAll('.pricing-btn');
  const priceElements = document.querySelectorAll('[data-price-monthly]');
  const periodLabels = document.querySelectorAll('.price-period');

  function updateBilling(period) {
    billingBtns.forEach(btn => {
      const isActive = btn.dataset.period === period;
      btn.classList.toggle('active', isActive);
      btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });

    priceElements.forEach(el => {
      const targetVal = period === 'annual' 
        ? el.dataset.priceAnnual 
        : el.dataset.priceMonthly;

      el.style.opacity = '0';
      setTimeout(() => {
        el.textContent = targetVal;
        el.style.opacity = '1';
      }, 150);
    });

    periodLabels.forEach(lbl => {
      lbl.textContent = period === 'annual' ? '/ mes (fact. anual)' : '/ mes';
    });

    // Sincronizar botones de estado con la periodicidad seleccionada
    if (typeof window.actualizarTarjetasPrecios === 'function') {
      const serverData = window.USER_MEMBRESIA_SERVER;
      const savedLicense = localStorage.getItem('simc_membresia_activa') || localStorage.getItem('simc_user_session');
      
      if (serverData && serverData.plan) {
        window.actualizarTarjetasPrecios(serverData.plan, serverData.fecha_expiracion, serverData.periodo, period);
      } else if (savedLicense) {
        try {
          const data = JSON.parse(savedLicense);
          const m = data.membresia || data;
          if (m && (m.activa || m.plan)) {
            window.actualizarTarjetasPrecios(m.plan, m.fecha_expiracion, m.periodo, period);
          }
        } catch(e) {}
      }
    }
  }

  billingBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      updateBilling(btn.dataset.period);
    });
  });

  // 4. Acordeón de preguntas frecuentes (FAQ)
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const trigger = item.querySelector('.faq-trigger');
    const panel = item.querySelector('.faq-panel');

    if (trigger && panel) {
      trigger.addEventListener('click', () => {
        const isActive = item.classList.contains('active');

        // Cerrar los demás
        faqItems.forEach(otherItem => {
          if (otherItem !== item) {
            otherItem.classList.remove('active');
            const otherTrigger = otherItem.querySelector('.faq-trigger');
            const otherPanel = otherItem.querySelector('.faq-panel');
            if (otherTrigger) otherTrigger.setAttribute('aria-expanded', 'false');
            if (otherPanel) otherPanel.style.maxHeight = null;
          }
        });

        // Alternar el actual
        if (isActive) {
          item.classList.remove('active');
          trigger.setAttribute('aria-expanded', 'false');
          panel.style.maxHeight = null;
        } else {
          item.classList.add('active');
          trigger.setAttribute('aria-expanded', 'true');
          panel.style.maxHeight = panel.scrollHeight + 'px';
        }
      });
    }
  });

  // 5. Animación de scroll reveal
  const revealEls = document.querySelectorAll('.reveal');

  if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, {
      threshold: 0.08,
      rootMargin: '0px 0px -30px 0px'
    });

    revealEls.forEach(el => revealObserver.observe(el));
  } else {
    revealEls.forEach(el => el.classList.add('visible'));
  }

  // 6. Contadores numéricos animados
  const statNums = document.querySelectorAll('.stat-num[data-target]');

  function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-target'), 10);
    if (isNaN(target)) return;
    const duration = 1400;
    const start = performance.now();

    function step(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.round(ease * target);
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

  if ('IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.dataset.counted) {
          entry.target.dataset.counted = 'true';
          animateCounter(entry.target);
        }
      });
    }, { threshold: 0.5 });

    statNums.forEach(el => counterObserver.observe(el));
  } else {
    statNums.forEach(el => {
      el.textContent = el.getAttribute('data-target');
    });
  }

  // 7. Desplazamiento suave para enlaces
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (!href || href === '#' || href.startsWith('#open') || href.startsWith('#close')) return;
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const offset = 80;
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  // 8. Efecto ripple al hacer clic en botones
  document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const ripple = document.createElement('span');
      ripple.classList.add('ripple');
      const rect = btn.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      ripple.style.cssText = `
        width: ${size}px;
        height: ${size}px;
        left: ${e.clientX - rect.left - size / 2}px;
        top:  ${e.clientY - rect.top  - size / 2}px;
      `;
      btn.appendChild(ripple);
      setTimeout(() => ripple.remove(), 600);
    });
  });

  // 9. Marcar enlace activo según sección visible
  const sections = document.querySelectorAll('section[id]');
  const navAnchors = document.querySelectorAll('.nav-links a[href^="#"]');

  if ('IntersectionObserver' in window && sections.length > 0) {
    const sectionObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          navAnchors.forEach(a => a.classList.remove('active'));
          const active = document.querySelector(`.nav-links a[href="#${entry.target.id}"]`);
          if (active) active.classList.add('active');
        }
      });
    }, {
      threshold: 0.3,
      rootMargin: '-80px 0px -40% 0px'
    });

    sections.forEach(s => sectionObserver.observe(s));
  }

});