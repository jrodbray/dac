<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-14
 * Time: 11:27 AM
 */

class CourseOfferingsController extends AppController {
    public $helpers = array('FilterDisplay');
    public $uses=array('CourseOffering', 'Course', 'Instructor', 'Person', 'Entity');
    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 10,
        'joins' => array(
            array(
                'table' => 'people',
                'alias' => 'Person',
                'type' => 'LEFT',
                'foreignKey' => false,
                'conditions'=> array('Instructor.person_id = Person.id')
            ),
        ),
        'fields' => array('Person.*',
            'Course.*',
            'CourseOffering.*',
            'Entity.*'
        ),
        'order' => array(
            'CourseOffering.date' => 'desc',
            'Course.course_code' => 'asc',
            'CourseOffering.cancelled' => 'asc'
        )
    );

    public function index() {
        $this->response->disableCache();

        $active_filter = $this->Session->read('active_filter');
        if( !empty($active_filter) ){
            $this->paginate['conditions'] = $active_filter;
        }else{
            $this->paginate['conditions'] = null;
        }

        $this->Paginator->settings = $this->paginate;
        // similar to findAll(), but fetches paged results
        $course_offerings = $this->Paginator->paginate('CourseOffering');

        $this->set('course_offerings', $course_offerings);
    }

    public function filter(){
        $this->response->disableCache();

        $all_organizations = $this->Entity->find('all', array(
            'order' => array('Entity.name ASC'),
            'conditions' => array('dac_training' => 1)
        ) );
        $this->set('all_organizations', $all_organizations);

        $all_instructors = $this->Instructor->find('all', array('order' => array('Person.last_name', 'Person.first_name ASC') ) );
        $this->set('all_instructors', $all_instructors);
        $all_courses = $this->Course->find('all', array('order' => array('Course.course_code')));
        $this->set('all_courses', $all_courses);

        if($this->request->is('post')) {
            $active_filter = array();
            $filter_array = $this->request->data;
            while (list($key, $val) = each($filter_array)) {
                if($val) {
                    if ($key == 'date') {
                        $active_filter[$key . ' >= '] = $val;
                    } else {
                        $active_filter[$key] = $val;
                    }
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


    public function course_details() {
        $this->response->disableCache();
        $person_id = $this->request->params['pass'][0];
        $person = $this->Person->find('all', array(
                'conditions' => array(
                    'id' => $person_id
                    )
                )
            );
        $this->set('person', $person);
        $course_offerings = $this->CourseOffering->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'enrollments',
                        'alias' => 'Enrollment',
                        //'type' => 'LEFT',
                        'foreignKey' => false,
                        'conditions'=> array('Enrollment.course_offering_id = CourseOffering.id')
                    ),
                ),
                'fields' => array(
                    'Enrollment.*',
                    'Course.*',
                    'CourseOffering.*'
                ),
                'conditions' => array(
                    'Enrollment.person_id' => $person_id
                ),
                'order' => array('date' => 'asc'))
        );
        $this->set('course_offerings', $course_offerings);
    }



    public function add() {
        $this->response->disableCache();

        $all_entities = $this->Entity->find('all', array('order'=>'name ASC'));
        $this->set('all_entities', $all_entities);

        $all_instructors = $this->Instructor->find('all', array('order' => array('Person.last_name', 'Person.first_name ASC') ) );
        $this->set('all_instructors', $all_instructors);
        $all_courses = $this->Course->find('all', array('order' => array('Course.course_code')));
        $this->set('all_courses', $all_courses);

        //check if it is a post request
        //this way, we won't have to do if(!empty($this->request->data))
        if ($this->request->is('post')){
            //save new user
            if ($this->CourseOffering->saveAll($this->request->data)){

                //set flash to user screen
                $this->Session->setFlash('Course Offering was added.');
                //redirect to user list
                $this->redirect(array('action' => 'index'));

            }else{
                //if save failed
                $this->Session->setFlash('Unable to add Course Offering. Please, try again.');

            }
        }
    }

    public function edit() {
        $this->response->disableCache();

        $all_entities = $this->Entity->find('all', array('order'=>'name ASC'));
        $this->set('all_entities', $all_entities);

        $all_instructors = $this->Instructor->find('all', array('order' => array('Person.last_name', 'Person.first_name ASC') ) );
        $this->set('all_instructors', $all_instructors);

        $all_courses = $this->Course->find('all', array('order' => array('Course.course_code')));
        $this->set('all_courses', $all_courses);


        //get the id of the CourseOffering to be edited
        $id = $this->request->params['pass'][0];

        //set the CourseOffering id
        $this->CourseOffering->id = $id;

        //check if a CourseOffering with this id really exists
        if( $this->CourseOffering->exists() ){

            if( $this->request->is( 'post' ) || $this->request->is( 'put' ) ){
                //save CourseOffering
                if( $this->CourseOffering->save( $this->request->data ) ){

                    //set to CourseOffering's screen
                    $this->Session->setFlash('Course Offering was edited.');

                    //redirect to CourseOffering's list
                    $this->redirect(array('action' => 'index'));

                }else{
                    $this->Session->setFlash('Unable to edit Course Offering. Please, try again.');
                }

            }else{

                //we will read the CourseOffering data
                //so it will fill up our html form automatically
                $this->request->data = $this->CourseOffering->read();
            }

        }else{
            //if not found, we will tell the user that user does not exist
            $this->Session->setFlash('The user you are trying to edit does not exist.');
            $this->redirect(array('action' => 'index'));

            //or, since it we are using php5, we can throw an exception
            //it looks like this
            //throw new NotFoundException('The user you are trying to edit does not exist.');
        }
    }

    public function cancel() {
        $id = $this->request->params['pass'][0];

        //the request must be a post request
        //that's why we use postLink method on our view for deleting user
        if( $this->request->is('get') ){

            $this->Session->setFlash('Cancel method is not allowed.');
            $this->redirect(array('action' => 'index'));

            //since we are using php5, we can also throw an exception like:
            //throw new MethodNotAllowedException();
        }else{

            if( !$id ) {
                $this->Session->setFlash('Invalid id for Course Offering');
                $this->redirect(array('action'=>'index'));

            }else{
                //cancel CourseOffering
                $course_offering = $this->CourseOffering->read(null, $id);
                if(  $course_offering ){
                    $this->CourseOffering->set('cancelled', 1);
                    $this->CourseOffering->save();
                    //set to screen
                    $this->Session->setFlash('Course Offering was cancelled.');
                    //redirect to users's list
                    $this->redirect(array('action'=>'index'));

                }else{
                    //if unable to delete
                    $this->Session->setFlash('Unable to cancel Course Offering.');
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
    }
}

?>