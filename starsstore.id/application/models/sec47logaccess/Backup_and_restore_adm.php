<?php
class Backup_and_restore_adm extends CI_model{ 

	function get_order_all(){
		$this->db->select('*');
		$this->db->from('order_customer');
		$r = $this->db->get();
		return $r->result();
	}

	function truncate_data(){
		$this->db->truncate('master_barang');
	}

	function truncate_data_tb($tb){
		$this->db->truncate($tb);	
	}

	function truncate_brgcp(){
		$this->db->truncate('brgcp');
	}

	function master_barang_dan_brgcp(){
		$this->db->select('*');
		$this->db->from('master_barang a');
		$this->db->join('brgcp b','b.art_id=a.artikel','left');
		$r = $this->db->get();
		return $r->result();	
	}

	function data_master(){
		$this->db->select('*');
		$this->db->from('master_barang');
		$r = $this->db->get();
		return $r->result();		
	}

	function data_brgcp(){
		$this->db->select('*');
		$this->db->from('brgcp');
		$r = $this->db->get();
		return $r->result();		
	}

	function update_data($art67, $data){
		$this->db->where('artikel',$art67);
        $this->db->update('master_barang', $data);
	}
}
?> 