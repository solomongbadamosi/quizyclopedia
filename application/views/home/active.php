<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="container">';

//load form for reset password after code is sent
echo form_open();
echo '<div class="row"><div class="col-lg-1">';
echo form_label('Password: ');
echo '</div>';
    $pw_input = array(
        'name' => 'password',
        'required autocomplete' => 'off',
        'placeholder'=>'Re-type your password'
    );
echo '<div class="col">';
echo form_password($pw_input);
echo '</div>';
echo '</div><div class="container row pt-3"><div class="col-lg-1 col-md-2 col-sm-2">';
echo form_submit('submit', 'Login', 'class="btn btn-primary"');
echo '</div>';
echo '<div class="col-md-6 col-sm-6 pt-1">';
echo anchor('home', '<span class="btn btn-success">Go Back Home</span>');
echo '</div>';
echo form_close();
echo '</div>';
echo '</section>';
