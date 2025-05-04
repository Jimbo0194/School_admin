<?php
require_once(__DIR__ . '/database/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (
        isset($data['id']) &&
        isset($data['nombre']) &&
        isset($data['correo']) &&
        isset($data['grupo_id']) &&
        isset($data['grupo_nombre']) &&
        isset($data['grupo_descripcion'])
    ) {
        $id = $data['id'];
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $grupo_id = $data['grupo_id'];
        $grupo_nombre = $data['grupo_nombre'];
        $grupo_descripcion = $data['grupo_descripcion'];

        // Actualizar estudiante
        $sqlEstudiante = "UPDATE estudiantes SET nombre = :nombre, correo = :correo, grupo_id = :grupo_id WHERE id = :id";
        $stmt = $conn->prepare($sqlEstudiante);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':grupo_id', $grupo_id);
        $okEstudiante = $stmt->execute();

        // Actualizar grupo
        $sqlGrupo = "UPDATE grupos SET nombre = :grupo_nombre, descripcion = :grupo_descripcion WHERE id = :grupo_id";
        $stmtGrupo = $conn->prepare($sqlGrupo);
        $stmtGrupo->bindParam(':grupo_nombre', $grupo_nombre);
        $stmtGrupo->bindParam(':grupo_descripcion', $grupo_descripcion);
        $stmtGrupo->bindParam(':grupo_id', $grupo_id);
        $okGrupo = $stmtGrupo->execute();

        if ($okEstudiante && $okGrupo) {
            echo json_encode(['success' => true, 'message' => 'Estudiante y grupo actualizados con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Faltan datos necesarios.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>


