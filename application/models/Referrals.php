<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referrals extends MY_Model{
    function __construct() {
        parent::__construct();
    }
    
    static $table_name = 'referrals';
    static $table_pk = 'user_name';
    static $timestamps = FALSE;
    static $order_by = 'user_name';
    
    /**
     *
     * unique identification number for users
     * @var type mixed
     */
    public $user_name;
    
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
     *the name of the bank used by referral
     * @var type in
     */
    public $banker;
    
    /**
     *the phone number of referral
     * @var type int
     */
    public $phone_number;
    
    /**
     *amount accrued to the referral from user's subscription
     * @var type int
     */
    public $amount;
    
    
    /**
     *
     * the account number of the referals
     * @var type integer
     */
    public $account_number;
    
    /**
     *
     * Active or Not
     * @var type tinyinteger
     */
    public $status;
    
    /**
     *
     * referral
     * @var type text
     */
    public $user_category;
    
    /**
     *
     * login time
     * @var type timestamp
     */
    public $logged_in;
    
    /**
     *
     * cookie value
     * @text
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
     *Time of Expiration for Schools
     * Default is null
     * @var type text
     */
    public $expiry_time = NULL;
    
    
     
//    public function referral_signup(){
//        //run the insert query and return number of affected rows
//             $data = array(
//           'user_name' => $this->input->post('user_name'), 'password' => $this->users->hash($this->input->post('password')),
//           'confirm_password' => $this->users->hash($this->input->post('confirm_password')), 'email' => $this->input->post('email'),
//           'first_name' => $this->input->post('first_name'), 'last_name' => $this->input->post('last_name'),
//           'phone_number' => $this->input->post('phone_number'), 'gender' => $this->input->post('gender'),
//           'state_of_residence' => $this->input->post('state_of_residence'), 'subscribed' => '1',
//           'subscription_date' => '', 'expiry_date' => '', 'user_category' => 'Admin',
//        );
//             if(''){
//        //sql returns number of affected rows
//                 $this->users->save($data);
//             }else{
//             $this->session->set_flashdata('error', 'A user with this username/email already exists');
//         }
//     }
     
     
}