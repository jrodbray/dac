<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-06
 * Time: 6:31 PM
 */

class PDFController extends AppController {
    var $name = 'PDF';
    var $helpers = array('fpdf'); // this will use the pdf.php class

    public function downloadpdf() {
        //Import /app/Vendor/Fpdf
        App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));
        //Assign layout to /app/View/Layout/downloadpdf.ctp
        $this->layout = 'downloadpdf'; //this will use the downloadpdf.ctp layout
        //Set fpdf variable to use in view
        $this->set('fpdf', new FPDF('P','mm','A4'));
        //pass data to view
        $this->set('data', 'Hello, PDF world');
        //render the pdf view (app/View/[view_name]/downloadpdf.ctp)
        $this->render('downloadpdf');
    }

    public function displaypdf() {
        //Import /app/Vendor/Fpdf
        App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));
        //Assign layout to /app/View/Layout/downloadpdf.ctp
        $this->layout = 'displaypdf'; //this will use the downloadpdf.ctp layout

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        $this->response->type("application/pdf");
        $pdf->Output();
    }

    function indexPdf() {
        $this->response->disableCache();
        $this->response->type("application/pdf");
        $this->layout = 'defaultpdf'; //this will use the defaultpdf.ctp layout
        $this->set('data_array', array(
                        array('Name' => 'John Smith',
                                 'Course1' => 'Disciplined Agile Delivery',
                                 'Course2' => 'Workshop Experience',
                                 'PDUs' => '21',
                                 'Date' => 'July 7-9, 2014'
                        ),
                array('Name' => 'John Doe',
                    'Course1' => 'Disciplined Agile Delivery',
                    'Course2' => 'Workshop Experience',
                    'PDUs' => '21',
                    'Date' => 'July 7-9, 2014'
                ),

            )
        );
        $this->render();
    }


}