<?php
/**
 * SIMC — Términos y Condiciones de Uso (Modular)
 */

require_once __DIR__ . '/../php/conexion.php';
start_session();

$loggedIn = is_logged_in();
$username = $loggedIn ? htmlspecialchars($_SESSION['username']) : '';
$rol = $loggedIn ? ($_SESSION['rol'] ?? '') : '';
$baseUrl = get_base_url();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Términos y Condiciones de Uso — SIMC</title>
  <meta name="description" content="Términos y Condiciones de Uso de SIMC. Reglas de utilización del software, suscripciones y responsabilidades." />
  
  <!-- Favicons Oficiales de SIMC -->
  <link rel="icon" type="image/x-icon" href="../favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png" />

  <link rel="stylesheet" href="../css/main.css?v=<?= filemtime(__DIR__ . '/../css/main.css') ?>"/>
  <link rel="stylesheet" href="../css/legal.css?v=<?= filemtime(__DIR__ . '/../css/legal.css') ?>"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Syne:wght@400;500;600;700&family=JetBrains+Mono:wght@300;400;500&display=swap" rel="stylesheet" />
</head>
<body>

  <!-- Barra de navegación -->
  <header>
    <nav class="navbar" id="navbar">
      <div class="nav-inner">
        <a href="../index.php" class="nav-logo">
          <span class="logo-bracket">[</span>SIMC<span class="logo-bracket">]</span>
        </a>
        <ul class="nav-links" id="navLinks">
          <li><a href="../index.php#about">Sistema</a></li>
          <li><a href="../index.php#how-it-works">Cómo Funciona</a></li>
          <li><a href="../index.php#products">Membresías</a></li>
          <li><a href="../index.php#compare">Comparativa</a></li>
          <li><a href="../index.php#faq">FAQ</a></li>
          <li><a href="../index.php#contact">Contacto</a></li>
          <li>
            <?php if ($loggedIn): ?>
              <?php if ($rol === 'admin'): ?>
                <a href="../admin/dashboard.php" class="btn-login-nav" title="Ir al Panel de Administración">
                  <i class="fas fa-gauge-high"></i> <?= $username ?>
                </a>
              <?php else: ?>
                <span class="btn-login-nav" style="cursor:default;"><i class="fas fa-user"></i> <?= $username ?></span>
                <a href="../php/logout.php" class="btn-login-nav" style="color:var(--red-no); margin-left:6px;" title="Cerrar sesión"><i class="fas fa-right-from-bracket"></i></a>
              <?php endif; ?>
            <?php else: ?>
              <a href="../index.php" class="btn-login-nav">Iniciar sesión</a>
            <?php endif; ?>
          </li>
        </ul>
        <button class="nav-hamburger" id="hamburger" aria-label="Abrir Menú">
          <span></span><span></span><span></span>
        </button>
      </div>
    </nav>
  </header>

  <!-- Encabezado de página -->
  <header class="legal-hero">
    <div class="container">
      <div class="legal-breadcrumbs">
        <a href="../index.php"><i class="fas fa-home"></i> Inicio</a>
        <i class="fas fa-chevron-right" style="font-size:0.65rem;"></i>
        <span>Términos y Condiciones</span>
      </div>

      <h1 class="legal-hero-title">Términos y <span class="gradient-text">Condiciones</span></h1>
      <p style="color:var(--text-muted); max-width:720px; font-size:1.02rem;">
        Condiciones de licencia, responsabilidades de uso ético del software y reglas del servicio SIMC PRO.
      </p>

      <div class="legal-meta-bar">
        <div class="legal-meta-item"><i class="fas fa-calendar-check"></i><span>Última actualización: <strong>Agosto 2026</strong></span></div>
        <div class="legal-meta-item"><i class="fas fa-file-contract"></i><span>Versión: <strong>SIMC Terms v2.4</strong></span></div>
        <div class="legal-actions">
          <button type="button" class="btn-legal-action" onclick="window.print()"><i class="fas fa-print"></i> Imprimir</button>
          <a href="privacidad.php" class="btn-legal-action"><i class="fas fa-shield-halved"></i> Privacidad</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Contenido principal -->
  <main class="legal-body-section">
    <div class="container">
      <div class="legal-layout">

        <!-- Menú lateral -->
        <aside class="legal-sidebar">
          <div class="legal-sidebar-header">
            <span class="legal-sidebar-title"><i class="fas fa-list-ul"></i> Índice</span>
          </div>
          <nav class="legal-nav-list">
            <a href="#sec-1" class="legal-nav-link active">1. Aceptación de Términos</a>
            <a href="#sec-2" class="legal-nav-link">2. Descripción del Software</a>
            <a href="#sec-3" class="legal-nav-link">3. Licencia de Uso</a>
            <a href="#sec-4" class="legal-nav-link">4. Uso Aceptable y Ético</a>
            <a href="#sec-5" class="legal-nav-link">5. Membresías y Pagos</a>
            <a href="#sec-6" class="legal-nav-link">6. Responsabilidad</a>
            <a href="#sec-7" class="legal-nav-link">7. Contacto Legal</a>
          </nav>
          <div class="legal-other-docs">
            <span class="legal-other-docs-title">Otros Documentos</span>
            <a href="privacidad.php" class="legal-other-link"><i class="fas fa-shield-halved"></i> Política de Privacidad</a>
            <a href="cookies.php" class="legal-other-link"><i class="fas fa-cookie-bite"></i> Política de Cookies</a>
          </div>
        </aside>

        <!-- Secciones -->
        <article class="legal-content">
          
          <section id="sec-1" class="legal-section">
            <h2>1. Aceptación de Términos</h2>
            <p>
              Al descargar, instalar o utilizar la plataforma web, el agente cliente o la aplicación móvil de SIMC, el usuario o la institución contratante acepta quedar legalmente vinculado por estos Términos y Condiciones.
            </p>
          </section>

          <section id="sec-2" class="legal-section">
            <h2>2. Descripción del Software</h2>
            <p>
              SIMC es una solución tecnológica compuesta por un agente cliente de escritorio, un panel administrativo de supervisión y una app móvil, orientada al monitoreo de concentración asistido por Inteligencia Artificial y Visión Computacional.
            </p>
          </section>

          <section id="sec-3" class="legal-section">
            <h2>3. Licencia de Uso</h2>
            <p>
              SIMC concede a los usuarios una licencia de software limitada, no exclusiva, intransferible y revocable para utilizar el software según el plan de membresía contratado (Basic, Medium, Enterprise).
            </p>
          </section>

          <section id="sec-4" class="legal-section">
            <h2>4. Uso Aceptable y Ético</h2>
            <p>
              El software debe utilizarse estrictamente con fines pedagógicos, de supervisión académica, laboral o de control parental, respetando la legislación vigente en materia de protección de datos y consentimiento informado.
            </p>
          </section>

          <section id="sec-5" class="legal-section">
            <h2>5. Membresías, Facturación y Cancelación</h2>
            <p>
              Las membresías pueden contratarse bajo la modalidad mensual o anual (con descuento del 20% OFF). Las suscripciones se renuevan automáticamente salvo cancelación previa por parte del administrador de la cuenta.
            </p>
          </section>

          <section id="sec-6" class="legal-section">
            <h2>6. Limitación de Responsabilidad</h2>
            <p>
              SIMC proporciona herramientas de apoyo basadas en modelos probabilísticos de Inteligencia Artificial (YOLOv8) con alta precisión, pero no reemplaza el criterio humano ni garantiza la infalibilidad en entornos no calibrados.
            </p>
          </section>

          <section id="sec-7" class="legal-section">
            <h2>7. Contacto Legal</h2>
            <div class="legal-contact-box">
              <h4><i class="fas fa-envelope"></i> Departamento Legal SIMC</h4>
              <p>Para consultas legales o contractuales, escribí a <strong>legal@simc-ai.com</strong>.</p>
            </div>
          </section>

        </article>
      </div>
    </div>
  </main>

  <!-- Pie de página -->
  <footer class="footer">
    <div class="footer-inner container">
      <div class="footer-brand">
        <a href="../index.php" class="nav-logo"><span class="logo-bracket">[</span>SIMC<span class="logo-bracket">]</span></a>
        <p>Sistema Inteligente de Monitoreo de Concentración.</p>
      </div>
      <div class="footer-links">
        <div class="footer-col">
          <h5>Navegación</h5>
          <a href="../index.php#about">Sistema</a>
          <a href="../index.php#products">Membresías</a>
          <a href="../index.php#contact">Contacto</a>
        </div>
        <div class="footer-col">
          <h5>Legal</h5>
          <a href="privacidad.php">Privacidad</a>
          <a href="terminos.php" style="color:var(--cyan);">Términos y Condiciones</a>
          <a href="cookies.php">Cookies</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <?= date('Y') ?> SIMC. Desarrollado en Argentina. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="../js/main.js"></script>
</body>
</html>
