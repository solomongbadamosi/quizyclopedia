<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Model extends CI_Model{
    
    static $table_name;
    static $table_pk;
    static $table_index;
    static $order_by;
    static $timestamps = FALSE;
    static $pk;
    
    function __construct() {
        parent::__construct();
    }
    
    /**
    * Load from the database.
     * @param mixed
     */
      public function find_by_id($id, $limit=null, $offset=0){
       $query = $this->db->get_where($this::$table_name, array(
            $this::$table_pk => $id),$limit, $offset);
       return $query->row();
      }
          
      public function find($limit=null, $offset=null){
        $query = $this->db->select()
                ->from($this::$table_name)
                ->order_by($this::$order_by, 'ASC')
                ->limit($limit, $offset)
                ->get();
        return $query; 
      }
      
      /**
     * finds names of table columns
     * @return object
     */
   
    private function table_columns(){
        $column = array();
        $query = $this->db->select('column_name')
                     ->from('information_schema.columns')
                     ->where('table_name', $this::$table_name)
                     ->get($this::$table_name)->result_array();
        //return individual table column
        foreach($query as $column_array){
            foreach($column_array as $column_name){
                  $column[] = $column_name;
            }
        }
        return $column;
    }
   /**
     * select items from database with indexes
     * @param type $indexed_id
    * 
    */
     
    public function find_by_index($indexed_id){
          return $this->db->get_where($this::$table_name, array(
                  $this::$table_index => $indexed_id,));
        }  
        /**
         * @param type $where
         * @return type object
         */

    public function find_where($where, $limit=null, $offset=null){
        $this->db->select();
        $this->db->from($this::$table_name);
        $this->db->where($where);
        if($limit !=null){
            $this->db->order_by($this::$order_by, 'ASC');
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query;
        }  
        
    
    /**
     * Delete
     */
    public function delete($id){
        if(!$id){
            return FALSE;
        }
        if($this::$table_pk){
            $this->db->where($this::$table_pk, $id);
        }else{
            $this->db->where($id);
        }
        $this->db->limit(1);
        $this->db->delete($this::$table_name);
        //return $query->affected_rows(TRUE);
        
    }
    
    /**
     * for hashing a password data
     * @param type $password
     * @return type hashed password
     */
    public function hash($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * for hashing a code sent to email
     * @param type time stamp
     * @return type hashed password
     */
    public function verification_hash($code){
        return hash('sha512', $code . config_item('encryption_key'));
    }
    
    
    /**
     * Create record.
     */
    public function insert($data) {
        $this->db->insert($this::$table_name, $data);
        $this->{$this::$table_pk} = $this->db->insert_id();
    }
    
    /**
     * Update record.
     * @param associative array $data input post
     * @param associative array $id primary key and or other keys
     */
    public function update($data, $id) {
        if($this::$table_pk !=NULL){
            $this->db->where($this::$table_pk, $id);
        }else{
            $this->db->where($id);
        }
        $this->db->update($this::$table_name, $data);
    }
    
    /**
     * if an item is not provided it selects the table primary key and returns number of rows
     * else it returns the item selected
     * @param array $where_id the primary key of the table
     * @param list $item if table is a child
     * @return tyep integer
     */
    public function data_count($where_id=null, $item=null){
        if($item!=null){
            $this->db->select($item);
        }else{
            $this->db->select($this::$table_pk);
        }
        $this->db->from($this::$table_name);
        if($where_id!=null){
            $this->db->where($where_id);
        }
        $query = $this->db->get();
        if($item==null){
        return $query->num_rows();
        }else{
            return $query;
        }
    }
    
    /**
     * Get the primary keys for inserting and updating data in question table
     */
    protected function question_where(){
        return $array = array('exam_id'=>trim($this->input->post('exam_id')), 
            'category_id'=>trim($this->input->post('category_id')),
            'body_id'=>trim($this->input->post('body_id')),
            'subject_id'=>trim($this->input->post('subject_id')),
            'period_id'=>trim($this->input->post('period_id')),
            'question_number'=>trim($this->input->post('question_number')),
            );
    }
    
    /**
     * Displaying Questions Data
     * @param int $body_id
     * @param string $exam_id
     * @param string $subject_id
     * @param string $period_id
     * @param string $cat_id
     * @param string $qnum
     * @return object
     */
    public function read($body_id, $exam_id, $subject_id, $period_id, $cat_id, $qnum, $item){
        $where = array('body_id'=>$body_id, 'exam_id'=>$exam_id, 'subject_id'=>$subject_id, 'period_id'=>$period_id, 
                        'category_id'=>$cat_id, 'question_number'=>$qnum);
        return $this->data_count($where, $item)->row();
    }
    
    public function encode($id) {
      $id_str = (string) $id;
      $offset = rand(0, 9);
      $encoded = chr(79 + $offset);
      for ($i = 0, $len = strlen($id_str); $i < $len; ++$i) {
        $encoded .= chr(65 + $id_str[$i] + $offset);
      }
      return $encoded;
    }

    
     public function decode($encoded) {
        $offset = ord($encoded[0]) - 79;
        $value = substr($encoded, 1);
        for ($i = 0, $len = strlen($value); $i < $len; ++$i) {
          $value[$i] = ord($value[$i]) - $offset - 65;
        }
        return (int) $value;
    }
}

