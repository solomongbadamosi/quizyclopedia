<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//declaration of document type
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
//Mobile Specific Meta
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes">';
//Favicon
echo '<link rel="icon" type="image/png" href="'.site_url('assets/brand/favicon.png').'">';
//Author Meta
echo '<meta name="author" content="quizyclopedia">';
//Meta Description
echo '<meta name="description" content="A computer based test for Most past examinations in Nigeria">';
//Meta Keyword
echo '<meta name="keywords" content="past questions, JAMB, WAEC, NECO, Common Entrance, CBT, GCE, Computer Based Test, Computer Based Examination">';
//Meta Character Set
echo '<meta charset="UTF-8">';
// Site Title
echo '<title>Quizyclopedia</title>';
//page Refresh
echo '<meta http-equiv="refresh" content="1900">';

//Bootstrap core CSS
echo link_tag('assets/site/vendor/bootstrap/css/bootstrap.min.css');

//Custom fonts for this template
echo link_tag('assets/site/vendor/fontawesome-free/css/all.min.css');
echo '<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">';
echo '<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">';
echo '<link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css">';
echo '<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">';

// Custom styles for this template
echo link_tag('assets/site/css/agency.min.css');

echo '</head>';

echo '<body id="page-top">';
//Navigation Bar for Registered Users
$no_nav = array('login', 'signup', 'home', ''); $exempted_class = array('referral', 'school');
if(!in_array($this->uri->segment(2), $no_nav)||in_array($this->uri->segment(1), $exempted_class)){    
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <a class="navbar-brand" href="#">';
             echo '<object class="navbar-brand logo mr-3 img-fluid" width="150" height="30" type="image/svg+xml" data="'
                      .site_url('assets/brand/logo.svg').'"></object>';
          echo '</a>
        <div class="navbar-nav mr-auto mt-2 mt-lg-0"></div>';
        echo '<a class="nav-link" href="'.site_url('user/logout').'">Logout</a>';
      echo '</div>';
    echo '</nav>';
}else{ 
    //Set Default Navigation
    $no_nav = array('login', 'signup');
    if(!in_array($this->uri->segment(2), $no_nav)){
      echo '<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">';
             echo '<object class="navbar-brand logo mr-3 img-fluid" width="150" height="30" type="image/svg+xml" data="'
                      .site_url('assets/brand/logo.svg').'"></object>';
            echo '</a>
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#quizyclopedia">Quizyclopedia</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#body">Bodies</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#services">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>';
    }
} 
$home = array('', 'home');
if(!in_array($this->uri->segment(1),$home)){
    $this->load->view('messages'); 
}
