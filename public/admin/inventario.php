<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

$title = 'Gestión de Inventario';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Inventario</h1>
            <p class="page-subtitle">Control de stock y movimientos</p>
        </div>
        <div class="page-actions">
            <a href="inventario_ajuste.php" class="btn btn-warning">
                <i class="icon-plus"></i> Ajuste de Stock
            </a>
            <a href="inventario_movimientos.php" class="btn btn-info">
                📊 Ver Movimientos
            </a>
        </div>
    </div>

    <div class="crud-table-container">
        <div class="table-header">
            <h3 class="table-title">Estado del Inventario</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar productos..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="stockFilter">
                    <option value="">Todos</option>
                    <option value="bajo">Stock Bajo</option>
                    <option value="agotado">Agotado</option>
                    <option value="normal">Stock Normal</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="sku">SKU</th>
                    <th class="sortable" data-column="nombre">Producto</th>
                    <th class="sortable" data-column="categoria">Categoría</th>
                    <th class="sortable" data-column="stock">Stock Actual</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>MED-001</td>
                    <td>Paracetamol 500mg</td>
                    <td>Medicamentos</td>
                    <td>150</td>
                    <td><span class="status-badge status-active">Normal</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="inventario_ver.php?id=1" class="btn-action btn-view" title="Ver Historial">📋</a>
                            <a href="inventario_ajuste.php?id=1" class="btn-action btn-edit" title="Ajustar">⚙️</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>EQU-001</td>
                    <td>Termómetro Digital</td>
                    <td>Equipos</td>
                    <td>5</td>
                    <td><span class="status-badge status-warning">Stock Bajo</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="inventario_ver.php?id=2" class="btn-action btn-view" title="Ver Historial">📋</a>
                            <a href="inventario_ajuste.php?id=2" class="btn-action btn-edit" title="Ajustar">⚙️</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>MED-002</td>
                    <td>Ibuprofeno 400mg</td>
                    <td>Medicamentos</td>
                    <td>0</td>
                    <td><span class="status-badge status-cancelled">Agotado</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="inventario_ver.php?id=3" class="btn-action btn-view" title="Ver Historial">📋</a>
                            <a href="inventario_ajuste.php?id=3" class="btn-action btn-edit" title="Ajustar">⚙️</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando 3 productos
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

    <!-- Alertas de Stock -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Alertas de Stock</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <strong>Stock Bajo:</strong> 1 producto con stock menor al mínimo
            </div>
            <div class="alert alert-danger">
                <strong>Productos Agotados:</strong> 1 producto sin stock
            </div>
        </div>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>