<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 echo validation_errors();

    echo '<div class="modal fade" id="pdfDownload" tabindex="-1" role="dialog" aria-labelledby="pdfDownloadLabel" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">
            <div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="pdfDownloadLabel">Please Fill the following Data</h5>';
                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
            echo '<div class="modal-body">';
                echo form_open(); 
                echo '<div class="card text-center">';
                echo '<div class="card-header">';
                echo '<object class="navbar-brand logo mr-3 img-fluid" width="60" height="60" type="image/svg+xml" data="'
                    .site_url('assets/brand/quizyclopedia.svg').'"></object>';
                echo '</div>';
                echo '<div class="form-row">';
                echo '<div class="form-group col-md-6">';
                echo form_label('First Name', '', 'Class="text-white"') ;
                    $f_n_input = array(
                        'name' => 'first_name',
                        'required autocomplete' => 'off',
                        'type' => 'text',
                        'placeholder'=>'First Name',
                        'value' => $this->input->post('first_name'),
                    );
                echo form_input($f_n_input, '', 'class="form-control"');
                echo '</div>';
                echo '<div class="form-group col-md-6">';
                echo form_label('Last Name', '', 'Class="text-white"');
                    $l_n_input = array(
                        'name' => 'last_name',
                        'required autocomplete' => 'off',
                        'type' => 'text',
                        'placeholder' => 'Last Name',
                        'value' => $this->input->post('last_name')
                    );
                echo form_input($l_n_input, '', 'class="form-control"');
                echo '</div>';
                echo '</div>';
                echo '<div class="form-row">';
                echo '<div class="form-group col">';
                echo form_label('School Name', '', 'Class="text-white"') ;
                    $s_n_input = array(
                        'name' => 'sch_name',
                        'required autocomplete' => 'off',
                        'type' => 'text',
                        'placeholder'=>'School Name',
                        'value' => $this->input->post('sch_name'),
                    );
                echo form_input($s_n_input, '', 'class="form-control"');
                echo '</div>';
                echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="modal-footer">';
                        echo form_submit('download','Download Result', 'class="btn btn-dark text-white border"');
                        echo form_close();
                    echo '<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="location.reload();">Close</button>
                  </div>';
            echo '</div></div></div>';