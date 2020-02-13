<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'questions';
    static $order_by = 'question_number';
    
    /*
     * unique to each examination
     * @int
     */
    public $question_number;
    
    /*
     * Primary Keys to questions table
     * and secondary to their parent tables
     */
    public $exam_id;
    
    public $subject_id;
    
    public $period_id;
    
    public $category_id;
    
    public $body_id;
    
    /*
     * for both multiple choice and 
     * Essay Questions
     * @text
     */
    public $question;
    
    
    public function find_count($body_id, $exam_id, $subject_id, $period_id, $cat_id) {
        $where = $this->where($body_id, $exam_id, $subject_id, $period_id, $cat_id);
        $this->db->select('question_number');
        $this->db->from($this::$table_name);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function where($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum=null){
        $array = array(
            'body_id'=>$body_id,
            'exam_id'=>$exam_id,
            'subject_id'=>$subject_id,
            'period_id'=>$period_id,
            'category_id'=>$cat_id,
            );
        if($qnum!==null){
            $array['question_number'] = $qnum;
        }
        return $array;
    }
    
    public function find_answer($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum, $choice){
        $where = "(body_id='{$body_id}' AND exam_id='{$exam_id}' AND subject_id='{$subject_id}' AND period_id='{$period_id}' AND category_id='{$cat_id}' AND question_number='{$qnum}') AND "
        . "( option='{$choice}' OR option2='{$choice}' OR option3='{$choice}' OR option4='{$choice}' OR option5='{$choice}')";
        $this->db->select('correct_option');
        $this->db->from($this::$table_name);
        if($choice){
        $this->db->where($where);
        }
        $query = $this->db->get();
        return $query;
    }
    
    public function count($where_id){
        
        $this->db->select('question_number');
        $this->db->from($this::$table_name);
        $this->db->where($where_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * Options Data for inputing Options
     */
    public function prep(){
        $where = $this->question_where();
        $where['question']=trim($this->input->post('question'));
        return $where;
    }
}