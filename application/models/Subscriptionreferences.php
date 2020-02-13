<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriptionreferences extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'subscription_references';    
    /*
     * unique to reference
     * @email of subscriber
     */
    public $email;
    
    /*
     * reference code
     */
    public $reference;
    
    /*
     * amount
     */
    public $amount;
    
}