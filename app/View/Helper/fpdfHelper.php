<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-07
 * Time: 11:00 AM
 */
App::uses('AppHelper', 'View/Helper');
App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));
//vendor('fpdf/fpdf');

if (!defined('PARAGRAPH_STRING')) define('PARAGRAPH_STRING', '~~~');

class fpdfHelper extends AppHelper {
    var $core;

    function fpdfHelper() {
        $this->core = new FPDF('L', 'mm', 'Letter');
    }
}
?>
