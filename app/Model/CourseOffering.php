<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-13
 * Time: 3:12 PM
 */
App::uses('AppModel', 'Model');
class CourseOffering extends AppModel{
    public $hasMany = array(
        'Enrollment' => array(
            'className'=>'Enrollment',
            'foreignKey'=>'course_offering_id',
            'dependent'=>true,
            'exclusive'=>true
        )
    );
    public $belongsTo = array(
        'Course', 'Instructor', 'Entity'
    );
    //public  $hasOne = array(
    //    'Entity'
    //);

    public $validate = array(
        'location' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Location is required.'
        ),
        'date' => array(
            'rule' => array('date', 'ymd'),
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Enter a valid date in YYYY-MM-DD format.'
        ),
        'end_date' => array(
            'rule' => array('date', 'ymd'),
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Enter a valid date in YYYY-MM-DD format.'
        ),
        'entity_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Instructional Organization is required.'
        ),
        'instructor_id' => array(
            'rule' => 'numeric',
            'message' => 'Please supply the Instructor.'
        ),
        'course_id' => array(
            'rule' => 'numeric',
            'message' => 'Please supply the Course.'
        )

    );


}