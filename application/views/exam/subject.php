<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$url = $this->myurl->selected_item();
//Display for Available Choiec of Subjects for User
echo '<section class="container"><div class="bg-secondary text-center pt-2 pb-2">';
echo '<h4 class="text-white">Choose An Examination Subject and Year</h4></div>';
echo '<div class="bg-light">';
echo '<div class="container p-2"><div class="row">';
while($subject = $subjects_set->unbuffered_row()){ 
    echo '<div class="col-lg-4 col-md-6 col-10 d-flex"><div class="p-2 bg-warning m-3 text-center">';
    echo '<h4><strong>'.$subject->subject_name.'</strong></h4>';
    echo '<div class="dropright"><button type="button" class="btn btn-secondary">';
    echo 'Practice Questions';
    echo '</button>';
    //Query Periods from Database
    $periods_set = $this->examsubjectperiods->public_subject_periods($url->current_exam->exam_id, $subject->subject_id)->result(); 
    echo '<button type="button" class="btn tbn-secondary dropdown-toggle-split">';
    echo '<select name="subject_id" onchange="window.location.href=this.value;">';
    if($this->uri->segment(5)==5){
        echo '<option value="">Click Here to Start</option>';
    }else{
        echo '<option value="">Select a Year</option>';
    }
    foreach($periods_set as $subject_period){
        echo '<option value="'.site_url('exam/content/question/category/'.$url->current_body->body_id.'/'
                .$url->current_exam->exam_id.'/'.$subject->subject_id.'/'.$subject_period->period_id).'">';
        if($this->uri->segment(5)==5){
            echo 'START';
        }else{
            if($subject_period->ready==TRUE){
                echo $subject_period->period_name;
            }
        }
        echo '</option>';
    }//End Foreach
    echo '</select></button></div>';
    echo '<div class="dropdown-divider"></div></div></div>';
}//End While
echo '</div></div></div>';

//Pagination
echo $pagination_data['pages'];
echo '<div class="p-3"></div><div class="dropdown-divider"></div><div class="p-3">';
//Navigation
echo '<div class="col-md-6 p-1">';
echo anchor('exam/content/home', 'Choose Another Examination', 'class="btn btn-dark"');
echo '</div>';
if($this->uri->segment(6)==='JAMB'){
    echo '<div class="col-md-6 p-1">';
    echo anchor('exam/content/question/subject/4/JAMB', 'Select Another Environment', 'class="btn btn-success"');
    echo '</div>';
}
echo '</div><div class="p-3 d-flex">';
if($this->session->user_category=='Author'){
    echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
}else{
    echo anchor('exam/user', '<span class="fa fa-arrow-left"></span> Back to Home', 'class="btn btn-success"');
}
echo '</div></section>';