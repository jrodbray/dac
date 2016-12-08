<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-03-04
 * Time: 2:25 PM
 */
$this->extend('/Common/common_sign_in');

//$this->set('logo', 'http://scottambler.com/dac/app/webroot/img/Scott_Ambler+Associates_Logo_Large.jpg' );
$this->set('logo', $_SERVER['DOCUMENT_ROOT'].'/dac/app/webroot/img/Scott_Ambler+Associates_Logo-Vector-2016_800X249.jpg' );
$this->set('x',200);
$this->set('y',12);
$this->set('w',0);
$this->set('h',15);

//$core->Image('http://scottambler.com/dac/app/webroot/img/Scott_Ambler+Associates_Logo_Large.jpg', 200, 12, 0, 15);

?>