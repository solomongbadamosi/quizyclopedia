<?php

/**
 * The Admin User controller
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Check to see if User is logged in
 * confirm if logged in User is Author
 * if logged in User is not Author, redirect to Admin Page
 * controls all Admin CRUD
 */
class User extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('myuser'));
        $this->myuser->confirm_login();
        $this->myuser->has_right();
    }
    
    /**
     * this is for the Author only
     * if it not the author but admin, redirect to manage content
     */
    public function index(){
        $where = array('user_category'=>'admin');
        $item = ('user_id, first_name, email, user_category, status');
        $admin = $this->users->data_count($where, $item);
        $this->load->view('layout/head');
        $this->load->view('admin/user_view', array('admins'=>$admin));
        $this->load->view('layout/footer');
    }
    
    /**
     * deleting an Admin to the system
     * @param string $user_id passsed from the url
     */
    
    public function delete($user_id){
        $where = array('user_id' => $user_id);
        $user = $this->users->data_count($where, 'email, first_name')->row();
        $this->users->delete($user->email);
        $this->session->set_flashdata('success_msg', $user->first_name." successfully Deleted from Administrators' List");
        redirect('admin/user', 'refresh');
    }
    /**
     * edit an Admin to the system
     * @param, the user_id passed from the url
     */
    
    public function update($user_id=null){
        //set default value for current user if exists
        $current_user = $this->current_user($user_id);
        $data = $this->post_data();
        if ($this->form_validation->run('signup')=== TRUE) {
            //run the query for editing admin user
            if($user_id){
                $this->users->update($data, $current_user->email);
                $this->session->set_flashdata('success_msg', $current_user->first_name."'s data successfully Updated");
            }else{
                //check if user already exists
                $this->user_exists();
                //if not create the user
                $this->users->insert($data);
                $this->session->set_flashdata('success_msg', $data['first_name'].' is now Admin');
            }
                redirect('admin/user', 'refresh');
        }else{
            $this->load->view('layout/head');
            $this->load->view('admin/update/admin', array('current_user'=>$current_user));
            $this->load->view('layout/footer');
        }
    }
    
    /**
     * Check if User already exists
     */
    private function user_exists(){
        $where = array('email'=> trim($this->input->post('email', TRUE)));
        if($this->users->data_count($where)>0){
            $this->session->set_flashdata('error_msg', 'A user with this credential already exists');
            redirect('admin/user', 'refresh');
        }
    }
    
    /**
     * All $_POST data for creating and editing admin users.
     * @return array
     */
    private function post_data(){
       return $data = array(
            'first_name'=> trim($this->input->post('first_name', TRUE)),
            'last_name'=> trim($this->input->post('last_name', TRUE)),
            'email' => trim($this->input->post('email', TRUE)),
            'confirm_password' => $this->users->hash(trim($this->input->post('confirm_password', TRUE))),
            'password' => $this->users->hash(trim($this->input->post('password', TRUE))),
            'user_category' => trim($this->input->post('user_category', TRUE)),
            'subscribed' => trim($this->input->post('subscribed', TRUE)),
            'status' => trim($this->input->post('status', TRUE)),
        );
    }
   
    /**
     * setting default value for current user if method has user_id set
     * @param string $user_id
     * @return string or Array
     */
    private function current_user($user_id){
        $where = array('user_id'=>$user_id);
        if($user_id!==null){
            $current_user = $this->users->data_count($where, '*')->row();
        }else{
            $current_user = 'Author';
        }
        return $current_user;
    }
}

