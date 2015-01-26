<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Notification_model extends CI_Model
{
    protected $t_notification = 'notification';


    /**
     * Insert / create a notification
     */
    public function create($notification) 
    {
        return $this->db->insert($this->t_notification, $notification); 
    }


    /**
     * Get the notifications
     */
    public function get($where=null, $oder_by_date='', $limit_start=null, $limit_stop=null) 
    {
        //add a where clause if needed
        if ($where != null) 
            $this->db
                 ->where($where);

        //add a limit if needed
        if (($limit_start !== null) && ($limit_stop !== null)) 
            $this->db
                 ->limit($limit_stop, $limit_start);

        //add an order by if needed
        if ($oder_by_date != '')
            $this->db
                 ->order_by('CAST(date as DECIMAL)', $oder_by_date);

        //get the result from notification table
        $query = $this->db
                      ->from($this->t_notification)
                      ->get();

        //return an array of results
        $results = $query->result_array();
        //debug: print the query string
        //echo $this->db->last_query();
        return $results;
    }
    
    
    /**
     * Update a notification
     */
    public function update($where, $values)
    {
        $this->db->where($where);
        $result = $this->db->update($this->t_notification, $values); 
        return $result;
    }


    /**
     * Delete a notification
     */
    public function delete($where=null) 
    {
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->delete($this->t_notification); 
    }
}
