<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<div class="container mb-5">';
echo    '<table class="table table-hover">
        <thead class="bg-light">
          <tr>
            <th scope="col">School Name</th>
            <th scope="col">Email</th>
            <th scope="col">Contact Person</th>
            <th scope="col">Number</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>';
            //get the total students registered under a school from database
            while($school = $schools->unbuffered_row()){
                    echo '<tr>';
                      echo '<td>'. $school->name.'</td>';
                      echo '<td>'. $school->email.'</td>';
                      echo '<td>'. $school->contact_person.'</td>';
                      echo '<td>+234'. $school->phone.'</td>';
                      echo '<td>'; 
                      if($school->banned==TRUE){
                          echo form_open('admin/school/activate/'.$school->sch_id);
                          echo form_hidden('sch_name', $school->name);
                          echo form_submit('activate', 'Reactivate', 'class="btn btn-success"');
                        }else{
                            echo form_open('admin/school/ban/'.$school->sch_id);
                            echo form_hidden('sch_name', $school->name);
                            echo form_submit('ban', 'Ban', 'class="btn btn-danger"');
                        }
                        echo form_close();
                      echo '</td>';
                    echo '</tr>';
            }//End While loop
        echo '</tbody>';
    echo '</table>';
    echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Dashboard', 'class="btn btn-success"');
echo '</div>';
