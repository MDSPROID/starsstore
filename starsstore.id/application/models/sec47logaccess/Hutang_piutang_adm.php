<?php
class Hutang_piutang_adm extends CI_model{ 

	function get_order_all(){ 
		$this->db->select('*');
		$this->db->from('order_product a');
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer c','c.no_order_cus=a.no_order_pro','left');
		$this->db->join('order_expedisi d','d.no_order_ex=c.no_order_cus','left');
		$this->db->join('order_with_voucher e','e.no_order_vou=c.no_order_cus','left');
		$this->db->order_by('c.id desc');
		$r = $this->db->get();
		return $r->result();
	}

	function get_order_all_yang_belum_diinput_tarifnya_doang(){
		$this->db->select('*');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b','b.no_order_cus=a.no_order_ex','left');
		$this->db->where('a.actual_tarif','');
		$this->db->order_by('b.id asc');
		$r = $this->db->get();
		return $r->result();
	}

	function get_data_for_notif($inv){
		$this->db->select('*');
		$this->db->from('order_customer');
		$this->db->where('no_order_cus', $inv);
		$r = $this->db->get();
		return $r->row_array();
	}

	function get_data_for_edit($inv){
		$this->db->select('*');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');
		$this->db->where('a.no_order_ex', $inv);
		$r = $this->db->get();
		return $r->row_array();
	}

	function get_data_for_range($tgl1, $tgl2, $status){
		$this->db->select('*');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');
		$this->db->where('b.tanggal_order BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');
		$this->db->where('b.status',$status);
		$r = $this->db->get();
		return $r->result();	
	}

	function add($id_user,$inv,$data){

		$data_ex = array(
			'ongkir_ditanggung' => $data['tanggung_ongkir'],
			'actual_tarif'		=> $data['tarif'],
			'dibayar_oleh'		=> $data['dibayar'],
			'tgl_input_actual'	=> $data['tgl'],
			'id_user_add'		=> $id_user,
		);
		//print_r($data_ex);	
		$this->db->where('no_order_ex',$inv);
		$this->db->update('order_expedisi', $data_ex);		
	}	

	function update($id_user,$inv, $data){
		$data_ex = array(
			'ongkir_ditanggung' => $data['tanggung_ongkir'],
			'actual_tarif'		=> $data['tarif'],
			'dibayar_oleh'		=> $data['dibayar'],
			'tgl_input_actual'	=> $data['tgl'],
			'id_user_add'		=> $id_user,
		);
		//print_r($data_ex);	
		$this->db->where('no_order_ex',$inv);
		$this->db->update('order_expedisi', $data_ex);		
	}

	function filter_laporan_branded($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '3');
		$r = $this->db->get();
		return $r->result();
	}

	function filter_laporan_own($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '1');
		$r = $this->db->get();
		return $r->result();
	}

	function filter_laporan_konsi($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '2');
		$r = $this->db->get();
		return $r->result();
	}

	function filter_laporan_dropship($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '4');
		$r = $this->db->get();
		return $r->result();
	}
}
?>