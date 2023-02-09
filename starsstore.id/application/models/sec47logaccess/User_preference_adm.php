<?php
class User_preference_adm extends CI_Model{
	
	var $table = 'user';

	function get_user(){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('id DESC');
		$r = $this->db->get();
		return $r->result();
	}

	function cek_user($userr){
		$this->db->select('username');
		$this->db->where('username', $userr);
		$this->db->from($this->table);
		return $this->db->get();
	}

	function cek_data($b){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$b);
		$r = $this->db->get();
		return $r->row_array();	
	}	

	function cek_permision($b){
		$this->db->select('*');
		$this->db->from('tipe_akses_user');
		$this->db->where('id_user_log_default',$b);
		return $this->db->get();
	}	

	function get_data($b){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$b);
		$r = $this->db->get();
		return $r->result();	
	}


	function add_permision_akses($id_user,$akses){
		for($i = 0; $i<count($akses); $i++){
			$data_akses = array(
				'id_user_log_default' 	=> $id_user,
				'permision'				=> $akses[$i],
				);			
		$this->db->insert('tipe_akses_user', $data_akses);
		}
	}

	function on($id){
		$data = array(
			'status'	=> 'AEngOn73#43',
		);
		$this->db->where('id',$id);
		$this->db->update($this->table, $data);
	}

	function off($id){
		$data = array(
			'status'	=> 'Non36en&5*93#*',
		);
		$this->db->where('id',$id);
		$this->db->update($this->table, $data);
	}

	function hapus($b){
		$this->db->where('id',$b);
		$this->db->delete($this->table);
		$this->db->delete('tipe_akses_user', array('id_user_log_default' => $b));
	}

	function insert_user($data){	
		$this->db->insert($this->table, $data);
		$akses = $_POST['akses'];
		$last_insert_id = $this->db->insert_id();
		for($i = 0; $i<count($akses); $i++){
			$data_akses = array(
				'id_user_log_default' 	=> $last_insert_id,
				'permision'				=> $akses[$i],
				);			
		$this->db->insert('tipe_akses_user', $data_akses);
		}
	}

	function update_user($idx, $data){
		$this->db->where('id', $idx);
		$this->db->update($this->table, $data);

		//hapus semua tipe akses dan ganti dengan yang baru
		$this->db->delete('tipe_akses_user', array('id_user_log_default' => $idx));
		$akses = $_POST['akses'];
		for($i = 0; $i<count($akses); $i++){
			$data_akses = array(
				'id_user_log_default' 	=> $idx,
				'permision'				=> $akses[$i],
				);			
		$this->db->insert('tipe_akses_user', $data_akses);
		}
	}

	function get_data_record($idx){
		$this->db->select('*');
		$this->db->from('log_activity a');
		$this->db->join('user b','b.id=a.log_user','left');
		$this->db->where('log_user',$idx);
		$this->db->order_by('log_time desc');
		$r = $this->db->get();
		return $r->result();	
	}

	function get_data_kinerja_user($ids_log){
		$this->db->select('*');
		$this->db->from('user_kinerja');
		$this->db->where('id_user_kinerja',$ids_log);
		$this->db->order_by('tanggal desc');
		$r = $this->db->get();
		return $r->result();	
	}
	
	function add_kinerja($data){
		$this->db->insert('user_kinerja', $data);
	}

	function get_data_edit_kinerja($b){
		$this->db->select('*');
		$this->db->from('user_kinerja');
		$this->db->where('id',$b);
		$r = $this->db->get();
		return $r->row_array();	
	}

	function get_data_attach_edit_kinerja($id,$tgl){
		$this->db->select('*');
		$this->db->from('user_kinerja_attach');
		$this->db->where('id_user_attach',$id);
		$this->db->where('tanggal_attach',$tgl);
		$r = $this->db->get();
		return $r->result();	
	}

	function update_kinerja($data,$b){
		$this->db->where('id', $b);
		$this->db->update('user_kinerja', $data);
	}

	function hapus_kinerja($id){
		$this->db->where('id', $id);
		$this->db->delete('user_kinerja');
	}

	function get_data_kinerja_tgl_now(){
		$this->db->select('a.*, b.id, b.nama_depan');
		$this->db->from('user_kinerja a');
		$this->db->join('user b','b.id=a.id_user_kinerja','left');
		$this->db->where('a.tanggal > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$r = $this->db->get();
		return $r->result();
	}

	function get_data_attach_kinerja_tgl_now(){
		$this->db->select('*');
		$this->db->from('user_kinerja_attach');
		$this->db->where('tanggal_attach > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$r = $this->db->get();
		return $r->result();	
	}

	function delete_kinerja_select($id){
		$this->db->delete('user_kinerja_attach', array('token' => $id));
	}

	function cek_post_kinerja($id){
		$this->db->select('id_user_kinerja,tanggal');
		$this->db->from('user_kinerja');
		$this->db->where('id', $id);
		$t = $this->db->get();
		return $t->result();
	}

	function cek_lampiran($id_user, $tgl){
		$this->db->select('file');
		$this->db->from('user_kinerja_attach');
		$this->db->where('id_user_attach', $id_user);
		$this->db->where('tanggal_attach', $tgl);
		$t = $this->db->get();
		return $t->result();	
	}

	function hapus_lampiran($id_user, $tgl){
		$this->db->where('id_user_attach', $id_user);
		$this->db->where('tanggal_attach', $tgl);
		$this->db->delete('user_kinerja_attach');
	}
}
?>