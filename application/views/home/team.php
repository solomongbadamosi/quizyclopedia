<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="bg-light" id="team">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Our Amazing Team</h2>
          <h3 class="section-subheading text-muted">We are committed to making your life better</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="team-member">';
            echo '<img class="mx-auto rounded-circle"  src="'.site_url('assets/site/img/team/akomolede.jpg').'" alt="">';
            echo '<h4>Akomolede Adeniyi</h4>
            <p class="text-muted">Executive Producer</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">';
            //Akoms Twitter Handle
                echo '<a href="#">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">';
            //Akoms Facebook
                echo '<a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
              <li class="list-inline-item">';
            //Akoms Linked In
                echo '<a href="#">
                  <i class="fab fa-linkedin-in"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="team-member">';
            echo '<img class="mx-auto rounded-circle" src="'.site_url('assets/site/img/team/zalo.jpg').'" alt="">
            <h4>Gbadamosi Solomon</h4>
            <p class="text-muted">Lead Developer</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">';
            //solomon's facebook social media handles
               echo ' <a href="#">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-linkedin-in"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>';
        echo '<div class="col-sm-4">
          <div class="team-member">
            <img class="mx-auto rounded-circle" src="'. site_url('assets/site/img/team/sp.jpg').'" alt="">';
            echo '<h4>Igbinosun \'Sade</h4>
            <p class="text-muted">Lead Marketer</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-linkedin-in"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
        </div>
      </div>
    </div>
  </section>';