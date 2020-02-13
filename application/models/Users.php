<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Model{
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'users';
    static $table_pk = 'email';
    //static $table_index = 'email';
    static $timestamps = FALSE;
    static $order_by = 'user_id';
    
    /**
     *
     * unique identification number for users
     * @var type mixed
     */
    public $user_id;
    
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
     *the first name of the user
     * @var type text
     */
    public $first_name;
    
    /**
     *the last name of the user
     * @var type text
     */
    public $last_name;
    
    /**
     *check whether user is actively subscribed or not
     * @var type boolean
     */
    
    public $subscribed;
    
    /**
     *Unix time stamp of expiry date of subscription
     * @var type date-time stamp
     */
    public $logged_in;
    
    
    /**
     *
     * Admin, Public, Author
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
     *The amount paid by user during subscription
     * @var type integer
     */
    public $amount;
    
    /**
     *The user's phone number
     * @var type integer
     */
    public $phone;
    
    /**
     *The School id of the user, if any
     * @var type integer
     */
    public $school_id;
    
    
     
    public function admin_signup(){
        //run the insert query and return number of affected rows
             $data = array(
           'user_name' => $this->input->post('user_name'), 'password' => $this->users->hash($this->input->post('password')),
           'confirm_password' => $this->users->hash($this->input->post('confirm_password')), 'email' => $this->input->post('email'),
           'first_name' => $this->input->post('first_name'), 'last_name' => $this->input->post('last_name'),
           'phone_number' => $this->input->post('phone_number'), 'gender' => $this->input->post('gender'),
           'state_of_residence' => $this->input->post('state_of_residence'), 'subscribed' => '1',
           'subscription_date' => '', 'expiry_date' => '', 'user_category' => 'Admin',
        );
             if(''){
        //sql returns number of affected rows
                 $this->users->save($data);
             }else{
             $this->session->set_flashdata('error', 'A user with this username/email already exists');
         }
     }
     
     
}