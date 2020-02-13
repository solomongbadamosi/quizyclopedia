<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="container"><div class="bg-secondary text-center pt-3 pb-3">
        <h1 class="h1 text-white">Manage Content</h1></div><br/><div class="container-fluid">
        <table class="table table-hover"><thead class="bg-light"><tr><th scope="col"><table><thead><tr>';
// Table Head for Body
echo '<th scope="col">BODY NAME</th></tr></thead></table></th><th scope="col"><table><thead><tr>';
echo '<th scope="col">EXAMINATIONS</th></tr></thead></table></th>';

//Only Author can manipulate the data
if($this->session->userdata('user_category')=='Author'){
    echo '<th scope="col"><table><thead><tr><th scope="col">TASKS</th></tr></thead></table></th>';
} 
echo '</tr></thead><tbody>';
//Itterate All Examination Bodies
while ($body = $bodies_set->unbuffered_row()){ 
    echo '<tr><th scope="row" class="align-middle">';
    echo $body->body_name;
    //Activate and Deactivate examination Body
    if($this->session->userdata('user_category')=='Author'){
        if($body->ready==TRUE){
            echo anchor(site_url('admin/content/deactivate/body/'.$body->body_id), '<br /><button class="btn btn-danger text-white" id="myTd3">Deactivate</button>');
        }else{
            echo anchor(site_url('admin/content/activate/body/'.$body->body_id), '<br /><button class="btn btn-success text-white" id="myTd3">Activate</button>');
        }
    }
    echo '</th><td><table class="table table-success table-striped"><tbody>';
    
    //Load Examinations belonging to Each Body
    $exams_set = $this->examinations->find_by_index($body->body_id) ;
    while ($exam = $exams_set->unbuffered_row()) { 
        echo '<tr><th scope="row">';
        echo anchor(site_url('admin/content/manage/exam/'.$body->body_id.'/'.$exam->exam_id), $exam->exam_name, 'class="text-success"');
        //Activate Examination Body
        if($this->session->userdata('user_category')=='Author'){
            if($exam->ready==TRUE){
               echo anchor(site_url('admin/content/deactivate/exam/'.$exam->exam_id), '<br /><button class="btn btn-danger text-white" id="myTd3">Deactivate</button>');
           }else{
               echo anchor(site_url('admin/content/activate/exam/'.$exam->exam_id), '<br /><button class="btn btn-success text-white" id="myTd3">Activate</button>');
           }
        }
        echo '</th>';
        
        //If user is Author, Allow to Delete Examination
        if($this->session->userdata('user_category')==='Author'){ 
                echo '<td class="btn-group">'.anchor('admin/content/update/exam/'.$body->body_id.'/'.$exam->exam_id, '<button class="text-success">Edit</button>');
                echo anchor('admin/content/delete/exam/'.$body->body_id.'/'.$exam->exam_id, '<button class="text-danger delete">Delete</button>', 'class="delete"');
                echo '</td>';
        } 
        echo '</tr>';
    }//End Examination While Loop
    echo '</tbody></table></td>';
    //Only Author Can Add, Delete and Edit Examination Body
    if($this->session->userdata('user_category')==='Author'){ 
        echo '<td class="align-middle btn-group">';
        echo anchor(site_url('admin/content/update/body/'.$body->body_id), '<button class="btn btn-primary text-white multi-collapse" id="myTd1">Edit</button>'); 
        echo anchor(site_url('admin/content/delete/body/'.$body->body_id), '<button class="btn btn-danger text-white multi-collapse delete" id="myTd2">Delete</button>', '', 'title="'.$body->body_name.'"'); 
        echo anchor(site_url('admin/content/update/exam/'.$body->body_id), '<button class="btn btn-info text-white multi-collapse" id="myTd3">+Add Exam</button>');
        echo '</td>';
    } //End If Statement
    echo '</tr>';
}//End Examination Body While Loop
echo '</tbody></table></div><div class="p-3">';

//Load Pagination
echo $pagination['pages']; 
echo '</div>';

//Only Author can Add Items
if($this->session->userdata('user_category')=='Author'){
    echo '<div class="bg-secondary text-center pt-3"><div class="tab-content"><div class="container">';
    echo '<div class="row"><div class ="col-lg-4 align-middle"><div class="btn">
          <button class="btn btn-dark" role="button" type="button" data-toggle="collapse" data-target="#collapseBody">
          Add New Examination Body</button></div><div id="collapseBody" class="collapse">';
 
    //Form for Adding Examination Body
    echo form_open('admin/content/manage/body'); 
    echo '<div class="container container-fluid pl-3"><div>';
    $body_input = array('name'=>'body name','placeholder'=>'Enter Body Name' ,'type'=>'text', set_value('body_name'));
    echo form_input($body_input); 
    echo '</div><div>';
    echo form_submit('body', 'Add Body');
    echo '</div></div></div>';
    echo form_close(); //End of Add Examination Body Form
    
    //Add A New year to the Software System
    echo '</div><div class ="col-lg-4 align-middle"><div class="btn">
          <button class="btn btn-dark" role="button" type="button" data-toggle="collapse" data-target="#collapsePeriod">
          Add a New Year to the System</button></div>';
    //form for Adding New Subject
    echo '<div id="collapsePeriod" class="collapse">';
    echo form_open('admin/content/update/period'); 
    echo '<div class="container container-fluid pl-3" ><div>';
    $p_name_input = array('name'=>'period_name', 'placeholder'=>'What Year is it?', 'type'=>'text', set_value('period_name'));
    echo form_input($p_name_input); 
    echo '</div><div>';
    $p_id_input = array('name'=>'period_id','placeholder'=>'Year Code e.g. YrK001 = 2001', 'type'=>'text', set_value('period_id'));
    echo form_input($p_id_input); 
    echo '</div><div>';
    echo form_submit('period', 'Add Period');
    echo '</div></div></div>';
    echo form_close(); //End of Form for Adding Examination Years
    echo '</div>';

    //Add Subjects to the System
    echo '<div class ="col-lg-4 align-middle"><div class="btn">
          <button class="btn btn-dark" role="button" type="button" data-toggle="collapse" data-target="#collapseSubject">
          Add a New Subject to the System</button></div>';
    
    //Display form for Adding New Subject
    echo '<div id="collapseSubject" class="collapse">';
    echo form_open('admin/content/update/subject');
    echo '<div class="container container-fluid pl-3" ><div>';
    $s_name_input = array('name'=>'subject_name','placeholder'=>'Enter Subject Name' ,'type'=>'text', set_value('subject_name'));
    echo form_input($s_name_input); 
    echo '</div><div>';
    $s_id_input = array('name'=>'subject_id','placeholder'=>'Assign Code to Subject', 'type'=>'text', set_value('subject_id'));
    echo form_input($s_id_input); 
    echo '</div><div>'; 
    echo form_submit('subject', 'Add Subject');
    echo '</div></div>';
    echo form_close(); //End of Form for Subject
    echo '</div></div></div></div></div></div>';
}//End If Statement

echo '<div class="p-3"></div>';
//Navigate Back to Main menu
echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
echo '</section>';
