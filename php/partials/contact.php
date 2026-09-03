<?php
/**
 * SIMC — Vista Parcial: Sección Contacto
 */
?>
<section class="contact section" id="contact">
  <div class="container">
    <div class="section-label reveal">// contacto</div>
    <h2 class="section-title reveal">¿Listo para <span class="gradient-text">comenzar</span>?</h2>
    <p class="section-desc reveal">Contactanos y un especialista te responderá en menos de 24 horas.</p>

    <div class="contact-grid">
      <div class="contact-info reveal">
        <div class="info-item">
          <i class="fas fa-envelope" aria-hidden="true"></i>
          <div>
            <strong style="color:var(--text-primary); display:block; font-size:0.85rem;">Email</strong>
            <span>contacto@simc-ai.com</span>
          </div>
        </div>
        <div class="info-item">
          <i class="fas fa-phone" aria-hidden="true"></i>
          <div>
            <strong style="color:var(--text-primary); display:block; font-size:0.85rem;">Teléfono</strong>
            <span>+54 11 0000-0000</span>
          </div>
        </div>
        <div class="info-item">
          <i class="fas fa-location-dot" aria-hidden="true"></i>
          <div>
            <strong style="color:var(--text-primary); display:block; font-size:0.85rem;">Ubicación</strong>
            <span>Buenos Aires, Argentina</span>
          </div>
        </div>

        <div class="info-socials" aria-label="Redes sociales">
          <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
          <a href="#" class="social-icon" aria-label="GitHub"><i class="fab fa-github" aria-hidden="true"></i></a>
          <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-x-twitter" aria-hidden="true"></i></a>
          <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
        </div>
      </div>

      <form class="contact-form reveal" id="contactForm" novalidate>
        <div class="form-group">
          <label for="contactName">Nombre completo</label>
          <input type="text" id="contactName" name="name" placeholder="Tu nombre" required autocomplete="name" />
        </div>

        <div class="form-group">
          <label for="contactEmail">Correo electrónico</label>
          <input type="email" id="contactEmail" name="email" placeholder="tu@email.com" required autocomplete="email" />
        </div>

        <div class="form-group">
          <label for="contactMessage">Mensaje</label>
          <textarea id="contactMessage" name="message" rows="4" placeholder="¿En qué podemos ayudarte?" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-full">
          <span>Enviar consulta</span>
          <i class="fas fa-paper-plane" aria-hidden="true"></i>
        </button>

        <p class="form-note" id="formNote" role="status" aria-live="polite"></p>
      </form>
    </div>
  </div>
</section>
