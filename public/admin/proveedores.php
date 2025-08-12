<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener proveedores de la base de datos
$proveedorRepository = $bootstrap->getProveedorRepository();
$proveedores = $proveedorRepository->obtenerTodos();

$title = 'Gestión de Proveedores';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Proveedores</h1>
            <p class="page-subtitle">Administrar proveedores del sistema</p>
        </div>
        <div class="page-actions">
            <a href="proveedores_crear.php" class="btn btn-info">
                <i class="icon-plus"></i> Nuevo Proveedor
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
            <h3 class="table-title">Lista de Proveedores</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar proveedores..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="empresa">Empresa</th>
                    <th class="sortable" data-column="contacto">Contacto</th>
                    <th class="sortable" data-column="email">Email</th>
                    <th class="sortable" data-column="ruc">RUC</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($proveedores)): ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="empty-state">
                                <p>No hay proveedores registrados</p>
                                <a href="proveedores_crear.php" class="btn btn-info">
                                    Crear primer proveedor
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($proveedor->getId()); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getNombreEmpresa()); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getContactoNombre()); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getEmail() ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($proveedor->getRuc() ?? '-'); ?></td>
                            <td>
                                <div class="table-actions">
                                    <a href="proveedores_ver.php?id=<?php echo $proveedor->getId(); ?>" class="btn-action btn-view" title="Ver">👁️</a>
                                    <a href="proveedores_editar.php?id=<?php echo $proveedor->getId(); ?>" class="btn-action btn-edit" title="Editar">✏️</a>
                                    <button class="btn-action btn-delete" title="Eliminar" onclick="confirmarEliminacion(<?php echo $proveedor->getId(); ?>, '<?php echo htmlspecialchars($proveedor->getNombreEmpresa()); ?>')">🗑️</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando <?php echo count($proveedores); ?> proveedor<?php echo count($proveedores) !== 1 ? 'es' : ''; ?>
            </div>
        </div>
    </div>
</main>

<script>
function confirmarEliminacion(id, nombre) {
    if (confirm(`¿Estás seguro de que deseas eliminar al proveedor "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
        // Aquí iría la lógica de eliminación
        window.location.href = `proveedores_eliminar.php?id=${id}`;
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
</script>

<?php require_once 'partials/footer.php'; ?>