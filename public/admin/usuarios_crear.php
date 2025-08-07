<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $rol = $_POST['rol'] ?? 'vendedor';

        if (empty($nombre) || empty($email) || empty($password)) {
            throw new Exception("Todos los campos son requeridos");
        }

        $crearUsuarioUseCase = $bootstrap->getCrearUsuarioUseCase();
        $crearUsuarioUseCase->ejecutar($nombre, $email, $password, $rol);

        header('Location: usuarios.php?success=Usuario creado exitosamente');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$title = 'Crear Usuario';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Crear Usuario</h1>
            <p class="page-subtitle">Agregar nuevo usuario al sistema</p>
        </div>
        <div class="page-actions">
            <a href="usuarios.php" class="btn btn-secondary">
                ← Volver a Usuarios
            </a>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible">
            <?php echo htmlspecialchars($error); ?>
            <button class="alert-close">&times;</button>
        </div>
    <?php endif; ?>

    <div class="crud-form-container">
        <div class="form-header">
            <h3 class="form-title">Datos del Usuario</h3>
        </div>

        <form method="POST" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="nombre">Nombre completo</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
                           required>
                    <small class="form-text">Nombre y apellidos del usuario</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="email">Correo electrónico</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                           required>
                    <small class="form-text">Email único para acceso al sistema</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control" 
                           required>
                    <small class="form-text">Mínimo 6 caracteres</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="rol">Rol del usuario</label>
                    <select id="rol" name="rol" class="form-control" required>
                        <option value="">Seleccionar rol</option>
                        <option value="vendedor" <?php echo ($_POST['rol'] ?? '') === 'vendedor' ? 'selected' : ''; ?>>
                            Vendedor
                        </option>
                        <option value="admin" <?php echo ($_POST['rol'] ?? '') === 'admin' ? 'selected' : ''; ?>>
                            Administrador
                        </option>
                    </select>
                    <small class="form-text">Define los permisos del usuario</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="usuarios.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>