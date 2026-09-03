<?php
/**
 * SIMC ADMIN SUITE — Vista Parcial: Tab Usuarios (Gestión de Cuentas y Roles)
 */

if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}
?>
<div class="top-header">
  <div>
    <h1 class="page-title"><i class="fas fa-users-gear"></i> Gestión de Usuarios</h1>
    <p class="page-sub">Administración de operadores, administradores y estados de acceso.</p>
  </div>
  <div class="header-actions">
    <a href="dashboard.php?export=usuarios_csv" class="btn-outline">
      <i class="fas fa-file-excel"></i> Exportar CSV
    </a>
    <button class="btn-primary" onclick="abrirModalUsuario()">
      <i class="fas fa-user-plus"></i> Crear Nuevo Usuario
    </button>
  </div>
</div>

<div class="table-container">
  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Último Login</th>
        <th>Creado</th>
        <th style="text-align:right;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($listaUsuarios as $u): ?>
        <tr>
          <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--muted)">#<?= $u['id'] ?></td>
          <td>
            <div style="display:flex; align-items:center; gap:8px;">
              <div class="user-avatar" style="width:28px; height:28px; font-size:0.75rem;">
                <?= strtoupper(substr($u['username'], 0, 1)) ?>
              </div>
              <strong><?= htmlspecialchars($u['username']) ?></strong>
              <?php if ($u['id'] === $currentUserId): ?>
                <span class="badge neutral" style="font-size:0.65rem;">(Tú)</span>
              <?php endif; ?>
            </div>
          </td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td>
            <span class="badge <?= $u['rol'] === 'admin' ? 'admin' : 'neutral' ?>">
              <?= strtoupper($u['rol']) ?>
            </span>
          </td>
          <td>
            <span class="badge <?= $u['activo'] ? 'success' : 'danger' ?>">
              <?= $u['activo'] ? 'ACTIVO' : 'BLOQUEADO' ?>
            </span>
          </td>
          <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--muted)">
            <?= $u['ultimo_login'] ? date('d/m/y H:i', strtotime($u['ultimo_login'])) : 'Nunca' ?>
          </td>
          <td style="font-family:'JetBrains Mono', monospace; font-size:0.75rem; color:var(--muted)">
            <?= date('d/m/y', strtotime($u['creado_en'])) ?>
          </td>
          <td style="text-align:right;">
            <div style="display:inline-flex; gap:6px;">
              <!-- Cambiar contraseña -->
              <button type="button" class="btn-outline" style="padding:0.25rem 0.55rem; font-size:0.75rem;" onclick="abrirModalPass(<?= $u['id'] ?>, '<?= htmlspecialchars($u['username']) ?>')" title="Cambiar Contraseña">
                <i class="fas fa-key"></i>
              </button>

              <!-- Activar / Bloquear -->
              <?php if ($u['id'] !== $currentUserId): ?>
                <form method="POST" action="dashboard.php" style="display:inline;">
                  <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>" />
                  <input type="hidden" name="tab_origin" value="usuarios" />
                  <input type="hidden" name="accion" value="toggle_activo" />
                  <input type="hidden" name="id" value="<?= $u['id'] ?>" />
                  <input type="hidden" name="estado_actual" value="<?= $u['activo'] ?>" />
                  <button type="submit" class="btn-outline" style="padding:0.25rem 0.55rem; font-size:0.75rem;" title="<?= $u['activo'] ? 'Bloquear usuario' : 'Activar usuario' ?>">
                    <i class="fas <?= $u['activo'] ? 'fa-user-slash' : 'fa-user-check' ?>"></i>
                  </button>
                </form>

                <!-- Eliminar -->
                <form method="POST" action="dashboard.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar al usuario <?= htmlspecialchars($u['username']) ?>?');">
                  <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>" />
                  <input type="hidden" name="tab_origin" value="usuarios" />
                  <input type="hidden" name="accion" value="eliminar_usuario" />
                  <input type="hidden" name="id" value="<?= $u['id'] ?>" />
                  <button type="submit" class="btn-outline" style="padding:0.25rem 0.55rem; font-size:0.75rem; color:var(--danger);" title="Eliminar"><i class="fas fa-trash"></i></button>
                </form>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
