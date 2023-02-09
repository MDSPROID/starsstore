<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Point_customer extends CI_Controller { 

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
		$list_data['get_list'] = $this->customer_adm->get_list_point_customer();
		$data = array_merge($success, $list_data);
		log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Data Customer');
		$this->load->view('manage/header');
		$this->load->view('manage/customer/point_customer/index', $data);
		$this->load->view('manage/footer');
	}

	function detail($id){ // tracking customer
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$h = $this->customer_adm->get_data_before_delete($idx);
		foreach($h as $f){
			$nama = $f->nama_lengkap;
		}

		$jk = $this->customer_adm->total_point($idx);
		foreach($jk as $r){
			$tot = $r->total_point;
		}

		$data['total_point'] = $tot;
		$data['tr'] = $this->customer_adm->tracking_point($idx);
		log_helper('customer', ''.$this->data['username'].' ('.$this->data['id'].') Tracking Customer ('.$nama.')');
		$this->load->view('manage/header');
		$this->load->view('manage/customer/point_customer/detail', $data);
		$this->load->view('manage/footer');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->customer_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
}