<?php
session_start();
include("test_conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Consulta preparada
    $sql = "SELECT id, email, password, rol FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar usuario y contraseña segura
    if ($usuario && password_verify($clave, $usuario['password'])) {
        // Asignar los datos del usuario en la sesión
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol']
        ];

        // Redireccionar según el rol
        switch ($usuario['rol']) {
            case 'admin':
                header("Location: admin.php");
                exit();
            case 'docente':
                header("Location: docente.php");
                exit();
            case 'estudiante':
                header("Location: estudiante.php");
                exit();
            default:
                echo "<script>alert('❌ Rol no válido'); window.location.href = 'login.php';</script>";
                exit();
        }
    } else {
        echo "<script>alert('❌ Usuario o contraseña incorrectos'); window.location.href = 'login.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('❌ Acceso no válido'); window.location.href = 'login.php';</script>";
    exit();
}
?>
