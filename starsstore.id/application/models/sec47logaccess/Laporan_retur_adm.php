<?php
class Laporan_retur_adm extends CI_model{ 
 
	function get_retur(){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		$this->db->join('solusi_retur d','d.id_solusi=a.solusi','left');
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_retur($b){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		$this->db->join('solusi_retur e','e.id_solusi=a.solusi','left');
		$this->db->where('a.id_retur_info', $b);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_produk_retur($b){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		$this->db->join('order_product d','d.no_order_pro=c.no_order_cus','left');
		$this->db->join('solusi_retur e','e.id_solusi=a.solusi','left');
		$this->db->where('a.id_retur_info', $b);
		$q = $this->db->get();
		return $q->result();
	}

	function filter_laporan($tgl1, $tgl2){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		$this->db->join('order_product d','d.no_order_pro=c.no_order_cus','left');
		$this->db->join('solusi_retur e','e.id_solusi=a.solusi','left');
		$this->db->where('a.date_filter BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');
		$this->db->group_by('a.id_retur_info');
		$r = $this->db->get();
		return $r->result();
	}
}
?>