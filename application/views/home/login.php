<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//echo '<div class="pb-5"></div>';
echo '<div class="container col-lg-6">';
echo '<div class="card text-center">';
echo '<div class="card-header">';
echo '<object class="navbar-brand logo mr-3 img-fluid" width="60" height="60" type="image/svg+xml" data="'
        .site_url('assets/brand/quizyclopedia.svg').'"></object>';
echo '<div class="row">';
echo '<div class="col">';
echo '<h3 class="alert-heading text-center text-success">WELCOME BACK</h3>';
echo '</div></div></div>';
        
echo '<div class="card-body bg-dark">';
echo form_open();
echo '<div class="form-group">';
echo form_label('Email/Username', '', 'Class="text-white"');
    $em1_input = array(
        'name' => 'email',
        'type'=> 'text',
        'required autocomplete' => 'off',
        'placeholder' => 'Enter Email or Username here',
        'value' => $this->input->post('email')
    );
echo form_input($em1_input, '', 'class="form-control"');
echo '</div>';
echo '<div class="form-group">';
echo form_label('Password', '', 'Class="text-white"');
    $pw_input = array(
        'name' => 'password',
        'required autocomplete' => 'off',
        'placeholder'=>'Enter your Password'
    );
echo form_password($pw_input, '', 'class="form-control"');
    echo anchor('user/passwrd_reset', 'Forgot Password?', 'class="text-warning"');            
echo '</div>';
//captcha immage
echo '<div class="col">';
echo $cap['image'];
echo '</div>';
$captcha = array(
        'name' => 'captcha',
        'type'=> 'text',
        'required autocomplete' => 'off',
        'placeholder' => 'Enter Above Word here',
        'value' => ''
    );
echo '<div class="col">';
echo form_input($captcha);
echo '</div>';
//submit button
echo form_submit('login', 'LOGIN', 'class="btn btn-secondary font-weight-bold"');
echo '</div>';
echo form_close();
echo anchor('user/signup', 'Not a MEMBER? <span class="text-danger font-weight-bold">SIGNUP</span>');
echo '</div>';
echo '<div class="card-footer text">'.anchor('home', '<span class="btn btn-success">Go Back Home</span>').'</div>';
echo '</div>';