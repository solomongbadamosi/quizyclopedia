<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examtimers extends MY_Model{
    
    static $table_name = 'exam_timers';
    //static $table_pk = 'time_id';
    
    /*
     * Unique Identification for Examination Bodies
     * @int
     */
    public $exam_id;
    
    
    /*
     * Unique Identification for Examination 
     * @string
     */
    public $time_id;
    
    
    /*
     * Unique Identification for Examination Time
     * @int
     */
    public $subject_id;
    
    
    /*
     * Unique Identification for Examination Subjects
     * @string
     */
    public $body_id;
    
    public function get_time($where){
        $this->db->select(array('exam_timers.time_id', 'exam_timers.body_id', 'exam_timers.exam_id', 'exam_timers.subject_id', 'timers.hour'));
        $this->db->from($this::$table_name);
        $this->db->where($where);
        $this->db->join('timers', 'timers.time_id = exam_timers.time_id');
        $query = $this->db->get();
        return $query;
    }
}
