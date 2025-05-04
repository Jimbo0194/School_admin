<?php
include("./header.php");

if (!file_exists(__DIR__ . '/fpdf/fpdf.php')) {
    die("Error: La librería FPDF no está disponible.");
}
require_once __DIR__ . '/fpdf/fpdf.php';

if (isset($_GET['pdf'])) {
    ob_clean(); 
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(200, 10, utf8_decode('Lista de Notas'), 0, 1, 'C');

    $data = file_get_contents("http://localhost/Proyecto-Progralll/api/notas/index.php");
    $notas = json_decode($data, true);

    if (!is_array($notas)) {
        die("Error al obtener los datos de la API.");
    }

    $estudiantes = [];
    foreach ($notas as $nota) {
        $nombre = utf8_decode($nota['estudiante']);
        $materia = utf8_decode($nota['materia']);
        $nota_valor = $nota['nota'];
        
        if (!isset($estudiantes[$nombre])) {
            $estudiantes[$nombre] = [];
        }

        $clave_unica = $materia . '_' . $nota_valor;
        if (!isset($estudiantes[$nombre][$clave_unica])) {
            $estudiantes[$nombre][$clave_unica] = [
                'materia' => $materia,
                'nota' => $nota_valor
            ];
        }
    }

    $pdf->SetFont('Arial', '', 12);
    
    foreach ($estudiantes as $nombre => $registros) {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode("Estudiante: ") . $nombre, 0, 1);
        $pdf->SetFont('Arial', '', 12);
        
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(100, 10, utf8_decode('Materia'), 1, 0, 'C', true);
        $pdf->Cell(90, 10, 'Nota', 1, 1, 'C', true);
        
        foreach ($registros as $registro) {
            $pdf->Cell(100, 10, $registro['materia'], 1);
            $pdf->Cell(90, 10, $registro['nota'], 1, 1);
        }
        
        $pdf->Ln(10);
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="notas_sin_duplicados.pdf"');
    $pdf->Output();
    exit();
}
?>

<main class="container py-5">
    <h2 class="text-center text-primary mb-4">Lista de Notas</h2>
    <button onclick="descargarPDF()" class="btn btn-success mb-3">📄 Exportar a PDF</button>
    <div id="notas-container" class="row g-4"></div>
</main>

<style>
.card:hover {
    transform: translateY(-10px);
    transition: transform 0.3s ease;
}

.materia {
    color: blue;
    font-weight: bold;
}

.nota {
    color: green;
}

.nota-baja {
    color: red;
}
</style>

<script>
function descargarPDF() {
    window.location.href = window.location.href + '?pdf=true';
}

fetch('http://localhost/Proyecto-Progralll/api/notas/index.php')
    .then(response => response.text()) 
    .then(text => {
        try {
            const data = JSON.parse(text); 
            const container = document.getElementById("notas-container");
            let studentData = {};
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(item => {
                    if (!studentData[item.estudiante]) {
                        studentData[item.estudiante] = {};
                    }
                    if (!studentData[item.estudiante][item.materia]) {
                        studentData[item.estudiante][item.materia] = new Set();
                    }
                    studentData[item.estudiante][item.materia].add(item.nota);
                });

                container.innerHTML = Object.keys(studentData).map(student => {
                    let studentHtml = ` 
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <h3 class="card-title text-success text-center">${student}</h3>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Materia</th>
                                                <th>Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                    Object.keys(studentData[student]).forEach(materia => {
                        const notas = Array.from(studentData[student][materia]).join(', ');
                        studentHtml += `
                            <tr>
                                <td class="materia">${materia}</td>
                                <td class="nota">${notas.split(', ').map(nota => {
                                    return parseFloat(nota) < 65 ? 
                                    `<span class="nota-baja">${nota}</span>` : 
                                    `<span class="nota">${nota}</span>`;
                                }).join(', ')}</td>
                            </tr>`;
                    });
                    studentHtml += `</tbody></table></div></div></div>`;
                    return studentHtml;
                }).join('');
            } else {
                container.innerHTML = '<p>No hay notas disponibles.</p>';
            }
        } catch (error) {
            console.error("Error al convertir a JSON:", error);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
</script>

<?php include("./footer.php"); ?>








