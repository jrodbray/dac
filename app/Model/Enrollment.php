<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-10
 * Time: 3:32 PM
 */
App::uses('AppModel', 'Model');
class Enrollment extends AppModel{
    public $belongsTo = array(
        'Person', 'CourseOffering'
    );


}
?>