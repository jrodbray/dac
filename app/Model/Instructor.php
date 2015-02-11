<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-16
 * Time: 12:16 PM
 */
App::uses('AppModel', 'Model');
class Instructor extends AppModel {
    public $belongsTo = array(
        'Person'
    );
    public $hasMany = array(
        'CourseOffering'
    );

    public $validate = array(
        'person_id' => array(
            'rule' => 'numeric',
            'message' => 'Please supply the Instructor.'
        )
    );
}