<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-06
 * Time: 6:33 PM
 */
?>
<?php
$fpdf->AddPage();
$fpdf->SetFont('Arial','B',16);
$fpdf->Cell(40,10,$data);
$fpdf->Output('test.pdf', 'I');
?>