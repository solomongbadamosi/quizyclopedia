<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Check to see if User is logged in
 * confirm if logged in User is Author
 * if logged in User is not Author, redirect to Admin Page
 * controls all Admin CRUD
 */
class PublicUser extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('myuser'));
        $this->myuser->confirm_login();
        if(!$this->myuser->has_permission()){
            $this->myuser->logout();
        }
    }
    
    /**
     * this is for the Author only
     * if it not the author but admin, redirect to manage content
     */
    public function index(){
        $users = $this->users->find_where(array('user_category'=>'Public'));
        $this->load->view('layout/head');
        $this->load->view('admin/publicuser', array('users'=>$users));
        $this->load->view('layout/footer');
    }
    
   
    /**
     * Banning a misbehaving user
     */
    
    public function ban(){
        if ($this->input->post('ban')) {
            $this->users->update(array('banned'=>1), $this->input->post('email'));
            $this->session->set_flashdata('error_msg', $this->input->post('name')." has been Banned!!!");
            redirect('admin/publicuser', 'refresh');
        }else{
            show_404();
        }
    }
    
    /**
     * Reactivate Banned User
     */
    public function activate(){
        if ($this->input->post('activate')) {
            $this->users->update(array('banned'=>0), $this->input->post('email'));
            $this->session->set_flashdata('success_msg', $this->input->post('name')." is Reactivated!!!");
            redirect('admin/publicuser', 'refresh');
        }else{
            show_404();
        }
    }
}

