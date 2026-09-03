<?php
/**
 * SIMC - Modal de Aviso Previo de Monitoreo
 * Componente reutilizable para advertir y obtener confirmación informada antes de vincular un dispositivo.
 */
?>
<div class="modal-overlay" id="monitoringNoticeModal" aria-hidden="true" role="dialog" aria-labelledby="monitoringNoticeTitle">
  <div class="modal-card" style="max-width: 480px; border-color: rgba(255, 170, 0, 0.4); box-shadow: 0 0 50px rgba(255, 170, 0, 0.15), 0 20px 40px rgba(0, 0, 0, 0.7);">
    
    <button class="modal-close" id="closeMonitoringNotice" aria-label="Cerrar aviso">
      <i class="fas fa-times"></i>
    </button>

    <div style="text-align:center; margin-bottom:1rem;">
      <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(255, 170, 0, 0.12); border: 1px solid rgba(255, 170, 0, 0.35); display: inline-flex; align-items: center; justify-content: center; color: #ffaa00; font-size: 1.6rem; margin-bottom: 0.75rem;">
        <i class="fas fa-triangle-exclamation"></i>
      </div>
      <h3 id="monitoringNoticeTitle" style="font-family: var(--font-display); font-size: 1.25rem; color: #fff; line-height: 1.3;">
        Información importante sobre el monitoreo
      </h3>
    </div>

    <div style="background: rgba(11, 17, 40, 0.8); border: 1px solid rgba(255, 170, 0, 0.2); border-radius: 10px; padding: 16px; margin-bottom: 1.25rem;">
      <p style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.6; margin: 0; text-align: left;">
        Este dispositivo está a punto de ser vinculado a <strong>SIMC</strong>. Dependiendo de la configuración habilitada, el sistema podrá registrar determinados datos técnicos y eventos de actividad. La información será tratada de acuerdo con la <strong>Política de Privacidad</strong> y los permisos establecidos.
      </p>
    </div>

    <div style="text-align:center; margin-bottom:1.5rem;">
      <a href="privacidad.php#sec-7" target="_blank" rel="noopener noreferrer" style="color: var(--cyan); font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-up-right-from-square"></i> Leer Política de Privacidad
      </a>
    </div>

    <div style="display: flex; gap: 12px; justify-content: flex-end;">
      <button type="button" class="btn btn-ghost" id="cancelMonitoringNotice" style="flex: 1; padding: 10px 16px; font-size: 0.9rem;">
        <span>Cancelar</span>
      </button>
      <button type="button" class="btn btn-primary" id="confirmMonitoringNotice" style="flex: 1; padding: 10px 16px; font-size: 0.9rem; background: linear-gradient(90deg, #ffaa00, #ff7700); border-color: #ffaa00;">
        <span>Continuar</span>
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>

  </div>
</div>
