<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examinations extends MY_Model{
    
    static $table_name = 'examinations';
    static $table_pk = 'exam_id';
    static $table_index = 'body_id';
    static$order_by = 'position';
    static $timestamps = FALSE;
    /*
     * Examination Unique Identifier
     * @var Example NECO, JSCE
     */
    public $exam_id;
    
    /*
     * Examination Body Identifier
     * @int
     */
    public $body_id;
    
    /*
     * Examination Order Arrangement
     * @int
     */
    public $position;
    
    /*
     * Examination Description
     * @var
     */
    public $description;
    
    /*
     * Examination name
     * @var
     */
    public $exam_name;
    
    /*
     * check if examination has questions
     * @boolean
     */
    public $ready;
    
    public function position_count($where_id=null){
        $this->db->select($this::$order_by);
        $this->db->from($this::$table_name);
        if($where_id!=null){
            $this->db->where($this::$table_index, $where_id);
        }
        return $this->db->get()->num_rows();
    }
}
