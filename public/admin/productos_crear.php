<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $datos = [
            'codigo_sku' => trim($_POST['codigo_sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => !empty($_POST['precio']) ? floatval($_POST['precio']) : null,
            'categoria_id' => intval($_POST['categoria_id'] ?? 0),
            'proveedor_id' => intval($_POST['proveedor_id'] ?? 0)
        ];

        // Validaciones básicas
        if (empty($datos['codigo_sku']) || empty($datos['nombre']) || !$datos['categoria_id'] || !$datos['proveedor_id']) {
            throw new Exception("SKU, nombre, categoría y proveedor son requeridos");
        }

        // Crear producto con imagen
        $crearProductoUseCase = $bootstrap->getCrearProductoUseCase();
        $archivoImagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;
        
        $crearProductoUseCase->ejecutar($datos, $archivoImagen);

        header('Location: productos.php?success=Producto creado exitosamente');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener categorías y proveedores para los selects
$categoriaRepository = $bootstrap->getCategoriaRepository();
$proveedorRepository = $bootstrap->getProveedorRepository();
$categorias = $categoriaRepository->obtenerActivas();
$proveedores = $proveedorRepository->obtenerTodos();

$title = 'Crear Producto';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Crear Producto</h1>
            <p class="page-subtitle">Agregar nuevo producto al catálogo</p>
        </div>
        <div class="page-actions">
            <a href="productos.php" class="btn btn-secondary">
                ← Volver a Productos
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
            <h3 class="form-title">Datos del Producto</h3>
        </div>

        <form method="POST" enctype="multipart/form-data" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="codigo_sku">Código SKU</label>
                    <input type="text" 
                           id="codigo_sku" 
                           name="codigo_sku" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['codigo_sku'] ?? ''); ?>" 
                           required
                           placeholder="Ej: MED-001">
                    <small class="form-text">Código único del producto</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="nombre">Nombre del Producto</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
                           required
                           placeholder="Ej: Paracetamol 500mg">
                    <small class="form-text">Nombre descriptivo del producto</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id" class="form-control" required>
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->getId(); ?>" 
                                    <?php echo ($_POST['categoria_id'] ?? '') == $categoria->getId() ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria->getNombre()); ?>
                                <?php if ($categoria->getDescripcion()): ?>
                                    - <?php echo htmlspecialchars(substr($categoria->getDescripcion(), 0, 50)); ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text">Categoría a la que pertenece el producto</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="proveedor_id">Proveedor</label>
                    <select id="proveedor_id" name="proveedor_id" class="form-control" required>
                        <option value="">Seleccionar proveedor</option>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <option value="<?php echo $proveedor->getId(); ?>" 
                                    <?php echo ($_POST['proveedor_id'] ?? '') == $proveedor->getId() ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($proveedor->getNombreEmpresa()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text">Proveedor del producto</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="precio">Precio</label>
                    <input type="number" 
                           id="precio" 
                           name="precio" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['precio'] ?? ''); ?>" 
                           step="0.01"
                           min="0"
                           placeholder="0.00">
                    <small class="form-text">Precio de venta (opcional)</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="imagen">Imagen del Producto</label>
                    <input type="file" 
                           id="imagen" 
                           name="imagen" 
                           class="form-control" 
                           accept="image/*">
                    <small class="form-text">Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 5MB</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control" 
                              rows="4"
                              placeholder="Descripción detallada del producto..."><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                    <small class="form-text">Descripción detallada del producto (opcional)</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="productos.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-warning">
                    📦 Crear Producto
                </button>
            </div>
        </form>
    </div>
</main>

<script>
// Preview de imagen
document.getElementById('imagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validar tamaño
        if (file.size > 5 * 1024 * 1024) {
            alert('El archivo es demasiado grande. Máximo 5MB');
            this.value = '';
            return;
        }
        
        // Validar tipo
        if (!file.type.startsWith('image/')) {
            alert('Por favor selecciona un archivo de imagen válido');
            this.value = '';
            return;
        }
        
        // Mostrar preview (opcional)
        console.log('Imagen seleccionada:', file.name, 'Tamaño:', (file.size / 1024 / 1024).toFixed(2) + 'MB');
    }
});
</script>

<?php require_once 'partials/footer.php'; ?>