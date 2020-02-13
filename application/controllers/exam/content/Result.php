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
            $this->load->model(array('questions', 'options', 'references', 'refdiagrams', 'questiondiagrams', 'periods'));
            $this->load->library(array('upload', 'myuser', 'myurl', 'Mypdf'));
            $this->load->helper('form');
            $this->myuser->confirm_login();
            if($this->myuser->can_practice()){
                $this->myuser->has_subscribed();
            }
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
            if($body_id==5){$count = 60;
            }else{$count = $this->questions->count($where);
            }
            //Load Views
            $this->load->view('layout/head');
            $this->load->view('exam/performance', array('requirement'=>$question, 'count'=>$count, 'where'=>$where));
            $this->load->view('layout/footer');
            //Download Result in pdf format
            $this->download_pdf($subject_id);
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
            redirect('exam/content/home');
        }
        
        /**
         * Viewing Theory Answers and explanations
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         * @param type $qnum
         */
        public function essay($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum){
            //for viewing theory answers
            $where = $this->solution_where($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum);
            $solution = $this->references->find_where($where)->row();
            $solution_diagram = $this->refdiagrams->find_where($where)->row();
            $this->load->view('layout/head');
            $this->load->view('exam/theory_solution', array('solution'=>$solution, 'solution_diagram'=>$solution_diagram));
            $this->load->view('layout/footer');
        }
        
        /**
         * Set User Information and Download Pdf format
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         * @param type $cat_id
         */
        private function download_pdf($subject_id){
            if($this->form_validation->run('result')==TRUE){
                $data = array();
                $data['name'] = htmlspecialchars($this->input->post('last_name', TRUE)).' '.
                        htmlspecialchars($this->input->post('first_name', TRUE));
                $data['school'] = htmlspecialchars($this->input->post('sch_name', TRUE));
                $data['examination'] = $this->uri->segment(6);
                $year = $this->periods->data_count(array('period_id'=>$this->uri->segment(8)), 'period_name')->row();
                $subject = $this->subjects->data_count(array('subject_id'=>$subject_id), 'subject_name')->row();
                $data['year'] = $year->period_name;
                $data['subject'] = $subject->subject_name;
                $content = $this->load->view('exam/pdf_result', $data, TRUE);
                
                $this->mypdf->loadHTML($content);
                $this->mypdf->render();
                $this->mypdf->stream($data['name'], array('attachment'=>1), 0);
            }
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
                redirect('exam/content/question/practice/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id.'/1');
            }elseif($this->input->post('another_subject')){
                $this->reset();
                unset($_SESSION['combo']);
                redirect('exam/content/question/subject/'.$body_id.'/'.$exam_id);
            }elseif($this->input->post('another_exam')){
                $this->reset();
                unset($_SESSION['combo']);
                redirect('exam/content/home');
            }
        }
}//End of Class