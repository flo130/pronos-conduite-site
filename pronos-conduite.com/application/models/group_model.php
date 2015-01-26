<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Group_model extends CI_Model
{
    protected $t_user_group = 'user_group';

	
	public function get($where = null) 
	{
		if ($where != null) {
			$query = $this->db->get_where($this->t_user_group, $where);
		} else {
			$query = $this->db->get($this->t_user_group);
		}
		return $query->result_array();
	}
}
