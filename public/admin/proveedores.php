<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

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
                <tr>
                    <td>1</td>
                    <td>Laboratorios ABC S.A.</td>
                    <td>Juan Pérez</td>
                    <td>contacto@lababc.com</td>
                    <td>20123456789</td>
                    <td>
                        <div class="table-actions">
                            <a href="proveedores_ver.php?id=1" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="proveedores_editar.php?id=1" class="btn-action btn-edit" title="Editar">✏️</a>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Equipos Médicos XYZ</td>
                    <td>María García</td>
                    <td>ventas@equiposxyz.com</td>
                    <td>20987654321</td>
                    <td>
                        <div class="table-actions">
                            <a href="proveedores_ver.php?id=2" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="proveedores_editar.php?id=2" class="btn-action btn-edit" title="Editar">✏️</a>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando 2 proveedores
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