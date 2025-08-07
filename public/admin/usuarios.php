<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

$usuarioRepository = $bootstrap->getUsuarioRepository();

// Procesar acciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
            $usuarioRepository->eliminar($_POST['id']);
            $success = "Usuario eliminado exitosamente";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener usuarios
$usuarios = $usuarioRepository->obtenerTodos();
$title = 'Gestión de Usuarios';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Usuarios</h1>
            <p class="page-subtitle">Administrar usuarios del sistema</p>
        </div>
        <div class="page-actions">
            <a href="usuarios_crear.php" class="btn btn-primary">
                <i class="icon-plus"></i> Nuevo Usuario
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
            <h3 class="table-title">Lista de Usuarios</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar usuarios..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="roleFilter">
                    <option value="">Todos los roles</option>
                    <option value="admin">Administrador</option>
                    <option value="vendedor">Vendedor</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="nombre">Nombre</th>
                    <th class="sortable" data-column="email">Email</th>
                    <th class="sortable" data-column="rol">Rol</th>
                    <th class="sortable" data-column="created_at">Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario->getId()); ?></td>
                    <td><?php echo htmlspecialchars($usuario->getNombre()); ?></td>
                    <td><?php echo htmlspecialchars($usuario->getEmail()); ?></td>
                    <td>
                        <span class="badge <?php echo $usuario->getRol() === 'admin' ? 'badge-danger' : 'badge-primary'; ?>">
                            <?php echo htmlspecialchars($usuario->getRol()); ?>
                        </span>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($usuario->getCreatedAt())); ?></td>
                    <td>
                        <div class="table-actions">
                            <a href="usuarios_ver.php?id=<?php echo $usuario->getId(); ?>" class="btn-action btn-view" title="Ver">
                                👁️
                            </a>
                            <a href="usuarios_editar.php?id=<?php echo $usuario->getId(); ?>" class="btn-action btn-edit" title="Editar">
                                ✏️
                            </a>
                            <?php if ($usuario->getId() != $_SESSION['usuario_id']): ?>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este usuario?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
                                <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                    🗑️
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando <?php echo count($usuarios); ?> usuarios
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