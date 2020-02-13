<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User has subscribed
        * if logged in User has not subscribed redirect to subscription page
        * control for Reading Examination Content
        */   

    class Home extends My_Controller {

 
        function __construct() {
            parent::__construct();
            $this->load->library(array('myuser', 'pagination'));
            $this->load->helper(array('form'));
            $this->load->model(array('exambodies', 'examinations'));
            $this->myuser->confirm_login();
            if($this->myuser->can_practice()){
                $this->myuser->has_subscribed();
            }
            //$this->output->cache(2);
        }
    
        /**
        * Index Page for this controller.
        */
        public function index($offset=0){
            //load pagination data
            $this->pagination();
            $config['total_rows']= $this->exambodies->data_count(); 
            $config['base_url']= base_url('exam/content/home/index');
            $config['per_page']=2; 
            $this->pagination->initialize($config);
            $pagination_data['pages']=$this->pagination->create_links();
            $where = array('ready'=>TRUE);
            
            $bodies_set = $this->exambodies->find_where($where);
            $this->load->view('layout/head');
            $this->load->view('exam/body', array('bodies_set'=>$bodies_set, 'pagination_data'=>$pagination_data));
            $this->load->view('layout/footer');
        }
}