<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller { 
 
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/voucher_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){ // get data produk in list data
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list'] = $this->voucher_adm->get_list_voucher();
		$data = array_merge($success, $list_data);
		$this->load->view('manage/header');
		$this->load->view('manage/sales/voucher/index', $data);
		$this->load->view('manage/footer');
		log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Voucher dan Kupon');
		
	}

	function off($id){ // off status
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$this->voucher_adm->off($idx);
		$this->session->set_flashdata('error', 'Review Produk dinonaktifkan!');
		log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan Voucher ('.$id.')');
		redirect('trueaccon2194/voucher');
	}

	function on($id){ // on status produk
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$this->voucher_adm->on($idx);
		log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan Voucher ('.$id.')');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Review Produk diaktifkan!');
		redirect('trueaccon2194/voucher');
	}

	function tambah_voucher(){ //load semua data yang ditampilkan pada form tambah produk
		$this->load->view('manage/header');
		$this->load->view('manage/sales/voucher/add');
		$this->load->view('manage/footer');
	}

	function proses_tambah_voucher(){ // proses tambah data produk
        if($this->input->post()){
        	$nama_voucher = $this->input->post('nama_voucher');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
 
			$id_user = $this->data['id'];

			$this->voucher_adm->add($id_user, $data); 
			log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Voucher '.$nama_voucher.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Voucher '.$nama_voucher.' ditambahkan!');
			redirect('trueaccon2194/voucher');
        
		}else{
			log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Voucher');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function edit_data($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->data['g'] = $this->voucher_adm->get_data_all($idx);

		$status = $this->voucher_adm->get_data_all($idx);
		if (empty($status['status'])){
		
				$this->data['status1'] = '';
		
		}else if($status['status'] == 'on'){
		
				$this->data['status1'] = 'checked';
		
		}else if($status['status'] == 'ditinjau'){

				$this->data['status1'] = '';	
		}
		
		$this->load->view('manage/header');
		$this->load->view('manage/sales/voucher/edit', $this->data);
		$this->load->view('manage/footer');
	}

	function update_voucher(){ // proses tambah data produk
		$id_voucher = $this->input->post('id');		

        if($this->input->post()){

				$data_filtering = $this->security->xss_clean($this->input->post());
        		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

				$this->voucher_adm->update_voucher($id_voucher,$data); 
				log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit ID Voucher'.$id_voucher.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> ID Voucher '.$id_voucher.' telah diubah!');
				redirect('trueaccon2194/voucher');
			}else{
				log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah Voucher ('.$id_voucher.')');
				$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
			}
	}

	function hapus($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		
		$this->voucher_adm->hapus_voucher($idx);
		$this->session->set_flashdata('error', 'ID Voucher '.$idx.' dihapus!');
		log_helper('voucher', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus ID Voucher ('.$idx.')');
		redirect('trueaccon2194/voucher');
	}

	function cek_expired_voucher(){
		$cek = $this->voucher_adm->cek_exp();
		foreach($cek as $r){
			$id = $r->id;
			$now = date('Y-m-d H:i:s');
			$dateData = $r->valid_until;

			if($now > $dateData){
				$this->voucher_adm->ganti_status_exp($id);
			}else{
				
			}
		}
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->voucher_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
}