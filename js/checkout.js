/**
 * SIMC — Pasarela de Pago y Generación de Licencias de Membresía
 */

let planSeleccionado = 'MEDIUM';
let periodoActual = 'monthly';
let tokenGeneradoActual = '';

const PRECIOS_PLANES = {
  BASIC: { mensual: 15, anual: 144, pcs: 'Hasta 10 PCs', nombre: 'Plan Basic' },
  MEDIUM: { mensual: 25, anual: 240, pcs: 'Hasta 20 PCs con IA', nombre: 'Plan Medium' },
  ENTERPRISE: { mensual: 60, anual: 576, pcs: '50+ PCs con IA Full', nombre: 'Plan Enterprise' }
};

function abrirCheckoutModal(plan) {
  planSeleccionado = (plan || 'MEDIUM').toUpperCase();

  // Detectar periodicidad activa en el switcher de precios
  const btnAnual = document.querySelector('.pricing-btn[data-period="annual"]');
  if (btnAnual && btnAnual.classList.contains('active')) {
    periodoActual = 'annual';
  } else {
    periodoActual = 'monthly';
  }

  const info = PRECIOS_PLANES[planSeleccionado] || PRECIOS_PLANES.MEDIUM;
  const esAnual = periodoActual === 'annual';
  const precioCobro = esAnual ? info.anual : info.mensual;
  const equivMes = esAnual ? Math.round(info.anual / 12) : info.mensual;
  const ahorro = (info.mensual * 12) - info.anual;

  // Actualizar UI del resumen
  const titleEl = document.getElementById('chk-plan-title');
  const badgeEl = document.getElementById('chk-plan-badge');
  const pcsEl = document.getElementById('chk-plan-pcs');
  const periodEl = document.getElementById('chk-plan-period');
  const amountEl = document.getElementById('chk-plan-amount');
  const unitEl = document.getElementById('chk-plan-period-unit');

  if (titleEl) titleEl.textContent = `${info.nombre} (${esAnual ? 'Anual' : 'Mensual'})`;
  if (badgeEl) badgeEl.textContent = `${planSeleccionado} ${esAnual ? 'ANUAL' : ''}`;
  if (pcsEl) pcsEl.textContent = info.pcs;
  if (periodEl) {
    periodEl.textContent = esAnual 
      ? `Facturación Anual (-20% OFF) · Equiv. $${equivMes}/mes (Ahorrás $${ahorro} USD)` 
      : 'Facturación Mensual';
  }
  if (amountEl) amountEl.textContent = precioCobro;
  if (unitEl) unitEl.textContent = esAnual ? '/ año' : '/ mes';

  // Resetear vistas
  const viewForm = document.getElementById('checkout-view-form');
  const viewSuccess = document.getElementById('checkout-view-success');
  const errBox = document.getElementById('chk-error-msg');

  if (viewForm) viewForm.classList.remove('hidden');
  if (viewSuccess) viewSuccess.classList.add('hidden');
  if (errBox) errBox.classList.add('hidden');

  const btnSubmit = document.getElementById('chk-btn-submit');
  const btnText = document.getElementById('chk-btn-text');
  if (btnSubmit) btnSubmit.disabled = false;
  if (btnText) btnText.textContent = `Pagar $${precioCobro} USD y Activar Membresía ${esAnual ? 'Anual' : ''}`;

  // Abrir Modal
  const modal = document.getElementById('checkout-modal');
  if (modal) {
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
}

function cerrarCheckoutModal() {
  const modal = document.getElementById('checkout-modal');
  if (modal) {
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
}

function formatearTarjeta(input) {
  let v = input.value.replace(/\D/g, '').slice(0, 16);
  let out = '';
  for (let i = 0; i < v.length; i++) {
    if (i > 0 && i % 4 === 0) out += ' ';
    out += v[i];
  }
  input.value = out;

  // Detección visual de marca
  const icon = document.getElementById('chk-card-brand-icon');
  if (!icon) return;

  if (v.startsWith('4')) {
    icon.className = 'fab fa-cc-visa chk-input-icon';
    icon.style.color = '#38bdf8';
  } else if (/^5[1-5]/.test(v) || /^2[2-7]/.test(v)) {
    icon.className = 'fab fa-cc-mastercard chk-input-icon';
    icon.style.color = '#f59e0b';
  } else if (/^3[47]/.test(v)) {
    icon.className = 'fab fa-cc-amex chk-input-icon';
    icon.style.color = '#10b981';
  } else {
    icon.className = 'fas fa-credit-card chk-input-icon';
    icon.style.color = '';
  }
}

function formatearVencimiento(input) {
  let v = input.value.replace(/\D/g, '').slice(0, 4);
  if (v.length >= 2) {
    input.value = v.slice(0, 2) + '/' + v.slice(2);
  } else {
    input.value = v;
  }
}

async function procesarPagoCheckout() {
  const titular = document.getElementById('chk-titular').value.trim();
  const email = document.getElementById('chk-email').value.trim();
  const numTarjeta = document.getElementById('chk-card-num').value.replace(/\s/g, '');
  const exp = document.getElementById('chk-exp').value.trim();
  const cvv = document.getElementById('chk-cvv').value.trim();
  const errBox = document.getElementById('chk-error-msg');
  const btnSubmit = document.getElementById('chk-btn-submit');
  const btnText = document.getElementById('chk-btn-text');

  if (errBox) errBox.classList.add('hidden');

  if (!titular || !email || numTarjeta.length < 13 || exp.length < 5 || cvv.length < 3) {
    if (errBox) {
      errBox.textContent = 'Por favor completá todos los datos de la tarjeta correctamente.';
      errBox.classList.remove('hidden');
    }
    return;
  }

  if (btnSubmit) btnSubmit.disabled = true;
  if (btnText) btnText.textContent = 'Procesando pago seguro...';

  try {
    const resp = await fetch('php/procesar_pago.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        plan: planSeleccionado,
        periodo: periodoActual,
        titular: titular,
        email: email,
        numero_tarjeta: numTarjeta,
        vencimiento: exp,
        cvv: cvv
      })
    });

    const data = await resp.json();

    if (data.success) {
      tokenGeneradoActual = data.token_licencia || '';

      // Guardar en localStorage para persistencia visual inmediata
      localStorage.setItem('simc_membresia_activa', JSON.stringify(data));
      actualizarTarjetasPrecios(data.plan, data.fecha_expiracion);

      // Cargar datos en la vista de éxito
      const sucBadge = document.getElementById('suc-plan-badge');
      const sucExp = document.getElementById('suc-plan-exp');
      const sucTitular = document.getElementById('suc-titular-display');
      const sucEmail = document.getElementById('suc-email-display');
      const sucInline = document.getElementById('suc-email-inline');
      const sucPcs = document.getElementById('suc-pcs-display');

      if (sucBadge) sucBadge.textContent = `MEMBRESÍA ${data.plan}`;
      if (sucExp) sucExp.textContent = `Válida hasta: ${data.fecha_expiracion}`;
      if (sucTitular) sucTitular.textContent = data.titular || titular;
      if (sucEmail) sucEmail.textContent = data.email || email;
      if (sucInline) sucInline.textContent = data.email || email;
      if (sucPcs) sucPcs.textContent = `${data.limite_pcs} PCs simultáneas`;

      // Cambiar de vista
      const viewForm = document.getElementById('checkout-view-form');
      const viewSuccess = document.getElementById('checkout-view-success');
      if (viewForm) viewForm.classList.add('hidden');
      if (viewSuccess) viewSuccess.classList.remove('hidden');
    } else {
      if (errBox) {
        errBox.textContent = data.error || 'Ocurrió un error al procesar el pago.';
        errBox.classList.remove('hidden');
      }
      if (btnSubmit) btnSubmit.disabled = false;
      if (btnText) btnText.textContent = 'Reintentar Pago';
    }
  } catch (e) {
    console.error('Error de red procesando pago:', e);
    if (errBox) {
      errBox.textContent = 'Error de conexión con el servidor de pagos. Intente nuevamente.';
      errBox.classList.remove('hidden');
    }
    if (btnSubmit) btnSubmit.disabled = false;
    if (btnText) btnText.textContent = 'Reintentar Pago';
  }
}

function copiarLicenciaGenerada() {
  if (!tokenGeneradoActual) return;

  navigator.clipboard.writeText(tokenGeneradoActual).then(() => {
    const btn = document.getElementById('btn-copy-lic');
    const text = document.getElementById('btn-copy-lic-text');
    if (text) text.textContent = '✓ COPIADO';
    if (btn) btn.style.background = '#10b981';

    setTimeout(() => {
      if (text) text.textContent = 'COPIAR';
      if (btn) btn.style.background = '';
    }, 2000);
  });
}

function actualizarTarjetasPrecios(planActivo, fechaExp, periodoActivo, periodoSitio) {
  if (!planActivo) return;
  planActivo = planActivo.toUpperCase();
  periodoActivo = (periodoActivo || 'monthly').toLowerCase();
  
  if (!periodoSitio) {
    const btnAnual = document.querySelector('.pricing-btn[data-period="annual"]');
    periodoSitio = (btnAnual && btnAnual.classList.contains('active')) ? 'annual' : 'monthly';
  }

  const cBasic = document.getElementById('card-plan-basic');
  const cMedium = document.getElementById('card-plan-medium');
  const cEnterprise = document.getElementById('card-plan-enterprise');

  const bBasic = document.getElementById('btn-container-basic');
  const bMedium = document.getElementById('btn-container-medium');
  const bEnterprise = document.getElementById('btn-container-enterprise');

  const badgeBasic = document.getElementById('badge-plan-basic');
  const badgeMedium = document.getElementById('badge-plan-medium');
  const badgeEnterprise = document.getElementById('badge-plan-enterprise');

  const expTexto = fechaExp ? `(${fechaExp})` : '';

  // Limpiar estados previos
  [cBasic, cMedium, cEnterprise].forEach(c => c && c.classList.remove('active-plan-card'));
  if (badgeBasic) { badgeBasic.className = 'card-badge'; badgeBasic.textContent = 'BÁSICO'; }
  if (badgeMedium) { badgeMedium.className = 'card-badge badge-featured'; badgeMedium.textContent = 'MÁS POPULAR'; }
  if (badgeEnterprise) { badgeEnterprise.className = 'card-badge'; badgeEnterprise.textContent = 'ENTERPRISE'; }

  const nivel = (planActivo === 'ENTERPRISE' || planActivo === 'PRO') ? 3 : (planActivo === 'MEDIUM' ? 2 : (planActivo === 'BASIC' ? 1 : 0));
  const esAnualSitio = periodoSitio === 'annual';
  const esAnualUsuario = periodoActivo === 'annual';

  // BASIC
  if (nivel === 1) {
    if (cBasic) cBasic.classList.add('active-plan-card');
    if (badgeBasic) { 
      badgeBasic.className = 'card-badge badge-active-plan'; 
      badgeBasic.textContent = esAnualUsuario ? '✓ TU PLAN ANUAL ACTIVO' : '✓ TU PLAN MENSUAL ACTIVO'; 
    }
    if (bBasic) {
      if (esAnualSitio && !esAnualUsuario) {
        bBasic.innerHTML = `<button type="button" class="btn btn-primary btn-upgrade-action" onclick="abrirCheckoutModal('BASIC')"><i class="fas fa-bolt"></i> <span>⚡ Cambiar a Anual ($144/año)</span></button>`;
      } else {
        bBasic.innerHTML = `<button type="button" class="btn btn-plan-status active-btn" disabled><i class="fas fa-check-circle"></i> <span>✓ Plan ${esAnualUsuario ? 'Anual' : 'Mensual'} Activo ${expTexto}</span></button>`;
      }
    }
    if (bMedium) bMedium.innerHTML = `<button type="button" class="btn btn-primary btn-upgrade-action" onclick="abrirCheckoutModal('MEDIUM')"><i class="fas fa-arrow-up"></i> <span>Mejorar a Medium ${esAnualSitio ? '($240/año)' : ''}</span></button>`;
    if (bEnterprise) bEnterprise.innerHTML = `<button type="button" class="btn btn-card btn-upgrade-action" onclick="abrirCheckoutModal('ENTERPRISE')"><i class="fas fa-crown"></i> <span>Mejorar a Enterprise ${esAnualSitio ? '($576/año)' : ''}</span></button>`;
  }
  // MEDIUM
  else if (nivel === 2) {
    if (cMedium) cMedium.classList.add('active-plan-card');
    if (badgeMedium) { 
      badgeMedium.className = 'card-badge badge-active-plan'; 
      badgeMedium.textContent = esAnualUsuario ? '✓ TU PLAN ANUAL ACTIVO' : '✓ TU PLAN MENSUAL ACTIVO'; 
    }
    if (bBasic) bBasic.innerHTML = `<button type="button" class="btn btn-plan-status included-btn" disabled><span>✓ Incluido en tu plan</span></button>`;
    if (bMedium) {
      if (esAnualSitio && !esAnualUsuario) {
        bMedium.innerHTML = `<button type="button" class="btn btn-primary btn-upgrade-action" onclick="abrirCheckoutModal('MEDIUM')"><i class="fas fa-bolt"></i> <span>⚡ Cambiar a Anual ($240/año)</span></button>`;
      } else {
        bMedium.innerHTML = `<button type="button" class="btn btn-plan-status active-btn" disabled><i class="fas fa-check-circle"></i> <span>✓ Plan ${esAnualUsuario ? 'Anual' : 'Mensual'} Activo ${expTexto}</span></button>`;
      }
    }
    if (bEnterprise) bEnterprise.innerHTML = `<button type="button" class="btn btn-card btn-upgrade-action" onclick="abrirCheckoutModal('ENTERPRISE')"><i class="fas fa-crown"></i> <span>Mejorar a Enterprise ${esAnualSitio ? '($576/año)' : ''}</span></button>`;
  }
  // ENTERPRISE
  else if (nivel === 3) {
    if (cEnterprise) cEnterprise.classList.add('active-plan-card');
    if (badgeEnterprise) { 
      badgeEnterprise.className = 'card-badge badge-active-plan'; 
      badgeEnterprise.textContent = esAnualUsuario ? '✓ TU PLAN ANUAL ACTIVO' : '✓ TU PLAN MENSUAL ACTIVO'; 
    }
    if (bBasic) bBasic.innerHTML = `<button type="button" class="btn btn-plan-status included-btn" disabled><span>✓ Incluido en tu plan</span></button>`;
    if (bMedium) bMedium.innerHTML = `<button type="button" class="btn btn-plan-status included-btn" disabled><span>✓ Incluido en tu plan</span></button>`;
    if (bEnterprise) {
      if (esAnualSitio && !esAnualUsuario) {
        bEnterprise.innerHTML = `<button type="button" class="btn btn-primary btn-upgrade-action" onclick="abrirCheckoutModal('ENTERPRISE')"><i class="fas fa-bolt"></i> <span>⚡ Cambiar a Anual ($576/año)</span></button>`;
      } else {
        bEnterprise.innerHTML = `<button type="button" class="btn btn-plan-status active-btn" disabled><i class="fas fa-crown"></i> <span>✓ Plan Enterprise ${esAnualUsuario ? 'Anual' : 'Mensual'} Activo ${expTexto}</span></button>`;
      }
    }
  }
}

// Exportar globalmente
window.abrirCheckoutModal = abrirCheckoutModal;
window.cerrarCheckoutModal = cerrarCheckoutModal;
window.formatearTarjeta = formatearTarjeta;
window.formatearVencimiento = formatearVencimiento;
window.procesarPagoCheckout = procesarPagoCheckout;
window.copiarLicenciaGenerada = copiarLicenciaGenerada;
window.actualizarTarjetasPrecios = actualizarTarjetasPrecios;

// Listener de inicio
document.addEventListener('DOMContentLoaded', () => {
  const serverData = window.USER_MEMBRESIA_SERVER;
  const savedLicense = localStorage.getItem('simc_membresia_activa') || localStorage.getItem('simc_user_session');
  
  if (serverData && serverData.plan) {
    actualizarTarjetasPrecios(serverData.plan, serverData.fecha_expiracion, serverData.periodo);
  } else if (savedLicense) {
    try {
      const data = JSON.parse(savedLicense);
      const m = data.membresia || data;
      if (m && (m.activa || m.plan)) {
        actualizarTarjetasPrecios(m.plan, m.fecha_expiracion, m.periodo);
      }
    } catch(e) {}
  }

  document.querySelectorAll('.btn-buy-plan').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const plan = btn.getAttribute('data-plan') || 'MEDIUM';
      abrirCheckoutModal(plan);
    });
  });
});

// Cerrar con Escape o clic fuera
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') cerrarCheckoutModal();
});

document.addEventListener('click', (e) => {
  const modal = document.getElementById('checkout-modal');
  if (modal && e.target === modal) {
    cerrarCheckoutModal();
  }
});
