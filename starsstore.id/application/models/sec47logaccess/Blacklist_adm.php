<?php
class Blacklist_adm extends CI_model{ 

	function get_list_blacklist(){
		$this->db->select('*');
		$this->db->from('blacklist');
		$this->db->order_by('date_time desc');
		$r = $this->db->get();
		return $r->result();
	}

	function update_baca(){
		$data_baca = array(
			'baca' => 'sudah',
		);
		$this->db->update('blacklist', $data_baca);
	}
}
?>