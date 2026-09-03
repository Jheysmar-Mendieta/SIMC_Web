'use strict';

function cerrarModales() {
  document.querySelectorAll('.admin-modal').forEach(m => m.classList.remove('active'));
}

function abrirModalUsuario() {
  const modal = document.getElementById('modalCrearUsuario');
  if (modal) modal.classList.add('active');
}

function abrirModalPass(userId, username) {
  const inputId = document.getElementById('passUserId');
  const labelUser = document.getElementById('passUsername');
  const modal = document.getElementById('modalPass');

  if (inputId) inputId.value = userId;
  if (labelUser) labelUser.textContent = username;
  if (modal) modal.classList.add('active');
}

function verConsulta(c) {
  const detNombre = document.getElementById('detNombre');
  const detEmail = document.getElementById('detEmail');
  const detFecha = document.getElementById('detFecha');
  const detMensaje = document.getElementById('detMensaje');
  const detReplyBtn = document.getElementById('detReplyBtn');
  const modal = document.getElementById('modalVerConsulta');

  if (detNombre) detNombre.textContent = c.nombre;
  if (detEmail) detEmail.textContent = c.email;
  if (detFecha) detFecha.textContent = 'Recibido: ' + c.creado_en;
  if (detMensaje) detMensaje.textContent = c.mensaje;
  if (detReplyBtn) {
    detReplyBtn.href = 'mailto:' + encodeURIComponent(c.email) + '?subject=' + encodeURIComponent('Respuesta de SIMC a tu consulta');
  }
  if (modal) modal.classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {

  // 1. Cerrar modales con Escape o clic exterior
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') cerrarModales();
  });

  document.querySelectorAll('.admin-modal').forEach(m => {
    m.addEventListener('click', (e) => {
      if (e.target === m) cerrarModales();
    });
  });

  // 2. Control de navegación móvil
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
  const adminSidebar = document.getElementById('adminSidebar');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  function toggleAdminSidebar(forceOpen) {
    if (!adminSidebar) return;
    const isOpen = forceOpen !== undefined ? forceOpen : !adminSidebar.classList.contains('open');
    adminSidebar.classList.toggle('open', isOpen);
    if (sidebarOverlay) sidebarOverlay.classList.toggle('active', isOpen);
    document.body.style.overflow = isOpen ? 'hidden' : '';
  }

  if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      toggleAdminSidebar(true);
    });
  }

  if (sidebarCloseBtn) {
    sidebarCloseBtn.addEventListener('click', (e) => {
      e.preventDefault();
      toggleAdminSidebar(false);
    });
  }

  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', () => toggleAdminSidebar(false));
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && adminSidebar && adminSidebar.classList.contains('open')) {
      toggleAdminSidebar(false);
    }
  });

  // 3. Ocultar notificación toast automáticamente
  setTimeout(() => {
    const toast = document.querySelector('.toast');
    if (toast) toast.style.display = 'none';
  }, 4000);

});
