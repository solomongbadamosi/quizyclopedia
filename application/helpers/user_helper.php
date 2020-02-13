<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * identifies user category
     * @param object $user
     */
    function useridentity($user){
        $CI = & get_instance();
        if($user->user_category=='School'){
            $data['identifier'] = $user->sch_id;
        }elseif($user->user_category=='Referral'){
            $data['identifier'] = $user->user_name;
            $data['user_name'] = $user->user_name;
        }else{
            $data['identifier'] = $user->email;
            $data['referral'] = $user->referral;
        }
        $CI->session->set_userdata($data);
    }
    
    /**
     * set session value after verifying user password
     * @param object $user
     */
    function set_session_value($user){
        $CI = & get_instance();
        $data = array(
            'user_category' => $user->user_category,
            'email' => $user->email,
        );
        if($user->user_category=='School'){
            $data['school_name'] = $user->name;
            $data['sch_id'] = $user->sch_id;
        }elseif($user->user_category=='Public'){
            $data['school_id'] = $user->school_id;
            $data['expiry_time'] = $user->expiry_time;
            $data['subscribed'] = $user->subscribed;
        }elseif($user->user_category!='School'){
            $data['first_name'] = $user->first_name;
        }
        $CI->session->set_userdata($data);
    }
    
    /**
     * Calculate waiting hours for wrong password attempts
     * @param timestamp $remaining_time
     */
    function trial_hour_calculator($remaining_time){
        $CI = & get_instance();
        if($remaining_time > 3600){
            $hour = floor($remaining_time/3600);
            $minutes = floor(($remaining_time % 3600)/60);
            $trial_hour = $hour. ' hour(s)';
        }else{
            $minutes = floor($remaining_time/60);
            $trial_hour = NULL;
        }
        $seconds = ($remaining_time % 60);
        $CI->session->set_flashdata('error_msg', 'Maximum Login Attempts Reached, Try Back in about '.$trial_hour.' '.$minutes.' Minutes : '.$seconds.' Seconds Time');
    }