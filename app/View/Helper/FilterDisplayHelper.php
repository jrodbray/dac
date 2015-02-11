<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-04
 * Time: 11:50 AM
 */

App::uses('AppHelper', 'View/Helper');

class FilterDisplayHelper extends AppHelper {
    public function display($filter_array) {
        $display_string = "Filter applied: ";
        while (list($key, $val) = each($filter_array)) {
            $display_string = $display_string . $key . " " . $val . "&nbsp;&nbsp;&nbsp;";
        }
        return $display_string;
    }
}