<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener filtros
$filtros = [];
if (!empty($_GET['stock'])) {
    $filtros['stock'] = $_GET['stock'];
}

// Obtener inventario de la base de datos
$obtenerInventarioUseCase = $bootstrap->getObtenerInventarioUseCase();
$inventario = $obtenerInventarioUseCase->ejecutar($filtros);
$resumenStock = $obtenerInventarioUseCase->obtenerResumenStock();

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
                <?php if (empty($inventario)): ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="empty-state">
                                <p>No hay productos en inventario</p>
                                <a href="productos_crear.php" class="btn btn-warning">
                                    Agregar productos
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($inventario as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item->id); ?></td>
                            <td><?php echo htmlspecialchars($item->codigo_sku); ?></td>
                            <td><?php echo htmlspecialchars($item->nombre); ?></td>
                            <td><?php echo htmlspecialchars($item->categoria_nombre); ?></td>
                            <td><?php echo number_format($item->stock_actual); ?></td>
                            <td>
                                <?php
                                $badgeClass = 'status-active';
                                $texto = 'Normal';
                                switch ($item->estado_stock) {
                                    case 'agotado':
                                        $badgeClass = 'status-cancelled';
                                        $texto = 'Agotado';
                                        break;
                                    case 'bajo':
                                        $badgeClass = 'status-warning';
                                        $texto = 'Stock Bajo';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?php echo $badgeClass; ?>">
                                    <?php echo $texto; ?>
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="inventario_ver.php?id=<?php echo $item->id; ?>" class="btn-action btn-view" title="Ver Historial">📋</a>
                                    <a href="inventario_ajuste.php?id=<?php echo $item->id; ?>" class="btn-action btn-edit" title="Ajustar">⚙️</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando <?php echo count($inventario); ?> producto<?php echo count($inventario) !== 1 ? 's' : ''; ?>
            </div>
        </div>
    </div>

    <!-- Alertas de Stock -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Resumen de Inventario</h3>
        </div>
        <div class="card-body">
            <?php if ($resumenStock['stock_bajo'] > 0): ?>
                <div class="alert alert-warning">
                    <strong>Stock Bajo:</strong> <?php echo $resumenStock['stock_bajo']; ?> producto<?php echo $resumenStock['stock_bajo'] !== 1 ? 's' : ''; ?> con stock menor al mínimo
                </div>
            <?php endif; ?>
            
            <?php if ($resumenStock['agotados'] > 0): ?>
                <div class="alert alert-danger">
                    <strong>Productos Agotados:</strong> <?php echo $resumenStock['agotados']; ?> producto<?php echo $resumenStock['agotados'] !== 1 ? 's' : ''; ?> sin stock
                </div>
            <?php endif; ?>
            
            <?php if ($resumenStock['agotados'] === 0 && $resumenStock['stock_bajo'] === 0): ?>
                <div class="alert alert-success">
                    <strong>¡Excelente!</strong> Todos los productos tienen stock adecuado
                </div>
            <?php endif; ?>
            
            <div class="mt-3">
                <p><strong>Total de productos:</strong> <?php echo $resumenStock['total_productos']; ?></p>
                <p><strong>Stock normal:</strong> <?php echo $resumenStock['normales']; ?></p>
            </div>
        </div>
    </div>
</main>

<script>
// Funcionalidad de búsqueda
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('.crud-table tbody tr');
    
    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let found = false;
        
        // Buscar en todas las celdas excepto la de acciones
        for (let i = 0; i < cells.length - 1; i++) {
            if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                found = true;
                break;
            }
        }
        
        row.style.display = found ? '' : 'none';
    });
});

// Filtro por stock
document.getElementById('stockFilter').addEventListener('change', function() {
    const selectedStock = this.value;
    const url = new URL(window.location);
    
    if (selectedStock) {
        url.searchParams.set('stock', selectedStock);
    } else {
        url.searchParams.delete('stock');
    }
    
    window.location = url;
});

// Mantener filtro seleccionado
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const stock = urlParams.get('stock');
    if (stock) {
        document.getElementById('stockFilter').value = stock;
    }
});
</script>

<?php require_once 'partials/footer.php'; ?>