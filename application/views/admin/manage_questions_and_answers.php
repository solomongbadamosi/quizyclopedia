<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$url = $this->myurl->selected_item(); 
echo '<div class="container">';
echo '<div class="bg-secondary text-center pt-3 pb-3">';
//Heading
echo '<h3 class="text-white">Manage: '.$url->current_subject->subject_name. ' Questions/Answers('.$url->current_period->period_name.')</h3>';
echo '</div><div class="bg-light pt-3"><div class="border p-2"></div>';
echo '<div class="container-fluid">';
echo '<h4><span class="text-success">Examination Body:</span><span class="text-heading"><Strong>'.$url->current_body->body_name.'</strong></span></h4><br/>';
echo '<h4><span class="text-success">Examination:</span><span><strong>'.$url->current_exam->exam_name.'</strong></span></h4><br/>';
echo '<h4><span class="text-success">Current Subject:</span><span class="text-danger">'.$url->current_subject->subject_name.'</span></h4><br/>';
echo '<h4><span class="text-success">Current Year: </span><span class="text-danger">'.$url->current_period->period_name.'</span></h4>';
echo '</div></div><div class="border p-2"></div><div class="row d-flex pb-5"><div class="col-lg-6">';
echo '<div class="container-fluid bg-dark"><h3 class="text-warning text-center"><strong>Manage Questions</strong></h3>';

//Adding Questions
echo '<div class="row"><div class="col-lg-5 btn"><button type="button" class="btn btn-success">';
echo 'Add Questions';
echo '</button></div><div class="col-lg-6 btn-group pb-2">';
foreach($categories as $category){
    echo anchor('admin/content/update/questions/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
        $url->current_period->period_id.'/'.$category->category_id, '<button class="btn btn-dark">'.$category->category_name.'</button>', 
        'class="btn btn-success"');
}
echo '</div></div><div class="border p-1 bg-light"></div><div class="row pt-2 pb-2">';
echo '<div class="col-lg-5 btn"><button type="button" class="btn btn-danger">';
echo 'Update/Delete Questions';
echo '</button></div><div class="col-lg-6 btn-group">';

//Call Categories
$q_cat = array();
foreach($categories as $category){
    $q_cat[$category->category_id] = $category->category_name;
}
if(in_array('Essay', $q_cat)){
    echo anchor('admin/content/manage/questions/'.$url->current_body->body_id.'/'.
    $url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
    $url->current_period->period_id.'/THEO', '<button class="btn btn-danger">'.$q_cat['THEO'].'</button>',
    'class="btn btn-warning"');
}if(in_array('Multiple Choices', $q_cat)){
    echo anchor('admin/content/manage/questions/'.$url->current_body->body_id.'/'.
    $url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
    $url->current_period->period_id.'/OBJ', '<button class="btn btn-danger">'.$q_cat['OBJ'].'</button>',
    'class="btn btn-warning"');
}
echo '</div></div></div></div>';

//Add Time
echo '<div class="col-lg-6">';
echo form_open(); 
    $options = array();
    foreach($time as $timer){
        $num_rows = 10;
        for($i=1; $i <= $num_rows; $i++){
            $options['default'] = 'Choose Time';
            $options[$timer->time_id] = $timer->hour.' Hours';
        }
    }
    //Separate Conditional Timer for General Assessment
    if($url->current_body->body_name!='General Assessment'){
        echo '<div class="pb-3">';
        echo '<span>'.form_dropdown('timer', $options, $options['default']).'</span>';
        echo  '<button class="btn btn-dark"><span class="btn text-success">ADD TIME TO EXAM</span>';
        echo form_submit('add_time', 'CLICK to ADD');
        echo '</button></div>';
    }//End if condition for General Assessment
echo form_close();
echo '</div></div><div class="p-3">';
echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
echo anchor('admin/content/manage/exam/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id, 'Choose Another Subject', 'class="btn btn-warning text-white"');
echo '</div></div>';