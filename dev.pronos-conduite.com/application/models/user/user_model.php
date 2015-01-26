<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model 
{
	protected $user_table = 'user';
	
	
    function __construct()
    {
        parent::__construct();
    }
    
    
    public function create($user) 
    {
		$this->db->insert($this->user_table, $user); 
    }
    
    
    public function get($where=array()) 
    {
    	$this->db->select();
    	if (count($where) > 0) {
	    	foreach ($where as $key => $value) {
	    		$this->db->where($key, $value); 
	    	}
    	}
    	$query = $this->db->get($this->user_table);
		$result = $query->result();
		return $result;
    }
    
    
    public function update() 
    {
    	
    }
    
    
    public function delete() 
    {
    	
    }
}