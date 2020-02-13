<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examsubjectperiods extends MY_Model{
    static $table_name = 'exam_subject_periods';
    //static $table_index = 'subject_id';
    //static $order_by = 'period_id';
    static $timestamps = FALSE;
    
    /*
     * Unique Identification for Examination
     */
    public $exam_id;
    
    /*
     * Examination period Identification
     * @var Example YrK00 = Year 2000
     */
    public $period_id;
    
    /*
     * Examination Subjects unique Identification
     * @var Example ACC = Account, BIZSTD = Business Studies
     */
    public $subject_id;
    
    /**
     * for Administrative use
     * @param type $exam_id
     * @param type $subject_id
     * @return type
     */
    public function find_subject_periods($exam_id, $subject_id){
        $this->db->select(array('periods.period_id', 'exam_subject_periods.subject_id',
            'exam_subject_periods.ready', 'periods.position', 'exam_subject_periods.exam_id', 'periods.period_name'));
        $this->db->from($this::$table_name);
        $this->db->where('exam_subject_periods.exam_id', $exam_id);
        $this->db->where('exam_subject_periods.subject_id', $subject_id);
        $this->db->join('periods', 'periods.period_id=exam_subject_periods.period_id', 'INNER');
        //$this->db->join('exam_periods', 'exam_periods.period_id=period_subjects.period_id', 'INNER');
        $this->db->order_by('periods.position', 'asc');
        return $this->db->get();
    }
    
    /**
     * Display periods for public 
     * @param type $exam_id
     * @param type $subject_id
     * @return type
     */
    public function public_subject_periods($exam_id, $subject_id){
        $this->db->select(array('periods.period_id', 'exam_subject_periods.subject_id',
            'exam_subject_periods.ready', 'periods.position', 'exam_subject_periods.exam_id', 'periods.period_name'));
        $this->db->from($this::$table_name);
        $this->db->where('exam_subject_periods.exam_id', $exam_id);
        $this->db->where('exam_subject_periods.subject_id', $subject_id);
        $this->db->where('exam_subject_periods.ready', TRUE);
        $this->db->join('periods', 'periods.period_id=exam_subject_periods.period_id', 'INNER');
        $this->db->order_by('periods.position', 'asc');
        return $this->db->get();
    }
}

