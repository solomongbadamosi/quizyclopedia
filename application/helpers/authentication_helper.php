<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    function get_user_table(){
        $CI = & get_instance();
        $pk = $CI->config->item('user_table_pk');//returns array of primary keys
        $table = $CI->config->item('user_tables');//returns array of tables
        if($CI->session->userdata('user_category')!==NULL){
            $query_string = $table[$CI->session->userdata('user_category')];//return single table for user category
            $pk_string = $pk[$CI->session->userdata('user_category')];//return single pk for user category
            return (object)array('table_name'=>$query_string, 'pk'=>$pk_string);
        }else{
            return NULL;
        }
    }

    /**
     * setting logging in cookie for user
     */
    function cookie(){
        $CI = & get_instance();
        $c_data = $CI->config->item('quizy_cookie');
        if($CI->input->cookie('my_user')===NULL){
            $cookie = array(
           'name' => 'user', 'value' => $CI->users->verification_hash(time()),
           'expire' => 86400*7, 'domain' => $c_data['domain'],
           'path' => '/', 'prefix' => 'my_',
           'secure' => $c_data['secure']
           );
           delete_cookie('user',  $c_data['domain'], '/', 'my_');
           $CI->input->set_cookie($cookie);
       }
    }
    
    /**
     * Return the record of users who login with their email accounts
     * @return object
     */
    function email_user(){
        $CI = & get_instance();
        $user = $CI->users->find_where(array('email' => $CI->input->post('email', TRUE)))->row();
        if($user==NULL){
            $user = $CI->schools->find_where(array('email' => $CI->input->post('email', TRUE)))->row();
        }
        return $user;
    }
    
    /**
     * Return the record of users who login with their email accounts
     * @return object
     */
    function referral_user(){
        $CI = & get_instance();
        return $CI->referrals->find_where(array('user_name' => trim($CI->input->post('email', TRUE))))->row();
    }
    
    /**
     * filter the user's login credential to know which form validation to run
     * if user provides email, the user is either an author, admin or a school
     * if user provides a username, user is a referral
     * @return array
     */
    function filter_user(){
        $CI = & get_instance();
        if(filter_var(trim($CI->input->post('email', TRUE)), FILTER_VALIDATE_EMAIL)){
            //Admin, Schools and Public Users
            $validation = 'login';
        }else{
            //Referral Login
            $validation = 'referral';
        }
        return $validation;
    }
    
    /**
     * Monitor the number of failed attempts on login by user
     * @param type $user
     * @param type $table (object of table name and primary key as properties)
     */
    function get_login_attempts($user, $table){
        $CI = & get_instance();
        $array = array();
        //fetch number of attempts made
        $attempt = $CI->session->userdata('attempt');
        //make increment on attempt
        $attempt++;
        $array['attempt'] = $attempt;
        //set a new value for attempt in session
        $CI->session->set_userdata($array);
        //check if maximum attempts has been made
        if($attempt > 3){
            //update the banned column in database
            $table_name = $table->table_name;
            $count_penalty = $user->pen_count;
            $count_penalty++;
            if($count_penalty == 1){
                $array = array('pen_count'=>$count_penalty, 'attempts'=>time()+900);
            }elseif($count_penalty == 2){
                $array = array('pen_count'=>$count_penalty, 'attempts'=>time()+3600);
            }elseif($count_penalty == 3){
                $array = array('pen_count'=>$count_penalty, 'attempts'=>time()+86400);
            }elseif($count_penalty > 3){
                $array['banned'] = TRUE;
            }
            $CI->$table_name->update($array, $CI->session->userdata('identifier'));
            //reset attempt to default of 0
            $attempt = 0;
            //set temporary data for penalty
            $CI->session->set_tempdata($user->email, TRUE, 900);
            $CI->session->unset_userdata('attempt');
        }
    }
    
    /**
     * used to fetch user table where user category is known
     * @param type $user_category
     * @return type
     */
    function user_table_name_pk($user_category){
        $CI = & get_instance();
        $pk = $CI->config->item('user_table_pk');//returns array of primary keys
        $table = $CI->config->item('user_tables');//returns array of tables
        if($user_category!==NULL){
            $query_string = $table[$user_category];//return single table for user category
            $pk_string = $pk[$user_category];//return single pk for user category
            return (object)array('table_name'=>$query_string, 'pk'=>$pk_string);
        }else{
            return NULL;
        }
    }
    /**
     * fetches user's record by search all tables based on user id supplied
     * @param type $id
     */
    function fetch_user($id){
        $CI = & get_instance();
        if(is_numeric($id)){
            $user_id = array('user_id'=>$id);
            $user = $CI->users->data_count($user_id, 'email, first_name, status, user_category')->row();
        }else{
            if(preg_match('/sch/', $id)){
                $user_id = array('sch_id'=> substr($id, 0, 1));
                $user = $CI->schools->data_count($user_id, 'email, name, status, user_category')->row();
            }else{
                $user_id = array('user_name'=>$id);
                $user = $CI->referrals->data_count($user_id, 'email, first_name, status, user_category, user_name')->row();
            }
            
        }
        return $user;
    }
    
    /**
     * update data where user data is fetched and category is ready
     * @param type $user
     * @param type $data
     */
    function update_user($user, $data){
        $CI = & get_instance();
        if($user->user_category==='School'){
            $CI->schools->update($data, $user->email);
        }elseif($user->user_category==='Referral'){
            $CI->referrals->update($data, $user->user_name);
        }else{
            $CI->users->update($data, $user->email);
        }
    }
    
    /**
     * for resetting passwords for all users except author and public
     */
    function change_password(){
        $CI = & get_instance();
        if ($CI->form_validation->run('email') == TRUE){
            //The user has typed the email address belonging to his account
            $email = trim($CI->input->post('email', TRUE));
            if($email AND $email === $CI->session->email){
                /**user is either an admin, author or a referral
                 * these group can only reset their passwords after they have logged in
                 */
                $CI->myvalidation->send_validation($email);
            }else{
                $CI->session->set_flashdata('error_msg', 'Invalid Credential supplied');
                $CI->myvalidation->p_wrd_reset_view();
            }
        }else{
            $CI->myvalidation->p_wrd_reset_view();
        }
    }
    
    
    
    
    
