<?php $url = $this->myurl->selected_item();
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container p-5">';
if($this->uri->segment(9)!==NULL){
    echo '<div class="bg-secondary text-center pt-3 pb-3">';
    echo '<h4 class="text-white">'.strtoupper($url->current_exam->exam_name).'</h4>';
    echo '</div><div class="container-fluid p-2">';
    echo '<div class="bg-light">';
    echo '<h5 class="h5"><span class="text-success">Subject: </span>'.$url->current_subject->subject_name.'</h5><br/>';
    
    //Heading Adjustment for General Assessment
    if($url->current_body->body_name!=='General Assessment'){
        echo '<h5 class="h5"><span class="text-success">Year: </span><span class="pl-30">'.$url->current_period->period_name.'</span></h5><br/>';
    } 
    //Timing for Objective Questions
    if($url->current_category->category_id==='OBJ' && $url->current_body->body_name!=='General Assessment'){
        if($time){
            //convert decimal hours to minutes
             $minutes = $time->hour * 60;
            $hours = intdiv($minutes, 60).' Hours : ' . ($minutes % 60).' Minutes';
            echo '<h5 class="h5"><span class="text-success">Time Allowed: </span>'.$hours.'</h5><br/>';
        }
        //timing for General Assessment Questions
    }elseif($url->current_body->body_name==='General Assessment'){
        echo '<h5 class="pb-3"><span class="text-success">Instruction:</span> '
            . 'Attempt 60 Questions in 15 Minutes</h5>';
    }//End If Statement
    echo '<h5 class="h5"><span class="text-success">Question Type: </span>'.$url->current_category->category_name.'</h5><br/>';
    echo '</div><div>';
    
    //Navigation to Question
    if($url->current_body->body_name!=='General Assessment'){
    echo form_open('exam/content/question/practice/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
                   $url->current_period->period_id.'/'.$url->current_category->category_id.'/1');
    }else{
        //Generate a random number and pass into question number for General Assessment
        $random = rand(1, $count);
        echo form_open('exam/content/question/practice/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
                   $url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$random);
    }
    echo form_submit('start', 'START', 'class="btn btn-danger"');
    echo '</div>';
}else{
    echo '<div class="container"><div class="bg-secondary text-center pt-3 pb-3">';
    echo '<h4 class="text-white">'.$url->current_subject->subject_name.' Questions';
    if($url->current_body->body_name!=='General Assessment'){ 
        echo '('.$url->current_period->period_name.')'; 
    }
    //Display Examination Instructions for All
    echo '</h4></div><div class="bg-light pt-3"><div class="dropdown-divider"></div>';
    echo '<div class="container-fluid">';
    echo '<h5><span class="text-success">Examination Body: </span><span class="text-heading"><Strong>'
        .$url->current_body->body_name.'</strong></span></h5><br/>';
    echo '<h5><span class="text-success">Examination: </span><span><strong>'
        .$url->current_exam->exam_name.'</strong></span></h5><br/>';
    echo '<h5><span class="text-success">Current Subject: </span><span class="text-danger">'
        .$url->current_subject->subject_name.'</span></h5><br/>';
    if($url->current_body->body_name!=="General Assessment"){
        echo '<h5><span class="text-success">Current Year: </span><span class="text-danger">'
        .$url->current_period->period_name.'</span></h5>';
    }
    echo '</div></div><div class="dropdown-divider"></div><div class="row d-flex pb-5">';
    echo '<div class="col"><div class="container-fluid bg-dark pb-3">';
    echo '<h5 class="text-warning text-center pt-2">Select Question Category</h5>';
    echo '<div class="row">';
        foreach($categories as $category){
            echo '<div class="col-lg-6">';
            echo anchor('exam/content/question/category/'.$url->current_body->body_id.'/'.
            $url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
            $url->current_period->period_id.'/'.$category->category_id, '<button class="btn btn-success">'.$category->category_name.'</button>', 'class="btn"');
            echo '</div>';
        }
    echo '</div></div></div></div>';
    echo '<div class="dropdown-divider"></div>';
    echo '<div class="pb-1 d-flex">';
    echo anchor('exam/content/question/subject/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id, 'Choose Another Subject', 'class="btn btn-dark"');
    echo '</div><div class="pt-1 d-flex">';
    if($this->session->user_category=='Author'){
        echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
    }else{
        echo anchor('exam/user', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
    }    
    echo '</div></div>';
}//End Beginning IF
echo '</div></div><script type="text/javascript">localStorage.clear();</script>';