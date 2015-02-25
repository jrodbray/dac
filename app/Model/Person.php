<?php
App::uses('AppModel', 'Model');
class Person extends AppModel {
    public $hasMany = array(
        'Enrollment'
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
        'work_email' => array(
            'rule1' => array(
                'rule' => 'email',
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
                'fields' => array('work_email')
            ));
            return $work_emails;
        }
        return false;
    }
}
?>