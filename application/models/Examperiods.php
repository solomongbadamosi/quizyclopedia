<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examperiods extends MY_Model{
   static $table_name = 'exam_periods';
    static $table_pk = 'exam_id';
    static $table_index = 'period_id';
    static $order_by = NULL;
    static $timestamps = FALSE;
    /*
     * Examination period Identification
     * @var Example YrK00 = Year 2000
     */
    public $period_id;
    /*
     * Examination Unique Identifier
     * @var Example NECO, JSCE
     */
    public $exam_id;
    
    public function find_exam_periods ($exam_id) {
        $this->db->select(array('exam_periods.exam_id', 'periods.position', 'periods.period_name', 'exam_periods.period_id'));
        $this->db->from($this::$table_name);
        $this->db->where('exam_periods.exam_id', $exam_id);
        $this->db->join('periods', 'periods.period_id = exam_periods.period_id', 'INNER');
        $this->db->order_by('periods.position');
        $query = $this->db->get();
        return $query;
	}
}
