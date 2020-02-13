<?php
/**
 * The general users login controller and signup
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Sandbox extends MY_Controller {
   
    
    function __construct() {
       parent::__construct();
       $this->load->library(array('myuser', 'myvalidation', 'mysubscription'));
       $this->load->helper(array('form'));
       $this->load->model(array('examsubjects'));
   }
   
   
   public function index($payment=6000, $prev_balance=2000){
//       $email = 'zalo003@gmail.com';
//       echo $waiting = $this->mailverifications->data_count(array('email'=> $email));
        //$CI = & get_instance();
        switch ($payment) {
            case 10000:
            case 2000:  
                $ref_amount_due = $prev_balance + 0.1*$payment;
                $share = array('referral'=>$ref_amount_due);
                print_r($share);
                break;
            case 6000:
            case 4000:
                $ref_amount_due = $prev_balance + 1000;
                $sch_amount_due = $prev_balance + 1000;
                $share = array('referral'=>$ref_amount_due, 'school'=>$sch_amount_due);
                print_r($share);
                break;
        }
        
    }
}