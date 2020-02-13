<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Heading
echo '<section class="container"><h1 class="h3 text-success">List of Referrals</h3><div class="container-fluid">';

//Table for Listing Adminstrator
echo '<table class="table table-hover"><thead><tr>';
//Table Headings
echo '<th scope="col">Username</th><th scope="col">First Name</th><th scope="col">Phone Number</th>';
echo '<th scope="col">Amount</th><th scope="col">Status</th><th scope="col">Task</th>';
//End of Table Head
echo '</tr></thead>';
//Table Body
echo '<tbody class="border">';
    //Fetch Adminstrators Information
    while($referrals = $referral->unbuffered_row()){
        echo '<tr class="border table-row">';
        //User Name
        echo '<th scope="row">'.$referrals->user_name.'</th>';
        //First Name
        echo '<td>'.$referrals->first_name.'</td>';
        //Email
        echo '<td>'.$referrals->phone_number.'</td>';
        //Amount Currently Due to the referral
        echo '<td>'.$referrals->amount.'</td>';
        //Status
        echo '<td>'; 
            if($referrals->status ==1){
                echo '<span class="text-success">Active</span>';
            }else{
                echo '<span class="text-danger">Inactive</span>'; 
            }
        echo '</td>';
        echo '<td>'. anchor('admin/referral/update/'.$referrals->user_name, 'Edit', 'class="btn btn-secondary"');
                echo anchor('admin/referral/delete/'.$referrals->user_name, 'Delete', 'class="delete btn btn-danger"');
                if($referrals->amount > 0){
                    echo anchor('admin/referral/pay/'.$referrals->user_name, 'Payout', 'class="btn btn-success"');
                }
                echo anchor('admin/referral/clients/'.$referrals->user_name, 'View Clients', 'class="btn btn-primary"');
        echo '</td></tr>';
    }//End While Loop
//End of Table
echo '</tbody></table></div>';
//Add New Admin Button
echo anchor('admin/referral/update', '<button class="btn btn-secondary">Add New Referral</button>', 'class="btn btn-secondary"');
echo '<div class="p-3"></div>';
//Navigation Buttion
echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
echo '</section>';
