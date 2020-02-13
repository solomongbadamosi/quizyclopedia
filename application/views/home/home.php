<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Header
  echo '<header class="masthead">
    <div class="container">
      <div class="intro-text">
        <div class="intro-lead-in"><span class="text-success">SUCCESS</span> begins with your <span class="text-warning">SPADEWORK</span>!</div>
        <div class="h1 text-uppercase"><h1>QUIZYCLOPEDIA</h1></div>';
    echo anchor('user/login', 'Sign Up/LogIn', 'class="btn btn-primary btn-xl text-uppercase js-scroll-trigger"');
     $this->load->view('messages');
      echo '</div>
    </div>
  </header>';

      //OTHER PAGES
  // About Quizyclopedia
  $this->load->view('home/about');
  
  // Available Examinations
  $this->load->view('home/examinations');
  
  // Team
  $this->load->view('home/services');
  
  // Team
  //$this->load->view('home/team');
  
  // Partners
  //$this->load->view('home/partner');
  
  //Contact Form
  //$this->load->view('home/contact');