<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="../imagenes/logo_saludEconomia.png" alt="SaludEconomía" class="logo-img">
            <span class="logo-text">SaludEconomía</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
                <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <i class="icon-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="usuarios.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'usuarios.php' ? 'active' : ''; ?>">
                    <i class="icon-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="clientes.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'clientes.php' ? 'active' : ''; ?>">
                    <i class="icon-clients"></i>
                    <span>Clientes</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="productos.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'productos.php' ? 'active' : ''; ?>">
                    <i class="icon-products"></i>
                    <span>Productos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="categorias.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'categorias.php' ? 'active' : ''; ?>">
                    <i class="icon-categories"></i>
                    <span>Categorías</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="proveedores.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'proveedores.php' ? 'active' : ''; ?>">
                    <i class="icon-suppliers"></i>
                    <span>Proveedores</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="pedidos.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pedidos.php' ? 'active' : ''; ?>">
                    <i class="icon-orders"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="inventario.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'inventario.php' ? 'active' : ''; ?>">
                    <i class="icon-inventory"></i>
                    <span>Inventario</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="compras.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'compras.php' ? 'active' : ''; ?>">
                    <i class="icon-purchases"></i>
                    <span>Compras</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="pagos.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pagos.php' ? 'active' : ''; ?>">
                    <i class="icon-payments"></i>
                    <span>Pagos</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <?php echo strtoupper(substr($_SESSION['usuario_nombre'] ?? 'A', 0, 1)); ?>
            </div>
            <div class="user-details">
                <span class="user-name" title="<?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Administrador'); ?>">
                    <?php echo htmlspecialchars(strlen($_SESSION['usuario_nombre'] ?? '') > 15 ? substr($_SESSION['usuario_nombre'], 0, 15) . '...' : $_SESSION['usuario_nombre'] ?? 'Administrador'); ?>
                </span>
                <span class="user-role">
                    <?php 
                    $rol = $_SESSION['usuario_rol'] ?? 'admin';
                    echo $rol === 'admin' ? 'Administrador' : ucfirst($rol);
                    ?>
                </span>
            </div>
        </div>
        <div class="logout-section">
            <a href="../index.php" class="btn-secondary btn-sm" title="Ir al sitio público">🏠 Sitio</a>
            <a href="logout.php" class="btn-danger btn-sm" title="Cerrar sesión">🚪 Salir</a>
        </div>
    </div>
</aside>