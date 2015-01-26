<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Match_med_model extends CI_Model
{
    protected $match_med_table = 'match_med';
    
    public function get_next_match()
    {
        $where = array( 
            'score_one IS NULL' => null,
            'score_two IS NULL' => null,
        );

        $this->db->from($this->match_med_table);
        $this->db->where($where);
        $query = $this->db->get();

        $results = $query->result_array()[0];
        return $results;
    }


    public function insert($match)
    {
        $where = array(
            'id_med' => $match['id_med'],
        );

        $query = $this->db->get_where(
            $this->match_med_table,
            $where);
        $result = $query->result_array();

        if(count($result) > 0) {
            $this->db->where($where);
            $query_status = $this->db->update(
                $this->match_med_table, 
                $match); 
        } else {
            $query_status = $this->db->insert(
                $this->match_med_table, $match
            );    
        }

        return $query_status;
    }


    public function get($where = null) 
    {
        if ($where != null) {
            $query = $this->db->get_where($this->match_med_table, $where);
        } else {
            $query = $this->db->get($this->match_med_table);
        }
        $results = $query->result_array();
        return $results;
    }
}
