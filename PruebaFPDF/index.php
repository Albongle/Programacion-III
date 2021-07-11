<?php
require_once "./FPDF/fpdf.php";
require_once "./PDF.php";
/**
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage(); //AddPage([string orientation [, mixed size [, int rotation]]])
//$pdf->SetMargins() la posición actual está por defecto situada a 1 cm de los bordes; los márgenes pueden cambiarse SetMargins(float left, float top [, float right])
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Cell(60,10,'Hecho con FPDF.',0,1,'C');
$pdf->Output();*/



$pdf = new PDF();
$header = array('País', 'Capital', 'Superficie (km2)', 'Pobl. (en miles)');
$data =  array(['Argentina','Buenos Aires','2323','111'],['Argentina','Buenos Aires','2323','111'],['Argentina','Buenos Aires','2323','111'],['Argentina','Buenos Aires','2323','111']);


$pdf->AddPage();
$pdf->FancyTable($header,$data);

$pdf->Output();



?>



