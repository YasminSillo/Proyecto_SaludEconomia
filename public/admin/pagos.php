<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

$title = 'Gestión de Pagos';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Pagos</h1>
            <p class="page-subtitle">Administrar pagos del sistema</p>
        </div>
        <div class="page-actions">
            <a href="pagos_registrar.php" class="btn btn-primary">
                <i class="icon-plus"></i> Registrar Pago
            </a>
        </div>
    </div>

    <div class="crud-table-container">
        <div class="table-header">
            <h3 class="table-title">Lista de Pagos</h3>
            <div class="table-filters">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Buscar pagos..." id="searchInput">
                    <span class="search-icon">🔍</span>
                </div>
                <select class="filter-select" id="methodFilter">
                    <option value="">Todos los métodos</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
        </div>

        <table class="crud-table">
            <thead>
                <tr>
                    <th class="sortable" data-column="id">ID</th>
                    <th class="sortable" data-column="pedido">Pedido</th>
                    <th class="sortable" data-column="cliente">Cliente</th>
                    <th class="sortable" data-column="monto">Monto</th>
                    <th class="sortable" data-column="metodo">Método</th>
                    <th class="sortable" data-column="fecha">Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>PED-2024-001</td>
                    <td>Farmacia Central</td>
                    <td>S/. 1,250.00</td>
                    <td>
                        <span class="badge badge-success">Efectivo</span>
                    </td>
                    <td>15/01/2024 14:30</td>
                    <td>
                        <div class="table-actions">
                            <a href="pagos_ver.php?id=1" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="pagos_recibo.php?id=1" class="btn-action btn-info" title="Generar Recibo">🧾</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>PED-2024-002</td>
                    <td>Clínica San Juan</td>
                    <td>S/. 3,800.00</td>
                    <td>
                        <span class="badge badge-primary">Tarjeta</span>
                    </td>
                    <td>14/01/2024 10:15</td>
                    <td>
                        <div class="table-actions">
                            <a href="pagos_ver.php?id=2" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="pagos_recibo.php?id=2" class="btn-action btn-info" title="Generar Recibo">🧾</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>PED-2024-003</td>
                    <td>Hospital Regional</td>
                    <td>S/. 850.00</td>
                    <td>
                        <span class="badge badge-info">Transferencia</span>
                    </td>
                    <td>12/01/2024 16:45</td>
                    <td>
                        <div class="table-actions">
                            <a href="pagos_ver.php?id=3" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="pagos_recibo.php?id=3" class="btn-action btn-info" title="Generar Recibo">🧾</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando 3 pagos
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

    <!-- Resumen de Pagos -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Resumen del Día</h3>
        </div>
        <div class="card-body">
            <div class="dashboard-stats">
                <div class="stat-card">
                    <h3>Total Recaudado</h3>
                    <p class="text-primary" style="font-size: 1.5rem; font-weight: bold;">S/. 5,900.00</p>
                </div>
                <div class="stat-card">
                    <h3>Pagos Efectivo</h3>
                    <p class="text-success" style="font-size: 1.5rem; font-weight: bold;">S/. 2,100.00</p>
                </div>
                <div class="stat-card">
                    <h3>Pagos Tarjeta/Digital</h3>
                    <p class="text-info" style="font-size: 1.5rem; font-weight: bold;">S/. 3,800.00</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>