<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User has subscribed
        * if logged in User has not subscribed redirect to subscription page
        * control for Reading Examination Content
        */   

    class Result extends My_Controller {
        
        function __construct() {
            parent::__construct();
            $this->load->library(array('upload', 'myuser', 'myurl', 'Mypdf'));
            $this->load->helper(array('form'));
            $this->load->model(array('questions', 'options', 'references', 'refdiagrams', 'questiondiagrams', 'periods'));
            $this->myuser->confirm_login();
            $this->myuser->is_referral();
            
        }
        
        public function index(){
            $score = $_SESSION['score'];
            $this->load->view('layout/head');
            $this->load->view('exam/result', array('score'=>$score));
            $this->load->view('layout/footer');
            unset($_SESSION['score']);
        }
        
        /**
         * 
         * @param int $body_id
         * @param mixed $exam_id
         * @param mixed $subject_id
         * @param mixed $period_id
         * @param mixed $cat_id
         */
        public function performance($body_id, $exam_id, $subject_id, $period_id, $cat_id){
            unset($_SESSION['start']);
            $where = array('body_id'=>$body_id, 'exam_id'=>$exam_id, 'subject_id'=>$subject_id, 'period_id'=>$period_id, 'category_id'=>$cat_id);
            $question = $this->questions->data_count($where, 'question, question_number');
            //count the number of questions available
            $count = $this->questions->count($where);
            //load view for checking comparing performance against answers
            $this->load->view('layout/head');
            if($this->input->get('set')===NULL){
                $this->load->view('exam/performance', array('requirement'=>$question, 'count'=>$count, 'where'=>$where));
            }else{
                //Download Result in pdf format
                $this->download_pdf(2, 'NCEE', 'QTR', 'YrK15', 'OBJ');
            }
            //Load Views
            $this->load->view('layout/footer');
            //Choose another subject or take examination again
            $this->reset_rewrite($body_id, $exam_id, $subject_id, $period_id, $cat_id);
        }//end performance method
        
        /**
         * redirect to the beginning of the just concluded test
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         * @param type $cat_id
         */
        private function reset(){
            unset($_SESSION['options']);
        }
        
        /**
         * prevents the back button after submission
         */
        public function no_back(){
            $this->reset();
            redirect('referral');
        }
        
        
        /**
         * Set User Information and Download Pdf format
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         * @param type $cat_id
         */
        private function download_pdf($body_id, $exam_id, $subject_id, $period_id, $cat_id){
            if($this->form_validation->run('result')==TRUE){
                $data = array();
                $data['name'] = htmlspecialchars($this->input->post('last_name', TRUE)).' '.
                                htmlspecialchars($this->input->post('first_name', TRUE));
                $data['school'] = htmlspecialchars($this->input->post('sch_name', TRUE));
                $data['examination'] = $exam_id;
                $year = $this->periods->data_count(array('period_id'=>$period_id), 'period_name')->row();
                $subject = $this->subjects->data_count(array('subject_id'=>$subject_id), 'subject_name')->row();
                $data['year'] = $year->period_name;
                $data['subject'] = $subject->subject_name;
                $content = $this->load->view('exam/pdf_result', $data, TRUE);
                
                $this->mypdf->loadHTML($content);
                $this->mypdf->render();
                $this->mypdf->stream($data['name'], array('attachment'=>1));
            }else{
                $this->load->view('exam/download_result');
            }
            $this->reset_rewrite($body_id, $exam_id, $subject_id, $period_id, $cat_id);
        }
        
        /**
         * Take examination again or Choose another Subject
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         * @param type $cat_id
         */
        private function reset_rewrite($body_id, $exam_id, $subject_id, $period_id, $cat_id){
            if($this->input->post('reset')){
                $start = array('start'=>1);
                $this->session->set_userdata($start);
                $this->reset();
                redirect('sample/content/question/practice/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id.'/1');
            }elseif($this->input->post('another')){
                $this->reset();
                redirect('sample/content/question/subject/'.$body_id.'/'.$exam_id);
            }elseif($this->input->post('go_home')){
                $this->no_back();
            }
        }
}//End of Class