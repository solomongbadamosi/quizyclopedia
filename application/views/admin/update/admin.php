<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container">';
//user's full name
echo '<div class="h2 text-white bg-primary p-3">';
    if($current_user != 'Author'){
echo $current_user->first_name .' '. $current_user->last_name;
    }else{
        echo 'Add New User to Admin Panel';
    }
echo '</div><br/>';

//start form
echo form_open();
echo '<div class="form-group">';
echo '<div class="row border">';

echo '<div class="col-lg-4">';
//User IDentification Number
if($current_user != 'Author'){
echo form_hidden($current_user->user_id);
}
echo form_hidden('referral', 'nobody');
//First Name
echo form_label('First Name:');
$f_name = array(
    'class'=>'form-text',
    'name'=>'first_name',
);
    if($current_user != 'Author'){
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
    if($current_user != 'Author'){
        $l_name['value'] = $current_user->last_name;
    }
echo form_input($l_name);
echo '</div>';

//E-mail
echo '<div class="col-lg-4">';
echo form_label('E-mail:');
$mail = array(
    'class'=>'form-text',
    'type'=>'email',
    'name'=>'email',
);
    if($current_user != 'Author'){
        $mail['value'] = $current_user->email;
    }
echo form_input($mail);
echo '</div>';

echo '</div><br/>';
echo '<div class="row border">';
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
//last name
echo '<div class="col-lg-4">';
echo form_label('User Category:');
$u_cat = array(
    'class'=>'form-text',
    'name'=>'user_category',
);
    if($current_user != 'Author'){
        $u_cat['value'] = $current_user->user_category;
    }else{
        $u_cat['value'] = 'Admin';
    }
echo form_input($u_cat);
echo '</div>';

//Phone number
echo '<div class="col-lg-4">';
echo form_label('Phone Number:');
$u_phone = array(
    'class'=>'form-text',
    'name'=>'phone',
    'type'=>'tel',
);
    if($current_user != 'Author'){
        $u_cat['value'] = $current_user->phone;
    }else{
        $u_cat['value'] = $this->input->post('phone');
    }
echo form_input($u_phone);
echo '</div>';
echo '</div><br/>';

//subscription Value
$options = array(1 => 'Subcribed', 0 => 'Not Subscribed');
echo form_dropdown('subscribed', $options, '1'). '<br/>';

//Activation Status
$status = array(0 => 'Deactivate', 1 => 'Activate');
echo form_dropdown('status', $status, 1). '<br/>';
    if($current_user != 'Author'){
        echo form_submit('submit', 'Update User', 'class="btn btn-danger"');
    }else{
        echo form_submit('submit', 'Add New Admin', 'class="btn btn-danger"');
    }

echo form_close(); //end of form

echo '</div>';

echo anchor('admin/user', '<button class="btn border btn-success">Back to Users Page</button>', 'class="btn btn-success"');
