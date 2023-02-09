<?php
class Alat_promosi_adm extends CI_Model{ 
	
	var $table = 'promo_slide_utama';
 
	function get_list_promo(){ 
		$this->db->select('*');
		$this->db->from('promo_slide_utama a');
		$this->db->join('parent_kategori b','b.id_parent=a.parent_kategori','left');
		$this->db->where('a.id_promo > 1');
		$this->db->order_by('a.id_promo desc');
		$q = $this->db->get();
		return $q->result();
	}

	function get_id_judul(){
		$this->db->select('*');
		$this->db->from('promo_slide_utama');
		$this->db->where('id_promo = 1');
		$q = $this->db->get();
		return $q->result();
	}
 
	function get_judul($b){
		$a = base64_decode($b);
		$id = $this->encrypt->decode($a);
		$this->db->from($this->table);
		$this->db->where('id_promo', $id);
		$t = $this->db->get();
		return $t->row();
	}

	function update_judul($where,$data){ 
    	$this->db->update($this->table, $data, $where);
    	return $this->db->affected_rows();
    } 

    function update_flag($where,$data){ 
    	$this->db->update('promo_home_flag', $data, $where);
    	return $this->db->affected_rows();
    } 

    function on_flag($where,$data){ 
    	$this->db->update('promo_home_flag', $data, $where);
    	return $this->db->affected_rows();
    } 

    function off_flag($where,$data){ 
    	$this->db->update('promo_home_flag', $data, $where);
    	return $this->db->affected_rows();
    } 

    function get_kriteria(){
    	$this->db->select('a.diskon, a.parent, b.id_parent, b.parent_kategori');
    	$this->db->from('produk a');
    	$this->db->join('parent_kategori b','b.id_parent=a.parent','left');
    	$this->db->where('a.diskon > 0');
    	$this->db->where('a.status','on');
    	$this->db->where('b.aktif','on');
//    	$this->db->group_by('b.parent_kategori');
    	$r = $this->db->get();
    	return $r->result();
    }

    function get_kriteria_rentang(){
    	$this->db->select("b.id_parent, b.parent_kategori, min(a.diskon) as diskon_min, max(a.diskon) as diskon_max");
		$this->db->from("produk a");
		$this->db->join("parent_kategori b", "b.id_parent=a.parent");
		$this->db->where('a.diskon > 0');
    	$this->db->where('a.status','on');
    	$this->db->where('b.aktif','on');
		$this->db->group_by("b.id_parent having count(1) > 1");
    	$r = $this->db->get();
    	return $r->result();
    }

    function get_kriteria_rentang_harga(){
    	$this->db->select("b.id_parent, b.parent_kategori, min(a.harga_net) as harga_min, max(a.harga_net) as harga_max");
		$this->db->from("produk a");
		$this->db->join("parent_kategori b", "b.id_parent=a.parent");	
    	$this->db->where('a.status','on');
    	$this->db->where('b.aktif','on');
		$this->db->group_by("b.id_parent having count(1) > 1");
    	$r = $this->db->get();
    	return $r->result();
    }

 // BUAT EDIT ///

    function get_list_promo_edit($id){ 
		$this->db->select('*');
		$this->db->from('promo_slide_utama a');
		//$this->db->join('parent_kategori b','b.id_parent=a.parent_kategori','left');
		//$this->db->where('a.id_promo > 1');
		$this->db->where('a.id_promo',$id);
		//$this->db->order_by('a.id_promo desc');
		$q = $this->db->get();
		return $q->row_array();
	}

    function get_kriteria_edit(){
    	$this->db->select('a.diskon, a.parent, b.id_parent, b.parent_kategori');
    	$this->db->from('produk a');
    	$this->db->join('parent_kategori b','b.id_parent=a.parent','left');
    	$this->db->where('a.diskon > 0');
    	$this->db->where('a.status','on');
    	$this->db->where('b.aktif','on');
//    	$this->db->group_by('b.parent_kategori');
    	$r = $this->db->get();
    	return $r->result_array();
    }

    function get_kriteria_rentang_edit(){
    	$this->db->select("b.id_parent, b.parent_kategori, min(a.diskon) as diskon_min, max(a.diskon) as diskon_max, a.parent");
		$this->db->from("produk a");
		$this->db->join("parent_kategori b", "b.id_parent=a.parent");
		$this->db->where('a.diskon > 0');
    	$this->db->where('a.status','on');
    	$this->db->where('b.aktif','on');
		$this->db->group_by("b.id_parent having count(1) > 1");
    	$r = $this->db->get();
    	return $r->result_array();
    }

    function get_kriteria_rentang_harga_edit(){
    	$this->db->select("b.id_parent, b.parent_kategori, min(a.harga_net) as harga_min, max(a.harga_net) as harga_max");
		$this->db->from("produk a");
		$this->db->join("parent_kategori b", "b.id_parent=a.parent");	
    	$this->db->where('a.status','on');
    	$this->db->where('b.aktif','on');
		$this->db->group_by("b.id_parent having count(1) > 1");
    	$r = $this->db->get();
    	return $r->result_array();
    }

	function cek_exp(){
		$this->db->select('id_promo, tgl_akhir');
		$this->db->from('promo_slide_utama');
		$this->db->where('id_promo > 1');
		$this->db->where('status','on');
		$r = $this->db->get();
		return $r->result();
	}

	function cek_exp_flag(){
		$this->db->select('*');
		$this->db->from('promo_home_flag');
		$r = $this->db->get();
		return $r->result();
	}

	function ganti_status_exp($id){
		$data = array(
			'status'	=> 'expired',
		);
		$this->db->where('id_promo', $id);
		$this->db->update('promo_slide_utama', $data);
	}

	function ganti_status_exp_flag($id){
		$data = array(
			'status'	=> 'off',
		);
		$this->db->where('id', $id);
		$this->db->update('promo_home_flag', $data);
	}

	function on($id){
		$data = array(
			'status'	=> 'on',
		);
		$this->db->where('id_promo',$id);
		$this->db->update('promo_slide_utama', $data);
	}

	function off($id){
		$data = array(
			'status'	=> '',
		);
		$this->db->where('id_promo',$id);
		$this->db->update('promo_slide_utama', $data);
	}

	function hapus_promo($id){
		$a = base64_decode($id);
		$ids = $this->encrypt->decode($a);
		$this->db->where('id_promo',$ids);
		$this->db->delete('promo_slide_utama');
	}

	function add_promo_banner($id_user, $data){

		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> '',
			'jenis_promo'	=> 'banneronly',
			'value1'	  	=> '',
			'value2'		=> '',
			'parent_kategori'=> '',
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> 'on',
			'user_pembuat'	=> $id_user,
			'dibuat'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('promo_slide_utama', $data_promo);		
	}	

	function add_promo1($id_user, $data){
		$promo = $data['jenis_promo1'];
		$pr = explode(',', $promo);
		$val1 = $pr[0];
		$category = $pr[1];
		// ganti nama jadi url friendly
		$d = strtolower($data['nama_promo']);
		$slug_fix = str_replace(" ", "-", $d);


		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> $slug_fix,
			'jenis_promo'	=> 'catalok1diskon',
			'value1'	  	=> $val1,
			'value2'		=> '',
			'parent_kategori'=> $category,
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> 'on',
			'user_pembuat'	=> $id_user,
			'dibuat'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('promo_slide_utama', $data_promo);		
	}	

	function add_promo2($id_user, $data){
		$promo = $data['jenis_promo2'];
		$pr = explode(',', $promo);
		$val1 = $pr[0];
		$val2 = $pr[1];
		$category = $pr[2];

		$d = strtolower($data['nama_promo']);
		$slug_fix = str_replace(" ", "-", $d);

		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> $slug_fix,
			'jenis_promo'	=> 'catalok2diskon',
			'value1'	  	=> $val1,
			'value2'		=> $val2,
			'parent_kategori'=> $category,
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> 'on',
			'user_pembuat'	=> $id_user,
			'dibuat'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('promo_slide_utama', $data_promo);		
	}

	function add_promo3($id_user, $data){
		$promo = $data['jenis_promo3'];
		$pr = explode(',', $promo);
		$val1 = $pr[0];
		$val2 = $pr[1];
		$category = $pr[2];

		$d = strtolower($data['nama_promo']);
		$slug_fix = str_replace(" ", "-", $d);

		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> $slug_fix,
			'jenis_promo'	=> 'catalok2harga',
			'value1'	  	=> $val1,
			'value2'		=> $val2,
			'parent_kategori'=> $category,
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> 'on',
			'user_pembuat'	=> $id_user,
			'dibuat'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('promo_slide_utama', $data_promo);		
	}

	function update_promo_banner($id_user, $data){
		$a = base64_decode($data['promoPad']);
		$id = $this->encrypt->decode($a);
		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> '',
			'jenis_promo'	=> 'banneronly',
			'value1'	  	=> '',
			'value2'		=> '',
			'parent_kategori'=> '',
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> $data['status'],
			'user_pengubah'	=> $id_user,
			'diubah'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->where('id_promo', $id);
		$this->db->update('promo_slide_utama', $data_promo);		
	}	

	function update_promo1($id_user, $data){
		$a = base64_decode($data['promoPad']);
		$id = $this->encrypt->decode($a);

		$promo = $data['jenis_promo1'];
		$pr = explode(',', $promo);
		$val1 = $pr[0];
		$category = $pr[1];

		$d = strtolower($data['nama_promo']);
		$slug_fix = str_replace(" ", "-", $d);

		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> $slug_fix,
			'jenis_promo'	=> 'catalok1diskon',
			'value1'	  	=> $val1,
			'value2'		=> '',
			'parent_kategori'=> $category,
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> $data['status'],
			'user_pembuat'	=> $id_user,
			'dibuat'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->where('id_promo', $id);
		$this->db->update('promo_slide_utama', $data_promo);		
	}	

	function get_setting_popup(){
		$this->db->where('id',12);
		$r = $this->db->get('setting');
		return $r->row_array();
	}

	function get_data_city(){
		$r = $this->db->get('kota_free_ongkir');
		return $r->result();	
	}

	function cek_id_city($id){
		$this->db->where('id_kota',$id);
		$t = $this->db->get('kota_free_ongkir');
		return $t->num_rows();
	}

	function save_city_freeongkir($data){
		$this->db->insert('kota_free_ongkir',$data);
	}

	function get_data_cityfreeongkir(){
		$t = $this->db->get('kota_free_ongkir');
		return $t->result();	
	}

	function save_setting_popup($data){
		$this->db->where('id', 12);
		$this->db->update('setting', $data);		
	}

	function update_promo2($id_user, $data){
		$a = base64_decode($data['promoPad']);
		$id = $this->encrypt->decode($a);

		$promo = $data['jenis_promo2'];
		$pr = explode(',', $promo);
		$val1 = $pr[0];
		$val2 = $pr[1];
		$category = $pr[2];

		$d = strtolower($data['nama_promo']);
		$slug_fix = str_replace(" ", "-", $d);

		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> $slug_fix,
			'jenis_promo'	=> 'catalok2diskon',
			'value1'	  	=> $val1,
			'value2'		=> $val2,
			'parent_kategori'=> $category,
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> $data['status'],
			'user_pembuat'	=> $id_user,
			'dibuat'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->where('id_promo', $id);
		$this->db->update('promo_slide_utama', $data_promo);		
	}

	function update_promo3($id_user, $data){
		$a = base64_decode($data['promoPad']);
		$id = $this->encrypt->decode($a);

		$promo = $data['jenis_promo3'];
		$pr = explode(',', $promo);
		$val1 = $pr[0];
		$val2 = $pr[1];
		$category = $pr[2];

		$d = strtolower($data['nama_promo']);
		$slug_fix = str_replace(" ", "-", $d);

		$data_promo = array(
			'judul'			=> $data['nama_promo'],
			'slug'			=> $slug_fix,
			'jenis_promo'	=> 'catalok2harga',
			'value1'	  	=> $val1,
			'value2'		=> $val2,
			'parent_kategori'=> $category,
			'banner'	  	=> $data['banner_promo'],
			'tgl_mulai'		=> $data['tgl_mulai'],
			'tgl_akhir'	  	=> $data['tgl_akhir'],
			'status' 		=> $data['status'],
			'user_pembuat'	=> $id_user,
			'dibuat'	  	=> date('Y-m-d H:i:s'),
		);
		$this->db->where('id_promo', $id);
		$this->db->update('promo_slide_utama', $data_promo);		
	}

	function home_flag(){
		$this->db->select('*');
		$this->db->from('promo_home_flag');
		$r = $this->db->get();
		return $r->row();
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