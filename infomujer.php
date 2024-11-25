<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
require('path/to/fpdf.php'); // Asegúrate de que la ruta sea correcta

// Verifica si la sesión es válida
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Obtener el ID de la mujer desde la URL
$eid = $_GET['editid'];

// Consulta para obtener la información de la mujer
$sql = "SELECT tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.StudentClass, tblstudent.Gender, tblstudent.DOB, tblstudent.StuID, tblstudent.FatherName, tblstudent.MotherName, tblstudent.ContactNumber, tblstudent.AltenateNumber, tblstudent.Address, tblstudent.Image, tblclass.ClassName, tblclass.Section FROM tblstudent JOIN tblclass ON tblclass.ID = tblstudent.StudentClass WHERE tblstudent.ID = :eid";
$query = $dbh->prepare($sql);
$query->bindParam(':eid', $eid, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if ($result) {
    // Crear una instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Título del documento
    $pdf->Cell(0, 10, 'Informe Detallado de la Mujer', 0, 1, 'C');
    $pdf->Ln(10);

    // Información personal
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Informacion Personal', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Nombre:', 0, 0);
    $pdf->Cell(0, 10, $result->StudentName, 0, 1);
    $pdf->Cell(50, 10, 'Correo Electronico:', 0, 0);
    $pdf->Cell(0, 10, $result->StudentEmail, 0, 1);
    $pdf->Cell(50, 10, 'Curso:', 0, 0);
    $pdf->Cell(0, 10, $result->ClassName . ' ' . $result->Section, 0, 1);
    $pdf->Cell(50, 10, 'Genero:', 0, 0);
    $pdf->Cell(0, 10, $result->Gender, 0, 1);
    $pdf->Cell(50, 10, 'Fecha de Nacimiento:', 0, 0);
    $pdf->Cell(0, 10, $result->DOB, 0, 1);
    $pdf->Cell(50, 10, 'DPI:', 0, 0);
    $pdf->Cell(0, 10, $result->StuID, 0, 1);
    $pdf->Ln(10);

    // Información de contacto
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Informacion de Contacto', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Numero de Contacto:', 0, 0);
    $pdf->Cell(0, 10, $result->ContactNumber, 0, 1);
    $pdf->Cell(50, 10, 'Numero de Contacto Alternativo:', 0, 0);
    $pdf->Cell(0, 10, $result->AltenateNumber, 0, 1);
    $pdf->Cell(50, 10, 'Direccion:', 0, 0);
    $pdf->MultiCell(0, 10, $result->Address);
    $pdf->Ln(10);

    // Información de los padres
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Informacion de los Padres', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Nombre del Padre:', 0, 0);
    $pdf->Cell(0, 10, $result->FatherName, 0, 1);
    $pdf->Cell(50, 10, 'Nombre de la Madre:', 0, 0);
    $pdf->Cell(0, 10, $result->MotherName, 0, 1);
    $pdf->Ln(10);

    // Mostrar el PDF en el navegador
    $pdf->Output();
} else {
    echo 'No se encontró información para la mujer seleccionada.';
}
?>
