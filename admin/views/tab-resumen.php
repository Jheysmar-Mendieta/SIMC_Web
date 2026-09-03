<?php
/**
 * SIMC ADMIN SUITE — Vista Parcial: Tab Resumen (Dashboard KPIs & Charts)
 */

if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}
?>
<div class="top-header">
  <div>
    <h1 class="page-title"><i class="fas fa-chart-line"></i> Dashboard General</h1>
    <p class="page-sub">Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>. Monitoreo en tiempo real del sistema.</p>
  </div>
  <div class="header-actions">
    <a href="?tab=consultas&filtro=sin_leer" class="btn-primary">
      <i class="fas fa-inbox"></i> Ver Consultas (<?= $sinLeer ?> sin leer)
    </a>
    <button class="btn-outline" onclick="abrirModalUsuario()">
      <i class="fas fa-user-plus"></i> Gestionar Usuarios
    </button>
  </div>
</div>

<!-- Grid de KPIs -->
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-info">
      <span class="kpi-label">Total Consultas</span>
      <span class="kpi-value"><?= $totalConsultas ?></span>
    </div>
    <div class="kpi-icon"><i class="fas fa-envelope"></i></div>
  </div>

  <div class="kpi-card">
    <div class="kpi-info">
      <span class="kpi-label">Sin Leer</span>
      <span class="kpi-value" style="color:<?= $sinLeer > 0 ? 'var(--danger)' : 'var(--text)' ?>"><?= $sinLeer ?></span>
    </div>
    <div class="kpi-icon" style="<?= $sinLeer > 0 ? 'background:rgba(255,69,96,0.15); color:var(--danger)' : '' ?>">
      <i class="fas fa-bell"></i>
    </div>
  </div>

  <div class="kpi-card">
    <div class="kpi-info">
      <span class="kpi-label">Usuarios Activos</span>
      <span class="kpi-value"><?= $usuariosActivos ?> <span style="font-size:1rem; color:var(--muted)">/ <?= $totalUsuarios ?></span></span>
    </div>
    <div class="kpi-icon"><i class="fas fa-users"></i></div>
  </div>

  <div class="kpi-card">
    <div class="kpi-info">
      <span class="kpi-label">Logins (24h)</span>
      <span class="kpi-value"><?= $logins24h ?></span>
    </div>
    <div class="kpi-icon"><i class="fas fa-key"></i></div>
  </div>
</div>

<!-- Dos Columnas: Gráfico y Actividad Reciente -->
<div class="two-cols">
  <!-- Gráfico de Actividad -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-chart-simple" style="color:var(--accent)"></i> Actividad de Consultas (Últimos 7 días)</h3>
      <span style="font-size:0.75rem; color:var(--muted)"><?= $consultasSemana ?> consultas esta semana</span>
    </div>

    <div class="chart-bar-container">
      <?php foreach ($diasGrafico as $d): ?>
        <?php $pct = round(($d['total'] / $maxGrafico) * 100); ?>
        <div class="chart-col">
          <span class="chart-val"><?= $d['total'] ?></span>
          <div class="chart-bar" style="height: <?= max(4, $pct) ?>%"></div>
          <span class="chart-date"><?= $d['dia'] ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Últimos Accesos -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-shield-halved" style="color:var(--accent)"></i> Accesos Recientes</h3>
      <a href="?tab=logs" style="font-size:0.75rem; color:var(--accent); text-decoration:none">Ver todos &rarr;</a>
    </div>

    <?php if (empty($ultimosAccesos)): ?>
      <div class="empty-state">No hay registros de acceso aún.</div>
    <?php else: ?>
      <div style="display:flex; flex-direction:column; gap:8px;">
        <?php foreach ($ultimosAccesos as $acc): ?>
          <div style="display:flex; align-items:center; justify-content:space-between; padding:0.5rem 0.75rem; background:var(--surface-2); border-radius:6px; font-size:0.82rem;">
            <div style="display:flex; align-items:center; gap:8px;">
              <i class="fas <?= $acc['accion'] === 'login' ? 'fa-circle-check' : ($acc['accion'] === 'login_fallido' ? 'fa-circle-xmark' : 'fa-circle-info') ?>" 
                 style="color:<?= $acc['accion'] === 'login' ? 'var(--success)' : ($acc['accion'] === 'login_fallido' ? 'var(--danger)' : 'var(--muted)') ?>"></i>
              <strong><?= htmlspecialchars($acc['username'] ?? 'Anónimo') ?></strong>
            </div>
            <span style="font-family:'JetBrains Mono', monospace; font-size:0.72rem; color:var(--muted)">
              <?= date('H:i - d/m', strtotime($acc['creado_en'])) ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Últimas Consultas Recibidas -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-inbox" style="color:var(--accent)"></i> Últimas Consultas Recibidas</h3>
    <a href="?tab=consultas" class="btn-outline" style="font-size:0.75rem; padding:0.35rem 0.75rem;">Ver Bandeja Completa</a>
  </div>

  <?php if (empty($ultimasConsultas)): ?>
    <div class="empty-state"><i class="fas fa-inbox fa-2x"></i><br />No se recibieron consultas todavía.</div>
  <?php else: ?>
    <div class="table-container">
      <table class="data-table">
        <thead>
          <tr>
            <th>Estado</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Mensaje</th>
            <th>Fecha</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($ultimasConsultas as $c): ?>
            <tr>
              <td>
                <span class="badge <?= $c['leido'] ? 'neutral' : 'danger' ?>">
                  <?= $c['leido'] ? 'Leído' : 'NUEVO' ?>
                </span>
              </td>
              <td><strong><?= htmlspecialchars($c['nombre']) ?></strong></td>
              <td><?= htmlspecialchars($c['email']) ?></td>
              <td style="max-width:280px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                <?= htmlspecialchars($c['mensaje']) ?>
              </td>
              <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--muted)">
                <?= date('d/m/Y H:i', strtotime($c['creado_en'])) ?>
              </td>
              <td>
                <button type="button" class="btn-outline" style="padding:0.25rem 0.6rem; font-size:0.75rem;" onclick='verConsulta(<?= json_encode($c) ?>)'>
                  <i class="fas fa-eye"></i> Ver
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
