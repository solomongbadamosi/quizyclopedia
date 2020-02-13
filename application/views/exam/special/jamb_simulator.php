<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container">';
echo '<div class="bg-secondary text-center p-3">';
echo '<h3 class="h3 text-white">Select Subject Combinations</h3>';
echo '</div>';
echo '<div class="p-2">';
echo '<div class="container">';
echo '<p class="text-danger">Please select your subject combinations. English Language 
        is compulsory so you are allowed to select 3 other subjects 
        of your choice below. 
        </p>';
echo form_open();
                
//Examination years
echo '<div class="p-3 bg-success col-lg-3">';
echo '<button type="button" class="btn tbn-secondary dropdown-toggle-split">';
echo '<select name="period_id">';
echo '<option value="default">Choose Examination Year</option>';
    foreach($exam_periods->result() as $serial=>$period){ 
        //print_r($period_name);
        echo '<option value="'.$period->period_id.'">';
        echo $period->period_name;
        echo '</option>';
    }//End Foreach
    echo '</select></button></div>';
                
    //JAMB Subjects
    foreach($subjects as $subject){
        echo '<div>';
        $data = array(
            'name'=>$subject->subject_id,
            'value'=>$subject->subject_name,
        );
        if($subject->subject_name === 'English Language'){
            $data['checked']=TRUE;
            $data['disabled']='disabled';
        }

        echo form_checkbox($data);
        echo form_label($subject->subject_name);
        echo '</div>';
    }
    echo '<div class="bg-light p-2 text-center">';
    echo form_submit('submit','Start Examination','class="btn btn-danger"');
    echo '</div>';
    echo form_close();
echo '</div>';
echo '</section>';
echo '<div class="col-md-6 p-1">';
echo anchor('exam/content/home', 'Choose Another Examination', 'class="btn btn-dark"');
echo '</div>';
    if($this->uri->segment(6)==='JAMB'){
        echo '<div class="col-md-6 p-1">';
        echo anchor('exam/content/question/subject/4/JAMB', 'Select Another Environment', 'class="btn btn-primary"');
        echo '</div>';
    }
echo '</div>';