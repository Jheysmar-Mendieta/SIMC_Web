<?php
/**
 * SIMC — Vista Parcial: Hero Section
 */
?>
<section class="hero" id="hero">
  <div class="hero-bg" aria-hidden="true">
    <canvas id="heroCanvas"></canvas>
    <div class="hero-grid"></div>
    <div class="hero-glow glow-1"></div>
    <div class="hero-glow glow-2"></div>
  </div>

  <div class="container hero-content fade-in">
    <div class="hero-badge">
      <span class="pulse-dot" aria-hidden="true"></span>
      <span>SISTEMA DE MONITOREO DE CONCENTRACIÓN IA EN TIEMPO REAL</span>
    </div>

    <h1 class="hero-title">
      Monitoreo Inteligente<br />
      <span class="gradient-text">de Concentración</span><br />
      en Tiempo Real
    </h1>

    <p class="hero-subtitle">
      Impulsado por <strong>Inteligencia Artificial (YOLOv8)</strong> y <strong>Visión Computacional</strong> —
      analizamos el nivel de atención humana, detectamos uso indebido de celulares y prevenimos el ocio 
      <strong>sin sensores físicos invasivos</strong>.
    </p>

    <div class="hero-cta">
      <a href="#products" class="btn btn-primary">
        <span>Ver Membresías</span>
        <i class="fas fa-arrow-right" aria-hidden="true"></i>
      </a>

      <?php if (!$loggedIn): ?>
        <a href="#" class="btn btn-ghost" id="openRegister" role="button">
          <i class="fas fa-user-plus" aria-hidden="true"></i>
          <span>Crear Cuenta</span>
        </a>
      <?php elseif ($rol === 'admin'): ?>
        <a href="admin/dashboard.php" class="btn btn-ghost">
          <i class="fas fa-gauge-high" aria-hidden="true"></i>
          <span>Ir a mi Panel</span>
        </a>
      <?php else: ?>
        <a href="#descargas" class="btn btn-ghost">
          <i class="fas fa-download" aria-hidden="true"></i>
          <span>Descargar Apps</span>
        </a>
      <?php endif; ?>
    </div>

    <!-- Métricas Principales -->
    <div class="hero-stats" role="region" aria-label="Métricas de rendimiento">
      <div class="stat">
        <div class="stat-num-wrapper">
          <span class="stat-num" data-target="98">0</span><span class="stat-suffix">%</span>
        </div>
        <span class="stat-label">Precisión IA</span>
      </div>
      <div class="stat-divider" aria-hidden="true"></div>
      <div class="stat">
        <div class="stat-num-wrapper">
          <span class="stat-num" data-target="24">0</span><span class="stat-suffix">ms</span>
        </div>
        <span class="stat-label">Latencia LAN</span>
      </div>
      <div class="stat-divider" aria-hidden="true"></div>
      <div class="stat">
        <div class="stat-num-wrapper">
          <span class="stat-num" data-target="0">0</span>
        </div>
        <span class="stat-label">Sensores Físicos</span>
      </div>
    </div>
  </div>

  <div class="hero-scroll-hint" aria-hidden="true">
    <span>Deslizar</span>
    <div class="scroll-line"></div>
  </div>
</section>
