<?php
/**
 * SIMC — Vista Parcial: Sección Membresías con Detección de Plan Activo y Periodicidad
 */
require_once __DIR__ . '/../conexion.php';

$planActivoUsuario = null;
$periodoPlan = 'monthly';
$expiracionPlan = null;

if (function_exists('is_logged_in') && is_logged_in()) {
    try {
        $db = get_db();
        $uid = $_SESSION['usuario_id'] ?? 0;
        $email = $_SESSION['email'] ?? '';
        $licStmt = $db->prepare("
            SELECT plan, periodo, fecha_expiracion FROM `licencias_membresia` 
            WHERE (user_id = :uid OR LOWER(email_comprador) = LOWER(:email))
              AND fecha_expiracion > NOW() 
              AND estado = 'activa'
            ORDER BY 
              CASE WHEN plan = 'ENTERPRISE' THEN 3 WHEN plan = 'MEDIUM' THEN 2 ELSE 1 END DESC,
              fecha_expiracion DESC 
            LIMIT 1
        ");
        $licStmt->execute([':uid' => $uid, ':email' => $email]);
        $licRow = $licStmt->fetch();
        if ($licRow) {
            $planActivoUsuario = strtoupper($licRow['plan']);
            $periodoPlan = strtolower($licRow['periodo'] ?? 'monthly');
            $expiracionPlan = date('d/m/Y', strtotime($licRow['fecha_expiracion']));
        }
    } catch(Exception $e) {
        error_log('[PRODUCTS ERROR] ' . $e->getMessage());
    }
}
?>
<script>
  window.USER_MEMBRESIA_SERVER = <?= json_encode([
    'plan' => $planActivoUsuario,
    'periodo' => $periodoPlan,
    'fecha_expiracion' => $expiracionPlan
  ]) ?>;
</script>

<section class="products section" id="products">
  <div class="container">
    <div class="text-center">
      <div class="section-label reveal">// planes &amp; precios</div>
      <h2 class="section-title reveal">Planes de <span class="gradient-text">Membresía SIMC PRO</span></h2>
      <p class="section-desc reveal">Supervisión inteligente de aulas y oficinas. Escoge la modalidad que mejor se adapte a tu institución.</p>
    </div>

    <!-- Selector de Facturación Mensual / Anual -->
    <div class="pricing-switcher-wrapper reveal" role="tablist" aria-label="Periodicidad de facturación">
      <button type="button" class="pricing-btn active" data-period="monthly" role="tab" aria-selected="true">
        Facturación Mensual
      </button>
      <button type="button" class="pricing-btn" data-period="annual" role="tab" aria-selected="false">
        Facturación Anual
        <span class="discount-tag">-20% OFF</span>
      </button>
    </div>

    <div class="products-grid">
      <!-- PLAN BASIC -->
      <div class="product-card reveal <?= ($planActivoUsuario === 'BASIC') ? 'active-plan-card' : '' ?>" id="card-plan-basic">
        <div class="card-badge <?= ($planActivoUsuario === 'BASIC') ? 'badge-active-plan' : '' ?>" id="badge-plan-basic">
          <?= ($planActivoUsuario === 'BASIC') ? ($periodoPlan === 'annual' ? '✓ TU PLAN ANUAL ACTIVO' : '✓ TU PLAN MENSUAL ACTIVO') : 'BÁSICO' ?>
        </div>
        <div class="card-icon"><i class="fas fa-desktop" aria-hidden="true"></i></div>
        <h3>Plan Basic</h3>
        
        <div class="pricing-price-block">
          <span class="price-currency">$</span>
          <span class="price-amount" data-price-monthly="15" data-price-annual="12">15</span>
          <span class="price-period">/ mes</span>
        </div>

        <p>Ideal para laboratorios pequeños y salas de clase individuales.</p>

        <ul class="card-specs">
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span><strong>Hasta 10 PCs</strong> simultáneas</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Monitoreo de apps y ventanas activas</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Cálculo de concentración y ocio</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Bloqueo remoto de aplicaciones</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Servidor WebSocket local LAN</span></li>
        </ul>

        <div id="btn-container-basic">
          <?php if ($planActivoUsuario === 'BASIC'): ?>
            <button type="button" class="btn btn-plan-status active-btn" disabled>
              <i class="fas fa-check-circle"></i>
              <span>✓ Plan <?= ($periodoPlan === 'annual' ? 'Anual' : 'Mensual') ?> Activo (<?= htmlspecialchars($expiracionPlan) ?>)</span>
            </button>
          <?php elseif ($planActivoUsuario === 'MEDIUM' || $planActivoUsuario === 'ENTERPRISE'): ?>
            <button type="button" class="btn btn-plan-status included-btn" disabled>
              <span>✓ Incluido en tu plan</span>
            </button>
          <?php else: ?>
            <button type="button" class="btn btn-card btn-buy-plan" data-plan="BASIC" onclick="abrirCheckoutModal('BASIC')">
              <i class="fas fa-shopping-cart" aria-hidden="true"></i>
              <span>Comprar Basic</span>
            </button>
          <?php endif; ?>
        </div>
      </div>

      <!-- PLAN MEDIUM (DESTACADO) -->
      <div class="product-card featured reveal <?= ($planActivoUsuario === 'MEDIUM') ? 'active-plan-card' : '' ?>" id="card-plan-medium">
        <div class="card-badge <?= ($planActivoUsuario === 'MEDIUM') ? 'badge-active-plan' : 'badge-featured' ?>" id="badge-plan-medium">
          <?= ($planActivoUsuario === 'MEDIUM') ? ($periodoPlan === 'annual' ? '✓ TU PLAN ANUAL ACTIVO' : '✓ TU PLAN MENSUAL ACTIVO') : 'MÁS POPULAR' ?>
        </div>
        <div class="card-icon"><i class="fas fa-brain" aria-hidden="true"></i></div>
        <h3>Plan Medium</h3>
        
        <div class="pricing-price-block">
          <span class="price-currency">$</span>
          <span class="price-amount" data-price-monthly="25" data-price-annual="20">25</span>
          <span class="price-period">/ mes</span>
        </div>

        <p>Para aulas estándar y grupos de trabajo con supervisión reforzada.</p>

        <ul class="card-specs">
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span><strong>Hasta 20 PCs</strong> simultáneas</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span><strong>🤖 Detección de Celular por IA (YOLOv8)</strong></span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span><strong>📸 Captura de Foto + Justificativo</strong></span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Rastreo de mirada y foco de atención</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Avisos y mensajes broadcast</span></li>
        </ul>

        <div id="btn-container-medium">
          <?php if ($planActivoUsuario === 'MEDIUM'): ?>
            <button type="button" class="btn btn-plan-status active-btn" disabled>
              <i class="fas fa-check-circle"></i>
              <span>✓ Plan <?= ($periodoPlan === 'annual' ? 'Anual' : 'Mensual') ?> Activo (<?= htmlspecialchars($expiracionPlan) ?>)</span>
            </button>
          <?php elseif ($planActivoUsuario === 'ENTERPRISE'): ?>
            <button type="button" class="btn btn-plan-status included-btn" disabled>
              <span>✓ Incluido en tu plan</span>
            </button>
          <?php elseif ($planActivoUsuario === 'BASIC'): ?>
            <button type="button" class="btn btn-primary btn-upgrade-action" data-plan="MEDIUM" onclick="abrirCheckoutModal('MEDIUM')">
              <i class="fas fa-arrow-up" aria-hidden="true"></i>
              <span>Mejorar a Medium</span>
            </button>
          <?php else: ?>
            <button type="button" class="btn btn-primary btn-buy-plan" data-plan="MEDIUM" onclick="abrirCheckoutModal('MEDIUM')">
              <i class="fas fa-bolt" aria-hidden="true"></i>
              <span>Comprar Medium</span>
            </button>
          <?php endif; ?>
        </div>
      </div>

      <!-- PLAN ENTERPRISE -->
      <div class="product-card reveal <?= ($planActivoUsuario === 'ENTERPRISE') ? 'active-plan-card' : '' ?>" id="card-plan-enterprise">
        <div class="card-badge <?= ($planActivoUsuario === 'ENTERPRISE') ? 'badge-active-plan' : '' ?>" id="badge-plan-enterprise">
          <?= ($planActivoUsuario === 'ENTERPRISE') ? ($periodoPlan === 'annual' ? '✓ TU PLAN ANUAL ACTIVO' : '✓ TU PLAN MENSUAL ACTIVO') : 'ENTERPRISE' ?>
        </div>
        <div class="card-icon"><i class="fas fa-building-shield" aria-hidden="true"></i></div>
        <h3>Plan Enterprise</h3>
        
        <div class="pricing-price-block">
          <span class="price-currency">$</span>
          <span class="price-amount" data-price-monthly="60" data-price-annual="48">60</span>
          <span class="price-period">/ mes</span>
        </div>

        <p>Para instituciones educativas y empresas con múltiples salas y auditoría integral.</p>

        <ul class="card-specs">
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span><strong>50+ PCs</strong> (Salas ilimitadas)</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span><strong>🎥 Acceso a Cámara en Vivo</strong></span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span><strong>🎙️ Intercomunicador de Voz / Micrófono</strong></span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>IA de Detección de Celular + Mirada</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Reportes de Auditoría e Incidentes</span></li>
        </ul>

        <div id="btn-container-enterprise">
          <?php if ($planActivoUsuario === 'ENTERPRISE'): ?>
            <button type="button" class="btn btn-plan-status active-btn" disabled>
              <i class="fas fa-crown"></i>
              <span>✓ Plan Enterprise <?= ($periodoPlan === 'annual' ? 'Anual' : 'Mensual') ?> Activo (<?= htmlspecialchars($expiracionPlan) ?>)</span>
            </button>
          <?php elseif ($planActivoUsuario === 'BASIC' || $planActivoUsuario === 'MEDIUM'): ?>
            <button type="button" class="btn btn-card btn-upgrade-action" data-plan="ENTERPRISE" onclick="abrirCheckoutModal('ENTERPRISE')">
              <i class="fas fa-crown" aria-hidden="true"></i>
              <span>Mejorar a Enterprise</span>
            </button>
          <?php else: ?>
            <button type="button" class="btn btn-card btn-buy-plan" data-plan="ENTERPRISE" onclick="abrirCheckoutModal('ENTERPRISE')">
              <i class="fas fa-crown" aria-hidden="true"></i>
              <span>Comprar Enterprise</span>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Sub-sección Descargas -->
    <?php require __DIR__ . '/downloads.php'; ?>
  </div>
</section>
