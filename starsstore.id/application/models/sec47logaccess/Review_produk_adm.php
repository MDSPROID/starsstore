<?php
class Review_produk_adm extends CI_Model{ 
	
	var $table = 'produk_review';
 
	function get_list_review(){ 
		$this->db->select('a.id_review, a.id_produk, a.id_cs,a.nama_review, a.review, a.rating, a.tgl_review, a.status AS status_review, b.*, c.*');
		$this->db->from('produk_review a');
		$this->db->join('customer b', 'b.id=a.id_cs','left');
		$this->db->join('produk c', 'c.id_produk=a.id_produk','left');
		$this->db->order_by('a.id_produk desc');
		$this->db->group_by('c.id_produk');
		$q = $this->db->get();
		return $q->result();
	} 
 
	function get_list_qna(){ 
		$this->db->select('*');
		$this->db->from('produk_q_n_a a');
		$this->db->join('produk c', 'c.id_produk=a.id_produk','left');
		$this->db->order_by('a.id_produk desc');
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_all($idx){
		$this->db->select('*');
		$this->db->from('produk_review');
		$this->db->where('id_review', $idx);
		$q = $this->db->get();
		return $q->row_array();
	}

	function get_data_qna($idx){
		$this->db->select('*');
		$this->db->from('produk_q_n_a');
		$this->db->where('id_q_n_a', $idx);
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

	function get_produk(){
		$this->db->select('id_produk, nama_produk, artikel');
		$this->db->from('produk');
		$this->db->where('status','on');
		$r = $this->db->get();
		return $r->result_array();
	}

	function off($idx){
		$off_data = array(
			'status' => '',
			);
		$this->db->where('id_review', $idx);
		$off = $this->db->update($this->table, $off_data);
	}

	function on($idx){
		$on_data = array(
			'status' => 'on',
			);
		$this->db->where('id_review', $idx);
		$off = $this->db->update($this->table, $on_data);
	}

	function setujui($idx){
		$off_data = array(
			'status' => 'on',
			);
		$this->db->where('id_review', $idx);
		$off = $this->db->update($this->table, $off_data);
	}

	function add($id_user, $data){

		$data_produk = array(
			'id_produk' 	=> $data['produk'],
			'nama_review' 	=> $data['nama_review'],
			'review'	  	=> $data['review'],
			'rating'		=> $data['rt'],
			'tgl_review'	=> date('Y-m-d H:i:s'),
			'status'		=> 'on',//$data['status'],
		);
		$this->db->insert('produk_review', $data_produk);		
	}	

	function balas($data, $idh){
		$data_produk = array(
			'nama_balas'	=> "Admin Stars",
			'balasan'		=> $data['balasan'],
			'tgl_balas'		=> date('Y-m-d H:i:s'),
		);
		$this->db->where('id_q_n_a', $idh);
		$this->db->update('produk_q_n_a', $data_produk);		
	}

	function update_review($idx,$data){

		$data_produk = array(
			'id_produk' 	=> $data['produk'],
			'nama_review' 	=> $data['nama_review'],
			'review'	  	=> $data['review'],
			'rating'		=> $data['rt'],
			'tgl_diubah'	=> date('Y-m-d H:i:s'),
			'status'		=> $data['status'],
		);
		$this->db->where('id_review',$idx);
		$this->db->update('produk_review', $data_produk);		
	}	

	function update_qna($idx,$data){
		$data_qna = array(
			'nama' 			=> $data['nama_qna'],
			'pertanyaan'	=> $data['pertanyaan'],
			'nama_balas'	=> $data['admin'],
			'balasan'		=> $data['balasan'],
		);
		$this->db->where('id_q_n_a',$idx);
		$this->db->update('produk_q_n_a', $data_qna);		
	}

	function hapus_qna($idx){
		$this->db->where('id_q_n_a', $idx);
		$this->db->delete('produk_q_n_a');
	}

	function hapus_review($idx){
		$this->db->where('id_review', $idx);
		$this->db->delete('produk_review');
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