<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller { 
 
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		//$this->load->model('sec47logaccess/voucher_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){ // get data produk in list data
		$this->load->view('manage/header');
		$this->load->view('manage/galeri/index');
		$this->load->view('manage/footer');
		log_helper('galeri', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman galeri');
		
	}
	
}