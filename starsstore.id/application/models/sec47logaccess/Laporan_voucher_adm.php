<?php
class Laporan_voucher_adm extends CI_model{ 
 
	function get_voucher(){
		$ignore = array('0000-00-00 00:00:00');
		$this->db->select('a.id AS id_voucher, a.id_customer, a.voucher AS vou, a.action_voucher, a.date_use_voucher , b.*');
		$this->db->from('order_with_voucher a');
		$this->db->join('order_customer b','b.no_order_cus=a.no_order_vou','left');
		//$this->db->join('customer c','c.id=a.id_customer','left');
		$this->db->where_not_in('a.date_use_voucher', $ignore);
		$q = $this->db->get();
		return $q->result();
	} 

	function filter_laporan($tgl1, $tgl2){
		$ignore = array('0000-00-00 00:00:00');
		$this->db->select('a.id AS id_voucher, a.id_customer, a.voucher AS vou, a.action_voucher, a.date_use_voucher , b.*, c.nama_lengkap');
		$this->db->from('order_with_voucher a');
		$this->db->join('order_customer b','b.no_order_cus=a.no_order_vou','left');
		$this->db->join('customer c','c.id=a.id_customer','left');
		$this->db->where('a.date_filter BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');
		$this->db->where_not_in('a.date_use_voucher', $ignore);
		$r = $this->db->get();
		return $r->result();
	}
}
?>