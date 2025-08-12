<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

// Obtener ID del producto
$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: productos.php?error=ID de producto no válido');
    exit;
}

// Obtener el producto
$productoRepository = $bootstrap->getProductoRepository();
$producto = $productoRepository->obtenerPorId($id);

if (!$producto) {
    header('Location: productos.php?error=Producto no encontrado');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $datos = [
            'id' => $id,
            'codigo_sku' => trim($_POST['codigo_sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => !empty($_POST['precio']) ? floatval($_POST['precio']) : null,
            'categoria_id' => intval($_POST['categoria_id'] ?? 0),
            'proveedor_id' => intval($_POST['proveedor_id'] ?? 0)
        ];

        // Validaciones básicas
        if (empty($datos['codigo_sku']) || empty($datos['nombre']) || !$datos['categoria_id'] || !$datos['proveedor_id']) {
            throw new Exception("SKU, nombre, categoría y proveedor son requeridos");
        }

        // Manejar imágenes
        $imagenActual = $producto->getImagen();
        $eliminarImagenActual = isset($_POST['eliminar_imagen_actual']);
        $archivosImagenes = isset($_FILES['imagenes']) ? $_FILES['imagenes'] : null;
        $nuevaImagenPrincipal = isset($_POST['nueva_imagen_principal']) ? intval($_POST['nueva_imagen_principal']) : 0;
        
        // Si se marca eliminar imagen actual, eliminarla del servidor
        if ($eliminarImagenActual && $imagenActual) {
            $imagenRepository = $bootstrap->get('imagenRepository');
            $imagenRepository->eliminarImagen('productos/' . $imagenActual);
            $imagenActual = null;
        }
        
        // Procesar nuevas imágenes
        $nuevaImagenPrincipalArchivo = null;
        if ($archivosImagenes && is_array($archivosImagenes['name']) && !empty($archivosImagenes['name'][0])) {
            $imagenRepository = $bootstrap->get('imagenRepository');
            
            for ($i = 0; $i < count($archivosImagenes['name']); $i++) {
                if ($archivosImagenes['error'][$i] === UPLOAD_ERR_OK) {
                    $archivo = [
                        'name' => $archivosImagenes['name'][$i],
                        'type' => $archivosImagenes['type'][$i],
                        'tmp_name' => $archivosImagenes['tmp_name'][$i],
                        'error' => $archivosImagenes['error'][$i],
                        'size' => $archivosImagenes['size'][$i]
                    ];
                    
                    $nombreImagen = $imagenRepository->subirImagen($archivo, 'productos');
                    
                    // Si es la imagen principal seleccionada, usar como imagen del producto
                    if ($i === $nuevaImagenPrincipal) {
                        $nuevaImagenPrincipalArchivo = $nombreImagen;
                    }
                }
            }
        }
        
        // Determinar qué imagen usar
        $imagenFinal = $nuevaImagenPrincipalArchivo ?: $imagenActual;
        
        // Crear producto actualizado
        $productoActualizado = new Producto(
            $datos['id'],
            $datos['codigo_sku'],
            $datos['nombre'],
            $datos['categoria_id'],
            $datos['proveedor_id'],
            $datos['descripcion'],
            $datos['precio'],
            $imagenFinal
        );

        // Actualizar producto
        $success = $productoRepository->actualizar($productoActualizado);
        
        if ($success) {
            header('Location: productos.php?success=Producto actualizado exitosamente');
            exit;
        } else {
            throw new Exception("Error al actualizar el producto");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener categorías y proveedores para los selects
$categoriaRepository = $bootstrap->getCategoriaRepository();
$proveedorRepository = $bootstrap->getProveedorRepository();
$categorias = $categoriaRepository->obtenerActivas();
$proveedores = $proveedorRepository->obtenerTodos();

$title = 'Editar Producto';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Editar Producto</h1>
            <p class="page-subtitle">Modificar información del producto</p>
        </div>
        <div class="page-actions">
            <a href="productos.php" class="btn btn-secondary">
                ← Volver a Productos
            </a>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible">
            <?php echo htmlspecialchars($error); ?>
            <button class="alert-close">&times;</button>
        </div>
    <?php endif; ?>

    <div class="crud-form-container">
        <div class="form-header">
            <h3 class="form-title">Datos del Producto #<?= $producto->getId() ?></h3>
        </div>

        <form method="POST" enctype="multipart/form-data" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="codigo_sku">Código SKU</label>
                    <input type="text" 
                           id="codigo_sku" 
                           name="codigo_sku" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['codigo_sku'] ?? $producto->getCodigoSku()); ?>" 
                           required
                           placeholder="Ej: MED-001">
                    <small class="form-text">Código único del producto</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="nombre">Nombre del Producto</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? $producto->getNombre()); ?>" 
                           required
                           placeholder="Ej: Paracetamol 500mg">
                    <small class="form-text">Nombre descriptivo del producto</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id" class="form-control" required>
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->getId(); ?>" 
                                    <?php echo ($_POST['categoria_id'] ?? $producto->getCategoriaId()) == $categoria->getId() ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria->getNombre()); ?>
                                <?php if ($categoria->getDescripcion()): ?>
                                    - <?php echo htmlspecialchars(substr($categoria->getDescripcion(), 0, 50)); ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text">Categoría a la que pertenece el producto</small>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="proveedor_id">Proveedor</label>
                    <select id="proveedor_id" name="proveedor_id" class="form-control" required>
                        <option value="">Seleccionar proveedor</option>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <option value="<?php echo $proveedor->getId(); ?>" 
                                    <?php echo ($_POST['proveedor_id'] ?? $producto->getProveedorId()) == $proveedor->getId() ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($proveedor->getNombreEmpresa()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text">Proveedor del producto</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="precio">Precio</label>
                    <input type="number" 
                           id="precio" 
                           name="precio" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['precio'] ?? $producto->getPrecio()); ?>" 
                           step="0.01"
                           min="0"
                           placeholder="0.00">
                    <small class="form-text">Precio de venta (opcional)</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="imagenes">Imágenes del Producto</label>
                    
                    <!-- Imágenes actuales -->
                    <?php if ($producto->getImagen()): ?>
                        <div class="current-images">
                            <h5>Imagen actual:</h5>
                            <div class="current-image-item">
                                <img src="../imagenes/productos/<?= htmlspecialchars($producto->getImagen()) ?>" 
                                     alt="Imagen actual" 
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                <div class="image-actions">
                                    <label>
                                        <input type="checkbox" name="eliminar_imagen_actual" value="1">
                                        Eliminar imagen actual
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Nuevas imágenes -->
                    <div style="margin-top: 1rem;">
                        <label class="form-label">Añadir nuevas imágenes:</label>
                        <input type="file" 
                               id="imagenes" 
                               name="imagenes[]" 
                               class="form-control" 
                               accept="image/*"
                               multiple>
                        <small class="form-text">Selecciona múltiples imágenes nuevas. Formatos: JPG, PNG, GIF, WEBP. Máximo 5MB por imagen</small>
                        <div id="imagePreview" class="image-preview-container" style="margin-top: 1rem;"></div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control" 
                              rows="4"
                              placeholder="Descripción detallada del producto..."><?php echo htmlspecialchars($_POST['descripcion'] ?? $producto->getDescripcion()); ?></textarea>
                    <small class="form-text">Descripción detallada del producto (opcional)</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="productos.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-warning">
                    ✏️ Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</main>

<script>
// Reutilizar el mismo JavaScript del formulario de crear
document.getElementById('imagenes').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const previewContainer = document.getElementById('imagePreview');
    previewContainer.innerHTML = '';
    
    if (files.length === 0) return;
    
    // Validar número máximo de archivos
    if (files.length > 10) {
        alert('Máximo 10 imágenes permitidas');
        this.value = '';
        return;
    }
    
    let validFiles = [];
    
    files.forEach((file, index) => {
        // Validar tamaño
        if (file.size > 5 * 1024 * 1024) {
            alert(`La imagen "${file.name}" es demasiado grande. Máximo 5MB por imagen`);
            return;
        }
        
        // Validar tipo
        if (!file.type.startsWith('image/')) {
            alert(`"${file.name}" no es una imagen válida`);
            return;
        }
        
        validFiles.push(file);
        
        // Crear preview
        const reader = new FileReader();
        reader.onload = function(event) {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'image-preview-item';
            previewDiv.innerHTML = `
                <img src="${event.target.result}" alt="Preview ${index + 1}">
                <div class="image-info">
                    <span class="filename">${file.name}</span>
                    <span class="filesize">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                    <button type="button" class="remove-image" onclick="removeImagePreview(this, ${index})">×</button>
                </div>
                <div class="image-controls">
                    <label>
                        <input type="checkbox" name="nueva_imagen_principal" value="${index}" ${index === 0 ? 'checked' : ''}>
                        Imagen principal
                    </label>
                </div>
            `;
            previewContainer.appendChild(previewDiv);
        };
        reader.readAsDataURL(file);
    });
    
    console.log(`${validFiles.length} imágenes seleccionadas`);
});

function removeImagePreview(button, index) {
    const previewItem = button.closest('.image-preview-item');
    previewItem.remove();
    
    // Actualizar el input file
    const fileInput = document.getElementById('imagenes');
    const dt = new DataTransfer();
    const files = Array.from(fileInput.files);
    
    files.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    fileInput.files = dt.files;
}

// Manejar selección de imagen principal para nuevas imágenes
document.addEventListener('change', function(e) {
    if (e.target.name === 'nueva_imagen_principal') {
        // Desmarcar otros checkboxes de imagen principal
        document.querySelectorAll('input[name="nueva_imagen_principal"]').forEach(checkbox => {
            if (checkbox !== e.target) {
                checkbox.checked = false;
            }
        });
    }
});
</script>

<style>
.current-images {
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.current-image-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.image-actions label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    margin: 0;
}

/* Reutilizar estilos del formulario de crear */
.image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    max-height: 400px;
    overflow-y: auto;
}

.image-preview-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
}

.image-preview-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.image-info {
    padding: 0.5rem;
    font-size: 0.8rem;
    position: relative;
}

.filename {
    display: block;
    font-weight: bold;
    margin-bottom: 0.25rem;
    word-break: break-all;
}

.filesize {
    color: #666;
}

.remove-image {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    font-size: 0.8rem;
    line-height: 1;
}

.image-controls {
    padding: 0.5rem;
    border-top: 1px solid #ddd;
    background: white;
}

.image-controls label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    margin: 0;
}
</style>

<?php require_once 'partials/footer.php'; ?>