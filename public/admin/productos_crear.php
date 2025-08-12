<?php 
require_once __DIR__ . '/../../src/Bootstrap.php';
require_once __DIR__ . '/auth_check.php';

$bootstrap = new Bootstrap();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $datos = [
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

        // Crear producto con imágenes múltiples
        $crearProductoUseCase = $bootstrap->getCrearProductoUseCase();
        $archivosImagenes = isset($_FILES['imagenes']) ? $_FILES['imagenes'] : null;
        $imagenPrincipal = isset($_POST['imagen_principal']) ? intval($_POST['imagen_principal']) : 0;
        
        $crearProductoUseCase->ejecutar($datos, $archivosImagenes, $imagenPrincipal);

        header('Location: productos.php?success=Producto creado exitosamente');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener categorías y proveedores para los selects
$categoriaRepository = $bootstrap->getCategoriaRepository();
$proveedorRepository = $bootstrap->getProveedorRepository();
$categorias = $categoriaRepository->obtenerActivas();
$proveedores = $proveedorRepository->obtenerTodos();

$title = 'Crear Producto';
?>

<?php require_once 'partials/head.php'; ?>

<?php require_once 'partials/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Crear Producto</h1>
            <p class="page-subtitle">Agregar nuevo producto al catálogo</p>
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
            <h3 class="form-title">Datos del Producto</h3>
        </div>

        <form method="POST" enctype="multipart/form-data" class="crud-form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="codigo_sku">Código SKU</label>
                    <input type="text" 
                           id="codigo_sku" 
                           name="codigo_sku" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($_POST['codigo_sku'] ?? ''); ?>" 
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
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
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
                                    <?php echo ($_POST['categoria_id'] ?? '') == $categoria->getId() ? 'selected' : ''; ?>>
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
                                    <?php echo ($_POST['proveedor_id'] ?? '') == $proveedor->getId() ? 'selected' : ''; ?>>
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
                           value="<?php echo htmlspecialchars($_POST['precio'] ?? ''); ?>" 
                           step="0.01"
                           min="0"
                           placeholder="0.00">
                    <small class="form-text">Precio de venta (opcional)</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="imagenes">Imágenes del Producto</label>
                    <input type="file" 
                           id="imagenes" 
                           name="imagenes[]" 
                           class="form-control" 
                           accept="image/*"
                           multiple>
                    <small class="form-text">Selecciona múltiples imágenes. Formatos: JPG, PNG, GIF, WEBP. Máximo 5MB por imagen</small>
                    <div id="imagePreview" class="image-preview-container" style="margin-top: 1rem;"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-control" 
                              rows="4"
                              placeholder="Descripción detallada del producto..."><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                    <small class="form-text">Descripción detallada del producto (opcional)</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="productos.php" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-warning">
                    📦 Crear Producto
                </button>
            </div>
        </form>
    </div>
</main>

<script>
// Preview de imágenes múltiples
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
                        <input type="checkbox" name="imagen_principal" value="${index}" ${index === 0 ? 'checked' : ''}>
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
    
    // Actualizar el input file (esto es limitado en navegadores por seguridad)
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

// Manejar selección de imagen principal
document.addEventListener('change', function(e) {
    if (e.target.name === 'imagen_principal') {
        // Desmarcar otros checkboxes de imagen principal
        document.querySelectorAll('input[name="imagen_principal"]').forEach(checkbox => {
            if (checkbox !== e.target) {
                checkbox.checked = false;
            }
        });
    }
});
</script>

<style>
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