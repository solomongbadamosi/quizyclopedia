<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User is Administrator or Author
        * if logged in User is not Administrator, redirect 404 page
        * controls all Administrator CRUD
        */   

    class Administrator extends My_Controller {

 
        function __construct() {
            parent::__construct();
            $this->load->library(array('myurl', 'myuser', 'myvalidation'));
            $this->load->helper(array('form'));
            $this->myuser->confirm_login();
            if(!$this->myuser->has_permission()){
                $this->myuser->logout();
            }
        }
    
        /**
         * Allows Administrators and Author to change their passwords
         */
        public function change_password(){
            change_password();
        }
}