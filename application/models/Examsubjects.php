<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examsubjects extends MY_Model{
    
    
    static $table_name = 'exam_subjects';
    static $table_pk = 'subject_id';
    static $table_index = 'exam_id';
    static$order_by = 'subject_id';
    static $timestamps = FALSE;
    /*
     * Examination Subjects unique Identification
     * @var Example ACC = Account, BIZSTD = Business Studies
     */
    public $subject_id;
    
    /*
     * Examination Unique Identifier
     * @var Example NECO, JSCE
     */
    public $exam_id;
    
    public function find_exam_subjects ($exam_id, $limit=null, $offset=null) {
	
       $this->db->select(array('examinations.exam_id', 'subjects.subject_id', 'subjects.subject_name'));
        $this->db->from($this::$table_name);
        $this->db->where('examinations.exam_id', $exam_id);
        $this->db->join('examinations', 'examinations.exam_id = exam_subjects.exam_id', 'INNER');
        $this->db->join('subjects', 'subjects.subject_id = exam_subjects.subject_id', 'INNER');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query;
	}
}

