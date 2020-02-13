<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailverifications extends MY_Model{
    
    static $table_name = 'mail_verifications';
    static $table_pk = 'email';
    static $order_by = '';
    
    /*
     * Email Address of the user
     * @int
     */
    public $email;
    
    /*
     * unique code for email verifications
     * @var
     */
    public $code;
}

