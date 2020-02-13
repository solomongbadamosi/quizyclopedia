<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    
    function __construct() {
            parent::__construct();
            $this->load->library(array('myurl', 'myuser'));
            $this->myuser->is_not_robot();
            //$this->output->cache(2);
        }

    /**
     * Index Page for this controller.
     */
    public function index(){
        if($this->form_validation->run('contact_mail')== TRUE){
            $this->myuser->sendmail();
        }elseif($this->input->post() && $this->form_validation->run('contact_mail')== FALSE){
            $this->session->set_flashdata('error_msg', 'Your Message was not sent, Please check the errors!');
        }
        //find the examination bodies available
        $exam_body = $this->exambodies->find();
        $body = $this->exambodies->find();
        //load views
        $this->load->view('layout/head');
        $this->load->view('home/home', array('bodies_set'=>$exam_body));
        $this->load->view('layout/footer', array('bodies'=>$body));
    }
}