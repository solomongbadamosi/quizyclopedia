<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//set image path
$path = 'assets/images/4/JAMB/'.$this->uri->segment(6).'/'.$_SESSION['period'];
//check if there are questions in the database
if($question->question){
      //set navigation for questions
       $current = $this->uri->segment(7); 
            $next = $current+1;
            $prev = $current-1;

       $attempted_question = array();
       //Capturing Attempted Questions
        foreach($_SESSION['subjects'][$this->uri->segment(6)] as $key=>$value){
            $data = array($key => $key);
            if(preg_grep ('/question/', $data)){
                $attempted_question[$this->uri->segment(6)]=$key;
                }
            }
    
    //Check if the start button is active
    if($this->session->start){
        //Subject Navigation Bar
        echo '<section class="container p-2">';
        echo '<ul class="nav nav-tabs nav-justified">';
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

                        echo '" href="'. site_url('exam/content/practice/jamb/question/'.$_SESSION['combination'][$exam]->subject_id.'/1').'">'.strtoupper($_SESSION['combination'][$exam]->subject_name).'</a>
                    </li>';
            }
        echo '</ul>';

        echo '<div class="bg-secondary text-center pt-3 pb-3">';
        //Current Subject
        echo '<h3 class="h3 text-white">'.strtoupper($current_subject->subject_name).'</h3>';

        //Display Time for Objective Questions
            echo '<div class="container">';
            echo '<h3 class="bg-warning">TIME: <span id="time" class="text-white"></span></h3>';
            echo '</div>';
        echo '</div>';
        //check if start button was hit!
            $time_set = $time*3600;

            //Display Question Instructions and Diagram if any
            echo '<div>';
            if($question->inst){
                echo '<div class="bg-danger"><div class="container p-2">';
                echo '<h3 class="h3 text-white">Instruction: </h3>';
                //echo '<div class="row">';
                echo '<div class="col text-white">';
                echo $question->inst->instruction. '</div>';
                echo '</div></div>';
            }//End If for Instruction
            
            if($question->inst_diagram){
                echo '<div class="col p-1">';
                echo '<object width="250" height="250" type="image/svg+xml" data="'.site_url($path.'/'.$question->inst_diagram->image).'">Diagram</object>';
                echo '</div>';
            }//End of Instruction Diagram


                echo '<div class="container-fluid bg-light"><div class="container">';
                echo form_open();
                //display question number
                echo '<br /><div class="bg-secondary">';
                //Number of Questions for Non-General Assessment Questions
                    echo '<h5 class="text-white p-2"><span class="font-weight-bold">Question Number: </span>'
                    .$question->question->question_number. ' of '. $_SESSION['subjects'][$this->uri->segment(6)]['count']. '</h5>'; 
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
                    $options = array($question->option->A, $question->option->B, $question->option->C, $question->option->D, $question->option->E); // You can add as many as you want!
                    foreach($options as $opt) {
                        // User selected option should be checked throughout the examination period
                        $checked = '';
                        foreach($_SESSION['subjects'][$this->uri->segment(6)] as $key=>$value){
                            $data = array($key => $key);
                            if(preg_grep ('/question/', $data)){
                                if($key==='question'.$current && $value==$opt){
                                    $checked = "checked='checked'";
                                }
                            }
                    }
                    //check if question option is not empty
                        if($opt){
                        // Iterate Options
                        echo "<div class=\"row p-1\"><input ".$checked." type=\"radio\" name=\"option\" value=\"".$opt."\"><span class=\"pl-3\">".$opt."</span></div>";
                        }
                    }
                }//End if Question Option
                echo '</div></div><div class="divide-right"></div>';

                echo '<div class="pb-5"></div></div></div>';
                echo '<div class="bg-dark pt-2 pb-2"><div class="container row"><div class="col-lg-6">';

                echo '<div class="btn-group">';
                    if($prev > 0){
                        echo '<div class="btn">';
                        echo anchor('exam/content/practice/jamb/question/'.$this->uri->segment(6).'/'.$prev, 'Previous', 'class="btn btn-primary"');
                        echo '</div>';
                    } 
                echo '<div class="btn">';
                echo form_hidden('qnum', $this->uri->segment(7));
                //check if the current question number is not the last
                    if($current != $_SESSION['subjects'][$this->uri->segment(6)]['count']){
                        echo form_submit('next', 'Next Question', 'class="btn btn-success"');
                    }else{
                        echo form_submit('next', 'Next Subject', 'class="btn btn-success"');
                    }
                echo '</div></div></div><div class="col-lg-3"></div><div class="col-lg-3"><div class="btn float-right">';
                echo form_submit('submit', 'Submit', 'class="btn btn-danger" title="Be sure you are done, please!"');
                            //Goto Button
                            echo '<button type="button" class="btn tbn-secondary dropdown-toggle-split d-sm-none d-md-none">';
                            echo '<select name="subject_id" onchange="window.location.href=this.value;">';
                            echo '<option value="">NAVIGATOR</option>';
                            foreach(range(1, $_SESSION['subjects'][$this->uri->segment(6)]['count']) as $question_number){
                                    echo '<option value="'.site_url('exam/content/practice/jamb/question/'.$this->uri->segment(6).'/'.$question_number).'">';
                                    echo $question_number;
                                    echo '</option>';
                            }//End Foreach
                            echo '</select></button>';
                echo '</div></div>';
                echo form_close();
                echo '</div></div></div></section>';

                //Question Number Navigator
                echo '<div class="bg-white p-2 d-none d-md-block d-lg-block">';
                echo '<h5 class="text-center">NAVIGATOR</h5>';
                echo '<ul class="nav pagination d-flex align-items-start">';
                foreach(range(1, $_SESSION['subjects'][$this->uri->segment(6)]['count']) as $question_number){
                    echo '<li class="page-item list-group-item ';
                    if($this->uri->segment(7)==$question_number){
                       echo 'active';
                    }
                    echo '">';
                        echo '<a class="page-link" ';
                        echo 'href="'.site_url('exam/content/practice/jamb/question/'.$this->uri->segment(6).'/'.$question_number).'">';
                        echo $question_number;
                        echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
                echo '</div>';
            
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
    }else{
        //If User did not get here by Start Button
        redirect('exam/content/practice/jamb/no_back');
    }
}else{
    //There is not Question Yet for this Year
    echo '<div class="container center">';
    echo '<h3 class="text-success">Work is in Progress! Please bear with us</h3>';
    echo '<div class="container-fluid row">';
    echo '<div class="col-lg-5 p-1">';
    if($this->session->user_category=='Author'){
        echo anchor('admin/content', 'Back to Main Menu<span class="lnr lnr-arrow-left"></span>', 'class="genric-btn primary circle arrow"');
    }else{
        echo anchor('exam/user', 'Back to Home<span class="lnr lnr-arrow-left"></span>', 'class="genric-btn primary circle arrow"');
    }
    echo '</div>';
    echo '<div class="col-lg-5 p-1">';
    //echo '<a href="'.site_url('exam/content/question/subject/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id).'" class="btn btn-dark col-sm-6">Choose Another Subject</a>
        //</div></div>';
    echo '</div>';
}
