<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $datos = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'parent_id' => !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : null
        ];

        // Validaciones básicas
        if (empty($datos['nombre'])) {
            throw new Exception("El nombre de la categoría es requerido");
        }

        // Crear categoría
        $crearCategoriaUseCase = $bootstrap->getCrearCategoriaUseCase();
        
        $resultado = $crearCategoriaUseCase->ejecutar($datos);
        
        if ($resultado) {
            header('Location: categorias.php?success=Categoría creada exitosamente');
            exit;
        } else {
            throw new Exception("Error al guardar la categoría en la base de datos");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener categorías principales para el select de categoría padre
$categoriaRepository = $bootstrap->getCategoriaRepository();
$categoriasPrincipales = $categoriaRepository->obtenerCategoriasPrincipales();

$title = 'Crear Categoría';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Crear Categoría</h1>
            <p class="page-subtitle">Agregar nueva categoría al sistema</p>
        </div>
        <div class="page-actions">
            <a href="categorias.php" class="btn btn-secondary">
                ← Volver a Categorías
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
            <h3 class="form-title">Datos de la Categoría</h3>
        </div>

        <form method="POST" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="nombre">Nombre de la Categoría</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
                           required
                           placeholder="Ej: Medicamentos, Equipos Médicos">
                    <small class="form-text">Nombre descriptivo de la categoría</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="parent_id">Categoría Padre (Opcional)</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value="">Sin categoría padre (Principal)</option>
                        <?php foreach ($categoriasPrincipales as $categoria): ?>
                            <option value="<?php echo $categoria->getId(); ?>" 
                                    <?php echo ($_POST['parent_id'] ?? '') == $categoria->getId() ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria->getNombre()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text">Selecciona una categoría padre para crear una subcategoría</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control" 
                              rows="4"
                              placeholder="Descripción detallada de la categoría..."><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                    <small class="form-text">Descripción detallada de la categoría (opcional)</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="categorias.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-success">
                    📁 Crear Categoría
                </button>
            </div>
        </form>
    </div>
</main>

<script>
// Validación del formulario
document.querySelector('.crud-form').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre').value.trim();
    
    if (nombre.length < 2) {
        e.preventDefault();
        alert('El nombre de la categoría debe tener al menos 2 caracteres');
        document.getElementById('nombre').focus();
        return;
    }
    
    if (nombre.length > 100) {
        e.preventDefault();
        alert('El nombre de la categoría no puede exceder 100 caracteres');
        document.getElementById('nombre').focus();
        return;
    }
});
</script>

<?php require_once 'partials/footer.php'; ?>