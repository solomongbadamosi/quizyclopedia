<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User is Administrator or Author
        * if logged in User is not Administrator, redirect 404 page
        * controls all Administrator CRUD
        */   

    class Referral extends My_Controller {

 
        function __construct() {
            parent::__construct();
            $this->load->library(array('myurl', 'myuser', 'myvalidation'));
            $this->load->helper(array('form'));
            $this->load->model(array('referrals', 'schools'));
            $this->myuser->confirm_login();
            $this->myuser->is_referral();
            
        }
    
        /**
        * Index Page for this controller.
        */
        public function index(){
            //Get the total users registered through referral
            $users = $this->users->data_count(array('referral'=>$this->session->user_name), 'subscribed')->result();
            //Check how many of this users are actively subscribed
            $number_subscribed = 0;
            foreach($users as $user){
                if($user->subscribed==1){
                    $number_subscribed++;
                }
            }
            //Check the amount presently due to the Referral
            $amount = $this->referrals->data_count(array('user_name'=>$this->session->user_name), 'amount')->row();
            $referral = (object)array(
                'users'=>count($users),
                'subscribed'=>$number_subscribed,
                'amount'=>$amount->amount,
            );
            $this->load->view('layout/head');
            $this->load->view('exam/referrals/referral', array('referral'=>$referral));
            $this->load->view('layout/footer');
        }
        
        /**
         * for managing schools and their students
         */
        public function client($id, $offset = null){
            /**
             * call schools registered with a referral from db
             */
            $where = array('ref_id'=>$id);
            //subscribers from schools
            $schools = $this->schools->find_where($where, 25, $offset);
            //other subscribers without school
            $other_subscribers = $this->users->find_where(array('referral'=>$id), 25, $offset);
            $this->load->view('layout/head');
            $this->load->view('exam/referrals/ref_client', array('sch'=>$schools, 'others'=>$other_subscribers));
            $this->load->view('layout/footer');
        }
        
        /**
         * for adding  and editing schools into the system by referrals
         * only the author reserves the right to delete schools
         */
        public function update($sch_id = NULL){
            $where = array('sch_id'=>$sch_id);
            $school = $this->schools->find_where($where)->row();
            if($this->form_validation->run('schools')==FALSE){
                $this->load->view('layout/head');
                $this->load->view('exam/referrals/update_client', array('school'=>$school));
                $this->load->view('layout/footer');
            }else{
                $data = $this->school_info();
                if($this->input->post('update')){
                    //update school information
                    $this->schools->update($data, $sch_id);
                    $this->session->set_flashdata('success_msg', 'School Info successfully changed');
                }elseif($this->input->post('add')){
                    //add new school to the system
                    $this->schools->insert($data);
                    $this->session->set_flashdata('success_msg', $data['name'].' successfully added');
                }
                redirect('referral');
            }
        }
        
        //Get post data of form information submitted
        private function school_info(){
            return array(
                'name'=> htmlspecialchars(trim($this->input->post('name', TRUE))),
                'contact_person'=> htmlspecialchars(trim($this->input->post('contact_person', TRUE))),
                'phone'=> htmlspecialchars(trim($this->input->post('phone', TRUE))),
                'location'=> htmlspecialchars(trim($this->input->post('location', TRUE))),
                'ref_id'=> $this->session->userdata('user_name'),
                'email'=> htmlspecialchars(trim($this->input->post('email', TRUE))),
                'password' => htmlspecialchars($this->users->hash(trim($this->input->post('password', TRUE)))),
                 'confirm_password' => htmlspecialchars($this->users->hash(trim($this->input->post('confirm_password', TRUE)))), 
            );
        }
        
        /**
         * Allows Referrals to change their passwords
         */
        public function change_password(){
            change_password();
        }
}