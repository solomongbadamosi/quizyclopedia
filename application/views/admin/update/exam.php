<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$url = $this->myurl->selected_item();

//Display form for Editing Current Examination body

echo '<section class="container"><section class="bg-secondary text-center pt-3 pb-3"><h1 class="h1 text-white">';
//Title Segment
if($this->uri->segment(6)===null){
   echo "Add Examination to '".$url->current_body->body_name;
}else{
    $current_exam = null;
    echo "Edit '".$url->current_exam->exam_name."'";
}
echo '</h1></section><section class="container"><br/><div class="container container-fluid pl-3" >';

//Form Starts
echo form_open();
echo '<div class="form-row"><div class="col-lg-4"><div class="form-group">';

//Examination Body Number
echo '<h3>'. form_label('Body Code: ', 'body_id', 'class="text-success"').'</h3>';
    $body_id_input = array($url->current_body->body_id=>$url->current_body->body_id);
echo form_dropdown('body_id', $body_id_input); 
echo '</div></div><div class="col-lg-4"><div class="form-group">';

//Examination Name
echo '<h3>'. form_label('Exam Name: ', 'exam_name', 'class="text-success"').'</h3>';
    $exam_name_input = array('name'=>'exam_name','placeholder'=>'What is the Exam name?' ,'type'=>'text' ,set_value('exam_name'));
if($this->uri->segment(6)){
    $exam_name_input['placeholder'] = '';
    $exam_name_input['value'] = $url->current_exam->exam_name;
}
echo form_input($exam_name_input);
echo '</div></div><div class="col-lg-4"><div class="form-group">';

//Examination Identification Variable
echo '<h3>'. form_label('Exam Code: ', 'exam_id', 'class="text-success"').'</h3>';
    $exam_id_input = array('name'=>'exam_id', 'placeholder'=>'Give this Exam a Code' , 'type'=>'text' ,set_value('exam_id'));
if($this->uri->segment(6)){
    $exam_id_input['placeholder'] = '';
    $exam_id_input['value'] = $url->current_exam->exam_id;
                        }
echo form_input($exam_id_input); 
echo '</div></div></div><div class="pb-3"></div><div class="form-row bg-light"><div class="col-lg-6"><div class="form-group">';

//Examination Ordering Position
echo '<h3>'. form_label('Position: ', 'position', 'class="text-success"').'</h3>';
    $pos_count = $position+1;
    if($this->uri->segment(6)){
        $pos_count = $position;
    }
    $pos_option = array();
    for ($i = 1; $i <= $pos_count; $i++) {$pos_option[$i]=$i;}
        echo form_dropdown('position', $pos_option, $pos_count);
echo '</div><div>';
    if(!$this->uri->segment(6)){
        echo form_submit('submit', 'Add Exam');
    }else{
        echo form_submit('submit', 'Edit Exam');
    }
echo '</div></div></div>';
//End of Form
echo form_close(); 

//Close all Opened Tags
echo '</div><div class="row pt-5"><div class="col-lg-6">';

//Navigation Back to Admin Home/main Menu
echo anchor('admin/content', 'Back to Main Menu<span class="lnr lnr-arrow-left"></span>', 'class="genric-btn primary circle arrow"');
echo '</div><div class="col-lg-6">';

//Navigation Back to selecting another Examination Body
echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
echo '</div></div></section></section>';
    
                
   