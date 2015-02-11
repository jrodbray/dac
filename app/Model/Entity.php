<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-09
 * Time: 6:31 PM
 */
App::uses('AppModel', 'Model');
class Entity extends AppModel {

    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Name is required.'
        ),
        'code' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Code is required.'
        ),
        'phone' => array(
            'rule' => array('phone', null, 'us'),
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Please supply a valid phone number.'
        )
    );

}