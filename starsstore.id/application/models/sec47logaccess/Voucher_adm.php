<?php
class Voucher_adm extends CI_Model{ 
	
	var $table = 'voucher_and_coupon';
 
	function get_list_voucher(){ 
		$this->db->select('*');
		$this->db->from('voucher_and_coupon');
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_all($idx){ 
		$this->db->select('*'); 
		$this->db->from($this->table);
		$this->db->where('id', $idx);
		$q = $this->db->get(); 
		return $q->row_array();
	}

	function get_list_produk_for_preview($id){ 
		$this->db->select('produk.nama_produk,produk.slug,produk.artikel,produk.keterangan,produk.tags,produk.status,produk.harga_retail,produk.harga_odv,produk.diskon,produk.stok,produk.berat,produk.point,produk.status,produk.parent,produk.tgl_dibuat,produk.tgl_diubah,rt.nama_depan as user1,ty.nama_depan as user2,merk.merk,kat.kategori as kategori, parent_kategori.id_parent, parent_kategori.parent_kategori AS parentnya_produk'); //produk_jenis.jenis as jenis_barang,produk_milik.milik as barang_milik
		$this->db->from('produk');
		//$this->db->join('produk_milik', 'produk.milik=produk_milik.id_milik','left');
		//$this->db->join('produk_jenis', 'produk.jenis=produk_jenis.id_jenis','left');
		$this->db->join('merk', 'produk.merk=merk.merk_id','left');
		$this->db->join('kategori kat', 'produk.kategori=kat.kat_id','left');
		$this->db->join('parent_kategori', 'parent_kategori.id_parent=produk.parent','left');
		$this->db->join('user rt', 'produk.dibuat=rt.id','left');
		$this->db->join('user ty', 'produk.diubah=ty.id','left');
		$this->db->where('produk.id_produk',$id);
		$q = $this->db->get();
		return $q->row();
	}

	function cek_exp(){
		$this->db->select('id, valid_until');
		$this->db->from($this->table);
		$this->db->where('aktif','on');
		$r = $this->db->get();
		return $r->result();
	}

	function ganti_status_exp($id){
		$data = array(
			'aktif'	=> 'expired',
		);
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}

	function get_produk(){
		$this->db->select('id_produk, nama_produk, artikel');
		$this->db->from('produk');
		$this->db->where('status','on');
		$r = $this->db->get();
		return $r->result_array();
	}

	function off($idx){
		$off_data = array(
			'aktif' => '',
			);
		$this->db->where('id', $idx);
		$off = $this->db->update($this->table, $off_data);
	}

	function on($idx){
		$on_data = array(
			'aktif' => 'on',
			);
		$this->db->where('id', $idx);
		$off = $this->db->update($this->table, $on_data);
	}

	function add($id_user, $data){
		if(preg_match('/,/', $data['action'])){

			$type = "discplus_apply"; // DISKON BERUNTUN

		}else if($data['action'] == ""){

			$type = "ongkir_apply"; // FREE ONGKIR

		}if($data['action_minim'] != ""){

			$type = "totalbelanja_apply"; //DISKON DENGAN MINIM PEMBELANJAAN

		}else if(!preg_match('/,/', $data['action']) && !empty($data['action']) && empty($data['action_minim'])){
			$type = "disc_apply"; // DISKON ALL ITEM TANPA MINIM PEMBELANJAAN
		}
		$data_voucher = array(
			'banner' 				=> $data['gambar'],
			'voucher_and_coupons' 	=> $data['nama_voucher'],
			'action'	  			=> $data['action'],
			'action_minim_pembelanjaan'	=> $data['action_minim'],
			'keterangan'			=> $data['keterangan'],
			'type'					=> $type,
			'qty'					=> $data['stok'],
			'valid_until'			=> $data['masa_berlaku'],
			'aktif'					=> 'on',
		);
		$this->db->insert('voucher_and_coupon', $data_voucher);		
	}	

	function hapus_voucher($idx){
		$this->db->where('id', $idx);
		$this->db->delete($this->table);
	}
	function update_voucher($id_voucher,$data){

		if(preg_match('/,/', $data['action'])){

			$type = "discplus_apply"; // DISKON BERUNTUN

		}else if($data['action'] == ""){

			$type = "ongkir_apply"; // FREE ONGKIR

		}if($data['action_minim'] != ""){

			$type = "totalbelanja_apply"; //DISKON DENGAN MINIM PEMBELANJAAN

		}else if(!preg_match('/,/', $data['action']) && !empty($data['action']) && empty($data['action_minim'])){
			$type = "disc_apply"; // DISKON ALL ITEM TANPA MINIM PEMBELANJAAN
		}

		$now = date('y-m-d H:i:s');
		if($data['masa_berlaku'] > $now){
			$stat = "on";
		}else{
			$stat = "expired";
		}

		$data_voucher = array(
			'banner' 				=> $data['gambar'],
			'voucher_and_coupons' 	=> $data['nama_voucher'],
			'action'	  			=> $data['action'],
			'action_minim_pembelanjaan'	=> $data['action_minim'],
			'keterangan'			=> $data['keterangan'],
			'type'					=> $type,
			'qty'					=> $data['stok'],
			'valid_until'			=> $data['masa_berlaku'],
			'aktif'					=> $stat,
		);

		$this->db->where('id',$id_voucher);
		$this->db->update($this->table, $data_voucher);		
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