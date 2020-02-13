<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$url = $this->myurl->selected_item();
echo '<section class="container"><div class="bg-secondary text-center pt-3 pb-3">';
echo '<h3 class="text-white">Manage: '.$url->current_body->body_name. '\'s '. $url->current_exam->exam_name.'</h3>';
echo '</div>';
echo '<div class="p-3"><div class="container">';
echo '<div class="row">';

//Display Subjects
while($subject = $subjects_set->unbuffered_row()){ 
    echo '<div class="col-lg-4 col-md-10 col-sm-24 d-flex p-3"><div class="bg-warning text-center">';
    echo '<h4>'.$subject->subject_name.'</h4>';
    //Drop Down Button for Adding Questions to a Subject
    echo '<div class="dropright"><button type="button" class="btn btn-secondary">';
    echo 'Add Question & Answers</button>';
    //Calling the Periods for each subjects from the Database
    $periods_set = $exam_periods->result(); 
    echo '<button type="button" class="btn tbn-secondary dropdown-toggle-split">';
    $subject_options = array(); 
    $subject_options['default'] = 'Choose Examination Year';
    
    //Displaying Period options for each subjects
        foreach($periods_set as $subject_period){
            $subject_options[site_url('admin/content/manage/questions/'.$url->current_body->body_id.'/'.
            $url->current_exam->exam_id.'/'.$subject->subject_id.'/'.$subject_period->period_id)] = $subject_period->period_name;
        }//end foreach
    
    echo form_dropdown('subject_id', $subject_options, '', 'onchange="window.location.href=this.value;"');
    echo '</button></div>';
    
    /**
     * Only author can add examination to the public user
     */
    if($this->session->user_category==='Author'){
        //Form for Adding Period to Subject
        echo '<div class="dropright"><button type="button" class="btn btn-secondary">';
        echo 'Add Period to Public</button>';
        echo '<button type="button" class="btn tbn-secondary dropdown-toggle-split">';


        //form for available periods
        echo form_open();
        $options = array($subject->subject_id=>'current subject');
        echo form_dropdown('subject_id',$options, $subject->subject_id, 'hidden');

        $exam_periods_set = $this->examperiods->find_exam_periods($url->current_exam->exam_id)->result();
        $exam_period_options = array();
        $exam_period_options['default'] = 'Choose';

            //call to periods to are available for use
            foreach($exam_periods_set as $period){
                $exam_period_options[$period->period_id] = $period->period_name;
            }
        echo form_dropdown('period_id', $exam_period_options);
        echo form_submit('subject_period', 'Add Period', 'class="btn-success"');
        echo form_close();

      echo '</button></div>';
    }
      echo '</div></div>';
}//End while loop for subjects
echo '</div>';

if($this->session->userdata('user_category')==='Author'){
    //Adding a New Subject to the Current Examination
    echo '<div class="btn-group col-lg-6 col-sm-6">';
    echo anchor('admin/content/manage/activate_period/'.$this->uri->segment(5).'/'.$this->uri->segment(6), 'Activate/Deactivate Examination Years', 'class="btn btn-dark p-4"');
    echo '</div>';
    echo '<div class="btn-group col-lg-6 col-sm-6">';
    
    echo '<button type="button" class="btn btn-danger">';
    echo 'Add New Subject to this Examination</button>';
    echo '<button type="button" class="btn dropdown-toggle-split btn-danger" aria-haspopup="true" aria-expanded="false">';

    //form Examination Subjects
    echo form_open('admin/content/update/exam_subject/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id);
    $options = array($url->current_exam->exam_id=>$url->current_exam->exam_name);
    echo form_dropdown('exam_id',$options, $url->current_exam->exam_id, 'hidden');
    //Subject Name
    $subject_options = array();
    $subject_options['default'] = 'Choose Subject';
        foreach($subjects as $subject){
        $subject_options[$subject->subject_id] = $subject->subject_name;
        }//end foreach
    echo form_dropdown('subject_id', $subject_options);
    echo form_submit('exam_subject', 'Add Subject', 'class="btn-success"');
    echo form_close();//End of form
    echo '</button></div>';
}

echo '</div></div>';

//Pagination
echo $pagination_data['pages'];
echo '<div class="p-3"></div>';
echo '</div></div>';
if($this->session->userdata('user_category')==='Author'){
    //Add New Year to the Current Examination
    echo '<div class="row bg-primary">';
    echo '<div class="btn-group col-lg-6 col-sm-6 bg-danger"><button class="btn btn-danger">';
    echo 'Add New Year to this Examination';
    echo '</button><button class="btn dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">';

    //form Examination periods for all Examinations in the Database
    echo form_open('admin/content/update/exam_period/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id);
    $exam_period_options = array($url->current_exam->exam_id=>'current_exam');
    echo form_dropdown('exam_id',$exam_period_options, $url->current_exam->exam_id, 'hidden');
    $period_options = array();
    $period_options['default'] = 'Add Period';
        foreach($periods as $period){
            $period_options[$period->period_id] = $period->period_name;
        }//End foreach
    echo form_dropdown('period_id', $period_options);
    echo form_submit('exam_period', 'Add New Year', 'class="btn-success"');
    echo form_close();//End of Form
    echo '</button></div>';

    echo '<div class="btn-group col-lg-6 col-sm-6 btn-warning">';
    echo '<button class="btn btn-warning">';
    echo 'Categorize Examination Questions</button>';
    echo '<button class="btn dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">';
    //form Categorization of Questions
    echo form_open('admin/content/update/exam_category');
    echo form_hidden('body_id', $url->current_body->body_id);
    $exam_category_options = array($url->current_exam->exam_id=>'current_exam');
    echo form_dropdown('exam_id',$exam_category_options, $url->current_exam->exam_id, 'hidden');
           
    //Categories
    $category_options = array();
    $category_options['default'] = 'Choose Category';
        foreach($question_categories as $category){
            $category_options[$category->category_id] = $category->category_name;
        }//End for each
    echo form_dropdown('category_id', $category_options);
    echo form_submit('exam_category', 'Categorize Questions', 'class="btn-success"');
    echo form_close();//End of Form
    echo '</button></div>';
}//End if for Author's Priviledge
echo '</div><div class="border pb-3 bg-light"></div>';
echo '<div class="p-3"></div>';

echo '<div class="container">';
echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
echo anchor('admin/content/manage/body', 'Choose Another Examination', 'class="btn btn-warning"');
echo '</div>';
echo '</section>'; 
