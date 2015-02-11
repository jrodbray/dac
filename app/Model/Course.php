<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-10
 * Time: 3:30 PM
 */
App::uses('AppModel', 'Model');
class Course extends AppModel{
    public $hasMany = array(
        'CourseOffering'
    );
}
?>