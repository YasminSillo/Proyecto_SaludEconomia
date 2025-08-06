<!-- Formulario de Registro -->
<section class="register-section">
    <div class="register-container">
        <div class="register-card">
            <!-- Header del formulario -->
            <div class="register-header">
                <div class="register-logo">
                    <img src="imagenes/logo_saludEconomia.png" alt="Salud y Economia" class="register-logo-img">
                    <h1 class="register-title">Salud y Economia</h1>
                </div>
                <h2 class="register-subtitle">Crear Cuenta</h2>
                <p class="register-description">Unete a nosotros y accede a los mejores productos farmaceuticos</p>
            </div>

            <!-- Formulario -->
            <form class="register-form" action="#" method="POST">
                <!-- Datos Personales -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-user form-section-icon"></i>
                        Datos Personales
                    </h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user form-label-icon"></i>
                                Nombre
                            </label>
                            <input type="text" 
                                   id="nombre" 
                                   name="nombre" 
                                   class="form-input" 
                                   placeholder="Tu nombre" 
                                   required>
                            <div class="form-error" id="nombre-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="apellido" class="form-label">
                                <i class="fas fa-user form-label-icon"></i>
                                Apellido
                            </label>
                            <input type="text" 
                                   id="apellido" 
                                   name="apellido" 
                                   class="form-input" 
                                   placeholder="Tu apellido" 
                                   required>
                            <div class="form-error" id="apellido-error"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="dni" class="form-label">
                                <i class="fas fa-id-card form-label-icon"></i>
                                DNI
                            </label>
                            <input type="text" 
                                   id="dni" 
                                   name="dni" 
                                   class="form-input" 
                                   placeholder="12345678" 
                                   maxlength="8"
                                   pattern="[0-9]{8}"
                                   required>
                            <div class="form-error" id="dni-error"></div>
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
                                   placeholder="987654321" 
                                   required>
                            <div class="form-error" id="telefono-error"></div>
                        </div>
                    </div>
                </div>

                <!-- Datos de la Empresa/Negocio -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-building form-section-icon"></i>
                        Datos del Negocio
                    </h3>

                    <div class="form-group">
                        <label for="empresa" class="form-label">
                            <i class="fas fa-building form-label-icon"></i>
                            Nombre de la Empresa/Negocio
                        </label>
                        <input type="text" 
                               id="empresa" 
                               name="empresa" 
                               class="form-input" 
                               placeholder="Farmacia San Jose" 
                               required>
                        <div class="form-error" id="empresa-error"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ruc" class="form-label">
                                <i class="fas fa-file-alt form-label-icon"></i>
                                RUC (Opcional)
                            </label>
                            <input type="text" 
                                   id="ruc" 
                                   name="ruc" 
                                   class="form-input" 
                                   placeholder="20123456789" 
                                   maxlength="11"
                                   pattern="[0-9]{11}">
                            <div class="form-error" id="ruc-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_negocio" class="form-label">
                                <i class="fas fa-store form-label-icon"></i>
                                Tipo de Negocio
                            </label>
                            <select id="tipo_negocio" 
                                    name="tipo_negocio" 
                                    class="form-input form-select" 
                                    required>
                                <option value="">Selecciona una opcion</option>
                                <option value="farmacia">Farmacia</option>
                                <option value="botica">Botica</option>
                                <option value="clinica">Clinica</option>
                                <option value="hospital">Hospital</option>
                                <option value="centro_salud">Centro de Salud</option>
                                <option value="otro">Otro</option>
                            </select>
                            <div class="form-error" id="tipo_negocio-error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="form-label">
                            <i class="fas fa-map-marker-alt form-label-icon"></i>
                            Direccion del Negocio
                        </label>
                        <input type="text" 
                               id="direccion" 
                               name="direccion" 
                               class="form-input" 
                               placeholder="Av. Principal 123, Lima" 
                               required>
                        <div class="form-error" id="direccion-error"></div>
                    </div>
                </div>

                <!-- Datos de Cuenta -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-key form-section-icon"></i>
                        Datos de Cuenta
                    </h3>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope form-label-icon"></i>
                            Correo Electronico
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               placeholder="tu@email.com" 
                               required>
                        <div class="form-error" id="email-error"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock form-label-icon"></i>
                                Contrasena
                            </label>
                            <div class="password-field">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-input" 
                                       placeholder="Minimo 8 caracteres" 
                                       minlength="8"
                                       required>
                                <button type="button" class="password-toggle" aria-label="Mostrar/ocultar contrasena">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-error" id="password-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">
                                <i class="fas fa-lock form-label-icon"></i>
                                Confirmar Contrasena
                            </label>
                            <div class="password-field">
                                <input type="password" 
                                       id="confirm_password" 
                                       name="confirm_password" 
                                       class="form-input" 
                                       placeholder="Repite tu contrasena" 
                                       required>
                                <button type="button" class="password-toggle" aria-label="Mostrar/ocultar contrasena">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-error" id="confirm_password-error"></div>
                        </div>
                    </div>
                </div>

                <!-- Terminos y condiciones -->
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" class="checkbox-input" required>
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">
                            Acepto los 
                            <a href="#" class="terms-link">Terminos y Condiciones</a> 
                            y la 
                            <a href="#" class="terms-link">Politica de Privacidad</a>
                        </span>
                    </label>
                    <div class="form-error" id="terms-error"></div>
                </div>

                <!-- Boton de envio -->
                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus register-btn-icon"></i>
                    Crear Cuenta
                </button>

                <!-- Enlace de login -->
                <div class="form-footer">
                    <p class="login-text">
                        Ya tienes una cuenta? 
                        <a href="iniciar_sesion.php" class="login-link">Inicia sesion aqui</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Beneficios -->
        <div class="register-benefits">
            <h3 class="benefits-title">Beneficios de registrarte</h3>
            
            <div class="benefit-card">
                <i class="fas fa-percentage benefit-icon"></i>
                <h4 class="benefit-title">Precios Especiales</h4>
                <p class="benefit-text">Accede a precios preferenciales y descuentos exclusivos para miembros.</p>
            </div>

            <div class="benefit-card">
                <i class="fas fa-shipping-fast benefit-icon"></i>
                <h4 class="benefit-title">Envio Gratis</h4>
                <p class="benefit-text">Disfruta de envio gratuito en compras mayores a S/200.</p>
            </div>

            <div class="benefit-card">
                <i class="fas fa-clock benefit-icon"></i>
                <h4 class="benefit-title">Entrega Rapida</h4>
                <p class="benefit-text">Recibe tus productos en 24-48 horas en Lima y Callao.</p>
            </div>

            <div class="benefit-card">
                <i class="fas fa-chart-line benefit-icon"></i>
                <h4 class="benefit-title">Reportes de Ventas</h4>
                <p class="benefit-text">Accede a reportes detallados de tus compras y movimientos.</p>
            </div>

            <div class="benefit-card">
                <i class="fas fa-phone-alt benefit-icon"></i>
                <h4 class="benefit-title">Soporte Prioritario</h4>
                <p class="benefit-text">Atencion personalizada y soporte tecnico especializado.</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad para mostrar/ocultar contrasenas
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    });

    // Validacion del formulario
    const form = document.querySelector('.register-form');
    const inputs = {
        nombre: document.querySelector('#nombre'),
        apellido: document.querySelector('#apellido'),
        dni: document.querySelector('#dni'),
        telefono: document.querySelector('#telefono'),
        empresa: document.querySelector('#empresa'),
        email: document.querySelector('#email'),
        password: document.querySelector('#password'),
        confirm_password: document.querySelector('#confirm_password'),
        terms: document.querySelector('input[name="terms"]')
    };

    // Validacion en tiempo real del DNI
    inputs.dni.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
    });

    // Validacion en tiempo real del RUC
    const rucInput = document.querySelector('#ruc');
    if (rucInput) {
        rucInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
        });
    }

    // Validacion del formulario al enviar
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Validar nombre
        if (!inputs.nombre.value.trim()) {
            showError('nombre', 'El nombre es requerido');
            isValid = false;
        } else {
            hideError('nombre');
        }

        // Validar apellido
        if (!inputs.apellido.value.trim()) {
            showError('apellido', 'El apellido es requerido');
            isValid = false;
        } else {
            hideError('apellido');
        }

        // Validar DNI
        if (!inputs.dni.value || inputs.dni.value.length !== 8) {
            showError('dni', 'El DNI debe tener 8 digitos');
            isValid = false;
        } else {
            hideError('dni');
        }

        // Validar email
        if (!inputs.email.value || !inputs.email.validity.valid) {
            showError('email', 'Por favor, ingresa un email valido');
            isValid = false;
        } else {
            hideError('email');
        }

        // Validar contrasena
        if (!inputs.password.value || inputs.password.value.length < 8) {
            showError('password', 'La contrasena debe tener al menos 8 caracteres');
            isValid = false;
        } else {
            hideError('password');
        }

        // Validar confirmacion de contrasena
        if (inputs.password.value !== inputs.confirm_password.value) {
            showError('confirm_password', 'Las contrasenas no coinciden');
            isValid = false;
        } else {
            hideError('confirm_password');
        }

        // Validar terminos y condiciones
        if (!inputs.terms.checked) {
            showError('terms', 'Debes aceptar los terminos y condiciones');
            isValid = false;
        } else {
            hideError('terms');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    function showError(fieldName, message) {
        const errorDiv = document.querySelector('#' + fieldName + '-error');
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
    }

    function hideError(fieldName) {
        const errorDiv = document.querySelector('#' + fieldName + '-error');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
    }
});
</script>