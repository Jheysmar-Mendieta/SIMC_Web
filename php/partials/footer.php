<?php
/**
 * SIMC — Vista Parcial: Footer y Créditos
 */
?>
<footer class="footer">
  <div class="footer-inner container">
    <div class="footer-brand">
      <a href="index.php" class="nav-logo" aria-label="SIMC Inicio">
        <img src="img/logo.png" alt="Logo SIMC" class="nav-logo-icon" width="28" height="28" />
        <span class="logo-bracket">[</span>SIMC<span class="logo-bracket">]</span>
      </a>
      <p>Sistema Inteligente de Monitoreo de Concentración impulsado por Inteligencia Artificial y Visión por Computadora.</p>
      
      <div class="footer-trust-badges">
        <div class="trust-badge-item">
          <i class="fas fa-lock" aria-hidden="true"></i>
          <span>Cifrado de Telemetría AES-256</span>
        </div>
        <div class="trust-badge-item">
          <i class="fas fa-shield-halved" aria-hidden="true"></i>
          <span>Procesamiento Local en Tiempo Real</span>
        </div>
      </div>
    </div>

    <div class="footer-links">
      <div class="footer-col">
        <h5>Navegación</h5>
        <a href="#about">Sistema</a>
        <a href="#how-it-works">Cómo Funciona</a>
        <a href="#use-cases">Soluciones</a>
        <a href="#products">Membresías</a>
        <a href="#descargas">Descargas</a>
        <a href="#compare">Comparativa</a>
        <a href="#faq">FAQ</a>
        <a href="#contact">Contacto</a>
      </div>

      <div class="footer-col">
        <h5>Legal</h5>
        <a href="pages/privacidad.php">Privacidad</a>
        <a href="pages/terminos.php">Términos y Condiciones</a>
        <a href="pages/cookies.php">Cookies</a>
      </div>
    </div>

    <div class="footer-social-wrapper">
      <h5>Conectar</h5>
      <div class="footer-social-icons">
        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
        <a href="#" aria-label="GitHub"><i class="fab fa-github" aria-hidden="true"></i></a>
        <a href="#" aria-label="Twitter"><i class="fab fa-x-twitter" aria-hidden="true"></i></a>
        <a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© <?= date('Y') ?> SIMC. Desarrollado en Argentina. Todos los derechos reservados.</p>
  </div>
</footer>
