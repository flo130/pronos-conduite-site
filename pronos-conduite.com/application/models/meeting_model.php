<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Meeting_model extends CI_Model
{
    protected $t_meeting = 'meeting';

	public function get_next_match() 
	{
		$where = array(
			'score_one' => null,
			'score_two' => null,
		);
		
		$query = $this->db->from($this->t_meeting)->where($where)->order_by('date', 'ASC')->get();
		$result = $query->result_array();
		
		if (isset($result[0])) {
			return $result[0];
		} else {
			return false;
		}
	}
	
	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->get_where($this->t_meeting, $where);
		} else {
			$query = $this->db->order_by('date', 'ASC')->get($this->t_meeting);
		}
		return $query->result_array();
	}
	
	
	public function update($where_clause, $values_clause)
	{
		$this->db->where($where_clause);
		$result = $this->db->update($this->t_meeting, $values_clause); 
		return $result;		
	}
	
	public function count($where = null) 
	{
		if ($where) $this->db->where($where);
		$this->db->from($this->t_meeting);
		return $this->db->count_all_results();
	}
}
