<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mycaptcha {
     
    private $CI;
    // We'll use a constructor, as you can't directly call a function
        // from a property definition.
    function __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->helper(array('captcha'));
    }
    
    /**
     * method for creating captcha
     */
    public function establish_captcha(){
        //set captcha configuration
        $vals = $this->captcha_config();
        //create captcha from configurations
        $cap = create_captcha($vals);
        //save into database
        $data = array(
                'captcha_time'  => $cap['time'],
                'ip_address'    => $this->CI->input->ip_address(),
                'word'          => $cap['word']
        );

        $query = $this->CI->db->insert_string('captcha', $data);
        $this->CI->db->query($query);
        return $cap;
    }
    
    private function captcha_config(){
        return     $vals = array(
            'img_path' => './captcha/',
            'img_url' => base_url('captcha/'),
            'font_path'     => FCPATH.'captcha/font/font.ttf',
            'img_width'     => 200,
            'img_height'    => 120,
            'expiration'    => 300,
            'word_length'   => 5,
            'font_size'     => 30,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                    'background' => array(250, 250, 250),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(255, 40, 40)
            )
        );
    }
    
    public function verify(){
        // First, delete old captchas
        $expiration = time() - 300; // 1 minute
        $this->CI->db->where('captcha_time < ', $expiration)
                ->delete('captcha');

        // Then see if a captcha exists:
        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        $binds = array($this->CI->input->post('captcha'), $this->CI->input->ip_address(), $expiration);
        $query = $this->CI->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0)
        {
          $this->CI->session->set_flashdata('error_msg', 'Word Does not Match, Please!');
          if($this->CI->uri->segment(2)=='login'){
              redirect('user/login', 'refresh');
          }else{
              redirect('user/signup', 'refresh');
          }
        }
    }
}

