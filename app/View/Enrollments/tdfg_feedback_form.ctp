<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-03-06
 * Time: 11:05 AM
 */
App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));
App::import('Vendor', 'tFpdf', array('file' => 'tfpdf/tfpdf.php'));

$courseOffering = $this->Session->read('course_offering');

$core = new FPDF('P', 'mm', 'Letter');
//$core = new tFPDF('P', 'mm', 'Letter');

$core->AddFont('Calibri','','calibri.php');
$core->AddFont('Calibri','B','calibrib.php');
$core->AddFont('Calibri','I','calibrii.php');
//$core->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
//$core->AddFont('DejaVu','B','DejaVuSans-Bold.ttf',true);
//$core->AddFont('DejaVu','I','DejaVuSerifCondensed-Italic.ttf',true);
//$core->AddFont('Calibri','','Calibri.ttf',true);
//$core->AddFont('Calibri','B','CalibriBold.ttf',true);
//$core->AddFont('Calibri','I','CalibriItalic.ttf',true);

$core->AddPage();

$core->Image('http://scottambler.com/dac/app/webroot/img/DAC.jpg', 10, 10, 100);
$core->Image('http://scottambler.com/dac/app/webroot/img/td_logo.jpg', 180, 12, 0, 15);

$core->SetTextColor(0, 0, 0);
$core->SetFont('Calibri', '', 12);
$core->SetXY(15, 30);
$core->Cell(15, 5, 'Course:', 0, 0, 'R');
$core->Cell(15, 5, $courseOffering[0]['Course']['course_code'], 0, 0, 'L');

$core->SetXY(15, 34);
$core->Cell(15, 5, 'Title:', 0, 0, 'R');
$core->Cell(15, 5, $courseOffering[0]['Course']['description'], 0, 0, 'L');

$core->SetXY(15, 38);
$core->Cell(15, 5, 'Instructor:', 0, 0, 'R');
$core->Cell(15, 5, $courseOffering[0]['InstructingPerson']['first_name'].' '.$courseOffering[0]['InstructingPerson']['last_name'], 0, 0, 'L');

$core->SetXY(15, 42);
$core->Cell(15, 5, 'Date:', 0, 0, 'R');
$core->Cell(15, 5, $date, 0, 0, 'L');

$core->SetLineWidth(.2);
$core->SetDrawColor(0, 118, 163);
$core->Line(10, 48, 206, 48);

$core->SetXY(15, 58);
$core->Cell(35, 5, 'Name (Optional):', 0, 0, 'L');
$core->SetLineWidth(.5);
$core->SetDrawColor(0, 0, 0);
$core->Line(50, 63, 150, 63);
$core->SetLineWidth(.2);
$core->SetDrawColor(0, 118, 163);
$core->Line(10, 65, 206, 65);

$core->SetFont('Calibri', 'B', 12);
$core->SetXY(15, 68);
$core->Cell(75, 5, 'Please rate the following Course aspects:', 0, 0, 'L');
$core->SetXY(120, 68);
$core->Cell(85, 5, '1=Poor to 5=Excellent', 0, 0, 'C');
$core->Line(10, 74, 206, 74);

$core->SetFont('Calibri', '', 12);
$core->SetXY(15, 78);
$core->Cell(75, 5, 'Instructor - Effectiveness', 0, 0, 'L');
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number1.png', 140, 78, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number2.png', 150, 78, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number3.png', 160, 78, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number4.png', 170, 78, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number5.png', 180, 78, 4);
$core->Line(10, 85, 206, 85);

$core->SetXY(15, 88);
$core->Cell(75, 5, 'Instructor - Knowledge', 0, 0, 'L');
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number1.png', 140, 88, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number2.png', 150, 88, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number3.png', 160, 88, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number4.png', 170, 88, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number5.png', 180, 88, 4);
$core->Line(10, 95, 206, 95);

$core->SetXY(15, 98);
$core->Cell(75, 5, 'Scope of Content', 0, 0, 'L');
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number1.png', 140, 98, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number2.png', 150, 98, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number3.png', 160, 98, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number4.png', 170, 98, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number5.png', 180, 98, 4);
$core->Line(10, 105, 206, 105);

$core->SetXY(15, 108);
$core->Cell(75, 5, 'Depth of Content', 0, 0, 'L');
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number1.png', 140, 108, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number2.png', 150, 108, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number3.png', 160, 108, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number4.png', 170, 108, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number5.png', 180, 108, 4);
$core->Line(10, 115, 206, 115);

$core->SetXY(15, 118);
$core->Cell(75, 5, 'Applicability of Content', 0, 0, 'L');
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number1.png', 140, 118, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number2.png', 150, 118, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number3.png', 160, 118, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number4.png', 170, 118, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number5.png', 180, 118, 4);
$core->Line(10, 125, 206, 125);

$core->SetXY(15, 128);
$core->Cell(75, 5, 'Slideware', 0, 0, 'L');
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number1.png', 140, 128, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number2.png', 150, 128, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number3.png', 160, 128, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number4.png', 170, 128, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number5.png', 180, 128, 4);
$core->Line(10, 135, 206, 135);

$core->SetXY(15, 138);
$core->Cell(75, 5, 'How would you rate this session overall?', 0, 0, 'L');
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number1.png', 140, 138, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number2.png', 150, 138, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number3.png', 160, 138, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number4.png', 170, 138, 4);
$core->Image('http://scottambler.com/dac/app/webroot/img/ico/PNGs/24/number5.png', 180, 138, 4);
$core->Line(10, 145, 206, 145);

$core->SetXY(15, 148);
$core->Cell(75, 5, 'Do you have positive comments that you would like to share?', 0, 0, 'L');

$core->SetXY(15, 188);
$core->Cell(75, 5, 'Can we quote you?     Yes     No', 0, 0, 'L');
$core->Line(10, 195, 206, 195);

$core->SetXY(15, 198);
$core->Cell(75, 5, 'How would you improve this workshop?', 0, 0, 'L');

$core->Line(10, 256, 206, 256);
$core->SetFont('Calibri', '', 8);
$core->SetTextColor(0, 118, 263);
$core->SetXY(10, 257);
$core->Cell(50, 2, 'www.disciplinedagilecortium.org', 0, 0, 'L');
$core->SetXY(60, 257);
$core->Cell(89, 2, 'Calgary, Alberta, CANADA', 0, 0, 'C');
$core->SetXY(146, 257);
$core->Cell(60, 2, 'www.disciplinedagiledelivery.com', 0, 0, 'R');




$core->Output('feedback.pdf', 'I');
?>