<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refdiagrams extends MY_Model{
    
    static $table_name = 'ref_diagrams';
    /*
     * Examination Unique Identifier
     * @var Example NECO, JSCE
     */
    public $exam_id;
    
    /*
     * Examination Subjects unique Identification
     * @var Example ACC = Account, BIZSTD = Business Studies
     */
    public $subject_id;
    
    /*
     * Examination period Identification
     * @var Example YrK00 = Year 2000
     */
    public $period_id;
    
    /*
     * Questions category identification
     * @var Example Obj or Theo
     */
    public $category_id;
    
    /*
     * Quesstion number 
     * @int
     */
    public $question_number;
    
    /*
     * diagrams for solutions
     * @Text
     */
    public $solution_diagram;
    
    
    /**
     * Options Data for inputing diagram file name
     */
    public function prep(){
        return $where = $this->question_where();
    }
    
}
