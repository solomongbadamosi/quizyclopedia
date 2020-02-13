<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questiondiagrams extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'question_diagrams';
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
    public $image;
    
    
    /**
     * Options Data for inputing Options
     */
    public function prep(){
        return $where = $this->question_where();
    }
}