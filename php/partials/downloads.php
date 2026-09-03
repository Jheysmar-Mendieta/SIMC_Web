<!-- Sección descargas de software oficial -->
<div class="downloads-section-wrapper reveal" id="descargas">
  <div style="text-align: center; margin-bottom: 32px;">
    <div class="section-label" style="display:inline-flex;">// centro de descargas oficial</div>
    <h3 style="font-family:'Orbitron', sans-serif; font-size: 1.9rem; color: #fff; margin-top: 8px;">
      Descargar <span class="gradient-text">Ecosistema SIMC PRO</span>
    </h3>
    <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 640px; margin: 8px auto 0;">
      Elegí la versión para tu dispositivo: aplicaciones móviles Android (.APK) o ejecutables para computadoras Windows (.EXE).
    </p>

    <!-- Selector de Plataforma (Tabs) -->
    <div class="download-tabs-nav">
      <button class="dl-tab-btn active" onclick="cambiarTabDescargas('apk')">
        <i class="fab fa-android"></i> <span>Aplicaciones Android (.APK)</span>
      </button>
      <button class="dl-tab-btn" onclick="cambiarTabDescargas('exe')">
        <i class="fab fa-windows"></i> <span>Software Windows PC (.EXE)</span>
      </button>
    </div>
  </div>

  <!-- PARTE 1: ANDROID APKS -->
  <div id="tab-descargas-apk" class="products-grid download-tab-content active">
    
    <!-- APK 1: SUPERVISOR MOBILE -->
    <div class="download-card">
      <div class="download-meta-badges">
        <span class="tag-version">DOCENTE / PADRES</span>
        <span class="tag-size">Android APK</span>
      </div>
      <div class="card-icon" style="color:var(--cyan);"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></div>
      <h3>SIMC Supervisor</h3>
      <p>App oficial para celulares de madres, padres o docentes. Permite crear salas, ver cuadrícula de alumnos, cámaras y enviar mensajes de voz.</p>
      
      <ul class="card-specs">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Creación y gestión de salas en la nube</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Monitoreo en vivo 4G y WiFi</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Control y bloqueo de dispositivos</span></li>
      </ul>

      <a href="descargas/apk/SIMC_Supervisor.apk?v=<?= time() ?>" class="btn btn-primary btn-download" download>
        <i class="fas fa-download" aria-hidden="true"></i>
        <span>Descargar Supervisor (.apk)</span>
      </a>
    </div>

    <!-- APK 2: AGENTE ALUMNO MOBILE -->
    <div class="download-card">
      <div class="download-meta-badges">
        <span class="tag-version">ALUMNO / HIJO</span>
        <span class="tag-size">Android APK</span>
      </div>
      <div class="card-icon" style="color:#38bdf8;"><i class="fas fa-mobile-alt" aria-hidden="true"></i></div>
      <h3>SIMC Agente</h3>
      <p>App para el celular del alumno ("Dejar monitorear mi celular"). Vinculación directa por Token y monitoreo de estudio en segundo plano.</p>
      
      <ul class="card-specs">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Conexión instantánea por Token</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Detección de distracciones en vivo</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Sincronizado con el aula oficial</span></li>
      </ul>

      <a href="descargas/apk/SIMC_Agente.apk?v=<?= time() ?>" class="btn btn-primary btn-download" download>
        <i class="fas fa-download" aria-hidden="true"></i>
        <span>Descargar Agente (.apk)</span>
      </a>
    </div>

    <!-- APK 3: MODO INDIVIDUAL MOBILE -->
    <div class="download-card">
      <div class="download-meta-badges">
        <span class="tag-version">MODO SOLO / FOCUS</span>
        <span class="tag-size">Android APK</span>
      </div>
      <div class="card-icon" style="color:#a855f7;"><i class="fas fa-brain" aria-hidden="true"></i></div>
      <h3>SIMC Individual</h3>
      <p>App personal de autodisciplina y estudio. Temporizador Pomodoro, métricas de rendimiento y bloqueo de redes sociales.</p>
      
      <ul class="card-specs">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Modos Pomodoro (25m, 45m, 60m)</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Métricas de % productivo vs ocio</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Reglas de bloqueo personalizadas</span></li>
      </ul>

      <a href="descargas/apk/SIMC_Individual.apk?v=<?= time() ?>" class="btn btn-primary btn-download" download>
        <i class="fas fa-download" aria-hidden="true"></i>
        <span>Descargar Individual (.apk)</span>
      </a>
    </div>

  </div>

  <!-- PARTE 2: WINDOWS PC EXES -->
  <div id="tab-descargas-exe" class="products-grid download-tab-content">
    
    <!-- EXE 1: SUPERVISOR DESKTOP -->
    <div class="download-card">
      <div class="download-meta-badges">
        <span class="tag-version">DOCENTE / ADMIN</span>
        <span class="tag-size">Windows PC</span>
      </div>
      <div class="card-icon" style="color:#818cf8;"><i class="fas fa-desktop" aria-hidden="true"></i></div>
      <h3>SIMC Supervisor Desktop</h3>
      <p>Panel de control centralizado de escritorio para administrar salas, límites de PCs, bloqueos y transmisiones en vivo.</p>
      
      <ul class="card-specs">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Compatible con <strong>Windows 10 y 11</strong></span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Gestión de salas y límites de computadoras</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Intercomunicador y avisos de voz</span></li>
      </ul>

      <a href="descargas/SIMC_Supervisor.exe?v=<?= time() ?>" class="btn btn-card btn-download" download>
        <i class="fas fa-download" aria-hidden="true"></i>
        <span>Descargar Supervisor (.exe)</span>
      </a>
    </div>

    <!-- EXE 2: AGENTE ALUMNO EXE -->
    <div class="download-card">
      <div class="download-meta-badges">
        <span class="tag-version">CLIENTE ALUMNO</span>
        <span class="tag-size">Windows PC</span>
      </div>
      <div class="card-icon" style="color:#38bdf8;"><i class="fas fa-laptop-code" aria-hidden="true"></i></div>
      <h3>SIMC Agente Alumno</h3>
      <p>Instalador cliente para la computadora del alumno. Detección automática con IA YOLOv8 de uso indebido de celular.</p>
      
      <ul class="card-specs">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Compatible con <strong>Windows 10 y 11</strong></span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>IA integrada de detección de celular</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Conexión segura y cifrada por Token</span></li>
      </ul>

      <a href="descargas/SIMC_Agente.exe?v=<?= time() ?>" class="btn btn-card btn-download" download>
        <i class="fas fa-download" aria-hidden="true"></i>
        <span>Descargar Agente (.exe)</span>
      </a>
    </div>

    <!-- EXE 3: INDIVIDUAL SOLO EXE -->
    <div class="download-card">
      <div class="download-meta-badges">
        <span class="tag-version">MODO SOLO / FOCUS</span>
        <span class="tag-size">Windows PC</span>
      </div>
      <div class="card-icon" style="color:#a855f7;"><i class="fas fa-user-shield" aria-hidden="true"></i></div>
      <h3>SIMC Individual PC</h3>
      <p>Monitoreo local de concentración para tu computadora. Detecta ventanas activas, mide productividad y bloquea distracciones.</p>
      
      <ul class="card-specs">
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Compatible con <strong>Windows 10 y 11</strong></span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Detección de ventanas y apps en tiempo real</span></li>
        <li><i class="fas fa-check-circle" aria-hidden="true"></i> <span>Bloqueo automático de pantalla ante ocio</span></li>
      </ul>

      <a href="descargas/SIMC_Individual.exe?v=<?= time() ?>" class="btn btn-card btn-download" download>
        <i class="fas fa-download" aria-hidden="true"></i>
        <span>Descargar Individual (.exe)</span>
      </a>
    </div>

  </div>
</div>

<script>
function cambiarTabDescargas(tipo) {
  const tabApk = document.getElementById('tab-descargas-apk');
  const tabExe = document.getElementById('tab-descargas-exe');
  const btns = document.querySelectorAll('.dl-tab-btn');

  btns.forEach(b => b.classList.remove('active'));

  if (tipo === 'apk') {
    btns[0].classList.add('active');
    tabApk.classList.add('active');
    tabExe.classList.remove('active');
  } else {
    btns[1].classList.add('active');
    tabExe.classList.add('active');
    tabApk.classList.remove('active');
  }
}
</script>
