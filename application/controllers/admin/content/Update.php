<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User is Administrator or Author
        * if logged in User is not Administrator, redirect 404 page
        * controls all Administrator CRUD
        */   

    class Update extends My_Controller {
        
        function __construct() {
            parent::__construct();
            $this->load->model(array('examsubjects', 'examperiods', 'examquestioncategories',));
            $this->load->library(array('myurl', 'myuser', 'pagination', 'form_validation', 'upload', 'myquestions'));
            $this->myuser->confirm_login();
            if(!$this->myuser->has_permission()){
                $this->myuser->logout();
            }
        }
    
    //METHOD FOR ADDING AND CHANGING EXAMINATIONS IN BODIES
    /**
     * for adding examination to an existing examination body
     * @param type $body_id
     */
    public function exam($body_id, $exam_id=null){
        //fetch the number of examination already existing in the selected body
        $position = $this->examinations->position_count($body_id);
        //Get submitted post from users after validation
        $data = array('exam_name'=> trim($this->input->post('exam_name', TRUE)),'exam_id'=> trim($this->input->post('exam_id', TRUE)),
                        'body_id'=> trim($this->input->post('body_id', TRUE)), 'position'=> trim($this->input->post('position', TRUE)),
        );
        if($this->form_validation->run('exam')== FALSE){
            //Load page
            $this->exam_content_view($position);
       }elseif($exam_id===null){
           // it is an insert query
           $this->insert_exam($data, $position);
       }else{
           //it is an edit query
           $this->examinations->update($data, $exam_id);
           $this->session->set_flashdata('success_msg', 'Examination successfully Edited!');
           redirect('admin/content/manage/body', 'refresh');
       }
    }
    
    /**
     * Method inserts examination into the major function
     * @param type $data
     * @param type $position
     */
    private function insert_exam($data, $position){
        // check if data is existing in the table and send back error message if any is found
        $count = array('body_id' => $data['body_id'], 'exam_name'=> $data['exam_name']);
        $exam_exist = $this->examinations->data_count($count);
        if($exam_exist > 0){
            $this->session->set_flashdata('error_msg', $data['exam_name'].' already exists');
            $this->exam_content_view($position);
            //if data is not existing, insert the new data into examinations table
        }else{
             $this->examinations->insert($data);
             $this->session->set_flashdata('success_msg', $data['exam_name'].' successfully added to '.$data['body_id']);
             redirect('admin/content/manage/body', 'refresh');
        }
    }
    
    
    /**
     * Loads View for adding examinations to body
     * @param int $position
     */
    private function exam_content_view($position){
        $this->load->view('layout/head');
        $this->load->view('admin/update/exam', array('position'=>$position));
        $this->load->view('layout/footer');
    }
   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //METHOD FOR CHANGING EXAMINATION BODY NAME
    /**
     * 
     * @param string $body_id
     * Method Editing examination Body name
     */
    public function body($body_id){
        $data = array('body_name'=> trim($this->input->post('body_name', TRUE)), 'about'=> trim($this->input->post('about', TRUE)),
            'brief_info'=> trim($this->input->post('brief_info', TRUE)));
        //set default value for file upload
        $check_file_upload = FALSE;
        if(isset($_FILES['logo']['error'])&& $_FILES['logo']['error'] !=4){
            $check_file_upload = TRUE;
        }
        //check form validation
        if($this->form_validation->run('body')===FALSE || ($check_file_upload && !$this->upload->do_upload('logo'))){
            //Load page
            $this->load->view('layout/head');
            $this->load->view('admin/update/body');
            $this->load->view('layout/footer');
       }else{
           $upload_data = $this->upload->data();
            if(isset($upload_data['file_name'])){
                $data['logo'] = $upload_data['file_name'];
            }
            $this->exambodies->update($data, $body_id);
            $this->session->set_flashdata('success_msg', 'Body Information successfully changed!');
            redirect('admin/content/manage/body', 'refresh');
       }
    }
  
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //METHOD FOR ADDING A NEW PERIOD TO THE SYSTEM
    /**
     * For Adding New Years into the system
     * @param type $ffset
     * @param type $pagination_data
     */
    public function period(){
        $data = array('period_id'=> trim($this->input->post('period_id', TRUE)),
                    'period_name'=> trim($this->input->post('period_name', TRUE))
            );
        if($this->form_validation->run('period')==FALSE){
            $this->go_home($offset=null);
        }else{
            $count = array('period_name'=>$data['period_name']);
            $item_count = $this->periods->data_count($count);
            if($item_count > 0){
                $this->session->set_flashdata('error_msg', $data['period_name'].' already exists');
                redirect('admin/content/manage/body', 'refresh');
            }else{
                $this->periods->insert($data);
                $this->session->set_flashdata('success_msg', 'Year '.$data['period_name'].' added Successfully');
               redirect('admin/content/manage/body', 'refresh');
            }
        }
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //METHOD FOR ADDING NEW SUBJECTS TO THE SYSTEM
    /**
     * For Adding New Subjects to the System
     * @param type $ffset
     * @param type $pagination_data
     */
    public function subject(){
        $data = array('subject_id'=> trim($this->input->post('subject_id', TRUE)),
                    'subject_name'=> trim($this->input->post('subject_name', TRUE))
            );
        if($this->form_validation->run('subject')==FALSE){
            $this->go_home($offset=null);
        }else{
            $count = array('subject_name'=>$data['subject_name']);
            $item_count = $this->subjects->data_count($count);
            if($item_count > 0){
                $this->session->set_flashdata('error_msg', $data['subject_name'].' already exists');
                redirect('admin/content/manage/body', 'refresh');
            }else{
                $this->subjects->insert($data);
                $this->session->set_flashdata('success_msg', $data['subject_name'] .' has been added to Subjects');
               redirect('admin/content/manage/body', 'refresh');
            }
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //METHOD FOR INCLUDING A PERIOD TO AN EXAMINATION
    /**
     * For adding Period to Examination
     * @param int $body_id
     * @param mixed $exam_id
     */
    public function exam_period($body_id, $exam_id){
        $exam_period_data = array('period_id'=> trim($this->input->post('period_id', TRUE)), 'exam_id'=> trim($this->input->post('exam_id', TRUE)));
        if($this->form_validation->run('exam_period')== TRUE){
            $count = array('period_id'=>$exam_period_data['period_id'], 'exam_id'=>$exam_period_data['exam_id']);
            $item_count = $this->examperiods->data_count($count);
            if($item_count > 0){
                $this->session->set_flashdata('error_msg', 'This Period Combo already exists');
                redirect('admin/content/manage/exam/'.$body_id.'/'.$exam_id, 'refresh');
            }else{
                $this->examperiods->insert($exam_period_data); $this->session->set_flashdata('success_msg', 'New Year added to this Examination');
                redirect('admin/content/manage/exam/'.$body_id.'/'.$exam_id, 'refresh');
            }
        }else{
            redirect('admin/content/manage/exam/'.$body_id.'/'.$exam_id, 'refresh');
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //METHOD FOR ADDING SUBJECTS TO AN EXAMINATION
    /**
     * For adding subjects to examination
     * @param int $body_id
     * @param mixed $exam_id
     */
    public function exam_subject($body_id, $exam_id){
        $exam_subject_data = array('exam_id'=> trim($this->input->post('exam_id', TRUE)), 'subject_id'=> trim($this->input->post('subject_id', TRUE)));
        if($this->form_validation->run('exam_subject')== TRUE){
            $count = array('exam_id'=>$exam_subject_data['exam_id'], 'subject_id'=>$exam_subject_data['subject_id']);
            $item_count = $this->examsubjects->data_count($count);
            if($item_count > 0){
                $this->session->set_flashdata('error_msg', 'This Exam/Subject Combo already exists');
                redirect('admin/content/manage/exam/'.$body_id.'/'.$exam_id, 'refresh');
            }else{
                $this->examsubjects->insert($exam_subject_data);
                $this->session->set_flashdata('success_msg', 'New Subject included to this Examination');
                redirect('admin/content/manage/exam/'.$body_id.'/'.$exam_id, 'refresh');
            }
        }else{
            redirect('admin/content/manage/exam/'.$body_id.'/'.$exam_id, 'refresh');
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //METHOD FOR CATEGORIZING AN EXAMINATION INTO OBJECTIVES AND THEORY
    /**
     * For Adding Category to Examination
     */
     public function exam_category(){
         $category_data = array('exam_id'=> trim($this->input->post('exam_id', TRUE)), 'category_id'=> trim($this->input->post('category_id', TRUE)));
         $url = array('body_id'=> trim($this->input->post('body_id', TRUE)));
        if($this->form_validation->run('exam_category')==TRUE){
            $count = array('exam_id'=>$category_data['exam_id'], 'category_id'=>$category_data['category_id']);
            $item_count = $this->examquestioncategories->data_count($count);
            if($item_count > 0){
                $this->session->set_flashdata('error_msg', 'This Exam/Category Combo already exists');
                redirect('admin/content/manage/exam/'.$url['body_id'].'/'.$category_data['exam_id'], 'refresh');
            }else{
                $this->examquestioncategories->insert($category_data);
                $this->session->set_flashdata('success_msg', 'Examination Questions successfully categorized');
                redirect('admin/content/manage/exam/'.$url['body_id'].'/'.$category_data['exam_id'], 'refresh');
            }
        }else{
            redirect('admin/content/manage/exam/'.$category_data['body_id'].'/'.$category_data['exam_id'], 'refresh');
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //METHOD FOR ADDING AND EDITING QUESTIONS IN THE DATABASE
    /**
     * For Saving Questions into the Database
     * @param int $body_id
     * @param mixed $exam_id
     * @param mixed $subject_id
     * @param mixed $period_id
     * @param mixed $category_id
     */
    public function questions($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum=null){
        //find existing questions
        if($qnum===null){$question = '';} 
        else {$question = $this->myquestions->exiting_questions($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum);}
        //set upload data
        $this->upload_config($body_id, $exam_id, $subject_id, $period_id);
        //set default value for file upload
        $image = array(); $check_file_upload = FALSE;
        if(isset($_FILES)){
            foreach($_FILES as $key => $value){
                if($value['name'] !='' && $value['error'] !=4){
                    $check_file_upload = TRUE;
                    $confirm_upload = !$this->upload->do_upload($key);
                    $image[$key] = $key;
                }
            }
        }
        if($this->form_validation->run('question')===FALSE || ($check_file_upload && $confirm_upload)){
            $this->load->view('layout/head');
            $this->load->view('admin/update/question', array('question'=>$question, 'qnum'=>$qnum,));
            $this->load->view('layout/footer');
        }else{
            //if form validation is true, insert or update questions
            $this->myquestions->check_update($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum, $image);
        }
    }
    
    private function upload_config($body_id, $exam_id, $subject_id, $period_id){
        //set the image path for images
        $path = 'assets/images/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id;
        if(!is_dir($path)){
            mkdir($path, 0777, TRUE);
        }
        $config =  Array(
            'upload_path' => $path,
            'allowed_types' => 'svg|svgz',
            'max_size' => 100, //in kilobytes
            'max_width' => 200, //in pixels
            'overwrite' => TRUE, //disable duplicate file uploads
        );
        $this->upload->initialize($config);
    }
}//end of Class