<?php

class PeopleController extends AppController {
    public $uses = array('Person', 'Enrollment', 'Course', 'CourseOffering');

    public $components = array('Paginator', 'RequestHandler');

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Person.last_name' => 'asc',
            'Person.first_name' => 'asc'
        )
    );

    public function getWorkEmail() {
        $this->response->disableCache();
        if ($this->request->is('ajax')) {
            $term = $this->request->query('term');
            $workEmails = $this->Person->getWorkEmail($term);
            $this->set(compact('workEmails'));
            $this->set('_serialize', 'workEmails');
        }
    }

    public function fillForm() {

        $email = $this->request->query['workEmail']; //data['Person']['work_email'];

        if( $this->request->is( 'post' ) || $this->request->is( 'put' ) ){
            //save Person
            $course_offering = $this->Session->read('course_offering');
            $person = $this->Person->save( $this->request->data );
            if(!empty($person)){
                // The ID of the newly created Person has been set
                // as $this->Person->id. OR the existing Person id is available
                $this->request->data['Enrollment']['person_id'] = $this->Person->id;
                // build Enrollment data for saving
                $enrollment_data = array('person_id' => $this->Person->id,
                    'course_offering_id' => $course_offering[0]['CourseOffering']['id'],
                    'enrollment_date' => $this->request->data['Person']['enrollment_date'],
                    'name_on_certificate' => $this->request->data['Person']['name_on_certificate']
                );

                $enrollment = $this->Enrollment->save($enrollment_data);

                if(!empty($enrollment)) {
                    //set flash to People screen
                    $course_code = $course_offering[0]['Course']['course_code'];
                    $course_start = $course_offering[0]['CourseOffering']['date'];
                    $this->Session->setFlash('Person was enrolled in course - ' . $course_code . ' / ' . $course_start);
                    unset($this->request->data['Person']);
                }else {
                    // if Enrollment save failed
                    $this->Session->setFlash("Person added but not enrolled.");
                }
            }else{
                //if save failed
                $this->Session->setFlash('Unable to save Person. Please, try again.');
            }
            //redirect to Enrollments list
            $this->redirect(array('controller' => 'Enrollments', 'action' => 'index'));
        }else{
            //we will read the Person data
            //so it will fill up our html form automatically
            $person = $this->Person->findByWorkEmail($email);
            $this->request->data = $person;
            // a little magic here to set the Name on Certificate to a default
            // but only if the Person has been found
            if($person) {
                $this->request->data['Person']['name_on_certificate'] =
                    $this->request->data['Person']['first_name'] . ' ' .
                    $this->request->data['Person']['last_name'];
            }
            // replace the entered email (just in case they had rekeyed it
            $this->request->data['Person']['work_email'] = $email;
        }
    }



    public function index() {
        $this->response->disableCache();
        $active_filter = $this->Session->read('active_filter');
        if( !empty($active_filter) ){
            $this->paginate['conditions'] = $active_filter;
        }else{
            $this->paginate['conditions'] = null;
        }

        //grab all Person instances and pass it to the view:
        //$people = $this->Person->find('all', array(
		//			'order' => array('last_name' => 'desc'))
		//	);
        $this->Paginator->settings = $this->paginate;
        // similar to findAll(), but fetches paged results
        $people = $this->Paginator->paginate('Person');

        $this->set('people', $people);
        $this->Session->write('active_filter', $active_filter);
    }

    public function filter(){
        if($this->request->is('post')) {
            $active_filter = array();
            $filter_array = $this->request->data;
            while (list($key, $val) = each($filter_array)) {
                if($val){
                    $active_filter[$key." LIKE "] = $val."%";
                }
            }

            $this->Session->write('active_filter', $active_filter);
            $this->redirect(array('action' => 'index'));
        }else{
            // take no action, just present the form to gather the filter data
        }
    }

    public function clear_filter(){
        $active_filter = array();
        $this->Session->write('active_filter', $active_filter);
        $this->redirect(array('action' => 'index'));
    }

    public function add_with_enrollment() {
        //check if it is a post request
        //this way, we won't have to do if(!empty($this->request->data))
        if ($this->request->is('post')){
            //save new Person & Enrollment
            $course_offering = $this->Session->read('course_offering');

            $person = $this->Person->save($this->request->data);
            if(!empty($person)){

                // The ID of the newly created Person has been set
                // as $this->Person->id.
                $this->request->data['Enrollment']['person_id'] = $this->Person->id;


                $enrollment_data = array('person_id' => $this->Person->id,
                                        'course_offering_id' => $course_offering[0]['CourseOffering']['id'],
                                        'enrollment_date' => $this->request->data['Person']['enrollment_date'],
                                        'name_on_certificate' => $this->request->data['Person']['name_on_certificate']
                    );

                $enrollment = $this->Enrollment->save($enrollment_data);

                if(!empty($enrollment)) {
                    //set flash to People screen
                    $course_code = $course_offering[0]['Course']['course_code'];
                    $course_start = $course_offering[0]['CourseOffering']['date'];
                    $this->Session->setFlash('Person was enrolled in course - ' . $course_code . ' / ' . $course_start);
                    unset($this->request->data['Person']);
                }else {
                    // if Enrollment save failed
                    $this->Session->setFlash("Person added but not enrolled.  Please try enrolling the Person through Enrollment Function");
                }
            }else{
                //if save failed
                $this->Session->setFlash('Unable to add Person. Please, try again.');

            }
        }

    }

    public function search_with_enrollment() {
        if ($this->request->is('post')) {
            $last_name = $this->request->data['Person']['last_name'];
            //$work_email = $this->request->data['Person']['work_email'];
            //$personal_email = $this->request->data['Person']['personal_email'];
            $conditions_array = array();

            if ($last_name) {
                $conditions_array['Person.last_name like'] = $last_name.'%';
            }
            //if ($work_email) {
            //    $conditions_array['Person.work_email'] = $work_email;
            //}
            //if ($personal_email) {
            //    $conditions_array['Person.personal_email'] = $personal_email;
            //}
            $people = $this->Person->find('all', array(
                'conditions' => $conditions_array
            ));
            $this->Session->write('people', $people);

            $this->redirect(array('action' => 'enroll_from_search_results'));
        }
    }

    public function enroll_from_search_results() {
        if ($this->request->is('post')) {
            $enrollment_date = $this->request->data['Date']['enrollment_date'];
            $course_offering = $this->Session->read('course_offering');

            $enrollment_people = $this->request->data['Enrollment'];
            $people_count = count($enrollment_people);

            $i = 0;
            $duplicate = false;
            $success = true;
            while ($i < $people_count) {
                $name_on_certificate = $this->request->data['Person'][$i]['name_on_certificate'];
                if($name_on_certificate) {

                    $enrollment_data = array('person_id' => $enrollment_people[$i]['person_id'],
                        'course_offering_id' => $course_offering[0]['CourseOffering']['id'],
                        'enrollment_date' => $enrollment_date,
                        'name_on_certificate' => $name_on_certificate
                    );
                    if($this->is_ok_to_enroll($enrollment_data)) {
                        // call clear() to ensure looping save works
                        $this->Enrollment->clear();
                        $enrollment = $this->Enrollment->save($enrollment_data);
                        if (empty($enrollment)) {
                            // check for any failures
                            $success = false;
                        }
                    }else{
                        // problem, likely duplicate
                        $success = false;
                        $duplicate = true;
                    }
                }
                $i++;
            }
            if($success){
                $this->Session->setFlash('Person(s) enrolled in course');
                // redirect to Enroll existing students
                $this->redirect(array('action' => 'search_with_enrollment'));
            }else{
                $this->Session->setFlash("Enrollment failed, please try again.");
                if($duplicate){
                    $this->Session->setFlash("Duplicate Enrollment failed.");
                }
            }
        }
    }

    protected function is_ok_to_enroll($enrollment_data){
        $existing = $this->Enrollment->find('all', array(
                            'conditions' => array(
                                'person_id' => $enrollment_data['person_id'],
                                'course_offering_id' => $enrollment_data['course_offering_id']
                            )
                        )
        );
        return !$existing;
    }

    public function add() {
        //check if it is a post request
        //this way, we won't have to do if(!empty($this->request->data))
        if ($this->request->is('post')){
            //save new user
            if ($this->Person->saveAll($this->request->data)){
                //set flash to Person screen
                $this->Session->setFlash('Person was added.');
                //redirect to user list
                $this->redirect(array('action' => 'index'));

            }else{
                //if save failed
                $this->Session->setFlash('Unable to add Person. Please, try again.');

            }
        }

    }

    public function detail() {
        $conditions = array('conditions' => array('Person.id' => 1));
        //$this->Channel->recursive = -1;
        $options=array(
            'joins' =>
                array(
                    array(
                        'table' => 'enrollments',
                        'alias' => 'Enrollment',
                        'type' => 'left',
                        'foreignKey' => false,
                        'conditions'=> array('Person.id = Enrollment.person_id')
                    ),
                    array(
                        'table' => 'courses',
                        'alias' => 'Course',
                        'type' => 'left',
                        'foreignKey' => false,
                        'conditions'=> array('Course.id = Enrollment.course_id')
                    )
                ),
            'conditions' => array('Person.id' => 1)
        );

        $person = $this->Person->find('first', $options );

        $this->set('person', $person);
        $enrollment = $person['Enrollment'];
        $this->set('enrollment', $enrollment);
        //$course =$enrollment['Course'];
        //$this->set('course',$course);
    }

    public function delete() {
        $id = $this->request->params['pass'][0];

        //the request must be a post request
        //that's why we use postLink method on our view for deleting user
        if( $this->request->is('get') ){

            $this->Session->setFlash('Delete method is not allowed.');
            $this->redirect(array('action' => 'index'));

            //since we are using php5, we can also throw an exception like:
            //throw new MethodNotAllowedException();
        }else{

            if( !$id ) {
                $this->Session->setFlash('Invalid id for Person');
                $this->redirect(array('action'=>'index'));

            }else{
                //delete Person
                if( $this->Person->delete( $id ) ){
                    //set to screen
                    $this->Session->setFlash('Person was deleted.');
                    //redirect to People list
                    $this->redirect(array('action'=>'index'));

                }else{
                    //if unable to delete
                    $this->Session->setFlash('Unable to delete Person.');
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
    }

    public function edit() {
        //get the id of the Person to be edited
        $id = $this->request->params['pass'][0];

        //set the user id
        $this->Person->id = $id;

        //check if a Person with this id really exists
        if( $this->Person->exists() ){

            if( $this->request->is( 'post' ) || $this->request->is( 'put' ) ){
                //save Person
                if( $this->Person->save( $this->request->data ) ){

                    //set to Person's screen
                    $this->Session->setFlash('Person was edited.');

                    //redirect to Person's list
                    $this->redirect(array('action' => 'index'));

                }else{
                    $this->Session->setFlash('Unable to edit Person. Please, try again.');
                }

            }else{

                //we will read the Person data
                //so it will fill up our html form automatically
                $this->request->data = $this->Person->read();
            }

        }else{
            //if not found, we will tell the user that Person does not exist
            $this->Session->setFlash('The Person you are trying to edit does not exist.');
            $this->redirect(array('action' => 'index'));

            //or, since it we are using php5, we can throw an exception
            //it looks like this
            //throw new NotFoundException('The Person you are trying to edit does not exist.');
        }


    }
}
?>