<?php 
require_once __DIR__ . '/../src/infraestructure/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_export($_POST);

    if ($_POST["formulario_seleccionado"] === "formulario_iniciar_sesion") {
        

        
    } elseif ($_POST["formulario_seleccionado"] === "formulario_registro") {
        // Suponiendo que ya tienes la conexión $conexion (PDO) 
        $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("INSERT INTO usuarios (email, password_hash) VALUES (:email, :password_hash)");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password_hash', $passwordHash); // Asumiendo que ya has generado el hash
        $stmt->execute();

    } else {
        // Manejo de error si el formulario no es reconocido
        echo "Formulario no reconocido.";
        exit();
    }
    // Acción para método POST
array ( 'nombre' => 'sergio7surco@gmail.com', 'apellido' => 'El DNI debe tesergio7surco@gmail.com digitos', 'dni' => 'sergio7surco@gmail.com', 'telefono' => 'sergio7surco@gmail.com', 'empresa' => 'sergio7surco@gmail.com', 'ruc' => 'sergio7surco@gmail.com', 'tipo_negocio' => 'clinica', 'direccion' => 'sergio7surco@gmail.com', 'email' => 'sergio7surco@gmail.comere', 'password' => 'sergio7surco@gmail.com', 'confirm_password' => 'sergio7surco@gmail.com', 'terms' => 'on', 'formulario_seleccionado' => 'formulario_registro', );
    // header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


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


