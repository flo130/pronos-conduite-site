<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Bet_model extends CI_Model
{
    protected $t_bet = 'bet';

	
	public function create($bet) 
	{
		return $this->db->insert($this->t_bet, $bet); 
	}
	
	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->get_where($this->t_bet, $where);
		} else {
			$query = $this->db->get($this->t_bet);
		}
		return $query->result_array();
	}
	
	
	public function update($where, $values)
	{
		$this->db->where($where);
		$result = $this->db->update($this->t_bet, $values); 
		return $result;
	}
	
	
	public function delete($where=null) 
	{
		if ($where) $this->db->where($where);
		return $this->db->delete($this->t_bet); 
	}
	
	
	public function count($where = null) 
	{
		if ($where) $this->db->where($where);
		$this->db->from($this->t_bet);
		return $this->db->count_all_results();
	}
}
