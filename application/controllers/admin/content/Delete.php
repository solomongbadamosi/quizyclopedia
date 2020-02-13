<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User is Administrator or Author
        * if logged in User is not Administrator, redirect 404 page
        * controls all Administrator CRUD
        */   

    class Delete extends My_Controller {    
    
        function __construct() {
            parent::__construct();
            $this->load->model(array('exambodies', 'examinations', 'examsubjects', 'questions', 
                'options', 'references', 'instructions', 'instructiondiagrams', 
                'questiondiagrams', 'refdiagrams'));
            $this->load->library(array('myurl', 'myuser', 'pagination', 'form_validation'));
            $this->load->helper(array('form'));
            $this->myuser->confirm_login();
            if(!$this->myuser->has_permission()){
                $this->myuser->logout();
            }
        }
        
    /** 
     * Examination Body delete
     * @param type $body_id
     */
    public function body($body_id){
        $where = array('body_id'=>$body_id);
        $child_count = $this->examinations->data_count($where);
        if($child_count>0){
            $this->session->set_flashdata('error_msg', 'Stop! this Body cannot be Deleted');
            redirect('admin/content/manage/body');
        }else{
        //delete examination body
        $this->exambodies->delete($body_id);
        $this->session->set_flashdata('success_msg', 'Exam Body Deleted Successfully');
        redirect('admin/content/manage/body', 'refresh');
        }
    }
    
    
    /**
     * Delete Examination from a body
     * @param type $body_id
     * @param type $exam_id the code for the examination to be deleted
     */
    public function exam(){
        $exam_id = trim($this->uri->segment(6));
        $exam = array('exam_id'=> $exam_id);
        $child_count = $this->examsubjects->data_count($exam);
        if($child_count>0){
            $this->session->set_flashdata('error_msg', 'Stop! this Examination cannot be Deleted');
            redirect('admin/content/manage/body', 'refresh');
        }else{
        //delete examination body
        $this->examinations->delete($exam_id);
        $this->session->set_flashdata('success_msg', 'Examination Deleted Successfully');
        redirect('admin/content/manage/body', 'refresh');
        }
    }
    
    /**
     * Deleting Questions 
     * @param type $body_id
     * @param type $exam_id
     * @param type $subject_id
     * @param type $period_id
     * @param type $category_id
     * @param type $qnum
     */
    public function question($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum){
        $where = $this->where($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum);
        $database = array('questions', 'instructions', 'instructiondiagrams', 'options', 'questiondiagrams', 'questiondiagrams', 'refdiagrams');
        foreach ($database as $value){
            $this->{$value}->delete($where);
            $this->session->set_flashdata('success_msg', 'Question '.$value.' Deleted Successfully');
        }
        redirect('admin/content/manage/questions/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$category_id, 'refresh');
    }
    
    
    public function solution($body_id, $exam_id, $subject_id, $period_id, $qnum){
        $where = $this->solution_where($body_id, $exam_id, $subject_id, $period_id, $qnum);
        $this->explanatorysolutions->delete($where);
        $this->session->set_flashdata('success_msg', 'Solution Deleted Successfully');
        redirect('admin/content/manage/solution/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/THEO', 'refresh');
    }
}