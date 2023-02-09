<?php
class Log_m extends CI_Model{
	var $table = 'user';

	function valid_log($user,$pass){
		$this->db->where('username', $user);
		$this->db->where('password', $pass);
		$this->db->where('status', "aktif");
		$this->db->where('level', "adm_joss_log_true_21");
		$this->db->where('akses', 1);
		return $this->db->get('user');
	}

	function updateLastlogin($id){
		$data = array(
			'last_login' => date('Y-m-d H:i:s')
			);
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
}
?>