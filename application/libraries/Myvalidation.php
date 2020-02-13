<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myvalidation {
    //create ancillary class with $ci
     protected $CI;
    
    // We'll use a constructor, as you can't directly call a function
    function __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }
    
    /**
     * send validation information to email
     * for reseting password
     */
    public function send_validation($mail = NULL) {
       //check if the email is existing
        $waiting = NULL;
        if($mail===NULL){
            $waiting = $this->CI->mailverifications->data_count(array('email'=> trim($this->CI->input->post('email', TRUE))));
        }
       if($waiting > 0){
           $this->CI->session->set_flashdata('error_msg', 'You have an existing link in your mail');
           redirect('home');
       }else{
           $authorized = FALSE;
           if($this->CI->session->loggedin===TRUE){
               //GET user table and primary key for author, admin, schools and referrals
               $table = get_user_table();
               $table_name = $table->table_name;
               //check user table to know if user is existing
               $user = $this->CI->$table_name->data_count(array('email'=> $mail), 'email')->row();
               //check if user exists and grant permission to change password
               if($user){
                    $authorized = TRUE;
               }
           }else{//the user is a public user
               $user = $this->CI->users->data_count(array('email'=> trim($this->CI->input->post('email', TRUE))), 'email, user_id, first_name, user_category')->row();
               //confirm that user exists and user is a public user
               if($user AND $user->user_category=='Public'){
                   $authorized = TRUE;
               }
//               else{
//                   //The user is not registered with Quizyclopedia
//                   $this->CI->session->set_flashdata('error_msg', 'You are not a Quizyclopedia User, Please Register');
//                   redirect('user/signup');
//               }
           }
           if($user AND $authorized==TRUE){
               //send link to database mailverifications and user's email address and redirect back home
               $value = array('email'=>$user->email, 'code'=> $this->CI->users->verification_hash(time()));
               //insert value to verification table
               $this->CI->mailverifications->insert($value);
               //send email to user
               $this->send_password_reset($user);
               $this->CI->session->set_flashdata('success_msg', 'Please, Check your E-mail for password Reset');
               //unset logged in session and redirect check user type
               if($this->CI->session->userdata('loggedin')!==NULL){
                   $this->CI->session->unset_userdata('loggedin');
               }
               redirect('home');
           }else{
               $this->CI->session->set_flashdata('error_msg', 'You are not allowed to carry out this action!!!');
               redirect('home');
           }
       }
   }
   
   /**
      * Send email verification
      */
     private function send_password_reset ($user){
         //print_r($user);
        $mail = array('email'=>$user->email);
        $code = $this->CI->mailverifications->data_count($mail, 'code')->row();
        $this->CI->email->from('noreply@quizyclopedia.com', 'Quizyclopedia');
        $this->CI->email->to($user->email);
        $this->CI->email->subject('Password Reset');
        //message
        $message = $this->CI->load->view('layout/email/reset', array('user'=>$user, 'code'=>$code), TRUE);
        $this->CI->email->message($message);

        $this->CI->email->send();
    }
    
   /**
    * Change User password through DB query
    * @param type $user_exists
    * @param type $code
    */
   public function change_password($user_exists, $code){
       $mail = array('email'=>$user_exists->email);
        $user_waiting = $this->CI->mailverifications->data_count($mail, 'code')->row();
        if(empty($user_waiting)){
            //link does not exist or has expired
            $this->CI->session->set_flashdata('error_msg', 'OOPS! False Link');
            redirect('home');
        }else{
            //check if verification code
            if(($user_exists->user_category!=='School')&&($user_exists->status==TRUE AND $user_waiting->code===$code)){
                    $this->p_change_continued($user_exists);
            }elseif(($user_exists->user_category=='School')&&($user_waiting->code===$code)){
                    $this->p_change_continued($user_exists);
            }else{
                show_404();
            }
        }
    }
   
    /**
     * Extension of change_password
     * @param type $user_exists
     */
    private function p_change_continued($user_exists){
        if($this->CI->form_validation->run('password')==FALSE){
            //display form for user to reset their password
            $this->p_wrd_reset_view();
        }else{
            //query database to reset password
            $data = array('password'=>  $this->CI->users->hash(trim($this->CI->input->post('password', TRUE))),
                'confirm_password' => $this->CI->users->hash(trim($this->CI->input->post('confirm_password', TRUE))));
            update_user($user_exists, $data);
            $this->CI->mailverifications->delete($user_exists->email);
            $this->CI->session->set_flashdata('success_msg', 'Password successfully Changed, Please proceed to Login');
            redirect('home');
        }
    }
    
    /**
    * Load view for password reset
    */
   public function p_wrd_reset_view(){
       $this->CI->load->view('layout/head');
       $this->CI->load->view('reset_password');
       $this->CI->load->view('layout/footer');
   }
}//End of Class
        