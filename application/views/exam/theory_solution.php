<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Display Solution to Theory Questions
$url = $this->myurl->selected_item();
//Check if there is solution
if($solution){
    echo '<section class="bg-secondary text-center pt-3 pb-3"><div class="row"><div class="col-lg-9">';
    echo '<h1 class="h1 te<div class="container"><div class="row pt-3 pb-3"><div class="col-lg-6 col-md-6">';
    echo '<div class="bg-secondary">';
    echo '<h4 class="text-white p-2"><span class="font-weight-bold">Question Number:</span>';
    echo '#'.$solution->question_number.'</h4>';
    echo '</div></div></div></div></section>';
    echo '<section><div class="container"><div class="row">';
    if($solution_diagram){
        echo '<div class="col-lg-6">';
    }else{
        echo '<div class="col">';
    }
    echo $solution->ref;
    echo '</div>';
    if($solution_diagram){
        echo '<div class="col-lg-6">';
        echo '<object type="image/svg+xml" data="'.site_url('assets/images/'.$solution_diagram->solution_diagram).'">Diagram</object>';
        echo '</div>';
    }
    echo '</div></div></section>';
}
