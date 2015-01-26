<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Litige_results_model extends CI_Model
{
    protected $t_litige_results = 'litige_results';

	
	public function create($litige_result) 
	{
		return $this->db->insert($this->t_litige_results, $litige_result); 
	}
	
	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->get_where($this->t_litige_results, $where);
		} else {
			$query = $this->db->get($this->t_litige_results);
		}
		return $query->result_array();
	}
	
	
	public function update($where, $values)
	{
		$this->db->where($where);
		$result = $this->db->update($this->t_litige_results, $values); 
		return $result;
	}
	
	
	public function delete($where=null) 
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->delete($this->t_litige_results); 
	}
}