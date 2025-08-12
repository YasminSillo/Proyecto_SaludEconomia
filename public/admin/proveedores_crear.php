<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $datos = [
            'nombre_empresa' => trim($_POST['nombre_empresa'] ?? ''),
            'contacto_nombre' => trim($_POST['contacto_nombre'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'ruc' => trim($_POST['ruc'] ?? '')
        ];

        // Validaciones básicas
        if (empty($datos['nombre_empresa']) || empty($datos['contacto_nombre'])) {
            throw new Exception("El nombre de empresa y contacto son requeridos");
        }

        // Crear proveedor
        $crearProveedorUseCase = $bootstrap->getCrearProveedorUseCase();
        
        $resultado = $crearProveedorUseCase->ejecutar($datos);
        
        if ($resultado) {
            header('Location: proveedores.php?success=Proveedor creado exitosamente');
            exit;
        } else {
            throw new Exception("Error al guardar el proveedor en la base de datos");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$title = 'Crear Proveedor';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Crear Proveedor</h1>
            <p class="page-subtitle">Agregar nuevo proveedor al sistema</p>
        </div>
        <div class="page-actions">
            <a href="proveedores.php" class="btn btn-secondary">
                ← Volver a Proveedores
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
            <h3 class="form-title">Datos del Proveedor</h3>
        </div>

        <form method="POST" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="nombre_empresa">Nombre de la Empresa</label>
                    <input type="text" 
                           id="nombre_empresa" 
                           name="nombre_empresa" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['nombre_empresa'] ?? ''); ?>" 
                           required
                           placeholder="Ej: Laboratorios ABC S.A.">
                    <small class="form-text">Razón social o nombre comercial de la empresa</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="contacto_nombre">Nombre del Contacto</label>
                    <input type="text" 
                           id="contacto_nombre" 
                           name="contacto_nombre" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['contacto_nombre'] ?? ''); ?>" 
                           required
                           placeholder="Ej: Juan Pérez">
                    <small class="form-text">Nombre de la persona de contacto</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="email">Email de Contacto</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                           placeholder="contacto@empresa.com">
                    <small class="form-text">Dirección de correo electrónico principal</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="ruc">RUC</label>
                    <input type="text" 
                           id="ruc" 
                           name="ruc" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['ruc'] ?? ''); ?>" 
                           placeholder="20123456789"
                           pattern="[0-9]{11}"
                           maxlength="11">
                    <small class="form-text">Registro Único de Contribuyentes (11 dígitos)</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="proveedores.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-info">
                    🏢 Crear Proveedor
                </button>
            </div>
        </form>
    </div>
</main>

<script>
// Validación del RUC
document.getElementById('ruc').addEventListener('input', function(e) {
    // Solo permitir números
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Validación del formulario
document.querySelector('.crud-form').addEventListener('submit', function(e) {
    const nombreEmpresa = document.getElementById('nombre_empresa').value.trim();
    const contactoNombre = document.getElementById('contacto_nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const ruc = document.getElementById('ruc').value.trim();
    
    if (nombreEmpresa.length < 2) {
        e.preventDefault();
        alert('El nombre de la empresa debe tener al menos 2 caracteres');
        document.getElementById('nombre_empresa').focus();
        return;
    }
    
    if (contactoNombre.length < 2) {
        e.preventDefault();
        alert('El nombre del contacto debe tener al menos 2 caracteres');
        document.getElementById('contacto_nombre').focus();
        return;
    }
    
    if (email && !email.includes('@')) {
        e.preventDefault();
        alert('Por favor ingresa un email válido');
        document.getElementById('email').focus();
        return;
    }
    
    if (ruc && ruc.length !== 11) {
        e.preventDefault();
        alert('El RUC debe tener exactamente 11 dígitos');
        document.getElementById('ruc').focus();
        return;
    }
});
</script>

<?php require_once 'partials/footer.php'; ?>