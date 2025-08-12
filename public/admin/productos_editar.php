<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener ID del producto
$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: productos.php?error=ID de producto no válido');
    exit;
}

// Obtener el producto
$productoRepository = $bootstrap->getProductoRepository();
$producto = $productoRepository->obtenerPorId($id);

if (!$producto) {
    header('Location: productos.php?error=Producto no encontrado');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $datos = [
            'id' => $id,
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

        // Crear producto actualizado
        $productoActualizado = new Producto(
            $datos['id'],
            $datos['codigo_sku'],
            $datos['nombre'],
            $datos['categoria_id'],
            $datos['proveedor_id'],
            $datos['descripcion'],
            $datos['precio'],
            $producto->getImagen() // Mantener imagen actual por ahora
        );

        // Actualizar producto
        $success = $productoRepository->actualizar($productoActualizado);
        
        if ($success) {
            header('Location: productos.php?success=Producto actualizado exitosamente');
            exit;
        } else {
            throw new Exception("Error al actualizar el producto");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener categorías y proveedores para los selects
$categoriaRepository = $bootstrap->getCategoriaRepository();
$proveedorRepository = $bootstrap->getProveedorRepository();
$categorias = $categoriaRepository->obtenerActivas();
$proveedores = $proveedorRepository->obtenerTodos();

$title = 'Editar Producto';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Editar Producto</h1>
            <p class="page-subtitle">Modificar información del producto</p>
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
            <h3 class="form-title">Datos del Producto #<?= $producto->getId() ?></h3>
        </div>

        <form method="POST" enctype="multipart/form-data" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="codigo_sku">Código SKU</label>
                    <input type="text" 
                           id="codigo_sku" 
                           name="codigo_sku" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['codigo_sku'] ?? $producto->getCodigoSku()); ?>" 
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
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? $producto->getNombre()); ?>" 
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
                                    <?php echo ($_POST['categoria_id'] ?? $producto->getCategoriaId()) == $categoria->getId() ? 'selected' : ''; ?>>
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
                                    <?php echo ($_POST['proveedor_id'] ?? $producto->getProveedorId()) == $proveedor->getId() ? 'selected' : ''; ?>>
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
                           value="<?php echo htmlspecialchars($_POST['precio'] ?? $producto->getPrecio()); ?>" 
                           step="0.01"
                           min="0"
                           placeholder="0.00">
                    <small class="form-text">Precio de venta (opcional)</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="imagen">Cambiar Imagen</label>
                    <input type="file" 
                           id="imagen" 
                           name="imagen" 
                           class="form-control" 
                           accept="image/*">
                    <small class="form-text">Dejar vacío para mantener imagen actual. Máximo 5MB</small>
                    <?php if ($producto->getImagen()): ?>
                        <small class="form-text text-info">Imagen actual: <?= htmlspecialchars($producto->getImagen()) ?></small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control" 
                              rows="4"
                              placeholder="Descripción detallada del producto..."><?php echo htmlspecialchars($_POST['descripcion'] ?? $producto->getDescripcion()); ?></textarea>
                    <small class="form-text">Descripción detallada del producto (opcional)</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="productos.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-warning">
                    ✏️ Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>