<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class References extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'references';
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
    *file name for the instruction diagrams
    * @var type strings
    */
    public $ref;
    
    
    /**
     * Reference Data for input
     */
    public function prep(){
        $where = $this->question_where();
        $where['ref']=trim($this->input->post('ref'));
        return $where;
    }
}