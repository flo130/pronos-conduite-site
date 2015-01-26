<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Litige_model extends CI_Model
{
    protected $t_litige = 'litige';

	
	public function create($litige) 
	{
		return $this->db->insert($this->t_litige, $litige); 
	}
	
	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->where($where);
		} 
		$query = $this->db->get($this->t_litige);
		return $query->result_array();
	}
	
	
	public function update($where, $values)
	{
		$this->db->where($where);
		$result = $this->db->update($this->t_litige, $values); 
		return $result;
	}
	
	public function delete($where=null) 
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->delete($this->t_litige); 
	}
}