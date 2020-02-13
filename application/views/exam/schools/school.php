<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//jumbotron
echo '<div class="jumbotron"><div class="container-fluid">';
echo '<h1 class="text-center"><span class="text-success font-weight-bold">Nigeria\'s </span><strong>First</strong> 
        Questions <span class="text-danger font-weight-bold font-italic">Encyclopedia</span></h1>';
echo '</div></div>';

echo '<div class="container">';
        echo '<h1 class="sp-2 text-danger">'.$this->session->school_name.'</h1>';
//Table for Analysis Goes here
    echo '<div class="bg-secondary"><h4 class="text-warning p-3">You currently have: </h4></div>';
    echo '<div class="row">';
        echo '<div class="col-lg-4 col-md-4 text-center">';
            echo '<h2 class="text-primary">'.$school->users .'</h2><p>REGISTERED STUDENTS</p><hr />';
        echo '</div>';
        echo '<div class="col-lg-4 col-md-4 text-center">';
            echo '<h2 class="text-secondary">'.$school->subscribed .'</h2><p>ACTIVE SUBSCRIBERS</p><hr />';
        echo '</div>';
        echo '<div class="col-lg-4 col-md-4 text-center">';
            echo '<h2 class="text-success">N'.$school->amount .'</h2><p>CASH IN YOUR WALLET</p><hr />';
        echo '</div>';
    echo '</div>';
    echo '<div class="text-center bg-info p-3"><h5 class="text-white">THANK YOU FOR CHOOSING QUIZYCLOPEDIA</h5></div>';
    //Clients of Referral
    echo '<div class="mb-1 mt-3">';
    echo anchor('school/students', '<button class="btn btn-primary">View your Students\' Record</button>');
    echo '</div>';
    //Password Reset
    echo '<div class="mb-4">';
    echo anchor('school/change_password', '<button class="btn btn-danger">Reset Password</button>');
    echo '</div>';
echo '</div>';