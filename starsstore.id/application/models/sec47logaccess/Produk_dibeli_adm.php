<?php
class Produk_dibeli_adm extends CI_Model{ 
	
	var $table = 'order_product';
  
	function get_list_product(){ 
		//$ignore = array('ErNondyj3723815##629)&5+02');
		$this->db->select('SUM(a.qty) AS total, a.artikel,b.id_produk,b.nama_produk,b.artikel,b.gambar, c.no_order_cus, c.status');
		$this->db->from('order_product a');
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer c','c.no_order_cus=a.no_order_pro','left');
		$this->db->where('c.status','ScUuses8625(62427^#&9531(73');
		$this->db->order_by('total desc');
		$this->db->group_by('b.id_produk');
		$q = $this->db->get();
		return $q->result();  
	}

	function detail($b){
		//$ignore = array('ErNondyj3723815##629)&5+02');
		$this->db->select('a.no_order_pro,a.qty,SUM(a.qty) AS total, a.artikel,b.id_produk,b.nama_produk,b.artikel,b.gambar,c.*');
		$this->db->from('order_product a');
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer c','c.no_order_cus=a.no_order_pro','left');
		$this->db->where('c.status','ScUuses8625(62427^#&9531(73');
		$this->db->where('a.artikel', $b);
		$this->db->order_by('c.tanggal_waktu_order asc');
		$this->db->group_by('c.no_order_cus');
		$q = $this->db->get();
		return $q->result();
	}

	function remove_dipilih($cek) { //untuk menghapus yang dipilih di menu pilihan hapus
		$cek = array();
		foreach($cek as $cek_id){
			$query = $this->db->get_where('produk_image',array('id_produk'=>$cek_id));
			$data = $query->result_array();
    		foreach ($data as $resultnya) 
    		{
	        	unlink('assets/img/produk/'.$resultnya['gambar']);
    		}
		}
		$action = $this->input->post('action');
		if ($action == "delete") {
			$delete = $cek;

			print_r($delete);
			//for ($i=0; $i < count($delete) ; $i++) { 
				
			//	$query = $this->db->get_where('produk_image',array('id_produk'=>$delete[$i]));
			//	$data = $query->result_array();
    		//	foreach ($data as $resultnya) 
    		//	{
	        //		unlink('assets/img/produk/'.$resultnya['gambar']);
    		//	}
				//$this->db->delete('produk', array('id_produk' => $delete[$i]));
				//$this->db->delete('produk_image', array('id_produk' => $delete[$i]));
		}elseif($action == "all"){
			//$this->db->delete('produk');
			//$this->db->delete('produk_image');
		}
	}
}
?>