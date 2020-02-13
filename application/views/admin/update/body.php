<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$url = $this->myurl->selected_item();
//Display form for Editing Current Examination body

//Name of the Examination Body
echo    '<section class="container">
        <section class="bg-secondary text-center pt-3 pb-3">
        <h1 class="h1 text-white">Rename'."'".$url->current_body->body_name.'</h1></section>';
        
//Form Open
echo    '<section class="container"><br/><div class="container container-fluid pl-3" >';
echo    form_open_multipart();
echo    '<div class="p-3"><div class="form-group">';
echo    '<h4>'. form_label('Body Number: ', 'body_id', 'class="text-success"').'</h4>';
        
//Body Identification Number
$id_input = array($url->current_body->body_id=>$url->current_body->body_id);
echo form_dropdown('body_id',$id_input); 
echo    '</div><div class="form-group">';
        
//Examination Body Logo
echo '<h5 class="text-success">'. form_label('Add Logo', 'logo').'</h5>';
echo form_upload('logo'); 
echo '</div><div class="form-group">';

//Examination Body Name
echo '<h4>'. form_label('Body Name: ', 'body_name', 'class="text-success"').'</h4>';
$input = array('name'=>'body_name','value'=>$url->current_body->body_name, set_value('body_name'));
echo form_input($input); 

//Examination Brief History
echo '<h4>'. form_label('Brief Information: ', 'brief_info', 'class="text-success"').'</h4>';
$info_input = array('name'=>'brief_info','value'=>$url->current_body->brief_info, set_value('brief_info'), 'class'=>'tinymce');
echo form_textarea($info_input); 
echo '</div><div class="form-group">';

//Full Story About Examination Body
echo '<h4>'. form_label('About Examination Body: ', 'about', 'class="text-success"').'</h4>';
$t_input = array('name'=>'about','value'=>$url->current_body->about, set_value('about'), 'class'=>'tinymce');
echo form_textarea($t_input); 
echo '</div><div>';

//Submit Button
echo form_submit('submit', 'Edit Body', 'class="btn btn-danger"');
echo '</div></div>';

//End of Form
echo form_close();

//Close All opened Tags
echo '</div><div class="row pt-5"><div class="col-lg-6">';

//Back Button Admin Home
echo anchor('admin/content', 'Back to Main Menu<span class="lnr lnr-arrow-left"></span>', 'class="genric-btn primary circle arrow"');
echo '</div><div class="col-lg-6">';

//Back Button to choose another Examination Body
echo anchor('admin/content/manage/body', 'Manage Another Exam Body', 'class="btn btn-warning"');
echo '</div></div></section></section>';