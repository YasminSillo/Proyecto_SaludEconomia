<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: productos.php?error=Método no permitido');
    exit;
}

$bootstrap = new Bootstrap();

// Obtener ID del producto
$id = intval($_POST['id'] ?? 0);
if (!$id) {
    header('Location: productos.php?error=ID de producto no válido');
    exit;
}

try {
    $productoRepository = $bootstrap->getProductoRepository();
    
    // Verificar que el producto existe
    $producto = $productoRepository->obtenerPorId($id);
    if (!$producto) {
        header('Location: productos.php?error=Producto no encontrado');
        exit;
    }
    
    // Eliminar imagen si existe
    if ($producto->getImagen()) {
        $imagenRepository = $bootstrap->get('imagenRepository');
        $imagenRepository->eliminarImagen('productos/' . $producto->getImagen());
    }
    
    // Eliminar producto de la base de datos
    $resultado = $productoRepository->eliminar($id);
    
    if ($resultado) {
        header('Location: productos.php?success=Producto eliminado exitosamente');
    } else {
        header('Location: productos.php?error=Error al eliminar el producto');
    }
    
} catch (Exception $e) {
    header('Location: productos.php?error=' . urlencode('Error: ' . $e->getMessage()));
}

exit;
?>