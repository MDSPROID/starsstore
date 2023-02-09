<?php
class Inout_adm extends CI_Model{ 
  
	function get_list(){ 
		$this->db->select('*');
		$this->db->from('inout');
		$this->db->order_by('tgl_dibuat desc');  
		$q = $this->db->get();
		return $q->result();
	}

	function get_list_inv($idinvoice){
		$this->db->select('*');
		$this->db->where('id_inout', $idinvoice);
		$get = $this->db->get('inout_inv');
		return $get->result();
	}

	function getstore(){
		$this->db->select('*');
		$this->db->from('toko a');
		$this->db->join('bdm b','b.id=a.id_bdm','left');
		$this->db->where('a.toko_aktif','on');
		$this->db->order_by('b.area desc');
		$r = $this->db->get();
		return $r->result();	
	}

	function count_toko_aktif(){
		$this->db->select('COUNT(a.id_toko) as jumlahtoko');
		$this->db->from('toko a');
		$this->db->join('bdm b','b.id=a.id_bdm','left');
		$this->db->where('a.toko_aktif','on');
		$r = $this->db->get();
		return $r->row_array();		
	}
 
	function cek_tanggal_selesai_order($id_inv){
		$this->db->select('tanggal_order_finish');
		$this->db->from('order_customer');
		$this->db->where('no_order_cus', $id_inv);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$this->db->select('*');
		$this->db->where('invoice', $idp);
		$get = $this->db->get('inout');
		return $get->row_array();
	}

	function get_data_inv($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);


		$this->db->select('*');
		$this->db->where('id_inout', $idp);
		$get = $this->db->get('inout_inv');
		return $get->result();
	}

	function add($id_user, $data){

		// Diskon percent
		if($data['jenis'] == "masuk"){
			$source = $data['dari'];
		}else{
			$source = $data['ke'];
		}

		$data_inout = array(
			'jenis'		  	=> $data['jenis'],
			//'market'	  	=> $data['ecommerce'],
			//'invoice_order' => $data['inv_pesanan'],
			'tanggal'		=> $data['tgl'],
//			'tanggal_selesai_pesanan'		=> $input_tgl_selesai,
			'invoice'		=> $data['inv'],
			'pasang'		=> $data['pasang'],
			'rupiah'		=> $data['rupiah'],
			'source'		=> $source,
			'keterangan'  	=> $data['ket'],
			'dibuat'	  	=> $id_user,
			'tgl_dibuat' 	=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('inout', $data_inout);
	}	

	function update($id,$id_user,$data){

		if($data['jenis'] == "masuk"){
			$source = $data['dari'];
		}else{
			$source = $data['ke'];
		}

		$data_inout = array(
			'jenis'		  	=> $data['jenis'],
			//'market'	  	=> $data['ecommerce'],
			//'invoice_order' => $data['inv_pesanan'],
			'tanggal'		=> $data['tgl'],
			'invoice'		=> $data['inv'],
			'pasang'		=> $data['pasang'],
			'rupiah'		=> $data['rupiah'],
			'source'		=> $source,
			'keterangan'  	=> $data['ket'],
			'dibuat'	  	=> $id_user,
			'tgl_dibuat' 	=> date('Y-m-d H:i:s'),
		);
		$this->db->where('id_inout',$id);
		$this->db->update('inout', $data_inout);

		// hapus dulu sebelumnya data inout_inv
		$this->db->delete('inout_inv',array('id_inout' => $id));

		// pecah nomor pesanan ke tabel inout_inv
		$invp = $data['inv_pesanan'];
		$pecahinv = explode(',', $invp);
		$invpx = count($pecahinv);
		//for($i=0;$i<$invpx;$i++){
		foreach($pecahinv as $gx){
			$datainout = array(
				'id_inout'  => $data['inv'],
				'inv'		=> $gx,
			);
			$this->db->insert('inout_inv', $datainout);
		}
	}

	function cek_inv_inout($id_pesanan){
		$this->db->select('inv');
		$this->db->from('inout_inv');
		$this->db->where('inv', $id_pesanan);
		return $this->db->get();
	}

	function cek_inv_inout_already($id_pesanan){
		$this->db->select('invoice');
		$this->db->from('inout');
		$this->db->where('invoice', $id_pesanan);
		return $this->db->get();
	}

	function get_data_before_delete($idx){
		$this->db->select('invoice');
		$this->db->from('inout');
		$this->db->where('id_inout', $idx);
		$r = $this->db->get();
		return $r->result();
	}

	function hapus($idx){
		$this->db->where('id_inout',$idx);
		$this->db->delete('inout');
	}

	function hapus_inout_inv($inv){
		$this->db->delete('inout_inv', array('id_inout' => $inv));
	}

	function insert_inv_inout($datainout){
		$this->db->insert('inout_inv', $datainout);
	}

	function insert_update_inv_inout($datainout){
		$this->db->insert('inout_inv', $datainout);
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

	function get_laporan_by_tgl($tgl1, $tgl2){
		$this->db->select('*');
		$this->db->from('inout');
		$this->db->where('tanggal >=', $tgl1);
		$this->db->where('tanggal <=', $tgl2);
		//$this->db->where('market', $market);
		$r = $this->db->get();
		return $r->result();
	}

	function doubleData($tanggal,$kode_edp,$artikel,$size,$qty){
		$where = array(
			'tanggal' 	=> $tanggal,
			'kode_edp' 	=> $kode_edp,
			'artikel' 	=> $artikel,
			'size' 		=> $size,
			'qty' 		=> $qty,
		);
		$this->db->select('*');
		$this->db->from('dmk');
		$this->db->where($where);
		return $this->db->get();
	}
}
?>