<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-06-06
 * Time: 10:42 AM
 */
App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));

$courseOffering = $this->Session->read('course_offering');
//echo print_r($courseOffering);

$numberOfDays = $courseOffering[0]['Course']['typical_length_in_days'];

$core = new FPDF('L', 'mm', 'Letter');

$core->AddFont('Calibri','','calibri.php');
$core->AddFont('Calibri','B','calibrib.php');
$core->AddFont('Calibri','I','calibrii.php');

function roundUpToAny($n,$x=5) {
    return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
}

$end_of_loop = max( array(20, roundUpToAny(sizeof($data_array), 10) ) );

for($loop=0; $loop<$end_of_loop; $loop++) {

    if ($loop == 0 || $loop == 10 || $loop == 20) {
        $core->AddPage();

        $core->SetFont('Arial', '', 16);
        $core->SetLineWidth(.2);
        $core->SetDrawColor(0, 118, 163);
        $core->Rect(10, 62, 260, 130, 'D');
        $core->Line(70, 62, 70, 192);
        $core->Line(140, 62, 140, 192);
        $core->Line(200, 62, 200, 192);

//  add sign-in columns
        $core->SetTextColor(0, 0, 0);
        $core->SetFont('Calibri', 'B', 10);
        $numberOfLines = $numberOfDays;
        $colWidth = (70 / $numberOfLines);
        $dayCounter = 0;
        for($lineX = 200; $lineX<270; ) {
            $dayCounter++;
            $core->SetXY($lineX, 52);
            $core->Cell($colWidth, 5, 'Sign',0,0,'C');
            if($numberOfLines != 1) {
                $core->SetXY($lineX, 56);
                $core->Cell($colWidth, 5, 'Day '.$dayCounter, 0, 0, 'C');
            }
            $lineX = $lineX + $colWidth;
            $core->Line($lineX, 62, $lineX, 192);
        }

        $core->Image($_SERVER['DOCUMENT_ROOT'].'/dac/app/webroot/img/Disciplined_Agile_Consortium_Logo_clear_no_shadow.png', 10, 10, 100);
        $this->fetch('content');
        $logo = $this->get('logo');
        if($logo) {
            $x = $this->get('x');
            $y = $this->get('y');
            $w = $this->get('w');
            $h = $this->get('h');
            $core->Image($logo, $x, $y, $w, $h);
        }

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
        $core->Cell(70, 5, 'Name on Certificate', 0, 0, 'C');
        $core->SetXY(70, 56);
        $core->Cell(70, 5, '(Check if OK, update legibly if required)', 0, 0, 'C');
        $core->SetXY(140, 52);
        $core->Cell(60, 5, 'E-mail', 0, 0, 'C');
        $core->SetXY(140, 56);
        $core->Cell(60, 5, '(to receive a certificate)', 0, 0, 'C');
    }

    $core->SetFont('Calibri', '', 11);
    $rowCoordinate = 70 + ( ($loop % 10) * 13);

    if ($loop < sizeof($data_array)) {
        $data = $data_array[$loop];
        $core->SetXY(10, $rowCoordinate);
        $core->Cell(60, 5, ' ' . ($loop+1) . '. ' . $data['Enrollment']['name_on_certificate'], 'B', 0, 'L');

        $core->SetXY(70, $rowCoordinate);
        $core->Cell(70, 5, '', 'B', 0, 'C');

        $core->SetXY(140, $rowCoordinate);
        $core->Cell(60, 5, $data['Person']['work_email'], 'B', 0, 'L');

        $core->SetXY(200, $rowCoordinate);
        $core->Cell(70, 5, '', 'B', 0, 'L');

    } else {
        // complete the form with empty rows
        $core->SetXY(10, $rowCoordinate);
        $core->Cell(60, 5, ' ' . ($loop+1) . '. ', 'B', 0, 'L');

        $core->SetXY(70, $rowCoordinate);
        $core->Cell(70, 5, '', 'B', 0, 'C');

        $core->SetXY(140, $rowCoordinate);
        $core->Cell(60, 5, '', 'B', 0, 'L');

        $core->SetXY(200, $rowCoordinate);
        $core->Cell(70, 5, '', 'B', 0, 'L');

    }

    if($loop == 9 || $loop == 19 || $loop == 29) {
        $core->SetFont('Calibri', '', 8);
        $core->SetTextColor(0, 118, 263);
        $core->SetXY(10, 193);
        $core->Cell(59, 2, 'DisciplinedAgileConsortium.org', 0, 0, 'L');
        $core->SetXY(70, 193);
        $core->Cell(139, 2, 'Calgary, Alberta, CANADA', 0, 0, 'C');
        $core->SetXY(190, 193);
        $core->Cell(80, 2, 'DisciplinedAgileDelivery.com', 0, 0, 'R');
    }
}

$core->Output('sign_in.pdf', 'I');
?>