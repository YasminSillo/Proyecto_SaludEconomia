<?php 
// Determinar que formulario mostrar basado en el parametro GET
$mostrar_registro = isset($_GET['action']) && $_GET['action'] === 'register';
require_once __DIR__ . '/../components/header.php'; 
?>
<body>
    <!--ESTRUCTURA PRINCIPAL CON CSS GRID-->
    <?php require_once __DIR__ . '/../components/navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL-->
    <main class="main">
        <?php 
        if ($mostrar_registro) {
            require_once __DIR__ . '/../components/formulario_registro.php';
        } else {
            require_once __DIR__ . '/../components/formulario_iniciar_sesion.php';
        }
        ?>
    </main>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>


