<?php 
require_once __DIR__ . '/../src/Bootstrap.php';
$bootstrap = new Bootstrap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_POST["formulario_seleccionado"] === "formulario_iniciar_sesion") {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = "Email y contraseña son requeridos";
            } else {
                $autenticarUseCase = $bootstrap->getAutenticarUsuarioUseCase();
                $usuario = $autenticarUseCase->ejecutar($email, $password);
                
                session_start();
                $_SESSION['usuario_id'] = $usuario->getId();
                $_SESSION['usuario_nombre'] = $usuario->getNombre();
                $_SESSION['usuario_rol'] = $usuario->getRol();
                
                if ($usuario->getRol() === 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            }
        } elseif ($_POST["formulario_seleccionado"] === "formulario_registro") {
            $nombre = ($_POST['nombre'] ?? '') . ' ' . ($_POST['apellido'] ?? '');
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($nombre) || empty($email) || empty($password)) {
                $error = "Todos los campos son requeridos";
            } elseif ($password !== $confirmPassword) {
                $error = "Las contraseñas no coinciden";
            } else {
                $crearUsuarioUseCase = $bootstrap->getCrearUsuarioUseCase();
                $crearUsuarioUseCase->ejecutar($nombre, $email, $password);
                
                $crearClienteUseCase = $bootstrap->getCrearClienteUseCase();
                $tipoCliente = !empty($_POST['ruc']) ? 'juridico' : 'natural';
                $rucDni = !empty($_POST['ruc']) ? $_POST['ruc'] : $_POST['dni'];
                $crearClienteUseCase->ejecutar($tipoCliente, $nombre, $email, $rucDni);
                
                $success = "Usuario registrado exitosamente";
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}


// Determinar que formulario mostrar basado en el parametro GET
$mostrar_registro = isset($_GET['action']) && $_GET['action'] === 'register';

// Mensajes del sistema
if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    $success = "Sesión cerrada correctamente";
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

require_once __DIR__ . '/../components/header.php'; 
?>
<body>
    <!--ESTRUCTURA PRINCIPAL CON CSS GRID-->
    <?php require_once __DIR__ . '/../components/navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL-->
    <main class="main">
        <?php if (isset($error)): ?>
            <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 10px; margin: 10px; border-radius: 5px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="success-message" style="background: #d4edda; color: #155724; padding: 10px; margin: 10px; border-radius: 5px;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php 
        if ($mostrar_registro) {
            require_once __DIR__ . '/../components/formulario_registro.php';
        } else {
            require_once __DIR__ . '/../components/formulario_iniciar_sesion.php';
        }
        ?>
    </main>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>


