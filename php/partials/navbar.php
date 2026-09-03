<?php
/**
 * SIMC — Vista Parcial: Navbar Principal
 */
?>
<header>
  <nav class="navbar" id="navbar" role="navigation" aria-label="Navegación principal">
    <div class="nav-inner">
      <a href="index.php" class="nav-logo" aria-label="Inicio de SIMC">
        <img src="img/logo.png" alt="Logo SIMC" class="nav-logo-icon" width="28" height="28" />
        <span class="logo-bracket">[</span>SIMC<span class="logo-bracket">]</span>
      </a>

      <ul class="nav-links" id="navLinks">
        <li><a href="#about">Sistema</a></li>
        <li><a href="#how-it-works">Cómo Funciona</a></li>
        <li><a href="#use-cases">Soluciones</a></li>
        <li><a href="#products">Membresías</a></li>
        <li><a href="#descargas">Descargas</a></li>
        <li><a href="#compare">Comparativa</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li><a href="#contact">Contacto</a></li>

        <li>
          <?php if ($loggedIn): ?>
            <?php if ($rol === 'admin'): ?>
              <a href="admin/dashboard.php" class="btn-login-nav" title="Ir al Panel de Administración">
                <i class="fas fa-gauge-high" aria-hidden="true"></i> <span><?= $username ?></span>
              </a>
            <?php else: ?>
              <span class="btn-login-nav" style="cursor:default;">
                <i class="fas fa-user" aria-hidden="true"></i> <span><?= $username ?></span>
              </span>
              <a href="php/logout.php" class="btn-login-nav" style="color:var(--red-no) !important; margin-left:6px;" title="Cerrar sesión" aria-label="Cerrar sesión">
                <i class="fas fa-right-from-bracket" aria-hidden="true"></i>
              </a>
            <?php endif; ?>
          <?php else: ?>
            <a href="#" class="btn-login-nav" id="openLogin" role="button" aria-haspopup="dialog">
              <i class="fas fa-user-lock" aria-hidden="true"></i>
              <span>Iniciar sesión</span>
            </a>
          <?php endif; ?>
        </li>
      </ul>

      <button class="nav-hamburger" id="hamburger" aria-label="Abrir menú de navegación" aria-expanded="false" aria-controls="navLinks">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
</header>
