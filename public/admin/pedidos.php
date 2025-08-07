<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

$title = 'Gestión de Pedidos';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Pedidos</h1>
            <p class="page-subtitle">Administrar pedidos del sistema</p>
        </div>
        <div class="page-actions">
            <a href="pedidos_crear.php" class="btn btn-danger">
                <i class="icon-plus"></i> Nuevo Pedido
            </a>
        </div>
    </div>

    <div class="crud-table-container">
        <div class="table-header">
            <h3 class="table-title">Lista de Pedidos</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar pedidos..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="statusFilter">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="procesando">Procesando</option>
                    <option value="completado">Completado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="numero">Número</th>
                    <th class="sortable" data-column="cliente">Cliente</th>
                    <th class="sortable" data-column="fecha">Fecha</th>
                    <th class="sortable" data-column="total">Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>PED-2024-001</td>
                    <td>Farmacia Central</td>
                    <td>15/01/2024</td>
                    <td>S/. 1,250.00</td>
                    <td><span class="status-badge status-pending">Pendiente</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="pedidos_ver.php?id=1" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="pedidos_editar.php?id=1" class="btn-action btn-edit" title="Editar">✏️</a>
                            <button class="btn-action btn-delete" title="Cancelar">❌</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>PED-2024-002</td>
                    <td>Clínica San Juan</td>
                    <td>14/01/2024</td>
                    <td>S/. 3,800.00</td>
                    <td><span class="status-badge status-completed">Completado</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="pedidos_ver.php?id=2" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="pedidos_editar.php?id=2" class="btn-action btn-edit" title="Editar">✏️</a>
                            <button class="btn-action btn-delete" title="Cancelar" disabled>❌</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando 2 pedidos
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