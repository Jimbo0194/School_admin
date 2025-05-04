<?php
require_once __DIR__ . '/fpdf/fpdf.php';
require_once __DIR__ . '/adodb/adodb.inc.php';

$conn = NewADOConnection('mysqli');
$conn->Connect('localhost', 'root', '', 'proyecto_db');
$conn->SetFetchMode(ADODB_FETCH_ASSOC);

class PDF extends FPDF {
    function Header() {
        
        if (file_exists(__DIR__ . '/logo.jpeg')) {
            $this->Image(__DIR__ . '/logo.jpeg', 10, 10, 30);
        }
        
        //  reporte
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(190, 10, "Escuela La Galleta Estudiosa", 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(190, 10, "Reporte de Notas", 0, 1, 'C');
        $this->Ln(5);

        // Fecha 
        $this->SetFont('Arial', '', 12);
        $this->Cell(190, 10, "Fecha: " . date("d/m/Y"), 0, 1, 'R');
        $this->Ln(5);
    }

    function Footer() {
        //Final de la pagina
        $this->SetY(-30);
        $this->SetFont('Arial', '', 12);
        
        // Espacio para firma
        $this->Cell(60, 10, "_____________________", 0, 1, 'C');
        $this->Cell(60, 10, "Firma del docente", 0, 1, 'C');

        // Número de página
        $this->SetY(-15);
        $this->Cell(0, 10, "Página " . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255); 

$pdf->Cell(60, 10, "Estudiante", 1, 0, 'C', true);
$pdf->Cell(60, 10, "Materia", 1, 0, 'C', true);
$pdf->Cell(60, 10, "Nota", 1, 1, 'C', true);

$result = $conn->Execute("SELECT estudiante, materia, nota FROM notas ORDER BY estudiante");

if (!$result) {
    die("Error en la consulta SQL: " . $conn->ErrorMsg());
}

while ($row = $result->FetchRow()) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(60, 10, $row['estudiante'], 1);
    $pdf->Cell(60, 10, $row['materia'], 1);
    $pdf->Cell(60, 10, $row['nota'], 1);
    $pdf->Ln();
}

$pdf->Output("D", "Reporte_Notas.pdf"); 
?>