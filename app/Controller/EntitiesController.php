<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-09
 * Time: 6:30 PM
 */

class EntitiesController extends AppController {

    public $components = array('Paginator');

    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'name' => 'asc'
        )
    );

    public function index() {
        $this->response->disableCache();

        $this->Paginator->settings = $this->paginate;
        // similar to findAll(), but fetches paged results
        $entities = $this->Paginator->paginate('Entity');

        $this->set('entities', $entities);

    }

    public function add() {
        //check if it is a post request
        //this way, we won't have to do if(!empty($this->request->data))
        if ($this->request->is('post')){
            // for now, we mark EVERYTHING as a DAC training entity
            $this->request->data['Entity']['dac_training'] = 1;
            //save new entity
            if ($this->Entity->saveAll($this->request->data)){
                //set flash to Person screen
                $this->Session->setFlash('Entity was added.');
                //redirect to user list
                $this->redirect(array('action' => 'index'));
            }else{
                //if save failed
                $this->Session->setFlash('Unable to add Entity. Please, try again.');
            }
        }
    }

    public function edit()
    {
        //get the id of the Entity to be edited
        $id = $this->request->params['pass'][0];

        //set the entity id
        $this->Entity->id = $id;

        //check if a Entity with this id really exists
        if ($this->Entity->exists()) {

            if ($this->request->is('post') || $this->request->is('put')) {
                //save Person
                if ($this->Entity->save($this->request->data)) {

                    //set to Person's screen
                    $this->Session->setFlash('Entity was edited.');

                    //redirect to Person's list
                    $this->redirect(array('action' => 'index'));

                } else {
                    $this->Session->setFlash('Unable to edit Entity. Please, try again.');
                }

            } else {

                //we will read the Person data
                //so it will fill up our html form automatically
                $this->request->data = $this->Entity->read();
            }

        } else {
            //if not found, we will tell the user that Person does not exist
            $this->Session->setFlash('The Person you are trying to edit does not exist.');
            $this->redirect(array('action' => 'index'));

            //or, since it we are using php5, we can throw an exception
            //it looks like this
            //throw new NotFoundException('The Person you are trying to edit does not exist.');
        }
    }

}