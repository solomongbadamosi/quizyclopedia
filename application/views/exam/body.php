<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="container">';
echo '<section class="bg-secondary text-center pt-3 pb-3">';
echo '<h1 class="h1 text-white">Select an Examination</h1>';
echo '</section><br/>';
echo '<div class="container-fluid">';
echo '<table class="table table-hover">';
echo '<thead class="bg-light"><tr>';
echo '<th scope="col"><table>';
echo '<thead><tr><th scope="col">BODY NAME</th>';
echo '</tr></thead></table></th>';
echo '<th scope="col">';
//Heading for Examination
echo '<table><thead><tr><th scope="col">EXAMINATIONS</th>';
echo '</tr></thead></table></th></tr></thead><tbody>';
    while ($body = $bodies_set->unbuffered_row()){
       /**
        * check if the examinations are available in the body before displaying 
        * the examination body
        */
        echo '<tr><th scope="row" class="align-middle">'.$body->body_name.'</th><td>';
        echo '<table class="table table-success table-striped"><tbody>';
        //Examinations in each body
        $exams_set = $this->examinations->find_by_index($body->body_id);
        while ($exam = $exams_set->unbuffered_row()) {
            if($exam->ready==TRUE){
                echo '<tr><th scope="row">';
                echo anchor(site_url('exam/content/question/subject/'.$body->body_id.'/'.$exam->exam_id), $exam->exam_name, 'class="text-success"'); 
                echo '</th></tr>';
            }
        }
        echo '</tbody></table>';//End of Examinations
        echo '</td></tr>';
    }
echo '</tbody></table>';
echo '</div><div class="dropdown-divider"></div>';
echo '<div class="bg-light"><div class="container-fluid btn-group">';
//Pagination
echo $pagination_data['pages'];
echo '</div></div>';
echo '<div class="dropdown-divider"></div>';
if($this->session->user_category=='Author'){
    echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
}else{
    echo anchor('exam/user', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
}
echo '</section>';
