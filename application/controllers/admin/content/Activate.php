<?php
defined('BASEPATH') OR exit('No direct script access allowed');


	/**
        * Check to see if User is logged in
        * confirm if logged in User is Administrator or Author
        * if logged in User is not Administrator, redirect 404 page
        * controls all Administrator CRUD
        */   

    class Activate extends My_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model(array('exambodies', 'examinations'));
            $this->load->library(array('myuser'));
            $this->myuser->confirm_login();
            if(!$this->myuser->has_permission()){
                $this->myuser->logout();
            }
        }
        
        /**
         * activate body
         * @param string $body_id
         */
        public function body($body_id){
            $data = array('ready'=>1);
            $this->exambodies->update($data, $body_id);
            redirect('admin/content/manage/body', 'refresh');
        }
        
        /**
         * activate examination
         * @param string $exam_id
         */
        public function exam($exam_id){
            $data = array('ready'=>1);
            $this->examinations->update($data, $exam_id);
            redirect('admin/content/manage/body', 'refresh');
        }
    }