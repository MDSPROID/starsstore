<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori_dan_parent_kategori extends CI_Controller { 

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/kategori_adm');
		$this->data = array();
		$this->data['id'] = $this->session->userdata('id'); // user session
		$this->data['username'] = $this->session->userdata('username');
		$this->data['load_option_kat_for_index'] = $this->kategori_adm->get_categories(); //load kat to option
		$this->data['data_kategori'] = $this->kategori_adm->get_all_category(); // load all to table
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){

		$kat = array();
		foreach ($this->kategori_adm->master_cat() as $kat_for_model) 
		{
		$kat[$kat_for_model['kat_id']] = $kat_for_model['kategori'];
		}

		$update = $this->kategori_adm->get_all_category();
		
		$this->data['jabatan']=$kat;
		$this->data['updatedata'] = $update;
		$this->data['parent_kategori'] = $this->kategori_adm->get_all_parent(); // load all to table

			$this->load->view('manage/header');
			$this->load->view('manage/kategori/index', $this->data);
			$this->load->view('manage/footer');
		
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman kategori');
		
	}

	function kategori_dihapuskan(){ // hapus kategori yang dipilih
		$id = $this->input->get('id');
		$idx = base64_decode($id);
		$idf = $this->encrypt->decode($idx);
		$go = $this->kategori_adm->get_data_kategori($idf);
		foreach($go as $t){
			$gb = $t->gambar;
		}
		unlink($gb);
		$target = $this->input->get('name');
		$this->kategori_adm->kategori_telah_dihapus($idf);
		echo json_encode(array("status" => TRUE));
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') menghapus kategori '.$target.'');
	}

	function parent_kategori_dihapuskan(){ // hapus kategori yang dipilih
		$id = $this->input->get('id');
		$idx = base64_decode($id);
		$idf = $this->encrypt->decode($idx);
		$go = $this->kategori_adm->get_data_parent($idf);
		foreach($go as $t){
			$gb = $t->gambar;
		}
		unlink($gb);

		$target = $this->input->get('name');
		$this->kategori_adm->parent_kategori_telah_dihapus($idf);
		echo json_encode(array("status" => TRUE));
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') menghapus kategori '.$target.'');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown

		//$action = $this->input->post('action');
		//$cek = $this->input->post('checklist');
			///for($i=0; $i<count($cek); $i++){
				//$this->kategori_adm->hapus_dipilih();
			//}
			//log_helper("kategori", "Menghapus Kategori yang dipilih");
			//redirect('trueaccon2194/kategori');
	}

	function proses_tambah_kat(){ // tambah kategori
		$kat_filter = $this->security->xss_clean($this->input->post('kat'));
		$kat = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$kat_filter);
		$slug_filter = $this->security->xss_clean($this->input->post('slug'));
		$slug = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$slug_filter);
		$ket_filter = $this->security->xss_clean($this->input->post('keterangan'));
		$ket = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ket_filter);
		$kunci_filter = $this->security->xss_clean($this->input->post('kata_kunci'));
		$kata_kunci = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$kunci_filter);
		$gb_filter = $this->security->xss_clean($this->input->post('gambar'));
		$gb = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$gb_filter);

		$data = array(
      		'kategori'			=> $kat,
      		'keterangan'		=> $ket,
      		'kata_kunci'		=> $kata_kunci,
      		'gambar' 			=> $gb,
      		'slug'				=> $slug,
    		'aktif'				=> "on",
    		'user_pembuat'	 	=> $this->data['id'],
    		'dibuat_tgl' 		=> date('Y-m-d H:i:s'),
      		);

		$this->kategori_adm->add($data);
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Kategori '.$kat.' ditambah!');
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Kategori ('.$kat.')');
		redirect('trueaccon2194/kategori_dan_parent_kategori');
	}

	function edit_kategori($id){ // edit dan simpan kategori yang diedit
		$idx = base64_decode($id);
		$idf = $this->encrypt->decode($idx);

		$update = $this->kategori_adm->get_categorie($idf);

		if ($update['aktif'] == 'on'){
			$this->data['aktif1'] = 'checked';
		}
		else{
			$this->data['aktif1'] = '';
		}

		$this->data['updatedata'] = $update;

		$this->load->view('manage/header');
		$this->load->view('manage/kategori/edit',$this->data);
		$this->load->view('manage/footer');
	}

	function edit_parent_kategori($id){ // edit dan simpan kategori yang diedit
		$idx = base64_decode($id);
		$idf = $this->encrypt->decode($idx);

		$kat = array();
		foreach ($this->kategori_adm->master_cat() as $kat_for_model) 
		{
		$kat[$kat_for_model['kat_id']] = $kat_for_model['kategori'];
		}

		$update = $this->kategori_adm->get_data_parent_categorie($idf);

		if ($update['aktif'] == 'on'){
			$this->data['aktif1'] = 'checked';
		}
		else{
			$this->data['aktif1'] = '';
		}

		$this->data['master']=$kat;
		$this->data['get_master_kategori'] = $this->kategori_adm->master_cat();
		$this->data['updatedata'] = $update;

		$this->load->view('manage/header');
		$this->load->view('manage/kategori/edit_parent',$this->data);
		$this->load->view('manage/footer');
	}

	function update_kategori(){
		$id_kategori = $this->input->post('id_kategori');
		$idx = base64_decode($id_kategori);
		$idf = $this->encrypt->decode($idx);

		$kat_filter = $this->security->xss_clean($this->input->post('kat'));
		$kat = str_replace("/(<\/?)(p)([^>]*>)", "",$kat_filter);
		$slug_filter = $this->security->xss_clean($this->input->post('slug'));
		$slug = str_replace("/(<\/?)(p)([^>]*>)", "",$slug_filter);
		$ket_filter = $this->security->xss_clean($this->input->post('keterangan'));
		$ket = str_replace("/(<\/?)(p)([^>]*>)", "",$ket_filter);
		$kunci_filter = $this->security->xss_clean($this->input->post('kata_kunci'));
		$kata_kunci = str_replace("/(<\/?)(p)([^>]*>)", "",$kunci_filter);
		$gb_filter = $this->security->xss_clean($this->input->post('gambar'));
		$gb = str_replace("/(<\/?)(p)([^>]*>)", "",$gb_filter);
		$st_filter = $this->security->xss_clean($this->input->post('status'));
		$st = str_replace("/(<\/?)(p)([^>]*>)", "",$st_filter);

		$data = array(
      		'kategori'			=> $kat,
      		'keterangan'		=> $ket,
      		'kata_kunci'		=> $kata_kunci,
      		'gambar' 			=> $gb,
      		'slug'				=> $slug,
    		'aktif'				=> $st,
    		'user_pengubah' 	=> $this->data['id'],
    		'diubah_tgl' 		=> date('Y-m-d H:i:s'),
      		);

			$this->kategori_adm->update_kategorix($data, $idf);
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Kategori '.$kat.' telah diubah!');
			log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') edit kategori '.$kat.'');
			redirect('trueaccon2194/kategori_dan_parent_kategori');
	}

	function update_parent_kategori(){
		$idp = $this->input->post('id_parent');
		$idx = base64_decode($idp);
		$idf = $this->encrypt->decode($idx);

		$par_kat_filter = $this->security->xss_clean($this->input->post('parent_kategori'));
		$par_kat = str_replace("/(<\/?)(p)([^>]*>)", "",$par_kat_filter);
		$kat_filter = $this->security->xss_clean($this->input->post('kategori'));
		$kat = str_replace("/(<\/?)(p)([^>]*>)", "",$kat_filter);
		$slug_filter = $this->security->xss_clean($this->input->post('slug_parent'));
		$slug = str_replace("/(<\/?)(p)([^>]*>)", "",$slug_filter);
		$ket_filter = $this->security->xss_clean($this->input->post('keterangan'));
		$ket = str_replace("/(<\/?)(p)([^>]*>)", "",$ket_filter);
		$kunci_filter = $this->security->xss_clean($this->input->post('kata_kunci'));
		$kata_kunci = str_replace("/(<\/?)(p)([^>]*>)", "",$kunci_filter);
		$gb_filter = $this->security->xss_clean($this->input->post('gambar'));
		$gb = str_replace("/(<\/?)(p)([^>]*>)", "",$gb_filter);
		$st_filter = $this->security->xss_clean($this->input->post('status'));
		$st = str_replace("/(<\/?)(p)([^>]*>)", "",$st_filter);

		$data = array(
      		'id_kategori'		=> $kat,
      		'parent_kategori'	=> $par_kat,
      		'keterangan'		=> $ket,
      		'kata_kunci'		=> $kata_kunci,
      		'gambar' 			=> $gb,
      		'slug_parent'		=> $slug,
    		'aktif'				=> $st,
    		'user_pengubah' 	=> $this->data['id'],
    		'diubah_tgl' 		=> date('Y-m-d H:i:s'),
      		);

			$this->kategori_adm->update_parent_kategori($data, $idf);
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Kategori '.$par_kat.' telah diubah!');
			log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') edit kategori '.$par_kat.'');
			redirect('trueaccon2194/kategori_dan_parent_kategori');
	}

	function proses_tambah_parent_kat(){ // tambah kategori
		$par_kat_filter = $this->security->xss_clean($this->input->post('parent_kategori'));
		$par_kat = str_replace("/(<\/?)(p)([^>]*>)", "",$par_kat_filter);
		$kat_filter = $this->security->xss_clean($this->input->post('kategori'));
		$kat = str_replace("/(<\/?)(p)([^>]*>)", "",$kat_filter);
		$slug_filter = $this->security->xss_clean($this->input->post('slug'));
		$slug = str_replace("/(<\/?)(p)([^>]*>)", "",$slug_filter);
		$ket_filter = $this->security->xss_clean($this->input->post('keterangan'));
		$ket = str_replace("/(<\/?)(p)([^>]*>)", "",$ket_filter);
		$kunci_filter = $this->security->xss_clean($this->input->post('kata_kunci'));
		$kata_kunci = str_replace("/(<\/?)(p)([^>]*>)", "",$kunci_filter);
		$gb_filter = $this->security->xss_clean($this->input->post('gambar'));
		$gb = str_replace("/(<\/?)(p)([^>]*>)", "",$gb_filter);

		$data = array(
      		'id_kategori'		=> $kat,
      		'parent_kategori'	=> $par_kat,
      		'keterangan'		=> $ket,
      		'kata_kunci'		=> $kata_kunci,
      		'gambar' 			=> $gb,
      		'slug_parent'		=> $slug,
      		'aktif'				=> "on",
    		'user_pembuat'	 	=> $this->data['id'],
    		'dibuat_tgl' 		=> date('Y-m-d H:i:s'),
      		);

		$this->kategori_adm->add_parent($data);
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Kategori '.$kat.' ditambah!');
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Kategori ('.$kat.')');
		redirect('trueaccon2194/kategori_dan_parent_kategori');
	}
}