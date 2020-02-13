<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<div class="container mb-5">';
    while ($school = $sch->unbuffered_row()){ 
    echo '<div class="table-responsive-sm pb-5">';
        echo '<div class="bg-dark text-center p-2 text-white"><h3>'.strtoupper($school->name).', '.$school->location;
        echo '</h3>';
            echo '<p>Contact Person: '.$school->contact_person.'(+234'.$school->phone.')'.'</p>';
            if($this->session->userdata('user_category')==='Author'){
                if($school->amount > 0){
                    echo '<p>'.anchor('admin/referral/pay/'.$this->uri->segment(4).'/'.$school->sch_id, 'Pay School', 'class="btn btn-success"').'</p>';
               }
            }else{
              echo '<p>'.anchor('referral/update/'.$school->sch_id, 'Edit School Info', 'class="btn btn-danger"').'</p>';  
            }
        echo '</div>
      <table class="table table-hover">
        <thead class="bg-light">
          <tr>
            <th scope="col">Student Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Status</th>
            <th scope="col">Expiry</th>
          </tr>
        </thead>
        <tbody>';
            //get the total students registered under a school from database
            $where = array('school_id'=>$school->sch_id);
            $students = $this->users->find_where($where);
            while($student = $students->unbuffered_row()){
                    echo '<tr>';
                      echo '<td>'. $student->last_name. ' '.$student->first_name.'</td>';
                      echo '<td>+234'.$student->phone.'</td>';
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
        echo '<div class="bg-dark p-2 text-center"><h5><span class="text-white">TOTAL AMOUNT DUE: </span>';
        echo '<span class="text-success">N'.$school->amount.'</span></h5></div>';
    echo '</div>';
    }//End While for Schools
    
    //other subscribers without school reference
    echo '<div class="table-responsive-sm pb-5">';
        echo '<div class="bg-dark text-center p-2 text-white"><h3>OTHER SUBSCRIBERS</h3>';
    echo '</div>';
    echo '<table class="table table-hover">
        <thead class="bg-light">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Status</th>
            <th scope="col">Expiry</th>
          </tr>
        </thead>
        <tbody>';
            //get the total students registered without a school from database
            while($other_subscribers = $others->unbuffered_row()){
                    echo '<tr>';
                      echo '<td>'. $other_subscribers->last_name. ' '.$other_subscribers->first_name.'</td>';
                      echo '<td>+234'.$other_subscribers->phone.'</td>';
                      echo '<td>'; 
                      if($other_subscribers->subscribed==TRUE){
                          if($other_subscribers->expiry_time < time()){
                              echo '<span class="text-warning">Expired Subscription</span>';
                          }else{
                              echo '<span class="text-success">Subscribed</span>';
                          }
                        }else{
                            if($other_subscribers->expiry_time === NULL){
                                echo '<span class="text-danger">Not Subscribed</span>';
                            }else{
                                echo '<span class="text-warning">Expired Subscription</span>';
                            }
                        }
                      echo '</td>';
                      echo '<td>';
                      if($other_subscribers->expiry_time !==NULL){
                          echo date('l jS \of F Y h:i:s A', $other_subscribers->expiry_time);
                      }
                      echo '</td>';
                    echo '</tr>';
                      }//End While loop
        echo '</tbody>';
    echo '</table>';
    
if($this->session->userdata('user_category')==='Author'){
    echo anchor('admin/referral', '<span class="fa fa-arrow-left"></span> Back to Referrals', 'class="btn btn-success"');
}else{
    echo anchor('referral', '<span class="fa fa-arrow-left"></span> Back to Dashboard', 'class="btn btn-success"');
}
echo '</div>';
