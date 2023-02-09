<?php
class Kontak_adm extends CI_Model{ 
	
	var $table = 'kontak';
 
	function get_list_kontak(){ 
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('date_create desc');
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_before_read($idx){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_kontak', $idx);
		$q = $this->db->get();
		return $q->result();
	}

	function ubah_status_baca($idx){
		$data = array(
			'baca' 	=> 'sudah',
		);
		$this->db->where('id_kontak',$idx);
		$this->db->update($this->table, $data);
	}

	function detail($idx){ 
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_kontak', $idx);
		$q = $this->db->get();
		return $q->row_array();
	}

	function total_point($idx){
		$this->db->select('SUM(c.point) AS total_point');
		$this->db->from('customer a');
		$this->db->join('order_customer b', 'b.id_customer=a.id','left');
		$this->db->join('order_product c', 'c.no_order_pro=b.no_order_cus','left');
		$this->db->where('a.id', $idx);
		$q = $this->db->get();
		return $q->result();
	}

	function tracking_point($idx){
		$this->db->select('a.*, b.*, c.no_order_pro, c.nama_produk, c.gambar, c.artikel, c.point, c.harga_fix,');
		$this->db->from('customer a');
		$this->db->join('order_customer b', 'b.id_customer=a.id','left');
		$this->db->join('order_product c', 'c.no_order_pro=b.no_order_cus','left');
		$this->db->where('a.id', $idx);
		$this->db->order_by('b.tanggal_waktu_order desc');
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_cs($idx){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $idx);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_before_delete($idx){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $idx);
		$q = $this->db->get();
		return $q->result();
	}

	function tracking($idx){
		$this->db->select('*');
		$this->db->from('tracking_customer');
		$this->db->where('id_user_track', $idx);
		$this->db->order_by('tanggal desc');
		$q = $this->db->get();
		return $q->result();
	}

	function get_list_produk_for_preview($id){ 
		$this->db->select('produk.nama_produk,produk.slug,produk.artikel,produk.keterangan,produk.tags,produk.status,produk.harga_retail,produk.harga_odv,produk.diskon,produk.stok,produk.berat,produk.point,produk.status,produk.parent,produk.tgl_dibuat,produk.tgl_diubah,rt.nama_depan as user1,ty.nama_depan as user2,merk.merk,kat.kategori as kategori, parent_kategori.id_parent, parent_kategori.parent_kategori AS parentnya_produk'); //produk_milik.milik as barang_milik
		$this->db->from('produk');
		//$this->db->join('produk_milik', 'produk.milik=produk_milik.id_milik','left');
//		$this->db->join('produk_jenis', 'produk.jenis=produk_jenis.id_jenis','left');
		$this->db->join('merk', 'produk.merk=merk.merk_id','left');
		$this->db->join('kategori kat', 'produk.kategori=kat.kat_id','left');
		$this->db->join('parent_kategori', 'parent_kategori.id_parent=produk.parent','left');
		$this->db->join('user rt', 'produk.dibuat=rt.id','left');
		$this->db->join('user ty', 'produk.diubah=ty.id','left');
		$this->db->where('produk.id_produk',$id);
		$q = $this->db->get();
		return $q->row();
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
			'status' => 'Nh3825(*hhb',
			);
		$this->db->where('id', $idx);
		$off = $this->db->update($this->table, $off_data);
	}

	function on($idx){
		$on_data = array(
			'status' => 'a@kti76f0',
			);
		$this->db->where('id', $idx);
		$off = $this->db->update($this->table, $on_data);
	}

	function add($id_user, $data, $encrypt_default_rand){

		$data_customer = array(
			'email' 		=> $data['email'],
			'password' 		=> $encrypt_default_rand,
			'nama_lengkap'	=> $data['nama'],
			'telp'			=> $data['telpon'],
			'gender'		=> $data['gender'],
			'gb_user'		=> $data['gambar'],
			'status'		=> 'Kj(*62&*^#)_',
			'level'			=> 'regcusok4*##@!9))921',
			'akses'			=> '9x4$58&(3*+',
			'created'		=> date('Y-m-d H:i:s'),
			'ip_register_first' => $this->input->ip_address(),
			'admin_edit'	=> $id_user,
		);
		$this->db->insert($this->table, $data_customer);		
	}	

	function update_cs_with_pass($id_user, $data, $encrypt_default_rand){
		$idf = base64_decode($data['cs']);
		$idr = $this->encrypt->decode($idf);
		$data_customer = array(
			'email' 		=> $data['email'],
			'password' 		=> $encrypt_default_rand,
			'nama_lengkap'	=> $data['nama'],
			'telp'			=> $data['telpon'],
			'gender'		=> $data['gender'],
			'gb_user'		=> $data['gambar'],
			'admin_edit'	=> $id_user,
		);
		$this->db->where('id',$idr);
		$this->db->update($this->table, $data_customer);		
	}	

	function update_cs($id_user, $data){
		$idf = base64_decode($data['cs']);
		$idr = $this->encrypt->decode($idf);
		$data_customer = array(
			'email' 		=> $data['email'],
			'nama_lengkap'	=> $data['nama'],
			'telp'			=> $data['telpon'],
			'gender'		=> $data['gender'],
			'gb_user'		=> $data['gambar'],
			'admin_edit'	=> $id_user,
		);
		$this->db->where('id',$idr);
		$this->db->update($this->table, $data_customer);		
	}	

	function hapus_customer($idx){
		$this->db->where('id', $idx); 
		$this->db->delete($this->table);
		$this->db->delete('wishlist', array('id_customer' => $idx));
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