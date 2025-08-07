<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $tipoCliente = $_POST['tipo_cliente'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? null;
        $rucDni = $_POST['ruc_dni'] ?? null;

        if (empty($tipoCliente) || empty($nombre)) {
            throw new Exception("Tipo de cliente y nombre son requeridos");
        }

        $crearClienteUseCase = $bootstrap->getCrearClienteUseCase();
        $crearClienteUseCase->ejecutar($tipoCliente, $nombre, $email, $rucDni);

        header('Location: clientes.php?success=Cliente creado exitosamente');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$title = 'Crear Cliente';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Crear Cliente</h1>
            <p class="page-subtitle">Agregar nuevo cliente al sistema</p>
        </div>
        <div class="page-actions">
            <a href="clientes.php" class="btn btn-secondary">
                ← Volver a Clientes
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
            <h3 class="form-title">Datos del Cliente</h3>
        </div>

        <form method="POST" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="tipo_cliente">Tipo de Cliente</label>
                    <select id="tipo_cliente" name="tipo_cliente" class="form-control" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="natural" <?php echo ($_POST['tipo_cliente'] ?? '') === 'natural' ? 'selected' : ''; ?>>
                            Persona Natural
                        </option>
                        <option value="juridico" <?php echo ($_POST['tipo_cliente'] ?? '') === 'juridico' ? 'selected' : ''; ?>>
                            Persona Jurídica
                        </option>
                    </select>
                    <small class="form-text">Seleccione el tipo de cliente</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="nombre">Nombre</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
                           required>
                    <small class="form-text">Nombre completo o razón social</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    <small class="form-text">Email de contacto (opcional)</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="ruc_dni">RUC/DNI</label>
                    <input type="text" 
                           id="ruc_dni" 
                           name="ruc_dni" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['ruc_dni'] ?? ''); ?>">
                    <small class="form-text">Documento de identificación</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="clientes.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-success">
                    Crear Cliente
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>