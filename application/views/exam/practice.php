<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<div class="container">';
//set url variable
$url = $this->myurl->selected_item();
//set image path
$path = 'assets/images/'.$this->uri->segment(5).'/'.$this->uri->segment(6)
        .'/'.$this->uri->segment(7).'/'.$this->uri->segment(8);
//check if there are questions in the database
if($question->question && $count > 10){
  //set navigation for questions
   $current = $this->uri->segment(10); 
        $next = $current+1;
        $prev = $current-1;
        
   //Get attempted questions
        if($this->session->userdata('options')){
            $attempted_question = $this->session->userdata('options');
        }else{
            $attempted_question = array(1);
        }
    echo '<div class="bg-secondary text-center p-3">';
    echo '<h4 class="text-white">'.strtoupper($url->current_subject->subject_name).'</h4>';

    //Display Time for Objective Questions
    if($url->current_category->category_id==='OBJ'){
        echo '<div class="container">';
        echo '<h3 class="bg-warning">TIME: <span id="time" class="text-white"></span></h3>';
        echo '</div>';
    }
    echo '</div>';
    
    //check if start button was hit!
    if($this->session->start){
        //check to see if the question is objective or theory
        if($url->current_category->category_id==='OBJ'){
            if($time){
                //if it is objective, confirm that it is not general question to set examination time
                if($url->current_body->body_name !=='General Assessment'){
                    $time_set = $time->hour*3600;
                }else{
                    $time_set = 900;
                }//End if for General Assessment
            }

            //Display Question Instructions and Diagram if any
            echo '<div class="p-2">';
            if($question->inst){
                echo '<div class="bg-danger"><div class="container p-2">';
                echo '<h3 class="text-white">Instruction: </h3>';
                //echo '<div class="row">';
                echo '<div class="col text-white">';
                echo $question->inst->instruction. '</div>';
                echo '</div></div>';
            }//End If for Instruction
            
            if($question->inst_diagram){
                echo '<div class="col p-1 text-center">';
                echo '<object width="250" height="250" type="image/svg+xml" data="'.site_url($path.'/'.$question->inst_diagram->image).'">Diagram</object>';
                echo '</div>';
            }//End of Instruction Dagram

            echo '<div class="container-fluid bg-light"><div class="container">';
            echo form_open();
            //display question number
            echo '<br /><div class="bg-secondary">';
            //Number of Questions for Non-General Assessment Questions
            if($url->current_body->body_name !=='General Assessment'){
                echo '<h6 class="text-white p-2"><span class="font-weight-bold">Question Number: </span>'
                .$question->question->question_number. ' of '. $count. '</h6>'; 
            }
            echo '</div>';
            echo '<div class="row">';
            //Questions
            echo '<div class="col-lg-6">'.$question->question->question;
                    //Display Diagram
                    if($question->q_diagram){ 
                        echo '<object width="250" height="250" type="image/svg+xml" data="'.site_url($path.'/'.$question->q_diagram->image).'">Diagram</object>';
                    } //End If for Diagrams
            echo '</div>';
            
            

            //Options
            echo '<div class="container">';
            //set all options in a single array
            if($question->option){
                foreach($question->option as $option_key=>$option_value) {
                    // User selected option should be checked throughout the examination period
                    $checked = '';
                    if($attempted_question){
                    foreach($attempted_question as $key=>$value){
                        $data = array($key => $key);
                        if(preg_grep ('/question/', $data)){
                            if($key==='question'.$current && $value=='option'.$option_key){
                                $checked = "checked='checked'";
                            }
                        }
                    }
                }
                //check if question option is not empty
                    if($option_value){
                    /**
                     * iterate through the options and display
                     * check to see if the current exam involves calculations first
                     */
                     $fraction = array('CHEM', 'COMP', 'FMATH', 'PHY', 'MTH', 'QTR');
                    echo '<div class="row">';
                    if(in_array($this->uri->segment(7), $fraction)){
                        echo  "<input ".$checked." type=\"radio\" class=\"m-1\" name=\"option{$option_key}\" value='".$option_value."'> ";
                    }else{
                        echo  "<input ".$checked." type=\"radio\" class=\"m-1\" name=\"option{$option_key}\" value=\"".$option_value."\"> ";
                    }
                    
                    echo  "<span class=\"col\">";
                    echo $option_value;
                    echo "</span>";
                    echo '</div>';
                    }
                }
            }//End if Question Option
            echo '</div></div><div class="divide-right"></div>';
            
            echo '<div class="pb-5"></div></div></div>';
            echo '<div class="bg-dark pt-2 pb-2"><div class="container row"><div class="col-lg-6">';

            //NAVIGATION AREA
            //Navigation for Non-General Assessment
            echo '<div class="btn-group">';
            if($url->current_body->body_name!=='General Assessment'){
                if($prev > 0){
                    echo '<div class="btn">';
                    echo anchor('exam/content/question/practice/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
                            $url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$prev, 'Previous', 'class="btn btn-primary"');
                    echo '</div>';
                } 
            }//End of Navigation If
            echo '<div class="btn">';
            echo form_hidden('qnum', $this->uri->segment(10));
            //check if the current question number is not the last
            if($url->current_body->body_name!=='General Assessment'){
                if($current != $count){
                    echo form_submit('next', 'Next Question', 'class="btn btn-success"');
                }
            }else{
                if(count($attempted_question)<59){
                   echo form_submit('next', 'Next Question', 'class="btn btn-success"');
                }
            }
            echo '</div></div></div><div class="col-lg-3"></div><div class="col-lg-3"><div class="btn float-right">';
            echo form_submit('submit', 'Submit', 'class="btn btn-danger" title="Be sure you are done, please!"');
          	if($url->current_body->body_name!=='General Assessment'){
          		//Goto Button
          		echo '<button type="button" class="btn tbn-secondary dropdown-toggle-split">';
    			echo '<select name="subject_id" onchange="window.location.href=this.value;">';
    			echo '<option value="">Question Number</option>';
    			foreach(range(1, $count) as $question_number){
        			echo '<option value="'.site_url('exam/content/question/practice/'.$url->current_body->body_id.'/'
                	.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.$url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$question_number).'">';
        			echo $question_number;
        			echo '</option>';
    			}//End Foreach
    			echo '</select></button>';
            }
            echo '</div></div>';
            echo form_close();
            echo '</div></div></div>';
?>
<script>
if (typeof(Storage) === "undefined") 
{
    alert("Your browser does not support this timing system");
}
var seconds = '<?php echo json_encode($time_set) ?>';
if (localStorage.getItem("seconds") !== null) 
{
    seconds = localStorage.getItem("seconds");
}



function secondPassed() 
{
            var minutes = Math.floor((seconds) / 60);
            console.log(minutes);
            var hours = Math.floor((minutes) / 60);
            var remainingSeconds = seconds % 60;
			minutes %=60;
            if (remainingSeconds < 10) {
                remainingSeconds = "0" + remainingSeconds;
            }
            document.getElementById('time').innerHTML = hours + ":" + minutes + ":" + remainingSeconds;
            if (seconds === 0 || seconds < 0) {
                clearInterval(myVar);
                document.getElementById('time').innerHTML = "Time Out";
                document.querySelector('[name="submit"]').click();
            } else {
                seconds--;
                console.log(seconds);
            }
            localStorage.setItem("seconds",seconds);
}

var myVar = setInterval(secondPassed, 1000);


</script>
<?php
 //THEORY SECTION
        }else{
            echo '<section class="container pt-3">';
            if($question->inst){ 
                echo '<div class="bg-danger"><div class="container"><h3 class="text-white">Instruction: </h3>';
                echo '<div class="col text-white">';
                echo $question->inst->instruction.'</div>';
                echo '</div></div>';
            }//End of Instruction text
            
            //Diagram
            if($question->inst_diagram){
                echo '<div class="col"><object width="250" height="250" class="img-fluid" type="image/svg+xml" data="'
                .site_url($path.'/'.$question->inst_diagram->image).'"></object></div>';
            }//End of Instruction Diagram
            
            echo '<div class="bg-secondary">';
            echo '<h5 class="text-white p-2"><span class="font-weight-bold">Question Number:</span> #'
            .$question->question->question_number. ' of '.$count. '</h5>';
            echo '</div><div class="container"><div class="row">';
            if($question->q_diagram){
                echo '<div class="col-lg-6">';
            }else{
                echo '<div class="col">';
            }
            //Questions
            echo $question->question->question; 
            echo '</div>';
            //Display Diagram
            if($question->q_diagram){ 
                echo '<div class="col-lg-6 col-md-6 container-fluid">';
                echo '<object width="250" height="250" type="image/svg+xml" data="'.site_url($path.'/'.$question->q_diagram->image).'">Diagram</object>';
                echo '</div>';
            } //End If for Diagrams
            echo '</div><div class="btn-group">';
            echo anchor_popup('exam/content/result/essay/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
                $url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$question->question->question_number, '<button class="btn btn-danger">View Solution</button>', 'class="border"');
            echo '</div><div class="btn-group">';
            if($prev >0){
                //previous Button
                echo anchor('exam/content/question/practice/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
                    $url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$prev, 
                    'Previous', 'class="btn btn-primary"'); 
            } 
            //Next Buttion
            if($next <= $count){
                echo anchor('exam/content/question/practice/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
                $url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$next, 'Next Question', 'class="btn btn-success"');
            }
            echo '</div><div class="pt-3">';
            echo anchor('exam/content/question/subject/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id, 
                '<button class="btn btn-primary">Select Another Subject or Year</button>', 'class="border"');
            echo '</div></div></section>';
        }//End If Objective and Theory
    }else{
        //If User did not get here by Start Button
        redirect('exam/content/result/no_back');
    }
}else{
    //There is not Question Yet for this Year
    echo '<div class="container center">';
    echo '<h5 class="text-success">Work is in Progress! Please bear with Us.</h5>';
    echo '<div class="container-fluid row">';
    echo '<div class="col-lg-5 p-1">';
    if($this->session->user_category=='Author'){
        echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
    }else{
        echo anchor('exam/user', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
    }
    echo '</div>';
    echo '<div class="col-lg-5 p-1">';
    echo '<a href="'.site_url('exam/content/question/subject/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id).'" class="btn btn-dark col-sm-6">Choose Another Subject</a>
        </div></div>';
    echo '</div>';
}
echo '</div>';