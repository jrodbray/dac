<?php
App::uses('AppModel', 'Model');
class Person extends AppModel {
    public $hasMany = array(
        'Enrollment' => array(
            'className'=>'Enrollment',
            'foreignKey'=>'person_id',
            'dependent'=>true,
            'exclusive'=>true
        )
    );

    public $validate = array(
        'first_name' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Names must only contain letters and numbers.'
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Names must only contain letters and numbers.'
        ),
        'work_email' =>
            array(
            'rule1' => array(
                'rule' => 'notEmpty',
                // attempted use of following Regex abandoned 2015/02/26
                //^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Please supply a valid email address.'
            ),
            'rule2' => array(
                'rule' => 'isUnique',
                'message' => 'Duplicate email address, may indicate duplicate Person.  Please check details.'
            )
        ),
        'work_phone' => array(
            'rule' => array('phone', null, 'us'),
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Please supply a valid phone number.'
        ),
        'home_phone' => array(
            'rule' => array('phone', null, 'us'),
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Please supply a valid phone number.'
        ),
        'mobile_phone' => array(
            'rule' => array('phone', null, 'us'),
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Please supply a valid phone number.'
        )
    );

    public function getWorkEmail ($term = null) {
        if(!empty($term)) {
            $work_emails = $this->find('list', array(
                'conditions' => array(
                    'work_email LIKE' => trim($term) . '%'),
                'order' => array('work_email' => 'asc'),
                'fields' => array('work_email')
            ));
            return $work_emails;
        }
        return false;
    }
}
?>