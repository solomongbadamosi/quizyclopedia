<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$url = $this->myurl->selected_item();
//FORM FOR ADDING AND EDITING QUESTIONS
echo '<section class="container"><section class="bg-secondary text-center pt-3 pb-3"><h1 class="h1 text-white">';
//Heading 
echo $url->current_subject->subject_name;
echo '</h1></section>';
//Question Form
echo '<section class="pt-3">';
echo form_open_multipart(); 
    $form_constants = array(
        'body_id'=>$url->current_body->body_id,
        'subject_id'=>$url->current_subject->subject_id,
        'period_id'=>$url->current_period->period_id,
        'exam_id'=>$url->current_exam->exam_id,
        'category_id'=>$url->current_category->category_id
    );
echo form_hidden($form_constants);
echo '<div class="container"><div class="form-row"><div class="col-lg-6 form-group">';
//Examination Instructions
echo '<h4 class="text-success">'. form_label('Instruction', 'instructions').'</h4>'; 
    $inst_data = array(
        'name'=>'instruction',
        //'id' => 'instruction',
        'class'=>'ckeditor',
    );
    $form_constants['question_number'] = $qnum;
    //check to see if there are instructions
    $inst = $this->instructions->data_count($form_constants, 'instruction')->row();
    if($inst){
        $inst_data['value']=$inst->instruction;
    }else{
        $inst_data['placeholder']='Enter Question Instructions, If Any';
    }
    echo form_textarea($inst_data);
echo '</div><div class="col-lg-2"></div><div class="col-lg-4 form-group"><div class="form-row"><div class="col pb-3 pt-5">';

//Question Number
echo '<h6 class="text-success">'. form_label('Question Number', 'question_number').'</h6>';
        $numbers = $this->questions->find_count($url->current_body->body_id, 
        $url->current_exam->exam_id, 
        $url->current_subject->subject_id, 
        $url->current_period->period_id, 
        $url->current_category->category_id)+1;
        $option = array();
        for ($i = 1; $i <= $numbers; $i++) {$option[$i]=$i;}
        if($question){
            echo form_dropdown('question_number', $option, $question['question']->question_number);
        }else{
            echo form_dropdown('question_number', $option, $numbers);
        }
echo '</div><div class="col bg-light">';

//Question Diagrams
echo '<h6 class="text-success">'. form_label('Add Question Diagram', 'diagram').'</h6>';
echo form_upload('diagram');

echo '<div class="p-2"></div>';

//Instruction Diagrams
echo '<h6 class="text-success">'. form_label('Add Instruction Diagram', 'inst_diagram').'</h6>';
echo form_upload('inst_diagram');

echo '</div></div></div></div><div class="dropdown-divider"></div><div class="form-row bg-light"><div class="col form-group">';

//Questions
echo '<h5 class="text-success">'. form_label('Questions', 'question').'</h5>'; 
    $ques_data = array(
        'name'=>'question',
        //'class'=>'form-control',
        'class'=>'ckeditor',
    );
    if($question){
        $ques_data['value']=$question['question']->question;
    }else{
        $ques_data['placeholder']='Enter Question here';
    }
    echo form_textarea($ques_data);
echo '</div></div>';

//Load Options if Questions are Multiple Choices
if($url->current_category->category_id=='OBJ'){
    echo '<div class="dropdown-divider"></div><div class="form-row">';
    //check if it is not calculations
    $calculations=array('MTH', 'PHY', 'CHEM', 'QTR', 'FMATH', 'COMP');
    if(!in_array($this->uri->segment(7), $calculations)){
        echo '<div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option A', 'A').'</h6>';
        //Option 1
            $o1_data = array(
                'name'=>'A',
                'class'=>'form-control',
            );
            if($question){
                if($question['option']){
                    $o1_data['value']=$question['option']->A;
                }
            }else{
              $o1_data['placeholder']='Option A';
            }
        echo form_input($o1_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option B', 'B').'</h6>';
        //Option 2
            $o2_data = array(
                'name'=>'B',
                'class'=>'form-control',
            );
            if($question){
                if($question['option']){
                    $o2_data['value']=$question['option']->B;
                }
            }else{
                $o2_data['placeholder']='Option B';
            }
            echo form_input($o2_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option C', 'C').'</h6>';
        //Option 3
            $o3_data = array(
                'name'=>'C',
                'class'=>'form-control',
            );
            if($question){
                if($question['option']){
                    $o3_data['value']=$question['option']->C;
                }
            }else{
               $o3_data['placeholder']='Option C';
            }
            echo form_input($o3_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option D', 'D').'</h6>'; 
        //Option 4
            $o4_data = array(
                'name'=>'D',
                'class'=>'form-control',
            );
            if($question){
                if($question['option']){
                    $o4_data['value']=$question['option']->D;
                }
            }else{
               $o4_data['placeholder']='Option D';
            }
            echo form_input($o4_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option 5', 'E').'</h6>';
        //Option 5
            $o5_data = array(
                'name'=>'E',
                'class'=>'form-control',
            );
            if($question){
                if($question['option']){
                    $o5_data['value']=$question['option']->E;
                }
            }else{
                $o5_data['placeholder']='Option E';
            }
            echo form_input($o5_data);
        echo '</div><div class="col-lg-4 form-group bg-secondary">';
        echo '<h6 class="text-warning">'. form_label('Answer', 'correct_option').'</h6>';
        //correct Option
            $co_data = array(
                'name'=>'correct_option',
                'class'=>'form-control',
            );
            if($question){
                if($question['option']){
                    $co_data['value']=$question['option']->correct;
                }
            }else{
               $co_data['placeholder']='Right Answer';
            }
            echo form_input($co_data);
        echo '</div>';
    }else{
        //calculations input
        echo '<div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option 1', 'A').'</h6>';
        //Option 1
            $o1_data = array(
                'name'=>'A',
                'class'=>'ckeditor',
            );
            if($question){
                if($question['option']){
                    $o1_data['value']=$question['option']->A;
                }
            }else{
              $o1_data['placeholder']='Option A';
            }
        echo form_textarea($o1_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option B', 'B').'</h6>';
        //Option 2
            $o2_data = array(
                'name'=>'B',
                'class'=>'ckeditor',
            );
            if($question){
                if($question['option']){
                    $o2_data['value']=$question['option']->B;
                }
            }else{
                $o2_data['placeholder']='Option B';
            }
            echo form_textarea($o2_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option C', 'C').'</h6>';
        //Option 3
            $o3_data = array(
                'name'=>'C',
                'class'=>'ckeditor',
            );
            if($question){
                if($question['option']){
                    $o3_data['value']=$question['option']->C;
                }
            }else{
               $o3_data['placeholder']='Option C';
            }
            echo form_textarea($o3_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option D', 'D').'</h6>'; 
        //Option 4
            $o4_data = array(
                'name'=>'D',
                'class'=>'ckeditor',
            );
            if($question){
                if($question['option']){
                    $o4_data['value']=$question['option']->D;
                }
            }else{
               $o4_data['placeholder']='Option D';
            }
            echo form_textarea($o4_data);
        echo '</div><div class="col-lg-4 form-group">';
        echo '<h6 class="text-success">'. form_label('Option 5', 'E').'</h6>';
        //Option 5
            $o5_data = array(
                'name'=>'E',
                'class'=>'ckeditor',
            );
            if($question){
                if($question['option']){
                    $o5_data['value']=$question['option']->E;
                }
            }else{
                $o5_data['placeholder']='Option E';
            }
            echo form_textarea($o5_data);
        echo '</div><div class="col-lg-4 form-group bg-secondary">';
        echo '<h6 class="text-warning">'. form_label('Answer', 'correct_option').'</h6>';
        //correct Option
            $co_data = array(
                'name'=>'correct_option',
                'class'=>'ckeditor',
            );
            if($question){
                if($question['option']){
                    $co_data['value']=$question['option']->correct;
                }
            }else{
               $co_data['placeholder']='Right Answer';
            }
            echo form_textarea($co_data);
        echo '</div>';
        //echo '</div>';
    }
    echo '</div>';
}//End of Condition for Objective Options
//Reference/Explanation
$ref = $this->references->data_count($form_constants, 'ref')->row();
    echo '<h4 class="text-warning">'. form_label('Reference/Explanation', 'ref').'</h4>';
        $ref_data = array(
            'name'=>'ref',
            'class'=>'ckeditor',
        );
        if($ref){
            $ref_data['value']=$ref->ref;
        }else{
            $ref_data['placeholder']='References';
        }
        echo form_textarea($ref_data);
//Solution Diagrams
echo '<h5 class="text-success">'. form_label('Add Solution Diagram', 'sol_diagram').'</h5>';
echo form_upload('sol_diagram');

//Submit Button
echo '<br /><div class="pt-3 form-row bg-light btn-group"><button>';
echo form_submit('submit', 'Submit');

//End of Form
echo form_close();
//Button to return Choose Another Subject
echo '</button><button class="btn btn-danger">';
echo anchor('admin/content/manage/exam/'.$url->current_body->body_id.'/'
    .$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'
    .$url->current_period->period_id, 'Choose Another Subject', 'class="btn btn-danger"');
echo '</button></div></div></section></section>';