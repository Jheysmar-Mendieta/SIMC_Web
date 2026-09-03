<?php
/**
 * SIMC ADMIN SUITE — Vista Parcial: Tab Consultas (Bandeja de Entrada)
 */

if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}
?>
<div class="top-header">
  <div>
    <h1 class="page-title"><i class="fas fa-inbox"></i> Bandeja de Consultas</h1>
    <p class="page-sub">Mensajes enviados a través del formulario de contacto de la landing page.</p>
  </div>
  <div class="header-actions">
    <a href="dashboard.php?export=consultas_csv" class="btn-outline">
      <i class="fas fa-file-excel"></i> Exportar CSV
    </a>
    <form method="POST" action="dashboard.php" style="display:inline;" onsubmit="return confirm('¿Marcar todas las consultas como leídas?');">
      <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>" />
      <input type="hidden" name="tab_origin" value="consultas" />
      <input type="hidden" name="accion" value="marcar_todas_leidas" />
      <button type="submit" class="btn-outline"><i class="fas fa-check-double"></i> Marcar todas leídas</button>
    </form>
  </div>
</div>

<!-- Barra de Filtros y Búsqueda -->
<div class="filter-bar">
  <div class="filter-pills">
    <a href="?tab=consultas&filtro=todos<?= $busquedaConsulta ? '&q='.urlencode($busquedaConsulta) : '' ?>" 
       class="pill <?= $filtroConsulta === 'todos' ? 'active' : '' ?>">
      Todos (<?= $totalConsultas ?>)
    </a>
    <a href="?tab=consultas&filtro=sin_leer<?= $busquedaConsulta ? '&q='.urlencode($busquedaConsulta) : '' ?>" 
       class="pill <?= $filtroConsulta === 'sin_leer' ? 'active' : '' ?>">
      Sin Leer (<?= $sinLeer ?>)
    </a>
    <a href="?tab=consultas&filtro=leidos<?= $busquedaConsulta ? '&q='.urlencode($busquedaConsulta) : '' ?>" 
       class="pill <?= $filtroConsulta === 'leidos' ? 'active' : '' ?>">
      Leídos (<?= $totalConsultas - $sinLeer ?>)
    </a>
  </div>

  <form method="GET" action="dashboard.php" class="search-box">
    <input type="hidden" name="tab" value="consultas" />
    <input type="hidden" name="filtro" value="<?= htmlspecialchars($filtroConsulta) ?>" />
    <i class="fas fa-search" style="color:var(--muted)"></i>
    <input type="text" name="q" placeholder="Buscar por nombre, email..." value="<?= htmlspecialchars($busquedaConsulta) ?>" />
    <?php if ($busquedaConsulta): ?>
      <a href="?tab=consultas&filtro=<?= urlencode($filtroConsulta) ?>" style="color:var(--muted); font-size:0.8rem;"><i class="fas fa-times"></i></a>
    <?php endif; ?>
  </form>
</div>

<!-- Tabla de Consultas -->
<?php if (empty($listaConsultas)): ?>
  <div class="card empty-state">
    <i class="fas fa-inbox fa-3x"></i><br /><br />
    No se encontraron consultas con los filtros seleccionados.
  </div>
<?php else: ?>
  <div class="table-container">
    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Estado</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Mensaje</th>
          <th>IP</th>
          <th>Fecha</th>
          <th style="text-align:right;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listaConsultas as $c): ?>
          <tr>
            <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--muted)">#<?= $c['id'] ?></td>
            <td>
              <span class="badge <?= $c['leido'] ? 'neutral' : 'danger' ?>">
                <?= $c['leido'] ? 'Leído' : 'NUEVO' ?>
              </span>
            </td>
            <td><strong><?= htmlspecialchars($c['nombre']) ?></strong></td>
            <td><a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="color:var(--accent); text-decoration:none;"><?= htmlspecialchars($c['email']) ?></a></td>
            <td style="max-width:260px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($c['mensaje']) ?>">
              <?= htmlspecialchars($c['mensaje']) ?>
            </td>
            <td style="font-family:'JetBrains Mono', monospace; font-size:0.72rem; color:var(--muted)"><?= htmlspecialchars($c['ip'] ?? 'N/A') ?></td>
            <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--muted)"><?= date('d/m/Y H:i', strtotime($c['creado_en'])) ?></td>
            <td style="text-align:right;">
              <div style="display:inline-flex; gap:6px;">
                <button type="button" class="btn-outline" style="padding:0.25rem 0.55rem; font-size:0.75rem;" onclick='verConsulta(<?= json_encode($c) ?>)' title="Ver detalle">
                  <i class="fas fa-eye"></i>
                </button>

                <form method="POST" action="dashboard.php" style="display:inline;">
                  <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>" />
                  <input type="hidden" name="tab_origin" value="consultas" />
                  <input type="hidden" name="id" value="<?= $c['id'] ?>" />
                  <?php if ($c['leido']): ?>
                    <input type="hidden" name="accion" value="marcar_no_leido" />
                    <button type="submit" class="btn-outline" style="padding:0.25rem 0.55rem; font-size:0.75rem;" title="Marcar como no leído"><i class="fas fa-envelope"></i></button>
                  <?php else: ?>
                    <input type="hidden" name="accion" value="marcar_leido" />
                    <button type="submit" class="btn-outline" style="padding:0.25rem 0.55rem; font-size:0.75rem;" title="Marcar como leído"><i class="fas fa-envelope-open"></i></button>
                  <?php endif; ?>
                </form>

                <form method="POST" action="dashboard.php" style="display:inline;" onsubmit="return confirm('¿Eliminar esta consulta?');">
                  <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>" />
                  <input type="hidden" name="tab_origin" value="consultas" />
                  <input type="hidden" name="accion" value="eliminar_consulta" />
                  <input type="hidden" name="id" value="<?= $c['id'] ?>" />
                  <button type="submit" class="btn-outline" style="padding:0.25rem 0.55rem; font-size:0.75rem; color:var(--danger);" title="Eliminar"><i class="fas fa-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
