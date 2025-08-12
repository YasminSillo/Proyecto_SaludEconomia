<?php 
require_once __DIR__ . '/../src/Bootstrap.php';

$bootstrap = new Bootstrap();

// Obtener ID del producto
$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: catalogo.php?error=Producto no encontrado');
    exit;
}

// Obtener el producto
try {
    $productoRepository = $bootstrap->getProductoRepository();
    $producto = $productoRepository->obtenerPorId($id);
    
    if (!$producto) {
        header('Location: catalogo.php?error=Producto no encontrado');
        exit;
    }
    
    // Obtener productos relacionados de la misma categoría
    $productosRelacionados = $productoRepository->obtenerPorCategoria($producto->getCategoriaId());
    // Filtrar el producto actual de los relacionados
    $productosRelacionados = array_filter($productosRelacionados, function($p) use ($id) {
        return $p->getId() != $id;
    });
    // Limitar a 4 productos relacionados
    $productosRelacionados = array_slice($productosRelacionados, 0, 4);
    
} catch (Exception $e) {
    header('Location: catalogo.php?error=Error al cargar producto');
    exit;
}

require_once __DIR__ . '/../components/header.php'; 
?>
<body>
    <?php require_once __DIR__ . '/../components/navbar.php'; ?>
    
    <main class="main">
        <div class="product-detail">
            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="index.php">Inicio</a>
                <span>/</span>
                <a href="catalogo.php">Catálogo</a>
                <span>/</span>
                <span><?= htmlspecialchars($producto->getNombre()) ?></span>
            </nav>

            <!-- Detalle del producto -->
            <div class="product-info">
                <div class="product-gallery">
                    <?php 
                    // Por ahora usar la imagen única, luego se implementará la galería completa
                    $rutaImagen = 'imagenes/no-image.svg';
                    if ($producto->getImagen()) {
                        $rutaImagen = 'imagenes/productos/' . $producto->getImagen();
                    }
                    
                    // Simular múltiples imágenes para demostración
                    $imagenes = [];
                    if ($producto->getImagen()) {
                        $imagenes[] = [
                            'url' => 'imagenes/productos/' . $producto->getImagen(),
                            'alt' => htmlspecialchars($producto->getNombre())
                        ];
                        // Agregar la misma imagen con diferentes "vistas" para demo
                        $imagenes[] = [
                            'url' => 'imagenes/productos/' . $producto->getImagen(),
                            'alt' => htmlspecialchars($producto->getNombre()) . ' - Vista 2'
                        ];
                    } else {
                        $imagenes[] = [
                            'url' => 'imagenes/no-image.svg',
                            'alt' => 'Sin imagen'
                        ];
                    }
                    ?>
                    
                    <div class="gallery-container">
                        <!-- Imagen principal -->
                        <div class="main-image">
                            <img id="mainImage" 
                                 src="<?= htmlspecialchars($imagenes[0]['url']) ?>" 
                                 alt="<?= $imagenes[0]['alt'] ?>"
                                 onerror="this.src='imagenes/no-image.svg'">
                            <div class="image-zoom" onclick="openLightbox()">🔍</div>
                        </div>
                        
                        <!-- Miniaturas -->
                        <?php if (count($imagenes) > 1): ?>
                            <div class="thumbnails">
                                <?php foreach ($imagenes as $index => $imagen): ?>
                                    <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>" 
                                         onclick="changeMainImage('<?= htmlspecialchars($imagen['url']) ?>', '<?= htmlspecialchars($imagen['alt']) ?>', <?= $index ?>)">
                                        <img src="<?= htmlspecialchars($imagen['url']) ?>" 
                                             alt="<?= $imagen['alt'] ?>"
                                             onerror="this.src='imagenes/no-image.svg'">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="product-details">
                    <div class="product-meta">
                        <span class="product-category">
                            <?= htmlspecialchars($producto->categoriaNombre ?? 'Sin categoría') ?>
                        </span>
                        <span class="product-sku">
                            SKU: <?= htmlspecialchars($producto->getCodigoSku()) ?>
                        </span>
                    </div>

                    <h1 class="product-title">
                        <?= htmlspecialchars($producto->getNombre()) ?>
                    </h1>

                    <?php if ($producto->getDescripcion()): ?>
                        <div class="product-description">
                            <h3>Descripción</h3>
                            <p><?= nl2br(htmlspecialchars($producto->getDescripcion())) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($producto->getPrecio()): ?>
                        <div class="product-price">
                            <span class="price">S/ <?= number_format($producto->getPrecio(), 2) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($producto->proveedorNombre): ?>
                        <div class="product-supplier">
                            <strong>Proveedor:</strong> <?= htmlspecialchars($producto->proveedorNombre) ?>
                        </div>
                    <?php endif; ?>

                    <div class="product-actions">
                        <button class="btn btn-primary" onclick="contactarVenta('<?= htmlspecialchars($producto->getNombre()) ?>')">
                            📞 Consultar Disponibilidad
                        </button>
                        <button class="btn btn-secondary" onclick="compartirProducto()">
                            📤 Compartir
                        </button>
                        <a href="catalogo.php" class="btn btn-outline">
                            ← Volver al Catálogo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Productos relacionados -->
            <?php if (!empty($productosRelacionados)): ?>
                <section class="related-products">
                    <h2>Productos Relacionados</h2>
                    <div class="products-grid">
                        <?php foreach ($productosRelacionados as $productoRel): ?>
                            <article class="card">
                                <div class="card__img">
                                    <?php 
                                    $rutaImagenRel = 'imagenes/no-image.svg';
                                    if ($productoRel->getImagen()) {
                                        $rutaImagenRel = 'imagenes/productos/' . $productoRel->getImagen();
                                    }
                                    ?>
                                    <img src="<?= htmlspecialchars($rutaImagenRel) ?>" 
                                         alt="<?= htmlspecialchars($productoRel->getNombre()) ?>"
                                         onerror="this.src='imagenes/no-image.svg'">
                                </div>
                                <div class="card__body">
                                    <div class="card__category">
                                        <?= htmlspecialchars($productoRel->categoriaNombre ?? 'Sin categoría') ?>
                                    </div>
                                    <h3 class="card__title">
                                        <?= htmlspecialchars($productoRel->getNombre()) ?>
                                    </h3>
                                    <div class="card__price">
                                        <?php if ($productoRel->getPrecio()): ?>
                                            S/ <?= number_format($productoRel->getPrecio(), 2) ?>
                                        <?php else: ?>
                                            Consultar precio
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card__footer">
                                    <a href="producto.php?id=<?= $productoRel->getId() ?>" class="card__btn btn-secondary">
                                        Ver Detalles
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>
    
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <div class="lightbox-content">
            <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
            <img id="lightboxImage" src="" alt="">
            <div class="lightbox-navigation">
                <button id="prevBtn" onclick="navigateLightbox(-1)">❮</button>
                <button id="nextBtn" onclick="navigateLightbox(1)">❯</button>
            </div>
        </div>
    </div>

    <script>
    let currentImageIndex = 0;
    const images = <?= json_encode($imagenes) ?>;

    function contactarVenta(nombreProducto) {
        const mensaje = encodeURIComponent(`Hola, me interesa el producto: ${nombreProducto}. ¿Podrían proporcionarme más información sobre disponibilidad y precio?`);
        const whatsapp = `https://wa.me/51999999999?text=${mensaje}`; // Reemplazar con número real
        window.open(whatsapp, '_blank');
    }

    function compartirProducto() {
        const url = window.location.href;
        const title = document.querySelector('.product-title').textContent;
        
        if (navigator.share) {
            navigator.share({
                title: title,
                text: `Mira este producto: ${title}`,
                url: url
            });
        } else {
            // Fallback: copiar URL al portapapeles
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copiada al portapapeles');
            }).catch(() => {
                // Fallback del fallback
                prompt('Copia esta URL:', url);
            });
        }
    }

    function changeMainImage(url, alt, index) {
        document.getElementById('mainImage').src = url;
        document.getElementById('mainImage').alt = alt;
        currentImageIndex = index;
        
        // Actualizar thumbnails activos
        document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });
    }

    function openLightbox() {
        document.getElementById('lightbox').style.display = 'flex';
        const mainImage = document.getElementById('mainImage');
        document.getElementById('lightboxImage').src = mainImage.src;
        document.getElementById('lightboxImage').alt = mainImage.alt;
        document.body.style.overflow = 'hidden';
        
        // Mostrar/ocultar botones de navegación
        document.getElementById('prevBtn').style.display = images.length > 1 ? 'block' : 'none';
        document.getElementById('nextBtn').style.display = images.length > 1 ? 'block' : 'none';
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = '';
    }

    function navigateLightbox(direction) {
        currentImageIndex += direction;
        if (currentImageIndex < 0) currentImageIndex = images.length - 1;
        if (currentImageIndex >= images.length) currentImageIndex = 0;
        
        const image = images[currentImageIndex];
        document.getElementById('lightboxImage').src = image.url;
        document.getElementById('lightboxImage').alt = image.alt;
        
        // También actualizar la imagen principal
        changeMainImage(image.url, image.alt, currentImageIndex);
    }

    // Cerrar lightbox con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            navigateLightbox(-1);
        } else if (e.key === 'ArrowRight') {
            navigateLightbox(1);
        }
    });
    </script>

    <style>
    .product-detail {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .breadcrumb {
        margin-bottom: 2rem;
        color: #666;
    }

    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .product-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .gallery-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .product-gallery .main-image {
        background: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        cursor: pointer;
    }

    .product-gallery .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-gallery .main-image:hover img {
        transform: scale(1.05);
    }

    .image-zoom {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 0.5rem;
        border-radius: 50%;
        font-size: 1.2rem;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .main-image:hover .image-zoom {
        opacity: 1;
    }

    .thumbnails {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding: 0.5rem 0;
    }

    .thumbnail {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail:hover,
    .thumbnail.active {
        border-color: #007bff;
        transform: scale(1.05);
    }

    .thumbnail.active {
        box-shadow: 0 0 10px rgba(0,123,255,0.3);
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        text-align: center;
    }

    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10000;
    }

    .lightbox img {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
    }

    .lightbox-navigation {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .lightbox-navigation button {
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        padding: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        border-radius: 50%;
        pointer-events: all;
        transition: background 0.3s ease;
    }

    .lightbox-navigation button:hover {
        background: rgba(0,0,0,0.8);
    }

    .product-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: #666;
    }

    .product-category {
        background: #e9ecef;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
    }

    .product-title {
        font-size: 2rem;
        margin-bottom: 1.5rem;
        color: #2c3e50;
    }

    .product-description {
        margin-bottom: 2rem;
    }

    .product-description h3 {
        margin-bottom: 1rem;
        color: #34495e;
    }

    .product-price {
        margin-bottom: 1.5rem;
    }

    .product-price .price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #27ae60;
    }

    .product-supplier {
        margin-bottom: 2rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .product-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .related-products {
        margin-top: 3rem;
    }

    .related-products h2 {
        margin-bottom: 2rem;
        text-align: center;
        color: #2c3e50;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .product-info {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .product-detail {
            padding: 1rem;
        }
        
        .product-actions {
            flex-direction: column;
        }
    }
    </style>
</body>
</html>