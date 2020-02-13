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
            $this->myuser->confirm_login();
            if($this->myuser->can_practice()){
                $this->myuser->has_subscribed();
            }
            $this->load->model(array('examtimers', 'examinations', 'examsubjects', 'examperiods', 'examsubjectperiods', 'questions', 'timers', 
                'instructions', 'instructiondiagrams', 'questiondiagrams', 'options', 'references', 'refdiagrams'));
        }
    
        /**
         * 
         * @param type $body_id
         * @param type $exam_id
         * @param type $offset
         * Displays the various subjects and years of examination available
         */
        public function subject($body_id, $exam_id, $offset=0){
            $this->pagination();
            $count = array('exam_id'=>$exam_id);
            $config['total_rows']= $this->examsubjects->data_count($count); $config['base_url']= base_url('exam/content/question/subject/'.$body_id.'/'.$exam_id); $config['per_page']=6; //$config['uri_segment'] = 5;
            //pull existing records from database
            $subjects_set = $this->examsubjects->find_exam_subjects($exam_id, 6, $offset);
            $this->pagination->initialize($config);
            $pagination_data['pages']=$this->pagination->create_links();
            $this->load->view('layout/head');
            //check if it is special exam or not
            $this->view_special_exams($exam_id, $subjects_set, $pagination_data);
            $this->load->view('layout/footer');
        }
        
        //view page for JAMB
        private function view_special_exams($exam_id, $subjects_set, $pagination_data){
            if($exam_id==='JAMB'){
                //check validation and redirect to examination page
               $this->form_validation->set_rules('submit', 'Start Examination', 'callback_check_selection');
               if ($this->form_validation->run() == FALSE){
                   $this->jamb_simulation_process($exam_id, $pagination_data, $subjects_set);
               }else{
                   redirect('exam/content/practice/jamb');
               }
            }else{
                $this->load->view('exam/subject', array('subjects_set'=> $subjects_set, 'pagination_data'=>$pagination_data));
            }
        }
        
        //load views for jamb simulation process
        private function jamb_simulation_process($exam_id, $pagination_data, $subjects_set){
            $exam_periods = NULL;
            if(!$this->input->get()){
                $this->load->view('exam/special/jamb');
            }elseif($this->input->get('simulator', 'simulator')){
                $subjects_set = $this->examsubjects->find_exam_subjects($exam_id)->result();
                $this->load->view('exam/special/jamb_simulator', array('subjects'=>$subjects_set, 'exam_periods'=>$exam_periods));
            }else{
                $this->load->view('exam/subject', array('subjects_set'=> $subjects_set, 'pagination_data'=>$pagination_data, 'exam_periods'=>$exam_periods));
            }
        }
        
        /**
         * 
         * @param type $body_id
         * @param type $exam_id
         * @param type $subject_id
         * @param type $period_id
         */
        public function category($body_id, $exam_id, $subject_id, $period_id){
          	//Get the Time for Examination
            $where = $this->time_where($body_id, $exam_id, $subject_id);
            $time = $this->examtimers->get_time($where)->row();
          	//Get the Categories available for examination
            $categories = $this->questionscategories->find_exam_category($exam_id)->result();
          	//If it is General Assessment, Get the total number of questions in database
          	$count_array = array('body_id'=>$body_id, 'exam_id'=>$exam_id, 'subject_id'=>$subject_id, 'period_id'=>$period_id, 'category_id'=>'OBJ');
            $total = $this->questions->data_count($count_array, 'question_number')->num_rows();
          	//Load View
            $this->load->view('layout/head');
            $this->load->view('exam/category', array('categories'=>$categories, 'time'=>$time, $period_id, 'count'=>$total));
            $this->load->view('layout/footer');
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
            if($this->input->post('start')){
                //unset the start variable from session
               unset ($_SESSION['score']);
               $start = array('start'=>1, 'options'=>array(), 'combo'=>array($body_id, $exam_id, $subject_id, $period_id, $cat_id));
               $this->session->set_userdata($start);
            }
            $time_where = $this->time_where($body_id, $exam_id, $subject_id);
            $time = $this->examtimers->get_time($time_where)->row();
            //set default time for General Questions
            if($body_id==5){$time = 1;}
            //Get Questions from Database
            $question = $this->question_data($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum);
            $count_array = array('body_id'=>$body_id, 'exam_id'=>$exam_id, 'subject_id'=>$subject_id, 'period_id'=>$period_id, 'category_id'=>$cat_id);
            //Get the total number of Questions available
            $total = $this->questions->data_count($count_array, 'question_number')->num_rows();
            $this->process($body_id, $exam_id, $subject_id, $period_id, $cat_id, $total);
            //get the URL combinations
            $combo = array($body_id, $exam_id, $subject_id, $period_id, $cat_id);
            //load View
            $this->practice_view($combo, $question, $total, $time, $qnum);
                    
        }
        /**
         * Views for questions
         * @param type $combo
         * @param type $question
         * @param type $total
         * @param type $time
         * @param type $qnum
         */
        private function practice_view($combo, $question, $total, $time, $qnum){
            if(isset($_SESSION['combo']) AND empty(array_diff($_SESSION['combo'], $combo))){
                $this->load->view('layout/head');
                $this->load->view('exam/practice', array('question'=>$question, 'count'=>$total, 'time'=>$time));
                $this->load->view('layout/footer');
            }elseif(isset($_SESSION['combo']) AND !empty(array_diff($_SESSION['combo'], $combo))){
                $this->session->set_flashdata('error_msg', $this->session->first_name. ', cheating is not the best for you!!!');
                redirect('exam/content/question/practice/'.$_SESSION['combo'][0].'/'.$_SESSION['combo'][1].'/'.$_SESSION['combo'][2].'/'.$_SESSION['combo'][3].'/'.$_SESSION['combo'][4].'/'.$qnum);
            }
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
        private function process($body_id, $exam_id, $subject_id, $period_id, $cat_id, $total){
            $current = $this->uri->segment(10);
            //set next variable
            if($this->myurl->selected_item()->current_body->body_name==='General Assessment'){
                $next = rand(1, $total);
            }else{$next = $current + 1;}
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
                    redirect('exam/content/question/practice/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id.'/'.$next);
                }elseif($this->input->post('submit')){
                    /**
                     * User is done writing the test
                     * redirect to result page
                     */
                $this->session->set_flashdata('success_msg', 'Congratulations! '.$this->session->first_name. ', you did your best');
                redirect('exam/content/result/performance/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id);
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
        
        //validation callback for JAMB
        public function check_selection(){
            if (count($this->input->post())!==5){
                    $this->form_validation->set_message('check_selection');
                    $this->session->set_flashdata('error_msg', 'You must select not More or Less than 3 Additional Subjects');
                    redirect('exam/content/question/subject/4/JAMB?simulator=simulator');
                    return FALSE;
            }else{
                $this->set_jamb_in_session();
                return TRUE;
            }
        }
        
        //set session variables for JAMB
        private function set_jamb_in_session(){
            //set the subjects as array
            $subjects = array('ENG'=>array());
            $post = $this->input->post();
            foreach($post as $id=>$name){
                $name = array();
                    if($id!=='submit' && $id!=='period_id'){
                    $subjects[$id] = $name;
                }
            }
            //Set Examination period in session
            if($post['period_id']!=='default'){
                $_SESSION['period']=$post['period_id'];
            }else{
                $this->session->set_flashdata('error_msg', 'Please Select an Examination Year');
                redirect('exam/content/question/subject/4/JAMB?simulator=simulator');
            }
            $_SESSION['subjects'] = $subjects;
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
                redirect('exam/content/question/practice/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$cat_id.'/'.$current);
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