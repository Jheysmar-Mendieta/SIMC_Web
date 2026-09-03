(function () {
  'use strict';

  const overlay  = document.getElementById('authModal');
  const closeBtn = document.getElementById('closeAuth');
  if (!overlay) return;

  // Abrir y cerrar modal
  function openModal(tab) {
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    switchTab(tab || 'login');
  }

  function closeModal() {
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  document.getElementById('openLogin')
    ?.addEventListener('click', (e) => { e.preventDefault(); openModal('login'); });
  document.getElementById('openRegister')
    ?.addEventListener('click', (e) => { e.preventDefault(); openModal('register'); });

  closeBtn.addEventListener('click', closeModal);
  overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

  // Control de pestañas (Login / Registro)
  const tabs   = document.querySelectorAll('.modal-tab');
  const panels = document.querySelectorAll('.modal-panel');

  function switchTab(name) {
    tabs.forEach(t   => t.classList.toggle('active', t.dataset.tab === name));
    panels.forEach(p => p.classList.toggle('active', p.id === 'panel-' + name));
    clearMsgs();
  }

  tabs.forEach(t => t.addEventListener('click', () => switchTab(t.dataset.tab)));
  document.querySelectorAll('.switch-link').forEach(l =>
    l.addEventListener('click', (e) => { e.preventDefault(); switchTab(l.dataset.switch); })
  );

  // Notificaciones y mensajes de error/éxito
  function clearMsgs() {
    ['loginMsg', 'registerMsg'].forEach(id => {
      const el = document.getElementById(id);
      el.className = 'form-msg';
      el.textContent = '';
    });
  }

  function showMsg(id, type, text) {
    const el = document.getElementById(id);
    el.className = 'form-msg ' + type;
    el.textContent = text;
  }

  // Ver / ocultar contraseña
  document.querySelectorAll('.toggle-pass').forEach(btn => {
    btn.addEventListener('click', () => {
      const input  = document.getElementById(btn.dataset.target);
      const icon   = btn.querySelector('i');
      const isPass = input.type === 'password';
      input.type   = isPass ? 'text' : 'password';
      icon.className = isPass ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
  });

  // Indicador de seguridad de contraseña
  const regPassInput = document.getElementById('regPass');
  const strengthBar  = document.getElementById('strengthBar');
  const strengthLbl  = document.getElementById('strengthLabel');
  const strengthMap  = { weak: 'Débil', fair: 'Regular', good: 'Buena', strong: 'Muy segura' };

  function calcStrength(pw) {
    let s = 0;
    if (pw.length >= 8)  s++;
    if (pw.length >= 12) s++;
    if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) s++;
    if (/[0-9]/.test(pw)) s++;
    if (/[^A-Za-z0-9]/.test(pw)) s++;
    return ['weak', 'weak', 'fair', 'good', 'strong', 'strong'][s] || 'weak';
  }

  regPassInput?.addEventListener('input', () => {
    const val = regPassInput.value;
    if (!val) {
      strengthBar.className = 'strength-bar';
      strengthLbl.className = 'strength-label';
      strengthLbl.textContent = '';
      return;
    }
    const level = calcStrength(val);
    strengthBar.className   = 'strength-bar ' + level;
    strengthLbl.className   = 'strength-label ' + level;
    strengthLbl.textContent = strengthMap[level];
  });

  // Estado de carga en botones
  function setLoading(btn, loading, label, icon) {
    btn.disabled = loading;
    btn.innerHTML = loading
      ? `<span>${label}</span> <i class="fas fa-spinner fa-spin"></i>`
      : `<span>${label}</span> <i class="fas ${icon}"></i>`;
  }

  // Envío del formulario de Login
  const loginForm = document.getElementById('loginForm');
  const loginBtn  = document.getElementById('loginBtn');

  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    clearMsgs();
    setLoading(loginBtn, true, 'Accediendo...');

    try {
      const res  = await fetch(BASE_URL + '/php/login.php', { method: 'POST', body: new FormData(loginForm) });
      const json = await res.json();

      if (json.success) {
        showMsg('loginMsg', 'success', '¡Bienvenido! Redirigiendo...');
        loginBtn.innerHTML = '<span>¡Bienvenido!</span> <i class="fas fa-check"></i>';
        setTimeout(() => window.location.href = json.redirect, 700);
      } else {
        showMsg('loginMsg', 'error', json.error || 'Credenciales incorrectas.');
        setLoading(loginBtn, false, 'Acceder', 'fa-arrow-right');
      }
    } catch {
      showMsg('loginMsg', 'error', 'Error de red. Intentá de nuevo.');
      setLoading(loginBtn, false, 'Acceder', 'fa-arrow-right');
    }
  });

  // Envío del formulario de Registro
  const registerForm = document.getElementById('registerForm');
  const registerBtn  = document.getElementById('registerBtn');

  registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    clearMsgs();

    if (document.getElementById('regPass').value !== document.getElementById('regConfirm').value) {
      showMsg('registerMsg', 'error', 'Las contraseñas no coinciden.');
      return;
    }

    const regTerms = document.getElementById('regTerms');
    const regPrivacy = document.getElementById('regPrivacy');
    if ((regTerms && !regTerms.checked) || (regPrivacy && !regPrivacy.checked)) {
      showMsg('registerMsg', 'error', 'Debés aceptar los Términos y Condiciones y la Política de Privacidad para registrarte.');
      return;
    }

    setLoading(registerBtn, true, 'Creando cuenta...');

    try {
      const res  = await fetch(BASE_URL + '/php/registro.php', { method: 'POST', body: new FormData(registerForm) });
      const json = await res.json();

      if (json.success) {
        showMsg('registerMsg', 'success', json.mensaje);
        registerForm.reset();
        strengthBar.className  = 'strength-bar';
        strengthLbl.textContent = '';
        setLoading(registerBtn, false, 'Crear cuenta', 'fa-user-plus');
        setTimeout(() => switchTab('login'), 1600);
      } else {
        showMsg('registerMsg', 'error', json.error || 'Error al registrarse.');
        setLoading(registerBtn, false, 'Crear cuenta', 'fa-user-plus');
      }
    } catch {
      showMsg('registerMsg', 'error', 'Error de red. Intentá de nuevo.');
      setLoading(registerBtn, false, 'Crear cuenta', 'fa-user-plus');
    }
  });

})();