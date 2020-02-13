<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container mb-5">';
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
echo '<div class="form-group col">';
echo '<h4 class="text-warning">Select Your School</h4>';
echo '<div class="text-center">';
  $options = array('none'=>'Not Included');
    foreach($schools as $key=>$value){
        $options[$value->sch_id] = $value->name;
    }
echo form_dropdown('school', $options);
echo '</div>';
echo '</div>';
echo '</div>';
//submit buttion
echo form_submit('continue', 'CONTINUE', 'class="btn btn-danger font-weight-bold"');
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';