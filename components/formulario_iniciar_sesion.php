<!-- Formulario de Iniciar Sesion -->
<section class="login-section">
    <div class="login-container">
        <div class="login-card">
            <!-- Header del formulario -->
            <div class="login-header">
                <div class="login-logo">
                    <img src="imagenes/logo_saludEconomia.png" alt="Salud y Economia" class="login-logo-img">
                    <h1 class="login-title">Salud y Economia</h1>
                </div>
                <h2 class="login-subtitle">Iniciar Sesion</h2>
                <p class="login-description">Accede a tu cuenta para gestionar tus pedidos</p>
            </div>

            <!-- Formulario -->
            <form class="login-form" action="#" method="POST">
                <!-- Campo Email -->
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

                <!-- Campo Contrasena -->
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
                               placeholder="Tu contrasena" 
                               required>
                        <button type="button" class="password-toggle" aria-label="Mostrar/ocultar contrasena">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-error" id="password-error"></div>
                </div>

                <!-- Recordar sesion y Olvide contrasena -->
                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" class="checkbox-input">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">Recordar sesion</span>
                    </label>
                    <a href="#" class="forgot-password">Olvidaste tu contrasena?</a>
                </div>

                <input type="hidden" 
                        id="formulario_iniciar_sesion" 
                        name="formulario_seleccionado" 
                        value="formulario_iniciar_sesion"
                        required>
                <!-- Boton de envio -->
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt login-btn-icon"></i>
                    Iniciar Sesion
                </button>

                <!-- Separador -->
                <div class="form-divider">
                    <span class="divider-text">O continua con</span>
                </div>

                <!-- Botones de redes sociales -->
                <div class="social-login">
                    <button type="button" class="social-btn social-btn--google">
                        <i class="fab fa-google"></i>
                        <span>Google</span>
                    </button>
                    <button type="button" class="social-btn social-btn--facebook">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </button>
                </div>

                <!-- Enlace de registro -->
                <div class="form-footer">
                    <p class="register-text">
                        No tienes una cuenta? 
                        <a href="iniciar_sesion.php?action=register" class="register-link">Registrate aqui</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Informacion adicional -->
        <div class="login-info">
            <div class="info-card">
                <i class="fas fa-shield-alt info-icon"></i>
                <h3 class="info-title">Seguridad Garantizada</h3>
                <p class="info-text">Tu informacion esta protegida con encriptacion de grado bancario.</p>
            </div>
            <div class="info-card">
                <i class="fas fa-truck info-icon"></i>
                <h3 class="info-title">Envios Rapidos</h3>
                <p class="info-text">Recibe tus productos farmaceuticos en tiempo record.</p>
            </div>
            <div class="info-card">
                <i class="fas fa-headset info-icon"></i>
                <h3 class="info-title">Soporte 24/7</h3>
                <p class="info-text">Estamos aqui para ayudarte cuando lo necesites.</p>
            </div>
        </div>
    </div>
</section>

<script>
// Script para mostrar/ocultar contrasena
document.addEventListener('DOMContentLoaded', function() {
    const passwordToggle = document.querySelector('.password-toggle');
    const passwordInput = document.querySelector('#password');
    const toggleIcon = passwordToggle.querySelector('i');

    passwordToggle.addEventListener('click', function() {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        toggleIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    });

    // Validacion basica del formulario
    const form = document.querySelector('.login-form');
    const emailInput = document.querySelector('#email');
    const emailError = document.querySelector('#email-error');
    const passwordError = document.querySelector('#password-error');

    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Validar email
        if (!emailInput.value || !emailInput.validity.valid) {
            emailError.textContent = 'Por favor, ingresa un email valido';
            emailError.style.display = 'block';
            isValid = false;
        } else {
            emailError.style.display = 'none';
        }

        // Validar contrasena
        if (!passwordInput.value || passwordInput.value.length < 6) {
            passwordError.textContent = 'La contrasena debe tener al menos 6 caracteres';
            passwordError.style.display = 'block';
            isValid = false;
        } else {
            passwordError.style.display = 'none';
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>