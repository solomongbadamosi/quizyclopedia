<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myquestions {
    //create ancillary class with $ci
     protected $CI;
     
    
    // We'll use a constructor, as you can't directly call a function
        // from a property definition.
    function __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->model(array('questiondiagrams', 'instructiondiagrams', 'instructions', 'options', 'references', 'refdiagrams', 'questions'));
    }

    
    private function update_question($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum=null){
        $database = array('instruction'=>'instructions', 'A'=>'options', 'ref'=>'references');
        $prep = array();
        foreach($database as $key => $value){
            $prep[$key] = $this->CI->{$value}->prep();
        }
        $q_data = $this->CI->questions->prep(); 
        //upload Questions
        if($qnum === null){
            $where = '';
            $this->CI->questions->insert($q_data);
            $this->insert_item($database, $prep);
            $this->CI->session->set_flashdata('success_msg', 'Question Number '.$q_data['question_number'].' successfully Updated');
            redirect($this->CI->uri->uri_string(), 'refresh');
            //upadate question
        }else{
            $where = $this->where($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum);
            //update questions
            $this->CI->questions->update($q_data, $where);
            //Update other variables
            $this->update_item($database, $prep, $where);
            $this->CI->session->set_flashdata('success_msg', 'Question Number '.$q_data['question_number'].' updated');
            redirect('admin/content/manage/questions/'.$body_id.'/'.$exam_id.'/'.$subject_id.'/'.$period_id.'/'.$category_id, 'refresh');
        }
    }
    
    /**
     * For inserting options, instructions and references
     * @param type $database
     * @param type $prep
     */
    private function insert_item($database, $prep){
        foreach($database as $key => $value){
            if($this->CI->input->post($key)){
                $this->CI->{$value}->insert($prep[$key]);
            }
        }
    }
    
   /**
    * updating instructions, options, and refrences
    * @param type $database
    * @param type $prep
    * @param type $where
    */
    private function update_item($database, $prep, $where){
        foreach($database as $key => $value){
            if($this->CI->input->post($key)){
                $this->perform_update($prep, $where, $value, $key);
            }
        }
    }
    
    //where clause for query
    private function where($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum=null){
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
    
    /**
     * for inserting or updating questions and answers
     * @param int $body_id
     * @param string $exam_id
     * @param string $subject_id
     * @param string $period_id
     * @param string $category_id
     * @param int $qnum
     */
    public function check_update($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum, $image){
        //upload images
        $upload_data = $this->CI->upload->data();
        if(isset($upload_data['file_name'])&& $upload_data['file_name'] !=''){
            //set database for saving images
        $database = array('diagram'=>'questiondiagrams', 'inst_diagram'=>'instructiondiagrams', 'sol_diagram'=>'refdiagrams' );
            foreach ($database as $key => $value) {
                $this->perform_insert($value, $key, $image);
            }
        }
        //insert or Update questions 
        $this->update_question($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum);
    }
    
    public function exiting_questions($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum){
        $where = $this->CI->questions->where($body_id, $exam_id, $subject_id, $period_id, $category_id, $qnum);
        return $question_data = array(
            'question' => $this->CI->questions->find_where($where)->row(),
            'instruction' => $this->CI->instructions->data_count($where, 'instruction')->row(),
            'ref' => $this->CI->references->data_count($where, 'ref')->row(),
            'option' => $this->CI->options->data_count($where, 'A, B, C, D, E, correct')->row(),
            );
    }
    //updating instruction, options, and references
    private function perform_update($prep, $where, $value, $key){
        if($this->CI->{$value}->data_count($where, $key)->row()){
            $this->CI->{$value}->update($prep[$key], $where);
        }else{$this->CI->{$value}->insert($prep[$key]);}
    }
    /**
     * for inserting image filename into the database
     * @param type $value
     * @param type $key
     * @param type $image
     */
    private function perform_insert($value, $key, $image){
        foreach($image as $img_key){
            if($img_key === $key){
                $prep = $this->CI->{$value}->prep();
                $data = $this->CI->{$value}->prep();
                $data['image'] = $_FILES[$key]['name'];
                $this->existence($prep, $value, $data);
            }
        }
    }
    //if image exist insert else update
    private function existence($prep, $value, $data){
        $exist = $this->CI->{$value}->data_count($prep, 'image')->row();
        if($exist){
            $this->CI->{$value}->update($data, $prep);
        }else{
            $this->CI->{$value}->insert($data);
        }
    }
}