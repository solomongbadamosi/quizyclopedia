<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="bg-light text-center" id="body">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Examination Bodies</h2>
          <h3 class="section-subheading text-muted">We have Past Exam Questions of the following bodies and more...</h3>
        </div>
      </div>
      <div class="row">';
//loop available examination names
     while($body = $bodies_set->unbuffered_row()){
        echo '<div class="col-md-4 col-sm-6 portfolio-item p-5">';
        echo '<a class="portfolio-link" data-toggle="modal" href="#'.$body->body_id.'">';
        echo '<div class="portfolio-hover">
              <div class="portfolio-hover-content">
                Read More
              </div>
            </div>';
        echo '<object class="img-fluid img-responsive img-thumbnail" width="180" height="36" type="image/svg+xml" data="'.
                site_url('assets/brand/'.$body->logo).'"></object>';
        echo '</a>';
        echo '<div class="portfolio-caption">';
        echo '<h6>'.$body->body_name.'</h6>';
        echo '<p class="text-muted">'.$body->brief_info.'</p>';
        echo '</div>';
        echo '</div>';
     } 
echo '</div>
      </div>
  </section>';