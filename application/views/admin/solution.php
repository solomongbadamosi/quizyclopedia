<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Adding Solutions to Theoretical Questions
$url = $this->myurl->selected_item();
echo '<section class="container"><div class="center pb-5">';
echo '<h1>'.$url->current_body->body_name.'</h1>';
echo '<h3>'.$url->current_subject->subject_name.', '. $url->current_period->period_name .' Theory Solution'.'</h3>';
echo '</div>';

//Check if Questions are available
if($question !==NULL){
    echo '<div class="bg-light"><div class="row"><div class="col-lg-6">';
    echo $question->solution;
    echo '</div>';
    //If Solution has Diagram
    if($question->solution_diagram){ 
        echo '<div class="col-lg-4 col-md-6 container-fluid">';
        echo '<object type="image/svg+xml" data="'.site_url('assets/images/'.$question->solution_diagram).'">Your Browser does not support this image</object>';
        echo '</div>';
    } //End If for Diagrams
echo '</div></div><div class="p-5"></div>';
}//End If for Question

//Load Pagination
echo '<div class="bg-secondary d-inline-flex">';
echo $pagination['pages'];
echo '</div>';

//Buttons for Selecting Question Number
echo '<div class="pt-3 float-right"><div class="btn btn-group border"><button class="btn-primary">';
echo 'Choose a Question Number';
echo '</button>';
    echo form_open();
    $options = array();
    for($i = 0; $i<=$total; $i++){$options[$i]=$i; $options[0]='Search';}
    $data = array('name'=>'pg_num');
        echo form_dropdown($data, $options, $options[0]);
        echo form_submit('search', 'GoTo', 'class="btn btn-success"');
        echo form_close();
echo '</div></div><div class="pt-3"><div class="btn-group">';

//Navigation
    if($this->uri->segment(10)){
        $page = $this->uri->segment(10);
    }else{
        $page = 0;
    }
    $qnum = $page + 1;
    echo anchor('admin/content/manage/solution/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.$url->current_period->period_id.'/THEO', 
            '<button class="btn btn-success">Add New Solution</button>', 'class="btn btn-success"');
    echo anchor('admin/content/manage/solution/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.$url->current_period->period_id.'/THEO/'.$page.'/'.$qnum, 
            '<button class="btn btn-warning">Edit Current Solution</button>', 'class="btn btn-warning"');
    echo anchor('admin/content/delete/solution/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.$url->current_period->period_id.'/'.$qnum, 
            '<button class="btn btn-danger delete">Delete this Solution</button>', 'class="btn btn-dark delete"');
echo '</div><br/><div class="btn btn-group">';
echo '<button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#form">Click to view Form</button>';
echo '</div></div>';

//Display Form for Adding and Editing Solution
echo '<div class="bg-light pt-5 collapse" id="form"><div>';
echo form_open_multipart();
    //Hidden form properties
    $hidden_properties = array(
        'exam_id'=>$url->current_exam->exam_id,
        'body_id'=>$url->current_body->body_id,
        'subject_id'=>$url->current_subject->subject_id,
        'period_id'=>$url->current_period->period_id,
    );
    if($this->uri->segment(11)){
        $hidden_properties['question_number'] = $qnum;
    }else{
        $hidden_properties['question_number'] = $total +1;
    }
    echo form_hidden($hidden_properties);
    $text_area_data = array(
        'name'=>'solution',
        'class'=>'tinymce',
    );
    echo form_textarea($text_area_data);
    echo '<div class="pt-3">';
    echo form_upload('solution_diagram');
    if($this->uri->segment(11)){
        echo form_submit('edit', 'Update Answer', 'class="btn btn-warning"');
    }else{
        echo form_submit('add', 'Add Answer', 'class="btn btn-success"');
    }
echo '</div>';
echo form_close();
echo '</div></div><div class="p-3"></div>';
echo anchor('admin/content/manage/questions/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
        $url->current_period->period_id, '<button class="btn btn-dark">&lArr; Back</button>', 'class="btn"');
echo anchor('admin/content', 'Back to Main Menu<span class="lnr lnr-arrow-left"></span>', 'class="genric-btn primary circle arrow"');
echo '</section>';