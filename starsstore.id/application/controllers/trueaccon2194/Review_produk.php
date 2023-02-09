<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_produk extends CI_Controller { 
 
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/review_produk_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		} 
	}
 
	function index(){ // get data produk in list data
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list_review'] = $this->review_produk_adm->get_list_review();
		$list_data['get_list_qna'] = $this->review_produk_adm->get_list_qna();
		$data = array_merge($success, $list_data);
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Review Produk');
		$this->load->view('manage/header');
		$this->load->view('manage/produk/review/index', $data);
		$this->load->view('manage/footer');
	}

	function off($id){ // off status
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$this->review_produk_adm->off($idx);
		$this->session->set_flashdata('error', 'Review Produk dinonaktifkan!');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan Review Produk ('.$id.')');
		redirect('trueaccon2194/review_produk');
	}

	function on($id){ // on status produk
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$this->review_produk_adm->on($idx);
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan Review Produk ('.$id.')');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Review Produk diaktifkan!');
		redirect('trueaccon2194/review_produk');
	}

	function setujui($id){ // setujui status 
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$this->review_produk_adm->setujui($idx);
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menyetujui ID Review Produk ('.$id.')');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Produk diaktifkan!');
		redirect('trueaccon2194/review_produk');
	}

	function tambah_review_produk(){ //load semua data yang ditampilkan pada form tambah produk
		$data['produk'] = $this->review_produk_adm->get_produk();
		$this->load->view('manage/header');
		$this->load->view('manage/produk/review/add', $data);
		$this->load->view('manage/footer');
	}

	function balas_qna(){ // proses tambah data produk
        if($this->input->post()){
        	$nm_produk =  $this->security->xss_clean($this->input->post('nama_produk'));
        	$idf = base64_decode($nm_produk);
			$idx = $this->encrypt->decode($idf);

			$id_produk =  $this->security->xss_clean($this->input->post('idp'));
        	$idg = base64_decode($id_produk);
			$idh = $this->encrypt->decode($idg);

			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

			$this->review_produk_adm->balas($data, $idh); 
			log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Membalas pertanyaa produk '.$idx.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Komentar telah berhasil dibalas!');
			redirect('trueaccon2194/review_produk');
        
		}else{
			log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Review produk');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function proses_tambah_review_produk(){ // proses tambah data produk
        if($this->input->post()){
        	$nama_produk = $this->input->post('produk');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
 
			$id_user = $this->data['id'];

			$this->review_produk_adm->add($id_user, $data); 
			log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Review produk '.$nama_produk.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Review Produk '.$nama_produk.' ditambahkan!');
			redirect('trueaccon2194/review_produk');
        
		}else{
			log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Review produk');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function edit_data($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);

		$this->data['produk'] = $this->review_produk_adm->get_produk();
		$this->data['g'] = $this->review_produk_adm->get_data_all($idx);

		$status = $this->review_produk_adm->get_data_all($idx);
		if (empty($status['status'])){
		
				$this->data['status1'] = '';
		
		}else if($status['status'] == 'on'){
		
				$this->data['status1'] = 'checked';
		
		}else if($status['status'] == 'ditinjau'){

				$this->data['status1'] = '';	
		}
		
		$this->data['status_post'] = $status;
		$this->load->view('manage/header');
		$this->load->view('manage/produk/review/edit', $this->data);
		$this->load->view('manage/footer');
	}

	function edit_qna($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);

		$this->data['produk'] = $this->review_produk_adm->get_produk();
		$this->data['g'] = $this->review_produk_adm->get_data_qna($idx);
		
		$this->load->view('manage/header');
		$this->load->view('manage/produk/review/edit_qna', $this->data);
		$this->load->view('manage/footer');
	}

	function update_qna_produk(){ // proses tambah data produk
		$id_produk = $this->input->post('produk');
		$idx = $this->input->post('id_qna');

        if($this->input->post()){

				$data_filtering = $this->security->xss_clean($this->input->post());
        		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

				$this->review_produk_adm->update_qna($idx,$data); 
				log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Q&A Produk '.$id_produk.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Q&A Produk '.$id_produk.' telah diubah!');
				redirect('trueaccon2194/review_produk');
			}else{
				log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah Q&A Produk ('.$id_produk.')');
				$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
			}
	}

	function update_review_produk(){ // proses tambah data produk
		$id_produk = $this->input->post('produk');
		$idx = $this->input->post('id_review');

        if($this->input->post()){

				$data_filtering = $this->security->xss_clean($this->input->post());
        		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

				$this->review_produk_adm->update_review($idx,$data); 
				log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Review Produk ID '.$id_produk.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Review Produk '.$id_produk.' telah diubah!');
				redirect('trueaccon2194/review_produk');
			}else{
				log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah Review Produk ('.$id_produk.')');
				$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
			}
	}

	function hapus_qna($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->review_produk_adm->hapus_qna($idx);
		$this->session->set_flashdata('error', 'ID Q&A Produk '.$idx.' dihapus!');
		redirect('trueaccon2194/review_produk');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Q&A Produk ID ('.$idx.')');
	}

	function hapus($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->review_produk_adm->hapus_review($idx);
		$this->session->set_flashdata('error', 'ID Review Produk '.$idx.' dihapus!');
		redirect('trueaccon2194/review_produk');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Review Produk ID ('.$idx.')');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->review_produk_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
}