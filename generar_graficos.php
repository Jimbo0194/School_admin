<?php
require_once (__DIR__ . '/adodb/adodb.inc.php');

header('Content-Type: application/json');

// Conexión a la base de datos
$conn = NewADOConnection('mysqli');
$conn->Connect('localhost', 'root', '', 'proyecto_db');

// Consulta para obtener estudiantes por grupo
$queryEstudiantesPorGrupo = "SELECT IFNULL(grupos.nombre, 'Sin Grupo') AS grupo, COUNT(estudiantes.id) AS total 
                             FROM estudiantes 
                             LEFT JOIN grupos ON estudiantes.grupo_id = grupos.id 
                             GROUP BY grupos.nombre";
$resultEstudiantesPorGrupo = $conn->Execute($queryEstudiantesPorGrupo);

$datosEstudiantes = [];
while (!$resultEstudiantesPorGrupo->EOF) {
    $datosEstudiantes[] = [
        "grupo" => $resultEstudiantesPorGrupo->fields['grupo'],
        "cantidad" => $resultEstudiantesPorGrupo->fields['total']
    ];
    $resultEstudiantesPorGrupo->MoveNext();
}

// Consulta para obtener distribución de notas
$queryDistribucionNotas = "SELECT nota, COUNT(id) AS total FROM notas GROUP BY nota";
$resultDistribucionNotas = $conn->Execute($queryDistribucionNotas);

$datosNotas = [];
while (!$resultDistribucionNotas->EOF) {
    $datosNotas[] = [
        "nota" => $resultDistribucionNotas->fields['nota'],
        "cantidad" => $resultDistribucionNotas->fields['total']
    ];
    $resultDistribucionNotas->MoveNext();
}

// Devolver los datos en formato JSON
echo json_encode([ 
    "estudiantesPorGrupo" => $datosEstudiantes,
    "distribucionNotas" => $datosNotas
]);
?>


