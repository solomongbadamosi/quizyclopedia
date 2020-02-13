<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timers extends MY_Model{
    
    static $table_name = 'timers';
    static $table_pk = 'time_id';
    static $order_by = 'time_id';
    
    /*
     * Unique Identification for Examination Time
     * @int
     */
    public $time_id;
    
    /*
     * Hours taken for the Exam Subject
     * @float
     */
    public $hour;
    
    
}
