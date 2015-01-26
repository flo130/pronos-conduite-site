<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Ride_model extends CI_Model
{
    protected $t_ride = 'ride';

	
	public function create($ride) 
	{
		return $this->db->insert($this->t_ride, $ride); 
	}
	
	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->get_where($this->t_ride, $where);
		} else {
			$query = $this->db->get($this->t_ride);
		}
		return $query->result_array();
	}
	
	
	public function update($where, $values)
	{
		$this->db->where($where);
		$result = $this->db->update($this->t_ride, $values); 
		return $result;			
	}
	
	
	public function delete($where=null) 
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->delete($this->t_ride); 
	}	
}
