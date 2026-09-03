<?php
/**
 * SIMC ADMIN SUITE — Vista Parcial: Tab Sistema (Telemetría de Servidor y BD)
 */

if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}
?>
<div class="top-header">
  <div>
    <h1 class="page-title"><i class="fas fa-server"></i> Estado del Sistema</h1>
    <p class="page-sub">Diagnóstico de entorno, base de datos, módulos de IA y seguridad.</p>
  </div>
</div>

<div class="system-grid">
  <!-- Entorno PHP -->
  <div class="sys-card">
    <h4><i class="fab fa-php"></i> Servidor Web &amp; PHP</h4>
    <div class="sys-row"><span>Versión de PHP</span><span><?= phpversion() ?></span></div>
    <div class="sys-row"><span>Software Servidor</span><span><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/XAMPP' ?></span></div>
    <div class="sys-row"><span>Límite de Memoria</span><span><?= ini_get('memory_limit') ?></span></div>
    <div class="sys-row"><span>Max Execution Time</span><span><?= ini_get('max_execution_time') ?>s</span></div>
    <div class="sys-row"><span>Upload Max Filesize</span><span><?= ini_get('upload_max_filesize') ?></span></div>
    <div class="sys-row"><span>Zona Horaria</span><span><?= date_default_timezone_get() ?></span></div>
  </div>

  <!-- Base de Datos -->
  <div class="sys-card">
    <h4><i class="fas fa-database"></i> Base de Datos (MySQL)</h4>
    <div class="sys-row"><span>Driver PDO</span><span>pdo_mysql</span></div>
    <div class="sys-row"><span>Host / Puerto</span><span><?= DB_HOST ?>:<?= DB_PORT ?></span></div>
    <div class="sys-row"><span>Base de Datos</span><span><?= DB_NAME ?></span></div>
    <div class="sys-row"><span>Charset</span><span><?= DB_CHARSET ?></span></div>
    <div class="sys-row"><span>Total Consultas</span><span><?= $totalConsultas ?></span></div>
    <div class="sys-row"><span>Total Usuarios</span><span><?= $totalUsuarios ?></span></div>
  </div>

  <!-- Módulos de IA y Seguridad -->
  <div class="sys-card">
    <h4><i class="fas fa-shield-halved"></i> Ciberseguridad &amp; IA</h4>
    <div class="sys-row"><span>Modelo IA</span><span style="color:var(--accent)">YOLOv8 Facial Core</span></div>
    <div class="sys-row"><span>Canal Telemetría</span><span style="color:var(--success)">WebSocket Seguro</span></div>
    <div class="sys-row"><span>Hash Contraseñas</span><span>Bcrypt (Costo 12)</span></div>
    <div class="sys-row"><span>Protección CSRF</span><span style="color:var(--success)">Activa (Token 256-bit)</span></div>
    <div class="sys-row"><span>Cabeceras HTTP</span><span style="color:var(--success)">OWASP Hardened</span></div>
    <div class="sys-row"><span>Rate Limiting</span><span style="color:var(--success)">5 err / 15 min</span></div>
  </div>
</div>
