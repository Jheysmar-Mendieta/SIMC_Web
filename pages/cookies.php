<?php
/**
 * SIMC — Política de Cookies & Almacenamiento Local (Modular)
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
  <title>Política de Cookies — SIMC</title>
  <meta name="description" content="Política de Cookies de SIMC. Información sobre el uso de cookies técnicas, de sesión y almacenamiento local." />
  
  <!-- Favicons Oficiales de SIMC -->
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
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
                <span class="btn-login-nav" style="cursor:default;">
                  <i class="fas fa-user"></i> <?= $username ?>
                </span>
                <a href="../php/logout.php" class="btn-login-nav" style="color:var(--red-no); margin-left:6px;" title="Cerrar sesión">
                  <i class="fas fa-right-from-bracket"></i>
                </a>
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
        <span>Política de Cookies</span>
      </div>

      <h1 class="legal-hero-title">Política de <span class="gradient-text">Cookies</span></h1>
      <p style="color:var(--text-muted); max-width:700px; font-size:1.02rem;">
        Transparencia total sobre las cookies técnicas, de sesión y tecnologías de almacenamiento local utilizadas en la plataforma SIMC.
      </p>

      <div class="legal-meta-bar">
        <div class="legal-meta-item"><i class="fas fa-calendar-check"></i><span>Última actualización: <strong>Agosto 2026</strong></span></div>
        <div class="legal-meta-item"><i class="fas fa-cookie-bite"></i><span>Tipo: <strong>Cookies Esenciales &amp; Seguridad</strong></span></div>
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
            <a href="#sec-1" class="legal-nav-link active">1. ¿Qué son las cookies?</a>
            <a href="#sec-2" class="legal-nav-link">2. Cookies que utiliza SIMC</a>
            <a href="#sec-3" class="legal-nav-link">3. Cookies de terceros</a>
            <a href="#sec-4" class="legal-nav-link">4. Almacenamiento Local (Local/SessionStorage)</a>
            <a href="#sec-5" class="legal-nav-link">5. Cómo administrar o desactivar</a>
            <a href="#sec-6" class="legal-nav-link">6. Contacto</a>
          </nav>
          <div class="legal-other-docs">
            <span class="legal-other-docs-title">Otros Documentos</span>
            <a href="privacidad.php" class="legal-other-link"><i class="fas fa-shield-halved"></i> Política de Privacidad</a>
            <a href="terminos.php" class="legal-other-link"><i class="fas fa-file-contract"></i> Términos de Uso</a>
          </div>
        </aside>

        <!-- Secciones -->
        <article class="legal-content">
          
          <section id="sec-1" class="legal-section">
            <h2>1. ¿Qué son las cookies?</h2>
            <p>
              Una cookie es un pequeño archivo de texto que un sitio web descarga en el navegador del usuario al visitarlo. Permite al sitio recordar información sobre la visita, como mantener la sesión iniciada, recordar preferencias o proteger la cuenta contra ataques informáticos.
            </p>
          </section>

          <section id="sec-2" class="legal-section">
            <h2>2. Cookies que utiliza SIMC</h2>
            <p>
              SIMC <strong>únicamente emplea cookies técnicas y estrictamente necesarias</strong> para el funcionamiento seguro de la plataforma, autenticación de usuarios y protección CSRF. <strong>No utilizamos cookies de publicidad ni redes de seguimiento invasivas.</strong>
            </p>
            <div class="legal-table-wrapper">
              <table class="legal-table">
                <thead>
                  <tr>
                    <th>Nombre de Cookie</th>
                    <th>Tipo</th>
                    <th>Finalidad</th>
                    <th>Duración</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><code>PHPSESSID</code></td>
                    <td>Técnica / Esencial</td>
                    <td>Identificador de sesión autenticada (HttpOnly, SameSite=Lax)</td>
                    <td>Sesión (2 horas de inactividad)</td>
                  </tr>
                  <tr>
                    <td><code>simc_csrf_token</code></td>
                    <td>Seguridad</td>
                    <td>Previene ataques de falsificación de peticiones en sitios cruzados</td>
                    <td>Sesión</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>

          <section id="sec-3" class="legal-section">
            <h2>3. Cookies de terceros</h2>
            <p>
              La plataforma web de SIMC se encuentra optimizada para no cargar rastreadores de terceros. Los recursos estáticos como fuentes e iconos provienen de CDNs públicas con políticas de sólo lectura.
            </p>
          </section>

          <section id="sec-4" class="legal-section">
            <h2>4. Almacenamiento Local (LocalStorage)</h2>
            <p>
              SIMC puede utilizar el almacenamiento local del navegador (<code>localStorage</code>) únicamente para guardar preferencias de interfaz del usuario (ej. preferencia de facturación mensual/anual o filtros activos en el panel administrativo).
            </p>
          </section>

          <section id="sec-5" class="legal-section">
            <h2>5. Cómo administrar o desactivar las cookies</h2>
            <p>
              Podés configurar tu navegador para bloquear o avisarte sobre estas cookies. Ten en cuenta que si deshabilitas las cookies de sesión, el inicio de sesión al panel de administración de SIMC no funcionará por razones técnicas y de seguridad.
            </p>
          </section>

          <section id="sec-6" class="legal-section">
            <h2>6. Contacto</h2>
            <div class="legal-contact-box">
              <h4><i class="fas fa-envelope"></i> ¿Dudas sobre cookies?</h4>
              <p>Escribinos a <strong>contacto@simc-ai.com</strong> y responderemos a la brevedad.</p>
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
        <p>Sistema Inteligente de Monitoreo de Concentración con IA y Visión Computacional.</p>
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
          <a href="terminos.php">Términos y Condiciones</a>
          <a href="cookies.php" style="color:var(--cyan);">Cookies</a>
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
