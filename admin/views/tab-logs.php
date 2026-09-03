<?php
/**
 * SIMC ADMIN SUITE — Vista Parcial: Tab Logs (Auditoría de Seguridad)
 */

if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}
?>
<div class="top-header">
  <div>
    <h1 class="page-title"><i class="fas fa-shield-halved"></i> Auditoría &amp; Logs de Seguridad</h1>
    <p class="page-sub">Registro de eventos de autenticación, inicios de sesión y accesos fallidos.</p>
  </div>
  <div class="header-actions">
    <a href="dashboard.php?export=logs_csv" class="btn-outline">
      <i class="fas fa-file-excel"></i> Exportar Logs CSV
    </a>
  </div>
</div>

<div class="filter-bar">
  <div class="filter-pills">
    <a href="?tab=logs&filtro_log=todos" class="pill <?= $filtroLog === 'todos' ? 'active' : '' ?>">Todos los eventos</a>
    <a href="?tab=logs&filtro_log=login_fallido" class="pill <?= $filtroLog === 'login_fallido' ? 'active' : '' ?>">Intentos Fallidos</a>
    <a href="?tab=logs&filtro_log=login" class="pill <?= $filtroLog === 'login' ? 'active' : '' ?>">Inicios de Sesión</a>
    <a href="?tab=logs&filtro_log=logout" class="pill <?= $filtroLog === 'logout' ? 'active' : '' ?>">Cierres de Sesión</a>
  </div>
</div>

<?php if (empty($listaLogs)): ?>
  <div class="card empty-state">No se registraron eventos para este filtro.</div>
<?php else: ?>
  <div class="table-container">
    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo de Evento</th>
          <th>Usuario</th>
          <th>Dirección IP</th>
          <th>Navegador / SO</th>
          <th>Fecha y Hora</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listaLogs as $l): ?>
          <tr>
            <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--muted)">#<?= $l['id'] ?></td>
            <td>
              <?php if ($l['accion'] === 'login'): ?>
                <span class="badge success"><i class="fas fa-check"></i> Login Exitoso</span>
              <?php elseif ($l['accion'] === 'login_fallido'): ?>
                <span class="badge danger"><i class="fas fa-triangle-exclamation"></i> Acceso Fallido</span>
              <?php elseif ($l['accion'] === 'logout'): ?>
                <span class="badge neutral"><i class="fas fa-power-off"></i> Logout</span>
              <?php else: ?>
                <span class="badge warning"><?= htmlspecialchars($l['accion']) ?></span>
              <?php endif; ?>
            </td>
            <td>
              <strong><?= htmlspecialchars($l['username'] ?? 'Anónimo / Desconocido') ?></strong>
              <?php if ($l['usuario_id']): ?>
                <span style="font-size:0.7rem; color:var(--muted)"> (UID #<?= $l['usuario_id'] ?>)</span>
              <?php endif; ?>
            </td>
            <td style="font-family:'JetBrains Mono', monospace; font-size:0.8rem; color:var(--accent)">
              <?= htmlspecialchars($l['ip']) ?>
            </td>
            <td style="max-width:260px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:0.78rem; color:var(--muted)" title="<?= htmlspecialchars($l['user_agent']) ?>">
              <?= htmlspecialchars($l['user_agent'] ?: 'N/A') ?>
            </td>
            <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--text)">
              <?= date('d/m/Y H:i:s', strtotime($l['creado_en'])) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
