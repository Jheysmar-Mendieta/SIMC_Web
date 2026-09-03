<?php
/**
 * SIMC — Landing Page Principal (Modular & Optimizada)
 */

require_once __DIR__ . '/php/conexion.php';
start_session();

$loggedIn = is_logged_in();
$username = $loggedIn ? htmlspecialchars($_SESSION['username']) : '';
$rol = $loggedIn ? ($_SESSION['rol'] ?? '') : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="SIMC — Sistema Inteligente de Monitoreo de Concentración en tiempo real con Inteligencia Artificial YOLOv8 y Visión Computacional." />
  <meta name="theme-color" content="#030712" />
  <title>SIMC — Sistema Inteligente de Monitoreo de Concentración</title>

  <!-- Tipografías & Iconos -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Orbitron:wght@600;700;800;900&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Hojas de Estilos Modulares (< 200 líneas cada una) -->
  <link rel="stylesheet" href="css/base/variables.css?v=<?= filemtime(__DIR__ . '/css/base/variables.css') ?>" />
  <link rel="stylesheet" href="css/base/reset.css?v=<?= filemtime(__DIR__ . '/css/base/reset.css') ?>" />
  <link rel="stylesheet" href="css/components/buttons.css?v=<?= filemtime(__DIR__ . '/css/components/buttons.css') ?>" />
  <link rel="stylesheet" href="css/components/navbar.css?v=<?= filemtime(__DIR__ . '/css/components/navbar.css') ?>" />
  <link rel="stylesheet" href="css/components/modals.css?v=<?= filemtime(__DIR__ . '/css/components/modals.css') ?>" />
  <link rel="stylesheet" href="css/components/checkout.css?v=<?= filemtime(__DIR__ . '/css/components/checkout.css') ?>" />
  <link rel="stylesheet" href="css/sections/hero.css?v=<?= filemtime(__DIR__ . '/css/sections/hero.css') ?>" />
  <link rel="stylesheet" href="css/sections/about.css?v=<?= filemtime(__DIR__ . '/css/sections/about.css') ?>" />
  <link rel="stylesheet" href="css/sections/steps.css?v=<?= filemtime(__DIR__ . '/css/sections/steps.css') ?>" />
  <link rel="stylesheet" href="css/sections/use-cases.css?v=<?= filemtime(__DIR__ . '/css/sections/use-cases.css') ?>" />
  <link rel="stylesheet" href="css/sections/products.css?v=<?= filemtime(__DIR__ . '/css/sections/products.css') ?>" />
  <link rel="stylesheet" href="css/sections/compare.css?v=<?= filemtime(__DIR__ . '/css/sections/compare.css') ?>" />
  <link rel="stylesheet" href="css/sections/faq.css?v=<?= filemtime(__DIR__ . '/css/sections/faq.css') ?>" />
  <link rel="stylesheet" href="css/sections/contact.css?v=<?= filemtime(__DIR__ . '/css/sections/contact.css') ?>" />
  <link rel="stylesheet" href="css/sections/footer.css?v=<?= filemtime(__DIR__ . '/css/sections/footer.css') ?>" />
  <link rel="stylesheet" href="css/responsive/responsive.css?v=<?= filemtime(__DIR__ . '/css/responsive/responsive.css') ?>" />
</head>
<body>

  <!-- Accesibilidad: Skip Link -->
  <a href="#main-content" class="skip-link">Saltar al contenido principal</a>

  <!-- 1. Navbar -->
  <?php require_once __DIR__ . '/php/partials/navbar.php'; ?>

  <!-- Contenido Principal -->
  <main id="main-content">
    <!-- 2. Hero Section -->
    <?php require_once __DIR__ . '/php/partials/hero.php'; ?>

    <!-- 3. Sección Sistema (¿Qué es SIMC?) -->
    <?php require_once __DIR__ . '/php/partials/about.php'; ?>

    <!-- 4. Sección Cómo Funciona (Pipeline) -->
    <?php require_once __DIR__ . '/php/partials/how-it-works.php'; ?>

    <!-- 5. Sección Soluciones & Casos de Uso -->
    <?php require_once __DIR__ . '/php/partials/use-cases.php'; ?>

    <!-- 6. Sección Membresías & Descargas -->
    <?php require_once __DIR__ . '/php/partials/products.php'; ?>

    <!-- 7. Sección Comparativa -->
    <?php require_once __DIR__ . '/php/partials/compare.php'; ?>

    <!-- 8. Sección FAQ -->
    <?php require_once __DIR__ . '/php/partials/faq.php'; ?>

    <!-- 9. Sección Contacto -->
    <?php require_once __DIR__ . '/php/partials/contact.php'; ?>
  </main>

  <!-- 10. Footer -->
  <?php require_once __DIR__ . '/php/partials/footer.php'; ?>

  <!-- 11. Modal de Autenticación -->
  <?php if (!$loggedIn): ?>
    <?php require_once __DIR__ . '/php/partials/auth-modal.php'; ?>
  <?php endif; ?>

  <!-- 12. Modal de Checkout de Membresías -->
  <?php require_once __DIR__ . '/php/partials/checkout-modal.php'; ?>

  <!-- 13. Scripts -->
  <script>const BASE_URL = '<?= get_base_url() ?>';</script>
  <script src="js/canvas.js?v=<?= filemtime(__DIR__ . '/js/canvas.js') ?>"></script>
  <script src="js/main.js?v=<?= filemtime(__DIR__ . '/js/main.js') ?>"></script>
  <script src="js/contact-form.js?v=<?= filemtime(__DIR__ . '/js/contact-form.js') ?>"></script>
  <script src="js/checkout.js?v=<?= filemtime(__DIR__ . '/js/checkout.js') ?>"></script>
  <?php if (!$loggedIn): ?>
    <script src="js/auth-modal.js?v=<?= filemtime(__DIR__ . '/js/auth-modal.js') ?>"></script>
  <?php endif; ?>

</body>
</html>