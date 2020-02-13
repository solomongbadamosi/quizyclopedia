<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container mb-5">';
echo '<div class="container">';
echo '<div class="container col-lg-8">';
echo '<div class="card text-center">';
echo '<div class="card-header">';
echo '<object class="navbar-brand logo mr-3 img-fluid" width="60" height="60" type="image/svg+xml" data="'
        .site_url('assets/brand/quizyclopedia.svg').'"></object>';
echo '</div>';
echo '<div class="card-body bg-dark">';
echo form_open();
echo '<div class="form-row">';
if($this->uri->segment(3)===NULL){
    $value = array(
        'name'=>$this->input->post('name'),
        'contact'=>$this->input->post('contact_person'),
        'phone'=>$this->input->post('phone'),
        'location'=>$this->input->post('location'),
        'email'=>$this->input->post('sch_mail')
    );
}else{
    $value = array(
        'name'=>$school->name,
        'contact'=>$school->contact_person,
        'phone'=>$school->phone,
        'location'=>$school->location,
        'email'=>$school->email
    );
}
echo '<div class="form-group col-md-6">';
echo form_label('School Name', '', 'Class="text-white"') ;
    $n_input = array(
        'name' => 'name',
        'required autocomplete' => 'off',
        'type' => 'text',
        'placeholder'=>'Full Name of School',
        'value' => $value['name'],
    );
echo form_input($n_input, '', 'class="form-control"');
echo '</div>';
echo '<div class="form-group col-md-6">';
echo form_label('Contact Person', '', 'Class="text-white"');
    $contact_input = array(
        'name' => 'contact_person',
        'required autocomplete' => 'off',
        'type' => 'text',
        'placeholder' => 'Contact Person',
        'value' => $value['contact']
    );
echo form_input($contact_input, '', 'class="form-control"');
echo '</div>';
echo '</div>';
echo '<div class="form-row">';
echo '<div class="form-group col-md-4">';
echo form_label('Phone Number', '', 'Class="text-white"');
    $phone_input = array(
        'name' => 'phone',
        'required autocomplete' => 'off',
        'type' => 'tel',
        'placeholder' => 'Phone Number',
        'value' => $value['phone'],
    );
echo form_input($phone_input, '', 'class="form-control"');
echo '</div>';
echo '<div class="form-group col-md-4">';
echo form_label('School Location', '', 'Class="text-white"');
    $loc_input = array(
        'name' => 'location',
        'required autocomplete' => 'off',
        'type' => 'text',
        'placeholder' => 'School Location',
        'value' => $value['location'],
    );
echo form_input($loc_input, '', 'class="form-control"');
echo '</div>';
echo '<div class="form-group col-md-4">';
echo form_label('School Email', '', 'Class="text-white"');
    $mail_input = array(
        'name' => 'email',
        'required autocomplete' => 'off',
        'type' => 'email',
        'placeholder' => 'School Email Address',
        'value' => $value['email'],
    );
echo form_input($mail_input, '', 'class="form-control"');
echo '</div>';
echo '</div>';
echo '<div class="form-row">';
echo '<div class="form-group col-md-6">';
echo form_label('School Password', '', 'Class="text-white"');
    $password_input = array(
        'name' => 'password',
        'required autocomplete' => 'off',
        'placeholder' => 'School Password',
    );
echo form_password($password_input, '', 'class="form-control"');
echo '</div>';
echo '<div class="form-group col-md-6">';
echo form_label('Confirm School Password', '', 'Class="text-white"');
    $c_password_input = array(
        'name' => 'confirm_password',
        'required autocomplete' => 'off',
        'placeholder' => 'Confirm School Password',
    );
echo form_password($c_password_input, '', 'class="form-control"');
echo '</div>';
echo '</div>';

//submit buttion
if($this->uri->segment(3)!==NULL){
    echo form_submit('update', 'UPDATE', 'class="btn btn-primary font-weight-bold"');
}else{
    echo form_submit('add', 'SUBMIT', 'class="btn btn-danger font-weight-bold"');
}

echo form_close();
echo '</div>';
echo '</div></div></div>';
echo '<div class="text-center">';
echo anchor('referral', '<span class="fa fa-arrow-left"></span> Back to Dashboard', 'class="btn btn-success"');
echo '</div>
    </div>';