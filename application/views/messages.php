<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Error for Forms Validation
$home = array('', 'home');
if(!in_array($this->uri->segment(2),$home)){
    echo '<div class="container mt-2">'.validation_errors('<p class="alert alert-danger text-center">', '</p>').'</div>';
}

//Flash Success Messages
echo '<div style="background-color: green; margin: 2px; text-align: center"><p style="color:white">'
.$this->session->flashdata('success_msg')
.'</p></div>';

//Flash Error Messages
echo '<div style="background-color: red; text-align: center"><p style="color:white">'
.$this->session->flashdata('error_msg')
.'</p></div>';

//Database Errors
echo $this->session->flashdata('db_error');

//Error Delimiter
if($this->uri->segment(4)==='questions' || $this->uri->segment(4)==='solution'||($this->uri->segment(3)==='update' && $this->uri->segment(4)==='body')){
    echo $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
}

