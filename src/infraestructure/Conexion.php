<?php
// Datos de conexión
$host = "localhost";
$base_datos = "gestion_ventas";
$usuario = "root";
$contrasena = "";

try {
    // Crear conexión PDO con opciones mejoradas
    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_TIMEOUT => 30
    ];
    
    $conexion = new PDO("mysql:host=$host;dbname=$base_datos;charset=utf8", $usuario, $contrasena, $opciones);

    // Ejemplo de consulta
    // $stmt = $conexion->query("SELECT * FROM usuarios");

    // while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //     echo $fila['columna'] . "<br>";
    // }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
