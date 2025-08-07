<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

$clienteRepository = $bootstrap->getClienteRepository();

// Procesar acciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
            $clienteRepository->eliminar($_POST['id']);
            $success = "Cliente eliminado exitosamente";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener clientes
$clientes = $clienteRepository->obtenerTodos();
$title = 'Gestión de Clientes';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Clientes</h1>
            <p class="page-subtitle">Administrar clientes del sistema</p>
        </div>
        <div class="page-actions">
            <a href="clientes_crear.php" class="btn btn-success">
                <i class="icon-plus"></i> Nuevo Cliente
            </a>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible">
            <?php echo htmlspecialchars($error); ?>
            <button class="alert-close">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible">
            <?php echo htmlspecialchars($success); ?>
            <button class="alert-close">&times;</button>
        </div>
    <?php endif; ?>

    <div class="crud-table-container">
        <div class="table-header">
            <h3 class="table-title">Lista de Clientes</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar clientes..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="typeFilter">
                    <option value="">Todos los tipos</option>
                    <option value="natural">Persona Natural</option>
                    <option value="juridico">Persona Jurídica</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="nombre">Nombre</th>
                    <th class="sortable" data-column="tipo_cliente">Tipo</th>
                    <th class="sortable" data-column="email">Email</th>
                    <th class="sortable" data-column="ruc_dni">RUC/DNI</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente->getId()); ?></td>
                    <td><?php echo htmlspecialchars($cliente->getNombre()); ?></td>
                    <td>
                        <span class="badge <?php echo $cliente->getTipoCliente() === 'juridico' ? 'badge-primary' : 'badge-secondary'; ?>">
                            <?php echo $cliente->esPersonaJuridica() ? 'Jurídica' : 'Natural'; ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($cliente->getEmail() ?: 'Sin email'); ?></td>
                    <td><?php echo htmlspecialchars($cliente->getRucDni() ?: 'Sin documento'); ?></td>
                    <td>
                        <div class="table-actions">
                            <a href="clientes_ver.php?id=<?php echo $cliente->getId(); ?>" class="btn-action btn-view" title="Ver">
                                👁️
                            </a>
                            <a href="clientes_editar.php?id=<?php echo $cliente->getId(); ?>" class="btn-action btn-edit" title="Editar">
                                ✏️
                            </a>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este cliente?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $cliente->getId(); ?>">
                                <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando <?php echo count($clientes); ?> clientes
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