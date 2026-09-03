<!-- Modal de Checkout y Pago de Membresía -->
<div class="checkout-modal-overlay" id="checkout-modal" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="checkout-modal-card">
    
    <!-- Botón Cerrar -->
    <button type="button" class="checkout-close-btn" onclick="cerrarCheckoutModal()" aria-label="Cerrar ventana">✕</button>

    <!-- VISTA 1: FORMULARIO DE PAGO -->
    <div id="checkout-view-form">
      <div class="checkout-header">
        <div class="checkout-eyebrow">// pasarela segura de pago</div>
        <h3 class="checkout-title">Comprar <span class="gradient-text" id="chk-plan-title">Membresía Medium</span></h3>
        <p class="checkout-subtitle">Completá los datos para procesar tu suscripción y obtener tu clave de licencia instantánea.</p>
      </div>

      <!-- Resumen de Compra -->
      <div class="checkout-order-summary">
        <div class="summary-plan-badge" id="chk-plan-badge">PLAN MEDIUM</div>
        <div class="summary-details">
          <span class="summary-pcs" id="chk-plan-pcs">Hasta 20 PCs con IA</span>
          <span class="summary-period" id="chk-plan-period">Facturación Mensual</span>
        </div>
        <div class="summary-price">
          <span class="currency">$</span><span class="amount" id="chk-plan-amount">25</span><span class="period" id="chk-plan-period-unit">/mes</span>
        </div>
      </div>

      <!-- Formulario de Tarjeta -->
      <form id="checkout-form" class="checkout-form" onsubmit="event.preventDefault(); procesarPagoCheckout();">
        
        <!-- Nombre del Titular -->
        <div class="chk-form-group">
          <label for="chk-titular">Nombre y Apellido del Titular</label>
          <div class="chk-input-wrap">
            <i class="fas fa-user chk-input-icon" aria-hidden="true"></i>
            <input type="text" id="chk-titular" placeholder="Ej: Juan Pérez" required autocomplete="cc-name">
          </div>
        </div>

        <!-- Email para recibir Licencia -->
        <div class="chk-form-group">
          <label for="chk-email">Correo Electrónico (para tu licencia)</label>
          <div class="chk-input-wrap">
            <i class="fas fa-envelope chk-input-icon" aria-hidden="true"></i>
            <input type="email" id="chk-email" placeholder="tu-email@colegio.edu" required autocomplete="email">
          </div>
        </div>

        <!-- Número de Tarjeta -->
        <div class="chk-form-group">
          <label for="chk-card-num">Número de Tarjeta de Crédito / Débito</label>
          <div class="chk-input-wrap">
            <i class="fas fa-credit-card chk-input-icon" id="chk-card-brand-icon" aria-hidden="true"></i>
            <input type="text" id="chk-card-num" placeholder="4000 1234 5678 9010" maxlength="19" required autocomplete="cc-number" oninput="formatearTarjeta(this)">
          </div>
        </div>

        <!-- Fila Vencimiento y CVV -->
        <div class="chk-form-row">
          <div class="chk-form-group">
            <label for="chk-exp">Vencimiento</label>
            <div class="chk-input-wrap">
              <input type="text" id="chk-exp" placeholder="MM/YY" maxlength="5" required autocomplete="cc-exp" oninput="formatearVencimiento(this)">
            </div>
          </div>
          <div class="chk-form-group">
            <label for="chk-cvv">Código CVV</label>
            <div class="chk-input-wrap">
              <input type="password" id="chk-cvv" placeholder="•••" maxlength="4" required autocomplete="cc-csc">
              <i class="fas fa-lock chk-input-icon-right" aria-hidden="true" title="Código de seguridad al dorso"></i>
            </div>
          </div>
        </div>

        <!-- Badge de Seguridad PCI -->
        <div class="chk-security-badge">
          <i class="fas fa-shield-alt" aria-hidden="true"></i>
          <span>Transacción cifrada SSL de 256 bits. <strong>No almacenamos tus datos bancarios</strong>.</span>
        </div>

        <!-- Botón de Pago -->
        <button type="submit" class="btn btn-primary chk-submit-btn" id="chk-btn-submit">
          <i class="fas fa-lock" aria-hidden="true"></i>
          <span id="chk-btn-text">Pagar y Obtener Licencia</span>
        </button>

        <div id="chk-error-msg" class="chk-alert-danger hidden"></div>
      </form>
    </div>

    <!-- VISTA 2: ÉXITO Y CONFIRMACIÓN DE MEMBRESÍA VINCULADA -->
    <div id="checkout-view-success" class="hidden">
      <div class="checkout-success-header">
        <div class="success-icon-ring"><i class="fas fa-check"></i></div>
        <h3 class="checkout-title" style="color:#10b981;">¡PAGO COMPLETADO!</h3>
        <p class="checkout-subtitle">Tu membresía fue activada exitosamente y quedó vinculada a tu cuenta de usuario.</p>
      </div>

      <!-- Tarjeta de Membresía Activada -->
      <div class="license-token-card" style="border: 1px solid #10b981; background: rgba(16, 185, 129, 0.06);">
        <div class="license-token-header">
          <span class="license-tag" id="suc-plan-badge" style="background:#10b981; color:#030712; font-weight:bold;">MEMBRESÍA MEDIUM</span>
          <span class="license-validity" id="suc-plan-exp" style="color:#a7f3d0;">Válida por 30 días</span>
        </div>

        <div style="background: rgba(3, 7, 18, 0.6); padding: 14px; border-radius: 8px; margin: 12px 0; border: 1px solid rgba(16, 185, 129, 0.2);">
          <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
            <i class="fas fa-user-check" style="color:#10b981; font-size:18px;"></i>
            <div>
              <div style="font-size:11px; color:#94a3b8; text-transform:uppercase; font-family:'Share Tech Mono', monospace;">Cuenta Vinculada:</div>
              <strong id="suc-email-display" style="color:#fff; font-size:14px;">usuario@gmail.com</strong>
            </div>
          </div>
          <div style="font-size:12px; color:#cbd5e1; display:flex; justify-content:space-between; border-top:1px dashed rgba(255,255,255,0.1); padding-top:8px; margin-top:6px;">
            <span>Capacidad Desbloqueada:</span>
            <strong id="suc-pcs-display" style="color:#00f2fe;">20 PCs con IA</strong>
          </div>
        </div>
      </div>

      <!-- Instrucciones de Uso -->
      <div class="license-instructions">
        <h4><i class="fas fa-info-circle"></i> ¿Cómo usar tu membresía?</h4>
        <ol>
          <li>Abrí la aplicación <strong>SIMC Supervisor</strong> en tu computadora o celular.</li>
          <li>Tocá en <strong>"👤 Iniciar Sesión"</strong> e ingresá con tu cuenta (<strong id="suc-email-inline" style="color:#00f2fe;">tu-email</strong>).</li>
          <li>¡Listo! Tus computadoras y funciones quedarán <strong>activadas automáticamente</strong> sin necesidad de ingresar tokens.</li>
        </ol>
      </div>

      <div class="checkout-actions-row">
        <button type="button" class="btn btn-primary" onclick="cerrarCheckoutModal()">
          <span>✓ Finalizar y Continuar</span>
        </button>
      </div>
    </div>

  </div>
</div>
