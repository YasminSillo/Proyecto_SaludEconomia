<?php
// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    // Si es una petición AJAX, devolver error JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No autenticado', 'redirect' => '../iniciar_sesion.php']);
        exit;
    }
    
    // Redirigir a login con mensaje
    header('Location: ../iniciar_sesion.php?error=Debe iniciar sesión para acceder al panel administrativo');
    exit;
}

// Verificar si el usuario tiene permisos de administrador (opcional, comentado por ahora)
/*
if ($_SESSION['usuario_rol'] !== 'admin') {
    header('Location: ../index.php?error=No tiene permisos para acceder al panel administrativo');
    exit;
}
*/

// Actualizar último acceso (opcional)
$_SESSION['ultimo_acceso'] = time();

// Verificar timeout de sesión (opcional - 2 horas)
$timeout = 2 * 60 * 60; // 2 horas en segundos
if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso']) > $timeout) {
    session_unset();
    session_destroy();
    header('Location: ../iniciar_sesion.php?error=Su sesión ha expirado');
    exit;
}
?>