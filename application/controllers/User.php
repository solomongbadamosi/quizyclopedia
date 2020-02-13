<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
   
    
    function __construct() {
       parent::__construct();
       $this->load->library(array('myuser', 'myvalidation', 'mysubscription', 'mycaptcha'));
       $this->load->helper(array('form'));
       $this->load->model(array('referrals', 'schools'));
   }
   
   /**
    * Call to Logout user
    */
   public function logout(){
       $this->myuser->logout();
   }   
   
   /**
    * the main method for login in
    * this method calls many methods from Users database and other libraries
    */
    public function login(){
        //check if User is not already logged in
        if($this->loggedin()===FALSE){
            //carry out the login process
            $this->myuser->check_validation();
            //create captcha
            $cap = $this->mycaptcha->establish_captcha();
            //load the login view
            $this->load->view('layout/head');
            $this->load->view('home/login', array('cap'=>$cap));
            $this->load->view('layout/footer');
        }elseif($this->session->loggedin){
            //redirect user according to their type
            $this->myuser->check_user_type();
	}
    }
    
    /**
     * check if the user is logged in already
     * @return type bool
     */
    private function loggedin(){
        return (bool) $this->session->loggedin;
    }
    
    /**
     * Prevent more than one user at a time
     * @param type $time
     */
    public function sess_reset($time){
        if($this->session->userdata['time'] === $time){
            if($this->form_validation->run('active')===TRUE){
                $this->myuser->logout_other_devices();
            }else{
                $this->load->view('layout/head');
                $this->load->view('home/active');
                $this->load->view('layout/footer');
            }
        }else{
            show_404();
        }
    }
    
    
    /**
     * parameters are submitted values from post
     */
    public function signup($continue = NULL){
        if($continue===NULL){
            unset($_SESSION['signup_info']);
             if($this->form_validation->run('signup')==TRUE){
                 $data = $this->signup_data();
                 //verify captcha
                 $this->mycaptcha->verify();
                 //check if user exist else continue
                 $this->user_exists($data);
             }else{
                 $this->signup_view();
             }
        }else{
            $this->signup_continue();
        }
     }
     
     /**
      * check if the user is existing or proceed with login info
      * @param array $data (post data of user)
      */
     private function user_exists($data){
         $count = array('email' => $data['email']);
         if($this->users->data_count($count) > 0){
            $this->session->set_flashdata('error_msg', 'A user with this Username/Email already exists');
            $this->signup_view();
        }else{
           //store value in session
           $_SESSION['signup_info'] = $data;
           redirect('user/signup/continue');
        }
     }
     
     private function signup_continue(){
         if($this->input->post('continue')){
                $_SESSION['signup_info']['school_id'] = htmlspecialchars(trim($this->input->post('school', TRUE)));
                $_SESSION['signup_info']['induction'] =time();
                //generate an identification code for user
                $value = array('email'=>$_SESSION['signup_info']['email'], 'code'=> $this->users->verification_hash(time()));
                //Load User information in the database
                $this->users->insert($_SESSION['signup_info']);
                //insert value to validations table
                $this->mailverifications->insert($value);
                //send verification mail to user
                $data = $_SESSION['signup_info'];
                $this->mail_verification($data);
                unset($_SESSION['signup_info']);
                $this->session->set_flashdata('success_msg', 'Congratulations! Please verify your E-mail Address. <br /> Check Your Spam Messages if not found');
                redirect('home', 'refresh');
            }else{
                //get the registered schools under the selected referral
                if(isset($_SESSION['signup_info'])){
                    $where = array('ref_id'=>$_SESSION['signup_info']['referral']);
                    $sch = $this->schools->data_count($where, 'sch_id, name')->result();
                }else{
                    $sch = array();
                }
                $this->continuation_view($sch);
            }
     }
     
     /**
      * view for choosing school name
      * @param array $sch
      */
     private function continuation_view($sch){
          //load the view for selecting a school
        $this->load->view('layout/head');
        $this->load->view('home/sch_signup', array('schools'=>$sch));
        $this->load->view('layout/footer');
     }
     /**
      * View loader for sign up page
      */
     private function signup_view(){
        //create captcha
        $cap = $this->mycaptcha->establish_captcha();
        //Get available refferals
        $referrals = $this->referrals->data_count('', 'user_name, first_name, last_name')->result();
        $this->load->view('layout/head');
        $this->load->view('home/signup', array('referrals'=>$referrals, 'cap'=>$cap));
        $this->load->view('layout/footer');
     }
    
     /**
      * Post information from signup form
      * @return type array()
      */
     private function signup_data(){
         $data = array(
                 'password' => htmlspecialchars($this->users->hash(trim($this->input->post('password', TRUE)))),
                 'confirm_password' => htmlspecialchars($this->users->hash(trim($this->input->post('confirm_password', TRUE)))), 
                 'email' => htmlspecialchars(trim($this->input->post('email', TRUE))),
                 'first_name' => htmlspecialchars(trim($this->input->post('first_name', TRUE))), 
                 'last_name' => htmlspecialchars(trim($this->input->post('last_name', TRUE))),
                 'referral' =>  htmlspecialchars(trim($this->input->post('referral', TRUE))),
                 'phone' =>  htmlspecialchars(trim($this->input->post('phone', TRUE))),
        );
         return ($data);
     }
     
     /**
      * for carrying out subscription activity for users
      */
     public function subscribe($time=NULL){
         if(isset($this->session->post)){
             $this->session->unset_userdata('post');
         }
         if($this->session->time AND $time===$this->session->time){
             //Validate and run Subscription
            validate_subscription($time);
            //Load Form Page
            $this->load->view('layout/head');
            $this->load->view('home/subscribe');
            $this->load->view('layout/footer');
         }else{
             show_404();
         }
     }
     
     public function subexists(){
         $post_data = $this->session->post;
         //Validate and Run subscription
         validate_subscription($this->session->time);
         //Load View
         if($this->input->post('cancel')){
             clear_existing_reference();
             redirect('user/subscribe/'.$this->session->time);
         }
         $this->load->view('home/confirm_subscription', array('post'=>$post_data));
     }
     
     /**
      * Send email verification
      */
     private function mail_verification ($data){
        $mail = array('email'=>$data['email']);
        $user = $this->users->data_count($mail, 'user_id, first_name')->row();
        $code = $this->mailverifications->data_count($mail, 'code')->row();
        $this->email->from('no-reply@quizyclopedia.com', 'Quizyclopedia');
        $this->email->to($data['email']);
        $this->email->subject('Account Verification');
        //message
        $message = $this->load->view('layout/email/activate', array('user'=>$user, 'code'=>$code), TRUE);
        $this->email->message($message);

        $this->email->send();
    }
    
	/**
         * call method to confirm email or reset user password
         */
    public function mail_validation($code, $id){
        //check if user exists
        $user_id = array('user_id'=>$id); $new_status = array('status'=>'1');
        $user_exists = $this->users->data_count($user_id, 'first_name, status, email')->row();
        if(!$user_exists){
            //load 404 error page
            show_404();
        }
        $mail = array('email'=>$user_exists->email);
        $user_waiting = $this->mailverifications->data_count($mail, 'code')->row();
        if($user_exists  && $user_waiting){
            if($user_waiting->code===$code){
                $this->validate_code($user_exists, $new_status, $code, $id);
            }
        }else{
            //link does not exist or has expired
            $this->session->set_flashdata('error_msg', 'OOPS! False or Expired Link');
            redirect('home');
        }
    }
    /**
     * for email validation and password reset
     * @param type $user_exists
     */
    private function validate_code($user_exists, $new_status, $code, $id){
        if($user_exists->status==='0'){
            //update the user's status and delete details from mailverifications table
            $this->users->update($new_status, $user_exists->email);
            $this->mailverifications->delete($user_exists->email);
            $this->session->set_flashdata('success_msg', 'Congratulations '.$user_exists->first_name.', Your account is Activated Successfully!!!');
            redirect('home', 'refresh');
        }else{
            //password reset
            redirect('user/passwrd_reset/'.$code.'/'.$id);
        }
    }
	
    /**
     * Method for sending Password code and resetting password
     * @param mixed $code (hash code sent to user)
     * @param int $id (user unique identification)
     * 
     */
    public function passwrd_reset($code=NULL, $id=NULL){
        if($code===NULL && $id===NULL){
            if($this->form_validation->run('email')=== FALSE){
                //display form for user to enter their registered email
                $this->myvalidation->p_wrd_reset_view();
            }else{
                $this->myvalidation->send_validation();
            }
        }else{
            //check if user exists
            $user_exists = fetch_user($id);
            if($user_exists===NULL){
                //load 404 error page
                show_404();
            }else{
               $this->myvalidation->change_password($user_exists, $code);
            }
        }
    }
    
    /**
     * Verification for user subscription status
     */
    public function authorize_subscription(){
        $this->mysubscription->verify();
    }
    
    /**
     * redirect users based on user category
     */
    public function check(){
        $this->myuser->check_user_type();
    }
}