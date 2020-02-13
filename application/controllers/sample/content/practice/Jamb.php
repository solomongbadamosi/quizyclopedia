<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User has subscribed
        * if logged in User has not subscribed redirect to subscription page
        * control for Reading Examination Content
        */   

    class Jamb extends My_Controller {

 
        function __construct() {
            parent::__construct();
            $this->load->library(array('myurl', 'myuser', 'pagination'));
            $this->load->helper(array('form'));
            $this->myuser->confirm_login();
            if($this->myuser->can_practice()){
                $this->myuser->has_subscribed();
            }
            $this->load->model(array('examtimers', 'examinations', 'examsubjects', 'examperiods', 'periodsubjects', 'questions', 'timers', 
                'instructions', 'instructiondiagrams', 'questiondiagrams', 'options', 'references', 'refdiagrams'));
        }
        
        public function index(){
            $combination = array();
            $exams = $_SESSION['subjects'];
            foreach($exams as $subject_id => $data_type){
                $where_subject = array('subject_id'=>$subject_id);
                $where_count = array('body_id'=>4, 'exam_id'=>'JAMB', 'subject_id'=>$subject_id, 'period_id'=>$_SESSION['period'], 'category_id'=>'OBJ');
                //count the number of questions
                $_SESSION['subjects'][$subject_id]['count'] = $this->questions->data_count($where_count, 'question_number')->num_rows();
                //Get Subject combinations
                $combination[$subject_id] = $this->subjects->find_where($where_subject)->row();
            }
            $_SESSION['combination'] = $combination;
            //count the number of questions in english
            $period = $this->periods->find_where(array('period_id'=>$_SESSION['period']))->row();
            $time = 2;
            if($_SESSION['subjects']['ENG']['count'] > 60){
                //time is 3 hours
                $time = 3;
            }
            $_SESSION['exam_time'] = $time;
            $this->load->view('layout/head');
            $this->load->view('exam/special/practice/jamb_prep', array($data_type, 'year'=>$period));
            $this->load->view('layout/footer');
        }
        
        
        
        //public function practice ($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum){
        public function question ($subject_id, $qnum){
            //check if the question queried is in session
            if(!isset($_SESSION['subjects'][$this->uri->segment(6)])){
                $this->session->set_flashdata('error_msg', 'You are not Allowed to Cheat, Please!');
                redirect('/exam/content/practice/jamb');
            }
            if($this->input->post('start')){
                //unset the score variable from session
               unset ($_SESSION['score']);
               $start = array('start'=>1);
               $this->session->set_userdata($start);
            }
            $time = $_SESSION['exam_time'];
            //GET QUESTIONS AND CURRENT SUBJECT FROM DATABASE
            $where_subject = array('subject_id'=>$subject_id);
            $current_subject = $this->subjects->find_where($where_subject)->row();
            $question = $this->question_data(4, 'JAMB', $subject_id, $_SESSION['period'], 'OBJ', $qnum);
            //Examination process
            $this->process($subject_id);
            $this->load->view('layout/head');
            $this->load->view('exam/special/practice/jamb', array('question'=>$question, 'time'=>$time, 'current_subject'=>$current_subject));
            $this->load->view('layout/footer');
        }
        
        
        /**
         * sub function for processing post and getting scores
         * @param int $body_id
         * @param var $exam_id
         * @param var $subject_id
         * @param var $period_id
         * @param var $cat_id
         * @param int $total
         */
        private function process($subject_id){
            $sub_id = array();
            foreach($_SESSION['subjects'] as $key=>$value){
                $sub_id[$key]=$key;
            }
            $current = $this->uri->segment(7);
            $next = $current + 1;
            //set session data if submit button is clicked
            if($this->input->post('next')){
                //Redirect to next subject
                $this->next_subject($subject_id, $sub_id, $current);
                
                //redirect to next question
                $_SESSION['subjects'][$subject_id]['question'.$this->security->xss_clean(trim($this->input->post('qnum')))] = $this->security->xss_clean(trim($this->input->post('option')));
                redirect('exam/content/practice/jamb/question/'.$subject_id.'/'.$next);
                
            }elseif($this->input->post('submit')){
                //user is done writing the test
                //set session variable and redirect to result page
                $_SESSION['subjects'][$subject_id]['question'.$this->security->xss_clean(trim($this->input->post('qnum')))] = $this->security->xss_clean(trim($this->input->post('option')));
                $this->session->set_flashdata('success_msg', 'Congratulations! '.$this->session->first_name. ', you did your best');
                redirect('exam/content/practice/jamb/performance/ENG');
            }
        }
        
        /**
         * Redirect user to next subject
         * @param type $subject_id
         * @param type $sub_id
         * @param type $current
         */
        private function next_subject($subject_id, $sub_id, $current){
            if($current == $_SESSION['subjects'][$subject_id]['count']){
                $current_key = key($sub_id);
                while ($current_key !== null && $current_key != $subject_id) {
                    next($sub_id);
                    $current_key = key($sub_id);
                    }
                $next_subject = next($sub_id);
                if($current_key=== end($sub_id)){
                    $next_subject = 'ENG';
                }
                //redirect to next subject
                //Add the user's choice to session before redirecting
                $_SESSION['subjects'][$subject_id]['question'.$this->security->xss_clean(trim($this->input->post('qnum')))] = $this->security->xss_clean(trim($this->input->post('option')));
                redirect('exam/content/practice/jamb/question/'.$next_subject.'/1');
            }
        }
        
        private function question_data($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum){
            return $data = (object)array(
                'question' => $this->questions->read($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum, 'question, question_number'),
                'q_diagram' => $this->questiondiagrams->read($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum, 'image'),
                'inst' => $this->instructions->read($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum, 'instruction'),
                'inst_diagram' => $this->instructiondiagrams->read($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum, 'image'),
                'option' => $this->options->read($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum, 'A, B, C, D, E,'),
            );
        }
        
        public function performance($subject_id){
            unset($_SESSION['start']);
            $where = array('body_id'=>4, 'exam_id'=>'JAMB', 'subject_id'=>$subject_id, 'period_id'=>$_SESSION['period'], 'category_id'=>'OBJ');
            $question = $this->questions->data_count($where, 'question, question_number');
            //count the number of questions available
            $count = $this->questions->count($where);
            //load view for checking comparing performance against answers
            $this->load->view('layout/head');
            $this->load->view('exam/special/practice/jamb_performance', array('requirement'=>$question, 'count'=>$count, 'where'=>$where));
            $this->load->view('layout/footer');
            //check if post exist
            if($this->input->post('another_subject')){
                $this->reset();
                redirect('exam/content/question/subject/4/JAMB');
            }
        }
        
        /**
         * redirect to the beginning of the just concluded test
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         * @param type $cat_id
         */
        private function reset(){
            unset($_SESSION['subjects']);
            unset($_SESSION['period']);
            unset($_SESSION['exam_time']);
            unset($_SESSION['combination']);
        }
        
        public function no_back(){
            $this->reset();
            redirect('exam/content/home');
        }
    }
