<?php
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
        $this->myuser->has_subscribed();
        $this->myuser->can_practice();
    }
    
    /**
     * this is for the Public and author only
     */
    public function index(){
        //load view
        $this->load->view('layout/head');
        $this->load->view('exam/home');
        $this->load->view('layout/footer');
    }
}
    