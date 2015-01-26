<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_connection_history_model extends CI_Model 
{
	protected $table = 'user_connection_history';
	
	
    function __construct()
    {
        parent::__construct();
    }
    
    
    public function create($id_user, $type) 
    {
    	$date = new DateTime();
		if ($type == 'login') {
    		$data['login'] = $date->format('Y-m-d H:i:s');
    		$data['logout'] = null;
    	} 
    	elseif ($type == 'logout') {
    		$data['logout'] = $date->format('Y-m-d H:i:s');
    		$data['login'] = null;
    	}
    	else {
    		$data['logout'] = null;
    		$data['login'] = null;
    	}
    	//@todo récupère la sessionpour connaitre le browser : po bo ! Faudrait faire autrement 
    	$session = $this->session->all_userdata();
    	$data['id_user'] = $id_user;
    	$data['ip'] = $this->input->ip_address();
    	$data['browser'] = !empty($session['user_agent'])?$session['user_agent']:null;
		$result = $this->db->insert($this->table, $data);
		return $result; 
    }
    
    
    public function save_user_login($id_user) 
    {
    	$this->create($id_user, 'login'); 
    }
    
    
    public function save_user_logout($id_user) 
    {
    	$this->create($id_user, 'logout');
    }
}