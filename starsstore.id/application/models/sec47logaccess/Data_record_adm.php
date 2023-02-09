<?php
class Data_record_adm extends CI_model{ 

	var $table = 'log_activity';

	function get_record(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('log_time DESC');
		$query=$this->db->get();
		return $query->result();
	}
}
?>