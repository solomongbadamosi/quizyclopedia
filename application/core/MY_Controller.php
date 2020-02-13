<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Controller extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        
    }
    
        /**
         * Load view for manage content method
         * @param type $offset
         * @param type $pagination_data
         */
    protected function go_home($offset=null, $pagination_data=null){
        $bodies_set = $this->exambodies->find(2, $offset);
        $this->load->view('layout/head');
        $this->load->view('admin/manage_content', array('bodies_set' => $bodies_set, 'pagination'=>$pagination_data));
        $this->load->view('layout/footer');
    }
    
    
    protected function pagination(){
        $config['full_tag_open'] = '<ul class="pagination">';
         $config['full_tag_close'] = '</ul>';
         $config['num_tag_open'] = '<li>';
         $config['num_tag_close'] = '</li>&nbsp';
         $config['cur_tag_open'] = '<li class="active btn btn-primary text-white"><a>';
         $config['cur_tag_close'] = '</a></li>&nbsp';
         $config['prev_tag_open'] = '<li class="btn btn-primary">';
         $config['prev_tag_close'] = '</li>&nbsp';
         $config['first_tag_open'] = '<li class="btn btn-dark">';
         $config['first_tag_close'] = '</li>&nbsp';
         $config['last_tag_open'] = '<li class="btn btn-dark">';
         $config['last_tag_close'] = '</li>&nbsp';


         $config['prev_link'] = '<button class="btn btn-warning"><i class="fa fa-long-arrow-left"> </i> '
                 . '<span class="text-white">Previous Page</span></button>';
         $config['prev_tag_open'] = '<li>';
         $config['prev_tag_close'] = '</li>&nbsp';

         $config['next_link'] = '<button class="btn btn-warning"><span class="text-white">Next Page</span> <i class="fa fa-long-arrow-right"></i></button>';
         $config['next_tag_open'] = '<li>';
         $config['next_tag_close'] = '</li>&nbsp';

         $this->pagination->initialize($config);    
    }
    
    
    /**
     * Filters form_input into Solution form
     * @return type Array
     */
    protected function solution_prep(){
        return $solution_data = array('exam_id'=>trim($this->input->post('exam_id')), 
            'body_id'=>trim($this->input->post('body_id')),
            'subject_id'=>trim($this->input->post('subject_id')),
            'period_id'=>trim($this->input->post('period_id')),
            'question_number'=>trim($this->input->post('question_number')),
            'solution'=>trim($this->input->post('solution')),
            );
    }
    
    protected function where($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum=null){
        $data = array(
            'body_id' => $body_id,
            'exam_id' => $exam_id,
            'subject_id' => $subject_id,
            'period_id' => $period_id,
            'category_id' => $category_id,
        );
        if($qnum!=null){
             $data['question_number'] = $qnum;
            }
        return $data;
    }
    
    protected function solution_where($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum=null){
        $data = array(
            'body_id' => $body_id,
            'exam_id' => $exam_id,
            'subject_id' => $subject_id,
            'period_id' => $period_id,
            'category_id' => $cat_id,
        );
        if($qnum!=null){
             $data['question_number'] = $qnum;
            }
        return $data;
    }
    
    protected function time_where($body_id, $exam_id, $subject_id){
        return $data = array(
            'body_id' => $body_id,
            'exam_id' => $exam_id,
            'subject_id' => $subject_id,
        );
    }
}
