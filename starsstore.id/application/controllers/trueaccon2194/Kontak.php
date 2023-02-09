<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller { 

	protected $key = 'LAJ391BD01N10DN37403NC62NXKSST28';
	protected $iv =  '01M364BS721X365MXMGW036C5N24931N';
 
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/kontak_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){ // get data produk in list data
		$data['get_list'] = $this->kontak_adm->get_list_kontak();
		log_helper('kontak', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Kontak');
		$this->load->view('manage/header');
		$this->load->view('manage/kontak/index', $data);
		$this->load->view('manage/footer');
	}

	function reply_and_read($id){ // tracking customer
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		// ubah status
		$this->kontak_adm->ubah_status_baca($idx);
		$h = $this->kontak_adm->get_data_before_read($idx);
		foreach($h as $f){
			$no = $f->no_kontak;
		}
		$data['r'] = $this->kontak_adm->detail($idx);
		log_helper('kontak', ''.$this->data['username'].' ('.$this->data['id'].') membaca dan membalas nomor tiket kontak ('.$no.')');
		$this->load->view('manage/header');
		$this->load->view('manage/kontak/detail', $data);
		$this->load->view('manage/footer');
	}

	function edit_data($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);

		$this->data['g'] = $this->kontak_adm->get_data_cs($idx);
		$gdt = $this->kontak_adm->get_data_cs($idx);
		foreach($gdt as $y){
			$gen = $y->gender;
		}

		if ($gen == "pria"){
			$pria = "checked";
			$wanita = "";
		}else if($gen == "wanita"){
			$pria = "";
			$wanita = "checked";
		}
		$this->data['pria'] = $pria;
		$this->data['wanita'] = $wanita;
		$this->load->view('manage/header');
		$this->load->view('manage/customer/data_customer/edit', $this->data);
		$this->load->view('manage/footer');
	}

	function update_customer(){ // proses tambah data produk
		$ins = $this->input->post('ins');
		$idf = base64_decode($ins);
		$idx = $this->encrypt->decode($idf);
		$id_user = $this->data['id'];

		$nama_customer = $this->input->post('nama');

        if($idx == "Hl0d!GJ5623bvhj3"){

			$nama_customer = $this->input->post('nama');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        	if($data['pass1'] != "" && $data['pass2'] != ""){
        		//update beserta password

				$pass = $data['pass2'];
				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
				$iv_size = mcrypt_enc_get_iv_size($cipher);
				// Encrypt
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
					$encrypt_default_rand = mcrypt_generic($cipher, $pass);
					mcrypt_generic_deinit($cipher);
				}

				$this->kontak_adm->update_cs_with_pass($id_user, $data, bin2hex($encrypt_default_rand)); 
				log_helper('kontak', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Customer '.$nama_customer.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Customer '.$nama_customer.' telah diubah!');
				redirect('trueaccon2194/customer');
					
	        }else if($data['pass1'] == "" && $data['pass2'] == "") {
	        	//update tanpa password
	        	$this->kontak_adm->update_cs($id_user, $data); 
				log_helper('kontak', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Customer '.$nama_customer.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Customer '.$nama_customer.' telah diubah!');
				redirect('trueaccon2194/customer');
	        }
			
		}else{
				log_helper('kontak', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah Review Produk ('.$id_customer.')');
				$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
		}
	}

	function hapus($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$h = $this->kontak_adm->get_data_before_delete($idx);
		foreach($h as $f){
			$nama = $f->nama_lengkap;
			$gambar = $f->gb_user;
			$prov = $f->provider_login;
		}
		if($prov != ""){
			unlink('qusour894/img/user/'.$gambar);
		}
		$this->kontak_adm->hapus_customer($idx);
		$this->session->set_flashdata('error', 'Customer '.$nama.' dihapus!');
		redirect('trueaccon2194/customer');
		log_helper('kontak', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Customer ('.$nama.')');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->kontak_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
}