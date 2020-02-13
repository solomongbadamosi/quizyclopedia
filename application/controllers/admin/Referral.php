<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Check to see if User is logged in
 * confirm if logged in User is Author
 * if logged in User is not Author, redirect to Admin Page
 * controls all Admin CRUD
 */
class Referral extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('myuser'));
        $this->load->model(array('referrals', 'schools'));
        $this->myuser->confirm_login();
        $this->myuser->has_right();
    }
    
    /**
     * this is for the Author only
     * if it not the author but admin, redirect to manage content
     */
    public function index(){
        $referral = $this->referrals->find();
        $this->load->view('layout/head');
        $this->load->view('admin/referral', array('referral'=>$referral));
        $this->load->view('layout/footer');
    }
    
    /**
     * deleting an Admin to the system
     * @param string $user_id passsed from the url
     */
    
    public function delete($user_name){
        $where = array('user_name' => $user_name);
        $user = $this->referrals->data_count($where, 'first_name')->row();
        $this->referrals->delete($user_name);
        $this->session->set_flashdata('success_msg', $user->first_name." successfully Deleted from Administrators' List");
        redirect('admin/referral', 'refresh');
    }
    /**
     * edit an Admin to the system
     * @param, the user_id passed from the url
     */
    
    public function update($user_name=null){
        //set default value for current user if exists
        $current_user = $this->current_user($user_name);
        $data = $this->post_data();
        if ($this->form_validation->run('signup_referral')=== TRUE) {
            //run the query for editing admin user
            if($user_name){
                $this->referrals->update($data, $current_user->user_name);
                $this->session->set_flashdata('success_msg', $current_user->first_name."'s data successfully Updated");
            }else{
                //check if referral already exists
                $this->user_exists();
                //if not create the user
                $this->referrals->insert($data);
                $this->session->set_flashdata('success_msg', $data['first_name'].' is now a Referral');
            }
                redirect('admin/referral', 'refresh');
        }else{
            $this->load->view('layout/head');
            $this->load->view('admin/update/referral', array('current_user'=>$current_user));
            $this->load->view('layout/footer');
        }
    }
    
    /**
     * Check if User already exists
     */
    private function user_exists(){
        $where = array('user_name'=> trim($this->input->post('user_name', TRUE)));
        if($this->referrals->data_count($where)>0){
            $this->session->set_flashdata('error_msg', 'A Referral with this credential already exists');
            redirect('admin/referral', 'refresh');
        }
    }
    
    /**
     * All $_POST data for creating and editing admin users.
     * @return array
     */
    private function post_data(){
       return $data = array(
            'user_name'=> htmlspecialchars(trim($this->input->post('user_name', TRUE))),
            'first_name'=> htmlspecialchars(trim($this->input->post('first_name', TRUE))),
            'last_name'=> htmlspecialchars(trim($this->input->post('last_name', TRUE))),
            'phone_number'=> htmlspecialchars(trim($this->input->post('phone_number', TRUE))),
            'banker'=> htmlspecialchars(trim($this->input->post('banker', TRUE))),
            'account_number'=> base64_encode(htmlspecialchars(trim($this->input->post('account_number', TRUE)))),
            'email' => htmlspecialchars(trim($this->input->post('email', TRUE))),
            'confirm_password' => $this->users->hash(trim($this->input->post('confirm_password', TRUE))),
            'password' => $this->referrals->hash(trim($this->input->post('password', TRUE))),
            'status' => htmlspecialchars(trim($this->input->post('status', TRUE))),
        );
    }
   
    /**
     * setting default value for current user if method has user_id set
     * @param string $user_name
     * @return string or Array
     */
    private function current_user($user_name){
        $where = array('user_name'=>$user_name);
        if($user_name!==null){
            $current_user = $this->referrals->data_count($where, '*')->row();
            return $current_user;
        }
    }
    
    /**
     * This method deletes the amount payable to referral
     * @param string $user_name of referral
     */
    public function pay($user_name, $sch_id = NULL){
        $data = array('amount'=>0);
        if($sch_id !==NULL){
            $this->schools->update($data, $sch_id);
            redirect('admin/referral/clients/'.$user_name, 'refresh');
        }else{
            $this->referrals->update($data, $user_name);
            redirect('admin/referral', 'refresh');
        }
    }
    
    /**
     * Manage the various schools registered under a referral
     * @param string $user_name
     */
    public function clients($user_name, $offset=NULL){
        /**
             * call schools registered with a referral from db
             */
            $where = array('ref_id'=>$user_name);
            $schools = $this->schools->find_where($where, 25, $offset);
            $this->load->view('layout/head');
            $this->load->view('exam/referrals/ref_client', array('sch'=>$schools));
            $this->load->view('layout/footer');
    }
}

