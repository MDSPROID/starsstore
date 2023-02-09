<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori_divisi extends CI_Controller { 

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/kategori_divisi_adm');
		$this->data = array();
		$this->data['id'] = $this->session->userdata('id'); // user session
		$this->data['username'] = $this->session->userdata('username');
		$this->data['data_kategori'] = $this->kategori_divisi_adm->get_all_category(); // load all to table
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	} 

	function index(){

		$this->load->view('manage/header');
		$this->load->view('manage/kategori/kategori_divisi/index', $this->data);
		$this->load->view('manage/footer');
		
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Kategori Divisi');
		
	}

	function kategori_dihapuskan(){ // hapus kategori yang dipilih
		$id = $this->input->get('id');
		$idx = base64_decode($id);
		$idf = $this->encrypt->decode($idx);
		$this->kategori_divisi_adm->kategori_telah_dihapus($idf);
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

	function proses_tambah_kat_divisi(){ // tambah kategori
		$kat_filter = $this->security->xss_clean($this->input->post('kode_kategori'));
		$kat = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$kat_filter);
		$divisi1 = $this->security->xss_clean($this->input->post('nm_kategori'));
		$divisi = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$divisi1);

		$data = array(
      		'kode_kategori'			=> $kat,
      		'nama_kategori_divisi'	=> $divisi,
    		'aktif'				=> "on",
    		'user_pembuat'	 	=> $this->data['id'],
    		'dibuat_tgl' 		=> date('Y-m-d H:i:s'),
      		);

		$this->kategori_divisi_adm->add($data);
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Kategori '.$kat.' dari divisi '.$divisi.' telah ditambah!');
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Kategori ('.$kat.') untuk divisi '.$divisi.'');
		redirect('trueaccon2194/kategori_divisi');
	}

	function edit_kategori($id){ // edit dan simpan kategori yang diedit
		$idx = base64_decode($id);
		$idf = $this->encrypt->decode($idx);

		$update = $this->kategori_divisi_adm->get_categorie($idf);

		if ($update['aktif'] == 'on'){
			$this->data['aktif1'] = 'checked';
		}
		else{
			$this->data['aktif1'] = '';
		}

		$this->data['updatedata'] = $update;

		$this->load->view('manage/header');
		$this->load->view('manage/kategori/kategori_divisi/edit',$this->data);
		$this->load->view('manage/footer');
	}

	function update_kategori(){
		$id_kategori = $this->input->post('id_kategori');
		$idx = base64_decode($id_kategori);
		$idf = $this->encrypt->decode($idx);

		$kat_filter = $this->security->xss_clean($this->input->post('kat'));
		$kat = str_replace("/(<\/?)(p)([^>]*>)", "",$kat_filter);
		$slug_filter = $this->security->xss_clean($this->input->post('divisi'));
		$slug = str_replace("/(<\/?)(p)([^>]*>)", "",$slug_filter);
		$st_filter = $this->security->xss_clean($this->input->post('status'));
		$st = str_replace("/(<\/?)(p)([^>]*>)", "",$st_filter);

		$data = array(
      		'kode_kategori'			=> $kat,
      		'nama_kategori_divisi' 	=> $slug_filter,
      		'aktif'				=> $st,
    		'user_pengubah' 	=> $this->data['id'],
    		'diubah_tgl' 		=> date('Y-m-d H:i:s'),
      		);

			$this->kategori_divisi_adm->update_kategorix($data, $idf);
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Kategori '.$kat.' telah diubah!');
			log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') edit kategori '.$kat.'');
			redirect('trueaccon2194/kategori_divisi');
	}
}