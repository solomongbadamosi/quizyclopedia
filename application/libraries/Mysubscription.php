<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mysubscription {
    //create ancillary class with $ci
     protected $CI;
     
     //Set initial value for subscribed
    protected $has_expired = TRUE;
    
    // We'll use a constructor, as you can't directly call a function
        // from a property definition.
    function __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->helper(array('subscription'));
        $this->CI->load->model(array('users', 'subscriptionreferences'));
    }

    /**
     * confirm if the user is an active subscriber
     * @return type boolean
     */
    private function subscribed(){
        return (bool) $this->CI->session->userdata['subscribed'];
    }
    
    /**
     * check if the user subscription is active and running
     */
    public function active_subscriber(){
        if($this->CI->session->userdata['user_category']=='Public'){
            if($this->subscribed()==FALSE ||$this->CI->session->expiry_time < time()){
                $session_data = array('loggedin', 'time');
                //unset session data
                $this->CI->session->unset_userdata($session_data);
                //change database variables loggedin and subscribed
                $time = $this->CI->users->verification_hash(time());
                $data = array('logged_in'=>'', 'subscribed'=>0);
                $this->CI->users->update($data, $this->CI->session->email);
                $this->CI->session->set_userdata('time', $time);
                $this->CI->session->set_flashdata('error_msg', 'Your Subscription has expired, Please renew to continue');
                redirect('user/subscribe/'.$this->CI->session->time);
            }
        }
    }
    
    /**
     * Get Post Data for subscription
     * and process to send for payment
     * @param type $post_data
     */
    public function run($post_data){
        $this->_subscription_prep($post_data);
        $result = array();
        //Set other parameters as keys in the $postdata array
        $ch = paystack_api('', $post_data);
        $request = curl_exec ($ch);
        curl_close ($ch);
        print_r($request);
        //process data
        if ($request){
            $result = json_decode($request, true);
            //save rerefence code in database
            if($result['status']==TRUE){
                $ref = array('reference'=>$result['data']['reference'], 
                    'email'=>$post_data['email'], 'amount'=>$post_data['amount']);
                $this->CI->subscriptionreferences->insert($ref);
                //redirect for authorization
                header('Location: ' . $result['data']['authorization_url']);
            }else{
                //something went wrong with authorization url
                $this->CI->session->set_flashdata('error_msg', 'Sorry!, Cannot process payment at the moment; Try Back Later');
                redirect('home');
            }
        }
    }
    
    private function _subscription_prep($post_data){
        //confirm if user is not having a pending payment process
        $prv_amount = $this->CI->subscriptionreferences->find_where(array('email'=>$post_data['email']))->row();
        //clear existing data from subscription reference table
        if($prv_amount && $prv_amount->amount==$post_data['amount']){
            clear_existing_reference();
        }elseif($prv_amount && $prv_amount->amount!=$post_data['amount']){
            $this->CI->session->set_flashdata('error_msg', 'You have a pending Subscription process');
            $this->CI->session->set_userdata('post', $post_data);
            redirect('user/subexists');
        }
    }
    
    /**
     * callback for subscription verification
     * This code verifies if subscription was successful or not
     */
    public function verify(){
        //check if the reference is in the database
        $return = array('reference'=>$this->CI->input->get('reference'));
        $existing = $this->CI->subscriptionreferences->find_where($return)->row();
        if($existing->reference){
            $result = array();
            //call paystack api
            $ch = paystack_api($return['reference']);
            $request = curl_exec($ch);
            curl_close($ch);

            if ($request) {
                $result = json_decode($request, true);
                //finalize subscription process
                $this->_subscription_check($result, $existing);
            }
        }else{
            $this->CI->session->set_flashdata('error_msg', 'Oops!!! False Link');
            redirect('home');
        }
    }
    
    
    /**
     * process logic if payment is successful or not
     * @param type $result
     */
    private function _subscription_check($result, $existing){
        if($result){
            if($result['data'] && $result['data']['status'] == 'success'){
                //Get School and Referral data
                $referral = $this->CI->users->data_count(array('email'=>$result['data']['customer']['email']), 'referral, school_id')->row();
                // the transaction was successful, you can deliver value
                $data = $this->_subscription_amount($result);
                //delete reference from database
                $this->CI->subscriptionreferences->delete(array('email'=>$existing->email));
                //update result in the database
                $this->CI->users->update($data, $result['data']['customer']['email']);
                //Distribute the shares of Referrals and Schools
                $this->_subscription_share($data, $referral);
                //set success message and redirect to login page
                $this->CI->session->set_flashdata('success_msg', 'Subcription was Successful');
                redirect('user/login');

           }else{
               //delete reference from database
                $this->CI->subscriptionreferences->delete(array('email'=>$existing->email));
                // the transaction was not successful, do not deliver value'
               $this->CI->session->set_flashdata('error_msg', 'Transaction was not successful, '.$result['data']['gateway_response']);
               redirect('home');
           }
        }
    }
    
    /**
     * Get the amount paid by user and set expiation date and time
     * @param type $result from Paystack
     */
    private function _subscription_amount($result){
        if($result['data']['amount']===1000000){
                $data = array('subscribed'=>'1', 'expiry_time'=> time()+31622400, 'amount'=>10000); 
            }elseif($result['data']['amount']===500000){
                $data = array('subscribed'=>'1', 'expiry_time'=> time()+15811200, 'amount'=>5000);
            }elseif($result['data']['amount']===400000){
                $data = array('subscribed'=>'1', 'expiry_time'=> time()+10540800, 'amount'=>4000);
            }else{
                $data = array('subscribed'=>'1', 'expiry_time'=> time()+2635200, 'amount'=>2000);
            }
        return $data;
    }
    
    private function _subscription_share($data, $referral){
        //check if user was referred
        if($referral){
            $previous = $this->_prev_balance($referral);
            //Generate Share of Commission
            if(!empty($previous)){
                $share = distribute_commission($data['amount'], $previous);
            }
            //update school's share
            if($referral->school_id!='nobody'){
                $this->CI->schools->update(array('amount'=>$share['school']), $referral->school_id);
            }if($referral->referral!='nobody'){
                //update referral's share
                $this->CI->referrals->update(array('amount'=>$share['referral']), $referral->referral);
            }
        }
    }
    
    
    private function _prev_balance($referral){
        $array = array();
        if($referral && $referral->referral!='nobody'){
            //Referral's Share
            $array['referral'] = $this->CI->referrals->data_count(array('user_name'=>$referral->referral), 'amount')->row();
            if($referral->school_id!=0){
                //School's Share
                $array['school'] = $this->CI->schools->data_count(array('sch_id'=>$referral->school_id), 'amount')->row();
            }
        }
        return $array;
    }
}//End of Class