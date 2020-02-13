<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Heading
echo '<section class="container"><h1 class="h1 text-success">Admin Users</h1><div class="container-fluid">';

//Table for Listing Adminstrator
echo '<table class="table table-hover"><thead><tr>';
//Table Headings
echo '<th scope="col">Username</th><th scope="col">First Name</th><th scope="col">Email</th>';
echo '<th scope="col">Role</th><th scope="col">Status</th><th scope="col">Task</th>';
//End of Table Head
echo '</tr></thead>';
//Table Body
echo '<tbody class="border">';
    //Fetch Adminstrators Information
    while($admin = $admins->unbuffered_row()){
        echo '<tr class="border table-row">';
        //User Id
        echo '<th scope="row">'.$admin->user_id.'</th>';
        //First Name
        echo '<td>'.$admin->first_name.'</td>';
        //Email
        echo '<td>'.$admin->email.'</td>';
        //Category of User
        echo '<td>'.$admin->user_category.'</td>';
        //Status
        echo '<td>'; 
            if($admin->status ==1){
                echo '<span class="text-success">Active</span>';
            }else{
                echo '<span class="text-danger">Inactive</span>'; 
            }
        echo '</td>';
        echo '<td>'. anchor('admin/user/update/'.$admin->user_id, 'Edit', 'class="btn btn-secondary"');
                echo anchor('admin/user/delete/'.$admin->user_id, 'Delete', 'class="delete btn btn-danger"');
        echo '</td></tr>';
    }//End While Loop
//End of Table
echo '</tbody></table></div>';
//Add New Admin Button
echo anchor('admin/user/update', '<button class="btn btn-secondary">Add New Administrator</button>', 'class="btn btn-secondary"');
echo '<div class="p-3"></div>';
//Navigation Buttion
echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
echo '</section>';
