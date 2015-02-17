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

    $core->SetFont('Arial','',16);
    $core->SetLineWidth(1);
    $core->SetDrawColor(0, 135, 255);
    $core->Rect(10,10,259,197, 'D');
    $core->SetDrawColor(0);

    $core->SetFont('Arial','',28);
    $core->SetXY(80, 20);
    $core->Cell(120, 20, 'Certificate of Achievement', 0, 0,'C');

    $core->SetTextColor(0,135,255);
    $core->SetFont('Times','B',40);
    $core->SetXY(80, 50);
    $core->Cell(120,20,$data['Name'], 0, 0, 'C');

    $core->SetTextColor(0);
    $core->SetFont('Arial','I',16);
    $core->SetXY(80, 70);
    $core->Cell(120,10,'Has completed the following course', 0, 0, 'C');

    $core->SetFont('Arial','',28);
    $core->SetXY(80, 90);
    $core->Cell(120,10, $data['Course1'], 0, 0, 'C');
    $core->SetFont('Arial','',28);
    $core->SetXY(80, 103);
    $core->Cell(120,10, $data['Course2'], 0, 0, 'C');
    $core->SetFont('Arial','',16);
    if($data['PDUs']){
        $core->SetXY(80, 115);
        $core->Cell(120,10, $data['PDUs'].' PDUs Awarded', 0, 0, 'C');
    }

    $core->Image( 'http://scottambler.com/dac/app/webroot/img/DAC.jpg', 90,140,100);
    $core->Image( 'http://scottambler.com/dac/app/webroot/img/AmblerSignature.jpg', 30,170,40);
    $core->Image( 'http://scottambler.com/dac/app/webroot/img/LinesSignature.jpg', 200,170,40);

    //$core->Image( 'APP'.DIRECTORY_SEPARATOR.'webroot'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'DAC.jpg', 90,140,100);
    //$core->Image( 'APP'.DIRECTORY_SEPARATOR.'webroot'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'AmblerSignature.jpg', 30,170,40);
    //$core->Image( 'APP'.DIRECTORY_SEPARATOR.'webroot'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'LinesSignature.jpg', 200,170,40);

    $core->SetLineWidth(.2);
    $core->Line(30,182,70,182);
    $core->Line(120,182,160,182);
    $core->Line(200,182,240,182);

    $core->SetFont('Arial', '', 12);
    $core->SetXY(30,185);
    $core->Cell(40, 5, 'Scott Ambler');

    $core->SetXY(120,176);
    $core->Cell(40, 5, $data['Date'], 0, 0, 'C');

    $core->SetXY(200,185);
    $core->Cell(40, 5, 'Mark Lines');

endforeach;
$core->Output('example_001.pdf', 'I');
?>