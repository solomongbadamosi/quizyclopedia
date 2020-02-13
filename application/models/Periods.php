<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periods extends MY_Model{
    
    static $table_name = 'periods';
    static $table_pk = 'period_id';
    static $table_index = NULL;
    static $order_by = 'position';
    
   /*
     * Examination period Identification
     * @var Example YrK00 = Year 2000
     */
    public $period_id;
    
    /*
     * Examination Years
     * @int Examaple 2009
     */
    public $period_name;
    
    /*
     * Ordered Arrangement of Years
     * @int
     */
    public $position;
}

