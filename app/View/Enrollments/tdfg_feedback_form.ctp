<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-03-06
 * Time: 11:05 AM
 */
$this->extend('/Common/common_feedback');

$this->set('logo', $_SERVER['DOCUMENT_ROOT'].'/dac/app/webroot/img/td_logo.jpg' );
$this->set('x',180);
$this->set('y',12);
$this->set('w',0);
$this->set('h',15);

//$core->Image('http://scottambler.com/dac/app/webroot/img/td_logo.jpg', 180, 12, 0, 15);
?>