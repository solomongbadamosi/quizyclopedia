<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Myuser {
     
    private $CI;
    //private $config;
    // We'll use a constructor, as you can't directly call a function
        // from a property definition.
    function __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        //$this->config = $config;
        $this->CI->load->helper(array('form', 'authentication', 'user'));
        $this->CI->load->library(array('form_validation', 'session', 'email', 'mysubscription', 'user_agent'));
        $this->CI->load->model(array('mailverifications', 'users', 'referrals'));
    }
    
    /**
     * Run form validation and login user if credentials are correct
     */
    public function check_validation(){
        $cookie = $this->verify_cookie();
        //set captcha for loging in
        $this->CI->load->library('mycaptcha');
        //Filter the type of user to know what category they belong to
        $validation = filter_user();
        //Run Post Validation
        if($this->CI->form_validation->run($validation)==TRUE){
            //fetch User data from database
            $data = $this->fetch_user($validation);
            //verify captcha
            $this->CI->mycaptcha->verify();
            if($data AND $data['user_exist']===TRUE){
                //Check if user is penalised or banned
                $user = $data['user'];
                //get relevant table
                $table = $this->get_table($user);
                //check number of attempts made by user and penalize if allowed attempts exceeded
                $this->penalized_user($user);
                //verify password and set variable for session
               $this->_verify_password($user, $cookie, $table);
            }else{
               $this->CI->session->set_flashdata('error_msg', 'You are not a registered user, Please Sign Up');
               redirect('user/signup', 'refresh');
            }//End if user exists
        }//End if Form Validation is True
    }
    
    /**
     * Fetch a table according to user category
     * @param type $user
     * @return type
     */
    public function get_table($user){
        $pk = $this->CI->config->item('user_table_pk');//returns array of primary keys
        $table = $this->CI->config->item('user_tables');//returns array of tables
        $query_string = $table[$user->user_category];//return single table for user category
        $pk_string = $pk[$user->user_category];//return single pk for user category
        return (object)array('table_name'=>$query_string, 'pk'=>$pk_string);
    }
    /**
     * Check if a user cookie exist on the machine
     * if it does, return the cookie value
     */
    private function verify_cookie(){
        if($this->CI->input->cookie('my_user')!==NULL){
           return $this->CI->input->cookie('my_user');
        }else{
            //set cookie and return cookie value
            cookie();
            return $this->CI->input->cookie('my_user');
        }
    }
    
    
    /**
     * Get the user according to user category
     */
    private function fetch_user($validation){
        $data = array('user_exist'=>FALSE);
        if($validation=='login'){
            //User is an email user
            if(email_user()){
                $data['user'] = email_user();
                $data['user_exist'] = TRUE;
            }
        }elseif($validation=='referral'){
            //User is a Referral
            if(referral_user()){
                $data['user'] = referral_user();
                $data['user_exist'] = TRUE;
            }
        }
        return $data;
    }
    
    /**
     * Penalty for User whose login attempts failed more than five times
     * and Banning for being penalized for 3 times consecutively
     */
    private function penalized_user($user){
        //penalized user
        if($this->CI->session->tempdata($user->email)||$user->attempts > time()){
            //Shows code that user is on a penalty
            $remaining_time = $user->attempts - time();
            //calculate trial hour and penalize user for wrong attempts
            trial_hour_calculator($remaining_time);
            redirect('user/login', 'refresh');
        }elseif($user->banned == TRUE){//banned user
            //Shows code that user is on a BAN
            $this->CI->session->set_flashdata('error_msg', 'Sorry, Your Account has been suspended. Please Reset Password or contact an Adminstrator');
            redirect('home', 'refresh');
        }
    }
    
    /**
     * verify password, set session variable and check for multiple device login
     * @param type $user (either referral, public, admin and schools)
     */
    private function _verify_password($user, $cookie, $table){
        //identify user category and set session
        useridentity($user);
        //verify user password
        if(password_verify(trim($this->CI->input->post('password', TRUE)), $user->password)){
            //check if no verification is pending for the user
            $this->_pending_verification($user);
            //set session data
            set_session_value($user);
            //disallow multiple user devices
            $this->disallow_multiple_devices($user, $cookie, $table);
        }else{
            //mark the number of attempts on login by a user
            get_login_attempts($user, $table);
            //Information supplied by user is incorrect
            $this->CI->session->set_flashdata('error_msg', 'Username/Password Combination is incorrect');
        }
    }
    
    
    
    
    /**
     * check if a user has email verifications issue
     * @param type $user
     */
    private function _pending_verification($user){
        if($user){
            $issue = $this->CI->mailverifications->data_count(array('email'=>$user->email));
            if($issue > 0){
                $this->CI->session->set_flashdata('error_msg', 'You have a pending athentication process, '
                        . 'Please check your mail or Contact Admin');
                redirect('home');
            }
        }
    }
    
    /**
     * check if there is an active user or user is using another device
     * @param type $user (the current user)
     */
    private function disallow_multiple_devices($user, $cookie, $table){
        //set cookie in session
        $sess_cookie = array('cookie'=>$cookie);
        //see if the user did not log out from previous session or devices
        $this->CI->session->set_userdata($sess_cookie);
        if($user && $user->logged_in!=''){
            //check to see if cookie is set and confirm cookie value matches
            if($cookie===$user->cookie){
                //log the user in
                $this->perform_login($table);
                $this->check_user_type();
            }else{
                //Let user reverify password and log them out of other devices
                $time = $this->CI->users->verification_hash(time());
                $this->CI->session->set_userdata('time', $time);
                $this->CI->session->set_flashdata('error_msg', 'Ongoing Session or Active Device detected, please enter your password to continue');
                redirect('user/sess_reset/'.$this->CI->session->userdata('time'));
            }
        }else{
            $this->perform_login($table);
            $this->check_user_type();
        }
    }
    
    /**
     * change the active variable and unset session variable
     */
    public function logout_other_devices(){
        //get the relevant table and primary Key
        $table = get_user_table();
        $table_name = $table->table_name; $pk = $table->pk;
        //Get the password
        $user = $this->CI->$table_name->data_count(array($pk =>  $this->CI->session->userdata['identifier']), 'password')->row();
        if(password_verify(trim($this->CI->input->post('password', TRUE)), $user->password)){
            //change the logged_in time and set session variables
            $this->perform_login($table);$this->CI->session->unset_userdata('time');
            $this->CI->session->set_flashdata('success_msg', 'you have been logged out of other devices');
            $this->check_user_type();
        }else{
            $this->CI->session->set_flashdata('error_msg', 'Incorrect Password Provided');
            redirect('user/sess_reset/'.$this->CI->session->userdata('time'));
        }
    }
    
    /**
     * Carry out final activity of logging in a user
     * @param type $user (array)
     * @param type $data (array)
     */
    private function perform_login($table){
        //get the relevant table and primary Key
        $table_name = $table->table_name; $pk = $table->pk;
        //set session value in array
        $data = array();
        //set time in database as loggin value
        $items = array('last_seen'=>time(),'logged_in'=> $this->CI->users->verification_hash(time()), 'cookie'=> $this->CI->session->userdata('cookie'), 'pen_count'=>0);
        $this->CI->$table_name->update($items, $this->CI->session->userdata('identifier'));
        //get current user's login value and store in session
        $currently = $this->CI->$table_name->data_count(array($pk=>$this->CI->session->userdata('identifier')), 'logged_in')->row();
        //set the session variables to complete login process
        $data['loggedin'] = TRUE; 
        $data['active'] = $currently->logged_in;
        $this->CI->session->set_userdata($data);
    }
    
    /**
     * After checking subscription status, check the kind of user and redirect according to their 
     * category
     */
    public function check_user_type(){
        if($this->CI->session->user_category=='Author' || $this->CI->session->user_category=='Admin'){
            redirect('admin/content');
        }elseif($this->CI->session->user_category=='Public'){
            redirect('exam/user');
        }elseif($this->CI->session->user_category=='Referral'){
            //redirect to referral dashboard
            redirect('referral');
        }elseif($this->CI->session->user_category=='School'){
             //redirect to school dashboard
            redirect('school');
        }else{
            //return Users home
            $this->logout();
        }
    }
    
    /**
     * perform logout of a user
     */
    public function logout(){
        if($this->CI->session->userdata('user_category')!==NULL){
            $table = get_user_table();
            $table_name = $table->table_name;
            $this->CI->$table_name->update(array('logged_in'=>''), $this->CI->session->userdata('identifier'));
        }
        $this->CI->session->sess_destroy();
        redirect('home');
    }
    
    /**
     * Check if the user has subscribed
     */
    public function has_subscribed(){
        $this->CI->mysubscription->active_subscriber();
    }
    
    /**
     * Only logged in Users
     */
    public function confirm_login(){
        if($this->CI->session->loggedin==FALSE || $this->CI->session->active !== $this->active_user()){
            $this->logout();
        }
    }
    
    /**
     * fetch active user login info
     * @return type timestamp
     */
    private function active_user(){
        //fetch the login time from database
       $table = get_user_table();
       $table_name = $table->table_name; $pk = $table->pk;
       $active = $this->CI->$table_name->data_count(array($pk=>$this->CI->session->identifier), 'logged_in')->row();
       return $active->logged_in;
    }
    
    /**
     * check if the user agent is not a robot
     */
    public function is_not_robot(){
        if($this->CI->agent->is_robot()){
            redirect('google.com');
        }
    }
    
    
    /**
     * 
     * @return boolean
     * only Admins and Author is allowed 
     */
    public function has_permission(){
        //check if the user is not a robot
        $this->is_not_robot();
        //grant permission to admin and author
        $permitted_users = array('Author', 'Admin');
        return (bool)in_array($this->CI->session->user_category, $permitted_users);
    }
    
    /**
     * only Author and Public can practice
     */
    public function can_practice(){
        //check if the user is not a robot
        $this->is_not_robot();
        //only the author and public can practice
        $array = array('Public', 'Author');
        if((!in_array($this->CI->session->user_category, $array))){
            $this->check_user_type();
        }
    }
    
    
    /**
     * only referral has access
     */
    public function is_referral(){
        $array = array('Referral');
        if((!in_array($this->CI->session->user_category, $array))){
            $this->check_user_type();
        }
    }
    
    /**
     * only schools has access
     */
    public function is_school(){
        $array = array('School');
        if((!in_array($this->CI->session->user_category, $array))){
            $this->check_user_type();
        }
    }
    
    
     /**
     * only Author has right to do 
     */
    public function has_right(){
        $CI = & get_instance();
        if($CI->session->userdata('user_category')!=='Author'){
            $this->check_user_type();
        }
    }
    
    /**
     * for receiving Email from users
     */
    public function sendmail(){
        $this->CI->email->from('info@quizyclopedia.com', $this->CI->input->post('name', TRUE));
        $this->CI->email->to('quizyclopedia@gmail.com');
        $this->CI->email->subject('User Request/Complain: '.$this->CI->input->post('phone'));
        $this->CI->email->message(htmlspecialchars($this->CI->input->post('message', TRUE))
                .'<p>from: <strong>'.$this->CI->input->post('email', TRUE).'</strong></p>');
        $this->CI->email->send();
        $this->CI->session->set_flashdata('success_msg', 'Your message was successfully sent! We shall get back to you shortly');
        redirect('home');
    }
}//End of Class