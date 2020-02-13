<?php

$config = array(
    //validation for Reset Password
        'subscription' => array(
                array(
                        'field' => 'amount',
                        'label' => 'amount',
                        'rules' => 'trim|required|numeric'
                ),
        ),
    //validation for Reset Password
        'password' => array(
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'confirm_password',
                        'label' => 'Confirm Password',
                        'rules' => 'trim|required|matches[password]'
                ),
        ),
    //validation Email Confirmation
        'email' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email'
                ),
            ),
    //validation for user Login
        'login' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email/Username',
                        'rules' => 'trim|required|valid_email'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required'
                ),
        ),
    //validation for user Contact Message
        'contact_mail' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email Address',
                        'rules' => 'trim|required|valid_email'
                ),
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Phone Number',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'message',
                        'label' => 'Message',
                        'rules' => 'trim|required'
                ),
        ),
    //validation for school registration
        'schools' => array(
                array(
                        'field' => 'name',
                        'label' => 'School Name',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'location',
                        'label' => 'School Location',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Phone Number',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'contact_person',
                        'label' => 'Contact Persson',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'email',
                        'label' => 'School Email',
                        'rules' => 'trim|required|valid_email'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'confirm_password',
                        'label' => 'Confirm Password',
                        'rules' => 'trim|required|matches[password]'
                ),
        ),
    
    //validation Viewing Results
        'result' => array(
                array(
                        'field' => 'first_name',
                        'label' => 'First Name',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'last_name',
                        'label' => 'Last Name',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'sch_name',
                        'label' => 'School Name',
                        'rules' => 'trim|required'
                ),
        ),
    //validation for Referral Login
        'referral' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email/Username',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required'
                ),
        ),
    //validation for active user
        'active' => array(
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required'
                ),
        ),
    //Validation for user Registration
        'signup' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[40]'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'confirm_password',
                        'label' => 'Confirm Password',
                        'rules' => 'trim|required|matches[password]'
                ),
                array(
                        'field' => 'first_name',
                        'label' => 'First Name',
                        'rules' => 'trim|required|alpha|max_length[25]'
                ),
                array(
                        'field' => 'last_name',
                        'label' => 'Last Name',
                        'rules' => 'trim|required|alpha|max_length[25]'
                ),
                array(
                        'field' => 'referral',
                        'label' => 'Referral',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Phone Number',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'school',
                        'label' => 'School',
                        'rules' => 'trim'
                ),
        ),
    //Validation for Referral Registration
        'signup_referral' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[40]'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'confirm_password',
                        'label' => 'Confirm Password',
                        'rules' => 'trim|required|matches[password]'
                ),
                array(
                        'field' => 'user_name',
                        'label' => 'User Name',
                        'rules' => 'trim|required|alpha_numeric|max_length[25]'
                ),
                array(
                        'field' => 'first_name',
                        'label' => 'First Name',
                        'rules' => 'trim|required|alpha|max_length[25]'
                ),
                array(
                        'field' => 'last_name',
                        'label' => 'Last Name',
                        'rules' => 'trim|required|alpha|max_length[25]'
                ),
                array(
                        'field' => 'phone_number',
                        'label' => 'Phone Number',
                        'rules' => 'trim|required|numeric|max_length[15]'
                ),
                array(
                        'field' => 'account_number',
                        'label' => 'Account Number',
                        'rules' => 'trim|required|numeric|min_length[10]|max_length[10]'
                ),
                array(
                        'field' => 'banker',
                        'label' => 'Bank Name',
                        'rules' => 'trim|required'
                ),
        ),
    
    //Validation for Examination Subject Periods
        'subject_period' => array(
                array(
                        'field' => 'subject_id',
                        'label' => 'Subject Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'period_id',
                        'label' => 'Period Code',
                        'rules' => 'trim|required|alpha_numeric'
                )
            ),
    
    //Validation for Examination Periods
        'exam_period' => array(
                array(
                        'field' => 'exam_id',
                        'label' => 'Exam Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'period_id',
                        'label' => 'Period Code',
                        'rules' => 'trim|required|alpha_numeric'
                )
            ),
    
    //Validation for Periods
        'period' => array(
                array(
                        'field' => 'period_id',
                        'label' => 'Period Code',
                        'rules' => 'trim|required|alpha_numeric'
                ),
                array(
                        'field' => 'period_name',
                        'label' => 'Period Name',
                        'rules' => 'trim|required|numeric'
                )
            ),
    
    //Validation for subjects
        'subject' => array(
                array(
                        'field' => 'subject_id',
                        'label' => 'Subject Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'subject_name',
                        'label' => 'Subject Name',
                        'rules' => 'trim|required|alpha_numeric_spaces'
                )
            ),
    
    //Validation for Examination Subjects
        'exam_subject' => array(
                array(
                        'field' => 'exam_id',
                        'label' => 'Exam Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'subject_id',
                        'label' => 'Subject Code',
                        'rules' => 'trim|required|alpha'
                )
            ),
    
    //Validation for Examination Questions Category
        'exam_category' => array(
                array(
                        'field' => 'exam_id',
                        'label' => 'Exam Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'category_id',
                        'label' => 'Category Code',
                        'rules' => 'trim|required|alpha'
                )
            ),
    
    //Validation for Examination Body
        'body' => array(
                array(
                        'field' => 'body_name',
                        'label' => 'Body Name',
                        'rules' => 'trim|required|alpha_numeric_spaces'
                ),
                array(
                        'field' => 'about',
                        'label' => 'About Examination Body',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'brief_info',
                        'label' => 'Brief Information',
                        'rules' => 'trim'
                ),
            ),
    
  
    //Validation for Examination
        'exam' => array(
                array(
                        'field' => 'exam_id',
                        'label' => 'Exam Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'body_id',
                        'label' => 'Body Code',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'position',
                        'label' => 'Position',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'exam_name',
                        'label' => 'Exam Name',
                        'rules' => 'trim|required|alpha_numeric_spaces'
                ),
            ),
    
    //validation for Questions
        'question' => array(
                array(
                        'field' => 'exam_id',
                        'label' => 'Exam Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'body_id',
                        'label' => 'Body Code',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'subject_id',
                        'label' => 'Subject Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'category_id',
                        'label' => 'Category Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'period_id',
                        'label' => 'Period Code',
                        'rules' => 'trim|required|alpha_numeric'
                ),
                array(
                        'field' => 'question_number',
                        'label' => 'Question Number',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'instruction',
                        'label' => 'Instruction',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'question',
                        'label' => 'Question',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'A',
                        'label' => 'First Option',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'B',
                        'label' => 'Second Option',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'C',
                        'label' => 'Third Option',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'D',
                        'label' => 'Fourth Option',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'E',
                        'label' => 'Fifth Option',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'diagram',
                        'label' => 'Image',
                        'rules' => 'trim|alpha_numeric'
                ),
                array(
                        'field' => 'sol_diagram',
                        'label' => 'Image',
                        'rules' => 'trim|alpha_numeric'
                ),
                array(
                        'field' => 'inst_diagram',
                        'label' => 'Image',
                        'rules' => 'trim|alpha_numeric'
                ),
                array(
                        'field' => 'correct_option',
                        'label' => 'Correct Answer',
                        'rules' => 'trim'
                ),
                array(
                        'field' => 'ref',
                        'label' => 'Reference',
                        'rules' => 'trim'
                ),
            ),
    //validation for Solutions
        'solution' => array(
                array(
                        'field' => 'exam_id',
                        'label' => 'Exam Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'body_id',
                        'label' => 'Body Code',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'subject_id',
                        'label' => 'Subject Code',
                        'rules' => 'trim|required|alpha'
                ),
                array(
                        'field' => 'period_id',
                        'label' => 'Period Code',
                        'rules' => 'trim|required|alpha_numeric'
                ),
                array(
                        'field' => 'question_number',
                        'label' => 'Question Number',
                        'rules' => 'trim|required|numeric'
                ),
                array(
                        'field' => 'solution',
                        'label' => 'Solution',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'solution_diagram',
                        'label' => 'Image',
                        'rules' => 'trim'
                ),
            )
);

$config['error_prefix'] = '<div class="text-success"><h3>';
$config['error_suffix'] = '</div></h3>';
