<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="container">';
echo '<h3 class="text-success">Reset Your Password</h3>';

//check if code has not been sent
if ($this->uri->segment(3)===NULL && $this->uri->segment(4)===NULL){
echo form_open();
echo form_label('Enter your Email Address');
$em1_input = array(
        'name' => 'email',
        'required autocomplete' => 'off',
        'type' => 'email',
        'placeholder' => 'Email',
        'value' => $this->input->post('email')
    );
echo form_input($em1_input);
echo form_submit('submit', 'Reset', 'class="btn btn-danger"');
echo form_close();

}else{
    //load form for reset password after code is sent
echo form_open();
echo '<div class="row">';
echo form_label('Enter a New Password: ');
    $pw_input = array(
        'name' => 'password',
        'required autocomplete' => 'off',
        'placeholder'=>'Set A  New Password'
    );
echo form_password($pw_input);
echo '</div><div class="row pt-3">';
echo form_label('Confirm Password: ');
    $cpw_input = array(
        'name' => 'confirm_password',
        'required autocomplete' => 'off',
        'placeholder' => 'Please Confirm your Password'
    );
    echo form_password($cpw_input);
echo '</div>';
echo form_submit('reset', 'Reset', 'class="btn btn-danger"');
echo form_close();
}
echo anchor('user/check', '<button class="btn btn-success m-2">Return Home</button>');
echo '</section>';
