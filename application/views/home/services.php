<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section id="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Our Services</h2>
          <h3 class="section-subheading text-muted">We are available to help you with the following services</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <ul class="timeline">
            <li>
              <div class="timeline-image">';
        echo '<img class="rounded-circle img-fluid" src="'.site_url('assets/site/img/about/1.jpg').'" alt="web development">';
        echo '</div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="subheading">Web/App Development</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">We specialize in developing Web Sites and Applications  for School Administration, Hotel Management and other aspects of Business function.</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">';
        echo '<img class="rounded-circle img-fluid" src="'.site_url('assets/site/img/about/2.jpg').'" alt="Content Management">';
        echo '</div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="subheading">Content Management</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">Tell us your stories, and we will organize and consolidate pieces of content (text, graphics, and multimedia clips) in the most efficient way for you.</p>
                </div>
              </div>
            </li>
            <li>
              <div class="timeline-image">';
        echo '<img class="rounded-circle img-fluid" src="'. site_url('assets/site/img/about/3.jpg').'" alt="Graphic Design">';
        echo '</div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="subheading">Graphic Design</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">We skillfully combine text and pictures in creating logo and special graphics for advertisements, magazines, books and more...</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">';
        echo '<img class="rounded-circle img-fluid" src="'.site_url('assets/site/img/about/4.jpg').'" alt="career counselor">';
        echo '</div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="subheading">Educational/Career Counseling</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">We help build professional relationship that empowers you to accomplish education and career goals. Our Counselor would guide you in making the right choice of career in life.</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">
                <h4>We are
                  <br>available
                  <br>for you!</h4>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>';
