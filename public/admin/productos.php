<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener productos (simulado por ahora)
$productos = []; // TODO: Implementar cuando tengamos el repositorio completo
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
                    <th class="sortable" data-column="codigo_sku">SKU</th>
                    <th class="sortable" data-column="nombre">Nombre</th>
                    <th class="sortable" data-column="categoria">Categoría</th>
                    <th class="sortable" data-column="proveedor">Proveedor</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center">
                        <p class="text-muted">No hay productos registrados</p>
                        <a href="productos_crear.php" class="btn btn-primary btn-sm">Crear primer producto</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando 0 productos
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

<?php require_once 'partials/footer.php'; ?>