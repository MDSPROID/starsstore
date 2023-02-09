<?php
class Stok_adm extends CI_Model{
	
	var $table = 'produk';

	function get_stok_all(){ // get critical stok
		$this->db->select('*');
		$this->db->from('produk_get_color a'); 
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->where("a.stok > 0"); 
		$this->db->where('b.status', 'on');
		$query=$this->db->get();
		return $query->result();
	}

	function get_data_stok_produk(){
		$this->db->select('*');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->join('produk_opsional_color c', 'c.id_opsi_color=a.id_opsi_get_color');
		$this->db->join('produk_opsional_size d', 'd.id_opsi_size=a.id_opsi_get_size');
		$this->db->where('b.status', 'on');
		//$this->db->where("a.stok BETWEEN 1 AND 30");
		$query=$this->db->get();
		return $query->result();
	}

	function insert_data_stok_taking(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_update_pro'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

        $art_filtering 	= $this->security->xss_clean($this->input->post('artikel'));
        $art = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$art_filtering);

        $size_filtering 	= $this->security->xss_clean($this->input->post('size'));
        $size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$size_filtering);

        $stok_data_filtering 	= $this->security->xss_clean($this->input->post('size_stok')); // STOK DARI DATABASE
        $stok_data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$stok_data_filtering);

        $stok_asli_filtering 	= $this->security->xss_clean($this->input->post('stok_taking')); // STOK HASIL STOK TAKING
        $stok_asli = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$stok_asli_filtering);

		$user = $this->data['id'];

		for($i=0;$i<count($id);$i++){
		$data = array(
			'tgl'					=> date('Y-m-d'),
			'id_produk_stok_taking'	=> $id[$i],
			'artikel'				=> $art[$i],
			'size'					=> $size[$i],
			'stok_data' 	 		=> $stok_data[$i],
			'stok_hasil_stok_taking'=> $stok_asli[$i],
			'tanggal_stok'			=> date('Y-m-d H:i:s'),
			'user'					=> $user,
			);
		//print_r($data);
		//$this->db->where_in('id_opsi_get_size', $size[$i]);
		//$this->db->where_in('id_produk_optional', $id[$i]);
		$this->db->insert('stok_taking', $data);
		}
	}

	function get_data_stok_produk_hasil_taking(){
		$this->db->select('a.tgl,SUM(a.stok_data) as stok_db, SUM(a.stok_hasil_stok_taking) as stok_fisik, a.tanggal_stok, a.user,b.nama_depan');
		$this->db->from('stok_taking a');
		$this->db->join('user b','b.id=a.user','left');
		$this->db->group_by('a.tgl');
		$this->db->order_by('a.tgl desc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_data_result_taking($id){
		$this->db->select('a.*,b.nama_depan');
		$this->db->from('stok_taking a');
		$this->db->join('user b','b.id=a.user','left');
		$this->db->where('a.tgl', $id);
		$query=$this->db->get();
		return $query->result();
	}

	function hapus_data_taking($id){
		$this->db->where('tgl', $id);
		$this->db->delete('stok_taking');
	}

	function get_stok_critical(){ // get critical stok
		$this->db->select('*');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->where('b.status', 'on');
		$this->db->where("a.stok BETWEEN 1 AND 10");
		$query=$this->db->get();
		return $query->result();
	}

	function get_stok_critical_graph(){ // get critical stok
		$this->db->select('COUNT(a.stok) as stok_total, b.nama_produk');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->where('b.status', 'on');
		$this->db->where("a.stok BETWEEN 1 AND 10");
		$this->db->group_by('b.id_produk');
		$query=$this->db->get();
		return $query->result();
	}

	function get_stok_critical_and_warning(){ // get critical stok
		$this->db->select('*');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->join('produk_opsional_color c', 'c.id_opsi_color=a.id_opsi_get_color');
		$this->db->join('produk_opsional_size d', 'd.id_opsi_size=a.id_opsi_get_size');
		$this->db->where('b.status', 'on');
		$this->db->where("a.stok BETWEEN 1 AND 30");
		$query=$this->db->get();
		return $query->result();
	}

	function get_stok_warning(){ // get warning stok
		$this->db->select('*');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->where('b.status', 'on');
		$this->db->where("a.stok BETWEEN 11 AND 30");
		$query=$this->db->get(); 
		return $query->result();
	}

	function get_stok_good(){ // get good stok
		$this->db->select('*');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->join('produk_opsional_color c', 'c.id_opsi_color=a.id_opsi_get_color');
		$this->db->join('produk_opsional_size d', 'd.id_opsi_size=a.id_opsi_get_size');
		$this->db->where('b.status', 'on');
		$this->db->where("a.stok > 30");
		$this->db->order_by('a.id_produk_optional DESC');
		$query=$this->db->get();
		return $query->result();
	}

	function get_data_harga_produk(){
		$this->db->select('*');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->join('produk_opsional_size c', 'c.id_opsi_size=a.id_opsi_get_size');
		$this->db->where('b.status', 'on');
		$this->db->order_by('b.id_produk DESC');
		$query=$this->db->get();
		return $query->result();
	}

	function update_stok(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_update_pro'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

        $data_filtering 	= $this->security->xss_clean($this->input->post('update_stok'));
        $stok = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        $size_filtering 	= $this->security->xss_clean($this->input->post('size_stok'));
        $size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$size_filtering);

		$user = $this->data['id'];

		for($i=0;$i<count($id);$i++){
		$data = array(
			'stok' 	 	=> $stok[$i],
			);
		//print_r($data);
		$this->db->where_in('id_opsi_get_size', $size[$i]);
		$this->db->where_in('id_produk_optional', $id[$i]);
		$this->db->update('produk_get_color', $data);
		}
//		return $this->db->affected_rows();
	}

	function update_harga(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_update_pro'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

        $size_filtering 	= $this->security->xss_clean($this->input->post('id_update_size'));
        $size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$size_filtering);

        $diskon_filtering 	= $this->security->xss_clean($this->input->post('diskon'));
        $diskon = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php", "",$diskon_filtering);

        $artikel_filtering 	= $this->security->xss_clean($this->input->post('artikel'));
        $artikel = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php", "",$artikel_filtering);

        $data_filtering 	= $this->security->xss_clean($this->input->post('update_harga_awal'));
        $harga_awal = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        $pricefix_filtering 	= $this->security->xss_clean($this->input->post('update_hargafix'));
        $harga_fix = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$pricefix_filtering);

		$user = $this->data['id'];

		for($i=0;$i<count($id);$i++){
			//if($diskon[$i] == "" || $diskon[$i] == 0){
				if($harga_awal[$i] == "" || $harga_awal[$i] == 0){
					$harga_awalx = "";
				}else{
					$harga_awalx = $harga_awal[$i];
				}

				$data = array(		
					//'artikel'			=> $artikel[$i],
					'harga_dicoret' 	=> $harga_awalx,
					'harga_fix'			=> $harga_fix[$i],
					//'diskon'			=> round(($harga_awal[$i] - $harga_fix[$i]) / $harga_awal[$i] * 100),
					//'diskon_rupiah' 	=> $harga_fix[$i],
				);
				
			//}else{
				//$data = array(		
					//'artikel'			=> $artikel[$i],
				//	'harga_dicoret' 	=> $harga_awal[$i],
				//	'harga_fix'			=> $harga_awal[$i] - (($diskon[$i]/100) * $harga_awal[$i]),
					//'diskon'			=> round(($harga_awal[$i] - $harga_fix[$i]) / $harga_awal[$i] * 100),
				//);
			//}
		//print_r($data);
		$this->db->where_in('id_opsi_get_size', $size[$i]);
		$this->db->where_in('id_produk_optional', $id[$i]);
		$this->db->update('produk_get_color', $data);
		}
//		return $this->db->affected_rows();
	}

	
}
?>