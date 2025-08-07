<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

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
                <tr>
                    <td>1</td>
                    <td>Medicamentos</td>
                    <td>Productos farmacéuticos</td>
                    <td><span class="badge badge-light">Principal</span></td>
                    <td><span class="status-badge status-active">Activa</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="categorias_ver.php?id=1" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="categorias_editar.php?id=1" class="btn-action btn-edit" title="Editar">✏️</a>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Equipos Médicos</td>
                    <td>Instrumentos y equipos para uso médico</td>
                    <td><span class="badge badge-light">Principal</span></td>
                    <td><span class="status-badge status-active">Activa</span></td>
                    <td>
                        <div class="table-actions">
                            <a href="categorias_ver.php?id=2" class="btn-action btn-view" title="Ver">👁️</a>
                            <a href="categorias_editar.php?id=2" class="btn-action btn-edit" title="Editar">✏️</a>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando 2 categorías
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