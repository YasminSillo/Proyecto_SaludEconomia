<!-- Seccion de Contacto para Ser Patrocinador -->
<section class="sponsors-contact" id="sponsors-contact">
    <div class="sponsors-contact-container">
        <div class="sponsors-contact-content">
            <!-- Informacion de contacto -->
            <div class="contact-info">
                <div class="contact-info-header">
                    <h2 class="contact-info-title">
                        <span class="contact-title-accent">Conviertete</span>
                        en Nuestro Patrocinador
                    </h2>
                    <p class="contact-info-description">
                        Contactanos para discutir oportunidades de partnership y 
                        descubre como podemos hacer crecer tu marca juntos.
                    </p>
                </div>

                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="contact-method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-method-info">
                            <h4 class="contact-method-title">Telefono</h4>
                            <p class="contact-method-detail">+51 987 654 321</p>
                            <span class="contact-method-note">Lunes a Viernes 8:00 - 18:00</span>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div class="contact-method-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-method-info">
                            <h4 class="contact-method-title">Email</h4>
                            <p class="contact-method-detail">partnerships@saludeconomia.com</p>
                            <span class="contact-method-note">Respuesta en 24 horas</span>
                        </div>
                    </div>

                    <div class="contact-method">
                        <div class="contact-method-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-method-info">
                            <h4 class="contact-method-title">Oficina Principal</h4>
                            <p class="contact-method-detail">Av. Javier Prado Este 123, San Isidro</p>
                            <span class="contact-method-note">Lima, Peru</span>
                        </div>
                    </div>
                </div>

                <div class="contact-additional-info">
                    <div class="additional-info-item">
                        <i class="fas fa-clock"></i>
                        <div class="additional-info-content">
                            <strong>Horarios de Atencion</strong>
                            <span>Lun - Vie: 8:00 AM - 6:00 PM</span>
                            <span>Sab: 9:00 AM - 1:00 PM</span>
                        </div>
                    </div>
                    <div class="additional-info-item">
                        <i class="fas fa-handshake"></i>
                        <div class="additional-info-content">
                            <strong>Tiempo de Respuesta</strong>
                            <span>Consultas: 24 horas</span>
                            <span>Propuestas: 48-72 horas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de contacto -->
            <div class="contact-form-wrapper">
                <form class="contact-form" action="#" method="POST">
                    <div class="contact-form-header">
                        <h3 class="contact-form-title">Solicitar Informacion</h3>
                        <p class="contact-form-subtitle">
                            Completa el formulario y nos comunicaremos contigo pronto
                        </p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="empresa" class="form-label">
                                <i class="fas fa-building form-label-icon"></i>
                                Nombre de la Empresa
                            </label>
                            <input type="text" 
                                   id="empresa" 
                                   name="empresa" 
                                   class="form-input" 
                                   placeholder="Tu empresa o laboratorio"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="contacto_nombre" class="form-label">
                                <i class="fas fa-user form-label-icon"></i>
                                Persona de Contacto
                            </label>
                            <input type="text" 
                                   id="contacto_nombre" 
                                   name="contacto_nombre" 
                                   class="form-input" 
                                   placeholder="Nombre completo"
                                   required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope form-label-icon"></i>
                                Email Corporativo
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-input" 
                                   placeholder="contacto@empresa.com"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="telefono" class="form-label">
                                <i class="fas fa-phone form-label-icon"></i>
                                Telefono
                            </label>
                            <input type="tel" 
                                   id="telefono" 
                                   name="telefono" 
                                   class="form-input" 
                                   placeholder="+51 987 654 321"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tipo_empresa" class="form-label">
                            <i class="fas fa-industry form-label-icon"></i>
                            Tipo de Empresa
                        </label>
                        <select id="tipo_empresa" 
                                name="tipo_empresa" 
                                class="form-input form-select" 
                                required>
                            <option value="">Selecciona una opcion</option>
                            <option value="laboratorio_nacional">Laboratorio Nacional</option>
                            <option value="laboratorio_internacional">Laboratorio Internacional</option>
                            <option value="distribuidor">Distribuidor</option>
                            <option value="fabricante_dispositivos">Fabricante de Dispositivos Medicos</option>
                            <option value="suplementos">Empresa de Suplementos</option>
                            <option value="cosmetica">Cosmetica y Cuidado Personal</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="productos_principales" class="form-label">
                                <i class="fas fa-pills form-label-icon"></i>
                                Productos Principales
                            </label>
                            <input type="text" 
                                   id="productos_principales" 
                                   name="productos_principales" 
                                   class="form-input" 
                                   placeholder="Ej: Antibioticos, Analgesicos, Vitaminas">
                        </div>

                        <div class="form-group">
                            <label for="volumen_mensual" class="form-label">
                                <i class="fas fa-chart-bar form-label-icon"></i>
                                Volumen Mensual Estimado
                            </label>
                            <select id="volumen_mensual" 
                                    name="volumen_mensual" 
                                    class="form-input form-select">
                                <option value="">Selecciona un rango</option>
                                <option value="menor_1000">Menos de 1,000 unidades</option>
                                <option value="1000_5000">1,000 - 5,000 unidades</option>
                                <option value="5000_10000">5,000 - 10,000 unidades</option>
                                <option value="10000_50000">10,000 - 50,000 unidades</option>
                                <option value="mayor_50000">Mas de 50,000 unidades</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mensaje" class="form-label">
                            <i class="fas fa-comment form-label-icon"></i>
                            Mensaje (Opcional)
                        </label>
                        <textarea id="mensaje" 
                                  name="mensaje" 
                                  class="form-input form-textarea" 
                                  placeholder="Cuentanos mas sobre tu empresa y que esperas de esta alianza..."
                                  rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="acepta_terminos" class="checkbox-input" required>
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">
                                Acepto recibir comunicaciones comerciales y acepto los 
                                <a href="#" class="terms-link">terminos y condiciones</a>
                            </span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="info_adicional" class="checkbox-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">
                                Deseo recibir informacion sobre eventos y novedades del sector
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="contact-submit-btn">
                        <i class="fas fa-paper-plane contact-btn-icon"></i>
                        Enviar Solicitud
                    </button>
                </form>
            </div>
        </div>

        <!-- Seccion de pasos siguientes -->
        <div class="next-steps">
            <div class="next-steps-header">
                <h3 class="next-steps-title">¿Que Pasa Despues?</h3>
                <p class="next-steps-subtitle">Nuestro proceso de evaluacion es rapido y transparente</p>
            </div>
            
            <div class="steps-timeline">
                <div class="timeline-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4 class="step-title">Evaluacion Inicial</h4>
                        <p class="step-description">Revisamos tu solicitud y productos en 48 horas</p>
                    </div>
                </div>
                
                <div class="timeline-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4 class="step-title">Reunion de Presentacion</h4>
                        <p class="step-description">Programamos una video llamada para conocer mas detalles</p>
                    </div>
                </div>
                
                <div class="timeline-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4 class="step-title">Propuesta Comercial</h4>
                        <p class="step-description">Elaboramos una propuesta personalizada para tu empresa</p>
                    </div>
                </div>
                
                <div class="timeline-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4 class="step-title">Inicio de Alianza</h4>
                        <p class="step-description">Firmamos acuerdos y comenzamos la distribucion</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>