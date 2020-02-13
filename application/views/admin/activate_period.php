<div class="container pb-5 pt-5">
    <div class="row">
        <?php
        while($subject = $subjects->unbuffered_row()){
        ?>
        <div class="col-lg-6">
            <h3 class="text-center bg-success p-2 text-white"><?php echo $subject->subject_name; ?></h3>
            <table class="table table-dark">
              <thead>
                <tr>
                  <th scope="col">Periods</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <?php
                $period_set = $this->examsubjectperiods->find_subject_periods($this->uri->segment(6),$subject->subject_id)->result();
              ?>
              <tbody>
                  <?php
                  foreach($period_set as $periods){
                  ?>
                    <tr>
                      <td><?php echo $periods->period_name; ?></td>
                      <?php
                      echo form_open();
                      echo form_hidden('subject_id', $periods->subject_id);
                      echo form_hidden('period_id', $periods->period_id);
                      if($periods->ready==TRUE){
                          echo form_hidden('status', FALSE);
                          echo '<td>'. form_submit('', 'Deactivate', 'class="btn-success"').'</td>';
                      }else{
                          echo form_hidden('status', TRUE);
                          echo '<td>'. form_submit('', 'Activate', 'class="btn-danger"').'</td>';
                      }
                      echo form_close();
                      ?>
                    </tr>
                  <?php
                  }
                  ?>
              </tbody>
            </table>
        </div>
       <?php
        }
      ?>
    </div>
    <?php
    echo anchor('admin/content', '<span class="fa fa-arrow-left"></span> Back to Main Menu', 'class="btn btn-success"');
    echo anchor('admin/content/manage/body', 'Choose Another Examination', 'class="btn btn-warning"');
    ?>
</div>