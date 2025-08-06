<?php require_once __DIR__ . '/../components/header.php'; ?>
<body>
    <!--ESTRUCTURA PRINCIPAL CON CSS GRID-->
    <?php require_once __DIR__ . '/../components/navbar.php'; ?>

    <!-- CONTENIDO PRINCIPAL-->
    <main class="main">
        <?php require_once __DIR__ . '/../components/patrocinadores_hero.php'; ?>
        <?php require_once __DIR__ . '/../components/patrocinadores_gallery.php'; ?>
        <?php require_once __DIR__ . '/../components/patrocinadores_beneficios.php'; ?>
        <?php require_once __DIR__ . '/../components/patrocinadores_contacto.php'; ?>
    </main>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>