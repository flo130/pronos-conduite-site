<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Meeting_bet_model extends CI_Model
{
    private $t_bet = 'bet';
	private $t_meeting = 'meeting';


	public function get($where = null) 
	{
		$fields_list = array(
			$this->t_bet.'.id AS b_id',
			$this->t_bet.'.user AS b_user',
			$this->t_bet.'.meeting AS b_meeting',
			$this->t_bet.'.score_one AS b_score_one',
			$this->t_bet.'.score_two AS b_score_two',
			$this->t_bet.'.date AS b_date',
			
			$this->t_meeting.'.id AS m_id',
			$this->t_meeting.'.team_one AS m_team_one',
			$this->t_meeting.'.team_two AS m_team_two',
			$this->t_meeting.'.score_one AS m_score_one',
			$this->t_meeting.'.score_two AS m_score_two',
			$this->t_meeting.'.date AS m_date',
			$this->t_meeting.'.med_id AS m_med_id',
		);
		$fields_list = implode($fields_list, ', ');
		$this->db->select($fields_list);
		
		$this->db->from($this->t_meeting);
		
		$this->db->join(
			$this->t_bet, 
			$this->t_meeting . '.id = ' . $this->t_bet . '.meeting'
		);
		
		if ($where) $this->db->where($where);
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	public function get_table_bet_name() 
	{
		return $this->t_bet;
	}
	
	
	public function get_table_meeting_name() 
	{
		return $this->t_meeting;
	}
}