<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exambodies extends MY_Model{
    
    static $table_name = 'exam_bodies';
    static $table_pk = 'body_id';
    static $order_by = 'body_id';
    
    /*
     * Unique Identification for Examination Bodies
     * @int
     */
    public $body_id;
    
    /*
     * Body name
     * @var
     */
    public $body_name;
    
    /**
     *Full Information Examination body
     * @var type text
     */
    public $about;
    
    /**
     *Brief Information about Body
     * @var type text
     */
    public $brief_info;
    
    /**
     *file name for the body logo
     * @var type string
     */
    public $logo;
    
    /**
     *check if examination body has questions
     * @boolean
     */
    public $ready;
}
