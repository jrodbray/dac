<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-03-13
 * Time: 6:38 PM
 */

class CurlsController extends AppController{

        public function curl(){

// create curl resource
            $ch = curl_init();

// set url
            //curl_setopt($ch, CURLOPT_URL, "http://disciplinedagiledelivery.files.wordpress.com/2014/01/lifecycle-goals-v2.jpg");
            //curl_setopt($ch, CURLOPT_URL, "http://disciplinedagiledelivery.wordpress.com/");
            curl_setopt($ch, CURLOPT_URL, "http://nhl.com/");

//return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// $output contains the output string
            $output = curl_exec($ch);
            $msg = curl_error($ch);
            $this->set("output", $output);
            $this->set('msg', $msg);
// close curl resource to free up system resources
            curl_close($ch);
        }

    public function curlit(){
        $this->response->disableCache();
        $this->Curl->url = 'nhl.com';
        $this->Curl->get = true;
        $this->Curl->post = false; // Set options like this, for a list of new names, see the array below organised by type
        //$this->Curl->postFieldsArray = array('field1' => 'value1', 'field2' => 'value2'); // This urlencode post data for you
        $this->Curl->followLocation = true;
        //$this->Curl->verbose = true;

        $this->Curl->userAgent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.1) Gecko/20060601 Firefox/2.0.0.1 (Ubuntu-edgy)';
        $this->Curl->execute(); // execute() returns the output instead of writing it straight to the page like normal cURL
        $output = $this->Curl->grab('<body>', '</body>'); // Matches the first set of these, and returns whats in between
        $http_code = $this->Curl->httpCode();

        $this->set('output',$output);
        $this->set('http_code', $http_code);
    }

}