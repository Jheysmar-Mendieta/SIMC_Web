<?php
/**
 * SIMC — Política de Privacidad & Protección de Datos (Modular)
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
  <title>Política de Privacidad — SIMC</title>
  <meta name="description" content="Política de Privacidad de SIMC (Sistema Inteligente de Monitoreo de Concentración). Tratamiento ético y no invasivo de datos." />
  
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
        <span>Política de Privacidad</span>
      </div>

      <h1 class="legal-hero-title">Política de <span class="gradient-text">Privacidad</span></h1>
      <p style="color:var(--text-muted); max-width:720px; font-size:1.02rem;">
        En SIMC protegemos la privacidad mediante inferencia matemática local sin almacenamiento continuo de video.
      </p>

      <div class="legal-meta-bar">
        <div class="legal-meta-item"><i class="fas fa-calendar-check"></i><span>Última actualización: <strong>Agosto 2026</strong></span></div>
        <div class="legal-meta-item"><i class="fas fa-shield-halved"></i><span>Estándar: <strong>Inferencia Edge &amp; AES-256</strong></span></div>
        <div class="legal-actions">
          <button type="button" class="btn-legal-action" onclick="window.print()"><i class="fas fa-print"></i> Imprimir</button>
          <a href="terminos.php" class="btn-legal-action"><i class="fas fa-file-contract"></i> Términos</a>
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
            <a href="#sec-1" class="legal-nav-link active">1. Principios Fundamentales</a>
            <a href="#sec-2" class="legal-nav-link">2. Datos que Procesamos</a>
            <a href="#sec-3" class="legal-nav-link">3. Tratamiento de Video e IA</a>
            <a href="#sec-4" class="legal-nav-link">4. Almacenamiento y Retención</a>
            <a href="#sec-5" class="legal-nav-link">5. Seguridad de la Información</a>
            <a href="#sec-6" class="legal-nav-link">6. Derechos del Titular</a>
            <a href="#sec-7" class="legal-nav-link">7. Contacto</a>
          </nav>
          <div class="legal-other-docs">
            <span class="legal-other-docs-title">Otros Documentos</span>
            <a href="terminos.php" class="legal-other-link"><i class="fas fa-file-contract"></i> Términos de Uso</a>
            <a href="cookies.php" class="legal-other-link"><i class="fas fa-cookie-bite"></i> Política de Cookies</a>
          </div>
        </aside>

        <!-- Secciones -->
        <article class="legal-content">
          
          <section id="sec-1" class="legal-section">
            <h2>1. Principios Fundamentales de Privacidad</h2>
            <p>
              SIMC está diseñado bajo el principio de <strong>Privacidad por Diseño y por Defecto (Privacy by Design)</strong>. Nuestra premisa técnica es que <em>el monitoreo del rendimiento y concentración no requiere la invasión de la vida privada</em>.
            </p>
            <div class="legal-callout info">
              <div class="callout-header"><i class="fas fa-shield-check"></i> Compromiso Central SIMC</div>
              <p>El sistema <strong>no graba video continuo ni almacena feeds de cámara en la nube</strong>. Todo el procesamiento visual de la IA ocurre en la memoria RAM del equipo local del usuario.</p>
            </div>
          </section>

          <section id="sec-2" class="legal-section">
            <h2>2. Datos que Procesamos</h2>
            <p>SIMC distingue dos categorías de información:</p>
            <ul>
              <li><strong>Datos de Cuenta:</strong> Nombre de usuario, correo electrónico, rol institucional y hash criptográfico de contraseña.</li>
              <li><strong>Telemetría de Concentración:</strong> Puntuaciones numéricas porcentuales de atención, estado de ocio, registros de tiempo en aplicaciones y alertas de incidentes.</li>
            </ul>
          </section>

          <section id="sec-3" class="legal-section">
            <h2>3. Tratamiento de Video y Modelos de IA</h2>
            <p>
              El modelo <strong>YOLOv8</strong> procesa los fotogramas capturados por la cámara en tiempo real para detectar puntos clave faciales (mirada, parpadeo) y objetos específicos (teléfonos móviles). Una vez obtenido el valor vectorial matemático, el fotograma es descartado inmediatamente de memoria.
            </p>
          </section>

          <section id="sec-4" class="legal-section">
            <h2>4. Almacenamiento y Retención de Datos</h2>
            <p>
              Las métricas de sesión se conservan únicamente durante el tiempo estipulado por la institución educativa o laboral para fines de auditoría y estadísticas de aprendizaje.
            </p>
          </section>

          <section id="sec-5" class="legal-section">
            <h2>5. Ciberseguridad &amp; Cifrado</h2>
            <p>
              Toda la comunicación de red local y remota se realiza a través de canales cifrados <strong>WebSocket Seguro (WSS) y HTTPS</strong> con certificados SSL/TLS y cabeceras endurecidas OWASP.
            </p>
          </section>

          <section id="sec-6" class="legal-section">
            <h2>6. Derechos de los Usuarios (ARCO)</h2>
            <p>
              Los usuarios tienen derecho a acceder, rectificar, actualizar o solicitar la supresión de sus datos personales registrados en la base de datos de SIMC en cualquier momento.
            </p>
          </section>

          <section id="sec-7" class="legal-section">
            <h2>7. Contacto y Consultas</h2>
            <div class="legal-contact-box">
              <h4><i class="fas fa-envelope"></i> Canal de Privacidad</h4>
              <p>Para consultas sobre privacidad de datos, escribí a <strong>privacidad@simc-ai.com</strong>.</p>
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
          <a href="privacidad.php" style="color:var(--cyan);">Privacidad</a>
          <a href="terminos.php">Términos y Condiciones</a>
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
