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
$core->AddFont('Calibri','','calibri.php');
$core->AddFont('Calibri','B','calibrib.php');
$core->AddFont('Calibri','I','calibrii.php');


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
    $core->Rect(11,11,257,195, 'D');

    $core->SetDrawColor(0);

    $core->SetFont('Calibri','',30);
    $core->SetXY(80, 20);
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
        $core->Cell(120,10, $data['PDUs'].' PDUs Awarded', 0, 0, 'C');
    }

    $core->Image( 'http://scottambler.com/dac/app/webroot/img/DAC.jpg', 162,140,0,15);
    $core->Image( 'http://scottambler.com/dac/app/webroot/img/td_logo.jpg', 225,165,0,15);

    $core->Image( 'http://scottambler.com/dac/app/webroot/img/AmblerSignature.jpg', 30,138,40);
    $core->SetLineWidth(.2);
    $core->Line(30,150,70,150);
    $core->SetFont('Calibri', '', 11);
    $core->SetXY(30,152);
    $core->Cell(40, 5, 'Scott Ambler');

    $core->Image( 'http://scottambler.com/dac/app/webroot/img/LinesSignature.jpg', 30,170,40);
    $core->SetLineWidth(.2);
    $core->Line(30,182,70,182);
    $core->SetXY(30,184);
    $core->Cell(40, 5, 'Mark Lines');

    $core->SetFont('Calibri', '', 12);
    $core->SetXY(120,176);
    $core->Cell(40, 5, $data['Date'], 0, 0, 'C');
    $core->Line(120,182,160,182);


endforeach;
$core->Output('example_001.pdf', 'I');
?>