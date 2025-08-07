<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Panel Administrativo'; ?> - SaludEconomía</title>
    <link rel="stylesheet" href="../estilos/admin/admin.css">
    <link rel="stylesheet" href="../estilos/admin/sidebar.css">
    <link rel="stylesheet" href="../estilos/admin/crud.css">
    <link rel="stylesheet" href="../estilos/admin/components.css">
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>