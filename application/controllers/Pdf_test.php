<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_test extends MY_Controller {
    
    function __construct() {
            parent::__construct();
            $this->load->library(array('Mypdf'));
        }
   
        public function index(){
            $content = $this->load->view('layout/email/reset','', TRUE);
            //$content = "<h3>Hello World</h3>";
            $this->mypdf->loadHTML($content);
            $this->mypdf->render();
            $this->mypdf->stream('another.pdf', array('attachment'=>1));
        }
}