<?php
class Produk_dilihat_adm extends CI_Model{ 
 
	function get_list_product(){ 
		$this->db->select('a.id_produk_view, COUNT(a.id_produk_view) AS total, b.nama_produk, b.gambar, b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_view','left');
		$this->db->where('status','on');
		$this->db->order_by('total desc');
		$this->db->group_by('a.id_produk_view');
		$q = $this->db->get();
		return $q->result(); 
	}
 
	function detail($b){
		//$ignore = array('ErNondyj3723815##629)&5+02');
		$this->db->select('a.*,b.id_produk,b.nama_produk,b.artikel,b.gambar');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		//$this->db->where('c.status','ScUuses8625(62427^#&9531(73');
		$this->db->where('a.id_produk_view', $b);
		$this->db->order_by('a.tanggal asc');
		//$this->db->group_by('a.no_order_cus');
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

	function get_counter_slide_perday(){ // total per day
		$this->db->select('COUNT(a.id_produk_view) as total,b.nama_produk,b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		$this->db->where('tanggal > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$this->db->group_by('a.id_produk_view');
		$this->db->order_by('total desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_slide_perweek(){ // total per day
		$this->db->select('COUNT(a.id_produk_view) as total,b.nama_produk,b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		$this->db->where('tanggal > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
		$this->db->group_by('a.id_produk_view');
		$this->db->order_by('total desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_slide_permonth(){ // total per day
		$this->db->select('COUNT(a.id_produk_view) as total,b.nama_produk,b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		$this->db->where('tanggal > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->group_by('a.id_produk_view');
		$this->db->order_by('total desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_slide_peryear(){ // total per day
		$this->db->select('COUNT(a.id_produk_view) as total,b.nama_produk,b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		$this->db->where('tanggal > DATE_SUB(NOW(), INTERVAL 1 YEAR)');
		$this->db->group_by('a.id_produk_view');
		$this->db->order_by('total desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_counter_slide_anak(){
		$this->db->select('COUNT(a.id_produk_view) as total,b.nama_produk,b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		$this->db->where('tanggal > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->where('b.kategori',37); // 37 anak, 26 pria, 34 wanita
		$this->db->group_by('a.id_produk_view');
		$this->db->order_by('total desc');
		$query=$this->db->get();
		return $query->result();	
	}

	function get_counter_slide_pria(){
		$this->db->select('COUNT(a.id_produk_view) as total,b.nama_produk,b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		$this->db->where('tanggal > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->where('b.kategori',26); // 37 anak, 26 pria, 34 wanita
		$this->db->group_by('a.id_produk_view');
		$this->db->order_by('total desc');
		$query=$this->db->get();
		return $query->result();	
	}

	function get_counter_slide_wanita(){
		$this->db->select('COUNT(a.id_produk_view) as total,b.nama_produk,b.artikel');
		$this->db->from('produk_viewed a');
		$this->db->join('produk b','b.id_produk=a.id_produk_view','left');
		$this->db->where('tanggal > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		$this->db->where('b.kategori',34); // 37 anak, 26 pria, 34 wanita
		$this->db->group_by('a.id_produk_view');
		$this->db->order_by('total desc');
		$query=$this->db->get();
		return $query->result();	
	}
}
?>