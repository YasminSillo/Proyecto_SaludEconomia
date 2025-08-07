<?php
// Datos de conexión
$host = "localhost";
$base_datos = "gestion_ventas";
$usuario = "root";
$contrasena = "";

try {
    // Crear conexión PDO
    $conexion = new PDO("mysql:host=$host;dbname=$base_datos;charset=utf8", $usuario, $contrasena);
    
    // Configurar errores
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejemplo de consulta
    // $stmt = $conexion->query("SELECT * FROM usuarios");

    // while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //     echo $fila['columna'] . "<br>";
    // }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
