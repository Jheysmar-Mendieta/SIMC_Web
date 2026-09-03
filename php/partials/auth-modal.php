<div class="modal-overlay" id="authModal">
  <div class="modal-card">

    <button class="modal-close" id="closeAuth" aria-label="Cerrar">
      <i class="fas fa-times"></i>
    </button>

    <div class="modal-logo">
      <span class="logo-bracket">[</span>SIMC<span class="logo-bracket">]</span>
    </div>

    <!-- Pestañas de acceso -->
    <div class="modal-tabs">
      <button class="modal-tab active" data-tab="login">
        <i class="fas fa-right-to-bracket"></i> Iniciar sesión
      </button>
      <button class="modal-tab" data-tab="register">
        <i class="fas fa-user-plus"></i> Crear cuenta
      </button>
    </div>

    <!-- Panel de inicio de sesión -->
    <div class="modal-panel active" id="panel-login">
      <p class="modal-sub">Accedé al panel de monitoreo</p>
      <div class="form-msg" id="loginMsg"></div>
      <form id="loginForm" autocomplete="on">
        <div class="form-group">
          <label for="loginUser">Usuario o email</label>
          <div class="input-icon">
            <i class="fas fa-user"></i>
            <input type="text" id="loginUser" name="username"
                   placeholder="usuario o tu@email.com" required autocomplete="username" />
          </div>
        </div>
        <div class="form-group">
          <label for="loginPass">Contraseña</label>
          <div class="input-icon">
            <i class="fas fa-lock"></i>
            <input type="password" id="loginPass" name="password"
                   placeholder="••••••••" required autocomplete="current-password" />
            <button type="button" class="toggle-pass" data-target="loginPass">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <div class="form-row">
          <label class="checkbox-label">
            <input type="checkbox" name="remember" /><span>Recordarme</span>
          </label>
          <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
        </div>
        <button type="submit" class="btn btn-primary btn-full" id="loginBtn">
          <span>Acceder</span>
          <i class="fas fa-arrow-right"></i>
        </button>
      </form>
      <p class="modal-footer-text">
        ¿No tenés cuenta?
        <a href="#" class="switch-link" data-switch="register">Registrate gratis</a>
      </p>
    </div>

    <!-- Panel de registro -->
    <div class="modal-panel" id="panel-register">
      <p class="modal-sub">Creá tu acceso al sistema SIMC</p>
      <div class="form-msg" id="registerMsg"></div>
      <form id="registerForm" autocomplete="off">
        <div class="form-group">
          <label for="regUser">Nombre de usuario</label>
          <div class="input-icon">
            <i class="fas fa-at"></i>
            <input type="text" id="regUser" name="username"
                   placeholder="mi_usuario" required
                   minlength="3" maxlength="40"
                   pattern="[a-zA-Z0-9_\.]+"
                   title="Solo letras, números, puntos y guiones bajos"
                   autocomplete="username" />
          </div>
        </div>
        <div class="form-group">
          <label for="regEmail">Correo electrónico</label>
          <div class="input-icon">
            <i class="fas fa-envelope"></i>
            <input type="email" id="regEmail" name="email"
                   placeholder="tu@email.com" required autocomplete="email" />
          </div>
        </div>
        <div class="form-group">
          <label for="regPass">Contraseña</label>
          <div class="input-icon">
            <i class="fas fa-lock"></i>
            <input type="password" id="regPass" name="password"
                   placeholder="Mínimo 8 caracteres" required
                   minlength="8" autocomplete="new-password" />
            <button type="button" class="toggle-pass" data-target="regPass">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="strength-bar" id="strengthBar">
            <span></span><span></span><span></span><span></span>
          </div>
          <p class="strength-label" id="strengthLabel"></p>
        </div>
        <div class="form-group">
          <label for="regConfirm">Repetir contraseña</label>
          <div class="input-icon">
            <i class="fas fa-lock"></i>
            <input type="password" id="regConfirm" name="confirm"
                   placeholder="••••••••" required autocomplete="new-password" />
            <button type="button" class="toggle-pass" data-target="regConfirm">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <div class="form-group" style="margin-top: 1rem; margin-bottom: 1.25rem;">
          <label class="checkbox-label" style="align-items: flex-start; margin-bottom: 8px;">
            <input type="checkbox" id="regTerms" name="accept_terms" required style="margin-top: 4px;" />
            <span style="font-size: 0.82rem; line-height: 1.4;">
              He leído y acepto los <a href="pages/terminos.php" target="_blank" rel="noopener noreferrer" style="color: var(--cyan); text-decoration: underline;">Términos y Condiciones</a>.
            </span>
          </label>
          <label class="checkbox-label" style="align-items: flex-start;">
            <input type="checkbox" id="regPrivacy" name="accept_privacy" required style="margin-top: 4px;" />
            <span style="font-size: 0.82rem; line-height: 1.4;">
              He leído la <a href="pages/privacidad.php" target="_blank" rel="noopener noreferrer" style="color: var(--cyan); text-decoration: underline;">Política de Privacidad</a>.
            </span>
          </label>
        </div>
        <button type="submit" class="btn btn-primary btn-full" id="registerBtn">
          <span>Crear cuenta</span>
          <i class="fas fa-user-plus"></i>
        </button>
      </form>
      <p class="modal-footer-text">
        ¿Ya tenés cuenta?
        <a href="#" class="switch-link" data-switch="login">Iniciá sesión</a>
      </p>
    </div>

  </div>
</div>