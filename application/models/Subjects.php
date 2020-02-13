<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends MY_Model{
    static $table_name = 'subjects';
    static $table_pk = 'subject_id';
    static $table_index = NULL;
    static$order_by = 'subject_name';
    static $timestamps = FALSE;
    
    /*
     * Examination Subjects unique Identification
     * @var Example ACC = Account, BIZSTD = Business Studies
     */
    public $subject_id;
    
    /*
     * names of all the subjects available in this project
     */
    public $subject_name;
}

