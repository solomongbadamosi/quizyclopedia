<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container">';
echo '<div class="bg-secondary text-center pt-3 pb-3">';
echo '<h3 class="h3 text-white">Here is Your Performance on '.$_SESSION['combination'][$this->uri->segment(6)]->subject_name.'</h3>';
echo '</div>';

//Subject Navigation Bar
    echo '<div class="container">';
    echo '<ul class="nav nav-tabs">';
        foreach ($_SESSION['combination'] as $exam => $subject){
          echo '<li class="nav-item">';
          $text_color = 'text-white';
            echo '<a class="nav-link '.$text_color.' ';
                    if($_SESSION['combination'][$exam]->subject_id===$this->uri->segment(6)){
                        $text_color = 'text-success';
                        echo 'active '. $text_color;
                       }else{
                           echo ' btn-dark';
                       }
                       
                    echo '" href="'. site_url('exam/content/practice/jamb/performance/'.$_SESSION['combination'][$exam]->subject_id).'">'.strtoupper($_SESSION['combination'][$exam]->subject_name).'</a>
                </li>';
        }
        
    echo '</ul>';
    echo '</div>';
    
//Define Score
$score = 0; 
echo '<div>';
//Get the correct Result for each Question
while($required = $requirement->unbuffered_row()){
    //Define where clause
    $where['question_number'] = $required->question_number;
    echo '<div class="container">';
    //Fetch the Options Selected by Users
        foreach($_SESSION['subjects'][$this->uri->segment(6)] as $key=>$value){
                if($key=='question'.$required->question_number){
                    echo '<div class="container-fluid pt-3">';
                    echo '<h4 class="bg-primary text-white d-inline-flex">Question Number'. $required->question_number.'</h4>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '<div class="col-lg-6">';
                    echo '<h5 class="text-secondary">'.$required->question.'</h5>';
                    echo '</div>';
                    echo '<div class="col-lg-6">';
                    //echo '<h5 class="text-success"><?php //Question image goes here;</h5>
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="container-fluid pt-1">'; 
                    //Get choices
                    $choice = $this->options->data_count($where, 'correct')->row();
                    echo '<div class="d-inline-flex p-2"><span class="font-weight-bold">You Chose: </span>';
                    echo ' <span ';
                    //formatting for Correct Choices and Wrong Choices
                        if($choice){
                            if(strtolower($choice->correct)===strtolower($value)){
                                $score++;
                                echo 'class="text-success"';
                            }else{
                                echo 'class="text-danger"';
                            }
                        }
                    echo '> '.$value. '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="container-fluid pt-1">';
                    echo '<div class="d-inline-flex"><span class="font-weight-bold pl-1">Answer: </span>';
                    echo '<span class="text-success">';if ($choice){echo $choice->correct;}
                    echo '</span>';
                    echo '</div><div class="border"></div><div class="bg-light p-1"></div>';
                    echo '</div>';
    
                    //Add references
                    $reference = $this->references->data_count($where, 'ref')->row();
                    $ref_dia = $this->refdiagrams->data_count($where, 'image')->row();
                    if($reference){
                    echo '<div class="container bg-info">';
                    echo '<div class="container-fluid pt-1">';
                    echo '<h5 class="text-warning">Reference/Explanation:</h5>';
                    echo '</div>';
                    echo '<div class="row">';
                    if($ref_dia){ 
                        echo '<div class="col-lg-6 col-md-6 container-fluid">';
                        echo '<object width="250" height="250" type="image/svg+xml" data="'.site_url('assets/images/'.$ref_dia->image).'">Diagram</object>';
                        echo '</div>';
                    } 
                    echo '<div class="col-lg-6">';
                    echo '<h6 class="text-white">'; 
                    echo $reference->ref.'</h6>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }//End if reference
            }//End if session key equals question number
    }//end foreach
    echo '</div>';
}//endwhile
echo '</div>';
echo '<section class="container"><div class="container-fluid"><div class="container-fluid bg-light pb-3 pt3">';
if($score !==0){
    $final_score = round($score/$count * 100, 2);
}else{
    $final_score = 0;
}
if($final_score < 50){
    $msg = 'You need to try harder and Study wider. You are not a Failure!';
    $class='class="text-danger"';
}elseif($final_score <= 70){
    $msg = 'You should be Proud of yourself, but you can still do better';
    $class='class="text-warning"';
}else{
    $msg = 'EXCELLENT! You are a Genius...';
    $class='class="text-success"';
}
echo '<h2><span class="font-weight-bold">Your Score is: </span><span '.$class.'>'.$final_score.'%</span></h2>';
echo '<h2 '.$class.'>'.$msg.'</h2></div>';
echo '<div class="container bg-secondary p-1">';
echo '<div class="bg-transparent">';

//Navigation
echo form_open();
echo form_submit('another_subject','Choose Another Subject/Combination','class="btn btn-success text-white border btn-block"');
echo form_close();
echo '</div></div></div></section>';
echo '<script type="text/javascript">localStorage.clear();</script>';
echo '</div>';
