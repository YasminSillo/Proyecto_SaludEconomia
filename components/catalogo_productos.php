<section class="catalog">
  
  <?php if (isset($error)): ?>
    <div class="error-message" style="grid-column: 1/-1; padding: 2rem; background: #f8d7da; color: #721c24; border-radius: 8px; margin-bottom: 2rem;">
      <h3>Error al cargar productos</h3>
      <p><?php echo htmlspecialchars($error); ?></p>
    </div>
  <?php endif; ?>

  <?php if (empty($productos)): ?>
    <div class="no-products" style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem;">
      <h3>No se encontraron productos</h3>
      <p>No hay productos disponibles en este momento.</p>
    </div>
  <?php else: ?>
    <?php foreach ($productos as $producto): ?>
      <article class="card">
        <div class="card__img" style="overflow: hidden; display: flex; align-items: center; justify-content: center;">
          <?php 
          $rutaImagen = '/imagenes/no-image.svg'; // Por defecto
          if ($producto->getImagen()) {
              $rutaImagen = '/imagenes/productos/' . $producto->getImagen();
          }
          ?>
          <img src="<?php echo htmlspecialchars($rutaImagen); ?>" 
               alt="<?php echo htmlspecialchars($producto->getNombre()); ?>"
               style="max-width: 100%; max-height: 100%; object-fit: cover;"
               onerror="this.src='/imagenes/no-image.svg'">
        </div>
        <div class="card__body">
          <div class="card__category">
            <?php echo htmlspecialchars($producto->categoriaNombre ?? 'Sin categoría'); ?>
          </div>
          <h3 class="card__title">
            <?php echo htmlspecialchars($producto->getNombre()); ?>
          </h3>
          <p class="card__desc">
            <?php if ($producto->getDescripcion()): ?>
              <?php echo htmlspecialchars(substr($producto->getDescripcion(), 0, 120)); ?>
              <?php if (strlen($producto->getDescripcion()) > 120): ?>...<?php endif; ?>
              <br>
            <?php endif; ?>
            <small style="color: #666;">
              SKU: <?php echo htmlspecialchars($producto->getCodigoSku()); ?>
              <?php if ($producto->proveedorNombre): ?>
                | <?php echo htmlspecialchars($producto->proveedorNombre); ?>
              <?php endif; ?>
            </small>
          </p>
          <div class="card__price">
            <?php if ($producto->getPrecio()): ?>
              S/ <?php echo number_format($producto->getPrecio(), 2); ?>
            <?php else: ?>
              Consultar precio
            <?php endif; ?>
          </div>
          <div class="card__stock">Disponible</div>
        </div>
        <div class="card__footer">
          <button class="card__btn" onclick="contactarVenta('<?php echo htmlspecialchars($producto->getNombre()); ?>')">
            Consultar
          </button>
        </div>
      </article>
    <?php endforeach; ?>
  <?php endif; ?>

</section>

<script>
function contactarVenta(nombreProducto) {
  // Función para contactar por WhatsApp o mostrar información de contacto
  const mensaje = encodeURIComponent(`Hola, me interesa el producto: ${nombreProducto}`);
  const whatsapp = `https://wa.me/51999999999?text=${mensaje}`; // Reemplazar con número real
  window.open(whatsapp, '_blank');
}
</script>