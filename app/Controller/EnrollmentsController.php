<?php

/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-10
 * Time: 5:10 PM
 */
class EnrollmentsController extends AppController {
    public $helpers = array('FilterDisplay');
    public $uses = array('Enrollment', 'Course', 'CourseOffering', 'Person', 'Instructor', 'Entity');
    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 5,
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
    public function detail() {
        $conditions = array('conditions' => array('person_id' => 1));
        $enrollment = $this->Enrollment->find('first', $conditions);
        $this->set('enrollment', $enrollment);
        if ($enrollment) {
            $course_id = $enrollment['CourseOffering']['course_id'];
            $course = $this->Course->find('first', array('conditions' => array('id' => $course_id)));

            $this->set('course', $course);
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

        $this->Paginator->settings = $this->paginate;
        // similar to findAll(), but fetches paged results
        $course_offerings = $this->Paginator->paginate('CourseOffering');

        $this->set('course_offerings', $course_offerings);
    }

    public function filter(){
        $this->response->disableCache();
        $this->prepare_filter();

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

    private function prepare_filter() {
        $all_organizations = $this->Entity->find('all', array(
            'order' => array('Entity.name ASC'),
            'conditions' => array('dac_training' => 1)
        ) );
        $this->set('all_organizations', $all_organizations);

        $all_instructors = $this->Instructor->find('all', array('order' => array('Person.last_name', 'Person.first_name ASC') ) );
        $this->set('all_instructors', $all_instructors);
        $all_courses = $this->Course->find('all', array('order' => array('Course.course_code')));
        $this->set('all_courses', $all_courses);
    }

    public function filter_report() {
        $this->response->disableCache();
        $this->prepare_filter();

        if($this->request->is('post')) {
            $active_filter = '';
            $filter_array = $this->request->data;
            while (list($key, $val) = each($filter_array)) {
                if($val) {
                    if ($key == 'date') {
                        $active_filter = $active_filter." AND ".$key." >= '".$val."'";
                    } else {
                        $active_filter = $active_filter." AND ".$key." = '".$val."'";
                    }
                }
            }

            $this->Session->write('active_report_filter', $active_filter);
            $this->redirect(array('action' => 'enrollments_report'));
        }else{
            // take no action, just present the form to gather the filter data
        }

    }


    public function enrollments_report() {
        $this->response->disableCache();

        $query_string = "SELECT CourseOffering.*, Course.*, I.*, EE.*, InstructingOrg.* FROM course_offerings AS CourseOffering ".
            "LEFT JOIN courses AS Course ON (CourseOffering.course_id = Course.id) ".
            "JOIN expanded_instructors as I ON (CourseOffering.instructor_id = I.id)".
            "JOIN expanded_enrollments as EE ON (CourseOffering.id = EE.course_offering_id) ".
            "JOIN entities as InstructingOrg ON (CourseOffering.entity_id = InstructingOrg.id) ".
            "WHERE (CourseOffering.cancelled <> 1 OR CourseOffering.cancelled IS NULL) ";
        $active_filter = $this->Session->read('active_report_filter');
        $query_string = $query_string.$active_filter." ORDER BY CourseOffering.date DESC, Course.course_code ASC, I.id ASC ";
        $enrollments = $this->CourseOffering->query($query_string);

        $this->set('enrollments', $enrollments);
        $this->set('query_string', $query_string);
    }

    public function class_list(){
        $this->response->disableCache();
        $this->find_and_set_course_offerings();
        //grab all Person instances and pass it to the view:
        $courseOffering = $this->Session->read('course_offering');
        $people = $this->Person->find('all', array(
        			'order' => array(
                        'last_name' => 'asc',
                        'first_name' => 'asc'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'enrollments',
                            'alias' => 'Enrollment',
                            //'type' => 'left',
                            'foreignKey' => false,
                            'conditions'=> array('Person.id = Enrollment.person_id')
                        )
                    ),
                    'fields' => array('Person.*', 'Enrollment.*'),
                    'conditions' => array(
                        'Enrollment.course_offering_id' => $courseOffering[0]['CourseOffering']['id']
                    )
                )
        	);
        $this->set('people', $people);
    }

    public function  print_certificates(){
        $this->response->disableCache();
        $this->find_and_set_course_offerings();
        //grab all Person instances and pass it to the view:
        $courseOffering = $this->Session->read('course_offering');
        $people = $this->Person->find('all', array(
                'order' => array(
                    'last_name' => 'asc',
                    'first_name' => 'asc'
                ),
                'joins' => array(
                    array(
                        'table' => 'enrollments',
                        'alias' => 'Enrollment',
                        //'type' => 'left',
                        'foreignKey' => false,
                        'conditions'=> array('Person.id = Enrollment.person_id')
                    )
                ),
                'fields' => array('Person.*', 'Enrollment.*'),
                'conditions' => array(
                    'Enrollment.course_offering_id' => $courseOffering[0]['CourseOffering']['id']
                )
            )
        );

        $this->response->type("application/pdf");
        $this->layout = 'defaultpdf'; //this will use the defaultpdf.ctp layout
        $data_array = array();
        $data_array_index = 0;
        foreach ($people as $person):
            $inner_array = array();
            $inner_array['Name'] = $person['Enrollment']['name_on_certificate'];
            $inner_array['Course1'] = $courseOffering[0]['Course']['description'];
            $inner_array['Course2'] = '';
            $inner_array['PDUs'] = $courseOffering[0]['Course']['PDUs'];

            $inner_array['Date'] = $this->format_certificate_date($courseOffering);

            $data_array[$data_array_index] = $inner_array;
            $data_array_index++;
        endforeach;
        $this->set('data_array', $data_array);
        $this->render(strtolower($courseOffering[0]['Entity']['code']).'_certificates');

    }

    public function enroll(){
        $this->find_and_set_course_offerings();
        $this->redirect(array('controller' => 'People', 'action' => 'add_with_enrollment'));
    }

    public function enroll_existing() {
        $this->find_and_set_course_offerings();
        $this->redirect(array('controller' => 'People', 'action' => 'search_with_enrollment'));
    }

    public function edit_enrollments(){
        $this->response->disableCache();
        $this->find_and_set_course_offerings();
        //grab all Person instances and pass it to the view:
        $courseOffering = $this->Session->read('course_offering');
        $people = $this->Person->find('all', array(
                'order' => array(
                    'last_name' => 'asc',
                    'first_name' => 'asc'
                ),
                'joins' => array(
                    array(
                        'table' => 'enrollments',
                        'alias' => 'Enrollment',
                        //'type' => 'left',
                        'foreignKey' => false,
                        'conditions'=> array('Person.id = Enrollment.person_id')
                    )
                ),
                'fields' => array('Person.*', 'Enrollment.*'),
                'conditions' => array(
                    'Enrollment.course_offering_id' => $courseOffering[0]['CourseOffering']['id']
                )
            )
        );
        $this->set('people', $people);
    }

    public function edit_enrollment() {
        $this->response->disableCache();
        //get the id of the Enrollment to be edited
        $id = $this->request->params['pass'][0];
        //we will read the Enrollment data
        //so it will fill up our html form automatically
        $this->Enrollment->id = $id;
        $enrollment =  $this->Enrollment->read();

        if($this->request->is('post') || $this->request->is('put')){
            //save Enrollment
            if( $this->Enrollment->save( $this->request->data, true, array('name_on_certificate') ) ){

                //set to Person's screen
                $this->Session->setFlash('Enrollment was edited.');

                //redirect to Edit Enrollments list
                $this->redirect(array('action' => 'edit_enrollments', $enrollment['CourseOffering']['id']));

            }else{
                $this->Session->setFlash('Unable to edit Enrollment. Please, try again.');
            }
        }else{
            $this->set('enrollment', $enrollment);
            $this->request->data = $enrollment;
        }
    }

    public function remove_enrollment() {
        $id = $this->request->params['pass'][0];
        $courseOffering = $this->Session->read('course_offering');

        //the request must be a post request
        //that's why we use postLink method on our view for deleting user
        if( $this->request->is('get') ){

            $this->Session->setFlash('Remove method is not allowed.');
            $this->redirect(array('action' => 'edit_enrollments', $courseOffering[0]['CourseOffering']['id']));

            //since we are using php5, we can also throw an exception like:
            //throw new MethodNotAllowedException();
        }else{

            if( !$id ) {
                $this->Session->setFlash('Invalid id for Enrollment');
                $this->redirect(array('action'=>'edit_enrollments', $courseOffering[0]['CourseOffering']['id']));

            }else{
                //remove Enrollment
                if(  $this->Enrollment->delete($id, false) ){
                    //set to screen
                    $this->Session->setFlash('Student enrollment was removed.');
                    //redirect to edit class list
                    $this->redirect(array('action'=>'edit_enrollments', $courseOffering[0]['CourseOffering']['id']));

                }else{
                    //if unable to delete
                    $this->Session->setFlash('Unable to remove student enrollment.');
                    $this->redirect(array('action' => 'edit_enrollments', $courseOffering[0]['CourseOffering']['id']));
                }
            }
        }
    }

    private function find_and_set_course_offerings(){
        $id = $this->request->params['pass'][0];
        $courseOffering = $this->CourseOffering->find('all', array(
            'conditions' => array(
                'CourseOffering.id' => $id
            )
        ));
        $this->Session->write('course_offering', $courseOffering);
    }

    /**
     * @param $courseOffering
     * @param $inner_array
     * @return mixed
     */
    private function format_certificate_date($courseOffering) {
        $t1 = strtotime($courseOffering[0]['CourseOffering']['date']);
        $t2 = strtotime($courseOffering[0]['CourseOffering']['end_date']);
        $formatted_date_string = '';
        // simple format for a single day course
        if($t1 == $t2){
            $formatted_date_string = date('j F Y', $t1);
        }else {
            // get date and time information from timestamps
            $d1 = getdate($t1);
            $d2 = getdate($t2);
            // three possible formats for the first date
            $long = "j F Y";
            $medium = "j F";
            $short = "j";
            // decide which format to use
            if ($d1["year"] != $d2["year"]) {
                $first_format = $long;
            } elseif ($d1["mon"] != $d2["mon"]) {
                $first_format = $medium;
            } else {
                $first_format = $short;
            }
            $formatted_date_string = date($first_format, $t1).'-'.date($long, $t2);
        }
        return $formatted_date_string;
    }


}

?>