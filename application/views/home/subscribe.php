<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<div class="container"><div class="row"><div class="col">';
echo '<h3 class="alert-heading text-center text-success">Quizyclopedia Subscription Page</h3>';
echo '</div></div>';
echo '<div class="card text-center">';
echo '<div class="card-header">';
echo '<h5 class="text-danger">Please Select a Plan</h5></div>';
echo '<div class="card-body">';
echo form_open();
echo '<div class="input-group mb-3 col-lg-6">';
echo '<div class="input-group-prepend">';
echo '<span class="input-group-text" id="inputGroup-sizing-default">Plan</span>';
echo '</div>';
echo '<select name="plan" id="plan" onchange="changePlan();">
        <option id="0" value="0">Choose a Plan</option>';
        if($this->session->school_id!=0){
            echo '<option id="2" value="2">Bi-annually</option>
                  <option id="3" value="3">Tri-annually</option>';
        }else{
            echo '<option id="1" value="1">Anually</option>
                  <option id="2" value="2">Bi-annually</option>
                  <option id="3" value="3">Tri-annually</option>
                  <option id="4" value="4">Monthly</option>';
        }
      echo '</select>';
echo '</div>';
echo '<div class="input-group mb-3 col-lg-6">';
echo '<div class="input-group-prepend">';
echo '<span class="input-group-text" id="inputGroup-sizing-default">Amount</span>';
echo '</div>';
    $amount_data = array('type'=>'text', 'name'=>'amount', 'id'=>'amount');
      echo form_input($amount_data, '', 'readonly class="form-control"');
echo '</div>';
echo '<div class="form-control">';
echo form_submit('pay id="pay"', 'Make Payment', 'class="btn btn-primary');
echo '</div>';
echo form_close();

echo '</div>';
echo '<div class="card-footer text-muted">';
echo '</div>';
echo '<div class="pt-3">'.anchor('home', 'Not Ready', 'class="btn btn-success"').'</div>';
echo '</div></div>';
?>
<script type="text/javascript">
function changePlan(){
    var option=document.getElementById('plan').value;

    if(option=="0"){
        document.getElementById('amount').value="";
    }else if(option=="1"){
        document.getElementById('amount').value="10000";
    }else if(option=="2"){
        document.getElementById('amount').value="5000";
    }else if(option=="3"){
        document.getElementById('amount').value="4000";
    }else if(option=="4"){
        document.getElementById('amount').value="2000";
    }

}
</script>
