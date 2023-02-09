<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller { 

	protected $key = 'LAJ391BD01N10DN37403NC62NXKSST28';
	protected $iv =  '01M364BS721X365MXMGW036C5N24931N';
 
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/customer_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){ // get data produk in list data
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list'] = $this->customer_adm->get_list_customer();
		$data = array_merge($success, $list_data);
		log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Data Customer');
		$this->load->view('manage/header');
		$this->load->view('manage/customer/data_customer/index', $data);
		$this->load->view('manage/footer');
	}

	function off($id){ // off status
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$h = $this->customer_adm->get_data_before_delete($idx);
		foreach($h as $f){
			$nama = $f->nama_lengkap;
		}
		$this->customer_adm->off($idx);
		$this->session->set_flashdata('error', 'Customer '.$nama.' dinonaktifkan!');
		log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan Customer ('.$nama.')');
		redirect('trueaccon2194/customer');
	}

	function on($id){ // on status 
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$h = $this->customer_adm->get_data_before_delete($idx);
		foreach($h as $f){
			$nama = $f->nama_lengkap;
		}
		$this->customer_adm->on($idx);
		log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan Customer ('.$nama.')');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Customer '.$nama.' diaktifkan!');
		redirect('trueaccon2194/customer');
	}

	function tracking($id){ // tracking customer
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$h = $this->customer_adm->get_data_before_delete($idx);
		foreach($h as $f){
			$nama = $f->nama_lengkap;
		}
		$data_baca = array(
			'baca' => 'sudah',
		);
		$this->customer_adm->ubah_status_baca($idx, $data_baca);
		$data['tr'] = $this->customer_adm->tracking($idx);
		log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Tracking Customer ('.$nama.')');
		$this->load->view('manage/header');
		$this->load->view('manage/customer/data_customer/detail', $data);
		$this->load->view('manage/footer');
	}

	function tambah_customer(){ //load semua data yang ditampilkan pada form tambah produk
		//$data['customer'] = $this->customer_adm->get_customer();
		$this->load->view('manage/header');
		$this->load->view('manage/customer/data_customer/add');
		$this->load->view('manage/footer');
	}

	function proses_tambah_customer(){ // proses tambah data produk
		$ins = $this->input->post('ins');
		$idf = base64_decode($ins);
		$idx = $this->encrypt->decode($idf);
		$id_user = $this->data['id'];

        if($idx == "Hl0d!GJ5623bvhj3"){
        	$nama_customer = $this->input->post('nama');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

			//panggil protected function
			$pass = $data['pass2'];
			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
			$iv_size = mcrypt_enc_get_iv_size($cipher);
			// Encrypt
			if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
			{
				$encrypt_default_rand = mcrypt_generic($cipher, $pass);
				mcrypt_generic_deinit($cipher);
			}

			$this->customer_adm->add($id_user, $data, bin2hex($encrypt_default_rand)); 
			log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Customer '.$nama_customer.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Customer '.$nama_customer.' ditambahkan, login ke front end untuk aktifasi!');
			redirect('trueaccon2194/customer');
        
		}else{
			$this->load->model('users');
			$aktifitas = "memecahkan kode enkripsi untuk akses pendaftaran customer pada halaman admin";
			$this->users->savingHack($aktifitas);
			log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Customer');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function edit_data($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);

		$this->data['g'] = $this->customer_adm->get_data_cs($idx);
		$gdt = $this->customer_adm->get_data_cs($idx);
		foreach($gdt as $y){
			$gen = $y->gender;
		}

		if ($gen == "pria"){
			$pria = "checked";
			$wanita = "";
		}else if($gen == "wanita"){
			$pria = "";
			$wanita = "checked";
		}else{
			$pria = "";
			$wanita = "";
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

				$this->customer_adm->update_cs_with_pass($id_user, $data, bin2hex($encrypt_default_rand)); 
				log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Customer '.$nama_customer.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Customer '.$nama_customer.' telah diubah!');
				redirect('trueaccon2194/customer');
					
	        }else if($data['pass1'] == "" && $data['pass2'] == "") {
	        	//update tanpa password
	        	$this->customer_adm->update_cs($id_user, $data); 
				log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Customer '.$nama_customer.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Customer '.$nama_customer.' telah diubah!');
				redirect('trueaccon2194/customer');
	        }
			
		}else{
				log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah Review Produk ('.$id_customer.')');
				$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
		}
	}

	function hapus($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$h = $this->customer_adm->get_data_before_delete($idx);
		foreach($h as $f){
			$nama = $f->nama_lengkap;
			$gambar = $f->gb_user;
			$prov = $f->provider_login;
		}
		if($prov != ""){
			unlink('qusour894/img/user/'.$gambar);
		}
		$this->customer_adm->hapus_customer($idx);
		$this->session->set_flashdata('error', 'Customer '.$nama.' dihapus!');
		redirect('trueaccon2194/customer');
		log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Customer ('.$nama.')');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->customer_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
}