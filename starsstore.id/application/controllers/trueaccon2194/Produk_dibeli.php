<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_dibeli extends CI_Controller { 
 
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/produk_dibeli_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	} 

	function index(){ // get data produk in list data
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list'] = $this->produk_dibeli_adm->get_list_product();
		$data = array_merge($success, $list_data);
		$this->load->view('manage/header');
		$this->load->view('manage/produk/produk_dibeli/index', $data);
		$this->load->view('manage/footer');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Produk dibeli');
		
	}

	function detail_produk($art){
		$a = base64_decode($art);
		$b = $this->encrypt->decode($a);
		$data['data'] = $this->produk_dibeli_adm->detail($b);
		$this->load->view('manage/header');
		$this->load->view('manage/produk/produk_dibeli/detail', $data);
		$this->load->view('manage/footer');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Detail ID produk dibeli '.$b.'');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->produk_dibeli_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
}