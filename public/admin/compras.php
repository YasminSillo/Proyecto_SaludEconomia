<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener filtros
$filtros = [];
if (!empty($_GET['estado'])) {
    $filtros['estado'] = $_GET['estado'];
}

// Obtener compras de la base de datos
$obtenerComprasUseCase = $bootstrap->getObtenerComprasUseCase();
$compras = $obtenerComprasUseCase->ejecutar($filtros);

$title = 'Gestión de Compras';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Compras</h1>
            <p class="page-subtitle">Administrar órdenes de compra</p>
        </div>
        <div class="page-actions">
            <a href="compras_crear.php" class="btn btn-success">
                <i class="icon-plus"></i> Nueva Compra
            </a>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible">
            <?php echo htmlspecialchars($_GET['success']); ?>
            <button class="alert-close">&times;</button>
        </div>
    <?php endif; ?>

    <div class="crud-table-container">
        <div class="table-header">
            <h3 class="table-title">Lista de Compras</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar compras..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="statusFilter">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="recibido">Recibido</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="numero">Número</th>
                    <th class="sortable" data-column="proveedor">Proveedor</th>
                    <th class="sortable" data-column="fecha">Fecha</th>
                    <th class="sortable" data-column="total">Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($compras)): ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="empty-state">
                                <p>No hay compras registradas</p>
                                <a href="compras_crear.php" class="btn btn-success">
                                    Crear primera compra
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($compras as $compra): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($compra->getId()); ?></td>
                            <td><?php echo htmlspecialchars($compra->getNumeroCompra()); ?></td>
                            <td><?php echo htmlspecialchars($compra->proveedor_nombre ?? 'N/A'); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($compra->getFecha())); ?></td>
                            <td>S/. <?php echo number_format($compra->total ?? 0, 2); ?></td>
                            <td>
                                <?php
                                $estado = $compra->getEstado();
                                $badgeClass = 'status-pending';
                                switch ($estado) {
                                    case 'recibido':
                                        $badgeClass = 'status-completed';
                                        break;
                                    case 'cancelado':
                                        $badgeClass = 'status-cancelled';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?php echo $badgeClass; ?>">
                                    <?php echo ucfirst($estado); ?>
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="compras_ver.php?id=<?php echo $compra->getId(); ?>" class="btn-action btn-view" title="Ver">👁️</a>
                                    <?php if ($estado !== 'recibido' && $estado !== 'cancelado'): ?>
                                        <a href="compras_editar.php?id=<?php echo $compra->getId(); ?>" class="btn-action btn-edit" title="Editar">✏️</a>
                                        <button class="btn-action btn-delete" title="Cancelar" onclick="confirmarCancelacion(<?php echo $compra->getId(); ?>, '<?php echo htmlspecialchars($compra->getNumeroCompra()); ?>')">❌</button>
                                    <?php else: ?>
                                        <button class="btn-action btn-delete" title="No se puede editar" disabled>❌</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando <?php echo count($compras); ?> compra<?php echo count($compras) !== 1 ? 's' : ''; ?>
            </div>
        </div>
    </div>
</main>

<script>
function confirmarCancelacion(id, numero) {
    if (confirm(`¿Estás seguro de que deseas cancelar la compra "${numero}"?\n\nEsta acción no se puede deshacer.`)) {
        window.location.href = `compras_cancelar.php?id=${id}`;
    }
}

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

// Filtro por estado
document.getElementById('statusFilter').addEventListener('change', function() {
    const selectedEstado = this.value;
    const url = new URL(window.location);
    
    if (selectedEstado) {
        url.searchParams.set('estado', selectedEstado);
    } else {
        url.searchParams.delete('estado');
    }
    
    window.location = url;
});

// Mantener filtro seleccionado
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const estado = urlParams.get('estado');
    if (estado) {
        document.getElementById('statusFilter').value = estado;
    }
});
</script>

<?php require_once 'partials/footer.php'; ?>