<?php
require_once __DIR__ . '/../php/conexion.php';

// Exigir rol de administrador
require_role('admin');

define('SIMC_ADMIN_INIT', true);

$pdo = get_db();
$csrfToken = generate_csrf_token();
$currentUserId = (int) ($_SESSION['usuario_id'] ?? 0);
$baseUrl = get_base_url();

// Módulos de lógica backend
require_once __DIR__ . '/php/exports.php';
require_once __DIR__ . '/php/actions.php';
require_once __DIR__ . '/php/data.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel de Control — SIMC Admin</title>
  
  <!-- Favicons Oficiales de SIMC -->
  <link rel="icon" type="image/x-icon" href="../favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon.png" />

  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Syne:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="css/admin.css?v=<?= filemtime(__DIR__ . '/css/admin.css') ?>" />
</head>
<body>

  <!-- Encabezado y navegación -->
  <?php require_once __DIR__ . '/views/header.php'; ?>

  <!-- Contenedor de vistas -->
  <main class="main">
    <?php
      switch ($activeTab) {
          case 'consultas':
              require_once __DIR__ . '/views/tab-consultas.php';
              break;
          case 'usuarios':
              require_once __DIR__ . '/views/tab-usuarios.php';
              break;
          case 'logs':
              require_once __DIR__ . '/views/tab-logs.php';
              break;
          case 'sistema':
              require_once __DIR__ . '/views/tab-sistema.php';
              break;
          case 'resumen':
          default:
              require_once __DIR__ . '/views/tab-resumen.php';
              break;
      }
    ?>
  </main>

  <!-- Modales -->
  <?php require_once __DIR__ . '/views/modals.php'; ?>

  <!-- Scripts -->
  <script src="js/admin.js?v=<?= filemtime(__DIR__ . '/js/admin.js') ?>"></script>

</body>
</html>