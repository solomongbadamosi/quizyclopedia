<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container mb-5">';
//user's full name
echo '<div class="h2 text-white bg-primary p-3">';
    if($current_user){
echo $current_user->first_name .' '. $current_user->last_name;
    }else{
        echo 'Add New User to Referral List';
    }
echo '</div><br/>';

//start form
echo form_open();
echo '<div class="form-group">';
echo '<div class="row border">';

echo '<div class="col-lg-4">';
//First Name
echo form_label('User Name:');
$u_name = array(
    'class'=>'form-text',
    'name'=>'user_name',
);
    if($current_user){
        $u_name['value'] = $current_user->user_name;
    }
echo form_input($u_name);
echo '</div>';


//last name
echo '<div class="col-lg-4">';
echo form_label('First Name:', 'class="form-label"');
$f_name = array(
    'class'=>'form-text',
    'name'=>'first_name',
);
    if($current_user){
        $f_name['value'] = $current_user->first_name;
    }
echo form_input($f_name);
echo '</div>';

//last name
echo '<div class="col-lg-4">';
echo form_label('Last Name:', 'class="form-label"');
$l_name = array(
    'class'=>'form-text',
    'name'=>'last_name',
);
    if($current_user){
        $l_name['value'] = $current_user->last_name;
    }
echo form_input($l_name);
echo '</div>';


echo '</div><br/>';
echo '<div class="row border">';
//E-mail
echo '<div class="col-lg-4">';
echo form_label('E-mail:');
$mail = array(
    'class'=>'form-text',
    'type'=>'email',
    'name'=>'email',
);
    if($current_user){
        $mail['value'] = $current_user->email;
    }
echo form_input($mail);
echo '</div>';

//password
echo '<div class="col-lg-4">';
echo form_label('Password:');
$p_word = array(
    'class'=>'form-text',
    'name'=>'password',
);
echo form_password($p_word);
echo '</div>';
//confirm password
echo '<div class="col-lg-4">';
echo form_label('Confirm Password:', 'class="form-label"');
$c_p_word = array(
    'class'=>'form-text',
    'name'=>'confirm_password',
);
echo form_password($c_p_word);
echo '</div>';
echo '</div><br/>';

echo '<div class="row border">';
//Phone Number
echo '<div class="col-lg-4">';
echo form_label('Phone Number:');
$phone = array(
    'class'=>'form-text',
    'name'=>'phone_number',
);
if($current_user){
        $phone['value'] = $current_user->phone_number;
    }
echo form_input($phone);
echo '</div>';
//Bank Name
echo '<div class="col-lg-4">';
echo form_label('Bank Name:');
$banker = array(
    'class'=>'form-text',
    'name'=>'banker',
);
if($current_user){
        $banker['value'] = $current_user->banker;
    }
echo form_input($banker);
echo '</div>';
//Account Number
echo '<div class="col-lg-4">';
echo form_label('Account Number:');
$acc_num = array(
    'class'=>'form-text',
    'name'=>'account_number',
);
if($current_user){
        $acc_num['value'] = base64_decode($current_user->account_number);
    }
echo form_input($acc_num);
echo '</div>';
echo '</div><br/>';

//Activation Status
$status = array(0 => 'Deactivate', 1 => 'Activate');
echo form_dropdown('status', $status, 1). '<br/>';
    if($current_user){
        echo form_submit('submit', 'Update Referral', 'class="btn btn-warning"');
    }else{
        echo form_submit('submit', 'Add New Referral', 'class="btn btn-primary"');
    }

echo form_close(); //end of form
echo '</div>';
echo anchor('admin/referral', '<button class="btn border btn-success">Back to referrals</button>', 'class="btn btn-success"');
echo '</div>';