<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Comment_model extends CI_Model
{
    protected $t_comment = 'comments';

	
	public function create($comment) 
	{
		return $this->db->insert($this->t_comment, $comment); 
	}
	
	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->get_where($this->t_comment, $where);
		} else {
			$query = $this->db->get($this->t_comment);
		}
		return $query->result_array();
	}
	
	
	public function update($where, $values)
	{
		$this->db->where($where);
		$result = $this->db->update($this->t_comment, $values); 
		return $result;
	}
	
	
	public function delete($where=null) 
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->delete($this->t_comment); 
	}
}
