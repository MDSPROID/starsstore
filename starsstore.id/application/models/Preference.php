<?php

class Preference extends CI_model{

	var $table = 'setting';

	function front_end_header(){
		$this->db->where('id',1);
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->result();
	}

	function toko_libur_set(){
		$this->db->select('nama,konten,aktif');
		$this->db->where('id',7);
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->row_array();
	}

	function toko_company_profile(){
		$this->db->select('nama,konten,aktif');
		$this->db->where('id',10);
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->row_array();
	}

	function status_notifclosing(){
		$this->db->select('nama,aktif');
		$this->db->where('id',8);
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->row_array();
	}

	function front_end_header_kategori(){
		$this->db->select('*');
		$this->db->from('kategori');
		$this->db->where(array('aktif' => 'on'));
		$this->db->order_by('kategori asc');
		$q = $this->db->get();
		return $q->result();
	}

	function front_end_header_merk(){
		$this->db->select('*');
		$this->db->from('merk');
		$this->db->where(array('aktif' => 'on'));
		$this->db->order_by('merk_id asc');
		$q = $this->db->get();
		return $q->result();
	}

	function front_end_header_banner_nav(){
		$this->db->select('*');
		$this->db->from('banner');
		$this->db->where(array('posisi' => 'nav_promo'));
		$this->db->limit(1);
		$q = $this->db->get();
		return $q->result();
	}

	function front_end_header_banner_3_utama(){
		$this->db->select('*');
		$this->db->from('banner');
		$this->db->where(array('status_banner' => 'on'));
		$this->db->where('tgl_akhir >= NOW()');
		$q = $this->db->get();
		return $q->result();
	}

	function our_store(){
		$this->db->select('*');
		$this->db->from('kategori');
		$this->db->where(array('aktif' => 'on'));
		$this->db->order_by('kategori asc');
		$q = $this->db->get();
		return $q->result();
	}

	function front_end_header_parent_kategori($ikat){
		$this->db->select('*');
		$this->db->from('parent_kategori');
		$this->db->where('id_kategori', $ikat);
		$this->db->where(array('aktif' => 'on'));
		$this->db->order_by('parent_kategori asc');
		$q = $this->db->get();
		return $q->result();
	}

	function front_end_header_kategori_desktop(){
		$this->db->select('*');
		$this->db->where(array('aktif' => 'on'));
		$this->db->from('parent_kategori');
		$this->db->order_by('parent_kategori ASC');
		$this->db->limit(7);
		$q = $this->db->get();
		return $q->result();
	}

	function front_end_footer(){
		$this->db->where(array('id' => '1', 'aktif' => 'on'));
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->result();
	}

	function header(){
		$this->db->where(array('id' => '1', 'aktif' => 'on'));
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->result();
	}

	function footer(){
		$this->db->where(array('id' => '2','aktif' => 'on'));
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_log_user($id){
		$this->db->where('id', $id);
		$this->db->from('user');
		$q = $this->db->get();
		return $q->result();
	}

}

?>