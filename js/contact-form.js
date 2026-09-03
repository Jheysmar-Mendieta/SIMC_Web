(function () {
  'use strict';

  const form = document.getElementById('contactForm');
  const note = document.getElementById('formNote');
  if (!form) return;

  // Envío asíncrono del formulario de contacto
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn  = form.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    btn.disabled  = true;
    btn.innerHTML = '<span>Enviando...</span> <i class="fas fa-spinner fa-spin"></i>';
    note.className   = 'form-note';
    note.textContent = '';

    try {
      const res  = await fetch(BASE_URL + '/php/contacto.php', { method: 'POST', body: new FormData(form) });
      const json = await res.json();

      if (json.success) {
        note.textContent = '✓ ' + json.mensaje;
        note.classList.add('show', 'success');
        form.reset();
      } else {
        note.textContent = '✗ ' + (json.error || 'Error al enviar.');
        note.classList.add('show', 'error');
      }
    } catch {
      note.textContent = '✗ Error de red. Intentá de nuevo.';
      note.classList.add('show', 'error');
    }

    btn.innerHTML = orig;
    btn.disabled  = false;
    setTimeout(() => { note.textContent = ''; note.className = 'form-note'; }, 6000);
  });

})();