<?php 
require('assets/fpdf/fpdf/fpdf.php');
include('includes/dbconnection.php'); // Asegúrate de que esta conexión esté configurada correctamente

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte de Cursos', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Encabezados de columna con fondo y alineación centrada
$pdf->SetFillColor(200, 220, 255); // Color de fondo azul claro para los encabezados
$pdf->Cell(10, 10, 'Nro', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Nombre del Curso', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Seccion', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Fecha de Creacion', 1, 0, 'C', true);
$pdf->Ln();

// Consulta para obtener los datos de los cursos
$query = $dbh->prepare("SELECT ID, ClassName, Section, CreationDate FROM tblclass");
$query->execute();
$nro = 1; // Contador para el número

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(10, 10, $nro, 1, 0, 'C');
    $pdf->Cell(60, 10, utf8_decode($row['ClassName']), 1, 0, 'L');
    $pdf->Cell(30, 10, utf8_decode($row['Section']), 1, 0, 'C');
    $pdf->Cell(50, 10, $row['CreationDate'], 1, 0, 'C');
    $pdf->Ln();
    $nro++;
}

// Salida del PDF
$pdf->Output('D', 'Reporte_Cursos.pdf'); // Forzar descarga del archivo
?>