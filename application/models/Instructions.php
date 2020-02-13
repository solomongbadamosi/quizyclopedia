<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructions extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'instructions';
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
    
    public $body_id;
    
    public $subject_id;
    
    public $period_id;
    
    public $category_id;
    
   /**
    *Question instructions
    * @var type strings
    */
    public $instruction;
    
    /**
     * Options Data for inputing Options
     */
    public function prep(){
        $where = $this->question_where();
        $where['instruction']=trim($this->input->post('instruction'));
        return $where;
    }
}