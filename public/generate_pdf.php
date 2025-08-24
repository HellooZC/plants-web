<?php
require('fpdf/fpdf.php');

$id = $_GET['id'];

$file = fopen("data/herbarium.txt", "r");

$selectedPlant = null;

while (($line = fgets($file)) !== false) {
    $plant = explode("|", trim($line));
    if ($plant[0] == $id) {
        $selectedPlant = $plant;
        break;
    }
}

fclose($file);

if ($selectedPlant !== null) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    
    $pdf->Cell(40, 10, $selectedPlant[1] . ' (' . $selectedPlant[2] . ')');
    $pdf->Ln(10);
    
    $pdf->Image($selectedPlant[3], 10, 30, 50, 50);
    $pdf->Ln(60);
    
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Family: ' . $selectedPlant[6]);
    $pdf->Ln(10);
    
    $pdf->MultiCell(0, 10, 'By contrast with other plant cultivation practices, bonsai is not intended for production of food or for medicine. Instead, bonsai practice focuses on long-term cultivation and shaping of one or more small trees growing in a container.');
    
    $pdf->Output('D', $selectedPlant[1] . '_details.pdf');
} else {
    echo 'Plant not found.';
}
?>
