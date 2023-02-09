<?php
class Report_order_adm extends CI_model{ 
 
	function get_order_all(){
		// karena pada fungsi ini difilter sukses saja
		$ignore = array('batal'); //ErNondyj3723815##629)&5+02
		$this->db->select('a.no_order_pro,a.artikel, a.qty as total_terjual,a.harga_fix,b.nama_produk, b.artikel, b.gambar, d.*'); //c.artikel, c.odv as odvM, c.retail as retailM,
		$this->db->from('order_product a');
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer d', 'd.no_order_cus=a.no_order_pro','left');
		$this->db->where('d.status','ScUuses8625(62427^#&9531(73');
		$this->db->order_by('d.tanggal_order desc');
		$r = $this->db->get(); 
		return $r->result();
	}	

//	function get_divisi(){
//		$this->db->select('id_milik, milik as fmilik, aktif');
//		$this->db->from('produk_milik'); 
//		$this->db->where('aktif','on');
//		$query=$this->db->get();
//		return $query->result();
//	} 

//	function get_jenis(){
//		$this->db->select('*');
//		$this->db->from('produk_jenis');
//		$this->db->where('aktif','on');
//		$query=$this->db->get();
//		return $query->result();
//	} 

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

	function filter_laporan($tgl1, $tgl2, $status, $bayar){
		// fungsi filter
		//$ignore = array('ErNondyj3723815##629)&5+02');
		$this->db->select('a.no_order_pro,a.artikel, a.qty as total_terjual,a.harga_fix,b.nama_produk, b.artikel, b.gambar, d.*'); //c.artikel, c.odv as odvM, c.retail as retailM,
		$this->db->from('order_product a');
		$this->db->join('produk b','b.artikel=a.artikel','left');
		//$this->db->join('master_barang c', 'c.artikel=a.artikel','left');
		$this->db->join('order_customer d', 'd.no_order_cus=a.no_order_pro','left');
		$this->db->where('d.tanggal_order_finish >=', $tgl1);
		$this->db->where('d.tanggal_order_finish <=', $tgl2);
		//$this->db->where('d.tanggal_order_finish <=', $tgl2);
		if($status == "all"){

		}else{
			$this->db->where('d.status',$status);
		}
		if($bayar == "all"){

		}else{
			$this->db->where('d.dibayar', $bayar);
		}
		//$this->db->group_by('d.no_order_cus');
		$this->db->order_by('d.tanggal_order_finish asc');
		//$this->db->where('c.divisi', $divisi);
		//$this->db->where('c.jenis', $jenis);
		$r = $this->db->get();
		return $r->result();

	}

	function list_aplication(){
		$this->db->select('*');
		$this->db->from('data_spv');
		$r = $this->db->get();
		return $r->result();
	}
}
?>