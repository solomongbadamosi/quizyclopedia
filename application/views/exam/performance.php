<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container">';
echo '<section class="bg-secondary text-center p-2 mb-3">';
echo '<h3 class="text-white">Here is Your Performance</h3>';
echo '</div>';
//Define Score
$score = 0; 
//$url = $this->myurl->selected_item();
$path = 'assets/images/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7)
        .'/'.$this->uri->segment(8);
//Display Attempted Question, Choices and Answers
$attempted = $this->session->userdata('options');
//Get the correct Result for each Question
while($required = $requirement->unbuffered_row()){
    //Iterate through the questions from the database
    $where['question_number'] = $required->question_number;
    echo '<div class="container">';
    //Fetch the Options Selected by Users
    if($attempted){
        foreach($attempted as $key=>$value){
            //Compare answered questions with retrieved questions
            if($key=='question'.$required->question_number){
                echo '<div class="container-fluid p-2 bg-primary">';
                //Question Number
                echo '<h4 class="text-white d-inline-flex">Question Number '. $required->question_number.'</h4>';
                echo '</div>';
                echo '<div class="col">';
                //Question text
                echo '<h6 class="text-secondary m-2">'.$required->question.'</h6>';
                echo '</div>';
                //Question Diagram
                $diagram = $this->questiondiagrams->data_count($where, 'image')->row();
                if($diagram){
                    echo '<div class="col">';
                    echo '<object width="250" height="250" type="image/svg+xml" data="'.site_url($path.'/'.$diagram->image).'">Diagram</object>';
                    echo '</div>';
                } //End If for Diagrams

                echo '<div class="container-fluid pt-1">'; 
                //Get User's selected choice Key
                $chosen = substr($value, -1);
                if($chosen){
                    $db_data = 'correct, '.$chosen;
                }else{
                    $db_data = 'correct';
                }
                
                //Fetch answer and user's choice value of database
                $choice = $this->options->data_count($where, $db_data)->row();
                
                echo '<div class="d-inline-flex p-2 h4"><span class="font-weight-bold">You Chose:</span> ';
                echo ' <span>';
                if($chosen){
                    echo $choice->$chosen. '</span>';
                    //formatting for Correct Choices and Wrong Choices
                        if($choice AND $chosen){
                            if(strtolower($choice->correct)===strtolower($choice->$chosen)){
                                $score++;
                                echo ' &#9989;';
                            }else{
                                echo ' &#10060;';
                            }
                        }
                }else{
                    echo 'NOTHING</span>';
                }
                echo '</div>';
                echo '</div>';
                echo '<div class="container-fluid pt-1">';
                echo '<div class="d-inline-flex  h4"><span class="font-weight-bold pl-1">Answer:</span> ';
                echo '<span class="text-success">';if ($choice){echo $choice->correct;}
                echo '</span>';
                echo '</div>';
                echo '</div>';

                //Add references
                $reference = $this->references->data_count($where, 'ref')->row();
                $ref_dia = $this->refdiagrams->data_count($where, 'image')->row();
                if($reference || $ref_dia){
                echo '<div class="container bg-light p-1 text-center">';
                echo '<div class="container-fluid pt-1">';
                echo '<h5 class="text-warning">Reference/Explanation Number '.$required->question_number. '</h5>';
                echo '</div></div>';
                    //display reference diagram
                    if($ref_dia){
                        echo '<div class="col container-fluid">';
                        echo '<object width="250" height="250" type="image/svg+xml" data="'.site_url($path.'/'.$ref_dia->image).'">Diagram</object>';
                        echo '</div>';
                    } //end reference diagram
                    if($reference){
                        echo '<div class="col text-center">';
                        echo $reference->ref;
                        echo '</div>';
                        echo '<div class="border"></div><div class="bg-light p-1"></div>';
                    }//end reference text display
                }//End if reference
            }//End if session key equals question number
        }//end foreach
    }//End of if attempted
    echo '</div>';
}//endwhile
echo '<div class="container mt-3 mb-2"><div class="container-fluid"><div class="container-fluid bg-light pb-3 pt3">';
$final_score = round($score/$count * 100, 2);
//Set the Final Score in Session
if(!isset($_SESSION['score'])){
    $_SESSION['score'] = $final_score;
}
//Perform Grading
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
echo '<h5>Your Score is: <span '.$class.'>'. $final_score.'%</span></h5>';
echo '<h6 '.$class.'>'.$msg.'</h6></div>';
echo '<div class="container bg-secondary p-1">';
echo '<div class="bg-transparent">';
//modal download button
if($this->uri->segment(5)!=5){
    echo '<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#pdfDownload">
     Download Result
    </button>';
}

echo form_open();
echo form_submit('reset','Retake this Exam','class="btn btn-warning text-white border btn-block"');
if($this->session->user_category!=='Referral'){
    if($this->uri->segment(5)!=5){
        echo form_submit('another_subject','Choose Another Subject/Year','class="btn btn-success text-white border btn-block"');
    }
    echo form_submit('another_exam','Choose Another Examination','class="btn btn-dark text-white border btn-block"');
}
if($this->session->user_category==='Referral'){
    echo form_submit('go_home', 'Back to Dashboard', 'class="btn btn-success text-white border btn-block"');
}
echo form_close();
echo '</div></div></div></section>';
echo '<script type="text/javascript">localStorage.clear();</script>';
echo '</div>';

$this->load->view('exam/download_result');