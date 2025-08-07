<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();
$title = 'Dashboard';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Bienvenido al sistema administrativo</p>
        </div>
        <div class="page-actions">
            <span class="badge badge-success">Sistema activo</span>
        </div>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Usuarios</h3>
            <p>Gestionar usuarios del sistema</p>
            <a href="usuarios.php" class="btn btn-primary">Ver usuarios</a>
        </div>
        <div class="stat-card">
            <h3>Clientes</h3>
            <p>Gestionar clientes</p>
            <a href="clientes.php" class="btn btn-success">Ver clientes</a>
        </div>
        <div class="stat-card">
            <h3>Productos</h3>
            <p>Gestionar productos</p>
            <a href="productos.php" class="btn btn-warning">Ver productos</a>
        </div>
        <div class="stat-card">
            <h3>Pedidos</h3>
            <p>Gestionar pedidos</p>
            <a href="pedidos.php" class="btn btn-danger">Ver pedidos</a>
        </div>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>