<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//View for Updating Question
$url = $this->myurl->selected_item();
echo '<section class="container"><section class="bg-secondary text-center pt-3 pb-3">';
echo '<h1 class="h1 text-white">Update Questions</h1>';
echo '</section><br/><div class="container-fluid"><table class="table table-striped">';

//Display Available Questions in a Table
//Table HEAD
echo '<thead><tr><th scope="col">Question Number</th><th scope="col">Questions</th>';
      
//Table BODY
echo '<tbody>';
while($question = $question_set->unbuffered_row()){
echo '<tr>';
    //Question Numbers
    echo '<th scope="row">'.$question->question_number.'</th>';
    //Questions
    echo '<td>'.anchor('admin/content/update/questions/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
        $url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$question->question_number, $question->question).'</td>';
    //Delete Button
    echo '<td class="btn-group">'.anchor('admin/content/delete/question/'.$url->current_body->body_id.'/'.
         $url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.$url->current_period->period_id.'/'.$url->current_category->category_id.'/'.$question->question_number, 
         '<button class="btn btn-danger delete">Delete</button>', 'class="btn delete"');
    echo '</tr>';
}

echo '</tbody></table>';//End of Table

//Add Pagination
echo '<div class="p-3">';
echo $pagination['pages']; 
echo '</div>';

echo '<div class="pt-5">';
//Anchor Buttons
echo anchor('admin/content/manage/questions/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
        $url->current_period->period_id, '<button class="btn btn-dark">&lArr; Back</button>', 'class="btn"');
echo anchor('admin/content/manage/body', '<button class="btn btn-primary">Another Examination</button>', 'class="btn"');
echo '</div>';

//Anchor for Theory Questions
if($url->current_category->category_id==='THEO'){
    echo '<div class="pb-3">';
    echo anchor('admin/content/manage/solution/'.$url->current_body->body_id.'/'.$url->current_exam->exam_id.'/'.$url->current_subject->subject_id.'/'.
        $url->current_period->period_id.'/THEO', '<button class="btn btn-dark">Add, Edit/Delete Solutions</button>', 
        'class="btn btn-success"');
    echo '</div>';
}
