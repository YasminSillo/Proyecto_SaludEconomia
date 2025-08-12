<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener productos desde la base de datos
try {
    $productoRepository = $bootstrap->getProductoRepository();
    $productos = $productoRepository->obtenerTodos();
} catch (Exception $e) {
    $productos = [];
    $error = "Error al cargar productos: " . $e->getMessage();
}
$title = 'Gestión de Productos';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Productos</h1>
            <p class="page-subtitle">Administrar productos del sistema</p>
        </div>
        <div class="page-actions">
            <a href="productos_crear.php" class="btn btn-warning">
                <i class="icon-plus"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <div class="crud-table-container">
        <div class="table-header">
            <h3 class="table-title">Lista de Productos</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar productos..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="categoryFilter">
                    <option value="">Todas las categorías</option>
                    <option value="medicamentos">Medicamentos</option>
                    <option value="equipos">Equipos Médicos</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th>Imagen</th>
                    <th class="sortable" data-column="codigo_sku">SKU</th>
                    <th class="sortable" data-column="nombre">Nombre</th>
                    <th class="sortable" data-column="categoria">Categoría</th>
                    <th class="sortable" data-column="proveedor">Proveedor</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($productos)): ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            <?php if (isset($error)): ?>
                                <p class="text-danger"><?= htmlspecialchars($error) ?></p>
                            <?php else: ?>
                                <p class="text-muted">No hay productos registrados</p>
                                <a href="productos_crear.php" class="btn btn-primary btn-sm">Crear primer producto</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto->getId()) ?></td>
                            <td>
                                <?php 
                                $rutaImagen = '/imagenes/no-image.svg';
                                if ($producto->getImagen()) {
                                    $rutaImagen = '/imagenes/productos/' . $producto->getImagen();
                                }
                                ?>
                                <img src="<?= htmlspecialchars($rutaImagen) ?>" 
                                     alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;"
                                     onerror="this.src='/imagenes/no-image.svg'">
                            </td>
                            <td><?= htmlspecialchars($producto->getCodigoSku()) ?></td>
                            <td><?= htmlspecialchars($producto->getNombre()) ?></td>
                            <td><?= htmlspecialchars($producto->categoriaNombre ?? 'Sin categoría') ?></td>
                            <td><?= htmlspecialchars($producto->proveedorNombre ?? 'Sin proveedor') ?></td>
                            <td>
                                <?php if ($producto->getPrecio()): ?>
                                    S/ <?= number_format($producto->getPrecio(), 2) ?>
                                <?php else: ?>
                                    <span style="color: #6c757d;">No definido</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="/admin/productos_editar.php?id=<?= $producto->getId() ?>" class="btn-action btn-edit" title="Editar">
                                        ✏️ Editar
                                    </a>
                                    <button type="button" class="btn-action btn-delete" onclick="confirmarEliminar(<?= $producto->getId() ?>)" title="Eliminar">
                                        🗑️ Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando <?= count($productos) ?> productos
            </div>
            <ul class="pagination">
                <li class="pagination-item disabled">
                    <a href="#" class="pagination-link">Anterior</a>
                </li>
                <li class="pagination-item active">
                    <a href="#" class="pagination-link">1</a>
                </li>
                <li class="pagination-item disabled">
                    <a href="#" class="pagination-link">Siguiente</a>
                </li>
            </ul>
        </div>
    </div>
</main>

<script>
function confirmarEliminar(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        // Crear formulario para eliminar
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/productos_eliminar.php';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php require_once 'partials/footer.php'; ?>