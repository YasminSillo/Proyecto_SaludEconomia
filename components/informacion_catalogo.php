
<div class="banner">
  <h2 class="banner__title">Catálogo de Productos</h2>
  <p class="banner__subtitle">
    Encuentra todos nuestros productos de cuidado personal y material quirúrgico
  </p>
  
  <!-- Filtros del catálogo -->
  <div class="catalog-filters" style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
    
    <!-- Buscador -->
    <form method="GET" style="display: flex; gap: 0.5rem;">
      <input type="text" 
             name="busqueda" 
             placeholder="Buscar productos..." 
             value="<?php echo htmlspecialchars($_GET['busqueda'] ?? ''); ?>"
             style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
      <?php if (isset($_GET['categoria'])): ?>
        <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($_GET['categoria']); ?>">
      <?php endif; ?>
      <button type="submit" 
              style="padding: 0.5rem 1rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
        🔍 Buscar
      </button>
    </form>

    <!-- Filtro por categoría -->
    <form method="GET" style="display: flex; gap: 0.5rem;">
      <select name="categoria" 
              onchange="this.form.submit()"
              style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
        <option value="">Todas las categorías</option>
        <?php if (isset($categorias) && !empty($categorias)): ?>
          <?php foreach ($categorias as $categoria): ?>
            <option value="<?php echo $categoria->getId(); ?>" 
                    <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $categoria->getId()) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($categoria->getNombre()); ?>
            </option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
      <?php if (isset($_GET['busqueda'])): ?>
        <input type="hidden" name="busqueda" value="<?php echo htmlspecialchars($_GET['busqueda']); ?>">
      <?php endif; ?>
    </form>

    <!-- Limpiar filtros -->
    <?php if (isset($_GET['categoria']) || isset($_GET['busqueda'])): ?>
      <a href="catalogo.php" 
         style="padding: 0.5rem 1rem; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
        🗑️ Limpiar Filtros
      </a>
    <?php endif; ?>
    
  </div>

  <!-- Información de resultados -->
  <?php if (isset($productos)): ?>
    <div class="results-info" style="text-align: center; margin-top: 1rem; color: #666;">
      <?php 
      $totalProductos = count($productos);
      if ($totalProductos > 0): ?>
        Mostrando <?php echo $totalProductos; ?> producto<?php echo $totalProductos != 1 ? 's' : ''; ?>
        <?php if (isset($_GET['categoria']) && !empty($_GET['categoria'])): ?>
          en la categoría seleccionada
        <?php endif; ?>
        <?php if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])): ?>
          para "<?php echo htmlspecialchars($_GET['busqueda']); ?>"
        <?php endif; ?>
      <?php else: ?>
        No se encontraron productos
        <?php if (isset($_GET['categoria']) || isset($_GET['busqueda'])): ?>
          con los filtros aplicados
        <?php endif; ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  
</div>