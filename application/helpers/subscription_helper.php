<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    //Generate a unique reference number for transaction
     function generate_reference($qtd){
        //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
        $Caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $QuantidadeCaracteres = strlen($Caracteres);
        $QuantidadeCaracteres--;

        $Hash=NULL;

        for($x=1;$x<=$qtd;$x++){
            $Posicao = rand(0,$QuantidadeCaracteres);
            $Hash .= substr($Caracteres,$Posicao,1);
        }

        return $Hash;
     }
     
     /**
     * Get the post data for subscription
     * @param type $time
     * @return int
     */
    function subscriptionpost($time){
        $CI = & get_instance();
        return $post_data = array(
            'email' => $CI->session->email,
            'reference' => $time.generate_reference(6),
            'amount' => $CI->security->xss_clean(trim($CI->input->post('amount')))*100,
            'plan' => $CI->security->xss_clean(trim($CI->input->post('plan')))
            );
    }
    
    /**
     * confirm if user is willing to proceed with subscription
     * @param array $post
     */
    function confirmusersubscription($post){
        $CI = & get_instance();
        if($CI->input->post('proceed')){
             //process for payment
             $CI->mysubscription->run($post);
         }else{
             $CI->load->view('home/confirm_subscription', array('post'=>$post));
         }
     }
     
     /**
      * Run subscription process
      * @param timestamp $time
      */
     function validate_subscription($time){
         $CI = & get_instance();
         if($CI->form_validation->run('subscription')==TRUE){
            //confirm if user is willing to subscribe and proceed if they are
            confirmusersubscription(subscriptionpost($time));
         }
     }
     
     /**
      * instantiating paystack url
      * @param url string $get_url
      * @return string
      */
     function paystack_url($get_url=NULL){
         if($get_url==NULL){
             $url = "https://api.paystack.co/transaction/initialize";
         }else{
             $url = 'https://api.paystack.co/transaction/verify/'.$get_url;
         }
         return $url;
     }
     
    /**
     * connecting with paystack
     * @param object $return (reference code in the database)
     * @return curlable object 
     */
    function paystack_api($get_url=NULL, $post_data=NULL){
        //The parameter after verify/ is the transaction reference to be verified
        $url = paystack_url($get_url);
       //use Curl to create api
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($get_url!=NULL){
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(
            $ch, CURLOPT_HTTPHEADER, ['Authorization: sk_live_460a18d6c522fd3a93695ab079ee1cd5b8b7a396']);
        }else{
            unset($post_data['plan']);
            curl_setopt($ch, CURLOPT_POST, 1);
            //Set other parameters as keys in the $postdata array
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post_data));  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
              'Authorization: Bearer sk_live_460a18d6c522fd3a93695ab079ee1cd5b8b7a396',
              'Content-Type: application/json',
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        return $ch;
    }
    
    /**
     * Clearing Reference table is exists
     * @param type $prv_amount
     * @param type $posted_amount
     * @param type $email
     */
    function clear_existing_reference(){
        $CI = & get_instance();
        //delete the value in the database and proceed with processing
        $CI->subscriptionreferences->delete(array('email'=>$CI->session->email));
    }
    
    /**
     * Calculate amount due to schools and referrals
     * @param string $payment
     * @param array $prev_balance
     * @return array
     */
    function distribute_commission($payment, $prev_balance){
        $CI = & get_instance();
        $sch_amount_due = 0;
        switch ($payment) {
            case 10000:
            case 2000:  
                $ref_amount_due = $prev_balance['referral']->amount + 0.1*$payment;
                $share = array('referral'=>$ref_amount_due, 'school'=>$sch_amount_due);
                return $share;
            case 5000:
            case 4000:
                $ref_amount_due = $prev_balance['referral']->amount + 1000;
                if($CI->session->school_id!=0){
                    $sch_amount_due = $prev_balance['school']->amount + 1000;
                }
                $share = array('referral'=>$ref_amount_due, 'school'=>$sch_amount_due);
                return $share;
        }
    }
    
    
