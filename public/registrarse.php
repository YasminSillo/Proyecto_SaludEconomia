<?php 
require_once __DIR__ . '/../src/Bootstrap.php';
$bootstrap = new Bootstrap();
require_once __DIR__ . '/../components/header.php'; 
?>
<body>
    <!--ESTRUCTURA PRINCIPAL CON CSS GRID-->
    <?php require_once __DIR__ . '/../components/navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL-->
    <main class="main">
        <?php require_once __DIR__ . '/../components/formulario_registro.php'; ?>
    </main>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>