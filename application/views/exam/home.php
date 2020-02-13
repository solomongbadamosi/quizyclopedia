<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="jumbotron"><div class="story-content container-fluid">';
echo '<h1 class="text-center"><span class="text-success font-weight-bold">Nigeria\'s </span><strong>First</strong> 
        Questions <span class="text-danger font-weight-bold font-italic">Encyclopedia</span></h1>';
echo '</div></div><section class="banner-area relative">';
echo '<div class="container"><div class="row align-items-center"><div class="col">';
echo '<div class="story-content">';
echo '<h1> Welcome! <span class="text-danger">'.$this->session->first_name.'</span></h1>';
echo '<h3 class="h3">This is an <span class="h2 text-success">Examination Test</span> Arena</h3>';
echo '<div class="d-flex">';
echo '<div class="tab-content justify-content-center">';
echo anchor('exam/content/', '<button class="btn btn-light">Please, Select an Examination</button>', 
        'title="Start Learning" class="btn btn-dark"');
        echo '<h6 class="text-danger">Plan Expiry Date: <sapn class="text-success">'.date('F j, Y, g:i a', $this->session->expiry_time).'</span></h6>';
echo '</div></div></div></div></div></div></section>';
