<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class log_activity extends CI_Model {
 
    public function save_log($param)
    {
        $sql        = $this->db->insert_string('log_activity',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
    function delete_old_log(){
  		$this->db->where("log_time < DATE_SUB(NOW(), INTERVAL 3 MONTH)");
  		$this->db->delete('log_activity');
    }
}