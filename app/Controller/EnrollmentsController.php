<?php

/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-10
 * Time: 5:10 PM
 */
App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));
App::uses('CakeEmail', 'Network/Email');

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
        $data_array = $this->build_certificate_data_array($courseOffering);
        $this->response->type("application/pdf");
        $this->layout = 'defaultpdf'; //this will use the defaultpdf.ctp layout
        $this->set('data_array', $data_array);
        $this->render(strtolower($courseOffering[0]['Entity']['code']).'_certificates');
    }


    private function build_certificate_data_array($courseOffering){
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
        $data_array = array();
        $data_array_index = 0;
        foreach ($people as $person):
            $inner_array = array();
            $inner_array['Name'] = $person['Enrollment']['name_on_certificate'];
            $description = explode(';', $courseOffering[0]['Course']['description']);
            $inner_array['Course1'] = $description[0];
            if(count($description) > 1){
                $inner_array['Course2'] = $description[1];
            }else{
                $inner_array['Course2'] = '';
            }
            $inner_array['PDUs'] = $courseOffering[0]['Course']['PDUs'];
            $inner_array['Date'] = $this->format_certificate_date($courseOffering);
            $inner_array['email'] = $person['Person']['work_email'];
            $data_array[$data_array_index] = $inner_array;
            $data_array_index++;
        endforeach;
        return $data_array;
    }


    public function download_certificates(){
        $this->response->disableCache();
        $this->find_and_set_course_offerings();
        $courseOffering = $this->Session->read('course_offering');

        $file = tempnam(sys_get_temp_dir(), 'cert'); //sys_get_temp_dir().DIRECTORY_SEPARATOR.'cert.zip';
        $zip = new ZipArchive();
        if($zip->open($file, ZipArchive::CREATE) == true) {
            $certificate_format = $courseOffering[0]['Entity']['code'];
            $data_array = $this->build_certificate_data_array($courseOffering);
            foreach ($data_array as $data):
                $contents = $this->build_certificate($certificate_format, $data);
                $file_name = $data['Name'].'_certificate.pdf';
                $zip->addFromString($file_name, $contents);
            endforeach;
        }
        $zip->close();
        $this->response->file($file);
        $this->response->header('Content-Disposition: attachment; filename="cert.zip"');
        return $this->response;
    }

    public function build_certificate($certificate_format, $data){
        switch ($certificate_format) {
            case 'TDFG':
                $contents = $this->produce_TDFG_certificate($data);
                break;
            case 'SA+A':
                $contents = $this->produce_SAA_certificate($data);
                break;
            case 'Indigo':
                $contents = $this->produce_Indigo_certificate($data);
                break;
            default:
                $contents = $this->produce_DAC_certificate($data);
        }
        return $contents;
    }


    public function email_certificates(){
        // this can take a while so ...
        $curr_max_time = ini_get('max_execution_time');
        ini_set('max_execution_time', '300');

        $this->find_and_set_course_offerings();
        $courseOffering = $this->Session->read('course_offering');
        $certificate_format = $courseOffering[0]['Entity']['code'];
        $data_array = $this->build_certificate_data_array($courseOffering);
        $count = 0;
        foreach ($data_array as $data):
            $contents = $this->build_certificate($certificate_format, $data);
            $Email = new CakeEmail('smtp');
            $Email->template('certificate', 'formal')->emailFormat('html');
            //$Email->to('rodbray@yahoo.com');    // dev
            $Email->to('louise@scottambler.com');    // prod testing
            $Email->subject('Your Certificate of Achievement');

            $Email->attachments(array(
                'certificate.pdf' => array(
                    'data' => $contents
                )
            ));

            $Email->send();
            $count++;
        endforeach;
        // restore max execution time
        ini_set('max_execution_time', $curr_max_time);
        //$this->Session->setFlash($count.' Certificates emailed.');
        //$this->redirect(array('controller' => 'Enrollments', 'action' => 'index'));
        $this->set('course_offering', $courseOffering);
        $this->set('data_array', $data_array);
    }

    private function produce_TDFG_certificate($data){
        $core = new FPDF('L', 'mm', 'Letter');
        $core = $this->produce_common_certificate_parts($core, $data);

        // logos
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/DAC.jpg', 162,140,0,15);
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/td_logo.jpg', 225,165,0,15);

        $core = $this->produce_third_part_signatures($core, $data);

        $contents = $core->Output('','S');
        return $contents;
    }


    private function produce_SAA_certificate($data){
        $core = new FPDF('L', 'mm', 'Letter');
        $core = $this->produce_common_certificate_parts($core, $data);

        // logos
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/DAC.jpg', 162,140,0,15);
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/SAA_logo.jpg', 184,165,0,15);

        $core = $this->produce_third_part_signatures($core, $data);

        $contents = $core->Output('','S');
        return $contents;
    }


    private function produce_Indigo_certificate($data){
        $core = new FPDF('L', 'mm', 'Letter');
        $core = $this->produce_common_certificate_parts($core, $data);

        // logos
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/DAC.jpg', 162,140,0,15);
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/IndigoCube_Logo.jpg', 214,165,0,18);

        $core = $this->produce_third_part_signatures($core, $data);

        $contents = $core->Output('','S');
        return $contents;
    }


    private function produce_third_part_signatures($core, $data){
        // Ambler signature
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/AmblerSignature.jpg', 30,138,40);
        $core->SetLineWidth(.2);
        $core->Line(30,150,70,150);
        $core->SetFont('Calibri', '', 11);
        $core->SetXY(30,152);
        $core->Cell(40, 5, 'Scott Ambler');

        // Lines signature
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/LinesSignature.jpg', 30,170,40);
        $core->SetLineWidth(.2);
        $core->Line(30,182,70,182);
        $core->SetFont('Calibri', '', 11);
        $core->SetXY(30,184);
        $core->Cell(40, 5, 'Mark Lines');

        // date
        $core->SetFont('Calibri', '', 12);
        $core->SetXY(120,176);
        $core->Cell(40, 5, $data['Date'], 0, 0, 'C');
        $core->Line(120,182,160,182);

        return $core;

    }


    private function produce_common_certificate_parts($core, $data) {
        $core->AddPage();
        $core->AddFont('Calibri','','calibri.php');
        $core->AddFont('Calibri','B','calibrib.php');
        $core->AddFont('Calibri','I','calibrii.php');

        $core->SetFont('Arial','',16);
        $core->SetLineWidth(1);
        $core->SetDrawColor(0, 118, 163);
        $core->Rect(10,10,259,197, 'D');
        $core->SetLineWidth(.2);
        $core->Rect(11,11,257,195, 'D');

        $core->SetDrawColor(0);

        $core->SetFont('Calibri','',30);
        $core->SetXY(80, 20);
        $core->Cell(120, 20, 'Certificate of Achievement', 0, 0,'C');

        $core->SetTextColor(0,118,163);
        $core->SetFont('Calibri','B',36);
        $core->SetXY(80, 50);
        $core->Cell(120,20,$data['Name'], 0, 0, 'C');

        $core->SetTextColor(0);
        $core->SetFont('Calibri','I',18);
        $core->SetXY(80, 70);
        $core->Cell(120,10,'Has completed the following course', 0, 0, 'C');

        $core->SetFont('Calibri','',30);
        $core->SetXY(80, 90);
        $core->Cell(120,10, $data['Course1'], 0, 0, 'C');
        $core->SetFont('Calibri','',30);
        $core->SetXY(80, 103);
        $core->Cell(120,10, $data['Course2'], 0, 0, 'C');
        $core->SetFont('Calibri','',12);
        if($data['PDUs']){
            $core->SetXY(80, 115);
            $core->Cell(120,10, $data['PDUs'].' PDUs Awarded', 0, 0, 'C');
        }

        return $core;
    }


    private function produce_DAC_certificate($data){
        $core = new FPDF('L', 'mm', 'Letter');
        $core = $this->produce_common_certificate_parts($core, $data);
        // logo
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/DAC.jpg', 90,140,100);

        // Ambler signature
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/AmblerSignature.jpg', 30,170,40);
        $core->SetLineWidth(.2);
        $core->SetFont('Calibri', '', 11);
        $core->Line(30,182,70,182);
        $core->SetXY(30,185);
        $core->Cell(40, 5, 'Scott Ambler');

        // Lines signature
        $core->Image( 'http://scottambler.com/dac/app/webroot/img/LinesSignature.jpg', 200,170,40);
        $core->SetLineWidth(.2);
        $core->SetFont('Calibri', '', 11);
        $core->Line(200,182,240,182);
        $core->SetXY(200,185);
        $core->Cell(40, 5, 'Mark Lines');

        // date
        $core->SetFont('Calibri', '', 12);
        $core->SetXY(120,176);
        $core->Cell(40, 5, $data['Date'], 0, 0, 'C');
        $core->Line(120,182,160,182);

        $contents = $core->Output('','S');
        return $contents;
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