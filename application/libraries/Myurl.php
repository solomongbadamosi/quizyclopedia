<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myurl {
    //create ancillary class with $ci
     protected $CI;
     
    protected static $current_body;
    protected static $current_exam;
    protected static $current_subject;
    protected static $current_period;
    protected static $current_category;
    
    // We'll use a constructor, as you can't directly call a function
        // from a property definition.
    function __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->model(array('exambodies', 'examinations', 'subjects', 'periods', 'questionscategories'));
    }

/**
 * this will specify the current item selected
 */

 function selected_item () {
        if($this->CI->uri->segment(5)==!NULL &&$this->CI->uri->segment(6)===NULL) {
                self::$current_body = $this->CI->exambodies->find_by_id($this->CI->uri->segment(5));// returns body_id, and body_name as key
                self::$current_exam= null; self::$current_subject = null; self::$current_period = null; self::$current_category = null;  return (object) array('current_body' => self::$current_body);
        }elseif($this->CI->uri->segment(5)==!NULL && $this->CI->uri->segment(6)==!NULL && $this->CI->uri->segment(7)===NULL) {
                self::$current_body = $this->CI->exambodies->find_by_id($this->CI->uri->segment(5));// returns body_id, and body_name as key
                self::$current_exam= $this->CI->examinations->find_by_id($this->CI->uri->segment(6));//returns exam_id, body_id, exam_name, position and description
                self::$current_subject = null; self::$current_period = null; self::$current_category = null;  return (object) array('current_body'=>self::$current_body, 'current_exam'=>self::$current_exam);
        }elseif($this->CI->uri->segment(5)==!NULL && $this->CI->uri->segment(6)==!NULL && $this->CI->uri->segment(7)==!NULL && $this->CI->uri->segment(8)===NULL) {
                self::$current_body = $this->CI->exambodies->find_by_id($this->CI->uri->segment(5));// returns body_id, and body_name as key
                self::$current_exam= $this->CI->examinations->find_by_id($this->CI->uri->segment(6));//returns exam_id, body_id, exam_name, position and description
                self::$current_subject = $this->CI->subjects->find_by_id($this->CI->uri->segment(7));//returns subject_id and subject_name
                self::$current_period = null; self::$current_category = null;  return (object) array ('current_body'=>self::$current_body, 'current_exam'=>self::$current_exam, 'current_subject'=>self::$current_subject);
        }elseif($this->CI->uri->segment(5)==!NULL && $this->CI->uri->segment(6)==!NULL && $this->CI->uri->segment(7)==!NULL && $this->CI->uri->segment(8)==!NULL && $this->CI->uri->segment(9)===NULL) {
                self::$current_body = $this->CI->exambodies->find_by_id($this->CI->uri->segment(5));// returns body_id, and body_name as key
                self::$current_exam= $this->CI->examinations->find_by_id($this->CI->uri->segment(6));//returns exam_id, body_id, exam_name, position and description
                self::$current_subject = $this->CI->subjects->find_by_id($this->CI->uri->segment(7));//returns subject_id and subject_name
                self::$current_period = $this->CI->periods->find_by_id($this->CI->uri->segment(8));//returns period_id and period_name
                self::$current_category = null;
                return (object) array('current_body'=>self::$current_body, 'current_exam'=>self::$current_exam, 'current_subject'=>self::$current_subject, 'current_period'=>self::$current_period);
        }elseif($this->CI->uri->segment(5)==!NULL && $this->CI->uri->segment(6)==!NULL && $this->CI->uri->segment(7)==!NULL && $this->CI->uri->segment(6)==!NULL && $this->CI->uri->segment(9)==!NULL) {
                self::$current_body = $this->CI->exambodies->find_by_id($this->CI->uri->segment(5));// returns body_id, and body_name as key
                self::$current_exam= $this->CI->examinations->find_by_id($this->CI->uri->segment(6));//returns exam_id, body_id, exam_name, position and description
                self::$current_subject = $this->CI->subjects->find_by_id($this->CI->uri->segment(7));//returns subject_id and subject_name
                self::$current_period = $this->CI->periods->find_by_id($this->CI->uri->segment(8));//returns period_id and period_name
                self::$current_category = $this->CI->questionscategories->find_by_id($this->CI->uri->segment(9));//returns category_id and category_name
                return (object) array('current_body'=>self::$current_body, 'current_exam'=>self::$current_exam, 'current_subject'=>self::$current_subject, 'current_period'=>self::$current_period, 'current_category' =>self::$current_category);
        }else {
                self::$current_body = null; self::$current_exam = null; self::$current_subject = null; self::$current_period = null; self::$current_category = null; return null;
        }
    }
}
