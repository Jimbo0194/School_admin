<?php
require_once __DIR__ . '/database/database.php';

$database = new Database();
$conn = $database->getConnection();

if ($conn === null) {
    echo "Error de conexión.";
    exit();
}

$sql = "SELECT * FROM alumnos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Estudiantes</title>
</head>
<body>
    <h1>Listado de Estudiantes</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono 1</th>
                <th>Teléfono 2</th>
                <th>Correo</th>
                <th>Fecha de Nacimiento</th>
                <th>Dirección</th>
                <th>Estado Estudiante</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $estudiante): ?>
                <tr>
                    <td><?= $estudiante['CEDULA'] ?></td>
                    <td><?= $estudiante['NOMBRE'] ?></td>
                    <td><?= $estudiante['APELLIDOS'] ?></td>
                    <td><?= $estudiante['TELEFONO_1'] ?></td>
                    <td><?= $estudiante['TELEFONO_2'] ?></td>
                    <td><?= $estudiante['CORREO'] ?></td>
                    <td><?= $estudiante['FECHA_NACIMIENTO'] ?></td>
                    <td><?= $estudiante['DIRECCION'] ?></td>
                    <td><?= $estudiante['ESTADO_ESTUDIANTE'] ?></td>
                    <td>
                        <a href="editar_estudiante.php?cedula=<?= $estudiante['CEDULA'] ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

