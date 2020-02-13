<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'options';
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
     * Options
     * for both multiple choice Questions
     * @text
     */
    public $option;
    
    /*
     * Options 1 -5 => Choices for multiple choice questions
     * @text
     */
    public $A;
    
    public $B;
    
    public $C;
    
    public $D;
    
    public $E;
    
    /*
     * Correct Option for the question
     * among options 1 -5 above
     */
    public $correct;
    
    /**
     * Options Data for inputing Options
     */
    public function prep(){
        $where = $this->question_where();
        $where['A']=trim($this->input->post('A'));
        $where['B']=trim($this->input->post('B'));
        $where['C']=trim($this->input->post('C'));
        $where['D']=trim($this->input->post('D'));
        $where['E']=trim($this->input->post('E'));
        $where['correct']=trim($this->input->post('correct_option'));
        return $where;
    }
    
}