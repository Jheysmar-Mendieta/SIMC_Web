<?php
if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}
?>
<!-- Barra móvil superior -->
<header class="mobile-admin-bar">
  <a href="dashboard.php" class="sidebar-brand">
    <img src="../img/logo.png" alt="Logo SIMC" style="width:24px;height:24px;border-radius:6px;margin-right:6px;filter:drop-shadow(0 0 6px rgba(0,242,254,0.5));" />
    <div class="sidebar-logo"><span>[</span>SIMC<span>]</span></div>
    <span class="suite-badge">ADMIN</span>
  </a>
  <button type="button" class="mobile-hamburger-btn" id="mobileMenuBtn" aria-label="Abrir Menú de Administración">
    <i class="fas fa-bars"></i>
  </button>
</header>

<!-- Fondo oscurecido para móvil -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Notificaciones flotantes -->
<?php if ($flash): ?>
  <div class="toast-container">
    <div class="toast <?= $flash['type'] ?>">
      <i class="fas <?= $flash['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
      <span><?= htmlspecialchars($flash['msg']) ?></span>
    </div>
  </div>
<?php endif; ?>

<!-- Menú lateral -->
<aside class="sidebar" id="adminSidebar">
  <div style="display:flex; align-items:center; justify-content:space-between; width:100%;">
    <a href="dashboard.php" class="sidebar-brand">
      <img src="../img/logo.png" alt="Logo SIMC" style="width:28px;height:28px;border-radius:6px;margin-right:8px;filter:drop-shadow(0 0 8px rgba(0,242,254,0.5));" />
      <div class="sidebar-logo"><span>[</span>SIMC<span>]</span></div>
      <span class="suite-badge">ADMIN v2.0</span>
    </a>
    <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Cerrar Menú">&times;</button>
  </div>

  <nav class="sidebar-nav">
    <a href="?tab=resumen" class="<?= $activeTab === 'resumen' ? 'active' : '' ?>">
      <span class="nav-label"><i class="fas fa-chart-line"></i> Dashboard</span>
    </a>
    <a href="?tab=consultas" class="<?= $activeTab === 'consultas' ? 'active' : '' ?>">
      <span class="nav-label"><i class="fas fa-inbox"></i> Consultas</span>
      <?php if ($sinLeer > 0): ?>
        <span class="nav-badge"><?= $sinLeer ?></span>
      <?php endif; ?>
    </a>
    <a href="?tab=usuarios" class="<?= $activeTab === 'usuarios' ? 'active' : '' ?>">
      <span class="nav-label"><i class="fas fa-users-gear"></i> Usuarios</span>
      <span style="font-size:0.75rem; color:var(--muted)"><?= $totalUsuarios ?></span>
    </a>
    <a href="?tab=logs" class="<?= $activeTab === 'logs' ? 'active' : '' ?>">
      <span class="nav-label"><i class="fas fa-shield-halved"></i> Auditoría & Logs</span>
      <?php if ($fallos24h > 0): ?>
        <span class="nav-badge" style="background:var(--warning); color:#000"><?= $fallos24h ?></span>
      <?php endif; ?>
    </a>
    <a href="?tab=sistema" class="<?= $activeTab === 'sistema' ? 'active' : '' ?>">
      <span class="nav-label"><i class="fas fa-server"></i> Sistema</span>
    </a>
  </nav>

  <div class="sidebar-user">
    <div class="sidebar-user-info">
      <div class="user-avatar"><?= strtoupper(substr($_SESSION['username'], 0, 1)) ?></div>
      <div class="user-details">
        <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        <span>ADMINISTRADOR</span>
      </div>
    </div>
    <div class="sidebar-actions">
      <a href="../index.php" class="btn-side" title="Ver sitio web público"><i class="fas fa-globe"></i> Web</a>
      <a href="../php/logout.php" class="btn-side danger" title="Cerrar sesión segura"><i class="fas fa-power-off"></i> Salir</a>
    </div>
  </div>
</aside>
