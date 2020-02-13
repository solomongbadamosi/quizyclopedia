<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schools extends MY_Model{
    
    static $table_name = 'schools';
    static $table_pk = 'sch_id';
    
    /*
     * School Unique Id
     * @int
     */
    public $sch_id;
    
    /*
     * School Unique Id
     * @int
     */
    public $name;
    
    /*
     * School Unique Id
     * @int
     */
    public $contact_person;
    
    /*
     * School Unique Id
     * @int
     */
    public $phone;
    
    /*
     * School Unique Id
     * @int
     */
    public $location;
    
    /*
     * School Unique Id
     * @int
     */
    public $ref_id;
    
    /*
     * Amount due to school from students' subscription
     * @int
     */
    public $amount;
    
    /**
     *
     * password for users using SHA12
     * @var type mixed
     */
    public $password;
    
    /**
     *confirmation of user password
     * @var type mixed
     */
    public $confirm_password;
    
    /**
     *cookie value set for user
     * @var type mixed
     */
    public $cookie;
    
    /**
     *number of attempts made on login
     * @var type mixed
     */
    public $attempts;
    
    /**
     *if user is banned or not
     * @var type mixed
     */
    public $banned;
    
    /**
     *the unique email address of a user
     * @var type email
     */
    public $email;
    
    
    /**
     *Unix time stamp of expiry date of subscription
     * @var type date-time stamp
     */
    public $logged_in;
    
    
    /**
     *
     * The user_category of school
     * @var type text
     */
    public $user_category;
    
    /**
     *This is to show if a user has authenticated the email used in registration
     * Active and Inactive
     * @var type text
     */
    public $status;
    
    /**
     *Time of Expiration for Schools
     * Default is null
     * @var type text
     */
    public $expiry_time = NULL;
}
   
    
    