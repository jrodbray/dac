<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-19
 * Time: 2:05 PM
 */

class FaqsController extends AppController {
    public $scaffold;
    public $uses = array('Faq', 'Section');

    public function create_faq_page() {
        $this->response->disableCache();
        $this->layout = 'layout.help';

        $sections = $this->Section->find('all', array(
            'order' => array(
                'Section.sort_code' => 'asc'
            )
        ));
        $this->set('sections', $sections);

        $faqs = $this->Faq->find('all', array(
            'order' => array(
                'Section.sort_code' => 'asc',
                'Faq.sort_code' => 'asc'
            )
        ));
        $this->set('faqs', $faqs);
    }
}