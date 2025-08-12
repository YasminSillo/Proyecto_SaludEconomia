<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener categorías de la base de datos
$categoriaRepository = $bootstrap->getCategoriaRepository();
$categorias = $categoriaRepository->obtenerTodas();

$title = 'Gestión de Categorías';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Categorías</h1>
            <p class="page-subtitle">Administrar categorías de productos</p>
        </div>
        <div class="page-actions">
            <a href="categorias_crear.php" class="btn btn-success">
                <i class="icon-plus"></i> Nueva Categoría
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
            <h3 class="table-title">Lista de Categorías</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar categorías..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="statusFilter">
                    <option value="">Todas</option>
                    <option value="activo">Activas</option>
                    <option value="inactivo">Inactivas</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="nombre">Nombre</th>
                    <th class="sortable" data-column="descripcion">Descripción</th>
                    <th>Categoría Padre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categorias)): ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="empty-state">
                                <p>No hay categorías registradas</p>
                                <a href="categorias_crear.php" class="btn btn-success">
                                    Crear primera categoría
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($categoria->getId()); ?></td>
                            <td><?php echo htmlspecialchars($categoria->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($categoria->getDescripcion() ?? '-'); ?></td>
                            <td>
                                <?php if ($categoria->getParentId()): ?>
                                    <span class="badge badge-secondary">Subcategoría</span>
                                <?php else: ?>
                                    <span class="badge badge-light">Principal</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($categoria->getActivo()): ?>
                                    <span class="status-badge status-active">Activa</span>
                                <?php else: ?>
                                    <span class="status-badge status-inactive">Inactiva</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="categorias_ver.php?id=<?php echo $categoria->getId(); ?>" class="btn-action btn-view" title="Ver">👁️</a>
                                    <a href="categorias_editar.php?id=<?php echo $categoria->getId(); ?>" class="btn-action btn-edit" title="Editar">✏️</a>
                                    <button class="btn-action btn-delete" title="Eliminar" onclick="confirmarEliminacion(<?php echo $categoria->getId(); ?>, '<?php echo htmlspecialchars($categoria->getNombre()); ?>')">🗑️</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando <?php echo count($categorias); ?> categoría<?php echo count($categorias) !== 1 ? 's' : ''; ?>
            </div>
        </div>
    </div>
</main>

<script>
function confirmarEliminacion(id, nombre) {
    if (confirm(`¿Estás seguro de que deseas eliminar la categoría "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
        // Aquí iría la lógica de eliminación
        window.location.href = `categorias_eliminar.php?id=${id}`;
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
    const filterValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('.crud-table tbody tr');
    
    tableRows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(5)');
        if (statusCell) {
            const statusText = statusCell.textContent.toLowerCase();
            
            if (filterValue === '' || statusText.includes(filterValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>