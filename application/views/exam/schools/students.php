<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<div class="container mb-5">';
echo    '<table class="table table-hover">
        <thead class="bg-light">
          <tr>
            <th scope="col">Student Name</th>
            <th scope="col">Status</th>
            <th scope="col">Expiry</th>
          </tr>
        </thead>
        <tbody>';
            //get the total students registered under a school from database
            while($student = $students->unbuffered_row()){
                    echo '<tr>';
                      echo '<td>'. $student->last_name. ' '.$student->first_name.'</td>';
                      echo '<td>'; 
                      if($student->subscribed==TRUE){
                          if($student->expiry_time < time()){
                              echo '<span class="text-warning">Expired Subscription</span>';
                          }else{
                              echo '<span class="text-success">Subscribed</span>';
                          }
                        }else{
                            if($student->expiry_time === NULL){
                                echo '<span class="text-danger">Not Subscribed</span>';
                            }else{
                                echo '<span class="text-warning">Expired Subscription</span>';
                            }
                        }
                      echo '</td>';
                      echo '<td>';
                      if($student->expiry_time !==NULL){
                          echo date('l jS \of F Y h:i:s A', $student->expiry_time);
                      }
                      echo '</td>';
                    echo '</tr>';
                      }//End While loop
        echo '</tbody>';
    echo '</table>';
    echo anchor('school', '<span class="fa fa-arrow-left"></span> Back to Dashboard', 'class="btn btn-success"');
echo '</div>';
