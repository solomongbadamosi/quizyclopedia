<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Check to see if User is logged in
 * confirm if logged in User is Author
 * if logged in User is not Author, redirect to Admin Page
 * controls all Admin CRUD
 */
class School extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('myuser'));
        $this->load->model('schools');
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
        $schools = $this->schools->find();
        $this->load->view('layout/head');
        $this->load->view('admin/school', array('schools'=>$schools));
        $this->load->view('layout/footer');
    }
    
    /**
     * ban Misbehaving Schools
     */
    
    public function ban($id){
        if ($this->input->post('ban')) {
            $this->schools->update(array('banned'=>1), $id);
            $this->session->set_flashdata('error_msg', $this->input->post('sch_name')." has been Banned!!!");
            redirect('admin/school', 'refresh');
        }else{
            show_404();
        }
    }
    
    /**
     * Reactivate Banned Schools
     */
    
    public function activate($id){
        if ($this->input->post('activate')) {
            $this->schools->update(array('banned'=>0), $id);
            $this->session->set_flashdata('success_msg', $this->input->post('sch_name')." is Reactivated!!!");
            redirect('admin/school', 'refresh');
        }else{
            show_404();
        }
    }
}

