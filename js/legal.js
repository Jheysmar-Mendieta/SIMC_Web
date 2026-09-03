document.addEventListener('DOMContentLoaded', () => {
  const sections = document.querySelectorAll('.legal-section[id]');
  const navLinks = document.querySelectorAll('.legal-nav-link');
  const mobileSelect = document.getElementById('legalMobileSelect');
  const btnPrint = document.getElementById('btnPrintDoc');

  // Botón para imprimir documento
  if (btnPrint) {
    btnPrint.addEventListener('click', (e) => {
      e.preventDefault();
      window.print();
    });
  }

  // Resaltar sección activa al hacer scroll
  if ('IntersectionObserver' in window && sections.length > 0) {
    const observerOptions = {
      root: null,
      rootMargin: '-80px 0px -60% 0px',
      threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.getAttribute('id');
          navLinks.forEach(link => {
            if (link.getAttribute('href') === `#${id}`) {
              link.classList.add('active');
              link.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            } else {
              link.classList.remove('active');
            }
          });

          // Sincronizar select móvil
          if (mobileSelect) {
            mobileSelect.value = `#${id}`;
          }
        }
      });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
  }

  // Cambio de sección en selector móvil
  if (mobileSelect) {
    mobileSelect.addEventListener('change', (e) => {
      const targetId = e.target.value;
      if (targetId && targetId.startsWith('#')) {
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          const offsetTop = targetEl.getBoundingClientRect().top + window.pageYOffset - 90;
          window.scrollTo({
            top: offsetTop,
            behavior: 'smooth'
          });
        }
      }
    });
  }

  // Desplazamiento suave para enlaces del índice
  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        const targetEl = document.querySelector(href);
        if (targetEl) {
          const offsetTop = targetEl.getBoundingClientRect().top + window.pageYOffset - 90;
          window.scrollTo({
            top: offsetTop,
            behavior: 'smooth'
          });
          history.pushState(null, null, href);
        }
      }
    });
  });
});
