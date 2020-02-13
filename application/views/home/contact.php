<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section id="contact">
    <div class="container">';
     echo validation_errors('<br/><p class="alert alert-danger">', '</p><br/>');
    echo '<div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Contact Us</h2>
          <h3 class="section-subheading text-muted">We would like to hear from you.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">';
    //start form
          echo form_open();
            echo '<div class="row">
              <div class="col-md-6">
                <div class="form-group">';
               //User's Name
                    $name_input = array(
                        'name' => 'name',
                        'type'=> 'text',
                        'required' => 'required',
                        'required autocomplete' => 'off',
                        'placeholder' => 'Your Name *',
                        'value' => $this->input->post('name')
                    );
                echo form_input($name_input, '', 'class="form-control"');
                  
                  echo '<p class="help-block text-danger"></p>
                </div>
                <div class="form-group">';
                  //User's Email Address
                    $email_input = array(
                        'name' => 'email',
                        'type'=> 'email',
                        'required' => 'required',
                        'required autocomplete' => 'off',
                        'placeholder' => 'Your Email *',
                        'value' => $this->input->post('email')
                    );
                echo form_input($email_input, '', 'class="form-control"');
                  
                echo '<p class="help-block text-danger"></p>
                </div>
                <div class="form-group">';
                 //Sender's Phone Number
                    $phone_input = array(
                        'name' => 'phone',
                        'type'=> 'tel',
                        'required' => 'required',
                        'required autocomplete' => 'off',
                        'placeholder' => 'Your Phone *',
                        'value' => $this->input->post('phone')
                    );
                echo form_input($phone_input, '', 'class="form-control"');
                  
                  echo '<p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">';
                  //Message
                    $msg_input = array(
                        'name' => 'message',
                        'required' => 'required',
                        'required autocomplete' => 'off',
                        'placeholder' => 'Your Message *',
                        'value' => $this->input->post('message')
                    );
                echo form_textarea($msg_input, '', 'class="form-control"');
                  
                  echo '<p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-lg-12 text-center">
                <div id="success"></div>';
                //submit Button
                $submit_input = array(
                        'type'=>'submit',
                        'name'=>'submit'
                    );
                echo form_button($submit_input, 'Send Message', 'class="btn btn-primary btn-xl text-uppercase"');
                
              echo '</div>
            </div>';
          echo form_close(); 
        echo '</div>
      </div>
    </div>
  </section>';