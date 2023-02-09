<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_dilihat extends CI_Controller { 
 
	function __construct(){  
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/produk_dilihat_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){ // get data produk in list data 
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list'] = $this->produk_dilihat_adm->get_list_product();
		$list_data['total_produk_view_per_day'] = $this->produk_dilihat_adm->get_counter_slide_perday();
		$list_data['total_produk_view_per_week'] = $this->produk_dilihat_adm->get_counter_slide_perweek();
		$list_data['total_produk_view_per_month'] = $this->produk_dilihat_adm->get_counter_slide_permonth();
		$list_data['total_produk_view_per_year'] = $this->produk_dilihat_adm->get_counter_slide_peryear();
		$list_data['total_produk_view_anak'] = $this->produk_dilihat_adm->get_counter_slide_anak();
		$list_data['total_produk_view_pria'] = $this->produk_dilihat_adm->get_counter_slide_pria();
		$list_data['total_produk_view_wanita'] = $this->produk_dilihat_adm->get_counter_slide_wanita();
		$data = array_merge($success, $list_data);
		$this->load->view('manage/header');
		$this->load->view('manage/produk/produk_dilihat/index', $data);
		$this->load->view('manage/footer');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Produk dilihat');
		
	}

	function detail($art){
		$a = base64_decode($art);
		$b = $this->encrypt->decode($a);
		$data['data'] = $this->produk_dilihat_adm->detail($b);
		$this->load->view('manage/header');
		$this->load->view('manage/produk/produk_dilihat/detail', $data);
		$this->load->view('manage/footer');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Detail ID produk dilihat'.$b.'');
	} 

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->produk_dilihat_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
} 