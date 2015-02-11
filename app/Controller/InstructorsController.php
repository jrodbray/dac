<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-16
 * Time: 4:36 PM
 */

class InstructorsController extends AppController {

    public $uses=array('CourseOffering', 'Course', 'Instructor', 'Person');

    public function index() {
        $this->response->disableCache();
        //grab all Instructor instances and pass it to the view:
        $instructors = $this->Instructor->find('all', array(
                'order' => array('last_name' => 'asc', 'first_name' => 'asc'))
        );
        $this->set('instructors', $instructors);

    }

    public function add()
    {
        if ($this->request->is('post')) {
            $id = $this->request->params['pass'][0];

            $this->Instructor->create();
            $this->Instructor->save(array('person_id' => $id));

            $this->Session->setFlash("Instructor activated");
            $this->redirect(array('action' => 'index'));
        }
    }

    public function search() {
        if($this->request->is('post')){
            $last_name = $this->request->data['Instructor']['last_name'];
            $work_email = $this->request->data['Instructor']['work_email'];
            //$personal_email = $this->request->data['Instructor']['personal_email'];
            $conditions_array = array();

            if($last_name){
                $conditions_array['Person.last_name'] = $last_name;
            }
            if($work_email){
                $conditions_array['Person.work_email'] = $work_email;
            }
            //if($personal_email){
            //    $conditions_array['Person.personal_email'] = $personal_email;
            //}
            $people = $this->Person->find('all', array(
                            'joins' => array(
                                        array(
                                        'table' => 'instructors',
                                        'alias' => 'Instructor',
                                        'type' => 'LEFT',
                                        'conditions'=> array('Person.id = Instructor.person_id')
                                        )
                                    ),
                            'fields' => array( 'Person.*', 'Instructor.*' ),
                            'conditions' => $conditions_array
                        ));
            $this->Session->write('people', $people);

            //$this->Session->setFlash('got to the search - '.$last_name);
            $this->redirect(array('action' => 'add'));
        }
    }

    public function remove() {
        $id = $this->request->params['pass'][0];

        //the request must be a post request
        //that's why we use postLink method on our view for deleting user
        if( $this->request->is('get') ){

            $this->Session->setFlash('Remove method is not allowed.');
            $this->redirect(array('action' => 'index'));

            //since we are using php5, we can also throw an exception like:
            //throw new MethodNotAllowedException();
        }else{

            // check if Instructor has active courses
            $committed = $this->CourseOffering->find('all', array(
               'conditions' => array(
                   'CourseOffering.instructor_id' => $id
               )
            ));

            if( count($committed) ){
                $this->Session->setFlash('Still active courses for Instructor');
                $this->redirect(array('action'=>'index'));

            }
            else
            if( !$id ) {
                $this->Session->setFlash('Invalid id for Instructor');
                $this->redirect(array('action'=>'index'));

            }else{
                //set Instructor as "inactive"
                $this->Instructor->read(null, $id);
                $this->Instructor->set('inactive', 1);
                if( $this->Instructor->save() ){
                    //set to screen
                    $this->Session->setFlash('Instructor was set as inactive.');
                    //redirect to People list
                    $this->redirect(array('action'=>'index'));

                }else{
                    //if unable to update
                    $this->Session->setFlash('Unable to set Instructor as inactive.');
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
    }

    public function reactivate() {
        $id = $this->request->params['pass'][0];

        //the request must be a post request
        //that's why we use postLink method on our view for deleting user
        if( $this->request->is('get') ){

            $this->Session->setFlash('Reactivate method is not allowed.');
            $this->redirect(array('action' => 'index'));

            //since we are using php5, we can also throw an exception like:
            //throw new MethodNotAllowedException();
        }else{

                if( !$id ) {
                    $this->Session->setFlash('Invalid id for Instructor');
                    $this->redirect(array('action'=>'index'));

                }else{
                    //set Instructor as "active"
                    $this->Instructor->read(null, $id);
                    $this->Instructor->set('inactive', null);
                    if( $this->Instructor->save() ){
                        //set to screen
                        $this->Session->setFlash('Instructor was set as active.');
                        //redirect to People list
                        $this->redirect(array('action'=>'index'));

                    }else{
                        //if unable to update
                        $this->Session->setFlash('Unable to set Instructor as active.');
                        $this->redirect(array('action' => 'index'));
                    }
                }
        }
    }

}