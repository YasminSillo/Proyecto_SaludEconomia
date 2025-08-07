<?php 
require_once __DIR__ . '/../src/Bootstrap.php';
$bootstrap = new Bootstrap();

// Obtener productos y categorías
try {
    $obtenerProductosUseCase = $bootstrap->getObtenerProductosUseCase();
    
    $filtros = [];
    if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
        $filtros['categoria'] = $_GET['categoria'];
    }
    if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
        $filtros['busqueda'] = $_GET['busqueda'];
    }
    
    $productos = $obtenerProductosUseCase->ejecutar($filtros);
    $categorias = $obtenerProductosUseCase->obtenerCategorias();
    
} catch (Exception $e) {
    $productos = [];
    $categorias = [];
    $error = "Error al cargar el catálogo: " . $e->getMessage();
}

require_once __DIR__ . '/../components/header.php'; 
?>
<body>

    <!--ESTRUCTURA PRINCIPAL CON CSS GRID-->
    <?php require_once __DIR__ . '/../components/navbar.php'; ?>
    
    <!-- CONTENIDO PRINCIPAL-->
    <main class="main">
        <?php require_once __DIR__ . '/../components/informacion_catalogo.php'; ?>
        <?php require_once __DIR__ . '/../components/catalogo_productos.php'; ?>
    </main>
    
    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>


