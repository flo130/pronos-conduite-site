<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User_model extends CI_Model
{
    protected $t_user = 'user';

	
	public function create($user) 
	{
		return $this->db->insert($this->t_user, $user); 
	}
	
	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->get_where($this->t_user, $where);
		} else {
			$query = $this->db->get($this->t_user);
		}
		return $query->result_array();
	}
	
	
	public function update($where, $values)
	{
		$this->db->where($where);
		$result = $this->db->update($this->t_user, $values); 
		return $result;
	}
	
	
	public function delete($where=null) 
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->delete($this->t_user); 
	}		
	
	
	public function get_ranking() 
	{
		$query = $this->db->from($this->t_user)->order_by('CAST(point as DECIMAL)', 'DESC')->get();
		return $query->result_array();
	}
}
