<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//jumbotron
echo '<div class="jumbotron"><div class="container-fluid">';
echo '<h1 class="text-center"><span class="text-success font-weight-bold">Nigeria\'s </span><strong>First</strong> 
        Questions <span class="text-danger font-weight-bold font-italic">Encyclopedia</span></h1>';
echo '</div></div>';

echo '<div class="container">';
        echo '<h1> Welcome! <span class="sp-2 text-danger">'.$this->session->first_name.'</span></h1>';
        echo '<h3 class="h3">Monitor your <span class="h1 text-success">Wealth </span> Here </h3>';
//Table for Analysis Goes here
    echo '<div class="bg-secondary"><h4 class="text-warning p-3">You currently have: </h4></div>';
    echo '<div class="row">';
        echo '<div class="col-lg-4 col-md-4 text-center">';
            echo '<h2 class="text-primary">'.$referral->users .'</h2><p>REGISTERED USERS</p><hr />';
        echo '</div>';
        echo '<div class="col-lg-4 col-md-4 text-center">';
            echo '<h2 class="text-secondary">'.$referral->subscribed .'</h2><p>ACTIVE SUBSCRIBERS</p><hr />';
        echo '</div>';
        echo '<div class="col-lg-4 col-md-4 text-center">';
            echo '<h2 class="text-success">N'.$referral->amount .'</h2><p>CASH IN YOUR WALLET</p><hr />';
        echo '</div>';
    echo '</div>';
    echo '<div class="text-center bg-info p-3"><h5 class="text-white">THANK YOU FOR BEING OUR PARTNER</h5></div>';
    //Clients of Referral
    echo '<div class="mb-5 mt-3">';
    echo anchor('referral/client/'.$this->session->userdata('user_name'), '<button class="btn btn-primary">Manage Your Clients</button>');
    echo anchor('referral/update/', '<button class="btn btn-success">Add New School</button>');
    echo '<div class="p-2">';
    echo form_open('sample/content/question/practice/2/NCEE/QTR/YrK15/OBJ/1');
        echo form_submit('start', 'Sample question', 'class="btn btn-secondary"');
    echo form_close();
    echo '</div>';
    //Password Reset
    echo anchor('referral/change_password', '<button class="btn btn-danger">Reset Password</button>');
    echo '</div>';
echo '</div>';
