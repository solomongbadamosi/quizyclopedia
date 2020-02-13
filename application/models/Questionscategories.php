<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questionscategories extends MY_Model{
    
    static $table_name = 'questions_categories';
    static $table_pk = 'category_id';
    static $table_index = NULL;
    static$order_by = NULL;
    static $timestamps = FALSE;
    
    /*
     * Questions Category Unique Identifier
     * @var (Obj and Theo)
     */
    public $category_id;
    
    /*
     * Name of the two Examinations category available
     * i.e Essay and Multiple Choices
     */
    public $category_name;
    
    public function find_exam_category($exam_id){
        $this->db->select(array('questions_categories.category_name', 'exam_question_categories.category_id', 'exam_question_categories.exam_id'));
        $this->db->from($this::$table_name);
        $this->db->join('exam_question_categories', 'exam_question_categories.category_id = questions_categories.category_id', 'INNER');
        $this->db->where('exam_question_categories.exam_id', $exam_id);
        return $this->db->get();
    }
}

