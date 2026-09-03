<?php
/**
 * SIMC — Vista Parcial: Sección FAQ (Preguntas Frecuentes)
 */
?>
<section class="faq-section section" id="faq">
  <div class="container">
    <div class="section-label reveal">// dudas resueltas</div>
    <h2 class="section-title reveal">Preguntas <span class="gradient-text">Frecuentes</span></h2>
    <p class="section-desc reveal">Todo lo que necesitas saber sobre privacidad, requerimientos y funcionamiento técnico de SIMC.</p>

    <div class="faq-container reveal">
      <div class="faq-list">
        <div class="faq-item">
          <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-ans-1">
            <span>¿Cómo se protege la privacidad de los usuarios?</span>
            <span class="faq-icon-wrap" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
          </button>
          <div class="faq-panel" id="faq-ans-1">
            <div class="faq-content">
              <p>
                <strong>SIMC no almacena video continuo</strong>. El modelo de IA procesa la imagen en tiempo real en la memoria del equipo local y solo extrae métricas matemáticas de atención. Ante incidentes de distracción o celular, se genera un registro seguro de auditoría.
              </p>
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-ans-2">
            <span>¿Qué requerimientos de hardware necesitan las PCs?</span>
            <span class="faq-icon-wrap" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
          </button>
          <div class="faq-panel" id="faq-ans-2">
            <div class="faq-content">
              <p>
                El cliente <strong>SIMC Agente</strong> está optimizado para funcionar en cualquier procesador Intel Core i3 / AMD Ryzen 3 o superior con 4 GB de RAM y una cámara web convencional USB o integrada.
              </p>
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-ans-3">
            <span>¿Funciona en redes locales (LAN) sin conexión a internet?</span>
            <span class="faq-icon-wrap" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
          </button>
          <div class="faq-panel" id="faq-ans-3">
            <div class="faq-content">
              <p>
                <strong>Sí, 100%</strong>. SIMC cuenta con un servidor WebSocket local que permite que todas las computadoras del aula o laboratorio se comuniquen directamente con el panel docente sin consumir internet.
              </p>
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-ans-4">
            <span>¿Cómo funciona el bloqueo remoto de aplicaciones?</span>
            <span class="faq-icon-wrap" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
          </button>
          <div class="faq-panel" id="faq-ans-4">
            <div class="faq-content">
              <p>
                Desde el panel del supervisor, se pueden definir reglas de bloqueo de programas (juegos, redes sociales) que despliegan una pantalla preventiva en el equipo del alumno cuando se detecta actividad fuera de foco.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
