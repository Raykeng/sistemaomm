<?php
require('assets/fpdf/fpdf/fpdf.php');
include('includes/dbconnection.php'); // Asegúrate de que esta conexión esté configurada correctamente

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Lista de Estudiantes Mujeres', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Encabezados de columna con fondo y alineación centrada
$pdf->SetFillColor(200, 220, 255); // Color de fondo azul claro para los encabezados
$pdf->Cell(10, 10, 'Nro', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'DPI', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Curso', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(45, 10, 'Email', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Fecha Adm.', 1, 0, 'C', true);
$pdf->Ln();
// Consulta para obtener los datos de estudiantes mujeres con el nombre del curso
$query = $dbh->prepare("SELECT tblstudent.ID, tblstudent.StuID AS DPI, tblstudent.StudentName, 
                               tblstudent.StudentEmail, tblstudent.DOB, 
                               tblclass.ClassName AS Curso
                        FROM tblstudent 
                        JOIN tblclass ON tblclass.ID = tblstudent.StudentClass
                        WHERE tblstudent.Gender = 'Female'");
$query->execute();
$nro = 1; // Contador para el número
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(10, 10, $nro, 1, 0, 'C');
    $pdf->Cell(25, 10, $row['DPI'], 1, 0, 'C');
    $pdf->Cell(35, 10, utf8_decode($row['Curso']), 1, 0, 'C');
    $pdf->Cell(35, 10, utf8_decode($row['StudentName']), 1, 0, 'L');
    $pdf->Cell(45, 10, utf8_decode($row['StudentEmail']), 1, 0, 'L');
    $pdf->Cell(30, 10, $row['DOB'], 1, 0, 'C');
    $pdf->Ln();
    $nro++;
}

$pdf->Output('D', 'Reporte_Mujeres_Registradas.pdf'); // Forzar descarga del archivo
?>