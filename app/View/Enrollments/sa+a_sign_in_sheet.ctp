<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-03-04
 * Time: 2:25 PM
 */
App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));

$courseOffering = $this->Session->read('course_offering');
//echo print_r($courseOffering);

$core = new FPDF('L', 'mm', 'Letter');

$core->AddFont('Calibri','','calibri.php');
$core->AddFont('Calibri','B','calibrib.php');
$core->AddFont('Calibri','I','calibrii.php');


for($loop=0; $loop<20; $loop++) {

    if ($loop == 0 || $loop == 10) {
        $core->AddPage();

        $core->SetFont('Arial', '', 16);
        $core->SetLineWidth(.2);
        $core->SetDrawColor(0, 118, 163);
        $core->Rect(10, 62, 260, 130, 'D');
        $core->Line(70, 62, 70, 192);
        $core->Line(210, 62, 210, 192);


        $core->Image('http://scottambler.com/dac/app/webroot/img/DAC.jpg', 10, 10, 100);
        $core->Image('http://scottambler.com/dac/app/webroot/img/SAA_logo.jpg', 200, 12, 0, 15);

        $core->SetTextColor(0, 0, 0);
        $core->SetFont('Calibri', '', 10);
        $core->SetXY(20, 30);
        $core->Cell(20, 5, 'Course:', 0, 0, 'R');
        $core->Cell(20, 5, $courseOffering[0]['Course']['course_code'], 0, 0, 'L');

        $core->SetXY(20, 34);
        $core->Cell(20, 5, 'Title:', 0, 0, 'R');
        $core->Cell(20, 5, $courseOffering[0]['Course']['description'], 0, 0, 'L');

        $core->SetXY(20, 38);
        $core->Cell(20, 5, 'Instructor:', 0, 0, 'R');
        $core->Cell(20, 5, $courseOffering[0]['InstructingPerson']['first_name'].' '.$courseOffering[0]['InstructingPerson']['last_name'], 0, 0, 'L');

        $core->SetXY(20, 42);
        $core->Cell(20, 5, 'Date:', 0, 0, 'R');
        $core->Cell(20, 5, $date, 0, 0, 'L');

        $core->SetFont('Calibri', 'B', 10);
        $core->SetXY(10, 52);
        $core->Cell(60, 5, 'Name', 0, 0, 'C');
        $core->SetXY(70, 52);
        $core->Cell(140, 5, 'Name on Certificate', 0, 0, 'C');
        $core->SetXY(70, 56);
        $core->Cell(140, 5, '(Check if OK, update legibly if required)', 0, 0, 'C');
        $core->SetXY(210, 52);
        $core->Cell(60, 5, 'E-mail', 0, 0, 'C');
        $core->SetXY(210, 56);
        $core->Cell(60, 5, '(to receive a certificate)', 0, 0, 'C');
    }

    $core->SetFont('Calibri', '', 11);
    $rowCoordinate = 70 + ( ($loop % 10) * 13);

    if ($loop < sizeof($data_array)) {
        $data = $data_array[$loop];
        $core->SetXY(10, $rowCoordinate);
        $core->Cell(60, 5, ' ' . ($loop+1) . '. ' . $data['Enrollment']['name_on_certificate'], 'B', 0, 'L');

        $core->SetXY(70, $rowCoordinate);
        $core->Cell(140, 5, '', 'B', 0, 'C');

        $core->SetXY(210, $rowCoordinate);
        $core->Cell(60, 5, $data['Person']['work_email'], 'B', 0, 'L');

    } else {
        // complete the form with empty rows
        $core->SetXY(10, $rowCoordinate);
        $core->Cell(60, 5, ' ' . ($loop+1) . '. ', 'B', 0, 'L');

        $core->SetXY(70, $rowCoordinate);
        $core->Cell(140, 5, '', 'B', 0, 'C');

        $core->SetXY(210, $rowCoordinate);
        $core->Cell(60, 5, '', 'B', 0, 'L');

    }

    if($loop == 9 || $loop == 19) {
        $core->SetFont('Calibri', '', 8);
        $core->SetTextColor(0, 118, 263);
        $core->SetXY(10, 193);
        $core->Cell(59, 2, 'www.disciplinedagilecortium.org', 0, 0, 'L');
        $core->SetXY(70, 193);
        $core->Cell(139, 2, 'Calgary, Alberta, CANADA', 0, 0, 'C');
        $core->SetXY(210, 193);
        $core->Cell(60, 2, 'www.disciplinedagiledelivery.com', 0, 0, 'R');
    }
}

$core->Output('sign_in.pdf', 'I');
?>