<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="container">';
    echo '<section class="bg-secondary text-center pt-3 pb-3">';
    echo '<h3 class="h3 text-white">JAMB EXAMINATION SIMULATOR</h3>';
    echo '</section><br/><div class="container-fluid">';
    echo '<section class="bg-light">';
    echo '<h5 class="h5 text-success">Subject Combinations:</h5>';
    //List the subjects combination chosen
    echo '<ul class="pl-5">';
    $subjects = array();
        foreach ($_SESSION['combination'] as $exam => $subject){
         echo '<li><strong>'.$_SESSION['combination'][$exam]->subject_name.'</strong></li>';
           if($_SESSION['combination'][$exam]->subject_id!=='ENG'){
                $subjects[$exam] = $_SESSION['combination'][$exam]->subject_name;
           }
        }
    echo '</ul>';
   
        //Timing 
            //convert decimal hours to minutes
             $minutes = $_SESSION['exam_time'] * 60;
            $hours = intdiv($minutes, 60).' Hours : ' . ($minutes % 60).' Minutes';
            echo '<h5 class="h5"><span class="text-success">Time Allowed: </span>'.$hours.'</h5><br/>';
        echo '<h5 class="h5"><span class="text-success">Examination Year: </span>'.$year->period_name.'</h5><br/>';
    $all_numbers = array($_SESSION['subjects']['ENG']['count'], );
    //Instructions
    echo '<h5 class="h5 text-warning">Instruction:</h5>';
    echo '<p class="text-justify">You have <strong>'.$_SESSION['subjects']['ENG']['count'].'</strong> questions to attempt on English Language, ';
            foreach($subjects as $key=>$value){
                //$total = $_SESSION['subjects']['ENG']['count'] + $_SESSION['subjects'][$key]['count'];
                $all_numbers[] = $_SESSION['subjects'][$key]['count'];
                foreach($_SESSION['subjects'] as $subject_id=>$data){
                    if($subject_id===$key){
                        echo ' <strong>'.$_SESSION['subjects'][$key]['count'] .'</strong> question(s) on '. $value.',';
                    }
                }
            }
            $total = array_sum($all_numbers);
    echo ' and a Sum of <strong>'.$total.'</strong> questions in all starting with English Language. '
            . 'Once you have answered a question, you will be required to click on '
            . '"Next" button to move to the next question and click "Submit" when you are done with or tired of the examination. '
            .'</p>';
    echo '<p class="text-justify">Click on the <strong><span class="text-danger">"START"</span></strong> button to Begin</p>';

    echo form_open('exam/content/practice/jamb/question/ENG/1');
    echo form_submit('start', 'START', 'class="btn btn-danger"');
    echo form_close();
    echo '</section>';
//    
echo '</section><script type="text/javascript">localStorage.clear();</script>';

