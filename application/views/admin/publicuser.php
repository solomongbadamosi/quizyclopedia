<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<div class="container mb-5">';
echo    '<table class="table table-hover">
        <thead class="bg-light">
          <tr>
            <th scope="col">User\'s Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>';
            //get the total students registered under a school from database
            while($user = $users->unbuffered_row()){
                    echo '<tr>';
                      echo '<td>'. $user->last_name. ' '.$user->first_name.'</td>';
                      echo '<td>+234'. $user->phone.'</td>';
                      echo '<td>'. $user->email.'</td>';
                      echo '<td>'; 
                      if($user->subscribed==TRUE){
                          if($user->expiry_time < time()){
                              echo '<span class="text-warning">Expired Subscription</span>';
                          }else{
                              echo '<span class="text-success">Subscribed</span>';
                          }
                        }else{
                            if($user->expiry_time === NULL){
                                echo '<span class="text-danger">Not Subscribed</span>';
                            }else{
                                echo '<span class="text-warning">Expired Subscription</span>';
                            }
                        }
                      echo '</td>';
                      echo '<td>'; 
                      if($user->banned==TRUE){
                          echo form_open('admin/publicuser/activate');
                          echo form_hidden('name', $user->last_name. ' '.$user->first_name);
                          echo form_hidden('email', $user->email);
                          echo form_submit('activate', 'Reactivate', 'class="btn btn-success"');
                        }else{
                          echo form_open('admin/publicuser/ban');
                          echo form_hidden('name', $user->last_name. ' '.$user->first_name);
                          echo form_hidden('email', $user->email);
                          echo form_submit('ban', 'Ban', 'class="btn btn-danger"');
                        }
                        echo form_close();
                      echo '</td>';
                    echo '</tr>';
                      }//End While loop
        echo '</tbody>';
    echo '</table>';
    echo anchor('school', '<span class="fa fa-arrow-left"></span> Back to Dashboard', 'class="btn btn-success"');
echo '</div>';
