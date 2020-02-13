<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
        * Check to see if User is logged in
        * confirm if logged in User has subscribed
        * if logged in User has not subscribed redirect to subscription page
        * control for Reading Examination Content
        */   

    class Question extends My_Controller {

        function __construct() {
            parent::__construct();
            $this->load->library(array('myurl', 'myuser', 'pagination'));
            $this->load->helper(array('form'));
            $this->load->model(array('examtimers', 'examinations', 'examsubjects', 'examperiods', 'examsubjectperiods', 'questions', 'timers', 
                'instructions', 'instructiondiagrams', 'questiondiagrams', 'options', 'references', 'refdiagrams'));
            $this->myuser->confirm_login();
            $this->myuser->is_referral();
            
        }
        
        
        /**
         * A method that calls the examination page
         * @param int $body_id
         * @param var $exam_id
         * @param var $subject_id
         * @param var $period_id
         * @param var $cat_id
         * @param in $qnum
         */

        public function practice ($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum){
                //unset the start variable from session
            if($this->input->post('start')){
               unset ($_SESSION['score']);
               $start = array('options'=>array());
               $this->session->set_userdata($start);
            }
            $time_where = $this->time_where(2, 'NCEE', 'QTR');
            $time = $this->examtimers->get_time($time_where)->row();
            //Get Questions from Database
            $question = $this->question_data(2, 'NCEE', 'QTR', 'YrK15', 'OBJ', $qnum);
            $count_array = array('body_id'=>2, 'exam_id'=>'NCEE', 'subject_id'=>'QTR', 'period_id'=>'YrK15', 'category_id'=>'OBJ');
            //Get the total number of Questions available
            $total = $this->questions->data_count($count_array, 'question_number')->num_rows();
            $this->process($body_id, $exam_id, $subject_id, $period_id, $cat_id, $total);
            $this->load->view('layout/head');
            $this->load->view('exam/referrals/sample', array('question'=>$question, 'count'=>$total, 'time'=>$time));
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
        private function process($body_id, $exam_id, $subject_id, $period_id, $cat_id){
            $current = $this->uri->segment(10);
            //set next variable
            $next = $current + 1;
            //User has made a choice
            if($this->input->post()){
                //store post variable and filter out the post already picked by user
                $post = $this->input->post();
                /**
                 * filter the post data and delete the existing one in post
                 * ensure that user is not selecting more than one option
                 */
                if ($this->options_check($post, $body_id, $exam_id, $subject_id, $period_id, $cat_id, $current) == TRUE){
                    $option = $this->options_check($post, $body_id, $exam_id, $subject_id, $period_id, $cat_id, $current);
                  $this->set_session_data($option);
                }
                /**
                 * if the post for a next button, exam is still on,
                 * so redirect to next question
                 */
                if($this->input->post('next')){
                    redirect('sample/content/question/practice/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id.'/'.$next);
                }elseif($this->input->post('submit')){
                    /**
                     * User is done writing the test
                     * redirect to result page
                     */
                $this->session->set_flashdata('success_msg', 'Congratulations! '.$this->session->first_name. ', you did your best');
                redirect('sample/content/result/performance/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id);
                }
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
        
        
        /**
         * set user's choices in session
         */
        private function set_session_data($post){
            //get all post data in an array
            $sent_data = array();
            //make the keys of the data its value
            foreach($post as $key => $value){
                $sent_data[$key]=$key;
                $value = $value;
            }
            //set the user's choice in an array
            $user_choice = '';
            if(preg_grep ('/option/', $sent_data)){
                $choice = preg_grep ('/option/', $sent_data);
                foreach($choice as $chosen => $chosen_value){
                    $user_choice = $chosen_value;
                    $chosen = $chosen;
                }
            }
            //set session variable
            $_SESSION['options']['question'.trim($this->input->post('qnum', TRUE))] = $user_choice;
        }
        
        /**
         * 
         * check to ensure not more than one option is posted
         * @param type $post
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         * @param type $cat_id
         * @param type $current
         * @return boolean
         */
        private function options_check($post, $body_id, $exam_id, $subject_id, $period_id, $cat_id, $current){
            $selection = array();
            foreach($post as $key => $val) {
                if(preg_match('/option/',$key)){
                    $selection[$key] = $val;
                }
            }
            if($this->filter_post($current, $selection)!==NULL){
                $filtered_post = $this->filter_post($current, $selection);
            }else{
                $filtered_post = $selection;
            }
            if (count($filtered_post)>1){
                $this->session->set_flashdata('error_msg', 'You cannot select more than one Option');
                redirect('sample/content/question/practice/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id.'/'.$current);
                return FALSE;
            }else{
                return $filtered_post;
            }
        }
        
        /**
         * Delete the previously session value from post
         * @param type $current
         * @param type $post
         */
        private function filter_post($current, $post){
            if(isset($_SESSION['options']['question'.$current])){
                if(array_key_exists($this->session->userdata('options')['question'.$current], $post)){
                    unset ($post[$this->session->userdata('options')['question'.$current]]);
                        return $post;
                }
            }
        }
}//End of Class