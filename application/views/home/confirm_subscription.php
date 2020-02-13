<?php
$this->load->view('layout/head');
?>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white">Preview Susbscription Details</h5>
      </div>
      <div class="modal-body">
         <?php
         if($this->session->post){
            echo '<p class="text-warning text-center bg-light p-2 h6">You have a Pending Subscription Payment:</p>';
          }else{
            echo '<p class="text-warning text-center bg-light p-2 h6">Please Confirm details of your Subscription through Paystack to Quizyclopedia below:</p>';
          }
          ?>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <th scope="row">Email:</th>
                <td><?php echo $post['email']; ?></td>
              </tr>
              <tr>
                <th scope="row">Amount:</th>
                <?php 
                if($this->session->post){
                    $where = array('email'=>$post['email']);
                    $existing = $this->subscriptionreferences->find_where($where)->row();
                    $amount = $existing->amount/100;
                }else{ 
                    $amount = $post['amount']/100;
                }
                ?>
                <td class="h4 text-success"><?php echo 'N'.$amount; ?></td>
              </tr>
              <tr>
                <th scope="row">Duration:</th>
                <?php
                if($amount==10000){
                    $duration = '1 Year';
                    $plan = 1;
                }elseif($amount==5000){
                    $duration = '6 Months';
                    $plan = 2;
                }elseif($amount==4000){
                    $duration = '4 Months';
                    $plan = 3;
                }else{
                    $duration = '1 Month';
                    $plan = 4;
                }
                ?>
                <td class="h4"><?php echo $duration; ?></td>
              </tr>
            </tbody>
          </table>
          <p class="text-center bg-dark p-2 text-white">Click on Proceed to Continue with the payment</p>
      </div>
      <div class="modal-footer">
          
        <?php
        echo form_open();
        if($this->session->post){
            echo form_submit('cancel', 'Cancel', 'class="btn btn-danger"');
        }else{
            echo anchor('user/subscribe/'.$this->session->time, 'Cancel', 'class="btn btn-danger"');
        }
        echo form_hidden('plan',$plan);
        echo form_hidden('amount',$amount);
        echo form_submit('proceed', 'Proceed', 'class="btn btn-success"');
        echo form_close();
        ?>
      </div>
    </div>
  </div>
<?php
$this->load->view('layout/footer');

