<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User is Administrator or Author
        * if logged in User is not Administrator, redirect 404 page
        * controls all Administrator CRUD
        */   

    class Manage extends My_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model(array('examtimers' ,'examsubjects', 'exambodies', 'examperiods', 'examsubjectperiods', 'periods', 'subjects', 'questionscategories', 'questions', 'refdiagrams', 'timers', 'instructions'));
            $this->load->library(array('myurl', 'myuser', 'pagination', 'form_validation', 'upload'));
            $this->load->helper(array('form'));
            $this->myuser->confirm_login();
            if(!$this->myuser->has_permission()){
                $this->myuser->logout();
            }
        }
    
        /**
         * Home Page for Managing Contents
         * Displays Examination Bodies and Examinations offered by Each body
         * Add New Examination Body to the system
         */
	public function body($offset=0){
            //pagination
            $this->pagination();
            $config['total_rows']= $this->exambodies->data_count(); $config['base_url']= base_url('admin/content/manage/body');
            $config['per_page']=2; 
            $this->pagination->initialize($config);
            $pagination_data['pages']=$this->pagination->create_links();
            //pull existing bodies from database
            $data = array('body_name'=>trim($this->input->post('body_name', TRUE)));
           if($this->form_validation->run('body')== FALSE){
               //load view from core
               $this->go_home($offset, $pagination_data);
           }else{
               $count = array('body_name'=>$data['body_name']);
                $item_count = $this->exambodies->data_count($count);
                if($item_count > 0){
                    $this->session->set_flashdata('error_msg', 'This Examination Body "'. $data['body_name'].'" already exists');
                    $this->go_home($offset, $pagination_data);
                }else{
                $this->exambodies->insert($data);
                $this->session->set_flashdata('success_msg', $data['body_name'].' successfully added to Examination Bodies!');
                redirect($this->uri->uri_string(), 'refresh');
                }
            }
        }
        
    /**
     * This is for managing Examination subjects and Body Subjects
     */
    public function exam($body_id, $exam_id, $offset=0){
        $this->pagination();
        $count = array('exam_id'=>$exam_id);
        $config['total_rows']= $this->examsubjects->data_count($count); 
        $config['base_url']= base_url('admin/content/manage/exam/'.$body_id.'/'.$exam_id); $config['per_page']=6; //$config['uri_segment'] = 5;
        //pull existing records from database
        $subjects_set = $this->examsubjects->find_exam_subjects($exam_id, 6, $offset);
        $periods = $this->periods->find()->result(); $subjects = $this->subjects->find()->result();
        $question_categories = $this->questionscategories->find()->result();
        $exam_periods = $this->examperiods->find_exam_periods($exam_id);
        $this->pagination->initialize($config);
        $pagination_data['pages']=$this->pagination->create_links();
        if($this->form_validation->run('subject_period')=== FALSE){
                $this->load->view('layout/head');
                $this->load->view('admin/manage_exam_content', array('subjects_set'=> $subjects_set, 'pagination_data'=>$pagination_data, 'periods'=>$periods, 'exam_periods'=>$exam_periods,'subjects'=>$subjects, 'question_categories'=>$question_categories));
                $this->load->view('layout/footer');
        }else{
            //run code for all page validator function
            $subject_period_data = array('exam_id'=>$exam_id, 'period_id'=>trim($this->input->post('period_id', TRUE)), 'subject_id'=>trim($this->input->post('subject_id', TRUE)));
            if(!$this->check_period_exist($subject_period_data)){
                $this->examsubjectperiods->insert($subject_period_data); 
                $this->session->set_flashdata('success_msg', 'New Year added to Subject');
                redirect($this->uri->uri_string(), 'refresh');
            }
        }
    }
    
    /**
     * @param type $subject_period_data
     */
    private function check_period_exist($subject_period_data){
        $item_count = $this->examsubjectperiods->data_count($subject_period_data, 'period_id')->result();
        if(count($item_count)>0){
            $this->session->set_flashdata('error_msg', 'This Exam Period already added');
            redirect($this->uri->uri_string(), 'refresh');
        }elseif($this->input->post('period_id')=='default'){
            $this->session->set_flashdata('error_msg', 'Please Select a Year from the Dropdown');
            redirect($this->uri->uri_string(), 'refresh');
        }
    }
    
    /*
     * this method activates and deactivate examination periods in the public view
     */
    public function activate_period($body_id, $exam_id, $offset=NULL){
        if($this->input->post()){
            $data = array('ready'=> $this->input->post('status', TRUE));
            $id = array('exam_id'=>$exam_id, 'subject_id'=>$this->input->post('subject_id', TRUE), 'period_id'=>$this->input->post('period_id', TRUE));
            $this->examsubjectperiods->update($data, $id);
            $this->session->set_flashdata('success_msg', 'Examination Year Updated');
            redirect($this->uri->uri_string(), 'refresh');
        }else{
            //pull subjects from database
            $subjects_set = $this->examsubjects->find_exam_subjects($exam_id, 6, $offset);
            $this->load->view('layout/head');
            $this->load->view('admin/activate_period', array('subjects'=>$subjects_set));
            $this->load->view('layout/footer');
        }
    }
    
    /**
     * Managing Questions
     * The Landing Page from Subject Page, to select question category to edit
     * @param int $body_id
     * @param string $exam_id
     * @param string $subject_id
     * @param string $period_id
     * @param string $category_id
     */
    public function questions($body_id, $exam_id, $subject_id, $period_id, $category_id=null, $offset=0){
       if($category_id==NULL){     
            $categories = $this->questionscategories->find_exam_category($exam_id)->result();
            $time = $this->timers->find()->result();
            if($this->input->post('add_time', TRUE)){
                $this->timer($body_id, $exam_id, $subject_id);
            }
            $this->load->view('layout/head');
            $this->load->view('admin/manage_questions_and_answers', array('categories'=>$categories, 
            $body_id, $exam_id, $subject_id, $period_id, 'time'=>$time));
            $this->load->view('layout/footer');
       }else{
           $this->edit_questions_view($body_id, $exam_id, $subject_id, $period_id, $category_id, $offset);
        }
    }
    /**
     * Displaying Questions already available for editing
     * @param type $body_id
     * @param type $exam_id
     * @param type $subject_id
     * @param type $period_id
     * @param type $category_id
     * @param type $offset
     */
    private function edit_questions_view($body_id, $exam_id, $subject_id, $period_id, $category_id, $offset){
        //load pagination configurations
            $this->pagination();
            $config['total_rows']= $this->questions->data_count($this->where($body_id, $exam_id, $subject_id, $period_id, $category_id), 'question_number')->num_rows();
            $config['base_url']= base_url('admin/content/manage/questions/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$category_id);
            $config['per_page']=25;  
            //initialize pagination configuration
            $this->pagination->initialize($config);
            $pagination_data['pages']=$this->pagination->create_links();
            $total = $config['total_rows'];
            $question_set = $this->questions->find_where($this->where($body_id, $exam_id, $subject_id, $period_id, $category_id), 25, $offset);
            $this->load->view('layout/head');
            $this->load->view('admin/question', array('question_set'=>$question_set, 'pagination'=>$pagination_data, 'total'=>$total));
            $this->load->view('layout/footer');
    }
    
    /**
     * For theory solutions
     * @param type $body_id
     * @param type $exam_id
     * @param type $subject_id
     * @param type $period_id
     * @param type $category_id
     * @param int $offset for pagination
     * @param type $qnum
     */
    public function solution($body_id, $exam_id, $subject_id, $period_id, $category_id, $offset=0, $qnum=null){
        //load pagination configurations
        $this->pagination();
        $where = $this->solution_where($body_id, $exam_id, $subject_id, $period_id);
        $config['total_rows']= $this->references->data_count($where, 'question_number')->num_rows();
        $config['base_url']= base_url('admin/content/manage/solution/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$category_id);
        $config['per_page']=1;  
        //initialize pagination configuration
        $this->pagination->initialize($config);
        $pagination_data['pages']=$this->pagination->create_links();
        $total = $config['total_rows'];
        
        //page navigation
        $this->page_navigation($body_id, $exam_id, $subject_id, $period_id, $offset);
        //pull existing bodies from database
        $solution_set = $this->references->find_where($where, 1, $offset)->row();
         //set upload configurations
        $check_file_upload = FALSE;
        if(isset($_FILES['solution_diagram']['error'])&& $_FILES['solution_diagram']['error'] !=4){
            $check_file_upload = TRUE;
        }
        $this->check_solution_update($body_id, $exam_id, $subject_id, $period_id, $qnum, $pagination_data, $solution_set, $check_file_upload, $total);
    }
    
    
    /**
     * for inserting or updating questions and answers
     * @param int $body_id
     * @param string $exam_id
     * @param string $subject_id
     * @param string $period_id
     * @param string $category_id
     * @param int $qnum
     */
    private function check_solution_update($body_id, $exam_id, $subject_id, $period_id, $qnum, $pagination_data, $solution_set, $check_file_upload, $total){
        //run form validation
        if($this->form_validation->run('solution')==FALSE || ($check_file_upload && !$this->upload->do_upload('solution_diagram'))){
            //load view
            $this->solution_view($pagination_data, $solution_set, $total);
        }else{
            //if form validation is true, insert or update questions
            //load prep from my_controller
            $data = $this->solution_prep();
            $upload_data = $this->upload->data();
            if(isset($upload_data['file_name'])){
                $data['solution_diagram'] = $upload_data['file_name'];
            }
            //insert questions
            if($this->input->post('add', TRUE)){
                $this->references->insert($data);
                $this->session->set_flashdata('success_msg', 'Solution to Question Number '.$data['question_number'].' successfully Added');
                redirect($this->uri->uri_string(), 'refresh');
                //upadate question
            }elseif($this->input->post('edit', TRUE)){
                $where = $this->solution_where($body_id, $exam_id, $subject_id, $period_id, $qnum);
                $this->references->update($data, $where);
                $this->session->set_flashdata('success_msg', 'Solution to Question Number '.$data['question_number'].' updated');
                redirect($this->uri->uri_string(), 'refresh');
            }
        }
    }
    
    private function page_navigation($body_id, $exam_id, $subject_id, $period_id, $offset){
        if($this->input->post('search', TRUE)){
            $num = trim($this->input->post('pg_num', TRUE));
            if($this->input->post('pg_num', TRUE)==0){
                $offset = 0;
            }else{
                $offset = $num -1;
            }
            redirect('admin/content/manage/solution/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/THEO/'.$offset, 'refresh');
        }
    }
    
    /**
     * view for solution method
     * @param type $pagination_data
     * @param type $solution_set
     * @param type $total
     */
    private function solution_view($pagination_data, $solution_set, $total){
        $this->load->view('layout/head');
        $this->load->view('admin/solution', array('pagination'=>$pagination_data, 'question'=>$solution_set, 'total'=>$total));
        $this->load->view('layout/footer');
    }
    
    /**
     * Timer Function for adding time 
     * @param type $body_id
     * @param type $exam_id
     * @param type $subject_id
     */
    private function timer($body_id, $exam_id, $subject_id){
        $time = $this->examtimers->get_time($this->time_where($body_id, $exam_id, $subject_id))->row();
        $data = $this->time_where($body_id, $exam_id, $subject_id);
        
        //check if the default value was sent
        if($this->input->post('timer', TRUE)==='default'){
            $this->session->set_flashdata('error_msg', 'Please Select an Item');
        }elseif($time){
            if($time->time_id=== $this->input->post('timer', TRUE)){
                $this->session->set_flashdata('error_msg', 'Sorry! Time is already set for this Subject');
            }elseif($time->time_id){
            $item = array('time_id'=>trim($this->input->post('timer', TRUE)));
            $this->examtimers->update($item, $data);
            $this->session->set_flashdata('success_msg', 'Time successfully Changed');
            }
        }else{
            $data['time_id']= trim($this->input->post('timer', TRUE));
            $this->examtimers->insert($data);
            $this->session->set_flashdata('success_msg', 'Time successfully Added');
        }
        redirect($this->uri->uri_string(), 'refresh');
    }
}//End of Class