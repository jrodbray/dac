<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-07
 * Time: 11:07 AM
 */
?>
<?php

$core = $this->FPDF->core;

foreach ($data_array as $data):

    $core->AddPage();
    $core->AddFont('Calibri','','calibri.php');
    $core->AddFont('Calibri','B','calibrib.php');
    $core->AddFont('Calibri','I','calibrii.php');

    $core->SetFont('Arial','',16);
    $core->SetLineWidth(1);
    $core->SetDrawColor(0, 118, 163);
    $core->Rect(10,10,259,197, 'D');
    $core->SetLineWidth(.2);
    $core->Rect(25,25,227,165, 'D');

    $core->SetDrawColor(0);

    $core->SetFont('Calibri','',30);
    $core->SetXY(80, 30);
    $core->Cell(120, 20, 'Certificate of Achievement', 0, 0,'C');

    $core->SetTextColor(0,118,163);
    $core->SetFont('Calibri','B',36);
    $core->SetXY(80, 50);
    $core->Cell(120,20,$data['Name'], 0, 0, 'C');

    $core->SetTextColor(0);
    $core->SetFont('Calibri','I',18);
    $core->SetXY(80, 70);
    $core->Cell(120,10,'Has completed the following course', 0, 0, 'C');

    $core->SetFont('Calibri','',30);
    $core->SetXY(80, 90);
    $core->Cell(120,10, $data['Course1'], 0, 0, 'C');
    $core->SetFont('Calibri','',30);
    $core->SetXY(80, 103);
    $core->Cell(120,10, $data['Course2'], 0, 0, 'C');
    $core->SetFont('Calibri','',12);
    if($data['PDUs']){
        $core->SetXY(80, 115);
        $core->Cell(120,10, $data['PDUs'].' Training Hours', 0, 0, 'C');
    }

    // logos
    $core->Image( 'http://scottambler.com/dac/app/webroot/img/DAC.jpg', 152,130,0,15);
    $core->Image( 'http://scottambler.com/dac/app/webroot/img/SAA_logo.jpg', 174,155,0,15);

    // signatures & date
    $core->Image( 'http://scottambler.com/dac/app/webroot/img/AmblerSignature.jpg', 40,128,40);
    $core->SetLineWidth(.2);
    $core->Line(40,140,80,140);
    $core->SetFont('Calibri', '', 11);
    $core->SetXY(40,142);
    $core->Cell(40, 5, 'Scott Ambler');

    $core->Image( 'http://scottambler.com/dac/app/webroot/img/LinesSignature.jpg', 40,160,40);
    $core->SetLineWidth(.2);
    $core->Line(40,172,80,172);
    $core->SetXY(40,174);
    $core->Cell(40, 5, 'Mark Lines');

    $core->SetFont('Calibri', '', 12);
    $core->SetXY(120,166);
    $core->Cell(40, 5, $data['Date'], 0, 0, 'C');
    $core->Line(120,172,160,172);

endforeach;
$core->Output('example_001.pdf', 'I');
?>