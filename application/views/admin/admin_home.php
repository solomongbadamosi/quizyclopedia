<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//HOME PAGE FOR ADMINSTRATORS AND AUTHOR
//Title (JUMBOTRON)
echo '<div class="jumbotron"><h2 class="text-center">'
    . '<span class="text-success font-weight-bold">Nigeria\'s </span><strong>First</strong> Questions '
    . '<span class="text-danger font-weight-bold font-italic">Encyclopedia</span></h2>';
echo '</div><section class="bg-light"><div class="container"><div class="row align-items-center">
        <div class="col"><h3>This is <span class="text-success">Admin</span> Area</h3>';
echo '<h2 class="text-danger">Welcome! <span class="text-warning">'.$this->session->first_name.'</span></h2>';
echo '<p class="text-dark">Please Select an Item</p>';
//Form for adding other adminstrators
if($this->session->userdata('user_category')=='Author'){
    //Only the Author has Access to this Page
    echo anchor('admin/user', '<button class="btn btn-light">Manage Administrators</button>', 'title="Manage Administrators" class="btn btn-dark font-weight-bold"');
    echo anchor('admin/school', '<button class="btn btn-light">Manage Schools</button>', 'title="Manage Registered Schools" class="btn btn-dark font-weight-bold"');
    echo anchor('admin/publicuser', '<button class="btn btn-light">Manage General Users</button>', 'title="Manage Registered Users" class="btn btn-dark font-weight-bold"');
    echo anchor('admin/referral', '<button class="btn btn-light">Manage Referrals</button>', 'title="Manage Referrals" class="btn btn-dark font-weight-bold"');
    echo anchor('exam/content', '<button class="btn btn-light">Practice Questions</button>', 'title="Manage Web Contents" class="btn btn-dark font-weight-bold"');
}
//Section for Managing Website Contents by Adminstrators and Authors only
echo anchor('admin/content/manage/body', '<button class="btn btn-light">Manage Contents</button>', 'title="Manage Web Contents" class="btn btn-dark font-weight-bold"'); 
//Password Reset
echo '<br />'.anchor('administrator/change_password', '<button class="btn btn-danger m-2">Reset Password</button>');
//Close All Opened Tags
echo '</div></div></div></div></section>';

