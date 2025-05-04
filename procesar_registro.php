<?php 
include('test_conexion.php');

function mostrarMensaje($mensaje, $tipo = 'exito') {
    $color = $tipo === 'exito' ? '#D4EDDA' : '#F8D7DA';
    $borde = $tipo === 'exito' ? '#C3E6CB' : '#F5C6CB';
    $texto = $tipo === 'exito' ? '#155724' : '#721C24';

    echo "<div style='
        max-width: 400px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 8px;
        background-color: $color;
        border: 1px solid $borde;
        color: $texto;
        text-align: center;
        font-family: Arial, sans-serif;
    '>
        <p>$mensaje</p>";

    if ($tipo === 'exito') {
        echo "<a href='login.php' style='
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #673AB7;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        '>Iniciar Sesión</a>";
    }

    echo "</div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $confirmar_clave = $_POST['confirmar_clave'];
    $rol = 'estudiante';

    if ($clave !== $confirmar_clave) {
        mostrarMensaje("Las contraseñas no coinciden.", 'error');
        exit();
    }

    $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        mostrarMensaje("El correo electrónico ya está registrado.", 'error');
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :correo, :clave, :rol)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':clave', $hashedPassword); 
        $stmt->bindParam(':rol', $rol);

        if ($stmt->execute()) {
            mostrarMensaje("¡Registro exitoso! Ya puedes iniciar sesión.");
        } else {
            mostrarMensaje("Hubo un error al registrar el usuario.", 'error');
        }
    }
}
?>








