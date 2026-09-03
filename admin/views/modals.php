<?php
/**
 * SIMC ADMIN SUITE — Vista Parcial: Modales Administrativos
 */

if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}
?>
<!-- Modal Crear Usuario -->
<div class="admin-modal" id="modalCrearUsuario">
  <div class="admin-modal-card">
    <div class="modal-header">
      <h3><i class="fas fa-user-plus"></i> Crear Nuevo Usuario</h3>
      <button class="close-modal-btn" onclick="cerrarModales()">&times;</button>
    </div>
    <form method="POST" action="dashboard.php">
      <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>" />
      <input type="hidden" name="tab_origin" value="usuarios" />
      <input type="hidden" name="accion" value="crear_usuario" />

      <div class="form-group">
        <label>Nombre de Usuario</label>
        <input type="text" name="username" placeholder="ej. docente_juan" required pattern="[a-zA-Z0-9_.]{3,40}" />
      </div>

      <div class="form-group">
        <label>Correo Electrónico</label>
        <input type="email" name="email" placeholder="usuario@institucion.edu" required />
      </div>

      <div class="form-group">
        <label>Contraseña Provisoria (mínimo 8 caracteres)</label>
        <input type="password" name="password" placeholder="••••••••" required minlength="8" />
      </div>

      <div class="form-group">
        <label>Rol de Usuario</label>
        <select name="rol">
          <option value="operador">Operador (Acceso Estándar)</option>
          <option value="admin">Administrador (Acceso Total)</option>
        </select>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:1.5rem;">
        <button type="button" class="btn-outline" onclick="cerrarModales()">Cancelar</button>
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Crear Cuenta</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div class="admin-modal" id="modalPass">
  <div class="admin-modal-card">
    <div class="modal-header">
      <h3><i class="fas fa-key"></i> Cambiar Contraseña</h3>
      <button class="close-modal-btn" onclick="cerrarModales()">&times;</button>
    </div>
    <form method="POST" action="dashboard.php">
      <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>" />
      <input type="hidden" name="tab_origin" value="usuarios" />
      <input type="hidden" name="accion" value="cambiar_password" />
      <input type="hidden" name="id" id="passUserId" value="" />

      <p style="font-size:0.85rem; color:var(--muted); margin-bottom:1.2rem;">
        Establecer una nueva contraseña para el usuario: <strong id="passUsername" style="color:var(--accent);"></strong>
      </p>

      <div class="form-group">
        <label>Nueva Contraseña (mínimo 8 caracteres)</label>
        <input type="password" name="nueva_password" placeholder="Nueva contraseña segura" required minlength="8" />
      </div>

      <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:1.5rem;">
        <button type="button" class="btn-outline" onclick="cerrarModales()">Cancelar</button>
        <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Actualizar Clave</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Ver Consulta Completa -->
<div class="admin-modal" id="modalVerConsulta">
  <div class="admin-modal-card" style="max-width:560px;">
    <div class="modal-header">
      <h3><i class="fas fa-envelope"></i> Detalle de Consulta</h3>
      <button class="close-modal-btn" onclick="cerrarModales()">&times;</button>
    </div>
    <div style="margin-bottom:1rem;">
      <div style="font-size:0.8rem; color:var(--muted);">De:</div>
      <strong id="detNombre" style="font-size:1.1rem; color:var(--text)"></strong>
      <div id="detEmail" style="color:var(--accent); font-size:0.88rem;"></div>
      <div id="detFecha" style="color:var(--muted); font-size:0.75rem; margin-top:4px;"></div>
    </div>
    <div class="form-group">
      <label>Mensaje Completo:</label>
      <div id="detMensaje" style="background:var(--surface-2); border:1px solid var(--border); border-radius:6px; padding:1rem; font-size:0.9rem; line-height:1.5; max-height:220px; overflow-y:auto; white-space:pre-wrap;"></div>
    </div>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1.5rem;">
      <a id="detReplyBtn" href="#" class="btn-primary"><i class="fas fa-reply"></i> Responder por Email</a>
      <button type="button" class="btn-outline" onclick="cerrarModales()">Cerrar</button>
    </div>
  </div>
</div>
