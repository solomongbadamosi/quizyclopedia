<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User is Administrator or Author
        * if logged in User is not Administrator, redirect 404 page
        * controls all Administrator CRUD
        */   

    class School extends My_Controller {

 
        function __construct() {
            parent::__construct();
            $this->load->library(array('myurl', 'myuser', 'myvalidation'));
            $this->load->helper(array('form'));
            $this->load->model(array('schools'));
            $this->myuser->confirm_login();
            $this->myuser->is_school();
        }
    
        /**
        * Index Page for this controller.
        */
        public function index(){
            //Get the total users registered through referral
            $users = $this->users->data_count(array('school_id'=>$this->session->identifier), 'subscribed')->result();
            //Check how many of this users are actively subscribed
            $number_subscribed = 0;
            foreach($users as $user){
                if($user->subscribed==1){
                    $number_subscribed++;
                }
            }
            //Check the amount presently due to the Referral
            $amount = $this->schools->data_count(array('sch_id'=>$this->session->identifier), 'amount')->row();
            $school = (object)array(
                'users'=>count($users),
                'subscribed'=>$number_subscribed,
                'amount'=>$amount->amount,
            );
            $this->load->view('layout/head');
            $this->load->view('exam/schools/school', array('school'=>$school));
            $this->load->view('layout/footer');
        }
        
        /**
         * for managing schools and their students
         */
        public function students($offset = null){
            /**
             * call schools registered with a referral from db
             */
            $where = array('school_id'=> $this->session->sch_id);
            $students = $this->users->find_where($where, 25, $offset);
            $this->load->view('layout/head');
            $this->load->view('exam/schools/students', array('students'=>$students));
            $this->load->view('layout/footer');
        }
        
        
       public function change_password(){
           change_password();
       }
        
}