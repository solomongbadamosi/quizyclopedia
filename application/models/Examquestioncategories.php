<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examquestioncategories extends MY_Model{
    static $table_name = 'exam_question_categories';
    static $table_pk = 'exam_id';
    static $table_index = NULL;
    static $order_by = NULL;
    static $timestamps = FALSE;
    
    const TABLE_NAME = 'exam_question_categories';
    /*
     * Examination Unique Identifier
     * @var Example NECO, JSCE
     */
    public $exam_id;
    
    /*
     * Questions Category Unique Identifier
     * @var (Obj and Theo)
     */
    public $category_id;
    
}

