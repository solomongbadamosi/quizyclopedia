<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col">';
echo '<h5 class="alert-heading text-center text-success">Join the Successful People</h5>';
echo '</div></div>';
echo '<div class="container col-lg-8">';
echo '<div class="card text-center">';
echo '<div class="card-header">';
echo '<object class="navbar-brand logo mr-3 img-fluid" width="60" height="60" type="image/svg+xml" data="'
        .site_url('assets/brand/quizyclopedia.svg').'"></object>';
echo '</div>';
echo '<div class="card-body bg-dark">';
echo form_open();
echo '<div class="form-row">';
echo '<div class="form-group col-md-6">';
echo form_label('First Name', '', 'Class="text-white"') ;
    $f_n_input = array(
        'name' => 'first_name',
        'required autocomplete' => 'off',
        'type' => 'text',
        'placeholder'=>'First Name',
        'value' => $this->input->post('first_name'),
    );
echo form_input($f_n_input, '', 'class="form-control"');
echo '</div>';
echo '<div class="form-group col-md-6">';
echo form_label('Last Name', '', 'Class="text-white"');
    $l_n_input = array(
        'name' => 'last_name',
        'required autocomplete' => 'off',
        'type' => 'text',
        'placeholder' => 'Last Name',
        'value' => $this->input->post('last_name')
    );
echo form_input($l_n_input, '', 'class="form-control"');
echo '</div>';
echo '</div>';
echo '<div class="form-row">';
echo '<div class="form-group col">';
echo form_label('Email Address', '', 'Class="text-white"');
    $em_input = array(
        'name' => 'email',
        'required autocomplete' => 'off',
        'type' => 'email',
        'placeholder' => 'Email Address',
        'value' => $this->input->post('email'),
    );
echo form_input($em_input, '', 'class="form-control"');
echo '</div></div>';
echo '<div class="form-row">';
echo '<div class="form-group col-md-6">';
echo form_label('Password', '', 'Class="text-white"');
    $pw_input = array(
        'name' => 'password',
        'required autocomplete' => 'off',
        'placeholder'=>'Set A Password',
    );
echo form_password($pw_input, '', 'class="form-control"');
echo '</div>';
echo '<div class="form-group col-md-6">';
echo form_label('Confirm Password', '', 'Class="text-white"');
    $cpw_input = array(
        'name' => 'confirm_password',
        'required autocomplete' => 'off',
        'placeholder' => 'Please Confirm Password'
    );
echo form_password($cpw_input, '', 'class="form-control"');
echo '</div>';
echo '</div>';
echo '<div class="form-row">';
echo '<div class="form-group col">';
echo form_label('Phone Number', '', 'Class="text-white"');
    $phone_input = array(
        'name' => 'phone',
        'required autocomplete' => 'off',
        'placeholder' => 'Please Enter a Valid Phone Number',
        'type' => 'tel',
        'value' => $this->input->post('phone'),
    );
echo form_input($phone_input, '', 'class="form-control"');
echo '</div>';
echo '</div>';
echo '<h5 class="text-warning">Please, Who told you about us?</h5>';
echo '<div class="text-center">';
  $options = array('nobody'=>'Nobody');
    foreach($referrals as $key=>$value){
        $options[$value->user_name] = $value->first_name. ' '.$value->last_name;
    }
echo form_dropdown('referral', $options);
echo '</div>';
//captcha immage
echo '<div class="col pt-3">';
echo $cap['image'];
echo '</div>';
$captcha = array(
        'name' => 'captcha',
        'type'=> 'text',
        'required autocomplete' => 'off',
        'placeholder' => 'Enter Above Word here',
        'value' => ''
    );
echo '<div class="text-center m-3">';
echo form_input($captcha);
echo '</div>';
//submit buttion
echo form_submit('signup', 'START LEARNING', 'class="btn btn-primary font-weight-bold"');
echo '<div class="form-group">';    
echo '<small class="text-white text-mute">Signing up means You agree to our <span class="text-info font-weight-bold">TERMS OF USE</span> and '.
         '<span class="text-info font-weight-bold">PRIVACY POLICY</span></small></div>';
echo form_close();
echo anchor('user/login', 'Already a User? <span class="text-success font-weight-bold">LOGIN</span>', 'class="text-white"');
echo '</div>';
echo '<div class="card-footer text">'.anchor('home', '<span class="btn btn-success">Go Back Home</span>'). '</div>';
echo '</div></div></div>';
