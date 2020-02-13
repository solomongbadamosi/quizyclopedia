<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//FOOTER
  echo '<footer class="bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-md-4">';
        echo '<span class="copyright text-white">Copyright &copy; Quizyclopedia '. date('Y').'</span>';
        //social Medias
        echo '</div>
        <div class="col-md-4">
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
        </div>';
        //Privacy Policy and Terms of Use
        echo '<div class="col-md-4">
          <ul class="list-inline quicklinks">
            <li class="list-inline-item">
              <a data-toggle="modal" data-target="#policy" href="">Privacy Policy</a>
            </li>
            <li class="list-inline-item">
              <a data-toggle="modal" data-target="#terms" href="">Terms of Use</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>';

//Privacy Policy Modal
echo '<div class="modal fade" id="policy" tabindex="-1" role="dialog" aria-labelledby="policyTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="policyTitle">Privacy Policy</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">';
       $this->load->view('policy');
      echo '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';

//Terms of Use Modal
echo '<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="termsTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="termsTitle">Terms of Use</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">';
     $this->load->view('terms_and_conditions');
      echo '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';

//Examination Bodies Modal
 $home = array('', 'home');
  if(in_array($this->uri->segment(1), $home)){
    while($body = $bodies->unbuffered_row()){
    echo '<div class="portfolio-modal modal fade" id="'.$body->body_id.'" tabindex="-1" role="dialog" aria-hidden="true">
  
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <h4 class="text-uppercase">'.$body->body_name.'</h4>
                <img class="img-fluid d-block mx-auto" src="'.site_url('assets/brand/'.$body->logo).'" alt="'.$body->body_name.'">
                '.$body->about.'
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fas fa-times"></i>
                  Close Body</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>';
        }
  }

//Bootstrap core javascript
echo '<script src="'.site_url('assets/site/vendor/jquery/jquery.min.js').'"></script>';
echo '<script src="'.site_url('assets/site/vendor/bootstrap/js/bootstrap.bundle.min.js').'"></script>';

//Plugin Javascript
echo '<script src="'.site_url('assets/site/vendor/jquery-easing/jquery.easing.min.js').'"></script>';

//Contact Form Javascript
echo '<script src="'.site_url('assets/site/js/jqBootstrapValidation.js').'"></script>';
echo '<script src="'.site_url('assets/site/js/contact_me.js').'"></script>';

//Custom Scripts
echo '<script src="'.site_url('assets/site/js/agency.min.js').'"></script>';

//Load CDN
echo '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>';

//TEXT EDITOR
if($this->uri->segment(9)||($this->uri->segment(3)==='update' && $this->uri->segment(4)==='body')||($this->uri->segment(3)==='manage' && $this->uri->segment(4)==='solution')){
    echo '<script src="'.site_url('assets/plugins/ckeditor/ckeditor.js').'"></script>'; 
    echo '<script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>';
    //maths editor
    echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML"></script>';
}


echo '<script src="'.site_url('assets/js/vendor/bootstrap.min.js').'"></script>';
echo '<script src="'.site_url('assets/js/main.js').'"></script>';

echo '<script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
           $("a.delete").click(function(e){
               if(!confirm(\'Do you know what you are doing?\')){
                   e.preventDefault();
                   return false;
               }
               return true;
           });
        });
    </script>';
echo '</body>';
echo '</html>';