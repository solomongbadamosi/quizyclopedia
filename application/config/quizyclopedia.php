<?php

/* 
 * This array holds user groups and their ids
 * 
 */
$config['user_type'] = array(
    'Author' => 1,
    'Admin' =>2,
    'Referral' =>3,
    'School' => 4,
    'Public' => 5
);

/**
 * Names of tables according to their user types
 */
$config['user_tables'] = array(
    'Author'=>'users',
    'Admin'=>'users',
    'Referral'=>'referrals',
    'School'=>'schools',
    'Public'=>'users',
);

/**
 * Names of tables primary keys according to their user types
 */
$config['user_table_pk'] = array(
    'Author'=>'email',
    'Admin'=>'email',
    'Referral'=>'user_name',
    'School'=>'sch_id',
    'Public'=>'email',
);

/**
 * Names of tables primary keys according to their user types
 */
$config['mail_users'] = array(
    'Author'=>'email',
    'Admin'=>'email',
    'School'=>'email',
    'Public'=>'email',
);


/**
 * cookie configuration for quizyclopedia
 */
$config['quizy_cookie'] = array(
    'domain'=>'[::1]',
    'secure'=>FALSE,
);
